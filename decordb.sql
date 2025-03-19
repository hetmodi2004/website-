-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 01:06 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `decordb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_number` varchar(11) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'Pending',
  `event_date` date NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`package_id`, `customer_name`, `customer_email`, `customer_number`, `status`, `event_date`, `package_name`, `payment_method`, `payment_status`) VALUES
(1, 'Het modi ', 'hetmodi206@gmail.com', '6351709559', 'Rejected', '2025-03-17', 'DJ party', 'Cash on Delivery', 'Cash on Delivery selected. Payment will be collected on delivery.'),
(2, 'Het modi ', 'hetmodi206@gmail.com', '6351709559', 'Pending', '2025-03-26', 'wedding decoration ', 'Cash on Delivery', 'Cash on Delivery selected. Payment will be collected on delivery.'),
(3, 'dhruvil patel ', 'dhruvil.per07@gmail.com', '9033821800', 'Completed', '2025-03-18', 'wedding decoration ', 'Cash on Delivery', 'Cash on Delivery selected. Payment will be collected on delivery.');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `title` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`title`, `event_date`, `description`) VALUES
('dj party ', '2025-05-30', 'The best thing about being a DJ is making people happy. .'),
('kitty party ', '2025-06-24', 'It''s time to unwind from the daily grind. You''re cordially invited to our Kitty Party loaded with fun, laughter, and amazing food!'),
('magic show decoration ', '2025-07-25', 'It''s still magic even if you know how it''s done.â€ '),
('government function decoration', '2025-09-26', '&quot;That government is best which governs least.&quot; &quot;The people cannot delegate to government the power to do anything which would be unlawful for them to do themselves.&quot; &quot;Power tends to corrupt, and absolute power corrupts absolutely.â€');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `booking_id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `booking_id`, `username`, `feedback`, `rating`) VALUES
(1, 1, 'Het modi', 'excellent service provided by H M decoration', 5),
(3, 3, 'dhruvil patel', 'good service', 5);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `package_name` varchar(200) NOT NULL,
  `package_price` varchar(200) NOT NULL,
  `package_description` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_name`, `package_price`, `package_description`, `id`, `package_image`) VALUES
('wedding decoration ', '20000', 'Elegance meets romance. â¤ï¸ \r\nLove is in the details. âœ¨  ', 1, 'uploads/download.jpeg'),
('Birthday decoration ', '5000', 'Cake, candles, and lots of smiles!\r\n\r\nAnother 365 days of adventures await!', 2, 'uploads/birthday.jpeg'),
('baby shower', '12000', 'The littlest feet make the biggest footprints in our hearts. ...\r\n\r\nAcknowledge how lucky, as parents, you are. ...', 3, 'uploads/download (2).jpeg'),
('haldi decoration ', '6000', '"Glowing and growing in love ."\r\n"A golden glow for the big day ahead!"', 4, 'uploads/haldi.jpg'),
('DJ party', '4000', 'Then I just moved into being a DJ when that turned into the hottest thing. ', 5, 'uploads/party.jpeg'),
('ganesh decoration ', '7000', 'Just as the sweet modak fills our taste buds with joy, may Lord Ganesha''s blessings fill our lives with happiness and peace', 6, 'uploads/ganesh.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `otp` int(6) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `email`, `password`, `otp`) VALUES
(1, 'het modi', 'hetmodi206@gmail.com', 'het2004', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
