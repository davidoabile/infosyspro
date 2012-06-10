-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2012 at 11:27 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `infosyspro`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_resources`
--

CREATE TABLE IF NOT EXISTS `acl_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acl_resources`
--

INSERT INTO `acl_resources` (`id`, `name`, `inheritsFrom_id`, `sort_order`) VALUES
(1, 'cms', NULL, 0),
(2, 'home', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `acl_roles`
--

CREATE TABLE IF NOT EXISTS `acl_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acl_roles`
--

INSERT INTO `acl_roles` (`id`, `name`, `inheritsFrom_id`, `sort_order`) VALUES
(1, 'marketing', 2, 2),
(2, 'staff', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_roles_resources`
--

CREATE TABLE IF NOT EXISTS `acl_roles_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_role_id` int(10) unsigned NOT NULL,
  `acl_resource_id` int(10) unsigned NOT NULL,
  `privilege` varchar(45) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_role_res_priv` (`acl_role_id`,`acl_resource_id`,`privilege`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acl_roles_resources`
--

INSERT INTO `acl_roles_resources` (`id`, `acl_role_id`, `acl_resource_id`, `privilege`, `sort_order`) VALUES
(1, 1, 2, 'edit', 0),
(2, 2, 1, 'view', 2);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `productID` varchar(20) NOT NULL DEFAULT '0',
  `ProductName` text NOT NULL,
  `Description` mediumtext NOT NULL,
  `Ingredients` mediumtext NOT NULL,
  `Price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `SpecialOffer` text NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`productID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `productID`, `ProductName`, `Description`, `Ingredients`, `Price`, `SpecialOffer`, `Quantity`) VALUES
