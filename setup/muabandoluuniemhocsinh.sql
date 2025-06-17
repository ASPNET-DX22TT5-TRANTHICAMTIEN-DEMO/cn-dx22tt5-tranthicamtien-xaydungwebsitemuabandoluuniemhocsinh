-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 17, 2025 lúc 01:57 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS muabandoluuniemhocsinh;
USE muabandoluuniemhocsinh;

-- --------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Sổ tay', 'Sổ tay học sinh dễ thương'),
(2, 'Móc khóa', 'Nhiều loại móc khóa dễ thương'),
(3, 'Quà handmade', 'Tự làm bằng tay độc đáo');

-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','custumer') NOT NULL DEFAULT 'custumer',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'user1', '123456', 'user1@example.com', 'custumer'),
(2, 'user2', '123456', 'user2@example.com', 'custumer'),
(3, 'user3', '123456', 'user3@example.com', 'custumer');

-- --------------------------------------------------------

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `created_at`, `category_id`) VALUES
(1, 'Sổ tay màu hồng', 'Sổ tay màu hồng dễ thương, mang họa tiết con heo xinh', 25000.00, '001', NULL, '2025-06-17 10:43:13', 1),
(2, 'Móc khóa hình con heo', 'Móc khóa hình con heo dễ thương\nHọa tiết : con heo\nMàu sắc : màu hồng', 15000.00, '002', NULL, '2025-06-17 10:43:13', 2),
(3, 'Heo handmade', 'Tên sản phẩm : heo handmade\nChất liệu : len\nMàu sắc : màu hồng\nHọa tiết : hình con heo', 50000.00, '003', NULL, '2025-06-17 10:43:13', 3);

-- --------------------------------------------------------

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `orders` (`id`, `user_id`, `total`, `order_date`, `status`) VALUES
(4, 1, 150000.00, 2147483647, 'Chờ xác nhận'),
(5, 2, 220000.00, 2147483647, 'Đang giao hàng'),
(6, 1, 185000.00, 2147483647, 'Đã giao');

-- --------------------------------------------------------

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 4, 1, 2, 50000.00),
(2, 5, 2, 1, 30000.00),
(3, 6, 3, 1, 55000.00);

-- --------------------------------------------------------

CREATE TABLE `shipping_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `receiver_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order` (`order_id`),
  CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `shipping_info` (`id`, `order_id`, `receiver_name`, `address`, `phone`, `delivery_date`) VALUES
(4, 4, 'Nguyễn Văn A', '123 Đường Lê Lợi, Quận 1, TP.HCM', '0901234567', '2025-06-18'),
(5, 5, 'Trần Thị B', '456 Đường Nguyễn Trãi, Quận 5, TP.HCM', '0912345678', '2025-06-19'),
(6, 6, 'Lê Văn C', '789 Đường Hai Bà Trưng, Quận 3, TP.HCM', '0938765432', '2025-06-20');

COMMIT;
