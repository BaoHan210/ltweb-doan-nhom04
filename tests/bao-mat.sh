#!/usr/bin/env bash
# Cook with me - Nhóm 04
# Bộ kiểm thử bảo mật Bảng 3
# Không lưu PHPSESSID, CSRF token hoặc mật khẩu trong tệp.

set -u

BASE="${BASE:-http://localhost/ltweb-doan-nhom04-main}"
COOKIE_FILE="$(mktemp)"
TMP_BODY="$(mktemp)"
TMP_HEADER="$(mktemp)"

cleanup() {
    rm -f "$COOKIE_FILE" "$TMP_BODY" "$TMP_HEADER"
}
trap cleanup EXIT

dem=0

kiem_tra() {
    local ten="$1"
    local mong_doi="$2"
    local thuc_te="$3"

    dem=$((dem + 1))
    printf '\n[%02d] %s\n' "$dem" "$ten"
    printf 'Mong doi: %s\n' "$mong_doi"
    printf 'Thuc te : %s\n' "$thuc_te"

    if [[ "$thuc_te" == "$mong_doi" ]]; then
        echo "KET QUA: DAT"
    else
        echo "KET QUA: CAN KIEM TRA"
    fi
}

lay_http() {
    curl -sS -b "$COOKIE_FILE" -c "$COOKIE_FILE" \
        -D "$TMP_HEADER" -o "$TMP_BODY" \
        -w '%{http_code}' "$@"
}

echo "=========================================="
echo " COOK WITH ME - KIEM THU BAO MAT"
echo "=========================================="
echo "BASE: $BASE"

# --------------------------------------------------
# 1. SECURITY HEADERS VA COOKIE
# --------------------------------------------------
echo
echo "===== 1. SECURITY HEADERS ====="

HTTP=$(curl -sS -I "$BASE/" -D "$TMP_HEADER" -o /dev/null \
    -w '%{http_code}')

kiem_tra "Trang chu" "200" "$HTTP"

for HEADER in \
    "Content-Security-Policy" \
    "X-Content-Type-Options" \
    "Referrer-Policy"
do
    if grep -qi "^${HEADER}:" "$TMP_HEADER"; then
        echo "DAT: $HEADER"
    else
        echo "CAN KIEM TRA: $HEADER"
    fi
done

if grep -qi '^X-Powered-By:' "$TMP_HEADER"; then
    echo "CAN KIEM TRA: X-Powered-By van xuat hien"
else
    echo "DAT: Khong co X-Powered-By"
fi

if grep -qi '^Set-Cookie: PHPSESSID=.*HttpOnly' "$TMP_HEADER" \
    && grep -qi '^Set-Cookie: PHPSESSID=.*SameSite=Lax' "$TMP_HEADER"; then
    echo "DAT: PHPSESSID co HttpOnly va SameSite=Lax"
else
    echo "CAN KIEM TRA: Cookie PHPSESSID"
fi

# --------------------------------------------------
# 2. CSRF - THIEU TOKEN
# --------------------------------------------------
echo
echo "===== 2. CSRF THIEU TOKEN ====="

HTTP=$(lay_http -X POST "$BASE/dang-nhap.php" \
    --data-urlencode "email=kiemthu@example.com" \
    --data-urlencode "mat_khau=MatKhauSai")

kiem_tra "POST dang nhap khong CSRF" "403" "$HTTP"

# --------------------------------------------------
# 3. API POST KHONG CSRF
# --------------------------------------------------
echo
echo "===== 3. API POST KHONG CSRF ====="

HTTP=$(lay_http \
    -H "Content-Type: application/json" \
    -X POST "$BASE/api/danh-sach-di-cho.php" \
    --data '{"hanh_dong":"khong_hop_le"}')

kiem_tra "API POST khong CSRF" "403" "$HTTP"

# --------------------------------------------------
# 4. GET DOI VOI CHUC NANG CHI CHO POST
# --------------------------------------------------
echo
echo "===== 4. HTTP METHOD ====="

HTTP=$(lay_http "$BASE/dang-xuat.php")
kiem_tra "GET dang xuat" "405" "$HTTP"

