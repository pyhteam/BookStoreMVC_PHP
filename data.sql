-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2023 at 02:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hmz_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `Key` varchar(40) NOT NULL,
  `Value` varchar(40) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `Name` varchar(40) NOT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rolespermissions`
--

CREATE TABLE `rolespermissions` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `PermissionId` char(36) NOT NULL,
  `RoleId` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `Username` varchar(40) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `FullName` varchar(250) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Avatar` varchar(250) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` varchar(250) DEFAULT 'System',
  `UpdatedAt` datetime DEFAULT NULL,
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--
-- Pass: 123456
-- CMD: composer dump-autoload
-- CMD: php -S localhost:8080 -t public

INSERT INTO `users` (`Id`, `Username`, `Email`, `Password`, `FullName`, `Phone`, `Avatar`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `IsActive`) VALUES
('3df1e08c-38dc-11ee-863c-a036bcab437e', 'admin', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Admin System', NULL, NULL, '2023-08-12 17:39:16', 'System', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usersroles`
--

CREATE TABLE `usersroles` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `UserId` char(36) NOT NULL,
  `RoleId` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `bookcategory` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',
  `Name` varchar(250) NOT NULL,
  `Slug` varchar(250) NOT NULL,
  
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `book` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',

  `Title` varchar(250) NOT NULL,
  `Author` varchar(250) NOT NULL,
  `CategoryId` varchar(36) NOT NULL,
  `Price`  INT(11) DEFAULT 0,
  `Quantity` INT(11) DEFAULT 0,
  `Description` varchar(1000) DEFAULT NULL,
  `Image` varchar(250) DEFAULT NULL,
  `Slug` varchar(250) DEFAULT NULL,

  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `orders` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',

  `Code` varchar(40) NOT NULL,
  `UserId` char(36) NOT NULL,
  `TotalPrice` INT(11) DEFAULT 0,
  `Status` varchar(100) NOT NULL,
  `ShipName`  varchar(250) NOT NULL,
  `ShipPhone` varchar(250) NOT NULL,
  `ShipAddress` varchar(250) NOT NULL,

  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `orderdetails` (
  `Id` char(36) NOT NULL DEFAULT 'UUID()',

  `OrderId` char(36) NOT NULL,
  `BookId` char(36) DEFAULT 0,
  `Quantity` INT(11) DEFAULT 0,
  
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(250) NOT NULL DEFAULT 'System',
  `UpdatedBy` varchar(250) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `orders`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`Id`);


ALTER TABLE `book`
  ADD PRIMARY KEY (`Id`);
  
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`Id`);
  
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `rolespermissions`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `usersroles`
  ADD PRIMARY KEY (`Id`);
COMMIT;
