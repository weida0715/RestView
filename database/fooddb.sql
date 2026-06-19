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
('The Gourmet Haven', 'Fine Dining', '123 Main St, Anytown', 'A exquisite culinary experience with a focus on seasonal ingredients.', 'Mon-Sat: 18:00-22:00', 'gourmet_haven.jpg'),
('Pasta Paradise', 'Italian', '456 Oak Ave, Anytown', 'Authentic Italian dishes in a cozy, family-friendly atmosphere.', 'Mon-Sun: 12:00-22:00', 'pasta_paradise.jpg'),
('Spice Route', 'Indian', '789 Pine Ln, Anytown', 'Vibrant flavors of India with traditional and modern interpretations.', 'Tue-Sun: 17:00-23:00', 'spice_route.jpg'),
('Burger Joint', 'American', '101 Elm St, Anytown', 'Classic American burgers, fries, and shakes.', 'Mon-Sun: 11:00-23:00', 'burger_joint.jpg'),
('Sushi Express', 'Japanese', '202 Maple Dr, Anytown', 'Freshly prepared sushi and sashimi for dine-in or takeout.', 'Mon-Sat: 11:30-22:00', 'sushi_express.jpg');

-- Sample Data for reviews (ensure restaurant_id matches existing restaurant ids)
INSERT INTO reviews (restaurant_id, restaurant_name, customer_name, email, rating, review) VALUES
(1, 'The Gourmet Haven', 'Alice Wonderland', 'alice@example.com', 5, 'Absolutely divine food and impeccable service!'),
(1, 'The Gourmet Haven', 'Bob Thebuilder', 'bob@example.com', 4, 'Great ambiance, food was a bit pricey but excellent.'),
(2, 'Pasta Paradise', 'Charlie Chaplin', 'charlie@example.com', 4, 'Delicious pasta, felt like I was in Italy!'),
(3, 'Spice Route', 'Diana Prince', 'diana@example.com', 5, 'The best Indian food I\'ve had in a long time. Highly recommend!'),
(4, 'Burger Joint', 'Eve Adams', 'eve@example.com', 3, 'Decent burger, nothing extraordinary.'),
(5, 'Sushi Express', 'Frank Sinatra', 'frank@example.com', 5, 'Fresh and tasty sushi, will definitely come back!');