-- ---------------------------------------------------------
-- HOTEL MANAGEMENT SYSTEM SAMPLE DATA (SEEDER)
-- Author: Antigravity (Advanced AI Assistant)
-- Description: Sample data for testing the hotel database schema
-- ---------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. ROLES & STAFF
TRUNCATE TABLE `Roles`;
INSERT INTO `Roles` (`Id`, `Name`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'Receptionist'),
(4, 'Housekeeping'),
(5, 'Technician');

TRUNCATE TABLE `Staff`;
INSERT INTO `Staff` (`RoleId`, `FirstName`, `LastName`, `PhoneNumber`, `Email`, `Password`, `IsActive`) VALUES
(1, 'System', 'Administrator', '0123456789', 'admin@hotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(3, 'Nguyen', 'Thanh', '0987654321', 'reception1@hotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(5, 'Quoc', 'Duy', '0901234567', 'tech1@hotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- 2. INFRASTRUCTURE & ROOMS
TRUNCATE TABLE `Floors`;
INSERT INTO `Floors` (`Id`, `Name`) VALUES
(1, 'Ground Floor (G)'),
(2, 'Floor 1'),
(3, 'Floor 2'),
(4, 'Floor 3'),
(5, 'Penthouse');

TRUNCATE TABLE `Amenities`;
INSERT INTO `Amenities` (`Id`, `Name`, `Icon`) VALUES
(1, 'Free Wi-Fi', 'fas fa-wifi'),
(2, 'Air Conditioning', 'fas fa-snowflake'),
(3, 'Safety Box', 'fas fa-vault'),
(4, 'Mini Bar', 'fas fa-wine-glass'),
(5, 'Balcony', 'fas fa-cloud-sun');

TRUNCATE TABLE `RoomTypes`;
INSERT INTO `RoomTypes` (`Id`, `Name`, `Code`, `AdultQuantity`, `ChildQuantity`, `SingleBedQuantity`, `DoubleBedQuantity`, `Width`, `Height`, `HourlyPrice`, `DailyPrice`, `Description`) VALUES
(1, 'Standard Single', 'STD-SGL', 1, 0, 1, 0, 15.5, 3.5, 50.00, 300.00, 'Basic room with single bed.'),
(2, 'Deluxe Double', 'DLX-DBL', 2, 1, 0, 1, 25.0, 3.5, 120.00, 800.00, 'Room with double bed and extra space.'),
(3, 'Luxury Suite', 'LUX-SUI', 2, 2, 0, 2, 45.0, 4.0, 350.00, 2500.00, 'Premium suite with balcony and mini bar.');

TRUNCATE TABLE `RoomTypeAmenities`;
INSERT INTO `RoomTypeAmenities` (`RoomTypeId`, `AmenityId`) VALUES
(1, 1), (1, 2),
(2, 1), (2, 2), (2, 3), (2, 4),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5);

TRUNCATE TABLE `Rooms`;
INSERT INTO `Rooms` (`RoomTypeId`, `FloorId`, `Name`, `Status`) VALUES
(1, 2, 'R101', 'Available'),
(1, 2, 'R102', 'Cleaning'),
(2, 3, 'R201', 'Occupied'),
(2, 3, 'R202', 'Available'),
(3, 5, 'P501', 'Available');

-- 3. EQUIPMENT
TRUNCATE TABLE `EquipmentCategories`;
INSERT INTO `EquipmentCategories` (`Id`, `Name`) VALUES
(1, 'Electronics'),
(2, 'Furniture'),
(3, 'Bedding');

TRUNCATE TABLE `Equipments`;
INSERT INTO `Equipments` (`Id`, `Name`, `EquipmentCategoryId`, `ImportPrice`) VALUES
(1, 'Smart TV 43"', 1, 5000.00),
(2, 'Air Conditioner', 1, 8000.00),
(3, 'Queen Size Bed', 2, 12000.00),
(4, 'Work Desk', 2, 2500.00);

TRUNCATE TABLE `RoomEquipment`;
INSERT INTO `RoomEquipment` (`RoomTypeId`, `EquipmentID`, `Quantity`) VALUES
(1, 2, 1), (1, 3, 1), (1, 4, 1),
(2, 1, 1), (2, 2, 1), (2, 3, 1), (2, 4, 1),
(3, 1, 2), (3, 2, 2), (3, 3, 2), (3, 4, 2);

-- 4. SERVICES
TRUNCATE TABLE `ServiceGroups`;
INSERT INTO `ServiceGroups` (`Id`, `ServiceName`) VALUES
(1, 'Food & Beverage'),
(2, 'Laundry'),
(3, 'Transportation');

TRUNCATE TABLE `Services`;
INSERT INTO `Services` (`Id`, `Name`, `GroupId`, `UnitPrice`, `Unit`) VALUES
(1, 'Beer Heineken', 1, 35.00, 'Can'),
(2, 'Stir-fried Noodles', 1, 75.00, 'Dish'),
(3, 'Shirt Laundry', 2, 20.00, 'Piece'),
(4, 'Airport Pick-up', 3, 500.00, 'Trip');

-- 5. SURCHARGE POLICIES
TRUNCATE TABLE `SurchargePolicies`;
INSERT INTO `SurchargePolicies` (`PolicyType`, `HourMark`, `Price`) VALUES
('Check-In Early (1-2h)', -2.00, 50.00),
('Check-In Early (>2h)', -4.00, 150.00),
('Check-Out Late (1-2h)', 2.00, 50.00),
('Check-Out Late (>2h)', 4.00, 150.00);

SET FOREIGN_KEY_CHECKS = 1;
