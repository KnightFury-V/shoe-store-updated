-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2025 at 09:20 AM
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
-- Database: `ShoeShopDB`
--
CREATE DATABASE IF NOT EXISTS `ShoeShopDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ShoeShopDB`;

-- --------------------------------------------------------

--
-- Table structure for table `tblAdminLogs`
--

CREATE TABLE `tblAdminLogs` (
  `LogID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblAdminLogs`
--

INSERT INTO `tblAdminLogs` (`LogID`, `AdminID`, `Action`, `Timestamp`) VALUES
(14, 2, 'Reset password for user #7', '2025-05-10 09:32:21'),
(15, 2, 'Edited user #3 name to Bhupendra Kadayat', '2025-05-10 09:33:04'),
(16, 2, 'Updated order #8 status to Shipped', '2025-05-12 09:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `tblAdmins`
--

CREATE TABLE `tblAdmins` (
  `AdminID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblAdmins`
--

INSERT INTO `tblAdmins` (`AdminID`, `UserID`, `FullName`) VALUES
(2, 3, 'Bhupendra Kadayat Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblCategories`
--

CREATE TABLE `tblCategories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblCategories`
--

INSERT INTO `tblCategories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Sports Shoes'),
(2, 'Boot'),
(3, 'Heels'),
(4, 'Loafer'),
(5, 'Sandal'),
(6, 'Sneakers'),
(7, 'Flip-flops');

-- --------------------------------------------------------

--
-- Table structure for table `tblOrderItems`
--

CREATE TABLE `tblOrderItems` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `PriceAtPurchase` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblOrders`
--

CREATE TABLE `tblOrders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblProducts`
--

CREATE TABLE `tblProducts` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Size` varchar(20) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `Stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblProducts`
--

INSERT INTO `tblProducts` (`ProductID`, `CategoryID`, `ProductName`, `Description`, `Price`, `Size`, `ImagePath`, `Stock`) VALUES
(12, 1, 'Puma Runner', 'Comfortable shoes for running and sports', 59.99, '10', 'pumarunner.png', 50),
(13, 1, 'air sus runner', 'Comfortable shoes for running and sports', 69.99, '10', 'airsusrunner.png', 70),
(14, 1, 'adidas spike runner', 'Comfortable shoes for running and sports', 59.99, '10', 'adidasspikerunner.png', 40),
(15, 1, 'reebok suspencer', 'Comfortable shoes for running and sports', 59.99, '10', 'reeboksuspencer.png', 55),
(16, 1, 'filla white', 'Comfortable shoes for running and sports', 59.99, '10', 'fillawhite.png', 50),
(17, 1, 'nike air black', 'Comfortable shoes for running and sports', 59.99, '10', 'nikeairblack.png', 62),
(18, 1, 'new balance pink', 'Comfortable shoes for running and sports', 59.99, '10', 'newbalancepink.jpg', 51),
(19, 1, 'nike runner', 'Comfortable shoes for running and sports', 59.99, '10', 'nikerunner.png', 47),
(20, 1, 'red white huraches', 'Comfortable shoes for running and sports', 59.99, '10', 'redwhitehuraches.png', 50),
(21, 1, 'soloman red runner', 'Comfortable shoes for running and sports', 59.99, '10', 'solomanredrunner.png', 68),
(22, 2, 'hakim shoes', 'Trendy boots for casual wear', 79.99, '9', 'hakimshoes.jpg', 30),
(23, 2, 'half sleeves boots', 'Trendy boots for casual wear', 87.99, '9', 'halfsleevesboots.png', 30),
(24, 2, 'ugg brown', 'Trendy boots for casual wear', 82.99, '9', 'uggbrown.png', 30),
(25, 2, 'timberland boots', 'Trendy boots for casual wear', 84.99, '9', 'timberlandboots.jpeg', 50),
(26, 2, 'Chelsea boot', 'Trendy boots for casual wear', 52.99, '9', 'chelseaboot.png', 58),
(27, 2, 'women ping boots', 'Trendy boots for casual wear', 59.99, '9', 'womenpingboots.png', 81),
(28, 2, 'longwomenboots', 'Trendy boots for casual wear', 57.99, '9', 'longwomenboots.png', 36),
(29, 2, 'motorcycleboots', 'Trendy boots for casual wear', 52.99, '9', 'motorcycleboot.png', 28),
(30, 3, 'blackheels', 'Elegant high heels for formal occasions', 79.99, '8', 'blackheels.png', 40),
(31, 3, 'blackpencilheels', 'Elegant high heels for formal occasions', 59.99, '8', 'blackpencilheels.png', 40),
(32, 3, 'highheelsandals', 'Elegant high heels for formal occasions', 49.99, '8', 'highheelsandals.png', 40),
(33, 3, 'pinkyheels', 'Elegant high heels for formal occasions', 69.99, '8', 'pinkyheels.png', 40),
(34, 3, 'redpencilheel', 'Elegant high heels for formal occasions', 52.99, '8', 'redpencilheel.png', 40),
(35, 3, 'blackheels', 'Elegant high heels for formal occasions', 53.99, '8', 'blackheels.png', 40),
(36, 4, 'balletflats', 'Comfortable loafers for everyday use', 49.99, '10', 'balletflats.png', 60),
(37, 4, 'leatherloafers', 'Comfortable loafers for everyday use', 49.99, '10', 'leatherloafer.png', 60),
(38, 4, 'blackandwhiteloafers', 'Comfortable loafers for everyday use', 49.99, '10', 'blackandwhiteloafers.png', 30),
(39, 4, 'flatloafers', 'Comfortable loafers for everyday use', 49.99, '10', 'flatloafers.png', 40),
(40, 4, 'jaipuriflats', 'Comfortable loafers for everyday use', 49.99, '10', 'jaipuriflats.png', 50),
(41, 6, 'airjordanlegacy', 'Comfortable and stylish sneakers for everyday use', 72.99, '10', 'airjordanlegacy.jpeg', 50),
(42, 6, 'airjordandior', 'Comfortable and stylish sneakers for everyday use', 88.99, '10', 'airjordandior.png', 50),
(43, 6, 'airjordanred', 'Comfortable and stylish sneakers for everyday use', 86.99, '10', 'airjordanred.png', 50),
(44, 6, 'airjordanretroblack', 'Comfortable and stylish sneakers for everyday use', 97.99, '10', 'airjordanretroblack.png', 50),
(45, 6, 'airforce1', 'Comfortable and stylish sneakers for everyday use', 89.99, '10', 'airforce1black.jpg', 50),
(46, 6, 'nikeairmaxjesus', 'Comfortable and stylish sneakers for everyday use', 79.99, '10', 'nikeairmaxjesus.png', 50),
(47, 6, 'nikeblazerwhite', 'Comfortable and stylish sneakers for everyday use', 69.99, '10', 'nikeblazerwhite.png', 50),
(48, 6, 'transparentairjordan', 'Comfortable and stylish sneakers for everyday use', 99.99, '10', 'transparentairjordan.png', 50),
(49, 6, 'vans', 'Comfortable and stylish sneakers for everyday use', 89.99, '10', 'vans.png', 50),
(50, 7, 'beachblack', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'beachblack.jpg', 37),
(51, 7, 'barefootslippers', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'barefootslippers.jpg', 67),
(52, 7, 'pressureslippers', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'pressureslippers.jpg', 72),
(53, 7, 'summerslippers', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'summerslipper.jpg', 48),
(54, 7, 'summerflip', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'summerflip.jpg', 20),
(55, 7, 'famdam', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'famdam.jpg', 60),
(56, 7, 'fancyflipflops', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'fancyflipflops.jpg', 42);

-- --------------------------------------------------------

--
-- Table structure for table `tblReviews`
--

CREATE TABLE `tblReviews` (
  `ReviewID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `ReviewText` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblUsers`
--

CREATE TABLE `tblUsers` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblUsers`
--

INSERT INTO `tblUsers` (`UserID`, `Email`, `PasswordHash`, `FullName`, `CreatedAt`) VALUES
(3, 'bhupendra@gmail.com', '$2y$10$91MaFHtaaG/lsIied7UMFugWN5jpsJLcvBTI6p7R.z9ywC2sRw2sq', 'Bhupendra Kadayat', '2025-05-05 20:13:46'),
(7, 'kab@gmail.com', '$2y$10$y6sFRKYramHQGpf079N9XOwsCShfmLya1Mk8Y9GrgC94/s0qsCx/q', 'Kabita Chy', '2025-05-09 10:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblWishlist`
--

CREATE TABLE `tblWishlist` (
  `WishlistID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `tblCategories`
--
ALTER TABLE `tblCategories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `tblorderitems_ibfk_1` (`OrderID`);

--
-- Indexes for table `tblOrders`
--
ALTER TABLE `tblOrders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `tblorders_ibfk_1` (`UserID`);

--
-- Indexes for table `tblProducts`
--
ALTER TABLE `tblProducts`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `tblReviews`
--
ALTER TABLE `tblReviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `tblreviews_ibfk_1` (`ProductID`);

--
-- Indexes for table `tblUsers`
--
ALTER TABLE `tblUsers`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  ADD PRIMARY KEY (`WishlistID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblCategories`
--
ALTER TABLE `tblCategories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblOrders`
--
ALTER TABLE `tblOrders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblProducts`
--
ALTER TABLE `tblProducts`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tblReviews`
--
ALTER TABLE `tblReviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblUsers`
--
ALTER TABLE `tblUsers`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  MODIFY `WishlistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  ADD CONSTRAINT `tbladminlogs_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `tblAdmins` (`AdminID`);

--
-- Constraints for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  ADD CONSTRAINT `tbladmins_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`);

--
-- Constraints for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  ADD CONSTRAINT `tblorderitems_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `tblOrders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblorderitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `tblProducts` (`ProductID`);

--
-- Constraints for table `tblOrders`
--
ALTER TABLE `tblOrders`
  ADD CONSTRAINT `tblorders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `tblProducts`
--
ALTER TABLE `tblProducts`
  ADD CONSTRAINT `tblproducts_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `tblCategories` (`CategoryID`);

--
-- Constraints for table `tblReviews`
--
ALTER TABLE `tblReviews`
  ADD CONSTRAINT `tblreviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`);

--
-- Constraints for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  ADD CONSTRAINT `tblwishlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`),
  ADD CONSTRAINT `tblwishlist_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `tblProducts` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
