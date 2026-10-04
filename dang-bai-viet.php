<?php
$pageTitle = "Đăng bài viết | Cook with me";

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>


  <main class="dang-bai-viet-trang">

    <h1>Đăng bài viết</h1>

    <noscript>
      <p class="thong-bao-noscript">
        JavaScript đang được tắt. Chức năng đăng và chỉnh sửa bài viết
        cần JavaScript để lưu dữ liệu bài viết trên trình duyệt.
      </p>
    </noscript>

    <div class="khung-dang-bai-viet">

      <div class="the-dang-bai-viet">

        <!-- Thông tin người đăng -->
        <header class="nguoi-dang-bai">

          <div class="anh-dai-dien">
            <span>U</span>
          </div>

          <div class="thong-tin-nguoi-dang">
            <strong>Người dùng</strong>
            <span>Đang chia sẻ công thức</span>
          </div>

        </header>


        <!-- Form đăng bài -->
        <form
          class="form-dang-bai-viet"
          action="#"
          method="post"
          enctype="multipart/form-data"
          novalidate
        >

          <!-- Caption -->
          <div class="khu-vuc-caption">

            <label for="mo-ta-bai-viet">
              Bạn đang muốn chia sẻ món gì?
            </label>

            <textarea
              id="mo-ta-bai-viet"
              name="mo_ta_bai_viet"
              rows="4"
              required
              placeholder="Chia sẻ câu chuyện hoặc kinh nghiệm nấu món ăn của bạn..."
            ></textarea>

          </div>


          <!-- Hình ảnh -->
          <section class="khu-vuc-hinh-anh-dang-bai">

            <div class="tieu-de-khu-vuc-dang-bai">

              <h2>Hình ảnh món ăn</h2>

              <span>
                Thêm hình ảnh
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
                Chọn một hoặc nhiều ảnh từ thiết bị
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


          <!-- Thông tin món ăn -->
          <section class="khu-vuc-thong-tin-mon-an">

            <h2>Thông tin món ăn</h2>


            <div class="nhom-truong">

              <label for="ten-mon">
                Tên món ăn
              </label>

              <input
                type="text"
                id="ten-mon"
                name="ten_mon"
                required
                minlength="2"
                placeholder="Ví dụ: Cao lầu Hội An"
              >

            </div>


            <div class="nhom-truong">

              <label for="danh-muc">
                Danh mục
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


            <div class="thong-tin-mon-an-grid">

              <div class="nhom-truong">

                <label for="thoi-gian-nau">
                  Thời gian
                </label>

                <input
                  type="number"
                  id="thoi-gian-nau"
                  name="thoi_gian_nau"
                  min="1"
                  max="300"
                  required
                  placeholder="Phút"
                >

              </div>


              <div class="nhom-truong">

                <label for="so-nguoi-an">
                  Khẩu phần
                </label>

                <input
                  type="number"
                  id="so-nguoi-an"
                  name="so_nguoi_an"
                  min="1"
                  max="20"
                  required
                  placeholder="Người"
                >

              </div>


              <div class="nhom-truong">

                <label for="ngan-sach">
                  Ngân sách
                </label>

                <input
                  type="number"
                  id="ngan-sach"
                  name="ngan_sach"
                  min="0"
                  required
                  placeholder="Đồng"
                >

              </div>

            </div>

          </section>


          <!-- Nguyên liệu -->
          <section class="khu-vuc-nguyen-lieu-dang-bai">

            <h2>Nguyên liệu</h2>

            <label for="nguyen-lieu">
              Danh sách nguyên liệu
            </label>

            <textarea
              id="nguyen-lieu"
              name="nguyen_lieu"
              rows="7"
              required
              placeholder="Mỗi nguyên liệu viết trên một dòng..."
            ></textarea>

          </section>


          <!-- Cách chế biến -->
          <section class="khu-vuc-cach-lam-dang-bai">

            <h2>Cách chế biến</h2>

            <label for="cach-lam">
              Các bước thực hiện
            </label>

            <textarea
              id="cach-lam"
              name="cach_lam"
              rows="9"
              required
              placeholder="Mỗi bước viết trên một dòng..."
            ></textarea>

          </section>


          <!-- Nút đăng -->
          <footer class="khu-vuc-dang-bai">

            <button
              type="submit"
              class="nut nut-dang-bai"
            >
              Đăng bài viết
            </button>

          </footer>

        </form>

      </div>

    </div>

  </main>


<?php
$customJS = 'js/trang-dang-bai-viet.js';
require_once 'includes/footer.php';
?>