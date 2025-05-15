-- Create the database
CREATE DATABASE IF NOT EXISTS MedallionTheatreDB;
USE MedallionTheatreDB;

-- 1. SecurityPersonnel table (Numeric ID only)
CREATE TABLE SecurityPersonnel (
    PersonnelID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

-- 2. Shifts table
CREATE TABLE Shifts (
    ShiftID INT AUTO_INCREMENT PRIMARY KEY,
    PersonnelID INT,
    Shift VARCHAR(20) NOT NULL,
    Location VARCHAR(100) NOT NULL,
    EntryTime TIME NOT NULL,
    ExitTime TIME NOT NULL,
    FOREIGN KEY (PersonnelID) REFERENCES SecurityPersonnel(PersonnelID)
);

-- 3. EquipmentAssigned table
CREATE TABLE EquipmentAssigned (
    EquipmentID INT AUTO_INCREMENT PRIMARY KEY,
    ShiftID INT,
    Equipment VARCHAR(50) NOT NULL,
    FOREIGN KEY (ShiftID) REFERENCES Shifts(ShiftID)
);

-- 4. IncidentsReported table
CREATE TABLE IncidentsReported (
    IncidentID INT AUTO_INCREMENT PRIMARY KEY,
    ShiftID INT,
    Incident VARCHAR(255) NOT NULL,
    FOREIGN KEY (ShiftID) REFERENCES Shifts(ShiftID)
);

INSERT INTO SecurityPersonnel (Name) VALUES 
('Carlos Mendoza'),
('Angela Ramos'),
('Ricardo Reyes'),
('Bea Lopez');

INSERT INTO Shifts (PersonnelID, Shift, Location, EntryTime, ExitTime) VALUES
(1, 'Day', 'Front Desk', '08:00:00', '16:00:00'),
(2, 'Night', 'Rooftop', '20:00:00', '04:00:00'),
(3, 'Swing', 'Control Room', '12:00:00', '20:00:00'),
(4, 'Day', 'Exit Gate', '06:00:00', '14:00:00');

INSERT INTO EquipmentAssigned (ShiftID, Equipment) VALUES
(1, 'Radio'),
(2, 'CCTV Monitor'),
(3, 'Body Cam'),
(4, 'Whistle');

INSERT INTO IncidentsReported (ShiftID, Incident) VALUES
(1, 'Missing Visitor Badge'),
(2, 'Fence Breach Detected'),
(3, 'Elevator Malfunction'),
(4, 'Unauthorized Parking');