HTTP=$(lay_http "$BASE/xoa-mon-an.php?id=cao-lau")
kiem_tra "GET xoa mon an" "405" "$HTTP"

# --------------------------------------------------
# 5. API CHI DOC
# --------------------------------------------------
echo
echo "===== 5. API MON AN ====="

HTTP=$(lay_http "$BASE/api/mon-an.php?id[]=abc")
kiem_tra "API mon an voi id dang mang" "400" "$HTTP"

# --------------------------------------------------
# 6. CAC THAM SO MANG
# --------------------------------------------------
echo
echo "===== 6. THAM SO MANG ====="

HTTP=$(lay_http "$BASE/danh-sach.php?q[]=ao")
kiem_tra "Tim kiem q dang mang" "200" "$HTTP"

HTTP=$(lay_http "$BASE/chi-tiet.php?id[]=1")
kiem_tra "Chi tiet id dang mang" "404" "$HTTP"

HTTP=$(lay_http "$BASE/danh-sach.php?sx[]=x")
kiem_tra "Sap xep dang mang" "200" "$HTTP"

# --------------------------------------------------
# 7. CAC DUONG DAN NHAY CAM
# --------------------------------------------------
echo
echo "===== 7. DUONG DAN NHAY CAM ====="

for PATH_TEST in \
    ".env" \
    ".env.example" \
    ".git/config" \
    "inc/db.php" \
    "database/schema.sql" \
    "composer.json" \
    "vendor/autoload.php" \
    "logs/bao-mat.log" \
    "uploads/"
do
    HTTP=$(curl -sS -o /dev/null -w '%{http_code}' \
        "$BASE/$PATH_TEST")

    printf '%-30s HTTP %s\n' "$PATH_TEST" "$HTTP"
done

HTTP=$(curl -sS -o /dev/null -w '%{http_code}' \
    "$BASE/css/01-bien.css")
kiem_tra "Tai tep CSS cong khai" "200" "$HTTP"

# --------------------------------------------------
# 8. SESSION FIXATION - ID GIA
# --------------------------------------------------
echo
echo "===== 8. SESSION FIXATION ====="

TEST_ID="FIXATION_TEST_20261109_ABCDEF123456"

HTTP=$(curl -sS -D "$TMP_HEADER" -o /dev/null \
    -w '%{http_code}' \
    -H "Cookie: PHPSESSID=$TEST_ID" "$BASE/")

kiem_tra "Truy cap voi session ID tu tao" "200" "$HTTP"

if grep -qi '^Set-Cookie: PHPSESSID=' "$TMP_HEADER" \
    && ! grep -qi "^Set-Cookie: PHPSESSID=$TEST_ID" "$TMP_HEADER"; then
    echo "DAT: Server cap session ID moi"
else
    echo "CAN KIEM TRA: Session strict mode"
fi

# --------------------------------------------------
# 9. API KHONG CHO PUT
# --------------------------------------------------
echo
echo "===== 9. API METHOD ====="

HTTP=$(lay_http -X PUT "$BASE/api/mon-an.php")
kiem_tra "PUT API mon an" "405" "$HTTP"

# --------------------------------------------------
# 10. KIEM TRA LOG KHONG CHUA MAT KHAU
# --------------------------------------------------
echo
echo "===== 10. LOG BAO MAT ====="

if [ -f logs/bao-mat.log ]; then
    if grep -qiE '"(mat_khau|password)"[[:space:]]*:' logs/bao-mat.log; then
        echo "CAN KIEM TRA: Log co truong mat khau"
    else
        echo "DAT: Khong tim thay truong mat khau trong log"
    fi
else
    echo "CHUA CO logs/bao-mat.log"
fi

echo
echo "=========================================="
echo " KET THUC KIEM THU TU DONG"
echo "=========================================="
echo "Luu y: Ket qua can doi chieu voi bang kiem thu."
echo "Cac phep thu can dang nhap, CSRF hop le,"
echo "thao tac CSDL va kiem tra giao dien phai lam rieng."
