-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-03-07 09:06:30
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `file`
--

-- --------------------------------------------------------

--
-- 資料表結構 `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `birthday` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `students`
--

INSERT INTO `students` (`id`, `name`, `no`, `birthday`) VALUES
(1, '丁于穎', 'C100000012', '1984-03-05'),
(2, '尹彗如', 'F200000026', '1980-09-08'),
(3, '孔琇榆', 'F200000035', '1984-08-28'),
(4, '文勝真', 'F100000042', '1984-08-28'),
(5, '方玉婷', 'C200000058', '1983-12-10'),
(6, '毛家男', 'C100000067', '1983-12-16'),
(7, '王鳳如', 'F200000071', '1984-01-06'),
(8, '史乾君', 'C100000085', '1984-04-01'),
(9, '田泓宜', 'F100000097', '1984-07-09'),
(10, '白金圓', 'V200000109', '1984-01-02'),
(11, '石政華', 'C100000110', '1984-03-03'),
(12, '任佩君', 'G200000123', '1984-09-17'),
(13, '朱怡蓉', 'F200000131', '1983-10-24'),
(14, '江欣欽', 'C100000147', '1983-12-11'),
(15, '何秋桂', 'G200000150', '1983-11-16'),
(16, '余進財', 'F100000168', '1984-02-26'),
(17, '吳菁菁', 'F200000177', '1984-07-13'),
(18, '呂意倫', 'F100000186', '1984-06-01'),
(19, '宋時雨', 'K100000199', '1984-09-16'),
(20, '李禬敏', 'C100000209', '1984-05-03'),
(21, '杜晉華', 'C100000218', '1984-02-24'),
(22, '沈慧如', 'F200000220', '1984-03-11'),
(23, '汪純芬', 'C200000236', '1984-10-20');

-- --------------------------------------------------------

--
-- 資料表結構 `upload`
--

CREATE TABLE `upload` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(36) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(64) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `upload`
--

INSERT INTO `upload` (`id`, `file_name`, `size`, `type`, `upload_time`, `update_time`, `description`) VALUES
(46, '20221212021601.jpg', 76269, 'image/jpeg', '2022-12-12 06:16:01', '2022-12-12 07:45:52', 'ohno'),
(49, '20221212022550.jpg', 35317, 'image/jpeg', '2022-12-12 06:25:50', '2022-12-12 06:25:50', 'yesisu'),
(51, '20221212033549.gif', 16384, 'image/gif', '2022-12-12 07:35:49', '2022-12-12 07:35:49', 'isu'),
(52, '20230221031500.png', 183564, 'image/png', '2023-02-21 07:15:00', '2023-02-21 07:15:00', '都要玩'),
(53, '20230221031518.png', 298138, 'image/png', '2023-02-21 07:15:18', '2023-02-21 07:15:18', '水豚勇'),
(54, '20230221031624.jpg', 60519, 'image/jpeg', '2023-02-21 07:16:24', '2023-02-21 07:16:24', 'OMG'),
(55, '20230221031658.jpg', 9281, 'image/jpeg', '2023-02-21 07:16:58', '2023-02-21 07:16:58', 'stupid'),
(56, '20230221031711.jpg', 14922, 'image/jpeg', '2023-02-21 07:17:11', '2023-02-21 07:17:11', 'Qoo'),
(57, '20230221031726.png', 1103871, 'image/png', '2023-02-21 07:17:26', '2023-02-21 07:17:26', 'Qong_p'),
(58, '20230221031738.png', 857656, 'image/png', '2023-02-21 07:17:38', '2023-02-21 07:17:38', 'Qong_p2'),
(59, '20230221031752.jpg', 179424, 'image/jpeg', '2023-02-21 07:17:52', '2023-02-21 07:17:52', 'colorful'),
(60, '20201225004037.jpg', 23389, 'image/jpeg', '2023-03-07 05:33:36', '2023-03-07 05:33:59', '加油');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
