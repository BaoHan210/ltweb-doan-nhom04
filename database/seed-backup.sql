
-- BAI TAP NHOM 6 - NHOM 04
-- Du lieu mau cho website Cook with me

SET NAMES utf8mb4;
USE ltweb_nhom04;



-- Danh muc mon an
INSERT INTO danh_muc (id, ten, slug) VALUES
(1, 'Món chính', 'mon-chinh'),
(2, 'Món khai vị', 'mon-khai-vi'),
(3, 'Món canh', 'mon-canh'),
(4, 'Món tráng miệng', 'mon-trang-mieng'),
(5, 'Món rau', 'mon-rau'),
(6, 'Đồ uống', 'do-uong'),
(7, 'Món chay', 'mon-chay'),
(8, 'Món xào', 'mon-xao'),
(9, 'Món mới', 'mon-moi');


INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          1,
          'cao-lau',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cao lầu Hội An',
          60,
          3,
          'Trung bình',
          120000,
          10,
          'images/cao-lau.jpg',
          'Cao lầu là món ăn đặc trưng của Hội An với sợi mì đặc biệt, thịt xá xíu, rau sống và các nguyên liệu ăn kèm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          2,
          'ca-kho-to',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cá kho tộ',
          60,
          4,
          'Dễ',
          100000,
          10,
          'images/ca-kho-to.jpg',
          'Cá kho tộ đậm đà với nước màu, nước mắm và các loại gia vị quen thuộc trong bữa cơm gia đình.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          3,
          'goi-ngo-sen',
          (SELECT id FROM danh_muc WHERE ten = 'Món khai vị'),
          'Gỏi ngó sen',
          30,
          4,
          'Dễ',
          70000,
          10,
          'images/goi-ngo-sen.jpg',
          'Gỏi ngó sen giòn mát, kết hợp rau củ và nước trộn chua ngọt hài hòa.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          4,
          'banh-xeo',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh xèo',
          40,
          3,
          'Trung bình',
          80000,
          10,
          'images/banh-xeo.jpg',
          'Bánh xèo giòn vàng với nhân tôm thịt, giá đỗ và rau sống ăn kèm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          5,
          'mi-quang',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Mì Quảng',
          50,
          4,
          'Trung bình',
          110000,
          10,
          'images/mi-quang.jpg',
          'Mì Quảng với sợi mì vàng, thịt, tôm, rau sống và nước dùng đậm đà.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          6,
          'pho-bo',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Phở bò',
          120,
          4,
          'Khó',
          150000,
          10,
          'images/pho-bo.jpg',
          'Phở bò với nước dùng trong, thơm mùi gia vị và thịt bò mềm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          7,
          'canh-chua-ca',
          (SELECT id FROM danh_muc WHERE ten = 'Món canh'),
          'Canh chua cá',
          35,
          4,
          'Dễ',
          90000,
          10,
          'images/canh-chua-ca.jpg',
          'Canh chua cá có vị chua thanh, kết hợp cá và các loại rau củ.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          8,
          'rau-muong-xao-toi',
          (SELECT id FROM danh_muc WHERE ten = 'Món rau'),
          'Rau muống xào tỏi',
          20,
          3,
          'Dễ',
          40000,
          10,
          'images/rau-muong-xao-toi.jpg',
          'Rau muống xào tỏi đơn giản, nhanh gọn với rau xanh giòn và tỏi thơm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          9,
          'cha-gio',
          (SELECT id FROM danh_muc WHERE ten = 'Món khai vị'),
          'Chả giò',
          45,
          4,
          'Trung bình',
          85000,
          10,
          'images/mon-an-nhanh.jpg',
          'Chả giò giòn rụm với nhân thịt và rau củ, thích hợp dùng trong các bữa ăn gia đình.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          10,
          'sinh-to-xoai',
          (SELECT id FROM danh_muc WHERE ten = 'Đồ uống'),
          'Sinh tố xoài',
          10,
          2,
          'Dễ',
          45000,
          10,
          'images/do-uong.jpg',
          'Sinh tố xoài thơm ngọt, mát lạnh và dễ thực hiện tại nhà.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          11,
          'che-dau-xanh',
          (SELECT id FROM danh_muc WHERE ten = 'Món tráng miệng'),
          'Chè đậu xanh',
          60,
          4,
          'Dễ',
          55000,
          10,
          'images/che-dau-xanh.jpg',
          'Chè đậu xanh mềm thơm, có vị ngọt dịu và thích hợp dùng nóng hoặc lạnh.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          12,
          'dau-hu-sot-ca-chua',
          (SELECT id FROM danh_muc WHERE ten = 'Món chay'),
          'Đậu hũ sốt cà chua',
          25,
          3,
          'Dễ',
          50000,
          10,
          'images/mon-chay.jpg',
          'Đậu hũ sốt cà chua mềm béo, kết hợp với nước sốt cà chua đậm đà.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          13,
          'banh-xeo-mien-tay',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh xèo miền Tây',
          40,
          4,
          'Trung bình',
          70000,
          10,
          'images/Banh-Xeo-Mien-Tay.jpg',
          'Bánh xèo vàng giòn rụm cuốn kèm rau sống và nước mắm chua ngọt.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          14,
          'com-hen',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cơm hến',
          30,
          2,
          'Dễ',
          35000,
          10,
          'images/com-hen.jpg',
          'Cơm hến đậm đà hương vị miền Trung cay nồng hấp dẫn.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          15,
          'hu-tieu-nam-vang',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Hủ tiếu Nam Vang',
          45,
          4,
          'Trung bình',
          80000,
          10,
          'images/Hu-tieu-nam-vang.jpg',
          'Hủ tiếu Nam Vang nước dùng thanh ngọt, topping phong phú.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          16,
          'banh-canh-cha-ca',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh canh chả cá',
          35,
          4,
          'Dễ',
          50000,
          10,
          'images/Banh-canh-cha-ca.jpg',
          'Bánh canh chả cá dai ngọt đậm đà hương vị biển.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          17,
          'bun-dau-mam-tom',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bún đậu mắm tôm',
          25,
          3,
          'Dễ',
          60000,
          10,
          'images/Bun-dau-mam-tom.jpg',
          'Đậu hũ giòn rụm ăn kèm bún, chả cốm, thịt luộc chấm mắm tôm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          18,
          'goi-ca-trich-phu-quoc',
          (SELECT id FROM danh_muc WHERE ten = 'Món khai vị'),
          'Gỏi cá trích Phú Quốc',
          30,
          4,
          'Trung bình',
          100000,
          10,
          'images/Goi-ca-trich-phu-quoc.jpg',
          'Gỏi cá trích tươi ngon trộn hành tây, dừa nạo và nước sốt đặc biệt.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          19,
          'banh-khot-vung-tau',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh khọt Vũng Tàu',
          35,
          4,
          'Trung bình',
          65000,
          10,
          'images/Banh-khot-vung-tau.jpg',
          'Bánh khọt nhỏ tròn giòn rụm bên trên có tôm tươi và mỡ hành.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          20,
          'lau-mam-mien-tay',
          (SELECT id FROM danh_muc WHERE ten = 'Món canh'),
          'Lẩu mắm miền Tây',
          50,
          6,
          'Khó',
          150000,
          10,
          'images/Lau-mam-mien-tay.jpg',
          'Lẩu mắm đậm đà hương vị miền tây ăn kèm các loại rau đồng quê.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          21,
          'com-tam-sai-gon',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cơm tấm Sài Gòn',
          35,
          2,
          'Dễ',
          45000,
          10,
          'images/Com-tam-sai-gon.jpg',
          'Cơm tấm hạt nhuyễn ăn kèm sườn nướng mỡ hành và bì chả.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          22,
          'banh-trang-cuon-thit-heo',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh tráng cuốn thịt heo',
          25,
          4,
          'Dễ',
          75000,
          10,
          'images/Banh-trang-cuon-thit-heo.jpg',
          'Thịt heo luộc hai đầu da cuốn bánh tráng kèm rau sống chấm mắm nêm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          23,
          'banh-da-cua-hai-phong',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh đa cua Hải Phòng',
          40,
          3,
          'Trung bình',
          60000,
          10,
          'images/Banh-da-cua-hai-phong.jpg',
          'Bánh đa đỏ dai thơm hòa quyện với gạch cua và chả lá lốt.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          24,
          'cha-muc-ha-long',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Chả mực Hạ Long',
          30,
          4,
          'Trung bình',
          120000,
          10,
          'images/Cha-muc-ha-long.jpg',
          'Chả mực giã tay dai giòn sần sật thơm lừng đặc sản Hạ Long.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          25,
          'bun-bo-hue',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bún bò Huế',
          120,
          4,
          'Khó',
          150000,
          10,
          'images/bun-bo-hue.jpg',
          'Bún bò Huế đậm đà với nước dùng thơm mùi sả, mắm ruốc và các loại gia vị đặc trưng.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          26,
          'com-chien-duong-chau',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cơm chiên Dương Châu',
          30,
          3,
          'Dễ',
          80000,
          10,
          'images/com-chien-duong-chau.jpg',
          'Cơm chiên vàng thơm kết hợp trứng, thịt và rau củ nhiều màu sắc.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          27,
          'bo-luc-lac',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bò lúc lắc',
          35,
          3,
          'Trung bình',
          140000,
          10,
          'images/bo-luc-lac.jpg',
          'Thịt bò mềm thơm được áp chảo cùng hành tây và ớt chuông.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          28,
          'ga-kho-gung',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Gà kho gừng',
          45,
          4,
          'Dễ',
          100000,
          10,
          'images/ga-kho-gung.jpg',
          'Gà kho mềm đậm đà kết hợp với vị cay thơm đặc trưng của gừng.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          29,
          'tom-rang-me',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Tôm rang me',
          30,
          3,
          'Trung bình',
          120000,
          10,
          'images/tom-rang-me.jpg',
          'Tôm rang sốt me chua ngọt, đậm đà và thơm ngon.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          30,
          'canh-bi-do-ham-xuong',
          (SELECT id FROM danh_muc WHERE ten = 'Món canh'),
          'Canh bí đỏ hầm xương',
          60,
          4,
          'Dễ',
          90000,
          10,
          'images/canh-bi-do-ham-xuong.jpg',
          'Canh bí đỏ mềm ngọt nấu cùng xương heo tạo nên món canh thanh nhẹ.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          31,
          'dau-que-xao-toi',
          (SELECT id FROM danh_muc WHERE ten = 'Món xào'),
          'Đậu que xào tỏi',
          20,
          3,
          'Dễ',
          45000,
          10,
          'images/dau-que-xao-toi.jpg',
          'Đậu que xanh giòn xào cùng tỏi thơm, đơn giản và dễ thực hiện.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          32,
          'nem-nuong-nha-trang',
          (SELECT id FROM danh_muc WHERE ten = 'Món khai vị'),
          'Nem nướng Nha Trang',
          60,
          4,
          'Trung bình',
          110000,
          10,
          'images/nem-nuong-nha-trang.jpg',
          'Nem nướng thơm mềm ăn kèm rau sống và bánh tráng cuốn.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          33,
          'banh-cuon-nong',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Bánh cuốn nóng',
          50,
          3,
          'Khó',
          70000,
          10,
          'images/banh-cuon-nong.jpg',
          'Bánh cuốn mềm mỏng với nhân thịt băm và mộc nhĩ thơm ngon.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          34,
          'che-ba-mau',
          (SELECT id FROM danh_muc WHERE ten = 'Món tráng miệng'),
          'Chè ba màu',
          60,
          4,
          'Trung bình',
          60000,
          10,
          'images/che-ba-mau.jpg',
          'Chè ba màu nhiều lớp với đậu xanh, đậu đỏ, thạch và nước cốt dừa.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          35,
          'panna-cotta-xoai',
          (SELECT id FROM danh_muc WHERE ten = 'Món tráng miệng'),
          'Panna cotta xoài',
          180,
          4,
          'Trung bình',
          100000,
          10,
          'images/panna-cotta-xoai.jpg',
          'Panna cotta mềm mịn kết hợp vị ngọt thơm tự nhiên của xoài.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          36,
          'nuoc-chanh-sa',
          (SELECT id FROM danh_muc WHERE ten = 'Đồ uống'),
          'Nước chanh sả',
          20,
          4,
          'Dễ',
          35000,
          10,
          'images/nuoc-chanh-sa.jpg',
          'Nước chanh sả thanh mát, có vị chua nhẹ và hương thơm đặc trưng.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          37,
          'ga-nuong-mac-khen',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Gà nướng mắc khén',
          50,
          4,
          'Trung bình',
          150000,
          10,
          'images/ga-nuong-mac-khen.jpg',
          'Thịt gà thả vườn da giòn rụm, thấm đượm hương vị cay tê thơm nồng của hạt mắc khén Tây Bắc.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          38,
          'ca-chem-hap-xi-dau',
          (SELECT id FROM danh_muc WHERE ten = 'Món chính'),
          'Cá chẽm hấp xì dầu',
          30,
          4,
          'Dễ',
          120000,
          10,
          'images/ca-chem-hap-xi-dau.jpg',
          'Cá hấp giữ trọn vị ngọt thanh tự nhiên của thịt cá tươi hòa quyện sốt xì dầu thơm gừng hành.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          39,
          'canh-suon-nau-sau',
          (SELECT id FROM danh_muc WHERE ten = 'Món canh'),
          'Canh sườn nấu sấu',
          35,
          4,
          'Dễ',
          80000,
          10,
          'images/canh-suon-nau-sau.jpg',
          'Món canh chua thanh tao đặc trưng của Hà Nội, nước canh trong ngọt xương điểm vị chua dịu của quả sấu.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          40,
          'canh-hen-hoa-thien-ly',
          (SELECT id FROM danh_muc WHERE ten = 'Món canh'),
          'Canh hến hoa thiên lý',
          20,
          3,
          'Dễ',
          45000,
          10,
          'images/canh-hen-hoa-thien-ly.jpg',
          'Thịt hến ngọt bùi tự nhiên kết hợp cùng bông thiên lý giòn thơm ngát, mang lại cảm giác dịu mát ngày oi ả.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          41,
          'bong-bi-xao-toi',
          (SELECT id FROM danh_muc WHERE ten = 'Món rau'),
          'Bông bí xào tỏi',
          15,
          3,
          'Rất dễ',
          35000,
          10,
          'images/bong-bi-xao-toi.jpg',
          'Những búp bông bí vàng ươm giòn ngọt, quyện trong vị tỏi phi thơm nức mũi dân dã.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          42,
          'nom-ngo-sen-tai-heo',
          (SELECT id FROM danh_muc WHERE ten = 'Món rau'),
          'Nộm ngó sen tai heo',
          30,
          4,
          'Trung bình',
          65000,
          10,
          'images/nom-ngo-sen-tai-heo.jpg',
          'Ngó sen trắng nõn giòn tan kết hợp cùng tai heo sần sật trong nước mắm chua ngọt và lạc rang bùi ngậy.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          43,
          'bao-tu-ca-xao-dua',
          (SELECT id FROM danh_muc WHERE ten = 'Món xào'),
          'Bao tử cá xào dưa chua',
          20,
          3,
          'Trung bình',
          55000,
          10,
          'images/bao-tu-ca-xao-dua.jpg',
          'Bao tử cá ba sa giòn sần sật ngấm trọn vị chua thanh dịu của cải muối và cay ấm của gừng.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          44,
          'chao-tom-boc-mia',
          (SELECT id FROM danh_muc WHERE ten = 'Món khai vị'),
          'Chạo tôm bọc mía',
          40,
          4,
          'Trung bình',
          110000,
          10,
          'images/chao-tom-boc-mia.jpg',
          'Chả tôm giòn dai thơm lừng thấm đẫm vị mật ngọt tươm ra từ từng khúc mía nướng.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          45,
          'ca-tim-om-dau-chay',
          (SELECT id FROM danh_muc WHERE ten = 'Món chay'),
          'Cà tím om đậu chay',
          25,
          3,
          'Dễ',
          30000,
          10,
          'images/ca-tim-om-dau-chay.jpg',
          'Cà tím mềm ngọt tự nhiên om cùng đậu hũ chiên vàng và nấm đùi gà dậy mùi lá tía tô thơm ngát.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          46,
          'hu-tieu-xao-chay',
          (SELECT id FROM danh_muc WHERE ten = 'Món chay'),
          'Hủ tiếu xào nấm rau củ chay',
          20,
          2,
          'Dễ',
          40000,
          10,
          'images/hu-tieu-xao-chay.jpg',
          'Sợi hủ tiếu mềm dai bóng bẩy, quyện cùng nấm rơm béo ngọt, cà rốt và cải ngọt thanh đạm.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          47,
          'tra-mang-cau',
          (SELECT id FROM danh_muc WHERE ten = 'Đồ uống'),
          'Trà mãng cầu xiêm',
          15,
          2,
          'Rất dễ',
          35000,
          10,
          'images/tra-mang-cau.jpg',
          'Thức uống giải nhiệt mùa nắng với vị trà lài thơm nức kết hợp thịt mãng cầu chua ngọt mọng nước sần sật.'
        );

INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          48,
          'banh-chuoi-nuong',
          (SELECT id FROM danh_muc WHERE ten = 'Món tráng miệng'),
          'Bánh chuối nướng cốt dừa',
          60,
          4,
          'Trung bình',
          55000,
          10,
          'images/banh-chuoi-nuong.jpg',
          'Món tráng miệng dân dã thơm nức mùi nước cốt dừa béo ngậy quyện cùng vị ngọt đậm đà, dẻo mềm của chuối xiêm chín nướng vàng ươm.'
        );
    
-- Du lieu kiem thu: mon an het hang
UPDATE mon_an
SET ton_kho = 0
WHERE slug = 'cao-lau';


-- Du lieu kiem thu: ten chua dau nhay don
INSERT INTO mon_an
(slug, danh_muc_id, ten, thoi_gian,
 khau_phan, do_kho, ngan_sach, ton_kho)
VALUES
(
    'chef-special-test',
    1,
    'Chef''s Special',
    30,
    2,
    'Dễ',
    50000,
    5
);


INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300 g sợi cao lầu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '300 g sợi cao lầu' FROM nguyen_lieu WHERE ten = '300 g sợi cao lầu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500 g thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '500 g thịt heo' FROM nguyen_lieu WHERE ten = '500 g thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '200 g rau sống' FROM nguyen_lieu WHERE ten = '200 g rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Giá đỗ' FROM nguyen_lieu WHERE ten = 'Giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mật ong');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Mật ong' FROM nguyen_lieu WHERE ten = 'Mật ong';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ngũ vị hương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Ngũ vị hương' FROM nguyen_lieu WHERE ten = 'Ngũ vị hương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500 g cá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, '500 g cá' FROM nguyen_lieu WHERE ten = '500 g cá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Nước mắm' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Tiêu' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300 g ngó sen');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '300 g ngó sen' FROM nguyen_lieu WHERE ten = '300 g ngó sen';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g cà rốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '100 g cà rốt' FROM nguyen_lieu WHERE ten = '100 g cà rốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '100 g rau thơm' FROM nguyen_lieu WHERE ten = '100 g rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, 'Nước mắm' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g bột bánh xèo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '200 g bột bánh xèo' FROM nguyen_lieu WHERE ten = '200 g bột bánh xèo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '200 g tôm' FROM nguyen_lieu WHERE ten = '200 g tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('150 g thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '150 g thịt heo' FROM nguyen_lieu WHERE ten = '150 g thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '100 g giá đỗ' FROM nguyen_lieu WHERE ten = '100 g giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, 'Rau sống' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400 g sợi mì Quảng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '400 g sợi mì Quảng' FROM nguyen_lieu WHERE ten = '400 g sợi mì Quảng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '200 g thịt heo' FROM nguyen_lieu WHERE ten = '200 g thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '200 g tôm' FROM nguyen_lieu WHERE ten = '200 g tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, 'Rau sống' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, 'Đậu phộng' FROM nguyen_lieu WHERE ten = 'Đậu phộng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500 g bánh phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, '500 g bánh phở' FROM nguyen_lieu WHERE ten = '500 g bánh phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500 g thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, '500 g thịt bò' FROM nguyen_lieu WHERE ten = '500 g thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Hành lá' FROM nguyen_lieu WHERE ten = 'Hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Rau thơm' FROM nguyen_lieu WHERE ten = 'Rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gia vị phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Gia vị phở' FROM nguyen_lieu WHERE ten = 'Gia vị phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400 g cá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, '400 g cá' FROM nguyen_lieu WHERE ten = '400 g cá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, '100 g giá đỗ' FROM nguyen_lieu WHERE ten = '100 g giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Cà chua' FROM nguyen_lieu WHERE ten = 'Cà chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Rau thơm' FROM nguyen_lieu WHERE ten = 'Rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500 g rau muống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, '500 g rau muống' FROM nguyen_lieu WHERE ten = '500 g rau muống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Dầu ăn' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gia vị');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Gia vị' FROM nguyen_lieu WHERE ten = 'Gia vị';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g thịt heo xay');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '200 g thịt heo xay' FROM nguyen_lieu WHERE ten = '200 g thịt heo xay';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g cà rốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '100 g cà rốt' FROM nguyen_lieu WHERE ten = '100 g cà rốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g miến');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '100 g miến' FROM nguyen_lieu WHERE ten = '100 g miến';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, 'Bánh tráng' FROM nguyen_lieu WHERE ten = 'Bánh tráng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 quả xoài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, '2 quả xoài' FROM nguyen_lieu WHERE ten = '2 quả xoài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sữa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, 'Sữa tươi' FROM nguyen_lieu WHERE ten = 'Sữa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, 'Đá viên' FROM nguyen_lieu WHERE ten = 'Đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, '200 g đậu xanh' FROM nguyen_lieu WHERE ten = '200 g đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, '100 g đường' FROM nguyen_lieu WHERE ten = '100 g đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, 'Nước cốt dừa' FROM nguyen_lieu WHERE ten = 'Nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400 g đậu hũ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, '400 g đậu hũ' FROM nguyen_lieu WHERE ten = '400 g đậu hũ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 quả cà chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, '2 quả cà chua' FROM nguyen_lieu WHERE ten = '2 quả cà chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400g bột bánh xèo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '400g bột bánh xèo' FROM nguyen_lieu WHERE ten = '400g bột bánh xèo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g thịt ba chỉ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '200g thịt ba chỉ' FROM nguyen_lieu WHERE ten = '200g thịt ba chỉ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g tôm tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '200g tôm tươi' FROM nguyen_lieu WHERE ten = '200g tôm tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('150ml nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '150ml nước cốt dừa' FROM nguyen_lieu WHERE ten = '150ml nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá, giá đỗ, đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, 'Hành lá, giá đỗ, đậu xanh' FROM nguyen_lieu WHERE ten = 'Hành lá, giá đỗ, đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống ăn kèm, tỏi ớt, chanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, 'Rau sống ăn kèm, tỏi ớt, chanh' FROM nguyen_lieu WHERE ten = 'Rau sống ăn kèm, tỏi ớt, chanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500g hến tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, '500g hến tươi' FROM nguyen_lieu WHERE ten = '500g hến tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 bát cơm nguội');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, '2 bát cơm nguội' FROM nguyen_lieu WHERE ten = '2 bát cơm nguội';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bắp chuối thái mỏng, khế chua, rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Bắp chuối thái mỏng, khế chua, rau thơm' FROM nguyen_lieu WHERE ten = 'Bắp chuối thái mỏng, khế chua, rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm ruốc Huế, ớt bột');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Mắm ruốc Huế, ớt bột' FROM nguyen_lieu WHERE ten = 'Mắm ruốc Huế, ớt bột';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng rang giã nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Đậu phộng rang giã nhỏ' FROM nguyen_lieu WHERE ten = 'Đậu phộng rang giã nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400g sợi hủ tiếu dai');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, '400g sợi hủ tiếu dai' FROM nguyen_lieu WHERE ten = '400g sợi hủ tiếu dai';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương ống heo, mực khô, tôm khô');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Xương ống heo, mực khô, tôm khô' FROM nguyen_lieu WHERE ten = 'Xương ống heo, mực khô, tôm khô';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo bằm, tôm tươi, trứng cút');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Thịt heo bằm, tôm tươi, trứng cút' FROM nguyen_lieu WHERE ten = 'Thịt heo bằm, tôm tươi, trứng cút';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành ngò, cần tây, giá hẹ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Hành ngò, cần tây, giá hẹ' FROM nguyen_lieu WHERE ten = 'Hành ngò, cần tây, giá hẹ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400g sợi bánh canh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, '400g sợi bánh canh' FROM nguyen_lieu WHERE ten = '400g sợi bánh canh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g chả cá thác lát hoặc chả cá chiên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, '300g chả cá thác lát hoặc chả cá chiên' FROM nguyen_lieu WHERE ten = '300g chả cá thác lát hoặc chả cá chiên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương cá hoặc xương heo nấu nước dùng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, 'Xương cá hoặc xương heo nấu nước dùng' FROM nguyen_lieu WHERE ten = 'Xương cá hoặc xương heo nấu nước dùng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá, ngò rí, tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, 'Hành lá, ngò rí, tiêu' FROM nguyen_lieu WHERE ten = 'Hành lá, ngò rí, tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500g bún tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '500g bún tươi' FROM nguyen_lieu WHERE ten = '500g bún tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('4 bìa đậu hũ trắng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '4 bìa đậu hũ trắng' FROM nguyen_lieu WHERE ten = '4 bìa đậu hũ trắng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g thịt ba chỉ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '300g thịt ba chỉ' FROM nguyen_lieu WHERE ten = '300g thịt ba chỉ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g chả cốm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '200g chả cốm' FROM nguyen_lieu WHERE ten = '200g chả cốm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm tôm, quất, tỏi ớt, rau kinh giới, tía tô');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, 'Mắm tôm, quất, tỏi ớt, rau kinh giới, tía tô' FROM nguyen_lieu WHERE ten = 'Mắm tôm, quất, tỏi ớt, rau kinh giới, tía tô';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g phi lê cá trích tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, '300g phi lê cá trích tươi' FROM nguyen_lieu WHERE ten = '300g phi lê cá trích tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100g dừa nạo sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, '100g dừa nạo sợi' FROM nguyen_lieu WHERE ten = '100g dừa nạo sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tây, hành tím, ớt sừng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, 'Hành tây, hành tím, ớt sừng' FROM nguyen_lieu WHERE ten = 'Hành tây, hành tím, ớt sừng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng rang, nước cốt chanh, nước mắm ngon');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, 'Đậu phộng rang, nước cốt chanh, nước mắm ngon' FROM nguyen_lieu WHERE ten = 'Đậu phộng rang, nước cốt chanh, nước mắm ngon';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g bột bánh khọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '300g bột bánh khọt' FROM nguyen_lieu WHERE ten = '300g bột bánh khọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g tôm tươi nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '200g tôm tươi nhỏ' FROM nguyen_lieu WHERE ten = '200g tôm tươi nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100ml nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '100ml nước cốt dừa' FROM nguyen_lieu WHERE ten = '100ml nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá làm mỡ hành, rau sống, nước mắm chua ngọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, 'Hành lá làm mỡ hành, rau sống, nước mắm chua ngọt' FROM nguyen_lieu WHERE ten = 'Hành lá làm mỡ hành, rau sống, nước mắm chua ngọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g mắm cá linh hoặc mắm cá sặc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, '200g mắm cá linh hoặc mắm cá sặc' FROM nguyen_lieu WHERE ten = '200g mắm cá linh hoặc mắm cá sặc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt ba chỉ, tôm, mực, cá basa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Thịt ba chỉ, tôm, mực, cá basa' FROM nguyen_lieu WHERE ten = 'Thịt ba chỉ, tôm, mực, cá basa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả băm, tỏi, hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Sả băm, tỏi, hành tím' FROM nguyen_lieu WHERE ten = 'Sả băm, tỏi, hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Các loại rau: bông súng, rau đắng, so đũa, bắp chuối');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Các loại rau: bông súng, rau đắng, so đũa, bắp chuối' FROM nguyen_lieu WHERE ten = 'Các loại rau: bông súng, rau đắng, so đũa, bắp chuối';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g gạo tấm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, '300g gạo tấm' FROM nguyen_lieu WHERE ten = '300g gạo tấm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 miếng sườn cốt lết');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, '2 miếng sườn cốt lết' FROM nguyen_lieu WHERE ten = '2 miếng sườn cốt lết';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bì heo, chả trứng hấp');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, 'Bì heo, chả trứng hấp' FROM nguyen_lieu WHERE ten = 'Bì heo, chả trứng hấp';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá làm mỡ hành, nước mắm pha ngọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, 'Hành lá làm mỡ hành, nước mắm pha ngọt' FROM nguyen_lieu WHERE ten = 'Hành lá làm mỡ hành, nước mắm pha ngọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400g thịt heo luộc (hai đầu da)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, '400g thịt heo luộc (hai đầu da)' FROM nguyen_lieu WHERE ten = '400g thịt heo luộc (hai đầu da)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng cuốn, bánh phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Bánh tráng cuốn, bánh phở' FROM nguyen_lieu WHERE ten = 'Bánh tráng cuốn, bánh phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm nêm, tỏi, ớt, dứa băm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Mắm nêm, tỏi, ớt, dứa băm' FROM nguyen_lieu WHERE ten = 'Mắm nêm, tỏi, ớt, dứa băm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống đa dạng: xà lách, dưa leo, khế, chuối chát');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Rau sống đa dạng: xà lách, dưa leo, khế, chuối chát' FROM nguyen_lieu WHERE ten = 'Rau sống đa dạng: xà lách, dưa leo, khế, chuối chát';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300g bánh đa đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '300g bánh đa đỏ' FROM nguyen_lieu WHERE ten = '300g bánh đa đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400g cua đồng tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '400g cua đồng tươi' FROM nguyen_lieu WHERE ten = '400g cua đồng tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200g chả lá lốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '200g chả lá lốt' FROM nguyen_lieu WHERE ten = '200g chả lá lốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua, hành lá, tôm tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, 'Cà chua, hành lá, tôm tươi' FROM nguyen_lieu WHERE ten = 'Cà chua, hành lá, tôm tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('500g mực nang tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, '500g mực nang tươi' FROM nguyen_lieu WHERE ten = '500g mực nang tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('50g thịt nạc dăm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, '50g thịt nạc dăm' FROM nguyen_lieu WHERE ten = '50g thịt nạc dăm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành khô, tỏi, tiêu, thì là');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, 'Hành khô, tỏi, tiêu, thì là' FROM nguyen_lieu WHERE ten = 'Hành khô, tỏi, tiêu, thì là';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn để chiên ngập dầu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, 'Dầu ăn để chiên ngập dầu' FROM nguyen_lieu WHERE ten = 'Dầu ăn để chiên ngập dầu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bún');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Bún' FROM nguyen_lieu WHERE ten = 'Bún';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Thịt bò' FROM nguyen_lieu WHERE ten = 'Thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Xương bò' FROM nguyen_lieu WHERE ten = 'Xương bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Sả' FROM nguyen_lieu WHERE ten = 'Sả';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm ruốc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Mắm ruốc' FROM nguyen_lieu WHERE ten = 'Mắm ruốc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Ớt' FROM nguyen_lieu WHERE ten = 'Ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau ăn kèm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Rau ăn kèm' FROM nguyen_lieu WHERE ten = 'Rau ăn kèm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cơm nguội');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Cơm nguội' FROM nguyen_lieu WHERE ten = 'Cơm nguội';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Trứng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Trứng' FROM nguyen_lieu WHERE ten = 'Trứng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Thịt' FROM nguyen_lieu WHERE ten = 'Thịt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu Hà Lan');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Đậu Hà Lan' FROM nguyen_lieu WHERE ten = 'Đậu Hà Lan';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Dầu ăn' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Thịt bò' FROM nguyen_lieu WHERE ten = 'Thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tây');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Hành tây' FROM nguyen_lieu WHERE ten = 'Hành tây';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt chuông');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Ớt chuông' FROM nguyen_lieu WHERE ten = 'Ớt chuông';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu hào');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Dầu hào' FROM nguyen_lieu WHERE ten = 'Dầu hào';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Tiêu' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt gà');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Thịt gà' FROM nguyen_lieu WHERE ten = 'Thịt gà';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Gừng' FROM nguyen_lieu WHERE ten = 'Gừng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Tiêu' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Tôm' FROM nguyen_lieu WHERE ten = 'Tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Me');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Me' FROM nguyen_lieu WHERE ten = 'Me';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Nước mắm' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Ớt' FROM nguyen_lieu WHERE ten = 'Ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bí đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Bí đỏ' FROM nguyen_lieu WHERE ten = 'Bí đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Xương heo' FROM nguyen_lieu WHERE ten = 'Xương heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Hành tím' FROM nguyen_lieu WHERE ten = 'Hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Hành lá' FROM nguyen_lieu WHERE ten = 'Hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Tiêu' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu que');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Đậu que' FROM nguyen_lieu WHERE ten = 'Đậu que';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Dầu ăn' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Tiêu' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Thịt heo' FROM nguyen_lieu WHERE ten = 'Thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Tỏi' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Nước tương' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Rau sống' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Bánh tráng' FROM nguyen_lieu WHERE ten = 'Bánh tráng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bột gạo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Bột gạo' FROM nguyen_lieu WHERE ten = 'Bột gạo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Thịt heo' FROM nguyen_lieu WHERE ten = 'Thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mộc nhĩ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Mộc nhĩ' FROM nguyen_lieu WHERE ten = 'Mộc nhĩ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Hành tím' FROM nguyen_lieu WHERE ten = 'Hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Nước mắm' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Đậu xanh' FROM nguyen_lieu WHERE ten = 'Đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Đậu đỏ' FROM nguyen_lieu WHERE ten = 'Đậu đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thạch');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Thạch' FROM nguyen_lieu WHERE ten = 'Thạch';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Nước cốt dừa' FROM nguyen_lieu WHERE ten = 'Nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xoài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Xoài' FROM nguyen_lieu WHERE ten = 'Xoài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sữa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Sữa tươi' FROM nguyen_lieu WHERE ten = 'Sữa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Whipping cream');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Whipping cream' FROM nguyen_lieu WHERE ten = 'Whipping cream';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gelatin');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Gelatin' FROM nguyen_lieu WHERE ten = 'Gelatin';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Chanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Chanh' FROM nguyen_lieu WHERE ten = 'Chanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Sả' FROM nguyen_lieu WHERE ten = 'Sả';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Đường' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước lọc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Nước lọc' FROM nguyen_lieu WHERE ten = 'Nước lọc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Đá viên' FROM nguyen_lieu WHERE ten = 'Đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 con gà ta khoảng 1.3 kg');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, '1 con gà ta khoảng 1.3 kg' FROM nguyen_lieu WHERE ten = '1 con gà ta khoảng 1.3 kg';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hạt mắc khén, hạt dổi rang thơm giã nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, 'Hạt mắc khén, hạt dổi rang thơm giã nhỏ' FROM nguyen_lieu WHERE ten = 'Hạt mắc khén, hạt dổi rang thơm giã nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả, ớt, mật ong rừng, muối hạt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, 'Sả, ớt, mật ong rừng, muối hạt' FROM nguyen_lieu WHERE ten = 'Sả, ớt, mật ong rừng, muối hạt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 con cá chẽm tươi 700 g');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, '1 con cá chẽm tươi 700 g' FROM nguyen_lieu WHERE ten = '1 con cá chẽm tươi 700 g';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng tươi, đầu hành lá, ớt sừng xắt sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, 'Gừng tươi, đầu hành lá, ớt sừng xắt sợi' FROM nguyen_lieu WHERE ten = 'Gừng tươi, đầu hành lá, ớt sừng xắt sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xì dầu thượng hạng, dầu hào, dầu mè');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, 'Xì dầu thượng hạng, dầu hào, dầu mè' FROM nguyen_lieu WHERE ten = 'Xì dầu thượng hạng, dầu hào, dầu mè';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400 g sườn non heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, '400 g sườn non heo' FROM nguyen_lieu WHERE ten = '400 g sườn non heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('5-6 quả sấu xanh cạo vỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, '5-6 quả sấu xanh cạo vỏ' FROM nguyen_lieu WHERE ten = '5-6 quả sấu xanh cạo vỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua chín, hành hoa, mùi tàu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, 'Cà chua chín, hành hoa, mùi tàu' FROM nguyen_lieu WHERE ten = 'Cà chua chín, hành hoa, mùi tàu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g thịt hến tươi đãi sạch');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, '200 g thịt hến tươi đãi sạch' FROM nguyen_lieu WHERE ten = '200 g thịt hến tươi đãi sạch';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g hoa thiên lý tươi non');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, '200 g hoa thiên lý tươi non' FROM nguyen_lieu WHERE ten = '200 g hoa thiên lý tươi non';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím phi, hạt nêm, tiêu sọ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, 'Hành tím phi, hạt nêm, tiêu sọ' FROM nguyen_lieu WHERE ten = 'Hành tím phi, hạt nêm, tiêu sọ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 bó bông bí tươi (búp đực)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, '1 bó bông bí tươi (búp đực)' FROM nguyen_lieu WHERE ten = '1 bó bông bí tươi (búp đực)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 củ tỏi đập dập');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, '1 củ tỏi đập dập' FROM nguyen_lieu WHERE ten = '1 củ tỏi đập dập';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu hào, hạt nêm, dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, 'Dầu hào, hạt nêm, dầu ăn' FROM nguyen_lieu WHERE ten = 'Dầu hào, hạt nêm, dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g ngó sen tươi ngâm giấm đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, '200 g ngó sen tươi ngâm giấm đường' FROM nguyen_lieu WHERE ten = '200 g ngó sen tươi ngâm giấm đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 cái tai heo nhỏ luộc giòn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, '1 cái tai heo nhỏ luộc giòn' FROM nguyen_lieu WHERE ten = '1 cái tai heo nhỏ luộc giòn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà rốt sợi, rau răm, lạc rang, ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, 'Cà rốt sợi, rau răm, lạc rang, ớt' FROM nguyen_lieu WHERE ten = 'Cà rốt sợi, rau răm, lạc rang, ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300 g bao tử cá ba sa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, '300 g bao tử cá ba sa tươi' FROM nguyen_lieu WHERE ten = '300 g bao tử cá ba sa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g dưa cải muối chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, '200 g dưa cải muối chua' FROM nguyen_lieu WHERE ten = '200 g dưa cải muối chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng tươi, cà chua, thì là, hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, 'Gừng tươi, cà chua, thì là, hành lá' FROM nguyen_lieu WHERE ten = 'Gừng tươi, cà chua, thì là, hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('400 g tôm sú tươi bóc nõn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, '400 g tôm sú tươi bóc nõn' FROM nguyen_lieu WHERE ten = '400 g tôm sú tươi bóc nõn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('50 g mỡ gáy heo luộc thái hạt lựu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, '50 g mỡ gáy heo luộc thái hạt lựu' FROM nguyen_lieu WHERE ten = '50 g mỡ gáy heo luộc thái hạt lựu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mía róc vỏ chẻ thanh dài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, 'Mía róc vỏ chẻ thanh dài' FROM nguyen_lieu WHERE ten = 'Mía róc vỏ chẻ thanh dài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 quả cà tím dài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, '2 quả cà tím dài' FROM nguyen_lieu WHERE ten = '2 quả cà tím dài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('2 miếng đậu hũ trắng chiên vàng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, '2 miếng đậu hũ trắng chiên vàng' FROM nguyen_lieu WHERE ten = '2 miếng đậu hũ trắng chiên vàng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Lá tía tô, lá lốt thái chỉ, tỏi băm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, 'Lá tía tô, lá lốt thái chỉ, tỏi băm' FROM nguyen_lieu WHERE ten = 'Lá tía tô, lá lốt thái chỉ, tỏi băm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('300 g sợi hủ tiếu dai sợi mềm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, '300 g sợi hủ tiếu dai sợi mềm' FROM nguyen_lieu WHERE ten = '300 g sợi hủ tiếu dai sợi mềm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('150 g nấm bào ngư xé sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, '150 g nấm bào ngư xé sợi' FROM nguyen_lieu WHERE ten = '150 g nấm bào ngư xé sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cải ngọt, cà rốt, giá đỗ, nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, 'Cải ngọt, cà rốt, giá đỗ, nước tương' FROM nguyen_lieu WHERE ten = 'Cải ngọt, cà rốt, giá đỗ, nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('200 g thịt mãng cầu xiêm xé hạt ngâm đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, '200 g thịt mãng cầu xiêm xé hạt ngâm đường' FROM nguyen_lieu WHERE ten = '200 g thịt mãng cầu xiêm xé hạt ngâm đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('10 g trà nhài (lài) ủ lấy cốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, '10 g trà nhài (lài) ủ lấy cốt' FROM nguyen_lieu WHERE ten = '10 g trà nhài (lài) ủ lấy cốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt quả tắc (quất), đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, 'Nước cốt quả tắc (quất), đá viên' FROM nguyen_lieu WHERE ten = 'Nước cốt quả tắc (quất), đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('6-8 quả chuối sứ (chuối xiêm) chín bói');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '6-8 quả chuối sứ (chuối xiêm) chín bói' FROM nguyen_lieu WHERE ten = '6-8 quả chuối sứ (chuối xiêm) chín bói';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('150 ml nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '150 ml nước cốt dừa' FROM nguyen_lieu WHERE ten = '150 ml nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('100 g bánh mì sandwich (hoặc bánh mì giòn)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '100 g bánh mì sandwich (hoặc bánh mì giòn)' FROM nguyen_lieu WHERE ten = '100 g bánh mì sandwich (hoặc bánh mì giòn)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('50 g bơ lạt đun chảy, 50 g đường vàng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '50 g bơ lạt đun chảy, 50 g đường vàng' FROM nguyen_lieu WHERE ten = '50 g bơ lạt đun chảy, 50 g đường vàng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('1 quả trứng gà, 1 thìa canh sữa đặc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '1 quả trứng gà, 1 thìa canh sữa đặc' FROM nguyen_lieu WHERE ten = '1 quả trứng gà, 1 thìa canh sữa đặc';


-- 3 tai khoan thu theo Goi y 2
-- Mat khau mau: matkhau123

INSERT INTO nguoi_dung
(id, email, ho_ten, mat_khau, vai_tro)
VALUES
(1, 'admin@ued.vn', 'Quản trị viên',
 '$2y$12$qHb8qF.xgsQsDEN5nvxo6OsTDLDQmDQmTnjDdlNCp7MqAzd4fkWBG',
 'quan_tri'),

(2, 'lan@ued.vn', 'Nguyễn Thị Lan',
 '$2y$12$u.0T5HsnlVJWcPLCbRUsIO9EXccEweLCYOD7R46J.TJ9bH4ju5eGC',
 'khach_hang'),

(3, 'an@ued.vn', 'Trần Văn An',
 '$2y$12$3ZoP8Zw46/1SUlmMu/unR.ZIvgTjCuo2NGWs2F9ttQBE.FmFo83bO',
 'khach_hang');

-- Moi khach hang co mot don hang

INSERT INTO don_hang
(id, nguoi_dung_id, trang_thai)
VALUES
(1, 2, 'cho_xac_nhan'),
(2, 3, 'cho_xac_nhan');

-- Chi tiet don hang

INSERT INTO chi_tiet_don
(don_hang_id, mon_an_id, so_luong, don_gia)
VALUES
(1, 2, 1, 100000),
(2, 3, 1, 70000);
