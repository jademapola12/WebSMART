-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 09:35 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websmart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_list`
--

CREATE TABLE `archive_list` (
  `id` int(30) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `year` year(4) NOT NULL,
  `title` text NOT NULL,
  `type` int(1) NOT NULL,
  `style` int(1) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `agenda` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `members` text NOT NULL,
  `banner_path` text NOT NULL,
  `document_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `student_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `views_count` int(11) NOT NULL DEFAULT 0,
  `search_count` int(8) NOT NULL DEFAULT 0,
  `submitted_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_list`
--

CREATE TABLE `curriculum_list` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `curriculum_list`
--

INSERT INTO `curriculum_list` (`id`, `department_id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(21, 11, 'BACHELOR OF SCIENCE IN PSYCHOLOGY', '', 1, '2024-08-18 21:39:42', '2024-08-18 21:40:40'),
(22, 12, 'BACHELOR OF SCIENCE IN ACCOUNTANCY', '', 1, '2024-08-18 21:40:19', NULL),
(23, 12, 'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT', '', 1, '2024-08-18 21:40:56', NULL),
(24, 12, 'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN MARKETING MANAGEMENT', '', 1, '2024-08-18 21:41:12', NULL),
(25, 13, 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '', 1, '2024-08-18 21:42:09', NULL),
(26, 13, 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', 1, '2024-08-18 21:42:22', NULL),
(27, 14, 'BACHELOR OF ELEMENTARY EDUCATION', '', 1, '2024-08-18 21:42:49', NULL),
(28, 14, 'BACHELOR OF SECONDARY EDUCATION MAJOR IN ENGLISH', '', 1, '2024-08-18 21:43:13', NULL),
(29, 14, 'BACHELOR OF SECONDARY EDUCATION MAJOR IN FILIPINO', '', 1, '2024-08-18 21:43:26', NULL),
(30, 14, 'BACHELOR OF SECONDARY EDUCATION MAJOR IN MATHEMATICS', '', 1, '2024-08-18 21:43:41', NULL),
(31, 14, 'BACHELOR OF SECONDARY EDUCATION MAJOR IN SOCIAL SCIENCE', '', 1, '2024-08-18 21:43:57', NULL),
(32, 15, 'BACHELOR OF SCIENCE IN COMPUTER ENGINEERING', '', 1, '2024-08-18 21:44:50', NULL),
(33, 15, 'BACHELOR OF SCIENCE IN ELECTRONICS ENGINEERING', '', 1, '2024-08-18 21:45:04', NULL),
(34, 15, 'BACHELOR OF SCIENCE IN INDUSTRIAL ENGINEERING', '', 1, '2024-08-18 21:45:17', NULL),
(35, 16, 'BACHELOR OF SCIENCE IN NURSING', '', 1, '2024-08-18 21:46:06', NULL),
(36, 17, 'MASTER OF BUSINESS ADMINISTRATION', '', 1, '2024-08-18 21:46:32', NULL),
(37, 17, 'MASTER OF ARTS IN EDUCATION', '', 1, '2024-08-18 21:46:45', NULL),
(38, 17, 'MASTER OF ARTS IN PSYCHOLOGY', '', 1, '2024-08-18 21:46:59', NULL),
(39, 18, 'ENHANCED SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS (E-STEM) STRAND', '', 1, '2024-08-18 21:47:26', NULL),
(40, 18, 'ENHANCED HUMANITIES AND SOCIAL SCIENCES (E-HUMSS) STRAND', '', 1, '2024-08-18 21:47:39', NULL),
(41, 18, 'ENHANCED ACCOUNTANCY, BUSINESS, AND MANAGEMENT (E-ABM) STRAND', '', 1, '2024-08-18 21:47:52', NULL),
(42, 18, 'ENHANCED TECHNICAL, VOCATIONAL, AND LIVELIHOOD (E-TVL) STRAND', '', 1, '2024-08-18 21:48:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(11, 'COLLEGE OF ARTS AND SCIENCE', 'College of Arts and Sciences holds in the ideals of learning by doing, making connections, and creating a community of progress that promotes social awareness and involvement by introducing students to advanced academic pursuits in promoting globally competitive professionals in the field of Psychology and in the programs for liberal arts education in the future.', 1, '2024-08-18 21:34:27', '2024-12-04 11:24:36'),
(12, 'COLLEGE OF BUSINESS, ACCOUNTANCY, AND ADMINISTRATION', 'Fostering excellence in business education, the College of Business, Accountancy, and Administration (CBAA) empowers its students with administrative competencies in the fields of business, accounting, and administration to enable them to contribute to national development.', 1, '2024-08-18 21:35:27', '2024-12-04 11:25:14'),
(13, 'COLLEGE OF COMPUTING STUDIES', 'The College of Computing Studies (CCS) offers undergraduate programs in the fields of Computer Science, Information Systems, and Information Technology. It aims to produce value-driven and innovative computing professionals equipped with knowledge and skills needed in the IT industry, particularly with specializations in web computing, application development, service management, multimedia, mobile development, game development, data science, and artificial intelligence.', 1, '2024-08-18 21:35:44', '2024-12-04 11:25:42'),
(14, 'COLLEGE OF EDUCATION', 'True to its vision of delivering quality and relevant teacher education, the College of Education (COED) aims to produce knowledge professionals who transform lives and nurture intellectual maturity and moral integrity of the students. Through collaborative engagement which leads to academic success, the college targets to empower future educators through advocacy, linkages, and extension.', 1, '2024-08-18 21:36:06', '2024-12-04 11:27:27'),
(15, 'COLLEGE OF ENGINEERING', 'The College of Engineering (COE) envisions itself as a frontrunner of engineering education in the region, producing professionals in the fields of Computer Engineering, Electronics Engineering, and Industrial Engineering. With commitment to community development and nation-building, the College develops competitive and value-laden future engineers specializing in artificial intelligence, production engineering, software development, telecommunication, microelectronics, and power electronics.', 1, '2024-08-18 21:36:28', '2024-12-04 11:26:28'),
(16, 'COLLEGE OF HEALTH AND ALLIED SCIENCE', 'Equipping students with competence and commitment to preserve humanity as stewards of God’s creation, the College of Health and Allied Sciences (CHAS) aims to produce healthcare professionals in the fields of Nursing and Psychology who can provide effective and efficient health services compliant with global standards.', 1, '2024-08-18 21:36:53', '2024-12-04 11:26:41'),
(17, 'GRADUATE SCHOOL', 'Graduate studies at Pamantasan ng Cabuyao (University of Cabuyao) give students a deeper understanding of business, science, and education. Curiosity, imaginative play, and a desire to solve problems for the benefit of society are combined with critical thinking. The Graduate School curriculum encourages students to create and apply original theories and concepts that will lead to new ideas and perspectives for the future.', 1, '2024-08-18 21:37:09', '2024-12-04 11:27:04'),
(18, 'SENIOR HIGH SCHOOL', 'The Pamantasan ng Cabuyao-Senior High School Department (PnC-SHS) prepares its students for higher education and future careers in the industry through effective delivery of instruction, adequate industry immersion experience, and active engagement in research endeavors.\r\n\r\nIts strand offerings follow the recommended curriculum by the Department of Education (DepEd) with additional appropriate subjects to provide students with a strong academic foundation in preparation for the tertiary level.', 1, '2024-08-18 21:37:38', '2024-12-04 11:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `forms_list`
--

CREATE TABLE `forms_list` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `document_path` text NOT NULL,
  `student_id` int(30) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `submitted_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reference_style`
--

CREATE TABLE `reference_style` (
  `id` int(11) NOT NULL,
  `style` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reference_style`
--

INSERT INTO `reference_style` (`id`, `style`) VALUES
(1, 'APA (American Psychological Association)'),
(2, ' MLA (Modern Language Association)'),
(3, 'Chicago / Tubarian'),
(4, ' IEEE (Institute of Electrical and Electronics Engineers)'),
(5, 'Harvard'),
(6, 'Vancouver'),
(7, 'AMA (American Medical Association'),
(8, 'ACS (American Chemical Society)');

-- --------------------------------------------------------

--
-- Table structure for table `research_type`
--

CREATE TABLE `research_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_type`
--

INSERT INTO `research_type` (`id`, `type`) VALUES
(1, 'Quantitative Research'),
(2, 'Qualitative Research'),
(3, 'Mixed Methods Research'),
(4, 'Descriptive Research'),
(5, 'Experimental Research'),
(6, 'Correlational Research'),
(7, 'Exploratory Research'),
(8, ' Action Research'),
(9, 'Case Study Research'),
(10, 'Longitudinal Research'),
(11, 'Cross-sectional Research');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `department_id` int(30) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `student_id` text NOT NULL,
  `user_type` varchar(255) DEFAULT 'student',
  `password` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `avatar` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `type` int(11) DEFAULT 1,
  `expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `firstname`, `middlename`, `lastname`, `department_id`, `curriculum_id`, `student_id`, `user_type`, `password`, `gender`, `status`, `avatar`, `date_created`, `date_updated`, `type`, `expiration_date`) VALUES
(1, 'Jade Lester', 'A', 'Mapola', 13, 25, '1903124', 'student', '8827a41122a5028b9808c7bf84b9fcf6', 'Male', 0, '', '2024-11-29 13:45:46', '2025-04-22 13:13:31', 1, '2025-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'WebSMART'),
(6, 'short_name', 'WebSMART'),
(11, 'logo', 'uploads/logo-1723986711.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1723986435.png'),
(15, 'content', 'Array'),
(16, 'email', 'pncusg@gmail.com'),
(17, 'contact', 'https://pnc.edu.ph/'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'Cabuyao, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'PNC', NULL, 'MISD', 'PNCMisd', 'c397e5bf6b1c40195a54239786e3e3b4', 'uploads/admins/admin-1.png?v=1744102202', NULL, 2, 1, '2021-01-20 14:02:37', '2025-04-08 16:50:02'),
(2, 'PNC', NULL, 'VPre', 'IamVPre', 'e10adc3949ba59abbe56e057f20f883e', 'uploads/admins/admin-1.png?v=1728481960', '2025-04-04 04:35:32', 2, 1, '2025-04-04 10:36:37', '2025-04-04 10:58:47'),
(3, 'PNC', NULL, 'LIBRARIAN', 'IamLibrarian', 'f32436e179abff439d51be39e90783a6', NULL, '2025-04-04 04:59:00', 2, 1, '2025-04-04 10:59:30', '2025-04-04 11:02:09'),
(18, 'Arcelito', NULL, 'Quiatchon', 'IamProfArcelito', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, 3, 1, '2025-04-04 11:08:01', '2025-04-08 15:42:36'),
(19, 'Luigi Kim', NULL, 'Flora', 'IamProfKim', '6fad96fb411933d8426fcb7163caf9a4', NULL, NULL, 3, 1, '2025-04-04 11:09:51', NULL),
(20, 'Ramiro', NULL, 'Dela Cruz', 'IamProfRamiro', '7e2f6c5a695c7cd84432dc5c3c2a9ff3', NULL, NULL, 3, 1, '2025-04-04 11:10:24', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_list`
--
ALTER TABLE `archive_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`) USING HASH,
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms_list`
--
ALTER TABLE `forms_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`) USING HASH,
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`student_id`) USING HASH,
  ADD KEY `department_id` (`department_id`),
  ADD KEY `curriculum_id` (`curriculum_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `archive_list`
--
ALTER TABLE `archive_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `forms_list`
--
ALTER TABLE `forms_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archive_list`
--
ALTER TABLE `archive_list`
  ADD CONSTRAINT `archive_list_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD CONSTRAINT `curriculum_list_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_list`
--
ALTER TABLE `student_list`
  ADD CONSTRAINT `student_list_ibfk_1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_list_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
