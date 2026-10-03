CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    booking_type VARCHAR(50) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL DEFAULT '00:00:00',
    room_type VARCHAR(100) DEFAULT NULL,
    ticket_amount INT DEFAULT NULL,
    people_amount INT NOT NULL DEFAULT 0,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES signupform(id) ON DELETE CASCADE
);



ALTER TABLE `signupform` ADD `loyalty_points` INT NOT NULL AFTER `hashed_password`;