(1, 'white&green', 'White & Green', 'Finally,a MINT You always wanted : Fresh,Strong but Delicate and Long lasting !!And remember,no ZIZI,no kiss...Have fun and choose your favorite colour...Golf or ski ?', 'Natural Sugar Cane,Glucose,natural mint flavour,Menthol, colorant for the Green Ball.', '1.30', '18 boxes for 20$A + Transport           ', 10),
(10, 'black&white', 'Black & White', 'This is really BLACK & WHITE !!       A Luscious LICORICE with a *SPARK* of refreshing WHITE MINT..            Ideal for..smokers & ex smokers !!!    No ZIZI,no Kiss...', 'Sugar Cane,Glucose Syrup,Natural extract of Licorice,Menthol,natural color', '1.30', '18 boxes for 20$ + Transport      ', 0),
(2, 'red&white', 'Red & White', 'The ideal for MINT addicts..Bravery will enflam your partner as well..Have fun...Red Hot... ', 'Sugar Cane,Glucose Syrup,Extra Strong Peppermint extract,Menthol and Red colorant for The Red Balls...', '1.30', '!8 boxes for 20$ A. + Transportt         ', 200),
(3, 'Orange', 'Zazi Orange', 'The Natural Taste of Seville Oranges combined with the smoothness of Gum Arabica,to give You a pleasurable SUGARFREE treat...And remember : ZAZI Orange is SUGAR FREE, LOW CARB. LOW GI., GLUTEN FREE as well as DAIRY FREE !!!', 'Natural Gum Arabica,maltitol,Flavours,natural colorant', '1.80', '18 packets for $30.00 +transport       ', 12),
(4, 'Mango', 'Zazi Mango', 'The most delicate Flavour of this delicious Exotic Fruit..A dream of holydays in those far,far away places !Bite and you will remember that juicy smooth Taste...Gum Arabica will give a long lasting support to the flavour..A complete Natural Taste. SUGAR FREE, GLUTEN FREE,DAIRY FREE, LOW CARB and LOW GI. The usual ZAZI perfection..', 'Gum Arabica,Maltitol,Mango flavour', '1.80', ' 18 packets for 30$ + Transport', 10),
(5, 'Strawberry', 'Zazi Strawberry', 'Strawberry..What can we add ? A Real Fresh Taste ..Lots of Pleasure with this candy made of  Natural Gum Arabica : SUGAR FREE, GLUTEN FREE, LOW CARB., LOW G.I. and DAIRY FREE..! Enjoy ZAZI Strawberry Pastilles.', 'Gum Arabica,maltitol.fruit juice,natural color', '1.80', '18 packets for 30$ + Transport ', 10),
(6, 'Blackcurrant', 'Zazi Black Currant', 'So Juicy,and that very special Natural Taste!ZAZI creation made of Gum Arabica with Real Fruit Juice will convince you that SUGARFREE is better than confectioneries made of sugar...ZAZI is also GLUTEN Free, LOW CARB, LOW GI. and DAIRY FREE !!!', 'Gum Arabica,Maltitol,Blackcurrant Fruit Juice', '1.80', '18 packets for 30$ + Transport   ', 0),
(7, 'rewards', 'Rewards and Competitions', 'When you purchase from our site the minimum requirement,you will be entered into the competitions automatically without the obligation of sending the 4 packets.. Otherwise                           send 4 packets of any ZIZI MINTS and you will be participating in our "Argentinian" competitions.Every 2 months a lucky winner will get one year FREE supply of ZIZI MINTS assorted Flavours.. ', 'Every 6 months,another lucky winner will receive 1000$ cash  ! Then our SUPER HERO,once a year, will get a trip for 2, to Argentina, BUSINESS CLASS and Hotels paid for a stay of 10 days and will be invited to visit the factory and meet some of "The Extraordinary People" who make ZIZI!!!! If you are from another part of the world and not living in Australia we will endeavour-your location permitting-to fly you in Australia, Business Class and organise FREE your accomodations for 15 days.In case of great difficulties or impossibilities an amount of 15000$ will be sent to you : The choice being entirely at the discretion of ZIZI corporation.. ', '1.30', '18 boxes for 20$+ transport         ', 0),
(8, 'zazirewards', 'Rewards and Competitions', 'When purchasing from our site the minimum requirement you will,automatically,be entered into our competitions without the obligation to send 4 packets of ZIZI products. Otherwise send 4 packets of any ZAZI SUGARFREE candies and you will be participating in our "ITALIAN"competitions : Every 2 months,a lucky winner will get one year free supply of ZAZI SUGARFREE candies assorted flavours.', 'Every 6 months,another lucky winner will receive 1000$ cash! Then our "SUPER HERO",once a year,will receive a trip for 2 FIRST class to VENICE,Hotel paid for 5 days and 1000$ CASH to cover 5 nights Hotels of your OWN choice of adventure in ITALY!!!A total of 10 days! You will be as well meeting "The Extraordinary People" who make ZAZI SUGARFREE candies. If you live somewhere else than Australia,we will organise your travel to our Extraordinary Australian continent, business class and 15 days accomodations FREE.If,due to you location,it is extremely difficult,we will send you a cheque for 15000$ : That choice is entirely to the discretion of ZIZI corporation....', '1.80', ' 18 boxes for 30$ + Transport            ', 0),
(9, 'music', 'Show us your talent', 'Produce an Original (must be your own) Musical Creation for ZIZI and or ZAZI. If your Music is accepted as "ZIZI MUSIC" or "ZAZI MUSIC", You will be rewarded with a cash price of $1000 and a supply of ZIZI or ZAZI products for 3 years. The winner will also receive a certificate of belonging to "The Extraordinary People".', '1. All productions must be your own.<br>\r\n2. If your production is deemed to be plagiarized from others, ZIZI corporation  will not accept any responsibility  whatsoever<br>\r\n3. The production will automatically become the property of ZIZI corporation including all copyright  protected by the international Laws<br>\r\n4. Upon submission you will be automatically registered to our ZIZI CLUB<br>\r\n5. Your production must be less than 1 MB<br>\r\n6. No indecent or swear words\r\n', '0.00', '           ', 0),
(11, 'Poems & Slogans', '', 'Produce an original (must be your own) Slogan and or Poem Schemes for ZIZI and or ZAZI. If your Poem/slogan is accepted as "ZIZI Poem" or "ZAZI Poem" or slogans, you will be rewarded with a cash price of $1000 and a supply of ZIZI or ZAZI products for 3 years. The winner will also receive a certificate of belonging to " The Extraordinary People".', '1. All productions must be your own.<br>\r\n2. If your production is deemed to be plagiarized from others Zizi or Zazi will not take responsibility  whatsoever<br>\r\n3. The production will automatically become the property of Zizi and or Zazi including all copyright laws<br>\r\n4. Upon submission you will be automatically registered to our ZIZI CLUB<br>\r\n5. Your production must be less than 1 MB<br>\r\n6. No indecent or swear words', '0.00', '     ', 0),
(12, 'Licorice', 'Zazi Licorice', 'Nuances of Mint in a delightful mix of Maltitol Syrup with Pure Licorice Essence.Very refreshing..A SUGARFREE,DAIRY FREE,GLUTEN FREE,LOW CARB,LOW G.I. Life Creation from ZAZI..', 'Natural Gum Arabica,Maltitol Syrup,Natural Mint and Natural Licorice Essence', '1.80', ' 18 packets for 30.00A$ + Transport ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE IF NOT EXISTS `basket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `products_id` mediumint(9) NOT NULL,
  `quantity` int(2) NOT NULL,
  `price_exgst` decimal(15,2) NOT NULL,
  `final_price` decimal(15,2) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_id` (`customers_id`),
  KEY `products_id` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`id`, `customers_id`, `products_id`, `quantity`, `price_exgst`, `final_price`, `date_added`) VALUES
(1, 100000, 4, 1, '1.40', '1.40', '0000-00-00 00:00:00'),
(2, 100000, 3, 1, '1.40', '1.40', '0000-00-00 00:00:00'),
(3, 100000, 2, 1, '1.40', '1.40', '0000-00-00 00:00:00'),
(4, 100000, 2, 3, '1.40', '1.40', '0000-00-00 00:00:00'),
(84, 1, 5, 4, '24.00', '7.20', '2010-11-28 01:09:45'),
(86, 1, 3, 1, '1.40', '1.40', '2010-11-28 01:08:53'),
(87, 1, 2, 1, '1.27', '1.40', '2010-11-28 01:11:58'),
(88, 1, 1, 2, '1.27', '2.80', '2010-11-28 01:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE IF NOT EXISTS `counter` (
  `page` varchar(50) DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`page`, `counter`) VALUES
('/index.php', 14512),
('/zizimusic.php', 202),
('/zizipoems.php', 108);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `CustID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(20) NOT NULL DEFAULT '',
  `Lastname` varchar(20) NOT NULL DEFAULT '',
  `Address` varchar(30) NOT NULL DEFAULT '',
  `State` varchar(5) NOT NULL DEFAULT '',
  `City` varchar(30) NOT NULL DEFAULT '',
  `Postcode` varchar(4) NOT NULL DEFAULT '',
  `Postaladdress` varchar(30) DEFAULT NULL,
  `Hometel` varchar(10) NOT NULL DEFAULT '',
  `Businesstel` varchar(10) NOT NULL DEFAULT '',
  `Mobile` varchar(10) DEFAULT NULL,
  `Fax` varchar(10) DEFAULT NULL,
  `Custemail` varchar(30) NOT NULL DEFAULT '',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `productname` varchar(50) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '',
  `Paymethod` varchar(20) NOT NULL DEFAULT '',
  `Credittype` varchar(20) DEFAULT NULL,
  `Cardholdername` varchar(30) DEFAULT NULL,
  `Cardnumber` varchar(16) DEFAULT NULL,
  `Expirydate` varchar(10) DEFAULT NULL,
  `lastdigits` char(3) DEFAULT NULL,
  `Date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`CustID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `caller_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `position` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caller_name` (`caller_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `title`, `caller_name`, `description`, `position`) VALUES
(1, 'Upcoming Products', 'layout.default', 'All New products will be advertised here and if you are a member you may be eligible for tasting new products before they are published.', 'right');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `Description` varchar(50) NOT NULL DEFAULT '',
  `links` varchar(100) NOT NULL DEFAULT '',
  `productname` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`name`, `Description`, `links`, `productname`) VALUES
('boughtorange.jpg', 'Orange', 'zazi_orange.php', 'orange'),
('boughtmango.jpg', 'Mango', 'zazi_mango.php', 'mango'),
('boughtstrawberry.jpg', 'Strawberry', 'zazi_strawberry.php', 'strawberry'),
('boughtcurrant.jpg', 'Currant', 'zazi_black_currant.php', 'blackcurrant'),
('boughtblack.jpg', 'White', 'sugarless_black_white.php', 'black&white'),
('boughtgreen.jpg', 'Green', 'sugarless.php', 'white&green'),
('boughtred.jpg', 'Red', 'sugarless_red_white.php', 'red&white'),
('boughtlicorice.jpg', 'Licorice', 'zazi_licorice.php', 'Licorice');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Companyname` varchar(100) DEFAULT NULL,
  `contactname` varchar(100) NOT NULL DEFAULT '',
  `tel` varchar(10) NOT NULL DEFAULT '',
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `Address` text NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `active` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `Companyname`, `contactname`, `tel`, `fax`, `email`, `Address`, `username`, `password`, `date`, `active`) VALUES
(1, 'my company name', 'David Oabile', '0749273633', '0749373644', 'davido@cyberoz.com.au', '12 William St Rockhampton 4700 QLD', 'davido', 'dailer', '2006-10-11', 'Yes'),
(2, 'Tinsonax (NSW) Pty Ltd', 'John Thumpkins', '02 9722 91', '02 9792 31', 'john@tinsonax.com.au', 'Unit 3, 4 Brunker Road\r\nChullora\r\nNSW   2190 ', 'John', 'tom', '2006-11-29', 'No'),
(3, 'my company name', 'jacques vasseur', '0427 -1916', 'area code', 'tsc@connexus.net.au', '638 musgrave     robertson \r\nqueensland \r\n4109australia ', 'talbot', 'chien', '2006-10-25', 'Mem'),
(4, 'Sugarless co', 'jacques vasseur', '0427-19168', '03-9387706', 'tsc@connexux.net.au', '19-21 gale st \r\neast brunswick \r\nvictoria.3057\r\naustralia ', 'sugarless', 'zizi', '2006-10-25', 'No'),
(5, 'sugarlessco', 'aurel', '0393881971', 'area code', 'info@sugarlessco.com', 'Number  Street \r\nCity Country \r\nState Postcode ', 'aurel', '123456', '2007-04-26', 'Mem'),
(6, 'Empress Creative', 'Francis Samson', '0883901249', '083901011', 'fsamson@hngs.com.au', 'Delamere\r\nAshton SA 5137\r\nSA5137', 'Francis', 'open', '2007-11-15', 'Mem'),
(7, 'Lolly Castle', 'Yanni Gao', '02 8021385', '02 8021385', 'lollycastle@live.com', '16/12 Essex St\r\nEpping \r\nNSW 2121 ', 'yanni gao', '276419', '2009-06-13', 'No'),
(8, 'sugarlessco pty ltd', 'jacques aubry', '03-9387751', '03 9387706', 'sugarlessco@cyberoz.com.au', '19-21 gale street \r\neast brunswick \r\nvic. 3057', 'hopenostop', 'tamuslechat', '2009-08-25', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `condition_id` varchar(100) DEFAULT '',
  `groupid` varchar(100) DEFAULT '',
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(100) DEFAULT NULL,
  `street` varchar(100) NOT NULL DEFAULT '',
  `suburb` varchar(50) NOT NULL DEFAULT '',
  `postcode` varchar(12) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(25) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `how` text,
  `why` text,
  `pref1` int(11) DEFAULT NULL,
  `pref2` int(11) DEFAULT NULL,
  `pref3` int(11) DEFAULT NULL,
  `join_date` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(25) DEFAULT 'none',
  `password` varchar(20) DEFAULT NULL,
  `hash` varchar(254) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `is_wholesaler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_wholesaler` (`is_wholesaler`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `contactname`, `company`, `condition_id`, `groupid`, `dob`, `email`, `street`, `suburb`, `postcode`, `state`, `country`, `phone`, `mobile`, `fax`, `how`, `why`, `pref1`, `pref2`, `pref3`, `join_date`, `username`, `password`, `hash`, `role`, `status`, `is_wholesaler`) VALUES
(1, 'David Oabile', 'Infosyspro', '', 'Admin', '2010-04-12', 'doabile@infosyspro.com.au', '23 burr crt', 'Pacific', '4521', 'QLD', 'Botswana', '07558224562', '042154254254', '', NULL, NULL, NULL, NULL, NULL, '0000-00-00', 'davido', 'dailer00', NULL, NULL, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Productname` varchar(100) NOT NULL DEFAULT '',
  `UserIP` varchar(20) NOT NULL DEFAULT '',
  `orderdate` date NOT NULL DEFAULT '0000-00-00',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` varchar(10) NOT NULL DEFAULT '0.00',
  `subtotal` varchar(10) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `Productname`, `UserIP`, `orderdate`, `quantity`, `price`, `subtotal`) VALUES
(138, 'white&green', '220.157.89.204', '2008-08-06', 1, '1.30', '1.3'),
(134, 'orange', '203.122.136.54', '2008-02-22', 1, '1.80', '1.8'),
(142, 'white&green', '122.107.247.152', '2008-10-06', 1, '1.30', '1.3'),
(136, 'strawberry', '203.122.136.54', '2008-05-06', 1, '1.80', '1.8'),
(135, 'mango', '203.122.136.54', '2008-02-22', 1, '1.80', '1.8'),
(127, 'white&green', '202.83.93.165', '2007-05-17', 1, '1.30', '1.3'),
(137, 'mango', '202.144.162.86', '2008-08-06', 1, '1.80', '1.8'),
(105, 'black&white', '220.157.87.1', '2006-10-07', 61, '1.30', '79.8'),
(125, 'white&green', '59.167.83.25', '2007-05-01', 1, '1.30', '1.3'),
(104, 'red&white', '220.157.87.1', '2006-10-07', 13, '1.30', '17.4'),
(103, 'blackcurrant', '220.157.87.1', '2006-10-07', 14, '1.80', '23.2'),
(102, 'mango', '220.157.87.1', '2006-10-07', 7, '1.80', '10.6'),
(101, 'strawberry', '220.157.87.1', '2006-10-07', 10, '1.80', '16'),
(99, 'orange', '220.157.87.1', '2006-10-07', 6, '1.80', '8.8'),
(124, 'white&green', '203.214.100.157', '2007-04-26', 1, '1.30', '1.3'),
(100, 'white&green', '220.157.87.1', '2006-10-07', 8, '1.30', '10.9'),
(123, 'black&white', '203.214.100.157', '2007-04-26', 1, '1.30', '1.3'),
(139, 'blackcurrant', '220.157.89.204', '2008-08-06', 1, '1.80', '1.8'),
(143, 'white&green', '114.73.12.11', '2008-10-06', 1, '1.30', '1.3'),
(144, 'white&green', '202.137.164.111', '2009-09-14', 1, '1.30', '1.3'),
(145, 'white&green', '122.105.187.173', '2009-09-23', 1, '1.30', '1.3'),
(146, 'orange', '122.105.187.173', '2009-09-23', 1, '1.80', '1.8'),
(147, 'red&white', '58.163.52.198', '2009-10-23', 2, '1.30', '2.6'),
(148, 'white&green', '150.101.113.129', '2009-11-17', 1, '1.30', '1.3'),
(149, 'mango', '139.130.234.2', '2010-01-23', 1, '1.80', '1.8'),
(150, 'white&green', '139.130.234.2', '2010-01-23', 1, '1.30', '1.3');

-- --------------------------------------------------------

--
-- Table structure for table `orders_orders`
--

CREATE TABLE IF NOT EXISTS `orders_orders` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_status` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `pending_reason` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `payment_date` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `subtotal` double NOT NULL,
  `Handling` double NOT NULL,
  `gross` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `invoice` varchar(30) COLLATE utf8_bin NOT NULL,
  `payer_email` varchar(127) COLLATE utf8_bin DEFAULT NULL,
  `protection_eligibility` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `cust_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `items` longtext COLLATE utf8_bin,
  `creation_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `store_status` varchar(15) COLLATE utf8_bin DEFAULT 'PENDING',
  `locked_by` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Names` varchar(150) COLLATE utf8_bin NOT NULL,
  `Address` tinyblob NOT NULL,
  `mobile` varchar(12) COLLATE utf8_bin NOT NULL,
  `phone` varchar(12) COLLATE utf8_bin NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_state` varchar(10) COLLATE utf8_bin NOT NULL,
  `type` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'Web',
  PRIMARY KEY (`id`),
  KEY `store_status` (`store_status`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `orders_orders`
--

INSERT INTO `orders_orders` (`id`, `payment_status`, `pending_reason`, `payment_date`, `subtotal`, `Handling`, `gross`, `tax`, `currency`, `invoice`, `payer_email`, `protection_eligibility`, `cust_id`, `items`, `creation_timestamp`, `store_status`, `locked_by`, `Names`, `Address`, `mobile`, `phone`, `last_edited`, `order_state`, `type`) VALUES
(1, 'Completed', '', '20:33:28 Aug 29, 2009 ', 91.22, 35, 96.84, 5.62, 'AUD', 'D0908303335R', 'denisereichle@bigpond.com', 'Ineligible', '1', 'a:16:{i:0;a:6:{s:11:"products_id";i:10;s:3:"ref";s:3:"157";s:7:"flavour";N;s:5:"title";s:17:"ZAZI GUM  1kg BAG";s:8:"quantity";i:1;s:11:"final_price";s:5:"32.00";}i:1;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:2;a:6:{s:11:"products_id";i:3;s:3:"ref";s:3:"143";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LICORICE 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:3;a:6:{s:11:"products_id";i:8;s:3:"ref";s:3:"154";s:7:"flavour";N;s:5:"title";s:18:"ZAZI 3-FRUITS.1x24";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.80";}i:4;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:5;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:6;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:7;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:8;a:6:{s:11:"products_id";i:10;s:3:"ref";s:3:"157";s:7:"flavour";N;s:5:"title";s:17:"ZAZI GUM  1kg BAG";s:8:"quantity";i:3;s:11:"final_price";s:5:"32.00";}i:9;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:10;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:11;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:12;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:9;s:11:"final_price";s:4:"1.40";}i:13;a:6:{s:11:"products_id";i:8;s:3:"ref";s:3:"154";s:7:"flavour";N;s:5:"title";s:18:"ZAZI 3-FRUITS.1x24";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.80";}i:14;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:15;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}}', '2009-08-29 13:26:02', 'Processing', 'storeadmin', 'Denise Reichle', 0x3c62723e3c623e204e616d65203a3c2f623e2044656e6973652052656963686c653c62723e3c623e20436f6e7461637473203a3c2f623e20303734363935313631383c6272202f3e3c623e204d6f62696c65203a203c2f623e303432393737363631383c62723e3c623e20456d61696c203a3c2f623e2064656e69736572656963686c6540626967706f6e642e636f6d3c62723e3c623e2041646472657373203a3c2f623e203820476f6c6620436c75622052643c62723e20514c4420202c4d696c6c6d657272616e2c204175737472616c69612c2034333537, '0429776618', '0746951618', '2009-09-09 09:50:25', 'QLD', 'Web'),
(6, 'Completed', '', '18:12:15 May 15, 2010 ', 10.32, 0, 12.34, 2.02, 'USD', 'D1005161636O', '', '', '1', 'a:16:{i:0;a:6:{s:11:"products_id";i:10;s:3:"ref";s:3:"157";s:7:"flavour";N;s:5:"title";s:17:"ZAZI GUM  1kg BAG";s:8:"quantity";i:1;s:11:"final_price";s:5:"32.00";}i:1;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:2;a:6:{s:11:"products_id";i:3;s:3:"ref";s:3:"143";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LICORICE 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:3;a:6:{s:11:"products_id";i:8;s:3:"ref";s:3:"154";s:7:"flavour";N;s:5:"title";s:18:"ZAZI 3-FRUITS.1x24";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.80";}i:4;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:5;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:6;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:7;a:6:{s:11:"products_id";i:9;s:3:"ref";s:3:"155";s:7:"flavour";N;s:5:"title";s:19:"ZAZI MENTHOL EUCALY";s:8:"quantity";i:8;s:11:"final_price";s:4:"1.80";}i:8;a:6:{s:11:"products_id";i:10;s:3:"ref";s:3:"157";s:7:"flavour";N;s:5:"title";s:17:"ZAZI GUM  1kg BAG";s:8:"quantity";i:3;s:11:"final_price";s:5:"32.00";}i:9;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:10;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:11;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:12;a:6:{s:11:"products_id";i:1;s:3:"ref";s:3:"141";s:7:"flavour";N;s:5:"title";s:18:"ZIZI PEPP.25g 1x36";s:8:"quantity";i:9;s:11:"final_price";s:4:"1.40";}i:13;a:6:{s:11:"products_id";i:8;s:3:"ref";s:3:"154";s:7:"flavour";N;s:5:"title";s:18:"ZAZI 3-FRUITS.1x24";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.80";}i:14;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}i:15;a:6:{s:11:"products_id";i:4;s:3:"ref";s:3:"144";s:7:"flavour";N;s:5:"title";s:18:"ZIZI LIC/MINT.1x36";s:8:"quantity";i:1;s:11:"final_price";s:4:"1.40";}}', '2010-05-15 00:00:00', 'Pending', '', 'David Oabile', 0x3c62723e3c623e204e616d65203a3c2f623e204461766964204f6162696c653c62723e3c623e20436f6e7461637473203a3c2f623e2030373535383232343536323c6272202f3e3c623e204d6f62696c65203a203c2f623e3034323135343235343235343c62723e3c623e20456d61696c203a3c2f623e20646f6162696c6540696e666f73797370726f2e636f6d2e61753c62723e3c623e2041646472657373203a3c2f623e2032332062757272206372743c62723e2020202c506163696669632c20426f747377616e612c0a202020202020202020202020202020202020202034353231, '042154254254', '07558224562', '2010-05-15 00:00:00', 'QLD', 'Web');

-- --------------------------------------------------------

--
-- Table structure for table `process_orders`
--

CREATE TABLE IF NOT EXISTS `process_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` varchar(20) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_process_orders_item_id` (`item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2862 ;

-- --------------------------------------------------------

--
-- Table structure for table `prodcat`
--

CREATE TABLE IF NOT EXISTS `prodcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `descr` text,
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `prodcat`
--

INSERT INTO `prodcat` (`id`, `title`, `photo`, `descr`, `reserved`) VALUES
(15, 'Zizi Products', NULL, 'Zizi Mints Products', '1'),
(16, 'Zazi Products', NULL, 'Zazi Products', '1');

-- --------------------------------------------------------

--
-- Table structure for table `prodcat_prodcat`
--

CREATE TABLE IF NOT EXISTS `prodcat_prodcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `descr` text,
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `prodcat_prodcat`
--

INSERT INTO `prodcat_prodcat` (`id`, `title`, `photo`, `descr`, `reserved`) VALUES
(15, 'Zizi Products', NULL, 'Zizi Mints Products', '1'),
(16, 'Zazi Products', NULL, 'Zazi Products', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `prodcat` varchar(255) NOT NULL DEFAULT '',
  `flavour` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `boxcost_exgst` float DEFAULT NULL,
  `boxcost_gst` varchar(100) DEFAULT NULL,
  `unitcost_exgst` varchar(100) DEFAULT NULL,
  `retail_price` float DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `tun` varchar(100) NOT NULL,
  `ingredients` text,
  `energy` varchar(100) DEFAULT NULL,
  `protein` varchar(100) DEFAULT NULL,
  `fat` varchar(100) DEFAULT NULL,
  `sat_fat` varchar(100) DEFAULT NULL,
  `trans_fat` varchar(100) DEFAULT NULL,
  `carb` varchar(100) DEFAULT NULL,
  `sugars` varchar(100) DEFAULT NULL,
  `lactitol` varchar(100) DEFAULT NULL,
  `isomalt` varchar(100) DEFAULT NULL,
  `mannitol` varchar(100) DEFAULT NULL,
  `maltitol` varchar(100) DEFAULT NULL,
  `polydextrose` varchar(100) DEFAULT NULL,
  `sorbitol` varchar(100) DEFAULT NULL,
  `fibre` varchar(100) DEFAULT NULL,
  `inulin` varchar(100) DEFAULT NULL,
  `gum` varchar(100) DEFAULT NULL,
  `sodium` varchar(100) DEFAULT NULL,
  `potassium` varchar(100) DEFAULT NULL,
  `ethical` text,
  `title` text,
  `photo` varchar(255) DEFAULT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `title` (`description`),
  KEY `flavour` (`flavour`),
  KEY `prodcat` (`prodcat`),
  KEY `ref` (`ref`),
  KEY `reserved` (`reserved`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ref`, `description`, `prodcat`, `flavour`, `quantity`, `boxcost_exgst`, `boxcost_gst`, `unitcost_exgst`, `retail_price`, `barcode`, `tun`, `ingredients`, `energy`, `protein`, `fat`, `sat_fat`, `trans_fat`, `carb`, `sugars`, `lactitol`, `isomalt`, `mannitol`, `maltitol`, `polydextrose`, `sorbitol`, `fibre`, `inulin`, `gum`, `sodium`, `potassium`, `ethical`, `title`, `photo`, `visible`, `reserved`) VALUES
(1, '141', 'ZIZI PEPPERMINT (GREEN & WHITE) 25g (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300141', '931264300143', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI PEPP.25g 1x36', 'greenandwhite.jpg', '1', '0'),
(2, '142', 'ZIZI HOT MINT  FLAVOUR. 25g  (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300142', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI HOT MINT 1x36', 'redandwhite.jpg', '1', '0'),
(3, '143', 'ZIZI LICORICE FLAV.(BLACK & WHITE) 25g (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300143', '', NULL, '4', '45', '454', '45', '454', '454', '454', '454', '454', '454', 'w4', 'w4w', 'wewe', 'wewe', 'wew', 'wew', 'wew', 'wew', 'no thong yet ', 'ZIZI LICORICE 1x36', 'blackandwhite.jpg', '1', '0'),
(4, '144', 'ZIZI LICORICE & MINT FLAV. 25g (36/BOX)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300144', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI LIC/MINT.1x36', NULL, '1', '0'),
(5, '151', 'ZAZI BLACKCURRANT FLAV. 25g (24/Box)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300151', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI B/CURRANT.1x24', 'zazi_blackcurrant.jpg', '1', '0'),
(6, '152', 'ZAZI ORANGE FLAVOUR 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300152', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI ORANGE 1x24', 'zazi_orange.jpg', '1', '0'),
(7, '153', 'ZAZI MANGO FLAVOUR 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300153', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI MANGO FL. 1x24', 'zazi_mango.jpg', '1', '0'),
(8, '154', 'ZAZI 3-FRUIT FLAVOURS 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300154', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI 3-FRUITS.1x24', NULL, '1', '0'),
(9, '155', 'ZAZI MENTHOL EUCALYPTUS XTRA-STRONG 25g.(24/Box)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300155', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI MENTHOL EUCALY', NULL, '1', '0'),
(10, '157', 'ZAZI SUGARFREE GUM 1kg BAG BULK', '16', NULL, '1', 18, '19.8', '18', 32, '?', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI GUM  1kg BAG', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `product_product`
--

CREATE TABLE IF NOT EXISTS `product_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `prodcat` varchar(255) NOT NULL DEFAULT '',
  `flavour` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `boxcost_exgst` float DEFAULT NULL,
  `boxcost_gst` varchar(100) DEFAULT NULL,
  `unitcost_exgst` varchar(100) DEFAULT NULL,
  `retail_price` float DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `ingredients` text,
  `energy` varchar(100) DEFAULT NULL,
  `protein` varchar(100) DEFAULT NULL,
  `fat` varchar(100) DEFAULT NULL,
  `sat_fat` varchar(100) DEFAULT NULL,
  `trans_fat` varchar(100) DEFAULT NULL,
  `carb` varchar(100) DEFAULT NULL,
  `sugars` varchar(100) DEFAULT NULL,
  `lactitol` varchar(100) DEFAULT NULL,
  `isomalt` varchar(100) DEFAULT NULL,
  `mannitol` varchar(100) DEFAULT NULL,
  `maltitol` varchar(100) DEFAULT NULL,
  `polydextrose` varchar(100) DEFAULT NULL,
  `sorbitol` varchar(100) DEFAULT NULL,
  `fibre` varchar(100) DEFAULT NULL,
  `inulin` varchar(100) DEFAULT NULL,
  `gum` varchar(100) DEFAULT NULL,
  `sodium` varchar(100) DEFAULT NULL,
  `potassium` varchar(100) DEFAULT NULL,
  `ethical` text,
  `descr` text,
  `photo` varchar(255) DEFAULT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `flavour` (`flavour`),
  KEY `prodcat` (`prodcat`),
  KEY `ref` (`ref`),
  KEY `reserved` (`reserved`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=369 ;

--
-- Dumping data for table `product_product`
--

INSERT INTO `product_product` (`id`, `ref`, `title`, `prodcat`, `flavour`, `quantity`, `boxcost_exgst`, `boxcost_gst`, `unitcost_exgst`, `retail_price`, `barcode`, `ingredients`, `energy`, `protein`, `fat`, `sat_fat`, `trans_fat`, `carb`, `sugars`, `lactitol`, `isomalt`, `mannitol`, `maltitol`, `polydextrose`, `sorbitol`, `fibre`, `inulin`, `gum`, `sodium`, `potassium`, `ethical`, `descr`, `photo`, `visible`, `reserved`) VALUES
(341, '141', 'ZIZI PEPPERMINT (GREEN & WHITE) 25g (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300141', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI PEPP.25g 1x36', NULL, '1', '0'),
(342, '142', 'ZIZI HOT MINT  FLAVOUR. 25g  (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300142', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI HOT MINT 1x36', NULL, '1', '0'),
(343, '143', 'ZIZI LICORICE FLAV.(BLACK & WHITE) 25g (36/Box)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300143', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI LICORICE 1x36', NULL, '1', '0'),
(344, '144', 'ZIZI LICORICE & MINT FLAV. 25g (36/BOX)', '15', NULL, '36', 34.2, '37.62', '0.95', 1.4, '931264300144', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZIZI LIC/MINT.1x36', NULL, '1', '0'),
(345, '151', 'ZAZI BLACKCURRANT FLAV. 25g (24/Box)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300151', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI B/CURRANT.1x24', NULL, '1', '0'),
(346, '152', 'ZAZI ORANGE FLAVOUR 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300152', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI ORANGE 1x24', NULL, '1', '0'),
(347, '153', 'ZAZI MANGO FLAVOUR 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300153', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI MANGO FL. 1x24', NULL, '1', '0'),
(348, '154', 'ZAZI 3-FRUIT FLAVOURS 25g (24/BOX)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300154', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI 3-FRUITS.1x24', NULL, '1', '0'),
(349, '155', 'ZAZI MENTHOL EUCALYPTUS XTRA-STRONG 25g.(24/Box)', '16', NULL, '24', 29.52, '32.472', '1.23', 1.8, '931264300155', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI MENTHOL EUCALY', NULL, '1', '0'),
(350, '157', 'ZAZI SUGARFREE GUM 1kg BAG BULK', '16', NULL, '1', 18, '19.8', '18', 32, '?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZAZI GUM  1kg BAG', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `rep_rep`
--

CREATE TABLE IF NOT EXISTS `rep_rep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `state` enum('1','2','3','4','5','6','7','8','9') NOT NULL DEFAULT '1',
  `carid` varchar(254) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` enum('6') NOT NULL DEFAULT '6',
  `repid1` int(11) DEFAULT NULL,
  `repid2` int(11) DEFAULT NULL,
  `repid3` int(11) DEFAULT NULL,
  `repid4` int(11) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `login` (`login`),
  KEY `state` (`state`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `talents`
--

CREATE TABLE IF NOT EXISTS `talents` (
  `ID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(20) NOT NULL DEFAULT '',
  `Lastname` varchar(20) NOT NULL DEFAULT '',
  `Street` varchar(30) NOT NULL DEFAULT '',
  `State` varchar(5) NOT NULL DEFAULT '',
  `City` varchar(30) NOT NULL DEFAULT '',
  `Postcode` varchar(4) NOT NULL DEFAULT '',
  `Country` varchar(30) DEFAULT NULL,
  `Hometel` varchar(10) NOT NULL DEFAULT '',
  `Upload` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `Date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20066 ;

--
-- Dumping data for table `talents`
--

INSERT INTO `talents` (`ID`, `Firstname`, `Lastname`, `Street`, `State`, `City`, `Postcode`, `Country`, `Hometel`, `Upload`, `email`, `Date`) VALUES
(20065, 'David', 'Oabile', '29 William St', 'QLD', 'Rockhampton', '4700', 'Australia', '0749273633', '1-01 Vivaldi_2.mp3', 'davido@cyberoz.com.au', '2006-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `TbAclResources`
--

CREATE TABLE IF NOT EXISTS `TbAclResources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TbAclResources`
--

INSERT INTO `TbAclResources` (`id`, `name`, `inheritsFrom_id`, `sort_order`) VALUES
(1, 'cms', NULL, 0),
(2, 'home', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `TbAclRoles`
--

CREATE TABLE IF NOT EXISTS `TbAclRoles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `TbAclRoles`
--

INSERT INTO `TbAclRoles` (`id`, `name`, `inheritsFrom_id`, `sort_order`, `title`) VALUES
(1, 'guest', 0, 1, 'Public Access'),
(2, 'registered', 1, 2, 'Registered Users'),
(3, 'editor', 2, 3, 'Content Editor'),
(4, 'publisher', 3, 4, 'Content Publisher'),
(5, 'manager', 3, 4, 'Content Manager'),
(6, 'administrator', 0, 999, 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `TbAclRolesResources`
--

CREATE TABLE IF NOT EXISTS `TbAclRolesResources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_role_id` int(10) unsigned NOT NULL,
  `acl_resource_id` int(10) unsigned NOT NULL,
  `privilege` varchar(45) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_role_res_priv` (`acl_role_id`,`acl_resource_id`,`privilege`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TbAclRolesResources`
--

INSERT INTO `TbAclRolesResources` (`id`, `acl_role_id`, `acl_resource_id`, `privilege`, `sort_order`) VALUES
(1, 1, 2, 'edit', 0),
(2, 2, 1, 'view', 2);

-- --------------------------------------------------------

--
-- Table structure for table `TbBanners`
--

CREATE TABLE IF NOT EXISTS `TbBanners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `TbBanners`
--

INSERT INTO `TbBanners` (`id`, `cid`, `type`, `name`, `alias`, `imptotal`, `impmade`, `clicks`, `clickurl`, `state`, `catid`, `description`, `custombannercode`, `sticky`, `ordering`, `metakey`, `params`, `own_prefix`, `metakey_prefix`, `purchase_type`, `track_clicks`, `track_impressions`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `reset`, `created`, `language`) VALUES
(2, 3, 0, 'Shop 1', 'shop-1', 0, 62, 2, 'http://shop.joomla.org/amazoncom-bookstores.html', 1, 15, 'Get books about Joomla! at the Joomla! book shop.', '', 0, 1, '', '{"imageurl":"images\\/banners\\/white.png","width":"","height":"","alt":"Joomla! Books"}', 0, '', -1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-01-01 00:00:01', 'en-GB'),
(3, 2, 0, 'Shop 2', 'shop-2', 0, 112, 2, 'http://shop.joomla.org', 1, 15, 'T Shirts, caps and more from the Joomla! Shop.', '', 0, 2, '', '{"imageurl":"images\\/banners\\/white.png","width":"","height":"","alt":"Joomla! Shop"}', 0, '', -1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-01-01 00:00:01', 'en-GB'),
(4, 1, 0, 'Support Joomla!', 'support-joomla', 0, 31, 1, 'http://contribute.joomla.org', 1, 15, 'Your contributions of time, talent and money make Joomla! possible.', '', 0, 3, '', '{"imageurl":"images\\/banners\\/white.png","width":"","height":"","alt":""}', 0, '', -1, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'en-GB');

-- --------------------------------------------------------

--
-- Table structure for table `TbBlocks`
--

CREATE TABLE IF NOT EXISTS `TbBlocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `control` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `TbBlocks`
--

INSERT INTO `TbBlocks` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
(1, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, '{\r\n "classmod" : "test"\r\n}\r\n', 1, 0, ''),
(2, 'Login', 'Login form', 1, 'login', 0, '0000-00-00 00:00:00', 0, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, ''),
(16, 'Polls', '', 6, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, 'id=14\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(17, 'User Menu', '', 9, 'left', 1, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu\nmoduleclass_sfx=_menu\ncache=1', 1, 0, ''),
(18, 'Login Form', '<div id="login-module">\r\n<div>\r\n<form id="login" name="login" method="post" action="http://www.sugarfreepeople.com/index.php?option=com_user&task=login">\r\n<div class="username-block">\r\n<label for="username_vmlogin">Username</label>\r\n<input id="username_vmlogin" class="inputbox" type="text" name="username" size="12">\r\n</div><br />\r\n<div class="password-block">\r\n<label for="password_vmlogin">Password</label>\r\n<input id="password_vmlogin" class="inputbox" type="password" name="passwd" size="12">\r\n</div>\r\n<div class="login-extras">\r\n<label for="remember_vmlogin">Remember me</label>\r\n<input id="remember_vmlogin" type="checkbox" checked="checked" value="yes" name="remember">\r\n<input class="button" type="submit" name="Login" value="Login">\r\n<ul>\r\n<li>\r\n<a href="/index.php?option=com_user&view=reset">Lost Password?</a>\r\n</li>\r\n<li>\r\n<a href="/index.php?option=com_user&view=remind">Forgot your username?</a>\r\n</li>\r\n</ul>\r\n<input type="hidden" name="op2" value="login">\r\n<input type="hidden" name="return" value="aHR0cDovL3N1Z2FyZnJlZS5pbmZvc3lzcHJvLmNvbS9pbmRleC5waHA/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD01MiZJdGVtaWQ9NjY=">\r\n<input type="hidden" value="1" name="38a31ed5af6e9982a2ef2d9124570fe1">\r\n</div>\r\n</form>\r\n</div>\r\n</div>\r\n', 2, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '{\r\n"moduleclass_sfx" : "bettey" \r\n}\r\n\r\n\r\n', 1, 0, ''),
(19, 'Latest News', '', 0, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, 'count=5\nordering=c_dsc\nuser_id=0\nshow_front=1\nsecid=\ncatid=\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n', 1, 0, ''),
(20, 'Statistics', '', 11, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0, ''),
(21, 'Who''s Online', '', 21, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_whosonline', 0, 0, 1, 'cache=0\nshowmode=0\nmoduleclass_sfx=\n\n', 0, 0, ''),
(22, 'Popular', '', 0, 'user5', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, 'moduleclass_sfx=\nshow_front=1\ncount=5\ncatid=\nsecid=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(23, 'Archive', '', 12, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, 'cache=1', 1, 0, ''),
(24, 'Sections', '', 13, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, 'cache=1', 1, 0, ''),
(25, 'Newsflash', '', 6, 'user1', 0, '0000-00-00 00:00:00', 0, 'mod_newsflash', 0, 0, 1, 'catid=3\nlayout=default\nimage=0\nlink_titles=\nshowLastSeparator=1\nreadmore=0\nitem_title=0\nitems=\nmoduleclass_sfx=\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(26, 'Related Items', '', 14, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0, ''),
(27, 'Search', '', 1, 'search-right', 0, '0000-00-00 00:00:00', 0, 'mod_search', 0, 0, 0, 'moduleclass_sfx=\nwidth=20\ntext=\nbutton=\nbutton_pos=right\nimagebutton=\nbutton_text=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(28, 'Random Image', '', 12, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0, ''),
(29, 'Top Menu', '', 1, 'bottom-menu', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=-nav\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=-1\nindent_image2=-1\nindent_image3=-1\nindent_image4=-1\nindent_image5=-1\nindent_image6=-1\nspacer=\nend_spacer=\n\n', 1, 0, ''),
(30, 'Banners', '', 4, 'user1', 0, '0000-00-00 00:00:00', 0, 'mod_banners', 0, 0, 0, 'target=1\ncount=1\ncid=1\ncatid=33\ntag_search=0\nordering=random\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=15\n\n', 1, 0, ''),
(31, 'Resources', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=othermenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(32, 'Wrapper', '', 15, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_wrapper', 0, 0, 1, '', 0, 0, ''),
(33, 'Footer', '', 1, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 0, 'cache=1\n\n', 1, 0, ''),
(34, 'Feed Display', '', 16, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_feed', 0, 0, 1, '', 1, 0, ''),
(35, 'Breadcrumbs', '', 0, 'breadcrumb', 0, '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 0, 0, 1, 'showHome=1\nhomeText=Home\nshowLast=1\nseparator=/\nmoduleclass_sfx=\ncache=0\n\n', 1, 0, ''),
(36, 'Syndication', '', 1, 'syndicate', 0, '0000-00-00 00:00:00', 1, 'mod_syndicate', 0, 0, 0, '', 1, 0, ''),
(38, 'Advertisement', '', 7, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 1, 'target=1\ncount=4\ncid=0\ncatid=14\ntag_search=0\nordering=0\nheader_text=Featured Links:\nfooter_text=<a href="http://www.joomla.org">Ads by Joomla!</a>\nmoduleclass_sfx=_text\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(39, 'Example Pages', '', 10, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, 'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=ExamplePages\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n', 0, 0, ''),
(40, 'Key Concepts', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=keyconcepts\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(41, 'Welcome to Joomla!', '<div style="padding: 5px">  <p>   Congratulations on choosing Joomla! as your content management system. To   help you get started, check out these excellent resources for securing your   server and pointers to documentation and other helpful resources. </p> <p>   <strong>Security</strong><br /> </p> <p>   On the Internet, security is always a concern. For that reason, you are   encouraged to subscribe to the   <a href="http://feedburner.google.com/fb/a/mailverify?uri=JoomlaSecurityNews" target="_blank">Joomla!   Security Announcements</a> for the latest information on new Joomla! releases,   emailed to you automatically. </p> <p>   If this is one of your first Web sites, security considerations may   seem complicated and intimidating. There are three simple steps that go a long   way towards securing a Web site: (1) regular backups; (2) prompt updates to the   <a href="http://www.joomla.org/download.html" target="_blank">latest Joomla! release;</a> and (3) a <a href="http://docs.joomla.org/Security_Checklist_2_-_Hosting_and_Server_Setup" target="_blank" title="good Web host">good Web host</a>. There are many other important security considerations that you can learn about by reading the <a href="http://docs.joomla.org/Category:Security_Checklist" target="_blank" title="Joomla! Security Checklist">Joomla! Security Checklist</a>. </p> <p>If you believe your Web site was attacked, or you think you have discovered a security issue in Joomla!, please do not post it in the Joomla! forums. Publishing this information could put other Web sites at risk. Instead, report possible security vulnerabilities to the <a href="http://developer.joomla.org/security/contact-the-team.html" target="_blank" title="Joomla! Security Task Force">Joomla! Security Task Force</a>.</p><p><strong>Learning Joomla!</strong> </p> <p>   A good place to start learning Joomla! is the   "<a href="http://docs.joomla.org/beginners" target="_blank">Absolute Beginner''s   Guide to Joomla!.</a>" There, you will find a Quick Start to Joomla!   <a href="http://help.joomla.org/ghop/feb2008/task048/joomla_15_quickstart.pdf" target="_blank">guide</a>   and <a href="http://help.joomla.org/ghop/feb2008/task167/index.html" target="_blank">video</a>,   amongst many other tutorials. The   <a href="http://community.joomla.org/magazine/view-all-issues.html" target="_blank">Joomla!   Community Magazine</a> also has   <a href="http://community.joomla.org/magazine/article/522-introductory-learning-joomla-using-sample-data.html" target="_blank">articles   for new learners</a> and experienced users, alike. A great place to look for   answers is the   <a href="http://docs.joomla.org/Category:FAQ" target="_blank">Frequently Asked   Questions (FAQ)</a>. If you are stuck on a particular screen in the   Administrator (which is where you are now), try clicking the Help toolbar   button to get assistance specific to that page. </p> <p>   If you still have questions, please feel free to use the   <a href="http://forum.joomla.org/" target="_blank">Joomla! Forums.</a> The forums   are an incredibly valuable resource for all levels of Joomla! users. Before   you post a question, though, use the forum search (located at the top of each   forum page) to see if the question has been asked and answered. </p> <p>   <strong>Getting Involved</strong> </p> <p>   <a name="twjs" title="twjs"></a> If you want to help make Joomla! better, consider getting   involved. There are   <a href="http://www.joomla.org/about-joomla/contribute-to-joomla.html" target="_blank">many ways   you can make a positive difference.</a> Have fun using Joomla!.</p></div>', 0, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 2, 1, 'moduleclass_sfx=\n\n', 1, 1, ''),
(42, 'Joomla! Security Newsfeed', '', 6, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_feed', 0, 0, 1, 'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://feeds.joomla.org/JoomlaSecurityNews\nrssrtl=0\nrsstitle=1\nrssdesc=0\nrssimage=1\nrssitems=1\nrssitemdesc=1\nword_count=0\n\n', 0, 1, ''),
(43, 'RokNavMenu', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 0, 'mod_roknavmenu', 0, 0, 1, 'menutype=mainmenu\nlimit_levels=0\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\ntemplate_menuRowsPerColumn=\ntemplate_menuColumns=\ntemplate_menuMultiColLevel=\nurl_type=relative\ncache=0\nmodule_cache=1\ncache_time=900\ntag_id=\nclass_sfx=\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_link=0\n\n', 0, 0, ''),
(44, 'RokAjaxSearch', '', 0, 'search-left', 0, '0000-00-00 00:00:00', 1, 'mod_rokajaxsearch', 0, 0, 0, 'moduleclass_sfx=\nsearch_page=index2.php?option=com_search&view=search&tmpl=component\nadv_search_page=index.php?option=com_search&view=search\ninclude_css=1\nsearchphrase=any\nordering=newest\nlimit=10\nperpage=3\nhide_divs=\ninclude_link=1\nshow_description=1\ninclude_category=1\nshow_readmore=1\n\n', 0, 0, ''),
(45, 'Product Categories', '', 17, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_rokvirtuemart_categories', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(47, 'RokVirtuemart Scroller', '', 1, 'scroller', 0, '0000-00-00 00:00:00', 1, 'mod_rokvirtuemart_scroller', 0, 0, 0, 'moduleclass_sfx=\nsorting=random\nfeatured=yes\nshow_title=1\nshow_price=1\ncount=9\ndirection=horizontal\nheight=300\nduration=800\nfxeffect=Quad.easeOut\namount=200\narrows_effect=1\narrows_color=auto\nautoscroll=0\nscrolldelay=2\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(48, 'Showcase Hero', '<div class="showcase-hero"></div>', 1, 'showcase', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(90, 'Mod Showcase2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.', 1, 'showcase2', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=media\n\n', 0, 0, ''),
(91, 'Mod Showcase3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.', 1, 'showcase3', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=user\n\n', 0, 0, ''),
(92, 'Mod Bottom2', 'This is the <b>Bottom2</b> module position, which is using the <b>cart</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'bottom2', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=cart\n\n', 0, 0, ''),
(93, 'Mod Bottom3', 'This is the <b>Bottom3</b> module position, which is using the <b>user</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'bottom3', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=user\n\n', 0, 0, ''),
(54, 'Currency Selector', '', 19, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_virtuemart_currencies', 0, 0, 1, 'text_before=\nproduct_currency=AUD,BRL,CAD,EUR,JPY,USD,\ncache=0\nmoduleclass_sfx=\nclass_sfx=\n\n', 0, 0, ''),
(94, 'Featured Products', '', 5, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_rokvirtuemart_featureprod', 0, 0, 1, 'max_items=2\nshow_price=1\nshow_addtocart=1\ndisplay_style=vertical\nproducts_per_row=4\ncategory_id=\ncache=0\nmoduleclass_sfx=cart\nclass_sfx=\n\n', 0, 0, ''),
(95, 'More Information', '[moreinfo icon="1" url="index.php?option=com_content&amp;view=article&amp;id=53&amp;Itemid=68" title="More Information"]Learn more about Mynxx[/moreinfo]\r\n\r\n[moreinfo icon="2" url="index.php?option=com_content&amp;view=article&amp;id=52&amp;Itemid=66" title="The Top Lists"]Lots of typography to choose from.[/moreinfo]\r\n\r\n[moreinfo icon="3" url="index.php?option=com_content&amp;view=article&amp;id=46&amp;Itemid=54" title="More Features"]New dynamic functionality and options.[/moreinfo]', 20, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(62, 'Shopping Content', '<b>Important:</b> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners.', 4, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(63, 'Virtuemart', 'Virtuemart is the most popular shopping component Joomla. For more information on Virtuemart, please go to <a href="http://www.virtuemart.net">www.virtuemart.net</a>', 22, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(64, 'Mod Left', 'This is the <b>Left</b> module position, which is using the <b>color1</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color1\n\n', 0, 0, ''),
(65, 'Blog Menu', 'This is the <b>Right</b> module position, which is using the <b>color2</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 8, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color2\n\n', 0, 0, ''),
(102, 'Mod Right', 'This is the <b>Right</b> module position, which is using the <b>arrow2</b> module class suffix.', 10, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, '{"moduleclass" : "arrow2" }\r\n\r\n', 0, 0, ''),
(66, 'Mod User1', 'This is the <b>User1</b> module position, which is using the <b>faq</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 5, 'user1', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=faq\n\n', 0, 0, ''),
(67, 'Mod User2', 'This is the <b>User2</b> module position, which is using the <b>cart</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 2, 'user2', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=cart\n\n', 0, 0, ''),
(68, 'Mod User3', 'This is the <b>User3</b> module position, which is using the <b>rss</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 1, 'user3', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=rss\n\n', 0, 0, ''),
(69, 'Mod User4', 'This is the <b>User4</b> module position, which is using the <b>media</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 2, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=media\n\n', 0, 0, ''),
(70, 'Mod User5', 'This is the <b>User5</b> module position, which is using the <b>check</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 2, 'user5', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=check\n\n', 0, 0, ''),
(71, 'Mod User6', 'This is the <b>User6</b> module position, which is using the <b>info</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'user6', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=info\n\n', 0, 0, ''),
(72, 'Mod User7', 'This is the <b>User7</b> module position, which is using the <b>alert</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'user7', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=alert\n\n', 0, 0, ''),
(73, 'Mod User8', 'This is the <b>User8</b> module position, which is using the <b>attention</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'user8', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=attention\n\n', 0, 0, ''),
(74, 'Mod User9', 'This is the <b>User9</b> module position, which is using the <b>download</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'user9', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=download\n\n', 0, 0, ''),
(75, 'Mod Inset2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 2, 'inset2', 62, '2012-01-15 06:13:55', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(76, 'Mod Showcase', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.', 2, 'showcase', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=cart\n\n', 0, 0, ''),
(77, 'Mod Bottom', 'This is the <b>Bottom</b> module position, which is using the <b>faq</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'bottom', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=faq\n\n', 0, 0, ''),
(78, 'Mod Scroller', '<b><u>Scroller Module Position</u>: primary function is to accommodate the Virtuemart product scroller.</b><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.', 2, 'scroller', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(108, 'Testing Information', 'You can test out the checkout process and view the extensive VirtueMart style customization by using a dummy account information.  Joomla account creation has been turned off in this demo.', 18, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color1\n\n', 0, 0, ''),
(111, 'VirtueMart Login', 'test form', 0, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_rokvirtuemart_login', 0, 0, 1, 'moduleclass_sfx=\npretext=\nposttext=\nlogin=samepage\nlogout=samepage\ngreeting=1\nname=0\naccountlink=1\n\n', 0, 0, ''),
(81, 'Mod Left', 'This is the <b>Left</b> module position, which is using the <b>color2</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color2\n\n', 0, 0, ''),
(100, 'Mod Left', 'This is the <b>Left</b> module position, which is using the <b>arrow</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 6, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=arrow\n\n', 0, 0, ''),
(82, 'Mod Right', 'This is the <b>Right</b> module position, which is using the <b>attention</b> module class suffix.', 11, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=attention\n\n', 0, 0, ''),
(83, 'Mod Left', 'This is the <b>Left</b> module position, which is using the <b>color3</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 5, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color3\n\n', 0, 0, ''),
(84, 'Mod Right', 'This is the <b>Right</b> module position, which is using the <b>color3</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color3\n\n', 0, 0, ''),
(85, 'Demo Information', '<b>Important:</b> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners.  \r\n<br /><br />\r\nThis is not an actual store, non of the products are for sale and the information maybe inaccurate such as pricing.', 2, 'popup', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(87, 'Banner', '<img src="media/site/images/content/banners/shop-ad-books.jpg" alt="banner" style="margin-left: 43px; display: block; width: 468px;" />', 7, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(88, 'Banner FP', '<img src="images/banners/shop-ad-books.jpg" alt="banner" style="width: 468px; margin: 0px auto; display: block;"/>', 1, 'advertisement', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(89, 'RokTabs', '', 1, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_roktabs', 0, 0, 0, 'catid=37\nsecid=1\nordering=m_dsc\nuser_id=0\nstyle=base\nwidth=554\ntabs_count=0\nduration=600\ntransition_type=scrolling\ntransition_fx=Quad.easeInOut\ntabs_position=top\ntabs_title=content\ntabs_incremental=Tab\ntabs_hideh6=1\nautoplay=0\nautoplay_delay=2000\nmoduleclass_sfx=\ncache=0\nmodule_cache=1\ncache_time=900\n\n', 0, 0, ''),
(110, 'Inactive Modules', 'You should publish modules to the "<b>inactive</b>" position and set the Menus to "<b>All</b>", for them to show up on pages where there is no active menu ID.  This is a bug/feature of Joomla that causes only menu items in the "<b>All</b>" setting to show up.', 0, 'inactive', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color1\n\n', 0, 0, ''),
(101, 'Mod Inset2', 'This is the <b>Inset2</b> module position, which is using the <b>info</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 'inset2', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=info\n\n', 0, 0, ''),
(99, 'Mod Right', 'This is the <b>Right</b> module position, which is using the <b>color1</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.', 2, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=color1\n\n', 0, 0, ''),
(107, 'Variation Chooser', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_variationchooser', 0, 0, 1, 'title_length=20\nshow_preview=0\npreview_width=169\npreview_height=189\nmoduleclass_sfx=\n\n', 0, 0, ''),
(98, 'VM Newsflash', '', 8, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 0, 'catid=38\nlayout=default\nimage=1\nlink_titles=\nshowLastSeparator=1\nreadmore=0\nitem_title=0\nitems=\nmoduleclass_sfx=\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(103, 'FP Bottom', '<div style="float: left; width: 22%;">\r\n\r\n<h3>Popular Accessories</h3>\r\n\r\n<ul>\r\n<li><a href="#">iPhone bluetooth headset</a></li>\r\n<li><a href="#">iPod Touch Battery Pack</a></li>\r\n<li><a href="#">In Car charger</a></li>\r\n<li><a href="#">All terrain laptop case</a></li>\r\n<li><a href="#">Blastout Speakers</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n<div style="float: left; width: 22%;">\r\n\r\n<h3>Latest Products</h3>\r\n\r\n<ul>\r\n<li><a href="#">Macbook Air Rev. 3</a></li>\r\n<li><a href="#">16hr Lithium Battery</a></li>\r\n<li><a href="#">8GB RAM Upgrade kit</a></li>\r\n<li><a href="#">External 190GB SSD</a></li>\r\n<li><a href="#">Chillz Cooler</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n<div style="float: left; width: 22%;">\r\n\r\n<h3>Editors Choice</h3>\r\n\r\n<ul>\r\n<li><a href="#">iPod Touch 16GB</a></li>\r\n<li><a href="#">Macbook Air</a></li>\r\n<li><a href="#">iBlazt Portable Speaker</a></li>\r\n<li><a href="#">TwiceLife Travel Kit</a></li>\r\n<li><a href="#">32GB Upgrade Kit</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n\r\n\r\n<div style="float: left; width: 33%;">\r\n\r\n<h3>Disclaimer</h3>\r\n\r\n<strong>Important:</strong> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners. This is not an actual store, only representative of one.\r\n\r\n</div>\r\n\r\n<div class="clr"></div>', 2, 'bottom', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(106, 'Customer Poll', '', 23, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, 'id=15\nmoduleclass_sfx=info\ncache=1\ncache_time=900\n\n', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `TbBlocksMenu`
--

CREATE TABLE IF NOT EXISTS `TbBlocksMenu` (
  `blockid` int(11) NOT NULL DEFAULT '0',
  `menuid` varchar(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blockid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TbBlocksMenu`
--

INSERT INTO `TbBlocksMenu` (`blockid`, `menuid`) VALUES
(65, 'blogFirstblogpost'),
(65, 'blogIndex'),
(102, 'indexIndex');

-- --------------------------------------------------------

--
-- Table structure for table `TbBlogReplies`
--

CREATE TABLE IF NOT EXISTS `TbBlogReplies` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `icon_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_time` int(11) unsigned NOT NULL DEFAULT '0',
  `post_approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_reported` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `post_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `post_text` mediumtext COLLATE utf8_bin NOT NULL,
  `post_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `post_postcount` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_edit_user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_edit_count` smallint(4) unsigned NOT NULL DEFAULT '0',
  `post_edit_locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  KEY `user_ip` (`user_ip`),
  KEY `user_id` (`user_id`),
  KEY `post_approved` (`post_approved`),
  KEY `tid_post_time` (`blog_id`,`post_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TbConfig`
--

CREATE TABLE IF NOT EXISTS `TbConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleName` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `description` tinytext NOT NULL,
  `sortOrder` int(11) NOT NULL DEFAULT '1',
  `langid` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleName` (`moduleName`),
  KEY `language` (`langid`),
  KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `TbConfig`
--

INSERT INTO `TbConfig` (`id`, `moduleName`, `key`, `value`, `description`, `sortOrder`, `langid`) VALUES
(1, 'all', 'company', 'InfoSysPro', 'This is the name of the company that will be displayed through out the site', 1, 1),
(2, 'all', 'allowedFailedLoginAttempts', '3', 'This is the value used to monitor how many failed log in attempts should be used before the user can be locked out of the system for a certain period of time', 1, 9999),
(3, 'all', 'maximumLockOutFailedLoginAttemptsTime', '30', 'Maximum time the user should wait in minutes before they ca be allowed login', 1, 9999),
(4, 'all', 'useCache', 'false', 'Enable caching in order to boost performance', 1, 9999),
(5, 'User', 'lockUsers', '1', 'Lock users if the supply X number of failed login attempts; 1 = Yes and 0 = No', 1, 9999),
(6, 'User', 'allowRegistration', '1', 'Allow users to register on the site options are 1 = Yes and 0 = No', 1, 9999),
(7, 'mailConfig', 'mail.useSmtp', '1', 'Whether to use the default php mail function or the company''s mailserver\r\n1 = Yes, 0 = No', 1, 9999),
(8, 'mailConfig', 'mail.host', 'pop.infosyspro.com.au', 'the server of from which emails will be relayed through. Check if relaying of this site''s IP is allowed', 2, 9999),
(9, 'mailConfig', 'mail.username', 'doabile@infosyspro.com.au', 'username if the SMTP requires authentication ', 3, 9999),
(10, 'mailConfig', 'mail.password', 'dailer12', 'Password for the SMTP if authentication is allowed ', 4, 9999),
(11, 'mailConfig', 'mail.auth', 'login', 'Does our mail server require authentication? if yes what method is used examples are Crammd5 or Login or Plain. Check with your IT company. LEAVE BLANK to disable this', 1, 9999),
(12, 'mailConfig', 'mail.port', '587', 'The SMTP port the mailserver uses', 5, 9999),
(13, 'mailConfig', 'mail.sentFrom', 'doabile@infosyspro.com.au', 'Sender''s email', 6, 9999),
(14, 'mailConfig', 'mail.name', '', 'the name of the mail server', 7, 9999),
(15, 'mailConfig', 'mail.useHtml', '1', 'Use html email body otherwise use plain text. 1 = Yes and 0 = No', 8, 9999),
(16, 'mailConfig', 'mail.CCTo', 'support@infosyspro.com.au', 'email address to cc all emails to. LEAVE BLANK if none', 9, 9999),
(17, 'all', 'mail.sentFromName', 'David Oabile', 'Sender name', 10, 9999),
(18, 'mailConfig', 'mail.sentFromName', 'Tirelo Oabile', 'test duplicated', 1, 9999),
(19, 'formData', 'errorIncorrectData', 'Incorrect data detected in %s', 'Erreror displayed when there is data validation error', 1, 1),
(20, 'site', 'siteOffline', '0', 'determine if the site is offline or not', 1, 9999),
(21, 'site', 'offlineMessage', 'This site is down for maintenance.<br /> Please check back again soon.', 'Message displayed when the site is offline', 1, 1),
(22, 'site', 'defaultAccessLevel', 'Public', 'Default group to view the contents of the site', 1, 1),
(23, 'template', 'template.fontFamily', 'mynxx', 'Font family for the site layout', 1, 9999),
(24, 'template', 'template.width', '959', 'Template width', 1, 9999),
(25, 'template', 'template.leftColumnWidth', '210', 'Left column width', 1, 9999),
(26, 'template', 'template.rightColumnWidth', '210', 'Right column width', 1, 9999),
(27, 'template', 'template.leftInsetWidth', '180', 'Left Insert width', 1, 9999),
(28, 'template', 'template.rightInsetWidth', '180', 'Right Insert width', 1, 9999),
(29, 'template', 'template.SideMenu', 'mainmenu', 'Menu displayed on the side of the template', 1, 9999),
(30, 'template', 'template.defaultFont', 'default', 'Default font used trought the template', 1, 9999),
(31, 'template', 'template.showLogo', 'true', 'Enable logo visibility', 1, 1),
(32, 'template', 'template.showLogoSlogan', 'true', 'show logo slogan ', 1, 9999),
(33, 'template', 'template.logoSlogan', 'Something about me', 'Slogan text', 1, 9999),
(34, 'template', 'template.showBottomLogo', 'true', 'Show logo at the bottom of the page', 1, 9999),
(35, 'template', 'template.showHomebutton', 'true', 'Show the home button icom', 1, 9999),
(36, 'template', 'template.showCart', 'true', 'Show cart on the home page', 1, 9999),
(37, 'template', 'template.showCopyright', 'true', 'Show copyright text at the bottom of the page', 1, 9999),
(38, 'template', 'template.language', 'en', 'language used for this site', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TbConfigGroup`
--

CREATE TABLE IF NOT EXISTS `TbConfigGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(50) NOT NULL COMMENT 'Group name ',
  `description` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupName` (`groupName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Container to hold TbConfig groupings' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TbConfigGroup`
--

INSERT INTO `TbConfigGroup` (`id`, `groupName`, `description`) VALUES
(1, 'General Group', 'This group belongs to those configurations that have a key of "all" ');

-- --------------------------------------------------------

--
-- Table structure for table `TbContent`
--

CREATE TABLE IF NOT EXISTS `TbContent` (
  `id` varchar(200) NOT NULL COMMENT 'Controller  ActionName ID',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `content_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'is this an article or blog',
  `introtext` mediumtext NOT NULL,
  `fulltext` longtext NOT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_state` (`published`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TbContent`
--

INSERT INTO `TbContent` (`id`, `title`, `alias`, `content_type`, `introtext`, `fulltext`, `published`, `created`, `created_by`, `modified`, `modified_by`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `ordering`, `metakey`, `metadesc`, `access`, `hits`, `metadata`, `featured`, `language`) VALUES
('indexIndex', 'Administrator Components', 'administrator-components', 'article', '<p>All components also are used in the administrator area of your website. In addition to the ones listed here, there are components in the administrator that do not have direct front end displays, but do help shape your site. The most important ones for most users are</p>', '<p>All components also are used in the administrator area of your website. In addition to the ones listed here, there are components in the administrator that do not have direct front end displays, but do help shape your site. The most important ones for most users are</p>\r\n<ul>\r\n<li>Media Manager</li>\r\n<li>Extensions Manager</li>\r\n<li>Menu Manager</li>\r\n<li>Global Configuration</li>\r\n<li>Banners</li>\r\n<li>Redirect</li>\r\n</ul>\r\n<hr title="Media Manager" alt="Media Manager" class="system-pagebreak" style="color: gray; border: 1px dashed gray;" />\r\n<p> </p>\r\n<h3>Media Manager</h3>\r\n<p>The media manager component lets you upload and insert images into content throughout your site. Optionally, you can enable the flash uploader which will allow you to to upload multiple images. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Content_Media_Manager">Help</a></p>\r\n<hr title="Extensions Manager" alt="Extensions Manager" class="system-pagebreak" style="color: gray; border: 1px dashed gray;" />\r\n<h3>Extensions Manager</h3>\r\n<p>The extensions manager lets you install, update, uninstall and manage all of your extensions. The extensions manager has been extensively redesigned for Joomla! 1.6, although the core install and uninstall functionality remains the same as in Joomla 1.5. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Extensions_Extension_Manager_Install">Help</a></p>\r\n<hr title="Menu Manager" alt="Menu Manager" class="system-pagebreak" style="color: gray; border: 1px dashed gray;" />\r\n<h3>Menu Manager</h3>\r\n<p>The menu manager lets you create the menus you see displayed on your site. It also allows you to assign modules and template styles to specific menu links. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Menus_Menu_Manager">Help</a></p>\r\n<hr title="Global Configuration" alt="Global Configuration" class="system-pagebreak" style="color: gray; border: 1px dashed gray;" />\r\n<h3>Global Configuration</h3>\r\n<p>The global configuration is where the site administrator configures things such as whether search engine friendly urls are enabled, the site meta data (descriptive text used by search engines and indexers) and other functions. For many beginning users simply leaving the settings on default is a good way to begin, although when your site is ready for the public you will want to change the meta data to match its content. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Site_Global_Configuration">Help</a></p>\r\n<hr title="Banners" alt="Banners" class="system-pagebreak" style="color: gray; border: 1px dashed gray;" />\r\n<h3>Banners</h3>\r\n<p>The banners component provides a simple way to display a rotating image in a module and, if you wish to have advertising, a way to track the number of times an image is viewed and clicked. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Components_Banners_Banners_Edit">Help</a></p>\r\n<h3>\r\n<hr title="Redirect" class="system-pagebreak" />\r\n</h3>\r\n<h3><br />Redirect</h3>\r\n<p>The redirect component is used to manage broken links that produce Page Not Found (404) errors. If enabled it will allow you to redirect broken links to specific pages. It can also be used to manage migration related URL changes. <a href="http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Components_Redirect_Manager">Help</a></p>', 1, '2011-01-01 00:00:01', 42, '2011-01-10 12:57:27', 42, '2011-01-01 00:00:01', '0000-00-00 00:00:00', '', '', '{"show_title":"1","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"1","link_author":"","show_create_date":"1","show_modify_date":"1","show_publish_date":"1","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"1","show_noauth":"","alternative_readmore":"","article_layout":""}', 7, '', '', 1, 81, '{"robots":"","author":"","rights":"","xreference":""}', 0, 'en'),
('firstblogpost', 'First Blog Post', 'first-blog-post', 'blog', '<p><em>Lorem Ipsum is filler text that is commonly used by designers before the content for a new site is ready.</em></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed faucibus purus vitae diam posuere nec eleifend elit dictum. Aenean sit amet erat purus, id fermentum lorem. Integer elementum tristique lectus, non posuere quam pretium sed. Quisque scelerisque erat at urna condimentum euismod. Fusce vestibulum facilisis est, a accumsan massa aliquam in. In auctor interdum mauris a luctus. Morbi euismod tempor dapibus. Duis dapibus posuere quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In eu est nec erat sollicitudin hendrerit. Pellentesque sed turpis nunc, sit amet laoreet velit. Praesent vulputate semper nulla nec varius. Aenean aliquam, justo at blandit sodales, mauris leo viverra orci, sed sodales mauris orci vitae magna.</p>', '<p>Quisque a massa sed libero tristique suscipit. Morbi tristique molestie metus, vel vehicula nisl ultrices pretium. Sed sit amet est et sapien condimentum viverra. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus viverra tortor porta orci convallis ac cursus erat sagittis. Vivamus aliquam, purus non luctus adipiscing, orci urna imperdiet eros, sed tincidunt neque sapien et leo. Cras fermentum, dolor id tempor vestibulum, neque lectus luctus mauris, nec congue tellus arcu nec augue. Nulla quis mi arcu, in bibendum quam. Sed placerat laoreet fermentum. In varius lobortis consequat. Proin vulputate felis ac arcu lacinia adipiscing. Morbi molestie, massa id sagittis luctus, sem sapien sollicitudin quam, in vehicula quam lectus quis augue. Integer orci lectus, bibendum in fringilla sit amet, rutrum eget enim. Curabitur at libero vitae lectus gravida luctus. Nam mattis, ligula sit amet vestibulum feugiat, eros sem sodales mi, nec dignissim ante elit quis nisi. Nulla nec magna ut leo convallis sagittis ac non erat. Etiam in augue nulla, sed tristique orci. Vestibulum quis eleifend sapien.</p><p>Nam ut orci vel felis feugiat posuere ut eu lorem. In risus tellus, sodales eu eleifend sed, imperdiet id nulla. Nunc at enim lacus. Etiam dignissim, arcu quis accumsan varius, dui dui faucibus erat, in molestie mauris diam ac lacus. Sed sit amet egestas nunc. Nam sollicitudin lacinia sapien, non gravida eros convallis vitae. Integer vehicula dui a elit placerat venenatis. Nullam tincidunt ligula aliquet dui interdum feugiat. Maecenas ultricies, lacus quis facilisis vehicula, lectus diam consequat nunc, euismod eleifend metus felis eu mauris. Aliquam dapibus, ipsum a dapibus commodo, dolor arcu accumsan neque, et tempor metus arcu ut massa. Curabitur non risus vitae nisl ornare pellentesque. Pellentesque nec ipsum eu dolor sodales aliquet. Vestibulum egestas scelerisque tincidunt. Integer adipiscing ultrices erat vel rhoncus.</p><p>Integer ac lectus ligula. Nam ornare nisl id magna tincidunt ultrices. Phasellus est nisi, condimentum at sollicitudin vel, consequat eu ipsum. In venenatis ipsum in ligula tincidunt bibendum id et leo. Vivamus quis purus massa. Ut enim magna, pharetra ut condimentum malesuada, auctor ut ligula. Proin mollis, urna a aliquam rutrum, risus erat cursus odio, a convallis enim lectus ut lorem. Nullam semper egestas quam non mattis. Vestibulum venenatis aliquet arcu, consectetur pretium erat pulvinar vel. Vestibulum in aliquet arcu. Ut dolor sem, pellentesque sit amet vestibulum nec, tristique in orci. Sed lacinia metus vel purus pretium sit amet commodo neque condimentum.</p><p>Aenean laoreet aliquet ullamcorper. Nunc tincidunt luctus tellus, eu lobortis sapien tincidunt sed. Donec luctus accumsan sem, at porttitor arcu vestibulum in. Sed suscipit malesuada arcu, ac porttitor orci volutpat in. Vestibulum consectetur vulputate eros ut porttitor. Aenean dictum urna quis erat rutrum nec malesuada tellus elementum. Quisque faucibus, turpis nec consectetur vulputate, mi enim semper mi, nec porttitor libero magna ut lacus. Quisque sodales, leo ut fermentum ullamcorper, tellus augue gravida magna, eget ultricies felis dolor vitae justo. Vestibulum blandit placerat neque, imperdiet ornare ipsum malesuada sed. Quisque bibendum quam porta diam molestie luctus. Sed metus lectus, ornare eu vulputate vel, eleifend facilisis augue. Maecenas eget urna velit, ac volutpat velit. Nam id bibendum ligula. Donec pellentesque, velit eu convallis sodales, nisi dui egestas nunc, et scelerisque lectus quam ut ipsum.</p>', 1, '2011-01-01 00:00:01', 42, '2011-01-01 00:00:01', 42, '2011-01-01 00:00:01', '0000-00-00 00:00:00', '', '', '{"show_title":"1","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_readmore":"","show_print_icon":"","show_email_icon":"","show_hits":"","page_title":"","alternative_readmore":"","layout":""}', 0, '', '', 1, 28, '', 0, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `TbLanguages`
--

CREATE TABLE IF NOT EXISTS `TbLanguages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TbLanguages`
--

INSERT INTO `TbLanguages` (`lang_id`, `lang_code`, `title`, `title_native`, `sef`, `image`, `description`, `metakey`, `metadesc`, `sitename`, `published`, `ordering`) VALUES
(1, 'en-GB', 'English', 'English', 'en', 'en', '', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TbLogName`
--

CREATE TABLE IF NOT EXISTS `TbLogName` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `message` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `TbLogName`
--

INSERT INTO `TbLogName` (`id`, `priority`, `message`) VALUES
(1, 6, 'addLog called on Infosys\\Log\\Log, using params {"message":"Testing what will happen","level":0}'),
(2, 6, 'addLog called on , using params {"message":"Testing static usage what will happen","level":0}'),
(3, 6, 'addLog called on , using params {"message":"Testing static usage what will happen","level":0}'),
(4, 6, 'addLog called on , using params {"message":"Testing static usage what will happen","level":0}'),
(5, 6, 'addLog called on , using params {"message":"Testing static usage what will happen","level":0}'),
(6, 6, 'addLog called on , using params {"message":"Testing static usage what will happen","level":0}'),
(7, 6, 'addLog triggered using params {"message":"Testing static usage what will happen","level":0}'),
(8, 6, 'addLog triggered using params {"message":"Testing static usage what will happen","level":0}');

-- --------------------------------------------------------

--
-- Table structure for table `TbMessageCenter`
--

CREATE TABLE IF NOT EXISTS `TbMessageCenter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  `language` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TbSessions`
--

CREATE TABLE IF NOT EXISTS `TbSessions` (
  `id` varchar(200) CHARACTER SET utf8 NOT NULL,
  `modified` int(11) NOT NULL,
  `lifetime` int(20) DEFAULT NULL,
  `data` mediumtext CHARACTER SET utf8 NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `clientid` tinyint(3) NOT NULL,
  `guest` tinyint(4) DEFAULT NULL,
  `username` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `lifetime` (`lifetime`),
  KEY `whosonline` (`guest`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TbSessions`
--

INSERT INTO `TbSessions` (`id`, `modified`, `lifetime`, `data`, `userid`, `clientid`, `guest`, `username`) VALUES
('29gr36f5h9kqp5j64cq63j9me3', 1325316214, 1440, '{"id":"1","contactname":"David Oabile","company":"Infosyspro","condition_id":"","roleid":"6","dob":"2010-04-12","email":"doabile@infosyspro.com.au","street":"23 burr crt","suburb":"Pacific","postcode":"4521","state":"QLD","country":"Botswana","phone":"07558224562","mobile":"042154254254","fax":"","how":null,"why":null,"pref1":null,"pref2":null,"pref3":null,"join_date":"0000-00-00","username":"davido","hash":null,"role":null,"status":"1","is_wholesaler":"1","clientId":0,"guest":0}', 1, 0, 0, 'davido');

-- --------------------------------------------------------

--
-- Table structure for table `TbStickies`
--

CREATE TABLE IF NOT EXISTS `TbStickies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TbStickies`
--

INSERT INTO `TbStickies` (`id`, `title`, `content`, `ordering`, `position`, `published`, `module`, `access`, `showtitle`, `params`, `client_id`, `language`) VALUES
(1, 'Special!', '<h1>This week we have a special, half price on delicious oranges!</h1><div>Only for our special customers!</div><div>Use the code: Joomla! when ordering</div><p><em>This module can only be seen by people in the customers group or higher.</em></p>', 1, 'position-12', 1, 'mod_custom', 4, 1, '{"prepare_content":"1","layout":"","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(2, 'Login', '', 1, 'login', 1, 'mod_login', 1, 1, '', 1, '*');

-- --------------------------------------------------------

--
-- Table structure for table `TbUsergroups`
--

CREATE TABLE IF NOT EXISTS `TbUsergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_usergroup_title_lookup` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `TbUsergroups`
--

INSERT INTO `TbUsergroups` (`id`, `title`) VALUES
(1, 'Public'),
(2, 'Registered'),
(3, 'Author'),
(4, 'Editor'),
(5, 'Publisher'),
(6, 'Manager'),
(7, 'Administrator'),
(8, 'Super Users'),
(12, 'Customer Group (Example)'),
(10, 'Shop Suppliers (Example)');

-- --------------------------------------------------------

--
-- Table structure for table `TbUsers`
--

CREATE TABLE IF NOT EXISTS `TbUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `condition_id` varchar(100) DEFAULT '',
  `roleid` int(10) DEFAULT NULL,
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(100) DEFAULT NULL,
  `street` varchar(100) NOT NULL DEFAULT '',
  `suburb` varchar(50) NOT NULL DEFAULT '',
  `postcode` varchar(12) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(25) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `how` text,
  `why` text,
  `pref1` int(11) DEFAULT NULL,
  `pref2` int(11) DEFAULT NULL,
  `pref3` int(11) DEFAULT NULL,
  `join_date` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(25) DEFAULT 'none',
  `password` varchar(20) DEFAULT NULL,
  `hash` varchar(254) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `is_wholesaler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `TbUsers`
--

INSERT INTO `TbUsers` (`id`, `contactname`, `company`, `condition_id`, `roleid`, `dob`, `email`, `street`, `suburb`, `postcode`, `state`, `country`, `phone`, `mobile`, `fax`, `how`, `why`, `pref1`, `pref2`, `pref3`, `join_date`, `username`, `password`, `hash`, `role`, `status`, `is_wholesaler`) VALUES
(1, 'David Oabile', 'Infosyspro', '', 6, '2010-04-12', 'doabile@infosyspro.com.au', '23 burr crt', 'Pacific', '4521', 'QLD', 'Botswana', '07558224562', '042154254254', '', NULL, NULL, NULL, NULL, NULL, '0000-00-00', 'davido', 'dailer00', NULL, NULL, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `TbVersion`
--

CREATE TABLE IF NOT EXISTS `TbVersion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TbVersion`
--

INSERT INTO `TbVersion` (`id`, `number`) VALUES
(1, '1.0');

-- --------------------------------------------------------

--
-- Table structure for table `wholesale`
--

CREATE TABLE IF NOT EXISTS `wholesale` (
  `product` varchar(50) NOT NULL DEFAULT '',
  `pname` varchar(50) NOT NULL DEFAULT '',
  `info` varchar(50) NOT NULL DEFAULT '',
  `refNo` varchar(50) NOT NULL DEFAULT '',
  `qty` int(11) NOT NULL DEFAULT '0',
  `cdisplay` varchar(50) NOT NULL DEFAULT '',
  `tuneNo` varchar(50) NOT NULL DEFAULT '',
  `pcartons` varchar(50) NOT NULL DEFAULT '',
  `barcode` varchar(50) NOT NULL DEFAULT '',
  `wprice` varchar(20) NOT NULL DEFAULT '',
  `rprice` varchar(20) NOT NULL DEFAULT '',
  `display` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wholesale`
--

INSERT INTO `wholesale` (`product`, `pname`, `info`, `refNo`, `qty`, `cdisplay`, `tuneNo`, `pcartons`, `barcode`, `wprice`, `rprice`, `display`) VALUES
('1', 'Zazi Orange', 'Seville Oranges + gum Arabic', '1234', 200, '2 by 2', '3', '00000', '000000', '1.80', '2.00', './boughtorange'),
('2', 'Zizi Black & White', 'Sugar Free, Gluten Free, Low Carb, Low G.I. and Di', 'soon', 120, 'soon', 'soon', 'soon', 'soon', 'soon', 'soon', 'soon'),
('3', 'Zazi Strawberry', 'Sugar Free', 'soon', 240, 'soon', 'sonn', 'sonn', 'sonn', 'soon', 'soon', 'soon'),
('4', 'Zizi White & Green', 'Fresh,Strong but Delicate and Long lasting', 'soon', 20000, 'sonn', 'soon', 'soon', 'soon', '$1.80', '$2.00', 'soon'),
('5', 'Zazi Mango', 'soon', 'soon', 2415, 'sonn', 'soon', 'soon', 'soon', 'soon', 'soon', 'soon'),
('6', 'Zizi Red & White', 'soon', 'soon', 0, 'soon', 'soon', 'soon', 'soon', 'soon', 'soon', 'soon'),
('7', 'Zizi Black Currant', 'soon', 'soon', 0, 'soon', 'soon', 'soon', 'soon', 'soon', 'soon', 'soon'),
('8', 'Zazi Licorice', 'soon', 'soon', 0, 'soon', 'soon', 'soon', 'soon', 'soon', 'soon', 'soon');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
