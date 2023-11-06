CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
CREATE TABLE IF NOT EXISTS users (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) NOT NULL,
  surname VARCHAR(40) NOT NULL,
  PRIMARY KEY (ID)
);

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Artem', 'Teremiazev') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Artem' AND surname = 'Teremiazev'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Outer', 'Wilds') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Outer' AND surname = 'Wilds'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Billy', 'Herrington') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Billy' AND surname = 'Herrington'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Dwayne', 'Johnson') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Dwayne' AND surname = 'Johnson'
) LIMIT 1;