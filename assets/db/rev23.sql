-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2014 at 04:09 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `access_department`
--

INSERT INTO `access_department` (`id`, `user_id`, `department_id`) VALUES
(99, 12, 54),
(100, 12, 55),
(101, 12, 50),
(102, 11, 54),
(104, 11, 51),
(105, 12, 56),
(106, 11, 56);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `number`, `name`, `department_id`) VALUES
(1, 2665, 'Data Communication & LAN', 50),
(2, 4635, 'Web Programming', 50),
(3, 3850, 'Legal Environment of Business', 55),
(4, 2101, 'Financial Accounting', 54),
(5, 2102, 'Managerial Accounting', 54),
(6, 4660, 'Advanced Java', 50),
(7, 1111, 'Into to Aviation', 56),
(15, 2615, 'Introduction to Java', 50),
(16, 3636, 'Management Information Systems', 50),
(17, 3650, 'Database Management Systems', 50),
(18, 3660, 'System Analysis & Design', 50),
(19, 3670, 'User Experience Design', 50),
(20, 4680, 'Data Resource Management', 50),
(21, 4690, 'System Architecture & Dev', 50);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `prefix`) VALUES
(50, 'Computer Information Systems', 'CIS'),
(51, 'Marketing', 'MKT'),
(53, 'Economics', 'ECON'),
(54, 'Accounting', 'ACCT'),
(55, 'Business Law', 'BLAW'),
(56, 'Aviation', 'AVIA'),
(60, 'Finance', 'FIN');

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
  `date_expiration` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_modified` (`user_modified`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `body`, `date_created`, `date_modified`, `date_expiration`, `user_id`, `user_modified`) VALUES
(3, 'Second Test Post', 'This is the body of the second test post, and hopefully it won''t crash with some &quot;double quotes&quot; and ''single quotes''.', '1414470085', '1416111237', '1415944800', 10, 10),
(4, 'Nathan''s Test Post', 'Here is an example of a short body to the example post.', '1414470182', '1414476163', '1414645200', 10, 10),
(5, 'Another test post', 'Here is another test so we have more data to work with tomorrow.', '1414475123', '1414475123', '1417845600', 10, 10),
(6, 'Expired Post', 'Here''s an example of an expired post. It shouldn''t show up in the public version of the app.', '1414475145', '1416111225', '1417240800', 10, 10);

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
  `rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `department_id`, `firstname`, `lastname`, `title`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`, `status`, `rank`) VALUES
(127, 50, 'Kerry', 'Henson', NULL, 'Dockery', '300C', 6604222705, 'henson@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/henson.jpg', 'enabled', 5),
(128, 55, 'Steven', 'Popejoy', NULL, 'Dockery', '302H', 3048234, 'popejoy@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/popejoy.jpg', 'enabled', 0),
(129, 54, 'Bob', 'Showers', NULL, 'Dockery', '300E', 348230428, 'showers@ucmo.edu', 'https://www.ucmo.edu/acct/facstaff/images/showers_175px.jpg', 'enabled', 1),
(130, 50, 'Sam', 'Ramanujan', NULL, 'Dockery', '301G', 6604410496, 'ramanujan@ucmo.edu', 'https://www.ucmo.edu/cis/faculty/images/ramanujan.jpg', 'enabled', 0),
(133, 50, 'Someswar', 'Kesh', NULL, 'Dockery', '400M', 6604410721, 'kesh@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Kesh_wb_000.jpg', 'enabled', 0),
(134, 50, 'Silvana', 'Faja', NULL, 'Dockery', '301I', 6604412423, 'sfaja@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Faja_wb.jpg', 'enabled', 1),
(135, 50, 'Linda', 'Lynam', NULL, 'Dockery', '301E', 6604222049, 'llynam@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Lynam_wb.jpg', 'enabled', 0),
(136, 50, 'Mustafa', 'Kamal', NULL, 'Dockery', '300D', 6605434243, 'kamal@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Kamal_wb.jpg', 'enabled', 1),
(137, 50, 'Qingxiong', 'Ma', NULL, 'Dockery', '300B', 6604411694, 'qma@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Ma_wb.jpg', 'enabled', 0),
(138, 50, 'Narasimha', 'Paravastu', NULL, 'Dockery', '301A', 6604418244, 'paravastu@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/wdrivenp_000.jpg', 'enabled', 0),
(139, 50, 'Jason', 'Ploch', NULL, 'Dockery', '301', 5736947219, 'ploch@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/ploch.jpg', 'enabled', 0),
(140, 50, 'Pauline', 'Ratnasingam', NULL, 'Dockery', '301A', 6605438606, 'ratnasingam@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/Ratnasingam_wb_000.jpg', 'enabled', 0),
(141, 50, 'Steven', 'Ake', NULL, 'WDE', '1600', 6605438154, 'ake@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/ake.jpg', 'enabled', 0),
(142, 50, 'Michele', 'Muin', NULL, 'Dockery', '400L', 6605434631, 'muin@ucmo.edu', 'http://www.ucmo.edu/cis/faculty/images/muin_000.jpg', 'enabled', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `professor_courses`
--

INSERT INTO `professor_courses` (`id`, `days`, `time`, `status`, `professor_id`, `course_id`) VALUES
(13, 'MWF', '9 AM - 9:50 AM', 'enabled', 129, 4),
(14, 'MWF', '10 AM - 10:50 AM', 'enabled', 129, 4),
(17, 'TR', '11 AM - 12:15 PM', 'enabled', 128, 3),
(29, 'Tuesday, Thursday', '2:00 PM', 'enabled', 127, 19),
(30, 'Monday, Wednesday', '2:00 PM', 'enabled', 127, 2),
(31, 'Tuesday, Thursday', '11:00 AM', 'enabled', 127, 21),
(32, 'Tuesday, Thursday', '11:00 AM', 'enabled', 137, 17),
(43, 'Tuesday, Thursday', '2:00 PM', 'enabled', 137, 18);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `professor_officehours`
--

INSERT INTO `professor_officehours` (`id`, `days`, `times`, `professor_id`) VALUES
(1, 'Wednesday', '2 PM - 4:30 PM', 127),
(3, 'Thursday', '2:30 PM - 4:30 PM', 129),
(7, 'Tuesday, Thursday', '3:00 PM - 4:00 PM', 137),
(8, 'Tuesday, Thursday', '5:00 PM - 6:00 PM', 137);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nicename`, `email`, `type`, `status`, `theme`) VALUES
(10, 'marydoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Mary Doe', 'marydoe@ucmo.edu', 'poster', 'enabled', 'simplex'),
(11, 'kevindoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin Doe', 'kevindoe@ucmo.edu', 'editorposter', 'enabled', 'simplex'),
(12, 'joedoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Joe Doe', 'joedoe@ucmo.edu', 'editor', 'enabled', 'simplex'),
(14, 'johndoe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'John Doe', 'johndoe@ucmo.edu', 'admin', 'enabled', 'simplex');

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
  ADD CONSTRAINT `course_prof_id_constr` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_prof_prof_id_constr` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professor_officehours`
--
ALTER TABLE `professor_officehours`
  ADD CONSTRAINT `prof_study_hours_constr` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
