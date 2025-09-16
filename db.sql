 
CREATE DATABASE IF NOT EXISTS recipefinder;

USE recipefinder;

CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_title VARCHAR(255) NOT NULL,
    recipe_url VARCHAR(255) NOT NULL,
    recipe_image VARCHAR(255) NOT NULL
);

-- CREATE DATABASE recipe_app;
-- USE recipe_app;

-- -- Users Table
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     username VARCHAR(50) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL
-- );

-- -- Favorites Table
-- CREATE TABLE favorites (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,
--     title VARCHAR(255),
--     url VARCHAR(255),
--     image VARCHAR(255),
--     FOREIGN KEY (user_id) REFERENCES users(id)
-- );



CREATE DATABASE IF NOT EXISTS recipe_app;
USE recipe_app;

-- Favorites table
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_title VARCHAR(255),
    recipe_url VARCHAR(255),
    recipe_image VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);