-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2014 at 05:16 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `access_department`
--

INSERT INTO `access_department` (`id`, `user_id`, `department_id`) VALUES
(89, 12, 42),
(90, 12, 46),
(91, 12, 47);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `number`, `name`, `department_id`) VALUES
(1, 4690, 'System Architecture & Dev', 42);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `prefix`) VALUES
(42, 'Computer Information Systems', 'CIS'),
(43, 'Marketing', 'MKT'),
(44, 'Management', 'MGT'),
(45, 'Finance', 'FIN'),
(46, 'Accounting', 'ACCT'),
(47, 'Business Law', 'BLAW');

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
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `department_id`, `firstname`, `lastname`, `title`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`, `status`) VALUES
(121, 42, 'Kerry', 'Henson', NULL, 'Dockery', '300D', 6604222705, 'dochenson@charter.net', 'https://www.ucmo.edu/cis/faculty/images/henson.jpg', 'enabled'),
(122, 42, 'Linda', 'Lynam', NULL, 'Dockery', '302B', 6605433219, 'lynam@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/lynam.jpg', 'enabled'),
(123, 46, 'Dawn', 'Anderson', NULL, 'Dockery', '401H', 583402348, 'danderson@ucmo.edu', 'http://www.ucmo.edu/acct/facstaff/images/anderson_dawn.jpg', 'enabled'),
(124, 46, 'Bob', 'Showers', NULL, 'Dockery', '404G', 304823432, 'hartley@ucmo.edu', 'http://www.ucmo.edu/acct/facstaff/images/showers_130px.jpg', 'enabled');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `professor_officehours`
--

INSERT INTO `professor_officehours` (`id`, `days`, `times`, `professor_id`) VALUES
(25, 'Monday, Wednesday', '11:30 AM - 12:30 PM', 121),
(26, 'Thursday', '10:00 Am - 11:00 AM', 121),
(27, 'Thursday', '4:30 - 5:30', 122);

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
(3, 'johndoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'John Doe', 'johndoe@gmail.com', 'admin', 'enabled', 'cyborg'),
(10, 'marydoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Mary Doe', 'marydoe@ucmo.edu', 'poster', 'enabled', 'united'),
(11, 'kevindoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin Doe', 'kevindoe@ucmo.edu', 'editorposter', 'enabled', 'cyborg'),
(12, 'joedoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Joe Doe', 'joedoe@ucmo.edu', 'editor', 'enabled', 'cyborg');

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
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `dept_course_constraint` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
