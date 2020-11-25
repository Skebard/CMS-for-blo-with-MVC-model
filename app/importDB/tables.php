<?php
// Tables that conform the database.
//At the end they are inserted in the $tables array and be sure that each query ends with ;
//Make sure to put them in the right order (relations)


$htmlElements = 'CREATE TABLE htmlElements(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    position INT(6) NOT NULL,
    postId INT(6) UNSIGNED NOT NULL,
    options CHAR(50) DEFAULT "javascript",
    UNIQUE(position,postId),
    CONSTRAINT fk_ph_post_id
        FOREIGN KEY (postId)
        REFERENCES posts (id)
        ON DELETE CASCADE
    );';

$posts = 'CREATE TABLE posts(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    mainImage VARCHAR(1000),
    description VARCHAR (1000),
    STATUS VARCHAR (20) DEFAULT "draft",
    published BOOLEAN DEFAULT FALSE,
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    publishingDate DATETIME,
    lastModificationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    authorId INT(6) UNSIGNED NOT NULL,
    mainCategory INT(6) UNSIGNED NOT NULL,
    UNIQUE(title),
        FOREIGN KEY (authorId)
        REFERENCES authors (id)
        ON DELETE CASCADE,
        FOREIGN KEY (mainCategory)
        REFERENCES categories (id)
        ON DELETE CASCADE
    );';

$categories = 'CREATE TABLE categories(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL UNIQUE
    );';

$postCategories = 'CREATE TABLE postCategories (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    postId INT(6) UNSIGNED NOT NULL,
    categoryId INT(6) UNSIGNED NOT NULL,
    UNIQUE(postId,categoryId),
        FOREIGN KEY (postId)
        REFERENCES posts (id)
        ON DELETE CASCADE,
        FOREIGN KEY (categoryId)
        REFERENCES categories (id)
        ON DELETE CASCADE

);';


$comments = 'CREATE TABLE comments(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    postId INT(6) UNSIGNED NOT NULL,
    CONSTRAINT fk_post_id
        FOREIGN KEY (postId)
        REFERENCES posts (id)
        ON DELETE CASCADE
    );';
$authors = 'CREATE TABLE authors(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(40) NOT NULL,
    password VARCHAR(1000) NOT NULL,
    firstName VARCHAR(30) NOT NULL,
    lastName1 VARCHAR(30) NOT NULL,
    lastName2 VARCHAR(30) NOT NULL,
    birthdate DATETIME,
    profileImage VARCHAR(3000),
    email VARCHAR (150),
    UNIQUE (username),
    UNIQUE (email)
    )';

// Table to track login attempts
$login = 'CREATE TABLE login (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(22) NOT NULL,
    attempts INT UNSIGNED NOT NULL,
    last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(ip_address)
)';




$tables = [$categories,$authors,$posts,$postCategories,$comments,$htmlElements];