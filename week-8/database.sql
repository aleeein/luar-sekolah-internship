CREATE DATABASE codein_db;

USE codein_db;

-- Table to store user information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table to store enrollments for users in specific courses
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Table for program categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Table for courses within each category
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(255) NOT NULL,
    level VARCHAR(50),
    trainer VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Table for testimonials
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT,
    name VARCHAR(255),
    position VARCHAR(255)
);

-- Add categories
INSERT INTO categories (name) VALUES 
('Backend Programming'), 
('Frontend Programming'), 
('Android Development'), 
('iOS Development');

-- Add courses
INSERT INTO courses (category_id, title, level, trainer) VALUES 
(1, 'Basic HTML and CSS', 'Basic', 'John Doe'),
(1, 'Advanced HTML and CSS', 'Advanced', 'Jane Smith'),
(1, 'Basic JavaScript', 'Basic', 'Sarah Johnson'),
(2, 'ReactJS for Beginners', 'Intermediate', 'Alex Lee'),
(3, 'Android App Development with Kotlin', 'Basic', 'Michael Thompson'),
(4, 'iOS App Development with Swift', 'Advanced', 'Linda Brown');

-- Add testimonials
INSERT INTO testimonials (content, name, position) VALUES 
("I've tried several coding platforms, but CodeIn stands out with its comprehensive learning paths...", "Katherine Smith", "Machine Learning Engineer at Tokopedia"),
("CodeIn has completely transformed the way I learn coding. The courses are well-structured and easy to follow...", "Jonathan Lee", "Backend Developer at Amazon"),
("Whether you're a complete beginner or looking to enhance your coding skills, CodeIn has something for everyone...", "David Wilson", "Full Stack Developer at Meta");