<?php
/** Kiểm tra chung dữ liệu món ăn cho trang Thêm và Sửa. */
declare(strict_types=1);

function kiemTraDuLieuMonAn(array $duLieu, array $dsDanhMuc): array
{
    $loi = [];
    $ten = trim((string) ($duLieu['ten'] ?? ''));
    $slug = trim((string) ($duLieu['slug'] ?? ''));
    $dmIds = array_map('intval', array_column($dsDanhMuc, 'id'));

    if ($ten === '' || mb_strlen($ten, 'UTF-8') > 200) {
        $loi['ten'] = 'Tên món ăn phải từ 1 đến 200 ký tự.';
    }
    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) || strlen($slug) > 190) {
        $loi['slug'] = 'Slug chỉ gồm chữ thường không dấu, số và dấu gạch ngang.';
    }
    $dm = filter_var($duLieu['danh_muc_id'] ?? '', FILTER_VALIDATE_INT);
    if ($dm === false || !in_array($dm, $dmIds, true)) {
        $loi['danh_muc_id'] = 'Hãy chọn danh mục có trong cơ sở dữ liệu.';
    }
    foreach (['thoi_gian' => 1, 'khau_phan' => 1, 'ngan_sach' => 0] as $cot => $min) {
        $so = filter_var($duLieu[$cot] ?? '', FILTER_VALIDATE_INT, [
            'options' => ['min_range' => $min, 'max_range' => 100000000]
        ]);
        if ($so === false) {
            $loi[$cot] = 'Hãy nhập số nguyên hợp lệ (từ ' . $min . ').';
        }
    }
    if (!in_array((string) ($duLieu['do_kho'] ?? ''), ['Dễ', 'Trung bình', 'Khó'], true)) {
        $loi['do_kho'] = 'Độ khó không hợp lệ.';
    }
    if (mb_strlen((string) ($duLieu['mo_ta'] ?? ''), 'UTF-8') > 10000) {
        $loi['mo_ta'] = 'Mô tả tối đa 10.000 ký tự.';
    }
    if (strlen((string) ($duLieu['video'] ?? '')) > 255) {
        $loi['video'] = 'Đường dẫn video quá dài.';
    }
    return $loi;
}

/** Trả về ['loi' => string|null, 'duoi' => string|null]. */
function kiemTraAnhMonAn(?array $anh, bool $batBuoc): array
{
    $khongChon = $anh === null || ($anh['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE;
    if ($khongChon) {
        return ['loi' => $batBuoc ? 'Vui lòng chọn ảnh đại diện.' : null, 'duoi' => null];
    }
    if (($anh['error'] ?? 0) !== UPLOAD_ERR_OK
        || !is_uploaded_file((string) ($anh['tmp_name'] ?? ''))
        || (int) ($anh['size'] ?? 0) <= 0
        || (int) ($anh['size'] ?? 0) > 3 * 1024 * 1024) {
        return ['loi' => 'Ảnh không hợp lệ hoặc vượt quá 3 MB.', 'duoi' => null];
    }
    $mimeChoPhep = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file((string) $anh['tmp_name']);
    $duoi = $mimeChoPhep[$mime] ?? null;
    if ($duoi === null || @getimagesize((string) $anh['tmp_name']) === false) {
        return ['loi' => 'Chỉ nhận ảnh JPG, PNG hoặc WebP hợp lệ.', 'duoi' => null];
    }
    return ['loi' => null, 'duoi' => $duoi];
}
