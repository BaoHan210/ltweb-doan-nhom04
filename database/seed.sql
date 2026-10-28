
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


INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sợi cao lầu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '300 g' FROM nguyen_lieu WHERE ten = 'sợi cao lầu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '500 g' FROM nguyen_lieu WHERE ten = 'thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, '200 g' FROM nguyen_lieu WHERE ten = 'rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mật ong');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mật ong';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ngũ vị hương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 1, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Ngũ vị hương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, '500 g' FROM nguyen_lieu WHERE ten = 'cá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 2, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('ngó sen');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '300 g' FROM nguyen_lieu WHERE ten = 'ngó sen';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cà rốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '100 g' FROM nguyen_lieu WHERE ten = 'cà rốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, '100 g' FROM nguyen_lieu WHERE ten = 'rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 3, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bột bánh xèo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '200 g' FROM nguyen_lieu WHERE ten = 'bột bánh xèo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '200 g' FROM nguyen_lieu WHERE ten = 'tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '150 g' FROM nguyen_lieu WHERE ten = 'thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, '100 g' FROM nguyen_lieu WHERE ten = 'giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 4, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sợi mì Quảng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '400 g' FROM nguyen_lieu WHERE ten = 'sợi mì Quảng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '200 g' FROM nguyen_lieu WHERE ten = 'thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, '200 g' FROM nguyen_lieu WHERE ten = 'tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 5, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu phộng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bánh phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, '500 g' FROM nguyen_lieu WHERE ten = 'bánh phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, '500 g' FROM nguyen_lieu WHERE ten = 'thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gia vị phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 6, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gia vị phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, '400 g' FROM nguyen_lieu WHERE ten = 'cá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('giá đỗ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, '100 g' FROM nguyen_lieu WHERE ten = 'giá đỗ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cà chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 7, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('rau muống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, '500 g' FROM nguyen_lieu WHERE ten = 'rau muống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gia vị');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 8, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gia vị';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt heo xay');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '200 g' FROM nguyen_lieu WHERE ten = 'thịt heo xay';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cà rốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '100 g' FROM nguyen_lieu WHERE ten = 'cà rốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('miến');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, '100 g' FROM nguyen_lieu WHERE ten = 'miến';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bánh tráng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 9, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('xoài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, '2 quả' FROM nguyen_lieu WHERE ten = 'xoài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sữa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sữa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 10, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, '200 g' FROM nguyen_lieu WHERE ten = 'đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, '100 g' FROM nguyen_lieu WHERE ten = 'đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 11, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('đậu hũ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, '400 g' FROM nguyen_lieu WHERE ten = 'đậu hũ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cà chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, '2 quả' FROM nguyen_lieu WHERE ten = 'cà chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 12, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bột bánh xèo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '400g' FROM nguyen_lieu WHERE ten = 'bột bánh xèo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt ba chỉ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '200g' FROM nguyen_lieu WHERE ten = 'thịt ba chỉ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tôm tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '200g' FROM nguyen_lieu WHERE ten = 'tôm tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, '150ml' FROM nguyen_lieu WHERE ten = 'nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá, giá đỗ, đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá, giá đỗ, đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống ăn kèm, tỏi ớt, chanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 13, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau sống ăn kèm, tỏi ớt, chanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('hến tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, '500g' FROM nguyen_lieu WHERE ten = 'hến tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cơm nguội');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, '2 bát' FROM nguyen_lieu WHERE ten = 'cơm nguội';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bắp chuối thái mỏng, khế chua, rau thơm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bắp chuối thái mỏng, khế chua, rau thơm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm ruốc Huế, ớt bột');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mắm ruốc Huế, ớt bột';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng rang giã nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 14, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu phộng rang giã nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sợi hủ tiếu dai');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, '400g' FROM nguyen_lieu WHERE ten = 'sợi hủ tiếu dai';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương ống heo, mực khô, tôm khô');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xương ống heo, mực khô, tôm khô';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo bằm, tôm tươi, trứng cút');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt heo bằm, tôm tươi, trứng cút';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành ngò, cần tây, giá hẹ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 15, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành ngò, cần tây, giá hẹ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sợi bánh canh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, '400g' FROM nguyen_lieu WHERE ten = 'sợi bánh canh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('chả cá thác lát hoặc chả cá chiên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, '300g' FROM nguyen_lieu WHERE ten = 'chả cá thác lát hoặc chả cá chiên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương cá hoặc xương heo nấu nước dùng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xương cá hoặc xương heo nấu nước dùng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá, ngò rí, tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 16, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá, ngò rí, tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bún tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '500g' FROM nguyen_lieu WHERE ten = 'bún tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('đậu hũ trắng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '4 bìa' FROM nguyen_lieu WHERE ten = 'đậu hũ trắng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt ba chỉ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '300g' FROM nguyen_lieu WHERE ten = 'thịt ba chỉ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('chả cốm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, '200g' FROM nguyen_lieu WHERE ten = 'chả cốm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm tôm, quất, tỏi ớt, rau kinh giới, tía tô');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 17, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mắm tôm, quất, tỏi ớt, rau kinh giới, tía tô';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('phi lê cá trích tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, '300g' FROM nguyen_lieu WHERE ten = 'phi lê cá trích tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('dừa nạo sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, '100g' FROM nguyen_lieu WHERE ten = 'dừa nạo sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tây, hành tím, ớt sừng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành tây, hành tím, ớt sừng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu phộng rang, nước cốt chanh, nước mắm ngon');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 18, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu phộng rang, nước cốt chanh, nước mắm ngon';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bột bánh khọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '300g' FROM nguyen_lieu WHERE ten = 'bột bánh khọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tôm tươi nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '200g' FROM nguyen_lieu WHERE ten = 'tôm tươi nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, '100ml' FROM nguyen_lieu WHERE ten = 'nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá làm mỡ hành, rau sống, nước mắm chua ngọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 19, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá làm mỡ hành, rau sống, nước mắm chua ngọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('mắm cá linh hoặc mắm cá sặc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, '200g' FROM nguyen_lieu WHERE ten = 'mắm cá linh hoặc mắm cá sặc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt ba chỉ, tôm, mực, cá basa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt ba chỉ, tôm, mực, cá basa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả băm, tỏi, hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sả băm, tỏi, hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Các loại rau: bông súng, rau đắng, so đũa, bắp chuối');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 20, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Các loại rau: bông súng, rau đắng, so đũa, bắp chuối';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('gạo tấm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, '300g' FROM nguyen_lieu WHERE ten = 'gạo tấm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sườn cốt lết');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, '2 miếng' FROM nguyen_lieu WHERE ten = 'sườn cốt lết';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bì heo, chả trứng hấp');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bì heo, chả trứng hấp';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá làm mỡ hành, nước mắm pha ngọt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 21, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá làm mỡ hành, nước mắm pha ngọt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt heo luộc (hai đầu da)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, '400g' FROM nguyen_lieu WHERE ten = 'thịt heo luộc (hai đầu da)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng cuốn, bánh phở');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bánh tráng cuốn, bánh phở';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm nêm, tỏi, ớt, dứa băm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mắm nêm, tỏi, ớt, dứa băm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống đa dạng: xà lách, dưa leo, khế, chuối chát');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 22, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau sống đa dạng: xà lách, dưa leo, khế, chuối chát';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bánh đa đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '300g' FROM nguyen_lieu WHERE ten = 'bánh đa đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cua đồng tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '400g' FROM nguyen_lieu WHERE ten = 'cua đồng tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('chả lá lốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, '200g' FROM nguyen_lieu WHERE ten = 'chả lá lốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua, hành lá, tôm tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 23, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cà chua, hành lá, tôm tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('mực nang tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, '500g' FROM nguyen_lieu WHERE ten = 'mực nang tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt nạc dăm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, '50g' FROM nguyen_lieu WHERE ten = 'thịt nạc dăm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành khô, tỏi, tiêu, thì là');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành khô, tỏi, tiêu, thì là';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn để chiên ngập dầu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 24, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu ăn để chiên ngập dầu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bún');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bún';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xương bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sả';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mắm ruốc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mắm ruốc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau ăn kèm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 25, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau ăn kèm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cơm nguội');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cơm nguội';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Trứng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Trứng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu Hà Lan');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu Hà Lan';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 26, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt bò');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt bò';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tây');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành tây';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt chuông');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Ớt chuông';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu hào');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu hào';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 27, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt gà');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt gà';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gừng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 28, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tôm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tôm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Me');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Me';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 29, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bí đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bí đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xương heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xương heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 30, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu que');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu que';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tiêu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 31, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tiêu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Tỏi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Tỏi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Rau sống');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Rau sống';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bánh tráng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 32, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bánh tráng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Bột gạo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Bột gạo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thịt heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thịt heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mộc nhĩ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mộc nhĩ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành tím';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước mắm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 33, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước mắm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu xanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu xanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đậu đỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đậu đỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Thạch');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Thạch';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 34, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xoài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xoài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sữa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sữa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Whipping cream');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Whipping cream';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gelatin');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 35, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gelatin';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Chanh');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Chanh';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sả';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước lọc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước lọc';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 36, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('gà ta khoảng 1.3 kg');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, '1 con' FROM nguyen_lieu WHERE ten = 'gà ta khoảng 1.3 kg';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hạt mắc khén, hạt dổi rang thơm giã nhỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hạt mắc khén, hạt dổi rang thơm giã nhỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Sả, ớt, mật ong rừng, muối hạt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 37, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Sả, ớt, mật ong rừng, muối hạt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cá chẽm tươi 700 g');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, '1 con' FROM nguyen_lieu WHERE ten = 'cá chẽm tươi 700 g';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng tươi, đầu hành lá, ớt sừng xắt sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gừng tươi, đầu hành lá, ớt sừng xắt sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Xì dầu thượng hạng, dầu hào, dầu mè');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 38, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Xì dầu thượng hạng, dầu hào, dầu mè';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sườn non heo');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, '400 g' FROM nguyen_lieu WHERE ten = 'sườn non heo';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sấu xanh cạo vỏ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, '5-6 quả' FROM nguyen_lieu WHERE ten = 'sấu xanh cạo vỏ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà chua chín, hành hoa, mùi tàu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 39, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cà chua chín, hành hoa, mùi tàu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt hến tươi đãi sạch');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, '200 g' FROM nguyen_lieu WHERE ten = 'thịt hến tươi đãi sạch';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('hoa thiên lý tươi non');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, '200 g' FROM nguyen_lieu WHERE ten = 'hoa thiên lý tươi non';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Hành tím phi, hạt nêm, tiêu sọ');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 40, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Hành tím phi, hạt nêm, tiêu sọ';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bông bí tươi (búp đực)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, '1 bó' FROM nguyen_lieu WHERE ten = 'bông bí tươi (búp đực)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tỏi đập dập');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, '1 củ' FROM nguyen_lieu WHERE ten = 'tỏi đập dập';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Dầu hào, hạt nêm, dầu ăn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 41, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Dầu hào, hạt nêm, dầu ăn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('ngó sen tươi ngâm giấm đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, '200 g' FROM nguyen_lieu WHERE ten = 'ngó sen tươi ngâm giấm đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tai heo nhỏ luộc giòn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, '1 cái' FROM nguyen_lieu WHERE ten = 'tai heo nhỏ luộc giòn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cà rốt sợi, rau răm, lạc rang, ớt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 42, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cà rốt sợi, rau răm, lạc rang, ớt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bao tử cá ba sa tươi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, '300 g' FROM nguyen_lieu WHERE ten = 'bao tử cá ba sa tươi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('dưa cải muối chua');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, '200 g' FROM nguyen_lieu WHERE ten = 'dưa cải muối chua';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Gừng tươi, cà chua, thì là, hành lá');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 43, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Gừng tươi, cà chua, thì là, hành lá';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('tôm sú tươi bóc nõn');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, '400 g' FROM nguyen_lieu WHERE ten = 'tôm sú tươi bóc nõn';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('mỡ gáy heo luộc thái hạt lựu');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, '50 g' FROM nguyen_lieu WHERE ten = 'mỡ gáy heo luộc thái hạt lựu';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Mía róc vỏ chẻ thanh dài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 44, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Mía róc vỏ chẻ thanh dài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('cà tím dài');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, '2 quả' FROM nguyen_lieu WHERE ten = 'cà tím dài';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('đậu hũ trắng chiên vàng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, '2 miếng' FROM nguyen_lieu WHERE ten = 'đậu hũ trắng chiên vàng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Lá tía tô, lá lốt thái chỉ, tỏi băm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 45, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Lá tía tô, lá lốt thái chỉ, tỏi băm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('sợi hủ tiếu dai sợi mềm');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, '300 g' FROM nguyen_lieu WHERE ten = 'sợi hủ tiếu dai sợi mềm';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('nấm bào ngư xé sợi');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, '150 g' FROM nguyen_lieu WHERE ten = 'nấm bào ngư xé sợi';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Cải ngọt, cà rốt, giá đỗ, nước tương');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 46, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Cải ngọt, cà rốt, giá đỗ, nước tương';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('thịt mãng cầu xiêm xé hạt ngâm đường');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, '200 g' FROM nguyen_lieu WHERE ten = 'thịt mãng cầu xiêm xé hạt ngâm đường';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('trà nhài (lài) ủ lấy cốt');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, '10 g' FROM nguyen_lieu WHERE ten = 'trà nhài (lài) ủ lấy cốt';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('Nước cốt quả tắc (quất), đá viên');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 47, id, 'Không ghi rõ' FROM nguyen_lieu WHERE ten = 'Nước cốt quả tắc (quất), đá viên';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('chuối sứ (chuối xiêm) chín bói');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '6-8 quả' FROM nguyen_lieu WHERE ten = 'chuối sứ (chuối xiêm) chín bói';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('nước cốt dừa');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '150 ml' FROM nguyen_lieu WHERE ten = 'nước cốt dừa';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bánh mì sandwich (hoặc bánh mì giòn)');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '100 g' FROM nguyen_lieu WHERE ten = 'bánh mì sandwich (hoặc bánh mì giòn)';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('bơ lạt đun chảy, 50 g đường vàng');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '50 g' FROM nguyen_lieu WHERE ten = 'bơ lạt đun chảy, 50 g đường vàng';

INSERT IGNORE INTO nguyen_lieu (ten) VALUES ('trứng gà, 1 thìa canh sữa đặc');
INSERT IGNORE INTO mon_an_nguyen_lieu (mon_an_id, nguyen_lieu_id, so_luong) SELECT 48, id, '1 quả' FROM nguyen_lieu WHERE ten = 'trứng gà, 1 thìa canh sữa đặc';



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

-- Phần B - Dòng thành viên của Phan Thị Bảo Hân
INSERT INTO thanh_vien (mssv, ho_ten, nguoi_dung_id) VALUES
  ('3120224045', 'Phan Thị Bảo Hân',
   (SELECT id FROM nguoi_dung WHERE email = 'baohan@cookwithme.com' LIMIT 1));

-- Phần B - Dữ liệu mẫu cho tv_du_an
INSERT INTO tv_du_an (mssv, ten, mo_ta, nam) VALUES
  ('3120224045', 'Website Cook with me',
   'Website chia sẻ công thức nấu ăn của nhóm 04', 2026);

INSERT INTO tv_phien_ban (mssv, ma, ten, ngay, nhom, mo_ta) VALUES
  ('3120224045', 'v1.0', 'Xây dựng giao diện ban đầu', '2026-09-01', 'giao-dien',
   'Hoàn thiện cấu trúc giao diện cơ bản của website.'),
  ('3120224045', 'v1.1', 'Cải thiện chức năng tìm kiếm', '2026-09-10', 'tinh-nang',
   'Cập nhật chức năng tìm kiếm và khám phá công thức.'),
  ('3120224045', 'v1.2', 'Sửa lỗi hiển thị', '2026-09-20', 'sua-loi',
   'Điều chỉnh một số lỗi giao diện trong quá trình kiểm thử.');