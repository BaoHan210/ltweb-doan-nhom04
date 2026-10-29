<?php
/**
 * Tệp: index.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - Hiển thị trang chủ
 * - Hiển thị 3 món ăn mới nhất từ MySQL
 * - Hiển thị món ăn đã xem gần đây
 * - Hiển thị gợi ý người theo dõi
 * - Hiển thị bảng tin
 *
 * Bài thực hành 6 - Chức năng 1:
 * - Sử dụng PDO và KhoMonAn
 * - Không truy vấn SQL trong vòng lặp
 * - Vẫn hiển thị dữ liệu khi tắt JavaScript
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/db.php';

use App\Data\KhoMonAn;

// Đường dẫn gốc dự án
$goc = URL_GOC;

// Khởi tạo lớp truy cập dữ liệu MySQL
$kho = new KhoMonAn(db());

// ======================================
// 1. LẤY 3 MÓN ĂN MỚI NHẤT
// ======================================

$moiVe = $kho->layMoiNhat(3);

// ======================================
// 2. LẤY DANH SÁCH MÓN ĐÃ XEM
// ======================================

$daXemIds = [];

if (!empty($_COOKIE['da_xem'])) {

    $duLieuCookie = json_decode(
        (string) $_COOKIE['da_xem'],
        true
    );

    if (is_array($duLieuCookie)) {

        foreach (array_slice($duLieuCookie, 0, 20) as $id) {

            if (!is_string($id)) {
                continue;
            }

            $id = trim($id);

            if ($id !== '' && strlen($id) <= 255) {
                $daXemIds[] = $id;
            }
        }
    }
}

// Loại bỏ ID trùng, giữ tối đa 5 món
$daXemIds = array_slice(
    array_values(array_unique($daXemIds)),
    0,
    5
);

// Truy vấn nhiều món cùng lúc bằng WHERE IN.
// Không thực hiện SQL trong foreach.
$danhSachDaXem = $kho->timNhieuTheoSlug($daXemIds);

// ======================================
// 3. THÔNG SỐ TRANG
// ======================================

$tieuDe = 'Trang chủ';
$trang = 'index';
$customJS = 'js/trang-chu.js';

// Header của website
require __DIR__ . '/inc/header.php';
?>

<main class="noi-dung-trang">

    <h1 class="tieu-de-trang">
        Trang chủ Cook with me
    </h1>

    <!-- ==================================
         HERO - GIỚI THIỆU WEBSITE
    =================================== -->

    <section class="hero">

        <div class="hero-noi-dung">

            <p class="hero-nhan">
                COOK WITH ME
            </p>

            <h2>
                Khám phá món ngon mỗi ngày
            </h2>

            <p>
                Cùng Cook with me tìm kiếm, học hỏi và
                chia sẻ những công thức nấu ăn tuyệt vời!
            </p>

            <a class="nut nut-chinh" href="danh-sach.php">
                Khám phá món ăn
            </a>

        </div>

    </section>

    <!-- ==================================
         BA THẺ CHỨC NĂNG
    =================================== -->

    <section class="the-gioi-thieu">

        <h2>
            Khám phá Cook with me
        </h2>

        <!-- Đăng bài -->
        <article class="the-gioi-thieu-item icon-dang-bai">

            <h3>
                Đăng bài viết
            </h3>

            <p>
                Chia sẻ công thức nấu ăn, hình ảnh món ăn
                và kinh nghiệm với cộng đồng Cook with me.
            </p>

            <a class="nut" href="dang-bai-viet.php">
                Đăng bài
            </a>

        </article>

        <!-- Khám phá -->
        <article class="the-gioi-thieu-item icon-kham-pha-card">

            <h3>
                Khám phá món ăn
            </h3>

            <p>
                Tìm kiếm và khám phá nhiều món ăn
                theo danh mục và nhu cầu sử dụng.
            </p>

            <a class="nut" href="danh-sach.php">
                Khám phá
            </a>

        </article>

        <!-- Gợi ý -->
        <article class="the-gioi-thieu-item icon-goi-y-card">

            <h3>
                Gợi ý món ăn
            </h3>

            <p>
                Nhận gợi ý món ăn dựa trên nguyên liệu,
                thời gian nấu và nhu cầu của người dùng.
            </p>

            <a class="nut" href="goi-y-mon-an.php">
                Xem gợi ý
            </a>

        </article>

    </section>

    <!-- ==================================
         KHU VỰC TRANG CHỦ
    =================================== -->

    <div class="khu-vuc-trang-chu">

        <!-- ==================================
             GỢI Ý MÓN ĂN HÔM NAY
        =================================== -->

        <section
            class="du-lieu-api"
            aria-labelledby="tieu-de-du-lieu-api"
        >

            <div class="tieu-de-khu-vuc">

                <h2 id="tieu-de-du-lieu-api">
                    Gợi ý món ăn hôm nay
                </h2>

            </div>

            <div
                class="noi-dung-api"
                id="noi-dung-api"
            >

                <p class="api-trang-thai">
                    Khám phá các công thức nấu ăn hấp dẫn
                    ngay tại Cook with me.
                </p>

                <a href="danh-sach.php" class="nut">
                    Khám phá món ăn
                </a>

            </div>

        </section>

        <noscript>

            <p class="thong-bao-noscript">
                JavaScript đang được tắt.
                Bạn vẫn có thể xem các món ăn,
                công thức và sử dụng các chức năng
                chính của website.
            </p>

        </noscript>

        <!-- ==================================
             MÓN ĂN MỚI NHẤT TỪ MYSQL
        =================================== -->

        <section class="mon-noi-bat">

            <div class="tieu-de-khu-vuc">

                <h2>
                    Món ăn mới nhất
                </h2>

                <a href="danh-sach.php">
                    Xem tất cả →
                </a>

            </div>

            <?php if (empty($moiVe)): ?>

                <p>
                    Hiện chưa có món ăn nào trong hệ thống.
                </p>

            <?php else: ?>

                <?php foreach ($moiVe as $monAn): ?>

                    <article class="the-mon-an">

                        <img
                            src="<?= e(
                                $monAn->hinhAnh
                                ?: 'images/default.jpg'
                            ) ?>"
                            alt="<?= e($monAn->ten) ?>"
                            width="300"
                            height="200"
                            loading="lazy"
                        >

                        <div class="thong-tin-mon">

                            <h3>
                                <?= e($monAn->ten) ?>
                            </h3>

                            <p
                                class="danh-gia-mon"
                                aria-label="Đánh giá món ăn"
                            >
                                ★★★★★
                            </p>

                            <p class="danh-muc-mon">
                                <?= e($monAn->danhMuc) ?>
                            </p>

                            <a
                                href="chi-tiet.php?id=<?= urlencode(
                                    $monAn->id
                                ) ?>"
                            >
                                Xem chi tiết
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

        <!-- ==================================
             GỢI Ý NGƯỜI THEO DÕI
        =================================== -->

        <section class="goi-y-theo-doi">

            <div class="tieu-de-khu-vuc">

                <h2>
                    Gợi ý người theo dõi
                </h2>

                <a href="nguoi-dung.php">
                    Xem tất cả →
                </a>

            </div>

            <!-- Người dùng Gladly -->
            <article
                class="the-nguoi-dung nguoi-dung-gladly"
            >

                <div class="thong-tin-hang-tren">

                    <img
                        src="images/icons/avt-default.svg"
                        alt="Gladly"
                    >

                    <div class="thong-tin-nguoi-dung">

                        <h3>
                            Gladly
                        </h3>

                        <p>
                            Chia sẻ công thức món ăn gia đình.
                        </p>

                    </div>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>

            <!-- Người dùng Serena -->
            <article
                class="the-nguoi-dung nguoi-dung-serena"
            >

                <div class="thong-tin-hang-tren">

                    <img
                        src="images/icons/avt-default.svg"
                        alt="Serena"
                    >

                    <div class="thong-tin-nguoi-dung">

                        <h3>
                            Serena
                        </h3>

                        <p>
                            Thường xuyên chia sẻ món ăn nhanh.
                        </p>

                    </div>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>

            <!-- Người dùng Jasmine -->
            <article
                class="the-nguoi-dung nguoi-dung-jasmine"
            >

                <div class="thong-tin-hang-tren">

                    <img
                        src="images/icons/avt-default.svg"
                        alt="Jasmine"
                    >

                    <div class="thong-tin-nguoi-dung">

                        <h3>
                            Jasmine
                        </h3>

                        <p>
                            Yêu thích các món tráng miệng.
                        </p>

                    </div>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>

        </section>

        <!-- ==================================
             MÓN ĂN ĐÃ XEM GẦN ĐÂY
        =================================== -->

        <?php if (!empty($danhSachDaXem)): ?>

            <section class="mon-da-xem">

                <div class="tieu-de-khu-vuc">

                    <h2>
                        Đã xem gần đây
                    </h2>

                </div>

                <div class="danh-sach-mon">

                    <?php foreach (
                        $danhSachDaXem as $monAn
                    ): ?>

                        <article class="the-mon-an">

                            <img
                                src="<?= e(
                                    $monAn->hinhAnh
                                    ?: 'images/default.jpg'
                                ) ?>"
                                alt="<?= e($monAn->ten) ?>"
                                width="300"
                                height="200"
                                loading="lazy"
                            >

                            <div class="thong-tin-mon">

                                <h3>
                                    <?= e($monAn->ten) ?>
                                </h3>

                                <p class="danh-gia-mon">
                                    ★★★★★
                                </p>

                                <a
                                    href="chi-tiet.php?id=<?= urlencode(
                                        $monAn->id
                                    ) ?>"
                                >
                                    Xem chi tiết
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            </section>

        <?php endif; ?>

    </div>

    <!-- ==================================
         BẢNG TIN
    =================================== -->

    <section class="bang-tin">

        <div class="tieu-de-khu-vuc">

            <h2>
                Bảng tin
            </h2>

            <a href="dang-bai-viet.php">
                Đăng bài viết →
            </a>

        </div>

        <!-- ==================================
             BÀI ĐĂNG 1: PHỞ BÒ
        =================================== -->

        <article
            class="the-bai-dang"
            data-bai-viet-id="pho-bo-truyen-thong"
        >

            <div class="thong-tin-tac-gia">

                <strong>
                    Angel
                </strong>

                <span>
                    Chia sẻ một công thức mới
                </span>

            </div>

            <h3>
                Phở bò truyền thống
            </h3>

            <p>
                Công thức phở bò thơm ngon với nước dùng
                đậm đà và các nguyên liệu quen thuộc.
            </p>

            <img
                src="images/pho-bo.jpg"
                alt="Tô phở bò với bánh phở, thịt bò, rau thơm và chanh"
                width="500"
                height="320"
                loading="lazy"
            >

            <div class="noi-dung-mo-rong" hidden>

                <p>
                    Phở bò là món ăn quen thuộc với
                    nước dùng trong, thơm và đậm vị.
                </p>

            </div>

            <div class="hanh-dong-bai-dang">

                <button
                    class="nut-tuong-tac nut-thich"
                    type="button"
                    data-bai-viet-id="pho-bo-truyen-thong"
                    aria-label="Thích bài viết"
                    title="Thích"
                >
                    ♡
                </button>

                <button
                    class="nut-tuong-tac nut-binh-luan"
                    type="button"
                    aria-label="Bình luận"
                    title="Bình luận"
                >
                    💬
                </button>

                <button
                    class="nut-tuong-tac nut-chia-se"
                    type="button"
                    aria-label="Chia sẻ bài viết"
                    title="Chia sẻ"
                >
                    ↗
                </button>

                <button
                    class="nut-tuong-tac nut-luu"
                    type="button"
                    data-bai-viet-id="pho-bo-truyen-thong"
                    aria-label="Lưu bài viết"
                    title="Lưu"
                >
                    🔖
                </button>

                <button
                    class="nut-tuong-tac nut-xem"
                    type="button"
                    aria-label="Xem nội dung bài viết"
                    title="Xem"
                >
                    ⋯
                </button>

            </div>

            <div class="khu-vuc-binh-luan" hidden>

                <form class="form-binh-luan">

                    <label for="binh-luan-pho-bo">
                        Bình luận
                    </label>

                    <input
                        type="text"
                        id="binh-luan-pho-bo"
                        name="comment"
                        maxlength="200"
                        placeholder="Viết bình luận..."
                        autocomplete="off"
                    >

                    <button
                        class="nut"
                        type="submit"
                    >
                        Gửi
                    </button>

                </form>

                <div class="danh-sach-binh-luan"></div>

            </div>

        </article>

        <!-- ==================================
             BÀI ĐĂNG 2: MÌ QUẢNG
        =================================== -->

        <article
            class="the-bai-dang"
            data-bai-viet-id="mi-quang-tom-thit"
        >

            <div class="thong-tin-tac-gia">

                <strong>
                    Helia
                </strong>

                <span>
                    Chia sẻ một công thức mới
                </span>

            </div>

            <h3>
                Mì Quảng tôm thịt
            </h3>

            <p>
                Công thức mì Quảng với tôm, thịt
                và rau sống ăn kèm.
            </p>

            <img
                src="images/mi-quang.jpg"
                alt="Tô mì Quảng với sợi mì vàng, tôm, thịt và rau sống"
                width="500"
                height="320"
                loading="lazy"
            >

            <div class="noi-dung-mo-rong" hidden>

                <p>
                    Công thức phù hợp cho bữa ăn gia đình
                    và có thể điều chỉnh nguyên liệu
                    theo khẩu phần.
                </p>

            </div>

            <div class="hanh-dong-bai-dang">

                <button
                    class="nut-tuong-tac nut-thich"
                    type="button"
                    data-bai-viet-id="mi-quang-tom-thit"
                    aria-label="Thích bài viết"
                    title="Thích"
                >
                    ♡
                </button>

                <button
                    class="nut-tuong-tac nut-binh-luan"
                    type="button"
                    aria-label="Bình luận"
                    title="Bình luận"
                >
                    💬
                </button>

                <button
                    class="nut-tuong-tac nut-chia-se"
                    type="button"
                    aria-label="Chia sẻ bài viết"
                    title="Chia sẻ"
                >
                    ↗
                </button>

                <button
                    class="nut-tuong-tac nut-luu"
                    type="button"
                    data-bai-viet-id="mi-quang-tom-thit"
                    aria-label="Lưu bài viết"
                    title="Lưu"
                >
                    🔖
                </button>

                <button
                    class="nut-tuong-tac nut-xem"
                    type="button"
                    aria-label="Xem nội dung bài viết"
                    title="Xem"
                >
                    ⋯
                </button>

            </div>

            <div class="khu-vuc-binh-luan" hidden>

                <form class="form-binh-luan">

                    <label for="binh-luan-mi-quang">
                        Bình luận
                    </label>

                    <input
                        type="text"
                        id="binh-luan-mi-quang"
                        name="comment"
                        maxlength="200"
                        placeholder="Viết bình luận..."
                        autocomplete="off"
                    >

                    <button
                        class="nut"
                        type="submit"
                    >
                        Gửi
                    </button>

                </form>

                <div class="danh-sach-binh-luan"></div>

            </div>

        </article>

    </section>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
