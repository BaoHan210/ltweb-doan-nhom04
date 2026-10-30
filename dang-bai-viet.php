<?php
/**
 * Tệp: dang-bai-viet.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - Hiển thị biểu mẫu đăng bài viết
 * - Kiểm tra phiên đăng nhập
 * - Lấy thông tin người dùng từ session
 * - Giữ nguyên xử lý JavaScript của Bài thực hành 5
 *
 * Bài thực hành 6:
 * - Không sử dụng data/mon-an.json
 * - Không phụ thuộc inc/bao-ve.php
 * - Không viết SQL trực tiếp trong trang
 */

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/xac-thuc.php';

// Xác thực lại từ MySQL, không tin thông tin vai trò trong Session.
$user = yeuCauDangNhap();

$emailNguoiDung = (string) ($user['email'] ?? '');

$tenMacDinh = $emailNguoiDung !== ''
    ? explode('@', $emailNguoiDung)[0]
    : 'Người dùng';

$tenHienThi = (string) (
    $user['ho_ten']
    ?? $user['hoTen']
    ?? $tenMacDinh
);

$avatarUser = (string) (
    $user['avatar']
    ?? 'images/icons/avt-default.svg'
);

// Chỉ đưa thông tin cần thiết sang JavaScript
$thongTinNguoiDungJS = [
    'id' => (int) $user['id'],
    'ho_ten' => $tenHienThi,
    'hoTen' => $tenHienThi,
    'email' => $emailNguoiDung,
    'vai_tro' => (string) ($user['vai_tro'] ?? '')
];

// 3. THÔNG SỐ TRANG
$tieuDe = 'Đăng bài viết';
$trang = 'dang-bai-viet';
$customJS = 'js/trang-dang-bai-viet.js';

// 4. NHÚNG HEADER
require __DIR__ . '/inc/header.php';
?>

<!-- ĐỒNG BỘ THÔNG TIN NGƯỜI DÙNG SANG JAVASCRIPT -->
<script>
    localStorage.setItem(
        'nguoiDungHienTai',
        JSON.stringify(
            <?= json_encode(
                $thongTinNguoiDungJS,
                JSON_UNESCAPED_UNICODE
                | JSON_HEX_TAG
                | JSON_HEX_AMP
                | JSON_HEX_APOS
                | JSON_HEX_QUOT
            ) ?>
        )
    );
</script>

