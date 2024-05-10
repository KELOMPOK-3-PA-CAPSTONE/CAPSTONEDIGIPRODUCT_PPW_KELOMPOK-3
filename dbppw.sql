-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 01:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbppw`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `image`, `quantity`) VALUES
(59, 0, 'Food & Beverages', 20, 'kuliner.jpg', 1),
(145, 12, 'kuliner', 20, 'kulinerp.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(11, 4, 'kayla', 'kayla11virrly@gmail.com', '23', 'rfdv'),
(14, 2, 'Iqoh andini', 'abc@gmail.com', '000000000000', 's'),
(17, 11, 'SU', 'aufa.trihapsari@gmail.com', '099999999999', 'a'),
(18, 11, 'SU', 'aufa.trihapsari@gmail.com', '099999999999', 'a'),
(19, 11, 'SU', 'aufa.trihapsari@gmail.com', '099999999999', 'a'),
(20, 11, 'SU', 'aufa.trihapsari@gmail.com', '099999999999', 'a'),
(21, 11, 'SU', 'aufa.trihapsari@gmail.com', '099999999999', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` text DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `total_price` int(100) DEFAULT NULL,
  `placed_on` varchar(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_name`, `method`, `city`, `address`, `total_price`, `placed_on`, `payment_status`) VALUES
(54, 2, 'Barista', 'Shoppeepay', 'balikpapan', 'Jl.Pramuka', 30, '09-May-2024', 'completed'),
(55, 2, 'Petshop', 'linkaja', 'balikpapan', 'Jl.Pramuka', 50, '09-May-2024', 'completed'),
(56, 2, 'kuliner', 'linkaja', 'Anand', 'Jl.Pramuka', 20, '09-May-2024', 'completed'),
(57, 2, 'Fashion', 'linkaja', 'balikpapan', 'Jl.Pramuka', 15, '09-May-2024', 'pending'),
(60, 2, 'Furniture', 'linkaja', 'balikpapan', 'Jl.Pramuka', 35, '10-May-2024', 'pending'),
(61, 2, 'Kecantikan', 'linkaja', 'balikpapan', 'Jl.Pramuka', 10, '10-May-2024', 'pending'),
(62, 2, 'saham', 'linkaja', 'balikpapan', 'Jl.Pramuka', 40, '10-May-2024', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(6) NOT NULL,
  `image` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `tujuan` longtext NOT NULL,
  `lesson_video` varchar(1000) NOT NULL DEFAULT '',
  `link` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `deskripsi`, `tujuan`, `lesson_video`, `link`) VALUES
(4, 'Kecantikan', 10, 'makeup.jpg', 'Apakah Anda bercita-cita untuk memulai bisnis kecantikan, tetapi tidak yakin harus mulai dari mana? Kelas ini dirancang khusus untuk membantu Anda memahami dasar-dasar bisnis kecantikan.', 'Dengan mengikuti kelas ini, Anda akan memiliki pengetahuan dan keterampilan yang diperlukan untuk merencanakan dan memulai bisnis kosmetik Anda sendiri. Segera bergabung dengan kami dan mulai wujudkan impian Anda dalam industri kosmetik!', 'uploaded_videos/kecantikan.mp4', 'https://chat.whatsapp.com/JwQ9fOvbp5j3WVOpWkCJiu'),
(7, 'kuliner', 20, 'kulinerp.jpg', 'Dalam kelas ini, Anda akan mendapatkan langkah demi langkah untuk mengembangkan keterampilan dalam memproduksi dan memasarkan kuliner dalam skala Usaha Mikro, Kecil, dan Menengah (UMKM). ', 'Memiliki pengetahuan dan keterampilan yang diperlukan untuk memulai atau meningkatkan usaha kue skala UMKM Anda sendiri. Jangan lewatkan kesempatan ini untuk menjelajahi dunia bisnis kue yang menjanjikan!', 'uploaded_videos/kuliner.mp4', 'https://chat.whatsapp.com/Ls3dttLsV6N0xD5cnCcb60'),
(9, 'Furniture', 35, 'funiture.jpg', 'Kelas wirausaha furniture memberikan pengetahuan dan keterampilan praktis untuk memulai dan mengelola bisnis furnitur, termasuk desain, produksi, pemasaran, dan manajemen bisnis.', 'Kelas ini bertujuan memberdayakan peserta dengan keterampilan untuk mengembangkan ide kreatif, memahami proses produksi yang efisien, dan mengelola bisnis furnitur secara berkelanjutan.', 'uploaded_videos/furniture.mp4', 'https://chat.whatsapp.com/GqR8sdzZg7u1BTEz6LFSpd'),
(14, 'saham', 40, 'saham.jpg', 'Selamat datang di kelas \"Menguasai Pasar Saham: Dasar-dasar Investasi yang Sukses\"! Kursus ini adalah panduan komprehensif bagi siapa pun yang ingin memahami pasar saham', 'Kelas ini bertujuan memberikan pengetahuan dan keterampilan investasi saham, termasuk dasar-dasar pasar saham, analisis, dan pengambilan keputusan investasi yang cerdas. Tujuannya adalah memahami risiko, mengembangkan strategi investasi, dan mencapai tujuan keuangan jangka panjang.', 'uploaded_videos/saham.mp4', 'https://chat.whatsapp.com/HOonX4NZbbZI8i7xnYn5yj'),
(16, 'Barista', 30, 'barista.jpg', 'Kami akan membimbing Anda melalui langkah-langkah praktis dalam meracik kopi yang sempurna, menguasai teknik-teknik penggilingan, dan mempelajari seni membentuk busa yang indah untuk minuman espresso', 'Mengetahui teknik pembuatan minuman yang sempurna dan kompetitif di pasaran.', 'uploaded_videos/coffe_shop.mp4', 'https://chat.whatsapp.com/Ls3dttLsV6N0xD5cnCcb60'),
(17, 'Petshop', 50, 'petshop.jpg', 'Dengan memahami kebutuhan dan preferensi pemilik hewan, wirausahawan petshop berusaha untuk menyediakan produk berkualitas tinggi, seperti makanan, perlengkapan mandi, mainan, dan aksesori lainnya, se', 'Tujuan utama dari wirausahawan petshop adalah untuk memberikan kemudahan, kenyamanan, dan kepuasan kepada pemilik hewan dalam merawat dan memanjakan hewan kesayangan mereka, sambil tetap memperhatikan kesejahteraan dan kebutuhan hewan peliharaan.', 'uploaded_videos/petshop.mp4', 'https://chat.whatsapp.com/KaNMWHjo4G64drGRW6Dpn0'),
(18, 'Fashion', 15, 'fashion.jpg', 'Selamat datang di kelas \"Panduan Praktis Memulai Bisnis Fashion Anda Sendiri\"! ', 'Tujuan kelas ini adalah memberikan pemahaman menyeluruh tentang industri fashion dan langkah-langkah praktis untuk memulai bisnis fashion. Kami bertujuan untuk mempersiapkan peserta dengan keterampilan yang diperlukan dalam perencanaan bisnis, desain, produksi, dan pemasaran produk fashion.', 'uploaded_videos/fashion.mp4', 'https://chat.whatsapp.com/CfDPEvJYZ2Z2Pat4mnJUmN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'Nauvaldi Caesar', 'aufa.@gmail.com', '1d64ce83c120a49b18c60c55789ec9f8', 'user'),
(3, 'admin', 'admin@gmail.com', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'admin'),
(4, 'kayla', 'kayla@gmail.com', '457391c9c82bfdcbb4947278c0401e41', 'user'),
(7, '-k', 'k@gmail.com', '8ce4b16b22b58894aa86c421e8759df3', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
