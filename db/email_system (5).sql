-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2021 at 02:31 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `email_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_info`
--

CREATE TABLE `billing_info` (
  `id` int(255) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `exp_month` varchar(255) NOT NULL,
  `exp_year` varchar(255) NOT NULL,
  `cvc` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billing_info`
--

INSERT INTO `billing_info` (`id`, `customer_id`, `amount`, `card_number`, `exp_month`, `exp_year`, `cvc`, `created_at`) VALUES
(2, 31, '1000', '4242424242424242', '12', '2022', '123', '1635245113'),
(3, 31, '85', '4242424242424242', '12', '2022', '123', '1635246403'),
(4, 31, '85', '4242424242424242', '12', '2022', '123', '1635246635'),
(5, 31, '85', '4242424242424242', '12', '2022', '123', '1635246972'),
(6, 31, '85', '4242424242424242', '12', '2022', '123', '1635247004'),
(7, 31, '85', '4242424242424242', '12', '2022', '123', '1635247078'),
(8, 31, '85', '4242424242424242', '12', '2022', '123', '1635247200'),
(9, 31, '85', '4242424242424242', '12', '2022', '123', '1635247868'),
(10, 31, '50', '4242424242424242', '12', '2022', '123', '1635248246'),
(11, 31, '30', '4242424242424242', '12', '2022', '123', '1635248330'),
(12, 29, '10', '4242424242424242', '12', '2022', '123', '1635270561'),
(13, 29, '20', '4242424242424242', '12', '2022', '123', '1635332202'),
(14, 29, '20', '4242424242424242', '12', '2022', '123', '1635332767');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(255) NOT NULL,
  `fromUser` varchar(255) NOT NULL,
  `toUser` varchar(255) NOT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `mailBy` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `fromUser`, `toUser`, `cc`, `bcc`, `subject`, `body`, `status`, `mailBy`) VALUES
(8, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', NULL, NULL, 'Sixth Test Subject', 'Sixth Test Body', '', 29),
(9, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', NULL, NULL, 'Seventh Test Subject', 'seventh Test Body', '', 29),
(10, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', 'yaseenboss49@gmail.com', 'yaseenboss@gmail.com', 'Seventh Test Subject', 'seventh Test Body', '', 29),
(11, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', 'yaseenboss49@gmail.com', 'yaseenboss@gmail.com', 'Seventh Test Subject', 'seventh Test Body', '', 29),
(12, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', 'yaseenboss49@gmail.com', 'yaseenboss@gmail.com', 'Seventh Test Subject', 'seventh Test Body', '', 29),
(13, 'hassaan.sagheer5@gmail.com', 'ismailamjad98@yahoo.com', 'yaseenboss49@gmail.com', 'yaseenboss@gmail.com', 'Seventh Test Subject', 'seventh Test Body', '', 29),
(14, 'hassaan.sagheer5@gmail.com', 'm.h.kasoori@gmail.com', 'yaseenboss49@gmail.com', 'yaseenboss@gmail.com', 'Seventh Test Subject', 'seventh Test Body', '', 29),
(15, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(16, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(17, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(18, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(19, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(20, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(21, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Deduct Balance', 'Deduct Balance', '', 29),
(22, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'From Secondary User', 'Deduct Balance', '', 29),
(23, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Now From Merchant User', 'Deduct Balance', '', 29),
(24, 'yaseenboss48@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'Email unsed', 'Unsed Body', 'Sending Failed', 30),
(25, 'hassaan.sagheer5@gmail.com', 'yaseenboss49@gmail.com', NULL, NULL, 'send subject', 'send mail', 'Sent', 29);

-- --------------------------------------------------------

--
-- Table structure for table `secondary_users`
--

CREATE TABLE `secondary_users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `view_email` varchar(255) NOT NULL,
  `send_email` varchar(255) NOT NULL,
  `view_billing_info` varchar(255) NOT NULL,
  `merchant_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secondary_users`
--

INSERT INTO `secondary_users` (`id`, `name`, `email`, `password`, `view_email`, `send_email`, `view_billing_info`, `merchant_id`) VALUES
(12, 'Ismail', 'ismail@gmail.com', '123', 'No', 'No', 'No', 29),
(13, 'user', 'user@gmail.com', '123', 'yes', 'Yes', 'Yes', 29),
(14, 'usman', 'usman@gmail.com', '123', 'No', 'No', 'No', 32),
(15, 'mudasir', 'mudasir@gmail.com', '123', 'No', 'No', 'No', 31),
(16, 'mudasir', 'mudasir@gmail.com', '123', 'Yes', 'Yes', 'Yes', 29),
(17, 'mudasir', 'yaseenboss49@gmail.com', 'astaghfirullah', 'No', 'yes', 'Yes', 29),
(18, 'second user', 'second@gmail.com', 'second', 'Yes', 'Yes', 'No', 29);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `balance` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `image`, `balance`) VALUES
(4, 'Ali', 'ali@gmail.com', '123', '', '', '0'),
(5, 'Ahmad', 'ahmad@gmail.com', '123', '', '', '0'),
(6, 'mudasir', 'musdasir@gmail.com', '123', '', '', '0'),
(8, 'Zubair', 'zubair@gmail.com', '123', '', '', '0'),
(29, 'Hassaan', 'hassaan.sagheer5@gmail.com', 'hassaanpp12', 'Merchant', '1635017168675.jpg', '50.8533'),
(30, 'Yaseen', 'yaseenboss48@gmail.com', '123', 'Merchant', '1635017487281.jpg', '4.9511'),
(31, 'admin', 'hassaan@gmail.com', '123', 'Admin', '', '250'),
(32, 'ali', 'ali49@gmail.com', '123', 'Merchant', '1635136876564.jpg', '0'),
(34, 'hassaan', 'hassaan1@gmail.com', '123', 'Merchant', '1635323038057.jpg', '0'),
(35, 'hassaan', 'hassaan12@gmail.com', '123', 'Merchant', '1635323445812.jpg', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_info`
--
ALTER TABLE `billing_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secondary_users`
--
ALTER TABLE `secondary_users`
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
-- AUTO_INCREMENT for table `billing_info`
--
ALTER TABLE `billing_info`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `secondary_users`
--
ALTER TABLE `secondary_users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_info`
--
ALTER TABLE `billing_info`
  ADD CONSTRAINT `billing_info_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
