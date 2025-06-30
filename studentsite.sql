-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 05:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `teacher_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `description`, `course_id`, `due_date`, `created_at`, `teacher_id`) VALUES
(1, 'MATHS', '1+1=?', NULL, '2025-06-02', '2025-06-29 16:20:11', '0'),
(2, 'science', 'what do you do when theres a mercury spiilage', NULL, '2025-06-30', '2025-06-29 16:21:11', '0');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent','Late') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `date`, `status`) VALUES
(1, 1, 1, '2025-06-20', 'Present'),
(2, 1, 2, '2025-06-20', 'Late'),
(3, 2, 1, '2025-06-20', 'Absent'),
(4, 2, 1, '2025-06-11', 'Late');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`) VALUES
(1, 'Mathematics', NULL),
(2, 'Science', NULL),
(3, 'Mathematics', 'Nice');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `grade` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `submission_id`, `grade`) VALUES
(1, 4, 'A'),
(2, 6, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `class` varchar(100) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `class`, `course_id`) VALUES
(1, 'Alicia Tan', 'alicia@example.com', NULL, NULL),
(2, 'Benjamin Lee', 'benjamin@example.com', NULL, NULL),
(3, 'DIVYAA RASHMIKA A/P MUNISWARAN', 'rashmikadivyaa@gmail.com', NULL, 1),
(4, 'Ramya aanishka', 'divyaarashmika43@gmail.com', NULL, 2),
(9, 'rhamya', '', NULL, NULL),
(18, 'blabla', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` varchar(5) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `assignment_id`, `student_id`, `file_path`, `submitted_at`, `grade`, `remarks`, `content`) VALUES
(1, 1, 9, NULL, '2025-06-29 17:16:59', NULL, NULL, '2'),
(2, 1, 9, NULL, '2025-06-29 17:17:08', NULL, NULL, '2'),
(3, NULL, 9, NULL, '2025-06-29 17:20:45', NULL, NULL, '3'),
(4, 1, 9, NULL, '2025-06-29 17:25:06', NULL, NULL, '3'),
(5, 2, 9, NULL, '2025-06-29 17:39:10', NULL, NULL, 'put sand'),
(6, 1, 18, NULL, '2025-06-30 10:39:30', NULL, NULL, '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `role` enum('teacher','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_pic`, `role`) VALUES
(1, 'divyrashh_', '$2y$10$9tIfhQj0soIB.Vd0uUuJzO8xUgETgB7u4xq9Uk15sfx63mGJzJv5O\r\n', NULL, 'student'),
(5, 'testuser', '$2y$10$giAGvtHh1rM3PLWhHmtlsuuR5.bJgf4ePU3Z0txEgpaX3NqJ0twKS', NULL, 'student'),
(6, 'testuser123', '$2y$10$AQaqWsY7VlRJ3UeGuk2o0eo/WUlFKWGGz1bSPN40aRIqHNQgdxLwW', NULL, 'student'),
(7, 'nishi', '$2y$10$DqZhrWlfI4dnI9tkCg5Srez3zWWNfclhdlljMSCORba5GkenhqLKq', 'uploads/6854d96e07790.png', 'student'),
(8, 'Divyaa', '$2y$10$EO7BHRiqwUEmUgyNqhqy1.6T.hDAWbvpltd4RsaBvqFQe3erlj3d.', NULL, 'student'),
(9, 'dovyaa', '$2y$10$oaHq1et2SWmDqq1H11X.6OsXJ8E7HudWWl7cm9QHOJu1uTYlWI7jO', NULL, 'student'),
(10, 'teacher1', 'password123', NULL, 'teacher'),
(11, 'student1', 'PASTE_HASH_HERE', NULL, 'student'),
(17, 'ramya', '$2y$10$.zpJQEfnQkV.IPJkpyntu.uRP4Mg97feBuxwV3QxE6O4ayS5ZXsDO', NULL, 'teacher'),
(18, 'blabla', '$2y$10$opu.KSm8H4o2EJKrfZM/iOMI5fNhL6tlJ6Ua1ZktmX72BNdQfdmum', NULL, 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
