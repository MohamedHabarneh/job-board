DROP DATABASE IF EXISTS projectB;

CREATE DATABASE projectB;
USE projectB;

-- uncomment the comment below and copy it before each table to drop an existing table
-- DROP TABLE IF EXISTS TABLENAME 
CREATE TABLE UserAccount(
UserID		INT	NOT NULL AUTO_INCREMENT,
UserEmail	VARCHAR(255)		NOT NULL,

FirstName	VARCHAR(25)		NOT NULL,
LastName	VARCHAR(25)		NOT NULL,
Phone		CHAR(10),
Password	VARCHAR(2048)		NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

PRIMARY KEY(UserID),
UNIQUE (UserEmail)
);

-- Table: Roles
CREATE TABLE Roles (
RoleID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
roleType		VARCHAR(30),
PRIMARY KEY (RoleID)
);
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Owner');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'CEO');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Assistant or Manager');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Human Resources Generalis');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Hiring Manage');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Recruiter');
INSERT INTO `Roles` (`RoleID`, `TimeStamp`, `roleType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Other');

-- Table: Address
CREATE TABLE Address (
AddressID	INT			NOT NULL AUTO_INCREMENT,
ZipCode		CHAR(5)			NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
StreetAddress	VARCHAR(50),
State CHAR(2),
PRIMARY KEY (AddressID)
);

-- Table: Employer
CREATE TABLE Employer (
EmployerID	INT	NOT NULL	UNIQUE AUTO_INCREMENT,
UserID		INT,
AddressID	INT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
EmployerEmail	VARCHAR(255)	NOT NULL,
EmployerName	VARCHAR(50)	NOT NULL,
EmployerPhone	CHAR(11),
HiringRoleId		INT,
PRIMARY KEY (EmployerID),
FOREIGN KEY (HiringRoleId) REFERENCES Roles(RoleID),
FOREIGN KEY (UserID) REFERENCES UserAccount(UserID),
FOREIGN KEY (AddressID) REFERENCES Address(AddressID)
);



CREATE TABLE EducationLevels (
EducationID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
EducationLevel		VARCHAR(25),
PRIMARY KEY (EducationID)
);

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'No Education Required');

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'High School Degree');

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Associates Degree');

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Bachelors Degree');

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Masters Degree');

INSERT INTO `EducationLevels` (`EducationID`, `TimeStamp`, `EducationLevel`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Doctoral Degree');



-- Table: Employee
CREATE TABLE Employee (
EmployeeID		INT NOT NULL AUTO_INCREMENT,
UserID			INT	NOT NULL,
EducationLevel	INT	NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (EmployeeID),
FOREIGN KEY (UserID) REFERENCES UserAccount (UserID),
FOREIGN KEY (EducationLevel) REFERENCES EducationLevels (EducationID)
);


-- Table: JobTypes
CREATE TABLE JobTypes (
JobTypeID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
JobType		VARCHAR(16),
PRIMARY KEY (JobTypeID)
);

INSERT INTO `JobTypes` (`JobTypeID`, `TimeStamp`, `JobType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Full-Time');

INSERT INTO `JobTypes` (`JobTypeID`, `TimeStamp`, `JobType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Part-Time');

INSERT INTO `JobTypes` (`JobTypeID`, `TimeStamp`, `JobType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Contract');

INSERT INTO `JobTypes` (`JobTypeID`, `TimeStamp`, `JobType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Temporary');

INSERT INTO `JobTypes` (`JobTypeID`, `TimeStamp`, `JobType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Internship');
-- Table: ExpereinceRequired
CREATE TABLE ExperienceRequired (
ExpReqID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ExpType		VARCHAR(50),
PRIMARY KEY (ExpReqID)
);

INSERT INTO `ExperienceRequired` (`ExpReqID`, `TimeStamp`, `ExpType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Entry');
INSERT INTO `ExperienceRequired` (`ExpReqID`, `TimeStamp`, `ExpType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Mid');
    INSERT INTO `ExperienceRequired` (`ExpReqID`, `TimeStamp`, `ExpType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Senior');

-- Table: SalaryRange
CREATE TABLE SalaryRange (
SalaryID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
Salary		INT,
PRIMARY KEY (SalaryID)
);

INSERT INTO `SalaryRange` (`SalaryID`, `TimeStamp`, `Salary`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 35000);
INSERT INTO `SalaryRange` (`SalaryID`, `TimeStamp`, `Salary`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 40000);
INSERT INTO `SalaryRange` (`SalaryID`, `TimeStamp`, `Salary`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 50000);
INSERT INTO `SalaryRange` (`SalaryID`, `TimeStamp`, `Salary`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 70000);
INSERT INTO `SalaryRange` (`SalaryID`, `TimeStamp`, `Salary`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 100000);


-- Table: JobPosts
CREATE TABLE JobPosts (
JobPostID	INT	NOT NULL AUTO_INCREMENT,
EducationID	INT	NOT NULL,
AddressID	INT	NOT NULL,
JobTypeID	INT	NOT NULL,
ExpReqID	INT	NOT NULL,
SalaryID	INT	NOT NULL,

TimeStamp	TIMESTAMP,
JobPostTitle		CHAR(30),
JobDescription	VARCHAR(200),
Responsibilities	VARCHAR(200),
Qualifications	VARCHAR(200),
DatePosted	DATE,
Deadline	DATE,
ContactDetails	INT,

PRIMARY KEY (JobPostID),
FOREIGN KEY (EducationID) REFERENCES EducationLevels (EducationID),
FOREIGN KEY (AddressID) REFERENCES Address (AddressID),
FOREIGN KEY (JobTypeID) REFERENCES JobTypes (JobTypeID),
FOREIGN KEY (ExpReqID) REFERENCES ExperienceRequired (ExpReqID),
FOREIGN KEY (SalaryID) REFERENCES SalaryRange (SalaryID),
FOREIGN KEY (ContactDetails) REFERENCES Employer (EmployerID)

);


-- Table: EmployerPosts
CREATE TABLE EmployerPosts (
EmployerID	INT	NOT NULL ,
JobPostID	INT	NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (JobPostID),
FOREIGN KEY (EmployerID) REFERENCES Employer (EmployerID),
FOREIGN KEY (JobPostID)  REFERENCES JobPosts (JobPostID)
);


-- Table: SavedPosts
CREATE TABLE SavedPosts (
EmployeeID	INT	NOT NULL,
JobPostID	INT	NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (EmployeeID,JobPostID),
FOREIGN KEY (EmployeeID) REFERENCES Employee (EmployeeID),
FOREIGN KEY (JobPostID)  REFERENCES JobPosts (JobPostID)
);


-- Table: ApplicationStatus
CREATE TABLE ApplicationStatus (
AppStatusID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
AppStatus	VARCHAR(16),
PRIMARY KEY (AppStatusID)
);
INSERT INTO `ApplicationStatus` (`AppStatusID`, `TimeStamp`, `AppStatus`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Applied');
INSERT INTO `ApplicationStatus` (`AppStatusID`, `TimeStamp`, `AppStatus`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Rejected');
INSERT INTO `ApplicationStatus` (`AppStatusID`, `TimeStamp`, `AppStatus`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Interviewed');
INSERT INTO `ApplicationStatus` (`AppStatusID`, `TimeStamp`, `AppStatus`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Accepted');


-- Table: AppliedPosts
CREATE TABLE AppliedPosts (
EmployeeID	INT	NOT NULL,
AppStatusID	INT	NOT NULL,
JobPostID	INT	NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (EMployeeID,AppStatusID,JobPostID),
FOREIGN KEY (EmployeeID)  REFERENCES Employee (EmployeeID),
FOREIGN	KEY (AppStatusID) REFERENCES ApplicationStatus (AppStatusID),
FOREIGN KEY (JobPostID)   REFERENCES JobPosts (JobPostID)
);


-- Table: BenefitsOffered
CREATE TABLE BenefitsOffered (
BenefitID	INT	NOT NULL AUTO_INCREMENT,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
BenefitType		VARCHAR(20),
PRIMARY KEY (BenefitID)
);

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Health Insurance');

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Vision Insurance');

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Dental Insurance');

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Life Insurance');

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, 'Pension');

INSERT INTO `BenefitsOffered` (`BenefitID`, `TimeStamp`, `BenefitType`)
VALUES
	(NULL, CURRENT_TIMESTAMP, '401(k)');


-- Table: JobBenefits
CREATE TABLE JobBenefits (
BenefitID	INT	NOT NULL,
JobPostID	INT	NOT NULL,
TimeStamp	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (BenefitID,JobPostID),
FOREIGN KEY (BenefitID)	REFERENCES BenefitsOffered(BenefitID),
FOREIGN KEY (JobPostID)	REFERENCES JobPosts (JobPostID)
);
