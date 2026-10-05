<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

// Thiết lập thông số header
$tieuDe   = 'Trang người dùng'; 
$trang    = 'nguoi-dung'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-nguoi-dung.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>


    <main class="nguoi-dung-trang">

        <h1 class="tieu-de-nguoi-dung">
            Khám phá người dùng
        </h1>


        <section
            class="gioi-thieu-nguoi-dung"
            aria-labelledby="tieu-de-gioi-thieu-nguoi-dung"
        >

            <h2 id="tieu-de-gioi-thieu-nguoi-dung">
                Những người dùng nổi bật
            </h2>

            <p>
                Theo dõi những người dùng bạn quan tâm để
                dễ dàng khám phá các công thức và bài viết mới.
            </p>

        </section>


        <section
            class="danh-sach-nguoi-dung"
            aria-label="Danh sách người dùng"
        >

            <article class="the-nguoi-dung nguoi-dung-gladly">

                <div class="anh-dai-dien-nguoi-dung">
                    <span aria-hidden="true">
                        👩🏻‍🍳
                    </span>
                </div>

                <div class="thong-tin-nguoi-dung">

                    <h2>
                        Gladly
                    </h2>

                    <p>
                        Chia sẻ nhiều công thức món ăn gia đình.
                    </p>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>


            <article class="the-nguoi-dung nguoi-dung-serena">

                <div class="anh-dai-dien-nguoi-dung">
                    <span aria-hidden="true">
                        👩🏻‍🍳
                    </span>
                </div>

                <div class="thong-tin-nguoi-dung">

                    <h2>
                        Serena
                    </h2>

                    <p>
                        Thường xuyên chia sẻ các món ăn nhanh.
                    </p>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>


            <article class="the-nguoi-dung nguoi-dung-jasmine">

                <div class="anh-dai-dien-nguoi-dung">
                    <span aria-hidden="true">
                        👩🏻‍🍳
                    </span>
                </div>

                <div class="thong-tin-nguoi-dung">

                    <h2>
                        Jasmine
                    </h2>

                    <p>
                        Yêu thích các món tráng miệng và làm bánh.
                    </p>

                </div>

                <button
                    class="nut nut-phu"
                    type="button"
                >
                    Theo dõi
                </button>

            </article>

        </section>


        <p class="quay-lai-nguoi-dung">

            <a
                class="nut"
                href="index.php"
            >
                ← Về trang chủ
            </a>

        </p>

    </main>


    <?php
require __DIR__ . '/inc/footer.php';
?>