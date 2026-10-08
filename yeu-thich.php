<?php
require_once __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

$kho = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$yeuThichService = new YeuThichService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['xoa_yeu_thich'])) {
        $idMonAn = trim((string)$_POST['xoa_yeu_thich']);

        if ($idMonAn !== '') {
            $yeuThichService->xoa($idMonAn);
        }

        header('Location: yeu-thich.php');
        exit;
    }

    if (isset($_POST['xoa_het_yeu_thich'])) {
    $yeuThichService->xoaHet();

    header('Location: yeu-thich.php');
    exit;
}

    if (isset($_POST['them_yeu_thich'])) {
        $idMonAn = trim((string)$_POST['them_yeu_thich']);

        if ($idMonAn !== '') {
            $yeuThichService->them($idMonAn);
        }

        header('Location: yeu-thich.php');
        exit;
    }
}

$danhSachYeuThich = $yeuThichService->danhSachMonAn($kho);

$tieuDe = 'Món ăn yêu thích';
$trang = 'yeu-thich';
$customJS = '';

require_once __DIR__ . '/inc/header.php';
?>

<main class="trang-yeu-thich container my-4">
    <h1 class="tieu-de-trang mb-4">Món ăn yêu thích của bạn</h1>
    
    <?php if (!empty($danhSachYeuThich)): ?>

    <div class="luoi-mon-an">

        <?php foreach ($danhSachYeuThich as $monAn): ?>

            <article class="the-mon-an">

                <img
                    src="<?= e($monAn->hinhAnh) ?>"
                    alt="Hình ảnh món <?= e($monAn->ten) ?>"
                    width="300"
                    height="200"
                    loading="lazy"
                >

                <div class="thong-tin-mon">

                    <h2><?= e($monAn->ten) ?></h2>

                    <p>
                        <?= e($monAn->moTa) ?>
                    </p>

                    <p>
                        <?= (int)$monAn->thoiGian ?> phút ·
                        <?= number_format((int)$monAn->nganSach, 0, ',', '.') ?> VNĐ ·
                        <?= (int)$monAn->khauPhan ?> người
                    </p>

                    <div class="hanh-dong-mon">

                        <a
                            href="chi-tiet.php?id=<?= e($monAn->id) ?>"
                            class="nut"
                        >
                            Xem chi tiết
                        </a>

                        <form action="yeu-thich.php" method="post">
                            <input
                                type="hidden"
                                name="xoa_yeu_thich"
                                value="<?= e($monAn->id) ?>"
                            >

                            <button
                                type="submit"
                                class="nut nut-phu"
                            >
                                Xóa khỏi yêu thích
                            </button>
                        </form>

                    </div>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

    <form action="yeu-thich.php" method="post">
        <button
            type="submit"
            name="xoa_het_yeu_thich"
            value="1"
            class="nut nut-phu"
        >
            Xóa tất cả yêu thích
        </button>
    </form>

<?php else: ?>

    <div class="thong-bao-trong">
        <p>Bạn chưa thêm món ăn nào vào danh sách yêu thích!</p>

        <a href="danh-sach.php" class="btn btn-primary">
            Khám phá món ăn ngay
        </a>
    </div>

<?php endif; ?>
</main>

<?php
require_once __DIR__ . '/inc/footer.php';
?>
