-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 09, 2023 at 10:30 AM
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
-- Database: `final_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `marathon`
--

CREATE TABLE `marathon` (
  `MarathonID` int(11) NOT NULL,
  `RaceName` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marathon`
--

INSERT INTO `marathon` (`MarathonID`, `RaceName`, `Date`) VALUES
(123, 'Hanoi Marathon', '2023-08-12'),
(1234, 'TienToan', '2023-10-20'),
(124214, 'Hanoi Marathon1', '2023-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `BestRecord` time DEFAULT NULL,
  `Nationality` varchar(100) DEFAULT NULL,
  `PassportNO` varchar(50) DEFAULT NULL,
  `Sex` enum('Male','Female','Other') DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`UserID`, `Name`, `BestRecord`, `Nationality`, `PassportNO`, `Sex`, `Age`, `Email`, `Phone`, `Address`) VALUES
(5, 'Nam', '12:20:20', '123', '213213', 'Male', 18, 'lenam20092003@gmail.com', '0866030920', '1');

-- --------------------------------------------------------

--
-- Table structure for table `participate`
--

CREATE TABLE `participate` (
  `MarathonID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `EntryNO` int(11) NOT NULL,
  `Hotel` varchar(255) DEFAULT NULL,
  `TimeRecord` time DEFAULT NULL,
  `Standings` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participate`
--

INSERT INTO `participate` (`MarathonID`, `UserID`, `EntryNO`, `Hotel`, `TimeRecord`, `Standings`) VALUES
(123, 5, 1, NULL, NULL, NULL),
(124214, 5, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Is_Admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `Is_Admin`) VALUES
(5, '123', '$2y$10$1/fdGHqPprJE18DSDSROv.E2LCHh5XkCTPiYw.nnju9T2epeVHD4C', 0),
(6, 'admin', '$2y$10$zUKIa075vmUAV030NiE1I.J5gC69NbYSGgswqYllt8XKUQK/9ZTxi', 1),
(7, 'admin1', '$2y$10$oiT/T1TscP8d0/yN6QYlmOP8RqHPwonIdwZsj2XhwFNq..yviSe5S', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marathon`
--
ALTER TABLE `marathon`
  ADD PRIMARY KEY (`MarathonID`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `participate`
--
ALTER TABLE `participate`
  ADD PRIMARY KEY (`MarathonID`,`UserID`,`EntryNO`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marathon`
--
ALTER TABLE `marathon`
  MODIFY `MarathonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124215;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `participate`
--
ALTER TABLE `participate`
  ADD CONSTRAINT `participate_ibfk_1` FOREIGN KEY (`MarathonID`) REFERENCES `marathon` (`MarathonID`),
  ADD CONSTRAINT `participate_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `participant` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
