-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 17, 2020 at 05:05 AM
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
(100, 1, 1, 0),
(101, 2, 5, 0),
(101, 17, 5, 0),
(102, 12, 5, 0),
(102, 17, 5, 0),
(103, 18, 3, 0),
(103, 20, 3, 0),
(104, 9, 3, 0),
(105, 2, 5, 0),
(105, 17, 5, 0),
(106, 12, 5, 0),
(107, 1, 5, 0),
(108, 12, 5, 0),
(109, 18, 5, 0),
(110, 18, 5, 0),
(111, 17, 5, 0),
(112, 17, 10, 0),
(113, 17, 10, 0),
(114, 12, 10, 0),
(115, 12, 10, 0),
(116, 12, 10, 0),
(117, 12, 10, 0),
(118, 17, 10, 0),
(119, 17, 10, 0),
(120, 17, 10, 0),
(121, 17, 10, 0),
(122, 17, 10, 0),
(123, 17, 10, 0),
(124, 17, 10, 0),
(125, 17, 10, 0),
(126, 17, 10, 0),
(127, 1, 10, 0),
(128, 12, 10, 0),
(129, 18, 10, 0),
(130, 18, 10, 0),
(131, 18, 10, 0),
(132, 18, 10, 0),
(133, 12, 10, 0),
(134, 12, 10, 0),
(135, 12, 10, 0),
(136, 12, 10, 0),
(137, 12, 10, 0),
(138, 12, 10, 0),
(139, 12, 10, 0),
(140, 12, 10, 0),
(141, 18, 10, 0),
(142, 1, 10, 0),
(142, 18, 10, 0),
(143, 17, 10, 0),
(143, 12, 10, 0),
(144, 17, 10, 0),
(144, 12, 10, 0),
(145, 17, 10, 0),
(146, 18, 10, 0),
(146, 20, 10, 0),
(147, 11, 5, 0),
(148, 17, 10, 0),
(149, 18, 10, 0),
(150, 12, 10, 0),
(151, 12, 10, 0),
(152, 22, 5, 0),
(153, 12, 10, 0),
(154, 17, 10, 0),
(155, 22, 10, 0),
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
(16, 2),
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
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(17, 3),
(17, 4),
(17, 8),
(18, 4),
(18, 5),
(18, 7),
(19, 1),
(19, 2),
(19, 3),
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
(4, 1),
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
(1, 'The Witcher 3: Wild Hunt', 'WITCHER3', '19 May 2015', 'As war rages on throughout the Northern Realms, you take on the greatest contract of your life â€” tracking down the Child of Prophecy, a living weapon that can alter the shape of the world.', '67.99', 'productimages/witcher3.jpg', 1, 'XHrskkHf958', '31.99'),
(2, 'Red Dead Redemption 2', 'RDR2', '26 October 2018', 'Red Dead Redemption 2 is a 2018 action-adventure game developed and published by Rockstar Games. The game is the third entry in the Red Dead series and is a prequel to the 2010 game Red Dead Redemption', '99.99', 'productimages/reddeadredemption2.png', 0, 'iqaipBpnVRE', '0.00'),
(9, 'Detroit: Become Human', 'DETROITBH', '24 April 2018', 'Detroit: Become Human puts the destiny of both mankind and androids in your hands, taking you to a near future where machines have become more intelligent than humans. Every choice you make affects the outcome of the game, with one of the most intricately branching narratives ever created.', '59.99', 'productimages/detroitbecomehuman.jpg', 0, '8a-EObAhYrg', '0.00'),
(12, 'Assassin\'s Creed: Origins', 'ACORIGINS', '27 October 2017', 'Ancient Egypt, a land of majesty and intrigue, is disappearing in a ruthless fight for power. Unveil dark secrets and forgotten myths as you go back to the one founding moment: The Origins of the Assassinâ€™s Brotherhood.', '99.99', 'productimages/acorigins.jpg', 1, 'cUuKIpCM2o0', '50.00'),
(11, 'Assassin\'s Creed Odyssey', 'ACODYSSEY', '02 October 2018', 'From outcast to living legend, embark on an odyssey to uncover the secrets of your past and change the fate of Ancient Greece.This ancient world features idyllic shores, volcanic mountain ranges, crystal-clear lakes, and arid deserts â€“ an entire world full of breathtaking views and unexpected adventures. Explore an entire country full of untamed environments and cities at the peak of Greece\'s Golden Age.\r\n', '99.99', 'productimages/acodyssey.jpg', 0, 's_SJZSAtLBA', '0.00'),
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
(1, 1),
(1, 3),
(1, 5),
(1, 10),
(2, 1),
(2, 3),
(2, 5),
(2, 9),
(2, 10),
(2, 11),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20);

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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `firstname`, `lastname`, `streetadd`, `suburb`, `city`, `postcode`, `email`, `password`, `status`) VALUES
(2, 'user', 'user', 'user', '', '', '', '', 'user', 'user', 1),
(3, 'teslaceo', 'Elon', 'Musk', '31 Silicon Ave', 'Palo Alto', 'California', '8535', 'elonmusk@spacex.com', '$2y$10$3.axUvFfn11sJ7yS.Jf3ce8RA8KEguv.BiFbSFVBK3Yi7NQSerSga', 1),
(7, 'test', 'test', 'test', 'test', 'test', 'test', '44324', 'test@gmail.com', '$2y$10$LtRo.nZrhLst0mEnL.YVfuIx/HpAPbu1ewMIOxAH.Z4uibw4k2FdG', 1),
(5, 'billgates56', 'Bill', 'Gates', '7400 Northeast 18th Street', 'Medina', 'Washington', '1835', 'billgates@microsoft.com', '$2y$10$UyxCgkM2d/pWargm2GVSjeWZmkyuZqj3togbm37nXuEjzmeDhAGWm', 1),
(8, 'daw', 'dwa', 'dwa', 'dawdwa', 'dwadwa', 'dwadwa', '2341', 'dwa@dwa', '$2y$10$VEXhrhyyg1diaBREvb9tduM/HXGbbf9ncQhfvMGls2g5.VQWkqbU.', 1),
(9, 'ceoamazon', 'Jeff', 'Bezos', 'Street Road', '', '', '196', 'jeff@amazon.com', '$2y$10$R65aGjoguqEthll55qH4HuQBaPd2Ulc072MavCg5ia9aHwXkWrssG', 0),
(10, 'ezioauditore', 'Ezio', 'Auditore', 'Rome', '', '', '7777', 'syndicategamesinfo@gmail.com', '$2y$10$fGNAJWBg4cmc8P0xf2zy8eg63Ym4Gsnd7WqCS4ykhG5N/vgM9Y7c.', 1),
(11, 'test2', 'test2', 'test2', 'test2', '', '', '232', 'test2@mail.com', '$2y$10$WfSeui1eBQMnCL3Ro8mlg.KDXXhbGC8HPtLCAlYfnU/hcpXDzRsji', 1),
(12, 'ezioauditore', 'fapn', 'npifaew', 'fan', '', '', '4332', 'pnifae@fe', '$2y$10$nU8vgdKDcXEhNYsO0SecTeIdD0XegytRJSKrEubm8AnyJBGGTNXdC', 1),
(13, 'ezioauditore', 'fae', 'fea', 'fea', '', '', '43', 'fea@fae', '$2y$10$FmcpvCmbwcEkrghF2/giJODsNe9t1QyhJL6MYxnMEFSJTCVHFs.WW', 1),
(14, 'ezioauditoreff', 'feaon', 'feafae', 'fae', '', '', '342', 'feaa@fae', '$2y$10$0dpWBy8WfB/B8zfiF861jOPdNAhrcZfYWQF1DWvWxLFg7/3ni1OzW', 1),
(15, 'dawd', 'faw', 'faw', 'faw', '', '', '34', 'faw@fea', '$2y$10$3SheA2tSQTyeWg10KQqTceJ7snMqUWLIhyUeB1U1Qnr4NowTYa5ku', 1),
(16, 'ggewqa', 'geagea', 'geagea', 'geagea', '', '', '5423', 'geage@gea', '$2y$10$w6IdjJdcdxsErprEsjyM2OfdLiS4yA6pdcItGkuN/Eqzgq89Ps2uC', 1),
(17, 'gsfse', 'fes', 'fes', 'fes', '', '', '534', 'es@fes', '$2y$10$5I7oE33MPO.qUY.L.Ivp6e30UF.Jx2fhZ14I9dREm1FXgECtcZ2Ei', 1),
(18, 'cs', 'vdz', 'vdz', 'vsz', '', '', '435', 'dvz@fads', '$2y$10$I.3nnoaXSFlNfE7YZV5WneXNBLo6knVxtJoGaZjv7V70Z45P2FQtW', 1),
(19, 'test3', 'test3', 'test3', 'test3', '', '', '543', 'test3@test3', '$2y$10$GDl4b/0E/VinF4fxxqKxNue1xmEFHVlpSxgsRk0h2ixg.6wMesII2', 1),
(20, 'ggse', 'grd', 'gdr', 'ges', '', '', '25345', 'grd@fea', '$2y$10$xDlrKDo9Mzt45O5N2YKZReeXZKD4bs6fmn/znni8sI3KA5L8DA5Iy', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
