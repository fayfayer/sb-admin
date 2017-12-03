-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table test.blogs: ~9 rows (approximately)
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` (`id`, `judul`, `isi`, `waktu`, `tag`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'judul pertama kalinya', 'isi content post pertama kalinya juga', '2017-09-02 10:50:31', 'bebas', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(2, 'judul kedua', 'isi kontent post yang kedua', '2017-09-02 10:50:31', 'ekonomi', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(3, 'judul ketiga ya', 'Isi kontent postingan yang ketiga', '2017-09-02 12:07:53', 'terserahlah', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(4, 'judul baru ne ya yang ke 4', 'isi dari judul baru ne ya yang ke 4..!!', '2017-10-04 17:32:51', 'entah lah', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(5, 'judul baru ne ya yang ke 5', 'isi dari judul baru ne ya yang ke 5..!!', '2017-10-04 17:32:58', 'entah lah', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(6, 'judul yang ke 6', 'isi dari judul baru lagi ne ya yang ke 6 ne ya..', '2017-10-04 18:14:50', 'ke_enam 6', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(7, 'judul baru lagi yang ke 7', 'isi dari judul baru lagi ne ya yang ke 7 ne ya..', '2017-10-04 18:15:26', 'ke_enam 6', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(9, 'judul gak baru ke 9', 'isi dari judul baru lagi ne ya yang ke 9 ne ya..', '2017-10-04 18:20:39', 'tag yang ke 9', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(10, 'judul ke 10 queryBuilder', 'isi dari judul yang ke 10 pake queryBuilder ya..', '2017-10-04 19:12:18', '', '2017-10-23 07:23:54', '2017-10-24 03:46:14', NULL),
	(14, 'sedfrwer', 'sdfewefw', '2017-10-24 11:10:35', 'post baru', '2017-10-24 04:10:35', '2017-10-24 04:10:35', NULL),
	(15, '123wer', 'ser ftertwertfertg ergertg3ert', '2017-10-24 11:32:59', 'post baru', '2017-10-24 04:32:59', '2017-10-24 04:32:59', NULL);
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;

-- Dumping data for table test.customers: ~16 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `name`, `age`, `address`, `salary`) VALUES
	(1, 'gojak', 24, 'jalan sederhana', 70000),
	(2, 'budi', 25, 'jalan bengkel/sempurna', 100000),
	(4, 'bambang', 27, 'jalan tambak rejo', 75000),
	(5, 'andooo', 28, 'jalan pasar 5', 100000),
	(6, 'holip', 28, 'jalan ngapakan', 75000),
	(7, 'sali\'jon', 26, 'jalan desa kolam lorong salam', 75000),
	(8, 'muliyono', 30, 'Desa Kolam', 80000),
	(9, 'nanang', 45, 'Jl. tambak rejo', 87000),
	(10, 'nanang', 45, 'Jl. tambak rejo', 87000),
	(11, 'donat', 36, 'Jl. mana aja lah', 87600),
	(13, 'tonet', 32, 'Jl. sana sini juga ya', 76000),
	(14, 'degleng', 27, 'jl. sana juga ya', 78000),
	(15, 'ahm\'att', 35, 'Jl. mana ini ya', 76000),
	(16, 'Bado\'oLLL', 45, 'Jl. makmur', 100000),
	(17, 'zai\'nal', 56, 'jalan kidul', 56000),
	(18, 'Jhon\'y', 34, 'Jalan sempuran (bengkel)', 85500);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping data for table test.employees: ~13 rows (approximately)
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` (`id`, `photo`, `name`, `age`, `address`, `salary`, `genre`, `status`) VALUES
	(1, '', 'gojak', 23, 'jalan sederhana', 70000, 'L', 1),
	(2, 'e774fc896b2ea47a929f4632a4bfed3debe27ef5.png', 'budi', 25, 'jalan bengkel/sempurna', 100000, 'L', 1),
	(3, '7bc02f1796a926389d392e975d456a8759b9a9e6.png', 'hendrik', 36, 'jalan makmur', 85000, 'L', 1),
	(5, '', 'andi', 28, 'jalan pasar 5', 100000, 'L', 1),
	(8, '', 'muliyono', 30, 'Desa Kolam', 80000, 'L', 1),
	(19, '', 'Bado\'ol', 34, 'jalan makmur', 120000, 'L', 1),
	(20, '', 'ahm\'ad', 34, 'Jl. test sana test sini', 340000, 'L', 1),
	(23, '8805a0cb8defbbeb55b97df7887ba50a5ded9ed6.jpg', 'danot', 23, 'Jl. mana aja boleh lah', 76000, 'L', 1),
	(26, '', 'aa\'lif', 34, 'Jl. sana aja kau ya', 76000, 'L', 1),
	(27, '507b9369440f9d4ecbad4961bd178db52f56d9a3.jpg', 'faijo', 25, 'Jl. Pesantren tebu ireng', 76000, 'L', 1),
	(28, 'b499f59ae00325af4b95861986cabafec7744ce9.png', 'Robi\'ah', 24, 'Jl. sama aja dengan jalan rumah mu..', 56000, 'L', 1),
	(30, 'b0c36a8da342e8c5f58e946de26bd1d6e67001bb.jpg', 'Azo ayam', 32, 'Jalan makmur', 78000, 'L', 1),
	(32, '12bd7b203d188348966ec05d039c5ea92afa3c4d.jpg', 'sekolah koding', 23, 'sdfg drthg ret', 23453, 'L', 1);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;

