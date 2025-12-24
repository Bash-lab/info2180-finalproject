--create the database
DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

--insert tables and fields
CREATE TABLE Users(
    id INT AUTO_INCREMENT NOT NULL,
    firstname VARCHAR(25),
    lastname  VARCHAR(25),
    password_hash VARCHAR(256),
    email VARCHAR(40) NOT NULL UNIQUE,
    role VARCHAR(40),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id)
);

CREATE TABLE Contacts(
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(10),
    firstname VARCHAR(25),
    lastname VARCHAR(25),
    email VARCHAR (40),
    telephone VARCHAR (15),
    company VARCHAR(40),
    type ENUM('Sales Lead', 'Support') NOT NULL,
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

CREATE TABLE Notes(
    id INT AUTO_INCREMENT NOT NULL,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

INSERT INTO Users (email, password_hash)
VALUES(
    'admin@project2.com',
    SHA2('password123',256)
    );
