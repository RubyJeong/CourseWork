-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 09, 2018 at 04:23 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Project02`
--

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `tour_id` int(3) NOT NULL,
  `re_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`tour_id`, `re_id`) VALUES
(893, 107192),
(129, 121662),
(243, 166497),
(550, 306521),
(550, 487245),
(893, 683955),
(243, 748217),
(243, 805001),
(129, 953520);

-- --------------------------------------------------------

--
-- Table structure for table `Tours`
--

CREATE TABLE `Tours` (
  `tour_id` int(3) NOT NULL,
  `tour_name` varchar(30) NOT NULL,
  `travel_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Tours`
--

INSERT INTO `Tours` (`tour_id`, `tour_name`, `travel_date`) VALUES
(129, 'CN Tower', '2018-12-02'),
(243, 'Wonderland', '2018-12-03'),
(550, 'Thousand Islands', '2018-12-04'),
(893, 'CN Tower', '2018-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `re_id` int(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `group_id` int(2) NOT NULL,
  `group_size` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`re_id`, `email`, `password`, `customer_name`, `address`, `group_id`, `group_size`) VALUES
(100000, 'admin@gmail.com', 'admin', '', '', 0, 0),
(107192, 'user1@gmail.com', 'user1', 'user1', 'North York', -92, 3),
(121662, 'user4@gmail.com', 'user4', 'user4', 'Toronto', -53, 3),
(166497, 'user6@gmail.com', 'user6', 'user6', 'Toronto', 17, 3),
(306521, 'user9@gmail.com', 'user9', 'user9', 'Toronto', -12, 3),
(487245, 'user8@gmail.com', 'user8', 'user8', 'Toronto', -12, 3),
(683955, 'user2@gmail.com', 'user2', 'user2', 'Toronto', -92, 3),
(748217, 'user3@gmail.com', 'user3', 'user3', 'Toronto', 17, 3),
(805001, 'user7@gmail.com', 'user7', 'user7', 'Toronto', 17, 3),
(953520, 'user5@gmail.com', 'user5', 'user5', 'Toronto', -53, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`tour_id`,`re_id`),
  ADD KEY `groups_users` (`re_id`);

--
-- Indexes for table `Tours`
--
ALTER TABLE `Tours`
  ADD PRIMARY KEY (`tour_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`re_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Groups`
--
ALTER TABLE `Groups`
  ADD CONSTRAINT `groups_tours` FOREIGN KEY (`tour_id`) REFERENCES `Tours` (`tour_id`),
  ADD CONSTRAINT `groups_users` FOREIGN KEY (`re_id`) REFERENCES `Users` (`re_id`);
