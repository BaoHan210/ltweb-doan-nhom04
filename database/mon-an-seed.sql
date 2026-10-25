-- Du lieu mon an tu mon-an.json
SET NAMES utf8mb4;
USE ltweb_nhom04;


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

