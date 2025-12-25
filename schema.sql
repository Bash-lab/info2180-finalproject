-- create the database
DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

-- insert tables and fields
CREATE TABLE users(
    id INT AUTO_INCREMENT NOT NULL,
    firstname VARCHAR(25),
    lastname  VARCHAR(25),
    password VARCHAR(256),
    email VARCHAR(40) NOT NULL UNIQUE,
    role VARCHAR(40),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE contacts(
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(10),
    firstname VARCHAR(25),
    lastname VARCHAR(25),
    email VARCHAR(40),
    telephone VARCHAR(15),
    company VARCHAR(40),
    type ENUM('Sales Lead', 'Support') NOT NULL,
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE notes(
    id INT AUTO_INCREMENT NOT NULL,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (contact_id) REFERENCES contacts(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert default admin user
-- Password: password123
-- This hash was generated using: password_hash('password123', PASSWORD_DEFAULT)
INSERT INTO users (firstname, lastname, password, email, role)
VALUES(
    'Admin',
    'User',
    '$2y$10$eR8cKcZqWLZaZqGtV5GvPeJ3pXx.WqJpZqZ5E4YvQ7GvGqH7yqY8y',
    'admin@project2.com',
    'Admin'
);