-- Dumping data for table test.employees_copy: ~11 rows (approximately)
/*!40000 ALTER TABLE `employees_copy` DISABLE KEYS */;
INSERT INTO `employees_copy` (`id`, `name`, `age`, `address`, `salary`, `genre`, `status`) VALUES
	(1, 'gojak', 23, 'jalan sederhana', 70000.00, 'L', 1),
	(2, 'budi', 25, 'jalan bengkel/sempurna', 100000.00, 'L', 1),
	(3, 'hendrik', 36, 'jalan makmur', 85000.00, 'L', 1),
	(4, 'bambang', 27, 'jalan tambak rejo', 75000.00, 'L', 1),
	(5, 'andi', 28, 'jalan pasar 5', 100000.00, 'L', 1),
	(6, 'holip', 29, 'jalan ngapakan', 75000.00, 'L', 1),
	(7, 'salijon', 26, 'jalan desa kolam lorong salam', 75000.00, 'L', 1),
	(8, 'muliyono', 30, 'Desa Kolam', 80000.00, 'L', 1),
	(9, 'sarlin\'helen', 33, 'ngapakan wetan', 90000.00, 'L', 1),
	(10, 'dedi', 27, 'jalan makmur dusun kenanga', 70000.00, 'L', 1),
	(11, 'ohoi(edi)', 26, 'jalan sempurna dusun mawar', 72500.00, 'L', 1);
/*!40000 ALTER TABLE `employees_copy` ENABLE KEYS */;

-- Dumping data for table test.orders: ~8 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `date`, `customer_id`, `employee_id`, `amount`) VALUES
	(1, '2017-04-22 00:00:00', 1, 1, 175000),
	(2, '2017-04-21 00:00:00', 2, 1, 170000),
	(3, '2017-04-20 00:00:00', 3, 2, 180000),
	(4, '2017-04-18 00:00:00', 2, 3, 200000),
	(5, '2017-04-17 00:00:00', 4, 4, 190000),
	(6, '2017-04-16 00:00:00', 4, 5, 210000),
	(7, '2017-04-23 00:00:00', 6, 16, 160000),
	(8, '2017-04-24 00:00:00', 7, 8, 165000);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping data for table test.others: ~6 rows (approximately)
/*!40000 ALTER TABLE `others` DISABLE KEYS */;
INSERT INTO `others` (`id`, `date`, `customer_id`, `employee_id`, `amount`) VALUES
	(3, '2017-04-20 00:00:00', 3, 2, 180000),
	(4, '2017-04-18 00:00:00', 2, 3, 200000),
	(5, '2017-04-17 00:00:00', 4, 4, 190000),
	(6, '2017-04-16 00:00:00', 4, 5, 210000),
	(7, '2017-04-23 00:00:00', 6, 16, 160000),
	(8, '2017-04-24 00:00:00', 7, 8, 165000);
/*!40000 ALTER TABLE `others` ENABLE KEYS */;

-- Dumping data for table test.users: ~11 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `photo`, `role`) VALUES
	(1, 'Maman', 'arman', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@test.com', '', 'admin'),
	(2, 'Bambang', 'widodo', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@test.com', 'bebbfd57f7072d886a3a1461168222ba6dc66a3b.png', 'user'),
	(4, 'Nando', 'Pradilo', 'nando_pradilo', '45a9a31e5f1ff59621b681a5edbffe85', 'nando_pardilo@yahoo.com', '0c9b9135b86fff5a78b3f62ebaa20971153b2baf.png', 'user'),
	(7, 'Robert', 'waluyo', 'robert', '684c851af59965b680086b7b4896ff98', 'robert.waluyo@gmail.com', 'de28740cf81e4b24913696ed827910f6e5744735.png', 'user'),
	(8, 'James', 'waluyo', 'james', 'b4cc344d25a2efe540adbf2678e2304c', 'james.waluyo@gmail.com', '9c65135654ecab3e486f24a8e528d0ca19dccb2b.jpg', 'user'),
	(10, 'Dayat', 'waluyo', 'dayat', '1855c11f044cc8944e8cdac9cae5def8', 'dayat.waluyo@gmail.com', '', 'user'),
	(12, 'Belong', 'long', 'belong', 'e455e61aa5220a2673fb5f036c7dbb08', 'belong.long@gmail.com', 'a926ba66eb245d5737ede73ba7f798940fbed0ac.jpg', 'user'),
	(13, 'aaa bbb', 'bbb ccc ddd', 'aaa', '098f6bcd4621d373cade4e832627b4f6', 'aaa.bbb@test.com', '', 'user'),
	(15, 'ccc', 'ddd', 'ccc', '9df62e693988eb4e1e1444ece0578579', 'ccc.ddd@test.com', '7c74dfe432c433e80b600e448546692b1bb83b96.jpg', 'user'),
	(16, 'Boman', 'boiman', 'boman', 'f38d3489cfea6e460f8d61b0d6c2fb9c', 'boman@test.com', 'bfe7db32266fefd4bba8dc18d084b9170dfb6871.jpg', 'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
