-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 05:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leminhtam_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` varchar(10) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`) VALUES
('CAT01', 'Tủ Lạnh'),
('CAT02', 'Máy Giặt'),
('CAT03', 'Máy Lạnh'),
('CAT04', 'Tivi'),
('CAT05', 'Loa'),
('CAT06', 'Tủ Đông'),
('CAT07', 'Tủ Mát'),
('CAT08', 'Lò Vi Sóng'),
('CAT09', 'Quạt'),
('CAT10', 'Nồi Cơm Điện'),
('CAT11', 'Tai Nghe Bluetooth'),
('CAT12', 'Đồ Gia Dụng');

-- --------------------------------------------------------

--
-- Table structure for table `orderrs`
--

CREATE TABLE `orderrs` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `total` int(20) NOT NULL,
  `created_At` datetime NOT NULL DEFAULT current_timestamp(),
  `nameUserr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `productId` varchar(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(20) NOT NULL,
  `created_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` varchar(10) NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(450) NOT NULL,
  `price` int(20) NOT NULL,
  `sale` tinyint(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(10) NOT NULL,
  `categoryId` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`, `description`, `price`, `sale`, `image`, `status`, `categoryId`) VALUES
('PD01', 'ANDROID TIVI CASPER 32 INCH 32HG5200', 'Android Tivi Casper 32 inch 32HG5200 là một sản phẩm tivi thông minh nhỏ gọn, nhưng không kém phần mạnh mẽ và đa chức năng. Với kích thước 32 inch, Tivi Casper 32HG5200 sở hữu màn hình rõ nét và sắc nét, hiển thị hình ảnh chất lượng cao.', 5990000, 33, 'TiviCasper2.jpg', 1, 'CAT04'),
('PD02', 'LOA THÁP SAMSUNG MX-T70', 'Loa tháp Samsung MX-T70 với công suất siêu lớn 1500W hứa hẹn sẽ cho cảm giác nghe khác biệt với những dòng loa cùng phân khúc với công nghệ Bass Booster cho dải âm thanh trầm.Với thiết kế có 2 mặt loa hướng ra hai bên cho cảm giác nghe chân thực nhất có thể.', 7490000, 32, 'LoaThapSamSung.jpg', 1, 'CAT05'),
('PD03', 'LÒ VI SÓNG SHARP 20 LÍT R-G222VN', 'Lò vi sóng Sharp 20 lít R-G222VN có lớp vỏ bạc sáng bóng giúp căn bếp của nhà bạn thêm phần sáng sủa, hiện đại hơn. Kích thước của thiết bị nhỏ gọn, không chiếm quá nhiều diện tích giúp tiết kiệm không gian bếp và dễ dàng vệ sinh.', 2420000, 26, 'LovViSongSharp.jpg', 2, 'CAT08'),
('PD04', 'QUẠT ĐỨNG TOSHIBA F-LSA10(H)VN', 'Quạt đứng Toshiba F-LSA10(H)VN có 5 cánh quạt đường kính 40cm tạo lưu lượng gió mạnh mẽ, kết hợp với công suất hoạt động 50W giúp làm mát hiệu quả trên diện tích rộng. Ngoài ra, bạn có thể điều chỉnh chiều cao thân quạt để nâng cao hiệu quả làm mát.', 1230000, 20, 'QuatDung.jpg', 3, 'CAT09'),
('PD05', 'TỦ ĐÔNG SANAKY INVERTER 220 LÍT VH-2899W4K', 'Tủ đông Sanaky Inverter VH-2899W4K có dung tích 220 lít là một lựa chọn tuyệt vời để bảo quản thực phẩm đông lạnh trong gia đình hoặc nơi làm việc. Tủ được thiết kế nhỏ gọn và tiết kiệm không gian, dễ dàng di chuyển và đặt ở nhiều vị trí khác nhau', 8870000, 7, 'TuDong.jpg', 1, 'CAT06'),
('PD06', 'DÀN KARAOKE DI ĐỘNG ACNOS CS450', 'Dàn karaoke di động Acnos CS450 là một hế thống âm thanh và ánh sáng đa năng được thiết kế mang lại trải nghiệm karaoke chuyên nghiệp  và thú vị cho bất kỳ sự kiện nào.', 9670000, 10, 'DanLoaKaraoke.jpg', 1, 'CAT05'),
('PD07', 'TỦ LẠNH CASPER INVERTER 552 LÍT RS-570VT', 'Tủ lạnh Casper Inverter RS-570VT có dung tích lớn 552 lít, là một lựa chọn hoàn hảo cho gia đình có nhu cầu lớn về bảo quản thực phẩm. Tủ được thiết kế với kiểu dáng sang trọng và hiện đại, phù hợp với mọi không gian nội thất.', 9990000, 43, 'TuLanhCasper.jpg', 1, 'CAT01'),
('PD08', 'BỘ DAO INOX 7 MÓN ELMICH EL3800', 'Bộ dao inox 7 món Elmich EL3800 là bộ dao cao cấp, được làm từ chất liệu inox chất lượng cao, giúp cho việc cắt và chế biến thực phẩm trở nên dễ dàng và hiệu quả. Bộ sản phẩm này bao gồm 7 loại dao khác nhau, phục vụ cho nhiều mục đích nấu ăn và làm việc trong bếp.', 2090000, 24, 'BoDaoKeo.jpg', 1, 'CAT12'),
('PD09', 'BỘ NỒI CHẢO INOX 5 ĐÁY SUNHOUSE SHG995', 'Bộ nồi chảo inox 5 đáy Sunhouse SHG995 là một bộ nồi chảo cao cấp, được làm từ chất liệu inox không gỉ, giúp nấu ăn dễ dàng và hiệu quả. Bộ sản phẩm này bao gồm các nồi và chảo có kích thước và chức năng khác nhau, phù hợp để nấu các món ăn khác nhau trong gia đình.', 1290000, 44, 'BoNoiChao.jpg', 2, 'CAT12'),
('PD10', 'GOOGLE TIVI SONY 4K 55 INCH KD-55X75K VN3', 'Google Tivi Sony 4K 55 inch KD-55X75K VN3 công nghệ 4K X-Reality PRO nâng cấp hình ảnh lên 4K gấp 4 lần với FHD,màn hình sử dụng công nghệ LED nền cho độ tương phản hình ảnh rõ nét,công nghệ tạo màu với Live Color.', 13900000, 20, 'TiviSony.jpg', 1, 'CAT04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `ban_status` tinyint(10) UNSIGNED NOT NULL DEFAULT 1,
  `role` tinyint(10) UNSIGNED NOT NULL DEFAULT 2,
  `created_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `password`, `verify_token`, `ban_status`, `role`, `created_At`) VALUES
(6, 'admin3', 'tamle23122004@gmail.com', '$2y$10$uqXiMN/wrKfJ90PKI15f8OkR1U71N1B5rJM.N.YiDGk6yvUR86TUu', NULL, 1, 1, '2023-08-13 22:34:21'),
(8, 'tamle23122004', 'tamle23122004@gmail.com', '$2y$10$nlXv4OZBLh177RqESuYIwenbbqLKFL7SRBYU6wO85W01X/tsjKNw6', NULL, 1, 2, '2023-08-14 20:37:49'),
(9, 'tamle2312', 'tamle23122004@gmail.com', '$2y$10$C3yJ7TLuCbqFnRr0sKn3Vu9dsvdCIAjRo6rWvdHcFmx5tZiBNS.Gu', NULL, 2, 2, '2023-08-14 20:38:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `orderrs`
--
ALTER TABLE `orderrs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_ibfk_1` (`userId`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_Id_FK` (`productId`),
  ADD KEY `order_id_FK` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderrs`
--
ALTER TABLE `orderrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderrs`
--
ALTER TABLE `orderrs`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_id_FK` FOREIGN KEY (`order_id`) REFERENCES `orderrs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_Id_FK` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
