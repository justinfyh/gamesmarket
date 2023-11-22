-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 26, 2020 at 09:22 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamesmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

DROP TABLE IF EXISTS `developers`;
CREATE TABLE IF NOT EXISTS `developers` (
  `developerid` int(10) NOT NULL AUTO_INCREMENT,
  `developername` varchar(100) NOT NULL,
  PRIMARY KEY (`developerid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`developerid`, `developername`) VALUES
(1, 'CD Projekt RED'),
(2, 'Rockstar Games'),
(3, 'Guerrilla'),
(4, 'Ubisoft'),
(5, 'FromSoftware'),
(6, 'Quantic Dream'),
(7, 'CAPCOM Co., Ltd.'),
(10, 'Naughty Dog'),
(11, 'Kojima Productions');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `genreid` int(10) NOT NULL AUTO_INCREMENT,
  `genrename` varchar(100) NOT NULL,
  PRIMARY KEY (`genreid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genreid`, `genrename`) VALUES
(1, 'Open World'),
(2, 'Shooter'),
(3, 'Adventure'),
(4, 'RPG'),
(5, 'Stealth'),
(6, 'Simulation'),
(7, 'Historical'),
(8, 'Futuristic'),
(9, 'Apocalyptic'),
(12, 'Story Rich');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(10) NOT NULL,
  `productid` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`orderid`,`productid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `productid`, `userid`, `quantity`) VALUES
(160, 23, 5, 5),
(156, 22, 10, 3),
(156, 17, 10, 2),
(157, 11, 10, 1),
(157, 12, 10, 2),
(158, 18, 10, 2),
(159, 22, 10, 1),
(159, 1, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `productdev`
--

DROP TABLE IF EXISTS `productdev`;
CREATE TABLE IF NOT EXISTS `productdev` (
  `productid` int(10) NOT NULL,
  `developerid` int(10) NOT NULL,
  PRIMARY KEY (`productid`,`developerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productdev`
--

INSERT INTO `productdev` (`productid`, `developerid`) VALUES
(1, 1),
(2, 2),
(9, 6),
(11, 4),
(12, 4),
(17, 3),
(18, 5),
(20, 10),
(21, 10),
(22, 11),
(23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `productgenre`
--

DROP TABLE IF EXISTS `productgenre`;
CREATE TABLE IF NOT EXISTS `productgenre` (
  `productid` int(10) NOT NULL,
  `genreid` int(10) NOT NULL,
  PRIMARY KEY (`productid`,`genreid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productgenre`
--

INSERT INTO `productgenre` (`productid`, `genreid`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 12),
(2, 2),
(2, 4),
(2, 12),
(9, 4),
(9, 6),
(9, 8),
(9, 12),
(11, 1),
(11, 3),
(11, 4),
(11, 5),
(11, 7),
(12, 1),
(12, 3),
(12, 4),
(12, 7),
(17, 1),
(17, 3),
(17, 4),
(17, 8),
(18, 4),
(18, 5),
(18, 7),
(20, 5),
(20, 9),
(20, 12),
(21, 9),
(21, 12),
(22, 1),
(22, 3),
(22, 6),
(22, 9),
(22, 12),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 8),
(23, 12);

-- --------------------------------------------------------

--
-- Table structure for table `productpub`
--

DROP TABLE IF EXISTS `productpub`;
CREATE TABLE IF NOT EXISTS `productpub` (
  `productid` int(10) NOT NULL,
  `publisherid` int(10) NOT NULL,
  PRIMARY KEY (`productid`,`publisherid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productpub`
--

INSERT INTO `productpub` (`productid`, `publisherid`) VALUES
(1, 1),
(2, 3),
(9, 6),
(11, 5),
(12, 5),
(17, 2),
(18, 4),
(20, 9),
(21, 9),
(22, 10),
(23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `releasedate` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `onsale` tinyint(1) NOT NULL DEFAULT 0,
  `videolink` varchar(50) DEFAULT NULL,
  `discountedprice` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productid`, `title`, `code`, `releasedate`, `description`, `price`, `image`, `onsale`, `videolink`, `discountedprice`) VALUES
(1, 'Witcher 3: The Wild Hunt', 'WITCHER3', '19 May 2015', 'As war rages on throughout the Northern Realms, you take on the greatest contract of your life â€” tracking down the Child of Prophecy, a living weapon that can alter the shape of the world.', '67.99', 'productimages/witcher3.jpg', 1, 'XHrskkHf958', '32.99'),
(2, 'Red Dead Redemption 2', 'RDR2', '26 October 2018', 'Red Dead Redemption 2 is a 2018 action-adventure game developed and published by Rockstar Games. The game is the third entry in the Red Dead series and is a prequel to the 2010 game Red Dead Redemption', '99.99', 'productimages/reddeadredemption2.jpg', 0, 'iqaipBpnVRE', '0.00'),
(9, 'Detroit: Become Human', 'DETROITBH', '24 April 2018', 'Detroit: Become Human puts the destiny of both mankind and androids in your hands, taking you to a near future where machines have become more intelligent than humans. Every choice you make affects the outcome of the game, with one of the most intricately branching narratives ever created.', '59.99', 'productimages/detroitbecomehuman.jpg', 0, '8a-EObAhYrg', '0.00'),
(12, 'Assassin\'s Creed: Origins', 'ACORIGINS', '27 October 2017', 'Ancient Egypt, a land of majesty and intrigue, is disappearing in a ruthless fight for power. Unveil dark secrets and forgotten myths as you go back to the one founding moment: The Origins of the Assassinâ€™s Brotherhood.', '99.99', 'productimages/acorigins.jpg', 1, 'cUuKIpCM2o0', '50.00'),
(11, 'Assassin\'s Creed Odyssey', 'ACODYSSEY', '02 October 2018', 'From outcast to living legend, embark on an odyssey to uncover the secrets of your past and change the fate of Ancient Greece. This ancient world features idyllic shores, volcanic mountain ranges, crystal-clear lakes, and arid deserts â€“ an entire world full of breath-taking views and unexpected adventures. Explore an entire country full of untamed environments and cities at the peak of Greece\'s Golden Age.\r\n', '99.99', 'productimages/acodyssey.jpg', 0, 's_SJZSAtLBA', '0.00'),
(17, 'Horizon Zero Dawnâ„¢ Complete Edition', 'HORIZONZERODAWN', '28 February 2017', 'Experience Aloyâ€™s legendary quest to unravel the mysteries of a future Earth ruled by Machines. Use devastating tactical attacks against your prey and explore a majestic open world in this award-winning action RPG!', '61.99', 'productimages/horizonzerodawn.jpg', 1, 'wzx96gYA8ek', '20.00'),
(18, 'Sekiroâ„¢: Shadows Die Twice', 'SEKIRO', '22 March 2019', 'Explore late 1500s Sengoku Japan, a brutal period of constant life and death conflict, as you come face to face with larger than life foes in a dark and twisted world. Unleash an arsenal of deadly prosthetic tools and powerful ninja abilities while you blend stealth, vertical traversal, and visceral head to head combat in a bloody confrontation.', '99.95', 'productimages/sekiro.jpg', 1, 'rXMX4YJ7Lks', '80.00'),
(20, 'Resident Evil 2', 'RE2', '25 January 2019', 'A deadly virus engulfs the residents of Raccoon City in September of 1998, plunging the city into chaos as flesh eating zombies roam the streets for survivors. An unparalleled adrenaline rush, gripping storyline, and unimaginable horrors await you. Witness the return of Resident Evil 2.', '69.95', 'productimages/re2.jpg', 0, 'u3wS-Q2KBpk', '0.00'),
(22, 'Death Stranding', 'DEATHSTRANDING', '15 July 2020', 'From legendary game creator Hideo Kojima comes an all-new, genre-defying experience. Sam Bridges must brave a world utterly transformed by the Death Stranding. Carrying the disconnected remnants of our future in his hands, he embarks on a journey to reconnect the shattered world one step at a time.\r\n', '119.95', 'productimages/deathstranding.jpg', 0, 'tCI396HyhbQ', '0.00'),
(21, 'The Last Of Us Remastered', 'TLOU', '30 July 2014', 'Set in the post-apocalyptic United States, the game tells the story of survivors Joel and Ellie as they work together to survive their westward journey across what remains of the country to find a possible cure for the modern fungal plague that has nearly decimated the entire human race.', '34.95', 'productimages/tlou.jpg', 0, 'W01L70IGBgE', '0.00'),
(23, 'Cyberpunk 2077', 'CYBERPUNK2077', '19 November 2020', 'Cyberpunk 2077 is an open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification. You play as V, a mercenary outlaw going after a one-of-a-kind implant that is the key to immortality.', '99.99', 'productimages/cyberpunk2077.jpg', 0, 'ixl31324UxE', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

DROP TABLE IF EXISTS `publishers`;
CREATE TABLE IF NOT EXISTS `publishers` (
  `publisherid` int(10) NOT NULL AUTO_INCREMENT,
  `publishername` varchar(100) NOT NULL,
  PRIMARY KEY (`publisherid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisherid`, `publishername`) VALUES
(1, 'CD Projekt RED'),
(2, 'Playstation Mobile, Inc'),
(3, 'Rockstar Games'),
(4, 'Activision'),
(5, 'Ubisoft'),
(6, 'Quantic Dream'),
(7, 'CAPCOM Co., Ltd.'),
(9, 'Sony Interactive Entertainment'),
(10, '505 Games');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleid` int(10) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(100) NOT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleid`, `rolename`) VALUES
(1, 'administrator'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

DROP TABLE IF EXISTS `userroles`;
CREATE TABLE IF NOT EXISTS `userroles` (
  `roleid` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`roleid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`roleid`, `userid`) VALUES
(1, 5),
(1, 10),
(1, 25),
(1, 27),
(2, 2),
(2, 5),
(2, 9),
(2, 10),
(2, 25),
(2, 26),
(2, 27);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `streetadd` varchar(50) DEFAULT NULL,
  `suburb` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `firstname`, `lastname`, `streetadd`, `suburb`, `city`, `postcode`, `email`, `password`, `status`) VALUES
(2, 'user', 'user', 'user', 'User Street', '', '', '6543', 'user', '$2y$10$RU68FUXNOKMD2BHIu4gBHOOfZ2m8tafD6hPrQ7A5Cl2BCQgiIrNgu', 1),
(5, 'billgates56', 'Bill', 'Gates', '7400 Northeast 18th Street', 'Medina', 'Washington', '1835', 'billgates@microsoft.com', '$2y$10$UyxCgkM2d/pWargm2GVSjeWZmkyuZqj3togbm37nXuEjzmeDhAGWm', 1),
(9, 'ceoamazon', 'Jeff', 'Bezos', 'Street Road', '', '', '196', 'jeff@amazon.com', '$2y$10$R65aGjoguqEthll55qH4HuQBaPd2Ulc072MavCg5ia9aHwXkWrssG', 0),
(10, 'ezioauditore', 'Ezio', 'Auditore', 'House of Auditore', 'Florence', 'Republic of Florence', '7777', 'syndicategamesinfo@gmail.com', '$2y$10$fGNAJWBg4cmc8P0xf2zy8eg63Ym4Gsnd7WqCS4ykhG5N/vgM9Y7c.', 1),
(25, 'administrator', 'admin', 'admin', 'Admin Crescent', '', 'Silicon Valley', '2342', 'admin@site.com', '$2y$10$YVkRSkOMJJvlkM0mG0vkVO5bflvSJ7nQ6AQ/Wn2IiZDk6NX8KFimK', 1),
(26, 'turing', 'Alan', 'Turing', 'Maida Vale', '', 'London', '0110', '011010@gmail.com', '$2y$10$QzJoY1QbKFNzg4cBUfi.1eB9j1bjFlsehDv.OfbLu.yGjPZqlwMEq', 1),
(27, 'justin', 'Justin', 'Huang', 'Rathgar Road', 'Henderson', 'Auckland', '0610', 'effectjustin@gmail.com', '$2y$10$k20mMSjXSFSoMobng9CtgOpGu3eB8WWfpXgNF81K78Pg6FqOFgaKy', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
