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
(1, 'ACCUTANE (ISOTRETINOIN) ROACCUTANE 10mg 30tbs', 'Accutane is a medication taken to treat severe nodular acne that has not been helped by other treatments, including antibiotics. However, accutane can cause serious side effects. Before starting treatment with accutane, discuss with your doctor how bad the acne is, the possible benefits of accutane, and the possible side effects. Your doctor will ask you to read and sign a form indicating that you understand the serious risks associated with accutane therapy. Do not take accutane if you are pregnant or if you could become pregnant during treatment or for one month after you stop taking accutane. Accutane is in the FDA pregnancy category X. This means that accutane is known to cause severe birth defects in an unborn baby. It can also cause miscarriage, premature birth, or death of the baby. You must take a pregnancy test and have negative results when you and your doctor decide that accutane may be beneficial for your condition. You must have a second pregnancy test with negative results during the first 5 days of the menstrual period right before you start taking accutane. Two reliable forms of birth control must be used at the same time (unless abstinence is the chosen method of birth control or if you have undergone a hysterectomy) for one month before starting treatment with accutane, during treatment with accutane, and for at least 1 month following the end of treatment. You will also be asked to take a pregnancy test on a monthly basis. Your doctor will discuss with you and provide for you a video and written information regarding choices for birth control, possible causes for birth control failure, and the importance of using birth control while taking accutane. If you become pregnant, stop using birth control, or miss your menstrual period, immediately stop taking accutane and notify your doctor. Some patients have experienced depression (including feelings of sadness, irritability, unusual tiredness, trouble concentrating, and loss of appetite) and suicidal thoughts and/ or behavior during, and soon after stopping, treatment with accutane. Notify your doctor immediately if you begin to experience signs of depression or if you begin to have thoughts about taking your own life during or shortly following treatment with accutane. Do not take vitamin supplements containing vitamin A during treatment with accutane. This could cause increased side effects.  Do not donate blood while taking accutane and for at least 1 month following the end of treatment. Blood donated while taking Do not use wax hair removal systems or have any skin resurfacing procedures (such as dermabrasion or laser treatment) performed while taking accutane and for six months following treatment due to the possibility of scarring. Avoid exposure to sunlight or UV rays while taking accutane. Accutane may increase the sensitivity of the skin to sunlight and a severe sunburn could result. Avoid exposure to sunlight or UV rays while taking accutane. Accutane may increase the sensitivity of the skin to sunlight and a severe sunburn could result. Avoid exposure to sunlight or UV rays while taking accutane. Accutane may increase the sensitivity of the skin to sunlight and a severe sunburn could result.Take all of the accutane that has been prescribed for you even if your symptoms start to improve. The acne may seem to get worse at the start of therapy, but should then begin to improve. For the best results, finish all of the medication that has been prescribed. You may require more than one course of therapy with accutane. ', 'http://www.drugshoponline.com/UPLOAD/URUNLER//acne/Thumb/ACCUTANE_large.jpg', 0, 1, 43.99),
(2, 'REVIA (VIVITROL)(NALTREXONE) BRAND 50 mg 56 tablets', '', 'http://www.drugshoponline.com/UPLOAD/URUNLER/Thumb/Revia_large.jpg', 5, 2, 35.99),
(3, 'DIFFERIN (ADAPALENE) 0.10 GEL 30 grams gel', 'Avoid prolonged exposure to sunlight. Differin may increase the sensitivity of your skin to sunlight. Use a sunscreen and wear protective clothing when sun exposure is unavoidable. Do not use adapalene on sunburned, windburned, dry, chapped, or irritated skin or on open wounds. Avoid abrasive, harsh, or drying soaps and cleansers while using differin.', 'http://www.drugshoponline.com/UPLOAD/URUNLER/acne/Thumb/DIFFERIN1_large.jpg', 8, 1, 83.99),
(4, 'AERIUS (DESLORATADINE) 5mg 20tbs', 'aerius (des-LOR-at-a-deen)is an antihistamine. It is used to relieve the symptoms of hay fever and hives of the skin. Antihistamines work by preventing the effects of a substance called histamine, which is produced by the body. Histamine can cause itching, sneezing, runny nose, and watery eyes. Also, in some persons histamine can close up the bronchial tubes (air passages of the lungs) and make breathing difficult. Histamine can also cause some persons to have hives, with severe itching of the skin. This medicine is available only with your doctors prescription, in the following dosage form:', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antihistamines/Thumb/AERIUS_large.jpg', 6, 4, 55.99),
(5, 'CLARITIN (LIBERATOR IN CANADA) (LORATADINE) 40 tablets', 'Use caution when driving, operating machinery, or performing other hazardous activities. Although unlikely, claritin may cause dizziness or drowsiness. If you experience dizziness or drowsiness, avoid these activities.', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antihistamines/Thumb/CLARITIN_large.jpg', 3, 4, 33.2),
(6, 'LYRICA (PREGABALIN) TABLETS 25mg 56 caps', 'LYRICA is a prescription medicine used in adults, 18 years and older, to treat: pain from damaged nerves (neuropathic pain) that happens with diabetes, pain from damaged nerves (neuropathic pain) that happens with diabetes,partial seizures when taken together with other seizure medicines,fibromyalgia.', 'http://www.drugshoponline.com/UPLOAD/URUNLER/antidepressants/Thumb/Lyrica_large.jpg', 8, 3, 44.1);

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

CREATE TABLE IF NOT EXISTS `users` (
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
