
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

-- Tai khoan quan tri cua Phan Thi Bao Han
INSERT INTO nguoi_dung
    (email, ho_ten, mat_khau, vai_tro)
VALUES
    (
        'baohan@cookwithme.com',
        'Phan Thị Bảo Hân',
        '$2y$10$GP1mY/fooY8pymImErMbDOMqRtmy6uQhiWvfm5rre./ljnHp2zZWm',
        'quan_tri'
    );

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


-- ==========================================
-- PHAN B - DU LIEU MAU CUA NGUYEN THI TRINH
-- MSSV: 3120224155
-- ==========================================

-- 1. Tai khoan quan tri cua Nguyen Thi Trinh
INSERT INTO nguoi_dung
    (email, ho_ten, mat_khau, vai_tro)
VALUES
    (
        'ngoctrinh@cookwithme.com',
        'Nguyễn Thị Trinh',
        '$2y$10$kgWqdjLrKOLs15uuJ80U6uz8dVKjKJhZTt.HEtgC9rp8RQ7F/qnbi',
        'quan_tri'
    );

-- 2. Thong tin thanh vien va lien ket tai khoan
INSERT INTO thanh_vien
    (mssv, ho_ten, nguoi_dung_id)
VALUES
    (
        '3120224155',
        'Nguyễn Thị Trinh',
        (
            SELECT id
            FROM nguoi_dung
            WHERE email = 'ngoctrinh@cookwithme.com'
            LIMIT 1
        )
    );

-- 3. Du lieu mau so luu but
INSERT INTO tv_trinh_luu_but
    (mssv, ten_khach, loi_nhan)
VALUES
    (
        '3120224155',
        'Nguyễn Văn An',
        'Chúc bạn học tốt và có nhiều công thức nấu ăn hay!'
    ),
    (
        '3120224155',
        'Trần Thị Mai',
        'Cảm ơn bạn đã chia sẻ những món ăn ngon.'
    ),
    (
        '3120224155',
        'Lê Minh',
        'Mong bạn tiếp tục chia sẻ thêm nhiều công thức mới.'
    );

-- 4. Du lieu mau luot xem theo ngay
INSERT INTO tv_trinh_luot_xem
    (mssv, ngay, so_luot)
VALUES
    ('3120224155', '2026-10-25', 8),
    ('3120224155', '2026-10-26', 12),
    ('3120224155', '2026-10-27', 5);

-- ==========================================
-- PHAN B - DU LIEU MAU NGUYEN THI NGOC BINH
-- MSSV: 3120224013
-- ==========================================
-- Tai khoan quan tri cua Nguyen Thi Ngoc Binh
INSERT INTO nguoi_dung
    (email, ho_ten, mat_khau, vai_tro)
VALUES
    (
        'ngocbinh@cookwithme.com',
        'Nguyễn Thị Ngọc Bình',
        '$2y$10$Hsxn4Ac.liKJFTLQcKdkP.9KDZLjbEankdQm3qu8e7j7sWx52ffRm',
        'quan_tri'
    );
-- 1. Them thong tin thanh vien Binh
INSERT INTO thanh_vien (mssv, ho_ten, nguoi_dung_id)
VALUES (
    '3120224013',
    'Nguyễn Thị Ngọc Bình',
    (
        SELECT id FROM nguoi_dung
        WHERE email = 'ngocbinh@cookwithme.com'
        LIMIT 1
    )
);

-- 2. Danh gia mon Banh xeo - 5 sao
INSERT INTO tv_binh_danh_gia
(mssv, mon_an_id, so_sao, nhan_xet)
SELECT '3120224013', id, 5,
       'Món ăn ngon, dễ thực hiện và phù hợp với gia đình.'
FROM mon_an
WHERE slug = 'banh-xeo';

-- 3. Danh gia mon Cao lau - 4 sao
INSERT INTO tv_binh_danh_gia
(mssv, mon_an_id, so_sao, nhan_xet)
SELECT '3120224013', id, 4,
       'Hương vị đậm đà, nguyên liệu dễ chuẩn bị.'
FROM mon_an
WHERE slug = 'cao-lau';

-- 4. Danh gia mon Pho bo - 5 sao
INSERT INTO tv_binh_danh_gia
(mssv, mon_an_id, so_sao, nhan_xet)
SELECT '3120224013', id, 5,
       'Món ăn hấp dẫn, rất đáng thử.'
