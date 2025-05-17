-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS Onboarding;

-- Use the database
USE Onboarding;

-- Create the onboarding table
CREATE TABLE IF NOT EXISTS onboarding (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    is_emergency TINYINT(1) NOT NULL DEFAULT 0,
    property_type VARCHAR(50) NOT NULL,
    time VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 