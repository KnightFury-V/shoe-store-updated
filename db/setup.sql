-- Database: shoe_store

CREATE DATABASE IF NOT EXISTS shoe_store;
USE shoe_store;

-- Table structure for table `categories`
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `categories`
INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Sneakers'),
(2, 'Boots'),
(3, 'Sandals'),
(4, 'Formal Shoes');

-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `image_url` VARCHAR(255),
  `category_id` INT(11) UNSIGNED NOT NULL,
  `stock_quantity` INT(11) UNSIGNED DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` TINYINT(1) UNSIGNED DEFAULT 0,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `products`
INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `category_id`, `stock_quantity`) VALUES
(1, 'Classic White Sneakers', 'A timeless pair of white sneakers for everyday wear.', 79.99, 'assets/images/sneaker1.jpg', 1, 50),
(2, 'Brown Leather Boots', 'Durable and stylish brown leather boots, perfect for any occasion.', 129.50, 'assets/images/boot1.jpg', 2, 30),
(3, 'Summer Flip-Flops', 'Comfortable flip-flops ideal for the beach or casual outings.', 25.00, 'assets/images/sandal1.jpg', 3, 100),
(4, 'Black Oxford Shoes', 'Elegant black Oxford shoes for formal events.', 99.75, 'assets/images/formal1.jpg', 4, 20),
(5, 'Running Shoes Pro', 'High-performance running shoes designed for athletes.', 119.99, 'assets/images/sneaker2.jpg', 1, 40);

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin') DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `users`
INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$YOUR_ADMIN_PASSWORD_HASH', 'admin'), -- Replace with a real hashed password
(2, 'user1', '$2y$10$YOUR_USER_PASSWORD_HASH', 'user');   -- Replace with a real hashed password

-- Table structure for table `orders`
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `order_status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `order_items`
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT(11) UNSIGNED NOT NULL,
  `product_id` INT(11) UNSIGNED NOT NULL,
  `quantity` INT(11) UNSIGNED NOT NULL,
  `item_price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;