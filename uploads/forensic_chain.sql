-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 10:54 PM
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
-- Database: `forensic_chain`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `expert_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`log_id`, `expert_id`, `action`, `timestamp`) VALUES
(4, 1, 'Uploaded file \'Screenshot 2025-04-06 003202.png\' with IPFS hash 8cca183335ada9a7a7ce1356c2df17e7', '2025-04-05 19:41:32'),
(5, 1, 'Uploaded file \'Screenshot 2025-04-06 015220.png\' with IPFS hash c7db666b49f8840ea5f5b6d5c5035e15', '2025-04-05 20:40:20'),
(6, 1, 'Uploaded file \'Screenshot 2024-01-26 174052.png\' with IPFS hash acfc2bb01af6d59a3f5e1a4a2d355093', '2025-04-05 20:45:04'),
(7, 1, 'Uploaded file \'Screenshot 2024-07-10 235401.png\' with IPFS hash 74e4dfe3287a19f7cecd3aba5e2562ab', '2025-04-05 20:48:41'),
(8, 1, 'Uploaded file \'Screenshot (12).png\' with IPFS hash df75e929a0e03c2a3ac0c2153ff856c2', '2025-04-05 20:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `blockchain_log`
--

CREATE TABLE `blockchain_log` (
  `id` int(11) NOT NULL,
  `expert_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `ipfs_hash` varchar(255) NOT NULL,
  `action` varchar(100) DEFAULT 'Added to Blockchain'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blockchain_log`
--

INSERT INTO `blockchain_log` (`id`, `expert_id`, `file_name`, `file_hash`, `timestamp`, `ipfs_hash`, `action`) VALUES
(1, 1, 'Screenshot 2025-04-06 015220.png', '', '2025-04-05 22:43:19', 'c7db666b49f8840ea5f5b6d5c5035e15', 'File added to blockchain'),
(2, 1, 'Screenshot 2025-04-06 003202.png', '', '2025-04-05 22:43:24', '8cca183335ada9a7a7ce1356c2df17e7', 'File added to blockchain'),
(3, 1, 'Screenshot 2024-01-26 174052.png', '', '2025-04-05 22:45:17', 'acfc2bb01af6d59a3f5e1a4a2d355093', 'File added to blockchain'),
(4, 1, 'Screenshot 2024-07-10 235401.png', '', '2025-04-06 02:18:46', '74e4dfe3287a19f7cecd3aba5e2562ab', 'Added to Blockchain'),
(5, 1, 'Screenshot (12).png', '', '2025-04-06 02:20:42', 'df75e929a0e03c2a3ac0c2153ff856c2', 'Added to Blockchain');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE `experts` (
  `expert_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `usertype` enum('expert','higher_authority') NOT NULL DEFAULT 'expert',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`expert_id`, `username`, `password`, `name`, `email`, `usertype`, `created_at`) VALUES
(1, 'sailesh', '$2y$10$TIuetbS9V2e5tQM07cuoKe0ATnSS3T9qe1rmvVcMHKy2o6z1sAIae', 'sailesh pulukuri', 'sailesh@gmail.com', 'higher_authority', '2025-04-05 19:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `ipfs_storage`
--

CREATE TABLE `ipfs_storage` (
  `id` int(11) NOT NULL,
  `ipfs_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `ipfs_hash` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ipfs_storage`
--

INSERT INTO `ipfs_storage` (`id`, `ipfs_id`, `file_id`, `ipfs_hash`, `uploaded_at`, `created_at`) VALUES
(0, 4, 4, '8cca183335ada9a7a7ce1356c2df17e7', '2025-04-05 19:41:32', '2025-04-06 01:11:32'),
(0, 5, 5, 'c7db666b49f8840ea5f5b6d5c5035e15', '2025-04-05 20:40:20', '2025-04-06 02:10:20'),
(0, 6, 6, 'acfc2bb01af6d59a3f5e1a4a2d355093', '2025-04-05 20:45:04', '2025-04-06 02:15:04'),
(0, 7, 7, '74e4dfe3287a19f7cecd3aba5e2562ab', '2025-04-05 20:48:41', '2025-04-06 02:18:41'),
(0, 8, 8, 'df75e929a0e03c2a3ac0c2153ff856c2', '2025-04-05 20:50:27', '2025-04-06 02:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `file_id` int(11) NOT NULL,
  `expert_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`file_id`, `expert_id`, `file_name`, `file_path`, `upload_date`) VALUES
(4, 1, 'Screenshot 2025-04-06 003202.png', 'uploads/Screenshot 2025-04-06 003202.png', '2025-04-05 19:41:32'),
(5, 1, 'Screenshot 2025-04-06 015220.png', 'uploads/Screenshot 2025-04-06 015220.png', '2025-04-05 20:40:20'),
(6, 1, 'Screenshot 2024-01-26 174052.png', 'uploads/Screenshot 2024-01-26 174052.png', '2025-04-05 20:45:04'),
(7, 1, 'Screenshot 2024-07-10 235401.png', 'uploads/Screenshot 2024-07-10 235401.png', '2025-04-05 20:48:41'),
(8, 1, 'Screenshot (12).png', 'uploads/Screenshot (12).png', '2025-04-05 20:50:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `blockchain_log`
--
ALTER TABLE `blockchain_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`expert_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ipfs_storage`
--
ALTER TABLE `ipfs_storage`
  ADD PRIMARY KEY (`ipfs_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blockchain_log`
--
ALTER TABLE `blockchain_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `expert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ipfs_storage`
--
ALTER TABLE `ipfs_storage`
  MODIFY `ipfs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`expert_id`);

--
-- Constraints for table `blockchain_log`
--
ALTER TABLE `blockchain_log`
  ADD CONSTRAINT `blockchain_log_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`expert_id`) ON DELETE CASCADE;

--
-- Constraints for table `ipfs_storage`
--
ALTER TABLE `ipfs_storage`
  ADD CONSTRAINT `ipfs_storage_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`file_id`);

--
-- Constraints for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD CONSTRAINT `uploaded_files_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`expert_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
