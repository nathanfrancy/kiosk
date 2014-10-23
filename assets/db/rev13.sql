-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2014 at 04:46 AM
-- Server version: 5.6.15
-- PHP Version: 5.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ucmo_kiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_department`
--

CREATE TABLE IF NOT EXISTS `access_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `access_department`
--

INSERT INTO `access_department` (`id`, `user_id`, `department_id`) VALUES
(63, 12, 30),
(81, 12, 40);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(30, 'Computer Information Systems'),
(34, 'Management'),
(36, 'Economics'),
(39, 'Finance'),
(40, 'Business Law');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE IF NOT EXISTS `professor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `title` varchar(25) DEFAULT NULL,
  `officebuilding` varchar(100) NOT NULL,
  `officeroom` varchar(100) NOT NULL,
  `phonenumber` bigint(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pictureurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `department_id`, `firstname`, `lastname`, `title`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`) VALUES
(100, 30, 'Kerry', 'Henson', 'Dr.', 'Dockery', '300F', 530383403934, 'henson@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/henson.jpg'),
(101, 30, 'Linda', 'Lynam', 'Ms.', 'Dockery', '300T', 1365321355, 'llynam@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/lynam.jpg'),
(113, 30, 'Sam', 'Ramanujan', NULL, 'Dockery', '300J', 3482343804, 'ramanujan@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/ramanujan.jpg'),
(117, 40, 'Steven', 'Popejoy', NULL, 'Dockery', '200J', 843843435, 'popejoy@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/popejoy.jpg'),
(118, 40, 'Deni', 'Oas', NULL, 'Dockery', '301F', 4480543534, 'oas@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/doas.jpg'),
(119, 30, 'Someswar', 'Kesh', NULL, 'Dockery', '401B', 6605430000, 'kesh@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/kesh.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `professor_officehours`
--

CREATE TABLE IF NOT EXISTS `professor_officehours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` varchar(255) NOT NULL,
  `times` varchar(255) NOT NULL,
  `professor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `professor_id` (`professor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `professor_officehours`
--

INSERT INTO `professor_officehours` (`id`, `days`, `times`, `professor_id`) VALUES
(14, 'Friday', '4 PM - 5 PM', 100),
(15, 'Monday', '11:30 AM - 3:30 PM', 113),
(17, 'Monday', '11:30 AM - 12:00 PM', 100),
(18, 'Thursday', '4:00 PM - 5:00 PM', 101),
(19, 'Tuesday', '11:30 AM - 12:30 AM', 118),
(21, 'Tuesday', '3:30 PM - 4:30 PM', 119),
(22, 'Wednesday & Thursday', '7:30 AM - 8:30 AM', 119);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nicename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nicename`, `email`, `type`, `status`, `theme`) VALUES
(3, 'johndoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'John Doe', 'johndoe@gmail.com', 'admin', 'enabled', 'slate'),
(10, 'marydoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Mary Doe', 'marydoe@ucmo.edu', 'poster', 'enabled', 'united'),
(11, 'kevindoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin Doe', 'kevindoe@ucmo.edu', 'editorposter', 'enabled', 'cyborg'),
(12, 'joedoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Joe Doe', 'joedoe@ucmo.edu', 'editor', 'enabled', 'yeti');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_department`
--
ALTER TABLE `access_department`
  ADD CONSTRAINT `dept_access_constr` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_dept_access_constraint` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `prof_dept_constraint` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor_officehours`
--
ALTER TABLE `professor_officehours`
  ADD CONSTRAINT `prof_study_hours_constr` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
