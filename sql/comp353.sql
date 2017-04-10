-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 24, 2017 at 05:42 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comp353`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(8) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `first_name`, `last_name`, `address`, `city`, `phone`, `username`) VALUES
(1, 'vanessa', 'kurt', '3700 gaetan-boucher', 'saint-hubert', '4503410681', 'admin'),
(2, 'lev', 'kokotov', '1804 rue sainte-catherine', 'canada', '5146220407', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(8) NOT NULL,
  `name` varchar(20) NOT NULL,
  `base_cost` decimal(10,2) NOT NULL,
  `supplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(8) NOT NULL,
  `phase_id` varchar(12) NOT NULL,
  `project_id` int(8) NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `date_order` date DEFAULT NULL,
  `date_delivered` date DEFAULT NULL,
  `so_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phase`
--

CREATE TABLE `phase` (
  `phase_id` varchar(15) NOT NULL DEFAULT '',
  `project_id` int(8) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(8) NOT NULL,
  `client_id` int(8) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `client_id`, `status`, `start_date`, `complete_date`, `time_needed`, `title`, `type`, `budget`, `actual_cost`) VALUES
(221, 1, 'In Progress', '2017-03-09', NULL, '2 months', 'abc', 'House', '123456.00', '250000.00'),
(222, 2, 'Completed', '2017-03-06', NULL, '25 days', 'The sunny valley', 'condo', '23949393.00', '99999999.99'),
(223, 1, 'Completed', '2017-03-06', '2017-03-31', '2 months', 'The Jurassic Park', 'Condo', '123000.23', '23123213.00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_order`
--

CREATE TABLE `sub_order` (
  `so_id` int(8) NOT NULL DEFAULT '0',
  `order_id` int(8) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `item_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(8) NOT NULL DEFAULT '0',
  `project_id` int(8) NOT NULL DEFAULT '0',
  `phase_id` varchar(12) NOT NULL DEFAULT '',
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `privilege` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `privilege`) VALUES
('admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'A'),
('client', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `phase_id` (`phase_id`);

--
-- Indexes for table `phase`
--
ALTER TABLE `phase`
  ADD PRIMARY KEY (`phase_id`,`project_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `sub_order`
--
ALTER TABLE `sub_order`
  ADD PRIMARY KEY (`so_id`,`order_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`,`project_id`,`phase_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `phase_id` (`phase_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`phase_id`) REFERENCES `phase` (`phase_id`);

--
-- Constraints for table `phase`
--
ALTER TABLE `phase`
  ADD CONSTRAINT `phase_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);

--
-- Constraints for table `sub_order`
--
ALTER TABLE `sub_order`
  ADD CONSTRAINT `sub_order_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `sub_order_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`phase_id`) REFERENCES `phase` (`phase_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
