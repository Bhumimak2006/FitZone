
DROP DATABASE IF EXISTS fitzone;

CREATE DATABASE fitzone
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE fitzone;

-- 1. Membership plans
CREATE TABLE memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL
);

INSERT INTO memberships (name, price) VALUES
('Basic', 499.00),
('Premium', 999.00),
('VIP', 1499.00);


-- 2. Members / Registration / Login
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(20),
    membership_id INT NOT NULL,
    goal VARCHAR(100),
    start_date VARCHAR(20),
    photo VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_member_membership
        FOREIGN KEY (membership_id)
        REFERENCES memberships(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);


-- 3. Payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',

    CONSTRAINT fk_payment_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE
);
