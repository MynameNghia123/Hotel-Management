-- ---------------------------------------------------------
-- HOTEL MANAGEMENT SYSTEM DATABASE SCHEMA
-- Author: Antigravity (Advanced AI Assistant)
-- Description: Detailed database structure for hotel operations
-- RDBMS: MySQL/MariaDB
-- ---------------------------------------------------------

-- SET GLOBAL SETTINGS
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- 1. SYSTEM & ROLE MANAGEMENT
-- ---------------------------------------------------------

-- Roles Table: Define access levels (Admin, Staff, Manager, etc.)
CREATE TABLE IF NOT EXISTS `Roles` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Role name: Admin, Receptionist, Housekeeping'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- RoleClaims Table: Define specific permissions for each role
CREATE TABLE IF NOT EXISTS `RoleClaims` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `RoleId` INT NOT NULL,
    `ClaimName` VARCHAR(100) NOT NULL,
    `ClaimValue` VARCHAR(255) NOT NULL,
    CONSTRAINT `FK_RoleClaims_Roles` FOREIGN KEY (`RoleId`) REFERENCES `Roles`(`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Staff Table: Management of hotel employees
CREATE TABLE IF NOT EXISTS `Staff` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `RoleId` INT NOT NULL,
    `FirstName` VARCHAR(100) NOT NULL,
    `LastName` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(100) UNIQUE NULL,
    `Password` VARCHAR(255) NOT NULL COMMENT 'Hashed password',
    `IsActive` BOOLEAN DEFAULT TRUE,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_Staff_Roles` FOREIGN KEY (`RoleId`) REFERENCES `Roles`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SystemSettings Table: Global configuration
CREATE TABLE IF NOT EXISTS `SystemSettings` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `SettingKey` VARCHAR(100) NOT NULL UNIQUE,
    `SettingValue` TEXT NULL,
    `Description` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 2. INFRASTRUCTURE & ROOMS
-- ---------------------------------------------------------

-- Floor Table: Build structure mapping
CREATE TABLE IF NOT EXISTS `Floors` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Floor 1, Floor 2, Terrace'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Amenities Table: Hotel features like Wi-Fi, Pool, etc.
CREATE TABLE IF NOT EXISTS `Amenities` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL UNIQUE,
    `Icon` VARCHAR(255) NULL COMMENT 'CSS class or image URL for the icon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- RoomType Table: Configuration of room categories
CREATE TABLE IF NOT EXISTS `RoomTypes` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL COMMENT 'Superior, Deluxe, Suite',
    `Code` VARCHAR(20) NOT NULL UNIQUE COMMENT 'Short code for identification',
    `AdultQuantity` INT DEFAULT 2,
    `ChildQuantity` INT DEFAULT 0,
    `SingleBedQuantity` INT DEFAULT 0,
    `DoubleBedQuantity` INT DEFAULT 0,
    `Width` DECIMAL(10, 2) COMMENT 'In meters',
    `Height` DECIMAL(10, 2) COMMENT 'In meters',
    `HourlyPrice` DECIMAL(18, 2) NOT NULL DEFAULT 0,
    `DailyPrice` DECIMAL(18, 2) NOT NULL DEFAULT 0,
    `Description` TEXT NULL,
    `IsActive` BOOLEAN DEFAULT TRUE,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- RoomTypeAmenities: Many-to-Many relationship
CREATE TABLE IF NOT EXISTS `RoomTypeAmenities` (
    `RoomTypeId` INT NOT NULL,
    `AmenityId` INT NOT NULL,
    PRIMARY KEY (`RoomTypeId`, `AmenityId`),
    CONSTRAINT `FK_RTA_RoomType` FOREIGN KEY (`RoomTypeId`) REFERENCES `RoomTypes`(`Id`) ON DELETE CASCADE,
    CONSTRAINT `FK_RTA_Amenity` FOREIGN KEY (`AmenityId`) REFERENCES `Amenities`(`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- RoomTypeImage Table: Gallery for room types
CREATE TABLE IF NOT EXISTS `RoomTypeImages` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `RoomTypeId` INT NOT NULL,
    `ImageUrl` VARCHAR(255) NOT NULL,
    `Order` INT DEFAULT 0,
    CONSTRAINT `FK_RoomTypeImages_RoomType` FOREIGN KEY (`RoomTypeId`) REFERENCES `RoomTypes`(`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Room Table: Individual hotel rooms
CREATE TABLE IF NOT EXISTS `Rooms` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `RoomTypeId` INT NOT NULL,
    `FloorId` INT NOT NULL,
    `Name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Example: R101, R102',
    `Status` VARCHAR(20) DEFAULT 'Available' COMMENT 'Available, Occupied, Maintenance, Cleaning',
    CONSTRAINT `FK_Rooms_RoomType` FOREIGN KEY (`RoomTypeId`) REFERENCES `RoomTypes`(`Id`),
    CONSTRAINT `FK_Rooms_Floor` FOREIGN KEY (`FloorId`) REFERENCES `Floors`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 3. EQUIPMENT & MAINTENANCE
-- ---------------------------------------------------------

-- EquipmentCategories Table
CREATE TABLE IF NOT EXISTS `EquipmentCategories` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Equipments Table: Catalog of equipment
CREATE TABLE IF NOT EXISTS `Equipments` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL,
    `EquipmentCategoryId` INT NOT NULL,
    `ImportPrice` DECIMAL(18, 2) NOT NULL DEFAULT 0,
    CONSTRAINT `FK_Equipments_Category` FOREIGN KEY (`EquipmentCategoryId`) REFERENCES `EquipmentCategories`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- RoomEquipment: Stock/Setup per Room Type
CREATE TABLE IF NOT EXISTS `RoomEquipment` (
    `RoomTypeId` INT NOT NULL,
    `EquipmentID` INT NOT NULL,
    `Quantity` INT DEFAULT 1,
    PRIMARY KEY (`RoomTypeId`, `EquipmentID`),
    CONSTRAINT `FK_RE_RoomType` FOREIGN KEY (`RoomTypeId`) REFERENCES `RoomTypes`(`Id`) ON DELETE CASCADE,
    CONSTRAINT `FK_RE_Equipment` FOREIGN KEY (`EquipmentID`) REFERENCES `Equipments`(`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MaintenanceTicket Table: Tracking repairs
CREATE TABLE IF NOT EXISTS `MaintenanceTickets` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `RoomId` INT NOT NULL,
    `EquipmentId` INT NULL,
    `ReportedDate` DATE NOT NULL,
    `IssueDescription` TEXT NULL,
    `TechnicianNote` TEXT NULL,
    `Status` VARCHAR(20) DEFAULT 'Pending' COMMENT 'Pending, InProgress, Completed, Cancelled',
    `RepairCost` DECIMAL(18, 2) DEFAULT 0,
    `ReportedByStaffId` INT NOT NULL,
    `TechnicianId` INT NOT NULL,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_MT_Room` FOREIGN KEY (`RoomId`) REFERENCES `Rooms`(`Id`),
    CONSTRAINT `FK_MT_Equipment` FOREIGN KEY (`EquipmentId`) REFERENCES `Equipments`(`Id`),
    CONSTRAINT `FK_MT_ReportedBy` FOREIGN KEY (`ReportedByStaffId`) REFERENCES `Staff`(`Id`),
    CONSTRAINT `FK_MT_Technician` FOREIGN KEY (`TechnicianId`) REFERENCES `Staff`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 4. SERVICES
-- ---------------------------------------------------------

-- ServiceGroup Table
CREATE TABLE IF NOT EXISTS `ServiceGroups` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `ServiceName` VARCHAR(100) NOT NULL COMMENT 'Example: Food, Beverage, Spa, Transport'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Service Table
CREATE TABLE IF NOT EXISTS `Services` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL,
    `GroupId` INT NOT NULL,
    `UnitPrice` DECIMAL(18, 2) NOT NULL DEFAULT 0,
    `Unit` VARCHAR(20) NOT NULL COMMENT 'Piece, Hour, kg',
    CONSTRAINT `FK_Services_Group` FOREIGN KEY (`GroupId`) REFERENCES `ServiceGroups`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 5. CUSTOMERS & BOOKINGS
-- ---------------------------------------------------------

-- Customers Table
CREATE TABLE IF NOT EXISTS `Customers` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `FirstName` VARCHAR(100) NOT NULL,
    `LastName` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(20) NOT NULL,
    `AccountId` INT NULL COMMENT 'Link to web account if exists',
    `Country` VARCHAR(100) NULL,
    `Email` VARCHAR(100) UNIQUE NOT NULL,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Booking Table: Main reservation entry
CREATE TABLE IF NOT EXISTS `Bookings` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `CustomerId` INT NOT NULL,
    `BookingDate` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `StaffId` INT NULL COMMENT 'Staff who processed the booking',
    `TotalServiceAmount` DECIMAL(18, 2) DEFAULT 0,
    `TotalRoomAmount` DECIMAL(18, 2) DEFAULT 0,
    `SurchargeAmount` DECIMAL(18, 2) DEFAULT 0,
    `FinalAmount` DECIMAL(18, 2) DEFAULT 0,
    `Status` VARCHAR(20) DEFAULT 'Confirmed' COMMENT 'Pending, Confirmed, CheckedIn, CheckedOut, Cancelled',
    CONSTRAINT `FK_Bookings_Customer` FOREIGN KEY (`CustomerId`) REFERENCES `Customers`(`Id`),
    CONSTRAINT `FK_Bookings_Staff` FOREIGN KEY (`StaffId`) REFERENCES `Staff`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BookingDetail Table: Specific rooms in a booking
CREATE TABLE IF NOT EXISTS `BookingDetails` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `BookingId` INT NOT NULL,
    `RoomId` INT NOT NULL,
    `CheckinDate` DATETIME NOT NULL,
    `CheckoutDate` DATETIME NOT NULL,
    `HourlyPrice` DECIMAL(18, 2) DEFAULT 0,
    `DailyPrice` DECIMAL(18, 2) DEFAULT 0,
    `ServiceAmount` DECIMAL(18, 2) DEFAULT 0,
    `SurchargeAmount` DECIMAL(18, 2) DEFAULT 0,
    CONSTRAINT `FK_BD_Booking` FOREIGN KEY (`BookingId`) REFERENCES `Bookings`(`Id`) ON DELETE CASCADE,
    CONSTRAINT `FK_BD_Room` FOREIGN KEY (`RoomId`) REFERENCES `Rooms`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ServiceUsage Table: Tracking service consumption during stay
CREATE TABLE IF NOT EXISTS `ServiceUsage` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `BookingDetailId` INT NOT NULL,
    `ServiceId` INT NOT NULL,
    `Quantity` INT DEFAULT 1,
    `UnitPrice` DECIMAL(18, 2) NOT NULL,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_ServiceUsage_BookingDetail` FOREIGN KEY (`BookingDetailId`) REFERENCES `BookingDetails`(`Id`) ON DELETE CASCADE,
    CONSTRAINT `FK_ServiceUsage_Service` FOREIGN KEY (`ServiceId`) REFERENCES `Services`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 6. POLICIES & PAYMENTS
-- ---------------------------------------------------------

-- SurchargePolicies Table
CREATE TABLE IF NOT EXISTS `SurchargePolicies` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `PolicyType` VARCHAR(50) NOT NULL COMMENT 'CheckIn-Early, CheckOut-Late',
    `HourMark` DECIMAL(5, 2) COMMENT 'Threshold for policy application',
    `Price` DECIMAL(18, 2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payments Table
CREATE TABLE IF NOT EXISTS `Payments` (
    `Id` INT AUTO_INCREMENT PRIMARY KEY,
    `BookingId` INT NOT NULL,
    `Amount` DECIMAL(18, 2) NOT NULL,
    `PaymentMethod` VARCHAR(50) DEFAULT 'Cash' COMMENT 'Cash, CreditCard, BankTransfer, E-Wallet',
    `Note` VARCHAR(255) NULL,
    `TransactionCode` VARCHAR(100) NULL,
    `StaffId` INT NULL,
    `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_Payments_Booking` FOREIGN KEY (`BookingId`) REFERENCES `Bookings`(`Id`),
    CONSTRAINT `FK_Payments_Staff` FOREIGN KEY (`StaffId`) REFERENCES `Staff`(`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ENABLE FOREIGN KEY CHECKS
SET FOREIGN_KEY_CHECKS = 1;
