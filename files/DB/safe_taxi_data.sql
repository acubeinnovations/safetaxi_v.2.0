-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2015 at 06:33 AM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `safe_taxi_v2`
--

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('eda9ebd180c12decb8e149142483453b', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:30.0) Gec', 1417499747, 'a:10:{s:9:"user_data";s:0:"";s:22:"isloginAttemptexceeded";b:0;s:2:"id";s:1:"2";s:4:"name";s:11:"Nijo Joseph";s:5:"email";s:19:"nijojoseph@acube.co";s:8:"username";s:10:"nijojoseph";s:4:"type";s:1:"2";s:10:"permission";s:1:"2";s:10:"isLoggedIn";b:1;s:10:"token_pass";s:32:"bf8191475f55068537a0dc716078dddb";}');

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
(4, 'Suspended', 'Driver Suspended', 0, 1, '2014-12-02 08:06:31', '0000-00-00 00:00:00');

--
-- Dumping data for table `notification_statuses`
--

INSERT INTO `notification_statuses` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Notified', 'Notified', 0, 2, '2014-12-02 05:30:37', '0000-00-00 00:00:00'),
(2, 'Responded', 'Responded', 0, 2, '2014-12-02 05:31:05', '0000-00-00 00:00:00'),
(3, 'Expired', 'Expired', 0, 2, '2014-12-02 05:31:05', '0000-00-00 00:00:00');

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Notification Type New Trip', 'New Trip', 0, 2, '2014-12-02 05:26:34', '0000-00-00 00:00:00'),
(2, 'Notification Type Trip Cancelled', 'Trip Cancelled', 0, 2, '2014-12-02 05:26:34', '0000-00-00 00:00:00'),
(3, 'Notification Type Trip Update', 'Trip Update', 0, 2, '2014-12-02 05:28:24', '0000-00-00 00:00:00'),
(4, 'Notification Type  Payment Message', 'Payment', 0, 2, '2014-12-02 05:28:24', '2014-12-05 05:00:40'),
(5, 'Notification Type  Common Message', 'Common Message', 0, 2, '2014-12-16 13:00:14', '0000-00-00 00:00:00');

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
(1, 'Pending', 'Trip Pending', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(2, 'Accepted', 'Trip Accepted', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(3, 'Trip Completed', 'Trip Completed', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(4, 'Cancelled', 'Trip Cancelled', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(5, 'Driver Canceled', 'Trip Canceled By Driver', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(6, 'Customer Canceled', 'Trip Canceled By Customer', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00'),
(7, 'Invoice Generated', 'Trip Invoice Generated', 0, 1, '2014-11-14 05:27:34', '0000-00-00 00:00:00');

--
-- Dumping data for table `trip_types`
--

INSERT INTO `trip_types` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Instant', 'Instant Trip', 0, 1, '2014-11-14 05:18:27', '0000-00-00 00:00:00'),
(2, 'Future', 'Future Trip', 0, 1, '2014-11-14 05:18:27', '0000-00-00 00:00:00');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `address`, `user_status_id`, `password_token`, `user_type_id`, `user_permission_id`, `created`, `updated`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin@safetaxi.com', '', '', 1, '', 1, 0, '2014-11-13 12:29:16', '0000-00-00 00:00:00'),
(2, 'nijojoseph', 'bf8191475f55068537a0dc716078dddb', 'Nijo', 'Joseph', 'nijojoseph@acube.co', '9020964268', '', 1, '', 2, 2, '2014-11-13 12:29:16', '0000-00-00 00:00:00');

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

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name`, `description`, `value`, `user_id`, `created`, `updated`) VALUES
(1, 'Invoice', 'Invoice', 0, 2, '2014-12-01 23:40:38', '0000-00-00 00:00:00'),
(2, 'Payment', 'Payment', 0, 2, '2014-12-01 23:40:38', '0000-00-00 00:00:00'),
(3, 'Receipt', 'Receipt', 0, 2, '2014-12-01 23:41:18', '0000-00-00 00:00:00');

