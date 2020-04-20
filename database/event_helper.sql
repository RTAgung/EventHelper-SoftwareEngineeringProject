-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2020 at 03:47 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_helper`
--

-- --------------------------------------------------------

--
-- Table structure for table `committees`
--

CREATE TABLE `committees` (
  `Id` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `committees`
--

INSERT INTO `committees` (`Id`, `Email`, `EventId`, `Status`) VALUES
(5, 'ramatriagung91@gmail.com', 5, 'accepted'),
(6, 'zahra123@gmail.com', 5, 'accepted'),
(11, 'zahra234@gmail.com', 5, 'rejected'),
(16, 'zahra345@gmail.com', 5, 'accepted'),
(17, 'ramatriagung89@gmail.com', 5, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `departements`
--

CREATE TABLE `departements` (
  `Id` char(4) NOT NULL,
  `Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departements`
--

INSERT INTO `departements` (`Id`, `Name`) VALUES
('ACAR', 'Acara'),
('BEND', 'Bendahara'),
('DOKU', 'Dokumentasi'),
('HUMA', 'Humas'),
('KEAM', 'Keamanan'),
('KEPA', 'Ketua Panitia'),
('KESE', 'Kesehatan'),
('LAPA', 'Lapangan'),
('PERK', 'Perlengkapan'),
('SEKR', 'Sekretaris');

-- --------------------------------------------------------

--
-- Table structure for table `detail_committees`
--

CREATE TABLE `detail_committees` (
  `CommitteeId` int(11) NOT NULL,
  `DepartementId` char(4) NOT NULL,
  `Job` text NOT NULL,
  `Role` varchar(10) NOT NULL,
  `HireDate` date NOT NULL,
  `Sertificate` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_committees`
--

