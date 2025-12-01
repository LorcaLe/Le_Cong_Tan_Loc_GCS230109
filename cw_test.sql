-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2025 lúc 04:43 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cw_test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `reply_message` text DEFAULT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `sender_name`, `sender_email`, `subject`, `message`, `reply_message`, `status`, `created_at`, `replied_at`) VALUES
(9, 10, 'Loc', 'loc@ex.com', 'I have a question for you', 'Nếu tôi không bắn được tơ nhện nữa là do tôi bị gì ?', 'Là do m vừa tỉnh dậy đấy', 'replied', '2025-11-16 18:46:25', '2025-11-16 18:46:52'),
(11, 10, 'LorcaLe', 'loc123@ex.com', 'I have a question', 'Are you gay ?', 'No', 'replied', '2025-11-21 08:59:42', '2025-11-21 09:00:00'),
(12, 10, 'LorcaLe', 'loc123@ex.com', 'I have a question', '1+1=', '2', 'replied', '2025-11-25 08:45:55', '2025-11-25 08:47:23'),
(13, 10, 'Lorca Le', 'loc123@ex.com', 'I have a question', 'Which programming language should i learn?', 'Python, because it supports AI programming well and is trending.', 'replied', '2025-11-29 10:49:29', '2025-11-29 12:23:18'),
(14, 13, 'Johnny', 'john@ex.com', 'I have a question', 'What is the limit of INT variable?', 'The maximum integer value for an int data type is 2,147,483,647. This is the highest positive number that can be stored in a standard signed 32-bit integer variable. The int data type is one of the most fundamental data types in many programming languages, including C, C++, and Java.', 'replied', '2025-11-29 15:42:06', '2025-11-29 15:42:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `moduleName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `module`
--

INSERT INTO `module` (`id`, `moduleName`) VALUES
(1, 'COMP1770'),
(4, 'DES1889'),
(5, 'COMP1841');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `question`
--

INSERT INTO `question` (`id`, `text`, `date`, `img`, `userid`, `moduleid`) VALUES
(22, 'I\'m spider ', '2025-11-17', '1763318763_tom-holland-films-scenes-new-109163160-175426787459465253461.webp', 10, 4),
(31, 'The most popular programming language is JavaScript', '2025-11-29', '1764413983_R.png', 8, 1),
(32, 'Which language is best for backend?', '2025-11-29', '1764430891_What-is-back-end-development-2.jpg', 13, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `reset_token`, `reset_expires`) VALUES
(8, 'admin', 'admin@ex.com', '$2y$10$2.fGD/VSsK78E3eYU4/z8OpTiYMK9oxFdwYFBandIeYGN58PEPmOm', 'admin', NULL, NULL),
(10, 'Lorca Le', 'loc123@ex.com', '$2y$10$g.bPqcNmKM.yzRv3z3lv/uQeAAG5ihBd8fhOSpVrNAkUCCSxQkFPS', 'user', NULL, NULL),
(13, 'Johnny', 'john@ex.com', '$2y$10$HkJzijVHBIoDKCU7TvtqZOGsrYKlvRp790ZQ4t73gHVyoRJqEz/vW', 'user', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_user` (`user_id`);

--
-- Chỉ mục cho bảng `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_user` (`userid`),
  ADD KEY `fk_question_module` (`moduleid`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_unique` (`reset_token`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_module` FOREIGN KEY (`moduleid`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_question_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
