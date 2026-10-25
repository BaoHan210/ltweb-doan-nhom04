-- Nguyen lieu da tach ten va so luong
SET NAMES utf8mb4;
USE ltweb_nhom04;

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

