
CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `privilege` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `user` (`username`, `password`, `privilege`) VALUES
('admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'A'),
('client', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'C');

 

INSERT INTO `project` (`project_id`, `client_id`, `status`, `start_date`, `complete_date`, `time_needed`, `title`, `type`, `budget`, `actual_cost`) VALUES
(221, 1, 'In Progress', '2017-03-09', NULL, '2 months', 'abc', 'House', '123456.00', '250000.00'),
(223, 1, 'Completed', '2017-03-06', '2017-03-31', '2 months', 'The Jurassic Park', 'Condo', '123000.23', '23123213.00');
(222, 2, 'Completed', '2017-03-06', NULL, '25 days', 'The sunny valley', 'condo', '23949393.00', '99999999.99'),


INSERT INTO `client` (`client_id`, `first_name`, `last_name`, `address`, `city`, `phone`, `username`) VALUES
(1, 'vanessa', 'kurt', '3700 gaetan-boucher', 'saint-hubert', '4503410681', 'admin'),
(2, 'sdf', 'abc', '1804 rue sainte-catherine', 'canada', '5146220407', 'client');