<main class="dang-bai-viet-trang">

    <h1 style="display:none;">
        Đăng bài viết
    </h1>

    <!-- THÔNG BÁO KHI TẮT JAVASCRIPT -->
    <noscript>
        <p class="thong-bao-noscript">
            JavaScript đang được tắt.
            Chức năng đăng và chỉnh sửa bài viết
            cần JavaScript để lưu dữ liệu bài viết
            trên trình duyệt.
        </p>
    </noscript>

    <div class="khung-dang-bai-viet">

        <div class="the-dang-bai-viet">

            <!-- THÔNG TIN NGƯỜI ĐĂNG -->
            <header class="nguoi-dang-bai">

                <div class="anh-dai-dien-dang-bai">

                    <img
                        src="<?= e($avatarUser) ?>"
                        alt="Avatar"
                        onerror="this.onerror=null; this.src='images/icons/avt-default.svg';"
                    >

                </div>

                <div class="thong-tin-nguoi-dang">

                    <strong id="ten-nguoi-dung">
                        <?= e($tenHienThi) ?>
                    </strong>

                    <span>
                        Đang chia sẻ công thức
                    </span>

                </div>

            </header>

            <!-- BIỂU MẪU ĐĂNG BÀI -->
            <form
                class="form-dang-bai-viet"
                action="#"
                method="post"
                enctype="multipart/form-data"
                novalidate
            >

                <!-- MÔ TẢ BÀI VIẾT -->
                <div class="khu-vuc-caption">

                    <label for="mo-ta-bai-viet">
                        Bạn đang muốn chia sẻ món gì? *
                    </label>

                    <textarea
                        id="mo-ta-bai-viet"
                        name="mo_ta_bai_viet"
                        rows="4"
                        required
                        placeholder="Chia sẻ câu chuyện hoặc kinh nghiệm nấu món ăn của bạn..."
                    ></textarea>

                </div>

                <!-- HÌNH ẢNH MÓN ĂN -->
                <section class="khu-vuc-hinh-anh-dang-bai">

                    <div class="tieu-de-khu-vuc-dang-bai">

                        <h2>
                            Hình ảnh món ăn
                        </h2>

                        <span>
                            Thêm hình ảnh cho món hoặc nhiều ảnh từ thiết bị
                        </span>

                    </div>

                    <label
                        for="hinh-anh"
                        class="o-them-hinh-anh"
                    >

                        <span class="bieu-tuong-them-anh">
                            +
                        </span>

                        <strong>
                            Thêm hình ảnh
                        </strong>

                        <small>
                            Chọn ảnh từ thiết bị
                        </small>

                    </label>

                    <input
                        type="file"
                        id="hinh-anh"
                        name="hinh_anh"
                        accept="image/*"
                        multiple
                        hidden
                    >

                    <div
                        class="xem-truoc-hinh-anh"
                        aria-live="polite"
                    ></div>

                </section>

                <!-- THÔNG TIN MÓN ĂN -->
                <section class="khu-vuc-thong-tin-mon-an">

                    <h2>
                        Thông tin món ăn
                    </h2>

                    <!-- TÊN MÓN -->
                    <div class="nhom-truong">

                        <label for="ten-mon">
                            Tên món ăn *
                        </label>

                        <input
                            type="text"
                            id="ten-mon"
                            name="ten_mon"
                            required
                            minlength="2"
                            placeholder="Ví dụ: Cơm tấm sườn nướng"
                        >

                    </div>

                    <!-- DANH MỤC -->
                    <div class="nhom-truong">

                        <label for="danh-muc">
                            Danh mục *
                        </label>

                        <select
                            id="danh-muc"
                            name="danh_muc"
                            required
                        >

                            <option value="">
                                Chọn danh mục
                            </option>

                            <option value="mon-chinh">
                                Món chính
                            </option>

                            <option value="mon-canh">
                                Món canh
                            </option>

                            <option value="mon-xao">
                                Món xào
                            </option>

                            <option value="mon-an-vat">
                                Món ăn vặt
                            </option>

                            <option value="do-uong">
                                Đồ uống
                            </option>

                            <option value="mon-an-nhanh">
                                Món ăn nhanh
                            </option>

                            <option value="mon-trang-mieng">
                                Món tráng miệng
                            </option>

                            <option value="mon-chay">
                                Món chay
                            </option>

                        </select>

                    </div>

                    <!-- THỜI GIAN, KHẨU PHẦN, NGÂN SÁCH -->
                    <div
                        class="thong-tin-mon-an-grid"
                        style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;"
                    >

                        <!-- THỜI GIAN NẤU -->
                        <div class="nhom-truong">

                            <label for="thoi-gian-nau">
                                Thời gian chuẩn bị *
                            </label>

                            <input
                                type="number"
                                id="thoi-gian-nau"
                                name="thoi_gian_nau"
                                min="1"
                                max="300"
                                required
                                placeholder="Ví dụ: 30 phút"
                            >

                        </div>

                        <!-- KHẨU PHẦN -->
                        <div class="nhom-truong">

                            <label for="so-nguoi-an">
                                Khẩu phần *
                            </label>

                            <input
                                type="number"
                                id="so-nguoi-an"
                                name="so_nguoi_an"
                                min="1"
                                max="20"
                                required
                                placeholder="Ví dụ: 2 người"
                            >

                        </div>

                        <!-- NGÂN SÁCH -->
                        <div class="nhom-truong">

                            <label for="ngan-sach">
                                Ngân sách *
                            </label>

                            <input
                                type="number"
                                id="ngan-sach"
                                name="ngan_sach"
                                min="0"
                                required
                                placeholder="Ví dụ: 50.000đ"
                            >

                        </div>

                    </div>

                </section>

                <!-- NGUYÊN LIỆU -->
                <section class="khu-vuc-nguyen-lieu-dang-bai">

                    <h2>
                        Nguyên liệu
                    </h2>

                    <div class="nhom-truong">

                        <label
                            for="nguyen-lieu"
                            style="display:none;"
                        >
                            Danh sách nguyên liệu
                        </label>

                        <textarea
                            id="nguyen-lieu"
                            name="nguyen_lieu"
                            rows="5"
                            required
                            placeholder="Nhập danh sách nguyên liệu..."
                        ></textarea>

                    </div>

                </section>

                <!-- CÁCH CHẾ BIẾN -->
                <section class="khu-vuc-cach-lam-dang-bai">

                    <h2>
                        Cách chế biến
                    </h2>

                    <div class="nhom-truong">

                        <label
                            for="cach-lam"
                            style="display:none;"
                        >
                            Các bước thực hiện
                        </label>

                        <textarea
                            id="cach-lam"
                            name="cach_lam"
                            rows="7"
                            required
                            placeholder="Mô tả các bước chế biến món ăn..."
                        ></textarea>

                    </div>

                </section>

                <!-- NÚT ĐĂNG BÀI -->
                <footer class="khu-vuc-dang-bai">

                    <button
                        type="submit"
                        class="nut nut-dang-bai"
                    >
                        ✍ Đăng bài viết
                    </button>

                </footer>

            </form>

        </div>

    </div>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
