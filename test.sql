-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 05:13 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `memberId` int(11) NOT NULL,
  `username` varchar(45) NOT NULL DEFAULT '',
  `password` char(40) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`memberId`, `username`, `password`, `name`, `email`) VALUES
(0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `itemId` int(11) NOT NULL,
  `itemName` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `price` float DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`itemId`, `itemName`, `description`, `price`, `availability`, `categoryId`) VALUES
(1, 'Twist Drill Bit', 'A twist bit is the most common type of drill bit for home use. It works for general-purpose drilling in wood, plastic and light metal.', 9.99, 1, 1),
(2, 'Brad-Point Drill Bit', 'A brad-point bit is designed for boring into wood. The brad at the center of the bit tip helps position the bit precisely for accurate drilling and produces a clean exit point in the workpiece. The flutes — grooves that wrap around the bit and channel away chips and dust — are extra-wide to remove more material.', 14.99, 1, 1),
(3, 'Auger Drill Bit', 'An auger bit, another type of wood-boring bit, has a screw tip that starts the hole and pulls the bit through the workpiece to quickly create a clean hole. These bits can be as long as 18 inches. As with the brad-point bit, large flutes help remove chips and dust. An auger bit with a hollow center provides even more chip removal, allowing for deeper boring; one with a solid center is stronger and more rigid.', 29.99, 7, 1),
(4, 'Self-Feed Drill Bit', 'A self-feed bit bores through wood. Like the auger bit, a screw at the tip helps position the bit and draws it through the work piece. However, this bit is more compact. It doesn''t have the  flutes of a twist bit, so you need to pull the bit back periodically to clear away chips and dust.', 16.99, 1, 1),
(5, 'Installer Drill Bit', 'An installer bit is a specialized twist bit designed for installing wiring, such as that for entertainment or security systems. The bit can be up to 18 inches long and drills through wood, plaster and some masonry. Once you drill through the wall, floor or other surface, you insert a wire into the small hole in the bit and use the bit to draw it back through the hole you bored. You can then attach this wire to additional wire or cable and pull it through the hole.', 17.99, 1, 1),
(6, '“Basic” Handsaw', 'Arguably the most iconic and reliable of all wood saws, it’s no doubt that this tool has changed the world. They’re also useful for reminding you that you’re out of shape when cutting a simple 2×4.', 5.99, 1, 2),
(7, 'HackSaw', 'This type of handsaw features a fine-toothed blade tensioned in a C-frame. Commonly used for cutting metals and plastics. Take special care to clean it when cutting aluminum, as it will often gum up on softer metals.', 11.99, 1, 2),
(8, 'Japanese Saws', 'A family of pull saws known for a thinner blade with crosscut teeth on one side and rip teeth on the other. These saws make cutting dense wood easy by first starting a guide path with the crosscut edge, then switching over to finish the cut with the rip-teeth edge. The Ryoba style is the most useful type.', 3.99, 1, 2),
(9, 'Coping Saw', 'Popular with artists, this simple but useful cutting tool consists of a thin blade tensioned in a C-shaped frame that uses interchangeable blades for both metal and wood. It can cut tight radius but perhaps its most useful feature is the ability to remove the blade and thread it through a drilled hole to cut inside profiles.', 7.99, 1, 2),
(10, 'フリガナ', '商品一覧ページです。オシャレで可愛いiphoneケース、スマートフォンケース、IQOSケースのオンラインショップPOWER POWERです。', 7, 7, 0),
(11, '12321321', 'お買い物ガイドページです。オシャレで可愛いiphoneケース、スマートフォンケース、IQOSケースのオンラインショップPOWER POWERです。', 4, 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`memberId`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`itemId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
