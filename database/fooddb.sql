DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS restaurants;

CREATE DATABASE IF NOT EXISTS fooddb;
USE fooddb;

CREATE TABLE IF NOT EXISTS restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cuisine_type VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    opening_hours VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    restaurant_name VARCHAR(100) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    rating INT NOT NULL,
    review TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- Sample Data for restaurants
INSERT INTO restaurants (name, cuisine_type, location, description, opening_hours, image) VALUES
('Nasi Lemak Royale', 'Malay', 'Bukit Bintang, Kuala Lumpur', 'A modern take on classic Malaysian comfort food with fragrant coconut rice, sambal, and crispy fried chicken.', 'Daily: 07:00-22:30', '00.jpg'),
('Mamak Street Kitchen', 'Malay', 'George Town, Penang', 'Casual late-night spot serving roti canai, nasi kandar, and teh tarik in a lively atmosphere.', 'Daily: 10:00-02:00', '01.jpg'),
('Penang Wok House', 'Chinese', 'Jalan Macalister, Penang', 'Hawker-inspired dishes with Penang flavours, fresh seafood, and wok-fired noodles.', 'Mon-Sun: 11:00-22:00', '02.jpg'),
('Spice Bowl KL', 'Indian', 'Brickfields, Kuala Lumpur', 'Bold South Indian and Malaysian-Indian dishes, from banana leaf rice to masala curries.', 'Daily: 11:00-22:30', '10.jpg'),
('Borneo Bites', 'Kadazan-Dusun', 'Kota Kinabalu, Sabah', 'Sabah-inspired plates showcasing hinava, tuhau, and local river fish with a contemporary touch.', 'Tue-Sun: 12:00-21:30', '11.jpg'),
('Melaka Heritage Café', 'Peranakan', 'Jonker Street, Melaka', 'A heritage café serving nyonya laksa, ayam pongteh, and kuih in a restored shophouse.', 'Daily: 09:00-21:00', '12.jpg'),
('Coastline Grill', 'Seafood', 'Tanjung Aru, Kota Kinabalu', 'Fresh grilled seafood, sambal sotong, and chilled drinks with a relaxed seaside view.', 'Daily: 12:00-23:00', '20.jpg'),
('KL Garden Table', 'Fusion', 'Bangsar, Kuala Lumpur', 'A polished dining room blending Malaysian ingredients with contemporary plating and seasonal specials.', 'Mon-Sat: 18:00-23:00', '21.jpg');

-- Sample Data for reviews (ensure restaurant_id matches existing restaurant ids)
INSERT INTO reviews (restaurant_id, restaurant_name, customer_name, email, rating, review) VALUES
(1, 'Nasi Lemak Royale', 'Aina Rahman', 'aina@example.com', 5, 'The sambal was balanced and the chicken was crispy. Very satisfying for breakfast or dinner.'),
(1, 'Nasi Lemak Royale', 'Farid Hassan', 'farid@example.com', 4, 'Great local flavour and generous portions. The rice fragrance really stood out.'),
(2, 'Mamak Street Kitchen', 'Suresh Kumar', 'suresh@example.com', 5, 'Roti canai was flaky and the teh tarik was excellent. Perfect for a late-night meal.'),
(2, 'Mamak Street Kitchen', 'Nurul Izzah', 'nurul@example.com', 4, 'Busy and lively, just like a proper mamak spot. Food came out fast.'),
(3, 'Penang Wok House', 'Jason Lim', 'jason@example.com', 5, 'The char kway teow had proper wok hei and the seafood was fresh.'),
(3, 'Penang Wok House', 'Mei Ling Tan', 'meiling@example.com', 4, 'Comforting flavours with a nice Penang-style kick. Would return for the noodles.'),
(4, 'Spice Bowl KL', 'Priya Devi', 'priya@example.com', 5, 'Banana leaf rice was fragrant and the curries had a rich, authentic taste.'),
(5, 'Borneo Bites', 'Edward Ling', 'edward@example.com', 5, 'Loved the Sabah-inspired menu. The tuhau side dish was memorable and unique.'),
(6, 'Melaka Heritage Café', 'Shalini Perera', 'shalini@example.com', 4, 'Beautiful heritage setting and the nyonya laksa had a satisfying spicy depth.'),
(7, 'Coastline Grill', 'Hafiz Amir', 'hafiz@example.com', 4, 'Fresh seafood and a relaxed atmosphere by the coast. The grilled squid was a highlight.'),
(8, 'KL Garden Table', 'Amirah Zulkifli', 'amirah@example.com', 5, 'Modern plating, polished service, and clearly Malaysian flavours with a fine-dining touch.');