FROM mon_an
WHERE slug = 'pho-bo';

-- ==========================================
-- TAI KHOAN QUAN TRI CUA LE THI A NA
-- ==========================================

INSERT INTO nguoi_dung
    (email, ho_ten, mat_khau, vai_tro)
VALUES
    (
        'ana@cookwithme.com',
        'Lê Thị A Na',
        '$2y$10$xyQfcZRcRIucwB7j3MIMkuGFSY4XC2hrBQDKyc03rdElqOJw1ew96',
        'quan_tri'
    );

-- Phần B - Thông tin thành viên của Lê Thị A Na
INSERT INTO thanh_vien (mssv, ho_ten, nguoi_dung_id)
VALUES (
    '3120224096',
    'Lê Thị A Na',
    (
        SELECT id
        FROM nguoi_dung
        WHERE email = 'ana@cookwithme.com'
        LIMIT 1
    )
);

-- Phần B - Dự án cá nhân của Lê Thị A Na
INSERT INTO tv_du_an_ca_nhan
    (mssv, ten_du_an, cong_nghe, trang_thai, mo_ta)
VALUES
    (
        '3120224096',
        'Website Cook with me',
        'HTML, CSS, JavaScript, PHP, MySQL',
        'Đang thực hiện',
        'Xây dựng website chia sẻ công thức nấu ăn, hỗ trợ tìm kiếm món ăn và quản lý danh sách đi chợ.'
    );

-- ==========================================
-- CHUC NANG 5 - DU LIEU MAU DANH SACH DI CHO
-- ==========================================

-- 1. Tao danh sach di cho cho Nguyen Thi Lan
INSERT INTO danh_sach_di_cho (nguoi_dung_id)
SELECT id
FROM nguoi_dung
WHERE email = 'lan@ued.vn';

-- 2. Them mon an vao danh sach di cho cua Lan
INSERT INTO chi_tiet_di_cho
    (danh_sach_id, mon_an_id, so_suat)
SELECT ds.id, ma.id, 2
FROM danh_sach_di_cho ds
JOIN nguoi_dung nd
    ON nd.id = ds.nguoi_dung_id
JOIN mon_an ma
    ON ma.slug = 'cao-lau'
WHERE nd.email = 'lan@ued.vn';

INSERT INTO chi_tiet_di_cho
    (danh_sach_id, mon_an_id, so_suat)
SELECT ds.id, ma.id, 1
FROM danh_sach_di_cho ds
JOIN nguoi_dung nd
    ON nd.id = ds.nguoi_dung_id
JOIN mon_an ma
    ON ma.slug = 'banh-xeo'
WHERE nd.email = 'lan@ued.vn';


-- 3. Tao lich su di cho cho Tran Van An
INSERT INTO lan_di_cho
    (nguoi_dung_id, ngay_chot, trang_thai)
SELECT id, '2026-11-05 08:00:00', 'da_di_cho'
FROM nguoi_dung
WHERE email = 'an@ued.vn';


-- 4. Luu chi tiet mon an trong lich su
INSERT INTO chi_tiet_lan_di_cho
    (lan_id, mon_an_id, ten_mon, so_suat, ngan_sach_tham_khao)
SELECT
    ld.id,
    ma.id,
    ma.ten,
    2,
    ma.ngan_sach
FROM lan_di_cho ld
JOIN nguoi_dung nd
    ON nd.id = ld.nguoi_dung_id
JOIN mon_an ma
    ON ma.slug = 'cao-lau'
WHERE nd.email = 'an@ued.vn'
  AND ld.ngay_chot = '2026-11-05 08:00:00';

INSERT INTO chi_tiet_lan_di_cho
    (lan_id, mon_an_id, ten_mon, so_suat, ngan_sach_tham_khao)
SELECT
    ld.id,
    ma.id,
    ma.ten,
    1,
    ma.ngan_sach
FROM lan_di_cho ld
JOIN nguoi_dung nd
    ON nd.id = ld.nguoi_dung_id
JOIN mon_an ma
    ON ma.slug = 'banh-xeo'
WHERE nd.email = 'an@ued.vn'
  AND ld.ngay_chot = '2026-11-05 08:00:00';

  -- Món kiểm thử Chef's Special chưa có nguyên liệu.
-- Chưa bổ sung nguyên liệu vì đây là dữ liệu kiểm thử.

