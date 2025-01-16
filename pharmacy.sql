-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 28, 2012 at 11:27 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE IF NOT EXISTS `bill` (
  `billID` int(11) NOT NULL AUTO_INCREMENT,
  `creditcardtype` varchar(100) NOT NULL,
  `creditcardnumber` bigint(20) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `country` varchar(100) NOT NULL,
  `address` varchar(400) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`billID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`billID`, `creditcardtype`, `creditcardnumber`, `firstname`, `lastname`, `date`, `country`, `address`, `amount`) VALUES
(1, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-23', 'Afghanistan', 'qavtaradze', 400),
(2, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-23', 'Afghanistan', 'asdaa', 400),
(3, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-23', 'Afghanistan', 'asdasd', 400),
(4, 'Master Card', 1234567890123456, 'nika', 'badashvili', '2012-11-23', 'Afghanistan', 'qavtarade', 300),
(5, 'Visa', 1234567890123456, 'nika', 'badashvili', '2012-11-23', 'Afghanistan', 'qavtaradze', 500),
(6, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-23', 'Afghanistan', 'qavtaradze ', 600),
(7, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-23', 'Afghanistan', 'qavtaradze', 400),
(8, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-25', 'American Samoa', 'qavtaradze', 100),
(9, 'Visa', 1234567890123456, 'lasha', 'badashvili', '2012-11-26', 'Albania', 'qavtaradze', 240);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` int(11) NOT NULL AUTO_INCREMENT,
  `productPrice` float NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `productName` varchar(200) NOT NULL,
  PRIMARY KEY (`cartID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `cart`
--


-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryID`, `categoryName`) VALUES
(1, 'Acne TreatMent'),
(2, 'Alcohol Treatment'),
(3, 'Anti Depressants'),
(4, 'Anti Histamines'),
(5, 'Anti Viral'),
(6, 'Anti Biotics'),
(7, 'Anti Mycotics'),
(8, 'Asthma Medications'),
(9, 'Blood Pressure'),
(10, 'Cancer Treatment'),
(11, 'Cholesterol'),
(12, 'Dermatological'),
(13, 'Diabetes'),
(14, 'Eye Drops'),
(15, 'Gastrointestinal'),
(16, 'Immunosuppressants'),
(17, 'Mens Health'),
(18, 'Migraines'),
(19, 'Osteoarthritis'),
(20, 'Osteoporosis'),
(21, 'Pain Relief'),
(22, 'Radiodiagnostics'),
(23, 'Stop Smoking'),
(24, 'Thyroid Medications'),
(25, 'Weight Loss'),
(26, 'Womens Health');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `userid` int(11) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `productName`, `date`, `userid`, `productQuantity`) VALUES
(1, 'DIFFERIN (ADAPALENE) 0.10 GEL 30 grams gel', '2012-11-23', 2, 4),
(2, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', '2012-11-23', 2, 2),
(3, 'REVIA (VIVITROL)(NALTREXONE) BRAND 50 mg 56 tablets', '2012-11-23', 1, 1),
(4, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', '2012-11-23', 1, 2),
(5, 'DIFFERIN (ADAPALENE) 0.10 GEL 30 grams gel', '2012-11-23', 1, 4),
(6, 'CLARITIN (LIBERATOR IN CANADA) (LORATADINE) 40 tablets', '2012-11-25', 1, 3),
(7, 'REVIA (VIVITROL)(NALTREXONE) BRAND 50 mg 56 tablets', '2012-11-26', 2, 1),
(8, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', '2012-11-26', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(200) NOT NULL,
  `productDetails` text NOT NULL,
  `productIMG` varchar(400) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_category_Id` int(11) NOT NULL,
  `Price` float NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`productID`, `productName`, `productDetails`, `productIMG`, `quantity`, `product_category_Id`, `Price`) VALUES
(1, 'ACCUTANE (ISOTRETINOIN) ROACCUTANE 10mg 30tbs', 'Roche', 'http://www.drugshoponline.com/UPLOAD/URUNLER//acne/Thumb/ACCUTANE_large.jpg', 0, 1, 43.99),
(2, 'REVIA (VIVITROL)(NALTREXONE) BRAND 50 mg 56 tablets', 'Alkermes', 'http://www.drugshoponline.com/UPLOAD/URUNLER/Thumb/Revia_large.jpg', 5, 2, 35.99),
(3, 'DIFFERIN (ADAPALENE) 0.10 GEL 30 grams gel', 'Galderma', 'http://www.drugshoponline.com/UPLOAD/URUNLER/acne/Thumb/DIFFERIN1_large.jpg', 8, 1, 83.99),
(4, 'AERIUS (DESLORATADINE) 5mg 20tbs', 'Bayer', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antihistamines/Thumb/AERIUS_large.jpg', 6, 4, 55.99),
(5, 'CLARITIN (LIBERATOR IN CANADA) (LORATADINE) 40 tablets', 'Bayer', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antihistamines/Thumb/CLARITIN_large.jpg', 3, 4, 33.2),
(6, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', 'Pfizer', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antidepressants/Thumb/Lyrica_large.jpg', 8, 3, 44.1);


-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE IF NOT EXISTS `Transactions` (
  `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
  `productPrice` float NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `productName` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`TransactionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`TransactionID`, `productPrice`, `productQuantity`, `userid`, `productName`, `date`) VALUES
(1, 35.99, 1, 2, 'REVIA (VIVITROL)(NALTREXONE) BRAND 50 mg 56 tablets', '2012-11-26'),
(2, 44.1, 4, 2, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', '2012-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `passwordone` varchar(100) NOT NULL,
  `passwordtwo` varchar(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobilephone` varchar(40) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `passwordone`, `passwordtwo`, `fullname`, `email`, `mobilephone`) VALUES
(1, 'lasha', 'bca4b46721c10a119766ad9e2241d8b7', 'bca4b46721c10a119766ad9e2241d8b7', 'lasha badashvili', 'lashacst@gmail.com', '593308455'),
(2, 'nika', 'bca4b46721c10a119766ad9e2241d8b7', 'bca4b46721c10a119766ad9e2241d8b7', 'nika badashvili', 'nika@gmail.com', '593308455');


-- --------------------------------------------------------

-- Table structure for table `suppliers`
CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplierID` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `contact` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `address` TEXT NOT NULL,
  PRIMARY KEY (`supplierID`)
);

-- --------------------------------------------------------

-- Table structure for table `orders`
CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` INT(11) NOT NULL AUTO_INCREMENT,
  `supplierID` INT(11) NOT NULL,
  `orderDate` DATE NOT NULL,
  `deliveryDate` DATE DEFAULT NULL,
  `status` ENUM('Pending', 'Delivered', 'Cancelled') DEFAULT 'Pending',
  `totalAmount` FLOAT NOT NULL,
  PRIMARY KEY (`orderID`),
  FOREIGN KEY (`supplierID`) REFERENCES `suppliers`(`supplierID`)
);

-- --------------------------------------------------------

-- Table structure for table `sales`
CREATE TABLE IF NOT EXISTS `sales` (
  `saleID` INT(11) NOT NULL AUTO_INCREMENT,
  `billID` INT(11) NOT NULL,
  `productID` INT(11) NOT NULL,
  `quantity` INT NOT NULL,
  `saleDate` DATE NOT NULL,
  `totalPrice` FLOAT NOT NULL,
  PRIMARY KEY (`saleID`),
  FOREIGN KEY (`billID`) REFERENCES `bill`(`billID`),
  FOREIGN KEY (`productID`) REFERENCES `products`(`productID`)
);

-- --------------------------------------------------------

-- Table structure for table `reports`
CREATE TABLE IF NOT EXISTS `reports` (
  `reportID` INT(11) NOT NULL AUTO_INCREMENT,
  `reportType` ENUM('Sales', 'Inventory', 'Orders') NOT NULL,
  `generatedDate` DATE NOT NULL,
  `details` TEXT NOT NULL,
  PRIMARY KEY (`reportID`)
);


-- Sample data for table `suppliers`
INSERT INTO `suppliers` (`name`, `contact`, `email`, `address`) VALUES
('MedSupplies Co.', '123456789', 'contact@medsupplies.com', '123 Main St, Cityville'),
('PharmaDistributors', '987654321', 'info@pharmadistributors.com', '456 Elm St, Townsville');

-- Sample data for table `orders`
INSERT INTO `orders` (`supplierID`, `orderDate`, `deliveryDate`, `status`, `totalAmount`) VALUES
(1, '2025-01-01', '2025-01-05', 'Delivered', 500.00),
(2, '2025-01-03', NULL, 'Pending', 250.00);

-- Sample data for table `sales`
INSERT INTO `sales` (`billID`, `productID`, `quantity`, `saleDate`, `totalPrice`) VALUES
(1, 101, 2, '2025-01-10', 40.00),
(2, 102, 1, '2025-01-11', 20.00);

-- Sample data for table `reports`
INSERT INTO `reports` (`reportType`, `generatedDate`, `details`) VALUES
('Sales', '2025-01-10', 'Daily sales report showing a total revenue of $60.00'),
('Inventory', '2025-01-09', 'Inventory levels updated after restocking from suppliers');
