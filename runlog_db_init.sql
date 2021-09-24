/*
Use this file to initialize a database called runlog
which will work with the Runlog web app.

To initialize the database:
    1. Download this file
    2. Open the MySQL command line on your terminal
        - MySQL must be downloaded; check by typing 'mysql --version'
        - type 'mysql -u root -p'
        - type your root password and press enter
    3. Type 'source <path/to/file/runlog_db_init.sql>;' and press enter    
*/

-- Drop user if exists
DROP USER IF EXISTS 'runlog_user'@'localhost';

-- Create user and grant privileges
CREATE USER 'runlog_user'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON runlog.* TO 'runlog_user'@'localhost';

-- Create and use database
CREATE DATABASE IF NOT EXISTS runlog;
USE runlog;

-- Delete tables if exist
DROP TABLE IF EXISTS runs;
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    week_distance FLOAT(4,1) NOT NULL DEFAULT 0.0,
    month_distance FLOAT(5,1) NOT NULL DEFAULT 0.0,
    year_distance FLOAT(6,1) NOT NULL DEFAULT 0.0,
    PRIMARY KEY (id)
);

-- Create runs table
CREATE TABLE runs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    run_type VARCHAR(12) NOT NULL,
    distance FLOAT(4,1) NOT NULL,
    time_hours INT NOT NULL,
    time_minutes INT NOT NULL,
    time_seconds INT NOT NULL,
    average_pace VARCHAR(8) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert generic user data into user table
INSERT INTO users (first_name, last_name)
    VALUES ('user_first', 'user_last');