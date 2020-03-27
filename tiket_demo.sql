-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.1
-- Generation Time: Mar 27, 2020 at 05:42 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiket_demo`
--
CREATE DATABASE IF NOT EXISTS `tiket_demo`;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(1000) DEFAULT NULL,
  `uploaded_by` varchar(100) DEFAULT NULL,
  `ref` int(11) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `name`, `path`, `uploaded_by`, `ref`, `ext`) VALUES
(33, 'TEST.jpg', 'uploads/04012020180329-TEST.jpg', 'user.demo', 0, NULL),
(34, 'TEST.jpg', 'uploads/04012020181403-TEST.jpg', 'admin.demo', 0, NULL),
(35, 'TEST.jpg', 'uploads/04012020182353-TEST.jpg', 'agent.demo', 0, NULL),
(36, 'TEST.jpg', 'uploads/04012020183457-TEST.jpg', 'admin.demo', 0, NULL),
(37, 'dummy-img.jpeg', 'uploads/31012020125348-dummy-img.jpeg', 'agent.demo', 0, NULL),
(38, 'dummy-img.jpeg', 'uploads/31012020130215-dummy-img.jpeg', 'admin.demo', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `ticket` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `data` text,
  `owner` varchar(100) NOT NULL,
  `ref` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `type` int(11) DEFAULT '0',
  `to` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `ticket`, `message`, `data`, `owner`, `ref`, `created`, `type`, `to`) VALUES
(265, 'TIK-TIKAJ-000107', 'Changed priority to <span class=\'tik-priority\' data-value=5></span>', NULL, 'admin.demo', 0, 1578141272, 6, NULL),
(266, 'TIK-TIKAJ-000107', 'Changed assignee to <span class=\"user-label\" data-username=\"agent.demo\"></span>', NULL, 'admin.demo', 0, 1578141286, 8, NULL),
(267, 'TIK-TIKAJ-000107', '<p>Assigned to agent.demo</p>', 'null', 'admin.demo', 0, 1578141342, 1, NULL),
(268, 'TIK-TIKAJ-000108', 'Changed priority to <span class=\'tik-priority\' data-value=10></span>', NULL, 'admin.demo', 0, 1578141861, 6, NULL),
(269, 'TIK-TIKAJ-000108', 'Changed assignee to <span class=\"user-label\" data-username=\"agent.demo\"></span>', NULL, 'admin.demo', 0, 1578141874, 8, NULL),
(270, 'TIK-TIKAJ-000110', 'Changed priority to <span class=\'tik-priority\' data-value=5></span>', NULL, 'admin.demo', 0, 1578143379, 6, NULL),
(271, 'TIK-TIKAJ-000110', 'Changed assignee to <span class=\"user-label\" data-username=\"agent.demo\"></span>', NULL, 'admin.demo', 0, 1578143392, 8, NULL),
(272, 'TIK-TIKAJ-000110', 'Closed the ticket', NULL, 'admin.demo', 0, 1580306584, 3, NULL),
(273, 'TIK-TIKAJ-000110', 'Changed status to <span class=\'tik-status\' data-value=100></span>', NULL, 'admin.demo', 0, 1580453440, 4, NULL),
(274, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453559, 1, NULL),
(275, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453565, 1, NULL),
(276, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453567, 1, NULL),
(277, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453573, 1, NULL),
(278, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453573, 1, NULL),
(279, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453573, 1, NULL),
(280, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453573, 1, NULL),
(281, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453573, 1, NULL),
(282, 'TIK-TIKAJ-000110', '<p>This is related to current ticket</p>', 'null', 'agent.demo', 0, 1580453574, 1, NULL),
(283, 'TIK-TIKAJ-000109', '<h2>Dummy comment header</h2><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p><p><br></p><p><strong style=\"color: rgb(161, 0, 0);\">Following the following code:</strong></p><pre class=\"ql-syntax\" spellcheck=\"false\">&lt;div class=\"dummy__text\"&gt;\n  &lt;h1&gt;Dummy title here&lt;/h1&gt;\n&lt;/div&gt;\n</pre><p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost <u>unorthographic </u>life One day however a small line of blind text by the name of Lorem Ipsum decided to</p><p><br></p><p><br></p>', '{\"attachments\":[{\"file_name\":\"dummy-img.jpeg\",\"path\":\"uploads\\/31012020125348-dummy-img.jpeg\"}]}', 'agent.demo', 0, 1580455479, 1, NULL),
(284, 'TIK-TIKAJ-000111', 'Changed severity to <span class=\'tik-severity\' data-value=5></span>', NULL, 'admin.demo', 0, 1580456207, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_no` varchar(50) DEFAULT NULL,
  `owner` varchar(100) NOT NULL,
  `purpose` varchar(500) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `assign_to` varchar(100) DEFAULT NULL,
  `assign_on` varchar(100) DEFAULT NULL,
  `progress` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `severity` int(11) DEFAULT '0',
  `priority` int(11) DEFAULT '0',
  `cc` text,
  `data` text,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_no`, `owner`, `purpose`, `subject`, `message`, `assign_to`, `assign_on`, `progress`, `updated`, `created`, `status`, `severity`, `priority`, `cc`, `data`, `category`) VALUES
(106, 'TIK-TIKAJ-000106', 'user.demo', 'Testing', 'Dummy ticket 1', '<p>Dummy ticket 1 for demo.</p>', NULL, NULL, 0, 0, 1578140501, 0, 10, NULL, 'admin.demo;agent.demo', 'null', 0),
(107, 'TIK-TIKAJ-000107', 'user.demo', 'Testing', 'Dummy Ticket 2', '<p>Dummy ticket 2 for feature request.</p>', 'agent.demo', '1578141285991', 0, 0, 1578141217, 50, 5, 5, 'admin.demo;agent.demo', '{\"attachments\":[{\"file_name\":\"TEST.jpg\",\"path\":\"uploads\\/04012020180329-TEST.jpg\"}]}', 1),
(108, 'TIK-TIKAJ-000108', 'admin.demo', 'Testing', 'Dummy Ticket 3', '<p>Dummy ticket 3 for software troubleshooting.</p>', 'agent.demo', '1578141873859', 0, 0, 1578141850, 50, 10, 10, 'agent.demo', '{\"attachments\":[{\"file_name\":\"TEST.jpg\",\"path\":\"uploads\\/04012020181403-TEST.jpg\"}]}', 2),
(109, 'TIK-TIKAJ-000109', 'agent.demo', 'Testing', 'Dummy Ticket 4', '<p>Dummy ticket for Nertwork Problem.</p>', NULL, NULL, 0, 0, 1578142453, 0, 5, NULL, 'admin.demo', '{\"attachments\":[{\"file_name\":\"TEST.jpg\",\"path\":\"uploads\\/04012020182353-TEST.jpg\"}]}', 5),
(110, 'TIK-TIKAJ-000110', 'admin.demo', 'Testing', 'Dummy Ticket 5', '<p>Dummy ticket 5 for Hardware.</p>', 'agent.demo', '1578143391351', 0, 0, 1578143099, 100, 5, 5, 'agent.demo', '{\"attachments\":[{\"file_name\":\"TEST.jpg\",\"path\":\"uploads\\/04012020183457-TEST.jpg\"}]}', 6),
(111, 'TIK-TIKAJ-000111', 'admin.demo', 'To test a bug that is huge', 'The last [newsletter:total] posts from our blog', '<h2>Dummy comment header</h2><p><br></p><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p><p><br></p><p><br></p><p><strong>Following are points:</strong></p><p><strong><span class=\"ql-cursor\">?</span></strong></p><ol><li><span style=\"color: rgb(85, 85, 85);\">Point number 1</span></li><li><span style=\"color: rgb(85, 85, 85);\">Point number 2</span></li><li><span style=\"color: rgb(85, 85, 85);\">Point number 3</span>&nbsp;</li><li>Point number 4</li></ol><p><br></p><p><br></p><p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to</p><p><br></p><p><br></p><p><br></p>', NULL, NULL, 0, 0, 1580456068, 0, 5, NULL, 'user.demo;agent.demo', '{\"attachments\":[{\"file_name\":\"dummy-img.jpeg\",\"path\":\"uploads\\/31012020130215-dummy-img.jpeg\"}]}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(35) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `username`, `password`, `type`, `status`, `created`, `updated`) VALUES
(1, 'Demo Admin', 'admin.demo@tikaj.com', '9999999999', 'admin.demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 80, 1, 1568270653, 1568270653),
(2, 'Demo User', 'user.demo@tikaj.com', '9999999999', 'user.demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 10, 1, 1569649164, 1569649164),
(3, 'Demo Agent', 'agent.demo@tikaj.com', '9999999999', 'agent.demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 60, 1, 1569649194, 1569649194);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
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
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
