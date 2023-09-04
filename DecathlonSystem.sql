-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 02:13 PM
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
-- Database: `pullodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(255) NOT NULL,
  `AdminEmailAddress` varchar(255) NOT NULL,
  `AdminPassword` varchar(255) NOT NULL,
  `AdminName` varchar(255) NOT NULL,
  `AdminPhoneNum` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminEmailAddress`, `AdminPassword`, `AdminName`, `AdminPhoneNum`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin123', '123123123'),
(2, 'afiqazami@gmail.com', 'afiq123', 'Muhammad Afiq Azami', '01232399'),
(3, 'hafiq@gmail.com', 'hafiq123', 'Muhammad Hafiq bin Khairul Nizam', '01123232323');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(255) NOT NULL,
  `UserID` int(255) NOT NULL,
  `ProductID` int(255) NOT NULL,
  `ProductQuantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`, `ProductID`, `ProductQuantity`) VALUES
(1, 1, 0, 0),
(2, 2, 0, 0),
(3, 3, 0, 0),
(4, 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductCategory` varchar(255) NOT NULL,
  `ProductDesc` text NOT NULL,
  `ProductPrice` decimal(7,2) NOT NULL,
  `ProductQuantity` int(255) NOT NULL,
  `ProductImage` text NOT NULL,
  `ProductDateAdded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductCategory`, `ProductDesc`, `ProductPrice`, `ProductQuantity`, `ProductImage`, `ProductDateAdded`) VALUES
(1, 'DeMarini 2022 Bat', 'bats', '<p>The Half + Half technology of a silver alloy barrel paired with an ultra-stiff Paraflex™ Plus Composite Handle delivers an unrivaled blend of feel and performance.</p> <h3>Features</h3> <ul> <li>Barrel Material: Alloy</li> <li>Barrel Diameter: 2 5/8</li> <li>X14 Alloy Barrel: A massive alloy barrel designed specifically for elite power hitters.</li> </ul>', 399.95, 3, 'bat1.png', '2023-07-03 18:21:00'),
(2, 'DeMarini The Goods Bat', 'bats', '<p>With a massive X14 Alloy Barrel and additional mass near the end cap, The Goods One Piece is engineered to put your 80-grade power on full display.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Barrel Material: Alloy</li> \r\n<li>Barrel Diameter: 2 5/8</li> \r\n<li>One-Piece ConstructionAllows for maximum stiffness, ultimate bat speed, and an ultra responsive feel.</li> \r\n</ul>', 349.95, 4, 'bat2.png', '2023-07-03 18:22:06'),
(3, 'Louisville Slugger Bat', 'bats', '<p>The 2023 Select PWR (-3) BBCOR Bat from Louisville Slugger employs an elongated EXD™ Premium Alloy Barrel.</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>3FX-PWR™ Connection System.</li> \r\n<li>Robust alloy barrel with a stiff composite handle.</li> \r\n<li>heavier swing weight.</li> \r\n</ul>\r\n', 399.95, 2, 'bat3.png', '2023-07-03 18:22:40'),
(4, 'DeMarini 2021 Bat', 'bats', '<p>Crafted with a responsive Paraflex™ Plus Composite Barrel, CF (-10) allows well-rounded players to showcase their bat speed, barrel control and power.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Barrel Material: Composite</li> \r\n<li>Barrel Diameter: 2 5/8</li> \r\n<li>Paraflex™ Plus Composite Barrel: Engineered for consistent responsiveness and a huge sweet spot.</li> \r\n</ul>\r\n', 349.95, 5, 'bat4.png', '2023-07-03 18:23:17'),
(5, 'Marucci 2023 Bat', 'bats', '<p>For the first time ever, gapped wall barrel technology comes to USSSA baseball in the 2023 Louisville Slugger Meta® (-10) USSSA Bat.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>VCX2™ Connection System</li> \r\n<li>GT1 End Cap</li> \r\n</ul>\r\n', 499.95, 2, 'bat5.png', '2023-07-03 18:23:53'),
(6, 'Warstic 2022 Bat', 'bats', '<p>The ultra-balanced Paraflex™ Plus Composite Barrel delivers maximum control in the batter’s box, and the 3Fusion™ Connection\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Barrel Material: Composite</li> \r\n<li>Barrel Diameter: 2 3/4 </li> \r\n<li>Paraflex™ Plus Composite Barrel: Engineered for consistent responsiveness and a huge sweet spot</li> \r\n</ul>\r\n', 289.97, 6, 'bat6.png', '2023-07-03 18:24:20'),
(7, 'Rawlings Limited Edition Gloves', 'gloves', '<p>These gloves are built with traditional grey split welting, vegas gold stitching, tan laces, black embroidery, black ink indent, special gold lined Rawlings patch, and mustard hand sewn welt on select models. \r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Full Horween C55 including finger liners and palm liner</li> \r\n<li>Split Grey Welting Throughout </li> \r\n<li>Vegas Gold Stitching</li> \r\n</ul>\r\n\r\n', 299.95, 3, 'gloves1.png', '2023-07-03 18:35:10'),
(8, 'Rawlings 2021 Gloves', 'gloves', '<p>This infield glove\'s 200-pattern is our most popular infield pattern, due to its large pocket and extreme versatility.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Pattern: 11.5\" infield model</li> \r\n<li>Web: Single Post</li> \r\n<li>Leather: Heart of the Hide leather</li> \r\n</ul>\r\n\r\n', 299.95, 3, 'gloves2.png', '2023-07-03 18:38:11'),
(9, 'Rawlings Pro Preferred Gloves', 'gloves', '<p>The 2021 Pro Preferred 13-inch first base mitt was crafted from flawless, full-grain kip leather. This luxurious leather is known for its supple look, and unparalleled quality and feel. \r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Pattern: 13\" firstbase mitt</li> \r\n<li>Color: Camel</li> \r\n<li>Leather: Kip Leather</li> \r\n</ul>\r\n\r\n', 379.95, 5, 'gloves3.png', '2023-07-03 18:39:15'),
(10, 'Rawlings Heart of the Hide Gloves', 'gloves', '<p>Constructed from Rawlings\' world-renowned Heart of the Hide® steer hide leather, Heart of the Hide® gloves feature the game-day patterns of the top Rawlings Advisory Staff players.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Pattern: 11.75\"\" Infield/Pitcher model</li> \r\n<li>Web: Modifed Trap-Eze®</li> \r\n<li>Leather: Steerhide</li> \r\n</ul>\r\n\r\n', 299.95, 6, 'gloves4.png', '2023-07-03 18:40:02'),
(11, 'Rawlings 2021 Heart of the Hide Gloves', 'gloves', '<p>The 2021 11.75-inch Heart of the Hide infield glove offers unmatched quality and performance.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Pattern: 11.75\" infield model</li> \r\n<li>Web: Pro-I Web</li> \r\n<li>Color: Camel/Black/Columbia blue</li> \r\n</ul>\r\n\r\n', 299.95, 5, 'gloves5.png', '2023-07-03 18:40:30'),
(12, 'Rawlings Colorsync Gloves', 'gloves', '<p>These ColorSync models provide a look that in the past could only be found if you paid extra to create a custom Rawlings baseball glove.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Stiffer Feel Will Require A Break-In</li> \r\n<li>Constructed From Top Grade U.S. Steerhide</li> \r\n<li>Conventional Open Back</li> \r\n</ul>\r\n\r\n', 299.95, 3, 'gloves6.png', '2023-07-03 18:40:53'),
(13, 'Rawlings Velo Series Helmets', 'helmets', '<p>The Rawlings Velo gloss batting helmet was engineered to give you quality performance without breaking the bank.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>One-Tone clear coat paint finish</li> \r\n<li>REXT Extedner Compatible</li> \r\n<li>Detachable \"R\" logo</li> \r\n</ul>\r\n\r\n', 35.95, 8, 'helm1.png', '2023-07-03 18:41:22'),
(14, 'Easton Alpha Solid Helmets', 'helmets', '<p>BioDri™ fabric liner absorbs moisture for improved dryness and added comfort.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>ABS thermoplastic shell engineered for maximum protection</li> \r\n<li>BioDri™ fabric liner absorbs moisture</li> \r\n<li>Dual-density foam liner for shock absorption and comfort</li> \r\n</ul>\r\n\r\n', 22.88, 9, 'helm2.png', '2023-07-03 18:42:11'),
(15, 'Easton Z5 2.0 Solid Matte Helmets', 'helmets', '<p>The high impact resistant ABS shell has been engineered for maximum protection, while the padded dual-density foam liner works to absorb shock on impact.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>High impact resistant ABS providing an excellent protective shell</li> \r\n<li>Wrapped Ear Pads are highly durable </li> \r\n<li>NOCSAE Approved</li> \r\n</ul>\r\n\r\n', 43.95, 4, 'helm3.png', '2023-07-03 18:42:57'),
(16, 'Rawlings R16 Series Matte Helmets', 'helmets', '<p>The R16 has been constructed with 16 individual vents for optimal air flow and circulation allowing its wearer to stay cool and dry.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Meets NOCSAE® standard.</li> \r\n<li>16 vent design featuring exclusive COOLFLO® XV1™ style venting.</li> \r\n<li>Heat Exchange™ vents rapidly circulate cooler, ambient air.</li> \r\n</ul>\r\n\r\n', 42.95, 4, 'helm4.png', '2023-07-03 18:43:50'),
(17, 'Champro HX Gamer Helmets', 'helmets', '<p>Champro Hx Gamer Batting Helmet</p> \r\n<h3>Features</h3><ul> <li>LIGHTWEIGHT DUAL DENSITY PADDING</li> <li>Available in two premium finishes</li> <li>ANTI-MICROBIAL TREATED FOAM AND FABRIC</li> </ul>\r\n\r\n', 31.95, 6, 'helm5.png', '2023-07-03 18:44:19'),
(18, 'Easton PRO X Matte Helmets', 'helmets', '<p>All new Multi-Density Protection (MDP) technology, with 3 layers of energy absorbing foam, help address various speeds of impact players encounter in game situations. \r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>MDP Multi-Density Protection with 3 layers of impact absorbing density foam</li> \r\n<li>Matte finish with tonal metallic accents</li> \r\n<li>Extended Jaw Guard mounted to PRO X helmet</li> \r\n</ul>\r\n', 79.95, 3, 'helm6.png', '2023-07-03 18:44:55'),
(19, 'DeMarini 2023 Voodoo Bat', 'bats', '<p>Worth its weight in gold, the 2023 Voodoo® One (-3) BBCOR Baseball Bat from DeMarini delivers the unparalleled pop players expect from its easy-swinging one-piece construction.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>X14 Alloy Barrel</li> \r\n<li>Refined Tracer End Cap</li> \r\n<li>Reinforced Knob for a stiff feel</li> \r\n</ul>\r\n\r\n', 349.95, 6, 'bat7.png', '2023-07-04 08:43:38'),
(20, 'DeMarini ZOA -10 Bat', 'bats', '<p>Introducing the 2022 DeMarini Zoa (-10) USSSA Baseball Bat, a bold addition to the composite USSSA lineup.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Barrel Material: Composite</li> \r\n<li>Barrel Diameter: 2 3/4</li> \r\n<li>Anomaly End Cap: A blend of durable and lightweight materials maintains barrel integrity and optimizes performance.</li> \r\n</ul>\r\n\r\n', 299.95, 5, 'bat8.png', '2023-07-04 08:44:37'),
(21, 'Akadema Rookie Series Gloves', 'gloves', '<p>Hand-crafted for a quick and easy break-in period, making the glove more manageable for today’s younger ballplayer.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Pattern: 11.5\" Youth Utility model</li> \r\n<li>Features: Deep pocket</li> \r\n<li>Web: B-Hive web</li> \r\n</ul>\r\n\r\n\r\n', 71.95, 3, 'gloves7.png', '2023-07-04 08:47:58'),
(22, 'Rawlings Rev1x Gloves', 'gloves', '<p>Constructed from the highest quality materials, the 2022 REV1X 11.75-inch infield glove features new innovative technology that will take your game to the next level.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Back:  Adaptive Fit Hand Opening</li> \r\n<li>Lining: Heart of the Hide Leather Palm & Lining</li> \r\n<li>Shell: Engineered Multi-Layer Molded 3D Back</li> \r\n</ul>\r\n\r\n', 399.95, 2, 'gloves8.png', '2023-07-04 08:48:57'),
(23, 'All-Star Youth System 7 Helmets', 'helmets', '<p>Designed for protection, strength, and comfort, the System Seven® BH3010 helmets feature a smaller shell scaled to properly fit the proportions of smaller head shapes\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>The shell is constructed with high impact resistant ABS plastic.</li> \r\n<li>large vent ports placed throughout the helmet</li> \r\n<li>Chin strap snap is removable.\r\n</li> \r\n</ul>\r\n\r\n', 32.97, 9, 'helm7.png', '2023-07-04 08:51:01'),
(24, 'All-Star Adult System 7 Matte Helmets', 'helmets', '<p>Designed for protection, strength, and comfort, the System Seven™ one size fits all batting helmets are recommended for youth through college level play.\r\n</p> \r\n<h3>Features</h3>\r\n<ul> \r\n<li>Ultra-Cool™ (OSFA) liner system</li> \r\n<li>AEGIS Microbe Shield™</li> \r\n<li>Chin strap snap is removable.</li> \r\n</ul>\r\n\r\n ', 34.97, 6, 'helm8.png', '2023-07-04 08:52:39'),
(26, 'DonGak Gloves', 'gloves', '', 300.00, 50, 'gloves9.png', '2023-07-05 12:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(255) NOT NULL,
  `UserEmailAddress` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserFirstName` varchar(255) NOT NULL,
  `UserLastName` varchar(255) NOT NULL,
  `UserBirthDate` date NOT NULL,
  `UserPhoneNum` varchar(255) NOT NULL,
  `UserGender` varchar(255) NOT NULL,
  `UserAddress` varchar(255) NOT NULL,
  `CartID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserEmailAddress`, `UserPassword`, `UserFirstName`, `UserLastName`, `UserBirthDate`, `UserPhoneNum`, `UserGender`, `UserAddress`, `CartID`) VALUES
(1, 'user@gmail.com', 'user', 'user', '1', '2023-07-08', '01239582923', 'male', 'uitm segamat', 1),
(2, 'khairi@gmail.com', 'khairi', 'Muhamad', 'Khairi', '2023-07-08', '0123123123', 'male', 'Taman Harmoni Jaya', 2),
(3, 'kero@gmail.com', 'kero', 'Kero', 'kero', '2023-07-08', '0123231923', 'male', 'hehe', 3),
(4, 'kero@gmail.com', '1', 'kero', 'kero', '2023-07-10', '012321323', 'male', 'uitm segamat', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `cart_ibfk_1` (`ProductID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `CartID` (`CartID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
