-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 04:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pakel3`
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
(59, 0, 'Food & Beverages', 20, 'kuliner.jpg', 1);

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
(12, 4, '3', 'f@gmail.com', '3', 'g');

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
(35, 2, 'Kecantikan', 'Ewallet', 'balikpapan', 'Jl.Pramuka', 10, '06-May-2024', 'completed'),
(36, 2, 'Barista', 'Ewallet', 'balikpapan', 'Jl.Pramuka', 40, '08-May-2024', 'completed'),
(37, 2, 'kuliner', 'Ewallet', 'balikpapan', 'Jl.Pramuka', 20, '08-May-2024', 'pending'),
(38, 4, 'saham', 'Ewallet', 'Bengkulu', 'Jl. Patin', 50, '08-May-2024', 'completed'),
(39, 4, 'Fashion', 'Ewallet', 'Serayu', 'Jl. BIsmilah', 20, '08-May-2024', 'completed'),
(40, 4, 'Kecantikan', 'Ewallet', 'Serayu', 'Jl. BIsmilah', 10, '08-May-2024', 'completed'),
(42, 4, 'kuliner', 'Ewallet', 'Serayu', 'Jl. BIsmilah', 20, '08-May-2024', 'completed'),
(43, 4, 'Furniture', 'Ewallet', 'Serayu', 'Jl. BIsmilah', 35, '08-May-2024', 'completed'),
(44, 4, 'PetShop', 'Ewallet', 'Bekasi', 'Jl. Sambaliung', 100, '08-May-2024', 'completed'),
(45, 4, 'Barista', 'Ewallet', 'Samarinda', 'Jl. Sudang', 40, '08-May-2024', 'completed');

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
(3, 'saham', 50, 'saham.jpg', 'Selamat datang di kelas \"Menguasai Pasar Saham: Dasar-dasar Investasi yang Sukses\"! Kursus ini adalah panduan komprehensif bagi siapa pun yang ingin memahami pasar saham', 'Kelas ini bertujuan memberikan pengetahuan dan keterampilan investasi saham, termasuk dasar-dasar pasar saham, analisis, dan pengambilan keputusan investasi yang cerdas. Tujuannya adalah memahami risiko, mengembangkan strategi investasi, dan mencapai tujuan keuangan jangka panjang.', 'uploaded_videos/saham.mp4', 'https://chat.whatsapp.com/HOonX4NZbbZI8i7xnYn5yj'),
(4, 'Kecantikan', 10, 'makeup.jpg', 'Apakah Anda bercita-cita untuk memulai bisnis kecantikan, tetapi tidak yakin harus mulai dari mana? Kelas ini dirancang khusus untuk membantu Anda memahami dasar-dasar bisnis kecantikan.', 'Dengan mengikuti kelas ini, Anda akan memiliki pengetahuan dan keterampilan yang diperlukan untuk merencanakan dan memulai bisnis kosmetik Anda sendiri. Segera bergabung dengan kami dan mulai wujudkan impian Anda dalam industri kosmetik!', 'uploaded_videos/kecantikan.mp4', 'https://chat.whatsapp.com/JwQ9fOvbp5j3WVOpWkCJiu'),
(6, 'Barista', 40, 'barista.jpg', 'Kami akan membimbing Anda melalui langkah-langkah praktis dalam meracik kopi yang sempurna, menguasai teknik-teknik penggilingan, dan mempelajari seni membentuk busa yang indah untuk minuman espresso ', 'Mengetahui teknik pembuatan minuman yang sempurna dan kompetitif di pasaran.', 'uploaded_videos/barista.mp4', 'https://chat.whatsapp.com/ImomCELovcaByoohhjIfaS'),
(7, 'kuliner', 20, 'kulinerp.jpg', 'Dalam kelas ini, Anda akan mendapatkan langkah demi langkah untuk mengembangkan keterampilan dalam memproduksi dan memasarkan kuliner dalam skala Usaha Mikro, Kecil, dan Menengah (UMKM). ', 'Memiliki pengetahuan dan keterampilan yang diperlukan untuk memulai atau meningkatkan usaha kue skala UMKM Anda sendiri. Jangan lewatkan kesempatan ini untuk menjelajahi dunia bisnis kue yang menjanjikan!', 'uploaded_videos/kuliner.mp4', 'https://chat.whatsapp.com/Ls3dttLsV6N0xD5cnCcb60'),
(8, 'Fashion', 20, 'fashion.jpg', 'Selamat datang di kelas \"Panduan Praktis Memulai Bisnis Fashion Anda Sendiri\"! ', 'Tujuan kelas ini adalah memberikan pemahaman menyeluruh tentang industri fashion dan langkah-langkah praktis untuk memulai bisnis fashion. Kami bertujuan untuk mempersiapkan peserta dengan keterampilan yang diperlukan dalam perencanaan bisnis, desain, produksi, dan pemasaran produk fashion.', 'uploaded_videos/Fashion.mp4', 'https://chat.whatsapp.com/CfDPEvJYZ2Z2Pat4mnJUmN'),
(9, 'Furniture', 35, 'funiture.jpg', 'Kelas wirausaha furniture memberikan pengetahuan dan keterampilan praktis untuk memulai dan mengelola bisnis furnitur, termasuk desain, produksi, pemasaran, dan manajemen bisnis.', 'Kelas ini bertujuan memberdayakan peserta dengan keterampilan untuk mengembangkan ide kreatif, memahami proses produksi yang efisien, dan mengelola bisnis furnitur secara berkelanjutan.', 'uploaded_videos/furniture.mp4', 'https://chat.whatsapp.com/GqR8sdzZg7u1BTEz6LFSpd'),
(11, 'PetShop', 100, 'petshop.jpg', 'Selamat datang di kelas PetShop. Mulai wirausaha dibidang PetShop dengan persiapan terbaik!', 'Mengetahui cara berjualan peralatan hewan', 'uploaded_videos/petshop.mp4', 'https://chat.whatsapp.com/KaNMWHjo4G64drGRW6Dpn0');

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
(5, 'kayla', 'aufa.@gmail.com', '2e2a632715d4006188104dd34e4adb58', 'user'),
(7, '-k', 'k@gmail.com', '8ce4b16b22b58894aa86c421e8759df3', 'user'),
(8, '0', 'kayla11virrly@gmail.com', '8ce4b16b22b58894aa86c421e8759df3', 'user');

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
