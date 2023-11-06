CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;

CREATE TABLE Promos(
    promo_id INT AUTO_INCREMENT PRIMARY KEY,
    promo_name VARCHAR(50),
    promo_code VARCHAR(100)
);

CREATE TABLE Sites(
    site_id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(50),
    site_url VARCHAR(100)
);

CREATE TABLE PromosSites(
    promo_id INT,
    site_id INT,
    FOREIGN KEY (promo_id) REFERENCES Promos(promo_id),
    FOREIGN KEY (site_id) REFERENCES Sites(site_id),
    PRIMARY KEY (promo_id, site_id) 
);

INSERT INTO Promos(promo_name, promo_code) VALUES
    ('-50% First', 'AAABBBCCC'),
    ('10% Cashback', 'XXXYYYZZZ'),
    ('Free delivery', 'KKKLLLNNN');

INSERT INTO Sites(site_name, site_url) VALUES
    ('Pikabu', 'promokod.pikabu.ru'),
    ('Pepper', 'pepper.ru/coupons'),
    ('Promokodi net', 'promokodi.net');

INSERT INTO PromosSites(promo_id, site_id) VALUES
    (1, 1),
    (1, 2),
    (2, 1), 
    (2, 3),
    (3, 3);