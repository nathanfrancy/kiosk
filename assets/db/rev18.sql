-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2014 at 10:39 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `access_department`
--

INSERT INTO `access_department` (`id`, `user_id`, `department_id`) VALUES
(99, 12, 54),
(100, 12, 55),
(101, 12, 50);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `number`, `name`, `department_id`) VALUES
(1, 2665, 'Data Communication & LAN', 50),
(2, 4635, 'Web Programming', 50),
(3, 3850, 'Legal Environment of Business', 55),
(4, 2101, 'Financial Accounting', 54),
(5, 2102, 'Managerial Accounting', 54),
(6, 4660, 'Advanced Java', 50);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `prefix`) VALUES
(50, 'Computer Information Systems', 'CIS'),
(51, 'Marketing', 'MKT'),
(52, 'Management', 'MGT'),
(53, 'Economics', 'ECON'),
(54, 'Accounting', 'ACCT'),
(55, 'Business Law', 'BLAW');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `date_modified` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_modified` (`user_modified`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `body`, `date_created`, `date_modified`, `user_id`, `user_modified`) VALUES
(1, 'First Post', 'This is an example of a first post with a large enough body to be displayed on the page. Hopefully this can be easily edited and pulled out of the database for the users to see.', '1414101787', '1414116499', 10, 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `department_id`, `firstname`, `lastname`, `title`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`, `status`) VALUES
(127, 50, 'Kerry', 'Henson', NULL, 'Dockery', '303D', 40385434509, 'henson@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/henson.jpg', 'enabled'),
(128, 55, 'Steven', 'Popejoy', NULL, 'Dockery', '302H', 3048234, 'popejoy@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/popejoy.jpg', 'enabled'),
(129, 54, 'Bob', 'Showers', NULL, 'Dockery', '300E', 348230428, 'showers@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/showers_175px.jpg', 'enabled'),
(130, 50, 'Sam', 'Ramanujan', NULL, 'Dockery', '403G', 3048324234, 'ramanujan@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/ramanujan.jpg', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `professor_courses`
--

CREATE TABLE IF NOT EXISTS `professor_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `professor_id` (`professor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `professor_courses`
--

INSERT INTO `professor_courses` (`id`, `days`, `time`, `status`, `professor_id`, `course_id`) VALUES
(13, 'MWF', '9 AM - 9:50 AM', 'enabled', 129, 4),
(14, 'MWF', '10 AM - 10:50 AM', 'enabled', 129, 4),
(15, 'MWF', '11 AM - 11:50 AM', 'enabled', 129, 4),
(16, 'T', '6 PM - 8:45 PM', 'enabled', 130, 6),
(17, 'TR', '11 AM - 12:15 PM', 'enabled', 128, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `professor_officehours`
--

INSERT INTO `professor_officehours` (`id`, `days`, `times`, `professor_id`) VALUES
(1, 'Wednesday', '2 PM - 4:30 PM', 127),
(3, 'Thursday', '2:30 PM - 4:30 PM', 129);

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
(3, 'johndoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'John Doe', 'johndoe@gmail.com', 'admin', 'enabled', 'yeti'),
(10, 'marydoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Mary Doe', 'marydoe@ucmo.edu', 'poster', 'enabled', 'yeti'),
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
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `dept_course_constraint` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_mod_post_constraint` FOREIGN KEY (`user_modified`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_constra` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `prof_dept_constraint` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor_courses`
--
ALTER TABLE `professor_courses`
  ADD CONSTRAINT `course_prof_prof_id_constr` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_prof_id_constr` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor_officehours`
--
ALTER TABLE `professor_officehours`
  ADD CONSTRAINT `prof_study_hours_constr` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
