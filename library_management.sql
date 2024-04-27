-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 04:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', 'password'),
(2, 'admin2@admin.com', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `status`, `created`, `modified`) VALUES
(1, 'The Hidden Life of Trees', 'Peter Wohlleben', 3, 1, '2023-06-01 01:12:26', '2023-05-31 14:12:26'),
(2, 'Cosmos', 'Carl Sagan', 2, 0, '2023-06-01 01:12:26', '2023-05-31 14:12:26'),
(3, 'The Vital Question', 'Nick Lane, Kevin Pariseau', 3, 0, '2023-06-01 01:12:26', '2023-05-31 14:12:26'),
(6, 'The Diary of a Young Girl', 'Anne Frank', 1, 0, '2023-06-01 01:12:26', '2023-05-30 23:12:21'),
(7, 'Pride and Prejudice', 'Jane Austen', 4, 1, '2023-06-01 01:13:45', '2023-05-30 23:13:39'),
(8, 'The Disordered Cosmos', 'Chanda Prescod-Weinstein', 2, 0, '2023-06-01 01:14:13', '2023-05-30 23:14:08'),
(9, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 1, 1, '2023-06-01 01:18:36', '2023-05-30 23:18:31'),
(10, 'Brief Answers to the Big Questions', 'Stephen Hawking', 2, 0, '2023-06-06 17:10:01', '2023-06-05 15:09:51'),
(11, 'The Great Gatsby', ' F. Scott Fitzgerald', 4, 0, '2023-06-06 17:10:01', '2023-06-05 15:09:51'),
(40, 'The Earth Transformed', 'Peter Frankopan', 1, 0, '2024-03-27 17:26:53', '2024-03-27 16:26:53'),
(44, 'The Picture of Dorian Grey', 'Oscar Wilde', 4, 0, '2024-03-27 17:29:52', '2024-03-27 16:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`borrow_id`, `book_id`, `user_id`, `borrow_date`, `return_date`) VALUES
(98, 9, 1, '2024-04-08', '2024-04-22'),
(101, 7, 1, '2024-04-15', '2024-04-29'),
(102, 1, 2, '2024-04-19', '2024-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`, `modified`) VALUES
(1, 'History', '2023-06-01 00:35:07', '2023-05-30 14:34:33'),
(2, 'Astronomy', '2023-06-01 00:35:07', '2023-05-30 14:34:33'),
(3, 'Biology', '2023-06-01 00:35:07', '2023-05-30 14:34:33'),
(4, 'Literature', '2023-06-01 00:35:07', '2023-05-30 14:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `checked_out_book` tinyint(1) DEFAULT NULL,
  `overdue_book` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `checked_out_book`, `overdue_book`) VALUES
(1, 'student1@test.com', 'password', 'Dan', 'Bings', 0, 0),
(2, 'student2@test.com', 'password', 'Lucy', 'Skywalker', 0, 0),
(11, 'voyager@captain.com', 'password', 'Kathryn', 'Janeway', NULL, NULL),
(12, 'discovery@captain.com', '$2y$10$d8VTRKSwQN2q19mwjeAMiOFSPwOM0GlbA0XPszlp.5Uih2bxaVlMG', 'Christopher', 'Pike', NULL, NULL),
(13, 'edit', '$2y$10$4poD70AeKtlN9e/Su5AR5OhdB7hEtqJFTDjanOtRA9ri/S2YW7mtm', 'edit', 'edit', NULL, NULL),
(14, 'deepspace9@captain.com', '$2y$10$lUgOjECizP/kjnCR8r6BuOV4Q0rePuqXoVgFm8vSVpdp5SSlUjRWa', 'Benjamin', 'Sisko', NULL, NULL),
(15, 'enterprise@captain.com', '$2y$10$j8KwxNVH1wQldx.rh307meqcNpCrRFA4sWqSk.NIwPk.T74CeZyZS', 'James T.', 'Kirk', NULL, NULL),
(16, 'student3@test.com', '$2y$10$UKfZKFPDhmJixcYhTnKdPecYE5H1LGoEpbe1D4AblX39EwIpjc4Ma', 'Alice', 'Canyon', NULL, NULL),
(17, 'jade@jade.com', '$2y$10$95Mem0aes6DO1kczRgM7Sul4Pw1/ywlqUEmZVEu07Sg8offTl9xDu', 'Loius', 'Lane', NULL, NULL),
(18, 'nextgen@captain.com', '$2y$10$4xXSI4Uyds5OCo.VmfPM..Gv3CHRFjv2bh1YUjoJwMK3cQ5YVc5FC', 'Jean-Luc', 'Picard', NULL, NULL),
(19, 'sw@test.com', '$2y$10$SQeAIjwdykxlhYgnVuuYGekvCIWwWSkUwBOAz9d4cxc6fNuuYIsQa', 'Leia', 'Skywalker', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `borrowed_books_ibfk_2` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `borrowed_books_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `borrowed_books_ibfk_4` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
