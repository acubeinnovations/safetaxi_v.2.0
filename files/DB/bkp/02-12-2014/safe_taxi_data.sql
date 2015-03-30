-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2014 at 05:20 AM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `safetaxi`
--

--
-- Dumping data for table `customer_statuses`
--

INSERT INTO `customer_statuses` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Active', 'Customer Active', 0, 1, '2014-11-14 05:13:52', '0000-00-00 00:00:00'),
(2, 'Under Processing', 'Customer Under Processing', 0, 1, '2014-11-14 05:13:52', '0000-00-00 00:00:00');

--
-- Dumping data for table `driver_statuses`
--

INSERT INTO `driver_statuses` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Active', 'Driver Active', 0, 1, '2014-11-14 05:22:09', '0000-00-00 00:00:00'),
(2, 'Engaged', 'Driver Engaged', 0, 1, '2014-11-14 05:22:09', '0000-00-00 00:00:00'),
(3, 'Dismissed', 'Driver Dismissed', 0, 1, '2014-11-14 05:22:09', '0000-00-00 00:00:00'),
(4, 'Suspended', 'Driver Suspended', 0, 1, '2014-11-20 05:14:21', '0000-00-00 00:00:00');

--
-- Dumping data for table `notification_view_statuses`
--

INSERT INTO `notification_view_statuses` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Viewed', 'Notification Viewed', 0, 1, '2014-11-20 05:16:41', '0000-00-00 00:00:00'),
(2, 'Not Viewed', 'Notification Not Viewed', 0, 1, '2014-11-20 05:16:41', '0000-00-00 00:00:00');

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `description`) VALUES
(1, 'Active', 'Active'),
(2, 'Inactive', 'Inactive');

--
-- Dumping data for table `trip_statuses`
--

INSERT INTO `trip_statuses` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Booked', 'Trip Booked', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(2, 'Accepted', 'Trip Accepted', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(3, 'On Trip', 'On Trip', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(4, 'Trip Completed', 'Trip Completed', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(5, 'Cancelled', 'Trip Cancelled', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(6, 'Driver Canceled', 'Trip Canceled By Driver', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(7, 'Customer Canceled', 'Trip Canceled By Customer', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00');

--
-- Dumping data for table `trip_types`
--

INSERT INTO `trip_types` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Instant', 'Instant Trip', 0, 1, '2014-11-14 05:18:27', '0000-00-00 00:00:00'),
(2, 'Future', 'Future Trip', 0, 1, '2014-11-14 05:18:27', '0000-00-00 00:00:00');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `address`, `user_status_id`, `password_token`, `user_type_id`, `created`, `updated`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin@safetaxi.com', '', '', 1, '', 1, '2014-11-13 12:29:16', '0000-00-00 00:00:00'),
(2, 'nijojoseph', 'bf8191475f55068537a0dc716078dddb', 'Nijo', 'Joseph', 'nijojoseph@acube.co', '9020964268', '', 1, '', 2, '2014-11-13 12:29:16', '0000-00-00 00:00:00');

--
-- Dumping data for table `user_statuses`
--

INSERT INTO `user_statuses` (`id`, `name`, `description`) VALUES
(1, 'Active', 'Active'),
(2, 'Suspended', 'Suspended'),
(3, 'Disabled', 'Disabled');

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `description`) VALUES
(1, 'System Administrator', 'System Administrator'),
(2, 'Front Desk', 'Front Desk');