-- Du lieu bo sung tu ban sao luu ltweb_nhom04.sql
-- Chi bo sung huong dan nau va lien he; khong nhap lai mon_an/nguyen_lieu
-- Vi seed.sql hien tai da co 217 lien ket nguyen lieu.
-- Du lieu buoc nau tham chieu mon_an_id 1-48; khong bao gom mon kiem thu Chef's Special.

INSERT INTO buoc_nau (`id`, `mon_an_id`, `thu_tu`, `noi_dung`) VALUES
(1, 1, 1, 'Sơ chế và làm sạch các nguyên liệu.'),
(2, 1, 2, 'Ướp thịt với nước tương, mật ong, ngũ vị hương và gia vị.'),
(3, 1, 3, 'Chế biến thịt xá xíu đến khi chín mềm.'),
(4, 1, 4, 'Chần sợi cao lầu và để ráo.'),
(5, 1, 5, 'Cho sợi cao lầu, thịt xá xíu và rau sống vào tô rồi thưởng thức.'),
(6, 2, 1, 'Làm sạch cá và cắt thành từng khúc vừa ăn.'),
(7, 2, 2, 'Ướp cá với nước mắm và gia vị.'),
(8, 2, 3, 'Phi thơm tỏi rồi cho cá vào kho.'),
(9, 2, 4, 'Kho cá với lửa nhỏ đến khi nước sốt sánh lại.'),
(10, 2, 5, 'Nêm nếm và hoàn thiện món ăn.'),
(11, 3, 1, 'Sơ chế và ngâm ngó sen.'),
(12, 3, 2, 'Cắt nhỏ cà rốt và rau thơm.'),
(13, 3, 3, 'Pha nước trộn gỏi.'),
(14, 3, 4, 'Trộn đều các nguyên liệu với nước trộn.'),
(15, 3, 5, 'Trang trí và thưởng thức.'),
(16, 4, 1, 'Pha bột bánh xèo với nước.'),
(17, 4, 2, 'Sơ chế tôm, thịt và rau củ.'),
(18, 4, 3, 'Làm nóng chảo và cho một lớp bột mỏng vào chảo.'),
(19, 4, 4, 'Thêm tôm, thịt và giá đỗ rồi chiên giòn.'),
(20, 4, 5, 'Gấp bánh lại và dùng với rau sống.'),
(21, 5, 1, 'Sơ chế thịt, tôm và rau sống.'),
(22, 5, 2, 'Nấu nước dùng từ thịt và gia vị.'),
(23, 5, 3, 'Xào thịt và tôm.'),
(24, 5, 4, 'Trụng mì Quảng.'),
(25, 5, 5, 'Cho mì vào tô, thêm nhân, rau sống và nước dùng.'),
(26, 6, 1, 'Sơ chế xương và thịt bò.'),
(27, 6, 2, 'Ninh xương để tạo nước dùng.'),
(28, 6, 3, 'Nướng hoặc rang các loại gia vị thơm.'),
(29, 6, 4, 'Nấu nước dùng cùng gia vị.'),
(30, 6, 5, 'Trụng bánh phở, xếp thịt bò và chan nước dùng.'),
(31, 7, 1, 'Sơ chế cá và rau củ.'),
(32, 7, 2, 'Phi thơm tỏi rồi xào cà chua.'),
(33, 7, 3, 'Thêm nước và đun sôi.'),
(34, 7, 4, 'Cho cá vào nấu chín.'),
(35, 7, 5, 'Thêm rau và nêm nếm vừa ăn.'),
(36, 8, 1, 'Nhặt và rửa sạch rau muống.'),
(37, 8, 2, 'Băm nhỏ tỏi.'),
(38, 8, 3, 'Phi thơm tỏi với dầu.'),
(39, 8, 4, 'Cho rau muống vào xào nhanh trên lửa lớn.'),
(40, 8, 5, 'Nêm gia vị và hoàn thiện món ăn.'),
(41, 9, 1, 'Sơ chế và cắt nhỏ các nguyên liệu.'),
(42, 9, 2, 'Trộn thịt với rau củ và gia vị.'),
(43, 9, 3, 'Cuốn nhân bằng bánh tráng.'),
(44, 9, 4, 'Chiên chả giò đến khi vàng giòn.'),
(45, 9, 5, 'Vớt ra để ráo dầu và thưởng thức.'),
(46, 10, 1, 'Gọt vỏ và cắt xoài.'),
(47, 10, 2, 'Cho xoài vào máy xay.'),
(48, 10, 3, 'Thêm sữa tươi và đá viên.'),
(49, 10, 4, 'Xay nhuyễn hỗn hợp.'),
(50, 10, 5, 'Rót ra ly và thưởng thức.'),
(51, 11, 1, 'Ngâm đậu xanh.'),
(52, 11, 2, 'Rửa sạch và nấu đậu đến khi mềm.'),
(53, 11, 3, 'Thêm đường và khuấy đều.'),
(54, 11, 4, 'Nấu thêm vài phút cho chè thấm vị.'),
(55, 11, 5, 'Thêm nước cốt dừa và thưởng thức.'),
(56, 12, 1, 'Cắt đậu hũ thành miếng vừa ăn.'),
(57, 12, 2, 'Chiên đậu hũ vàng nhẹ.'),
(58, 12, 3, 'Băm nhỏ cà chua và tỏi.'),
(59, 12, 4, 'Nấu sốt cà chua rồi cho đậu hũ vào.'),
(60, 12, 5, 'Nêm nước tương và hoàn thiện món ăn.'),
(61, 13, 1, 'Pha bột bánh xèo với nước cốt dừa và bột nghệ.'),
(62, 13, 2, 'Xào thịt và tôm làm nhân.'),
(63, 13, 3, 'Đổ bánh mỏng vào chảo nóng cho giòn vàng.'),
(64, 13, 4, 'Cuốn bánh với rau sống và thưởng thức.'),
(65, 14, 1, 'Luộc hến lấy nước dùng và đãi lấy thịt hến.'),
(66, 14, 2, 'Xào thịt hến với gia vị và hành tỏi.'),
(67, 14, 3, 'Trộn cơm nguội với hến, rau sống, bắp chuối thái nhỏ.'),
(68, 14, 4, 'Chan nước hến luộc và thêm mắm ruốc khi ăn.'),
(69, 15, 1, 'Hầm xương heo lấy nước dùng ngọt thanh.'),
(70, 15, 2, 'Luộc sợi hủ tiếu và chuẩn bị thịt heo, tôm, trứng cút.'),
(71, 15, 3, 'Xếp topping lên tô và chan nước dùng nóng hổi.'),
(72, 16, 1, 'Nấu nước dùng từ xương cá hoặc thịt.'),
(73, 16, 2, 'Chiên hoặc hấp chả cá rồi cắt lát vừa ăn.'),
(74, 16, 3, 'Trần bánh canh qua nước sôi rồi cho vào tô.'),
(75, 16, 4, 'Chan nước dùng và đặt chả cá lên trên.'),
(76, 17, 1, 'Cắt đậu hũ thành từng miếng nhỏ rồi rán vàng giòn.'),
(77, 17, 2, 'Luộc thịt ba chỉ thái mỏng.'),
(78, 17, 3, 'Pha mắm tôm với đường, quất, ớt và dầu nóng.'),
(79, 17, 4, 'Bày bún, đậu, thịt, chả cốm và rau sống ra mẹt.'),
(80, 18, 1, 'Sơ chế cá trích lấy phần phi lê thịt tươi.'),
(81, 18, 2, 'Trộn cá với nước cốt chanh, hành tây và dừa nạo.'),
(82, 18, 3, 'Pha nước chấm chua ngọt cay đặc trưng.'),
(83, 19, 1, 'Pha bột bánh khọt đổ vào khuôn nhỏ.'),
(84, 19, 2, 'Đặt tôm tươi lên giữa bánh khi đổ.'),
(85, 19, 3, 'Đậy nắp đến khi bánh chín giòn cạnh thì lấy ra.'),
(86, 19, 4, 'Ăn kèm rau sống và nước mắm chua ngọt.'),
(87, 20, 1, 'Nấu mắm cá linh hoặc mắm cá sặc rồi lọc bỏ xương.'),
(88, 20, 2, 'Phi sả ớt thơm rồi cho nước mắm vào nấu thành nước lẩu.'),
(89, 20, 3, 'Chuẩn bị các loại hải sản, thịt ba chỉ và rổ rau đồng phong phú.'),
(90, 21, 1, 'Nấu chín cơm tấm.'),
(91, 21, 2, 'Ướp sườn với nước mắm, mật ong, hành tỏi rồi nướng chín thơm.'),
(92, 21, 3, 'Làm mỡ hành và pha nước mắm chua ngọt.'),
(93, 21, 4, 'Bày cơm, sườn, chả, mỡ hành ra đĩa.'),
(94, 22, 1, 'Luộc thịt heo chín tới để giữ độ giòn của da.'),
(95, 22, 2, 'Thái thịt thành các lát mỏng dài.'),
(96, 22, 3, 'Pha mắm nêm đậm đà với tỏi ớt băm.'),
(97, 22, 4, 'Cuốn thịt cùng bánh tráng, rau sống và dưa leo.'),
(98, 23, 1, 'Lọc thịt cua đồng nấu lấy gạch và nước dùng đậm đà.'),
(99, 23, 2, 'Trần bánh đa đỏ qua nước sôi.'),
(100, 23, 3, 'Làm chả lá lốt và chuẩn bị các loại topping.'),
(101, 23, 4, 'Chan nước dùng cua nóng vào tô bánh đa.'),
(102, 24, 1, 'Làm sạch mực tươi, giã nhuyễn thủ công để tạo độ dai.'),
(103, 24, 2, 'Trộn mực với thì là, tiêu và gia vị vừa ăn.'),
(104, 24, 3, 'Nặn thành từng miếng tròn rồi chiên vàng ngập dầu.'),
(105, 25, 1, 'Rửa sạch xương bò và hầm với nước trong khoảng 1–2 giờ.'),
(106, 25, 2, 'Sả đập dập, cho vào nồi nước dùng để tạo mùi thơm.'),
(107, 25, 3, 'Phi thơm tỏi, cho mắm ruốc và gia vị vào xào.'),
(108, 25, 4, 'Cho hỗn hợp gia vị vào nồi nước dùng và nêm nếm vừa ăn.'),
(109, 25, 5, 'Luộc thịt bò, thái lát mỏng.'),
(110, 25, 6, 'Trụng bún, cho vào tô cùng thịt bò và rau ăn kèm.'),
(111, 25, 7, 'Chan nước dùng nóng và thưởng thức.'),
(112, 26, 1, 'Chuẩn bị cơm nguội, để cơm tơi và không bị vón cục.'),
(113, 26, 2, 'Đánh tan trứng rồi chiên sơ.'),
(114, 26, 3, 'Phi thơm tỏi với dầu ăn.'),
(115, 26, 4, 'Cho thịt và đậu Hà Lan vào xào chín.'),
(116, 26, 5, 'Cho cơm vào đảo đều trên lửa lớn.'),
(117, 26, 6, 'Thêm trứng, nước tương và gia vị rồi đảo đều.'),
(118, 26, 7, 'Chiên đến khi cơm săn và tơi thì tắt bếp.'),
(119, 27, 1, 'Thịt bò rửa sạch, cắt thành từng miếng vuông vừa ăn.'),
(120, 27, 2, 'Ướp thịt bò với nước tương, dầu hào, tỏi và tiêu.'),
(121, 27, 3, 'Hành tây và ớt chuông cắt miếng vừa ăn.'),
(122, 27, 4, 'Làm nóng chảo với dầu ăn.'),
(123, 27, 5, 'Cho thịt bò vào áp chảo trên lửa lớn.'),
(124, 27, 6, 'Thêm hành tây và ớt chuông rồi đảo nhanh tay.'),
(125, 27, 7, 'Nêm lại gia vị và tắt bếp.'),
(126, 28, 1, 'Thịt gà rửa sạch, chặt thành miếng vừa ăn.'),
(127, 28, 2, 'Gừng rửa sạch, thái sợi hoặc thái lát mỏng.'),
(128, 28, 3, 'Ướp gà với nước tương, đường, tỏi và tiêu.'),
(129, 28, 4, 'Phi thơm tỏi và gừng.'),
(130, 28, 5, 'Cho gà vào đảo đến khi săn lại.'),
(131, 28, 6, 'Thêm nước và kho với lửa nhỏ đến khi thịt gà chín mềm.'),
(132, 28, 7, 'Nêm lại gia vị rồi tắt bếp.'),
(133, 29, 1, 'Tôm làm sạch, bỏ chỉ lưng và để ráo.'),
(134, 29, 2, 'Me ngâm với nước ấm rồi lọc lấy nước cốt.'),
(135, 29, 3, 'Phi thơm tỏi với dầu ăn.'),
(136, 29, 4, 'Cho tôm vào rang đến khi chuyển màu.'),
(137, 29, 5, 'Thêm nước cốt me, đường và nước mắm.'),
(138, 29, 6, 'Đảo đều đến khi nước sốt sánh lại.'),
(139, 29, 7, 'Thêm ớt và nêm lại gia vị rồi tắt bếp.'),
(140, 30, 1, 'Xương heo rửa sạch và chần qua nước sôi.'),
(141, 30, 2, 'Cho xương vào nồi cùng nước và hầm đến khi mềm.'),
(142, 30, 3, 'Bí đỏ gọt vỏ, bỏ hạt và cắt miếng vừa ăn.'),
(143, 30, 4, 'Cho bí đỏ vào nồi nước hầm xương.'),
(144, 30, 5, 'Nấu đến khi bí đỏ chín mềm.'),
(145, 30, 6, 'Nêm gia vị vừa ăn.'),
(146, 30, 7, 'Thêm hành lá và tiêu rồi tắt bếp.'),
(147, 31, 1, 'Đậu que tước xơ, rửa sạch và cắt khúc.'),
(148, 31, 2, 'Tỏi bóc vỏ và băm nhỏ.'),
(149, 31, 3, 'Đun nóng dầu ăn rồi phi thơm tỏi.'),
(150, 31, 4, 'Cho đậu que vào xào trên lửa lớn.'),
(151, 31, 5, 'Thêm nước tương và gia vị.'),
(152, 31, 6, 'Xào đến khi đậu vừa chín nhưng vẫn giữ độ giòn.'),
(153, 31, 7, 'Rắc tiêu rồi tắt bếp.'),
(154, 32, 1, 'Thịt heo xay nhuyễn rồi trộn với tỏi và gia vị.'),
(155, 32, 2, 'Ướp thịt khoảng 30 phút.'),
(156, 32, 3, 'Vo thịt thành từng viên hoặc quấn quanh que.'),
(157, 32, 4, 'Nướng nem trên bếp đến khi chín vàng.'),
(158, 32, 5, 'Chuẩn bị rau sống và bánh tráng.'),
(159, 32, 6, 'Cuốn nem cùng rau và chấm với nước chấm.'),
(160, 33, 1, 'Ngâm bột gạo và pha thành hỗn hợp bột loãng.'),
(161, 33, 2, 'Thịt heo băm nhỏ, mộc nhĩ ngâm mềm rồi thái nhỏ.'),
(162, 33, 3, 'Phi hành tím rồi xào thịt và mộc nhĩ.'),
(163, 33, 4, 'Tráng một lớp bột mỏng trên nồi hấp.'),
(164, 33, 5, 'Cho nhân vào giữa bánh rồi cuộn lại.'),
(165, 33, 6, 'Làm lần lượt đến khi hết bột và nhân.'),
(166, 33, 7, 'Dùng bánh cuốn nóng với nước mắm.'),
(167, 34, 1, 'Đậu xanh và đậu đỏ ngâm nước cho mềm.'),
(168, 34, 2, 'Nấu riêng từng loại đậu đến khi chín mềm.'),
(169, 34, 3, 'Thêm đường và nấu đến khi đậu thấm vị.'),
(170, 34, 4, 'Thạch cắt thành từng miếng nhỏ.'),
(171, 34, 5, 'Cho lần lượt đậu xanh, đậu đỏ và thạch vào ly.'),
(172, 34, 6, 'Thêm nước cốt dừa và đá.'),
(173, 34, 7, 'Trộn đều trước khi thưởng thức.'),
(174, 35, 1, 'Xoài gọt vỏ, cắt nhỏ và xay nhuyễn.'),
(175, 35, 2, 'Ngâm gelatin trong nước lạnh cho mềm.'),
(176, 35, 3, 'Đun sữa tươi, whipping cream và đường trên lửa nhỏ.'),
(177, 35, 4, 'Cho gelatin vào hỗn hợp nóng và khuấy tan.'),
(178, 35, 5, 'Đổ hỗn hợp vào khuôn.'),
(179, 35, 6, 'Để nguội rồi cho vào tủ lạnh khoảng 3 giờ.'),
(180, 35, 7, 'Thêm xoài xay lên trên trước khi thưởng thức.'),
(181, 36, 1, 'Sả rửa sạch, đập dập và cắt khúc.'),
(182, 36, 2, 'Đun sả với nước khoảng 10 phút.'),
(183, 36, 3, 'Lọc bỏ xác sả và để nước nguội.'),
(184, 36, 4, 'Vắt chanh lấy nước cốt.'),
(185, 36, 5, 'Cho nước chanh và đường vào nước sả rồi khuấy đều.'),
(186, 36, 6, 'Thêm đá viên.'),
(187, 36, 7, 'Trang trí bằng lát chanh và sả rồi thưởng thức.'),
(188, 37, 1, 'Mổ phanh gà, làm sạch và dùng xiên xăm nhẹ lên da để thấm gia vị.'),
(189, 37, 2, 'Xát đều hỗn hợp hạt mắc khén, hạt dổi, sả ớt băm và muối hạt quanh thân gà.'),
(190, 37, 3, 'Ướp ít nhất 40 phút cho ngấm sâu vào từng thớ thịt.'),
(191, 37, 4, 'Nướng trên than hoa hoặc nồi chiên không dầu ở 180 độ C, quét mật ong ở những phút cuối.'),
(192, 38, 1, 'Đánh vảy cá sạch, khía xéo hai bên thân và ướp với chút hạt nêm, tiêu.'),
(193, 38, 2, 'Lót gừng và hành dưới đĩa, đặt cá lên và hấp cách thủy trong 15 phút.'),
(194, 38, 3, 'Pha sốt gồm xì dầu, dầu hào, đường và chút nước hấp cá đun sôi.'),
(195, 38, 4, 'Xếp hành sợi lên mình cá, rưới dầu nóng cho dậy mùi rồi chan đều sốt xì dầu.'),
(196, 39, 1, 'Chặt khúc sườn, chần sơ nước sôi rồi rửa sạch để nước canh không bị đục.'),
(197, 39, 2, 'Ninh sườn với nước trên lửa vừa khoảng 20 phút cho mềm.'),
(198, 39, 3, 'Thả sấu và cà chua bổ múi cau vào đun sôi tiếp 10 phút đến khi sấu chín mềm.'),
(199, 39, 4, 'Dầm sấu lấy vị chua thanh vừa ý, nêm gia vị rồi rắc hành hoa, mùi tàu.'),
(200, 40, 1, 'Hoa thiên lý nhặt cuống già, rửa sạch nhẹ tay và vớt ra để ráo nước.'),
(201, 40, 2, 'Phi thơm hành tím, xào săn thịt hến với chút hạt nêm và tiêu.'),
(202, 40, 3, 'Đun sôi nước luộc hến (đã gạn trong) hoặc nước dùng, trút hến đã xào vào.'),
(203, 40, 4, 'Nước sôi bùng thả hoa thiên lý vào nấu nhanh 1 phút cho vừa chín giòn rồi tắt bếp.'),
(204, 41, 1, 'Tước xơ cọng bí, ngắt bỏ nhụy đắng bên trong bông rồi rửa nhẹ nhàng.'),
(205, 41, 2, 'Chần thật nhanh qua nước sôi có chút muối rồi vớt ngay ra rổ ráo.'),
(206, 41, 3, 'Làm nóng chảo với nhiều dầu ăn, phi thơm tỏi đập dập trên lửa lớn.'),
(207, 41, 4, 'Cho bông bí vào xào đảo thật nhanh tay với dầu hào trong 2 phút rồi bày ra đĩa.'),
(208, 42, 1, 'Tai heo luộc chín tới, ngâm đá lạnh cho giòn rồi thái lát thật mỏng.'),
(209, 42, 2, 'Ngó sen chẻ mỏng vắt nhẹ cho ráo nước; cà rốt bóp sơ chút muối.'),
(210, 42, 3, 'Pha nước mắm chua ngọt hài hòa từ chanh, tỏi băm, ớt và đường cát.'),
(211, 42, 4, 'Trộn đều tai heo, ngó sen, cà rốt với nước sốt, rắc rau răm và lạc rang giã dập.'),
(212, 43, 1, 'Bóp muối và giấm thật kỹ để khử tanh bao tử cá, luộc sơ với gừng rồi rửa sạch.'),
(213, 43, 2, 'Phi thơm gừng tỏi băm, cho bao tử cá vào xào săn lửa lớn rồi trút riêng ra.'),
(214, 43, 3, 'Xào mềm cà chua và dưa chua cho ngấm gia vị.'),
(215, 43, 4, 'Trút bao tử cá lại vào chảo đảo đều tay 2 phút, thêm thì là, hành lá rồi tắt bếp.'),
(216, 44, 1, 'Giã nhuyễn quết dai tôm với mỡ phần, lòng trắng trứng, hạt tiêu và hành tím.'),
(217, 44, 2, 'Thoa dầu lên tay, bọc một lớp chả tôm thật đều quanh từng khúc mía.'),
(218, 44, 3, 'Hấp cách thủy khoảng 5 phút để định hình que chạo.'),
(219, 44, 4, 'Nướng chạo trên than hoa hoặc chiên vàng đều mặt, dùng kèm rau sống bánh hỏi.'),
(220, 45, 1, 'Cà tím cắt khúc con chì ngâm nước muối loãng cho khỏi thâm, vớt ráo chiên sơ.'),
(221, 45, 2, 'Đậu hũ cắt vuông chiên vàng giòn các mặt.'),
(222, 45, 3, 'Xào cà chua với tương hột băm, trút cà tím và đậu hũ vào cùng nửa bát nước.'),
(223, 45, 4, 'Om lửa nhỏ 10 phút cho ngấm sốt, rắc tía tô và lá lốt thái nhỏ trước khi múc ra.'),
(224, 46, 1, 'Áp chảo sợi hủ tiếu với chút hắc xì dầu trên lửa lớn cho cháy cạnh thơm lừng.'),
(225, 46, 2, 'Xào săn nấm bào ngư, cà rốt và cải ngọt với sốt dầu hào chay.'),
(226, 46, 3, 'Trút hủ tiếu và giá đỗ vào chảo rau đảo thật đều tay trong 2 phút.'),
(227, 46, 4, 'Nêm thêm chút hạt tiêu sọ và dọn ra đĩa ăn kèm ớt ngâm chua ngọt.'),
(228, 47, 1, 'Ủ trà nhài với nước nóng 85 độ C trong 10 phút rồi lọc lấy cốt trà để nguội.'),
(229, 47, 2, 'Cho mãng cầu ngâm đường và nước cốt tắc vào ly dầm nhẹ.'),
(230, 47, 3, 'Thêm nước trà nhài và siro đường theo khẩu vị mong muốn.'),
(231, 47, 4, 'Thêm đầy đá viên vào ly và lắc đều trước khi thưởng thức.'),
(232, 48, 1, 'Chuối bóc vỏ, cắt lát tròn xéo; ướp với 2 thìa đường và chút rượu thơm khoảng 20 phút.'),
(233, 48, 2, 'Bánh mì xé nhỏ, trộn cùng nước cốt dừa, bơ lạt, sữa đặc và trứng gà đánh tan cho bánh mì ngấm mềm.'),
(234, 48, 3, 'Lót giấy nến vào khuôn nướng, xếp một lớp chuối ở đáy, đổ hỗn hợp bánh mì vào rồi xếp thêm một lớp chuối phủ kín mặt trên.'),
(235, 48, 4, 'Làm nóng nồi chiên không dầu/lò nướng ở 160 độ C, nướng bánh trong khoảng 45-50 phút đến khi mặt bánh chín vàng nâu óng ả.'),
(236, 48, 5, 'Lấy bánh ra để nguội hoàn toàn cho bánh se mặt, dẻo ngon rồi cắt miếng vừa ăn.');

INSERT INTO lien_he (`id`, `nguoi_dung_id`, `ho_ten`, `email`, `noi_dung`, `hinh_anh`, `ngay_gui`) VALUES
(1, NULL, 'Nguyễn Văn Test', 'test@example.com', 'Chủ đề: gop-y\n\n- Kiểm tra chức năng gửi liên hệ và lưu dữ liệu vào MySQL.', NULL, '2026-10-25 11:59:11'),
(2, NULL, 'Nguyễn Thị Ngọc', 'ngocbinh200706@gmail.com', 'Chủ đề: gop-y\n\nquá oke ròii', NULL, '2026-10-25 14:17:43'),
(3, NULL, 'Nguyễn Thị Ngọc', 'ngocbinh200706@gmail.com', 'Chủ đề: gop-y\n\ntest thử nheeeee', 'e70c7ea96fe3b4ea96144661f3fd1e36.png', '2026-10-25 15:28:46');
