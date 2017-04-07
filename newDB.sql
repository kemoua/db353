-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(8) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `civic_number` varchar(10) DEFAULT NULL,
  `postal_code` varchar(7) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `Street` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `first_name`, `last_name`, `civic_number`, `postal_code`, `country`, `city`, `phone`, `username`, `Street`) VALUES
(0, 'vanessa', 'kurt', '3700', 'j3y7s3', 'canada', 'saint-hubert', '4503410681', 'vanx', 'gaetanboucher'),
(2, 'kenx', 'moux', '3242', 'j3y2f3', 'canada', 'montreal', '3242342343', 'kenx', 'mountainview blvd');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
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
  `order_number` int(8) NOT NULL,
  `phase_id` int(8) NOT NULL,
  `project_id` int(8) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `date_order` date NOT NULL,
  `date_delivered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(8) NOT NULL DEFAULT '0',
  `sub_order_number` int(8) NOT NULL DEFAULT '0',
  `order_number` int(8) NOT NULL DEFAULT '0',
  `amount_paid` decimal(8,2) NOT NULL,
  `date_of_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phases`
--

CREATE TABLE `phases` (
  `phase_id` int(8) NOT NULL,
  `project_id` int(8) NOT NULL,
  `status` enum('Design','Pre-Construction','Procurement','Construction','Owner Occupancy','Closeout') NOT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(8) NOT NULL,
  `client_id` int(8) NOT NULL,
  `status` enum('Analysis','In Progress','Completed','Cancelled') NOT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `type` enum('Condo','House') NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `client_id`, `status`, `start_date`, `complete_date`, `time_needed`, `title`, `type`, `budget`, `actual_cost`) VALUES
(221, 0, 'Analysis', '2017-04-17', NULL, '42 days', 'ABC yo', 'House', '234234.00', '234234.00'),
(222, 0, 'Analysis', '2017-04-08', NULL, '23 days', 'Ocean Avenue', 'House', '12300332.00', '99999999.99'),
(223, 2, 'Completed', '2017-04-12', '2017-04-18', '200 days', 'JURASSIK', 'Condo', '234234.00', '234234.00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_orders`
--

CREATE TABLE `sub_orders` (
  `sub_order_number` int(8) NOT NULL DEFAULT '0',
  `order_number` int(8) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `item_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(8) NOT NULL DEFAULT '0',
  `project_id` int(8) NOT NULL DEFAULT '0',
  `phase_id` int(8) NOT NULL DEFAULT '0',
  `description` varchar(140) DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed','Cancelled') NOT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `time_needed` varchar(10) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `privilege` enum('Company','Customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `privilege`) VALUES
('kenx', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Company'),
('vanx', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Company');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_number`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `phase_id` (`phase_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`,`sub_order_number`,`order_number`),
  ADD KEY `sub_order_number` (`sub_order_number`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `phases`
--
ALTER TABLE `phases`
  ADD PRIMARY KEY (`phase_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `sub_orders`
--
ALTER TABLE `sub_orders`
  ADD PRIMARY KEY (`sub_order_number`,`order_number`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`,`project_id`,`phase_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `phase_id` (`phase_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`phase_id`) REFERENCES `phases` (`phase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`sub_order_number`) REFERENCES `sub_orders` (`sub_order_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`order_number`) REFERENCES `orders` (`order_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phases`
--
ALTER TABLE `phases`
  ADD CONSTRAINT `phases_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_orders`
--
ALTER TABLE `sub_orders`
  ADD CONSTRAINT `sub_orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_orders_ibfk_2` FOREIGN KEY (`order_number`) REFERENCES `orders` (`order_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`phase_id`) REFERENCES `phases` (`phase_id`) ON DELETE CASCADE ON UPDATE CASCADE;