INSERT INTO `detail_committees` (`CommitteeId`, `DepartementId`, `Job`, `Role`, `HireDate`, `Sertificate`) VALUES
(5, 'KEPA', '', 'creator', '2020-04-18', 'document/committees/5-Seminar Tech Talk 5-ramatriagung91@gmail.com.pdf'),
(6, 'SEKR', '', 'head', '2020-04-18', ''),
(11, 'HUMA', '', 'head', '0000-00-00', ''),
(16, 'HUMA', '', 'staff', '2020-04-19', ''),
(17, 'HUMA', '', 'staff', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_events`
--

CREATE TABLE `detail_events` (
  `Id` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `TotalExpense` int(11) NOT NULL,
  `TotalIncome` int(11) NOT NULL,
  `Sponsorship` varchar(100) NOT NULL,
  `Information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_events`
--

INSERT INTO `detail_events` (`Id`, `EventId`, `TotalExpense`, `TotalIncome`, `Sponsorship`, `Information`) VALUES
(5, 5, 50000, 500000, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_expenses`
--

CREATE TABLE `detail_expenses` (
  `Id` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Object` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_expenses`
--

INSERT INTO `detail_expenses` (`Id`, `EventId`, `Object`, `Quantity`, `Price`, `Information`) VALUES
(1, 5, 'Kertas A4 1 rim', 2, 25000, '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_incomes`
--

CREATE TABLE `detail_incomes` (
  `Id` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Source` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_incomes`
--

INSERT INTO `detail_incomes` (`Id`, `EventId`, `Source`, `Quantity`, `Price`, `Information`) VALUES
(2, 5, 'Penjualan Tiket', 50, 10000, '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_rundown`
--

CREATE TABLE `detail_rundown` (
  `Id` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Activity` varchar(50) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Performer` varchar(50) NOT NULL,
  `Information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_rundown`
--

INSERT INTO `detail_rundown` (`Id`, `EventId`, `Activity`, `StartTime`, `EndTime`, `Performer`, `Information`) VALUES
(2, 5, 'Daftar Ulang', '15:00:00', '15:45:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `Id` int(11) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Description` text NOT NULL,
  `Photo` varchar(300) NOT NULL DEFAULT 'photo/events/default.svg',
  `City` varchar(30) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `StartDateTime` datetime NOT NULL,
  `EndDateTime` datetime NOT NULL,
  `Company` varchar(40) NOT NULL,
  `Quota` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`Id`, `Name`, `Description`, `Photo`, `City`, `Location`, `StartDateTime`, `EndDateTime`, `Company`, `Quota`, `Price`, `Status`) VALUES
(5, 'Seminar Tech Talk 5', 'This is default description', 'photo/events/default.svg', 'Yogyakarta', 'Gedung Pattimura', '2020-04-25 15:00:00', '2020-04-25 18:00:00', 'UPNVY', 100, 0, 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `Email` varchar(50) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `Institution` varchar(50) NOT NULL,
  `Profession` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`Email`, `Fullname`, `ContactNumber`, `Institution`, `Profession`) VALUES
('ramatriagung91@gmail.com', 'Rama Tri Agung', '081377879966', 'UPN Veteran Yogyakarta', 'Student'),
('zahra234@gmail.com', 'Iffatuz Zahra', '081377879966', 'UPN Veteran Yogyakarta', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `Id` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Payment` varchar(10) NOT NULL,
  `Attendance` tinyint(1) NOT NULL,
  `Receipt` varchar(300) NOT NULL,
  `Reward` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Email` varchar(50) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Photo` varchar(300) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Birthday` date NOT NULL,
  `VerifiedAccount` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Email`, `Username`, `Password`, `Photo`, `Address`, `Birthday`, `VerifiedAccount`) VALUES
('ramatriagung89@gmail.com', 'RTAgung', '12345678', 'photo/users/default.svg', 'Jl. Amula Rahayu RT.07 No.04', '2020-04-09', 0),
('ramatriagung90@gmail.com', 'RTAgung', '12345678', 'photo/users/default.svg', 'Jl. Amula Rahayu RT.07 No.04', '2020-04-09', 0),
('ramatriagung91@gmail.com', 'RTA', '12345678', 'photo/users/default.svg', 'Jl. Amula Rahayu RT.07 No.04 Lubuklinggau', '2000-01-06', 1),
('zahra123@gmail.com', 'RedRa', '12345678', 'photo/users/default.svg', 'Agam Sumatera Barat', '1999-12-26', 0),
('zahra234@gmail.com', 'Zahra', '12345678', 'photo/users/default.svg', 'Padang', '2020-04-09', 1),
('zahra345@gmail.com', 'Zahra', '12345678', 'photo/users/default.svg', 'Padang', '2020-04-09', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `committees`
--
ALTER TABLE `committees`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_email_committee` (`Email`),
  ADD KEY `fk_eventid_committee` (`EventId`);

--
-- Indexes for table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `detail_committees`
--
ALTER TABLE `detail_committees`
  ADD KEY `fk_commid_detailcomm` (`CommitteeId`),
  ADD KEY `fk_departid_departements` (`DepartementId`);

--
-- Indexes for table `detail_events`
--
ALTER TABLE `detail_events`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_eventid_detailevents` (`EventId`);

--
-- Indexes for table `detail_expenses`
--
ALTER TABLE `detail_expenses`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_eventid_detailexpenses` (`EventId`);

--
-- Indexes for table `detail_incomes`
--
ALTER TABLE `detail_incomes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_eventid_detailincomes` (`EventId`);

--
-- Indexes for table `detail_rundown`
--
ALTER TABLE `detail_rundown`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_eventid_detailrundown` (`EventId`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD KEY `fk_email_participants` (`Email`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_eventid_tickets` (`EventId`),
  ADD KEY `fk_email_tickets` (`Email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `committees`
--
ALTER TABLE `committees`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detail_events`
--
ALTER TABLE `detail_events`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_expenses`
--
ALTER TABLE `detail_expenses`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_incomes`
--
ALTER TABLE `detail_incomes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_rundown`
--
ALTER TABLE `detail_rundown`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `committees`
--
ALTER TABLE `committees`
  ADD CONSTRAINT `fk_email_committee` FOREIGN KEY (`Email`) REFERENCES `users` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventid_committee` FOREIGN KEY (`EventId`) REFERENCES `events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_committees`
--
ALTER TABLE `detail_committees`
  ADD CONSTRAINT `fk_commid_detailcomm` FOREIGN KEY (`CommitteeId`) REFERENCES `committees` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_departid_departements` FOREIGN KEY (`DepartementId`) REFERENCES `departements` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_events`
--
ALTER TABLE `detail_events`
  ADD CONSTRAINT `fk_eventid_detailevents` FOREIGN KEY (`EventId`) REFERENCES `events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_expenses`
--
ALTER TABLE `detail_expenses`
  ADD CONSTRAINT `fk_eventid_detailexpenses` FOREIGN KEY (`EventId`) REFERENCES `detail_events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_incomes`
--
ALTER TABLE `detail_incomes`
  ADD CONSTRAINT `fk_eventid_detailincomes` FOREIGN KEY (`EventId`) REFERENCES `detail_events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_rundown`
--
ALTER TABLE `detail_rundown`
  ADD CONSTRAINT `fk_eventid_detailrundown` FOREIGN KEY (`EventId`) REFERENCES `detail_events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `fk_email_participants` FOREIGN KEY (`Email`) REFERENCES `users` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_email_tickets` FOREIGN KEY (`Email`) REFERENCES `users` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventid_tickets` FOREIGN KEY (`EventId`) REFERENCES `events` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
