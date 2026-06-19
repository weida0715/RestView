# RestView Project Documentation

## 1. System Explanation

**RestView** is a restaurant listing and review system built using PHP, HTML, CSS, JavaScript, SQL, and MySQL through XAMPP.

The system allows users to browse restaurants, search for restaurants by name, view restaurant details, submit reviews, and edit restaurant information.

The system uses a MySQL database named `fooddb`. PHP connects to the database using PDO. PDO prepared statements are used for database operations to improve security and prevent SQL injection.

## 2. System Objectives

The objectives of RestView are:

1. To display restaurant listings from a MySQL database.
2. To allow users to view full restaurant details.
3. To allow users to search restaurants by name.
4. To allow users to submit restaurant reviews.
5. To validate review forms using JavaScript and PHP.
6. To store review data securely using PDO.
7. To allow restaurant information to be edited.
8. To provide a simple and clean user interface.

## 3. Technologies Used

The project uses only the following technologies:

* PHP
* HTML
* CSS
* JavaScript
* SQL
* MySQL
* XAMPP

## 4. Project Folder Structure

```text
RestView/
│
├── index.php
├── restaurant-details.php
├── submit-review.php
├── edit-restaurant.php
├── delete-review.php
│
├── includes/
│   ├── db.php
│   ├── header.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── validation.js
│   └── images/
│
├── database/
│   └── fooddb.sql
│
└── documentation/
    ├── project-documentation.md
    └── features.md
```

## 5. Database Explanation

The system uses the database:

```text
fooddb
```

The database contains two main tables:

### restaurants

This table stores restaurant information.

Fields:

* `id`
* `name`
* `cuisine_type`
* `location`
* `description`
* `opening_hours`
* `image`

### reviews

This table stores customer reviews.

Fields:

* `id`
* `restaurant_id`
* `restaurant_name`
* `customer_name`
* `email`
* `rating`
* `review`
* `created_at`

## 6. Main Pages Explanation

### index.php

This is the homepage of RestView.

It displays restaurant thumbnails and basic restaurant information. Users can search restaurants by name and click on a restaurant to view full details.

### restaurant-details.php

This page displays full details of a selected restaurant.

The restaurant is selected using an ID in the URL.

Example:

```text
restaurant-details.php?id=1
```

This page also displays reviews and average rating.

### submit-review.php

This page allows users to submit a review for a restaurant.

The form collects:

* Restaurant name
* Customer name
* Email
* Rating
* Review

The form is validated using JavaScript before submission and PHP after submission.

### edit-restaurant.php

This page allows restaurant information to be edited.

The page loads current restaurant data using the restaurant ID.

Example:

```text
edit-restaurant.php?id=1
```

The editable fields are:

* Restaurant name
* Cuisine type
* Description

After successful update, the system redirects the user to the restaurant details page.

### delete-review.php

This is an optional feature file used to delete a review.

The delete action should use POST for safer data handling.

## 7. Setup Instructions

The project is developed and deployed locally on a Windows machine using XAMPP.

### Step 1: Install XAMPP

Download and install XAMPP for Windows.

After installation, open the XAMPP Control Panel.

Start the following services:

```text
Apache
MySQL
```

### Step 2: Move Project Folder

Copy the `RestView` folder into the XAMPP `htdocs` directory.

Example path:

```text
C:\xampp\htdocs\RestView
```

### Step 3: Open phpMyAdmin

Open a browser and go to:

```text
http://localhost/phpmyadmin
```

### Step 4: Create Database

Create a new database named:

```text
fooddb
```

### Step 5: Import SQL File

Import the database file located at:

```text
RestView/database/fooddb.sql
```

This will create the required tables and sample restaurant records.

### Step 6: Configure Database Connection

Open:

```text
includes/db.php
```

Make sure the database settings are correct for XAMPP:

```php
$host = "localhost";
$dbname = "fooddb";
$username = "root";
$password = "";
```

XAMPP usually uses `root` as the username and an empty password by default.

### Step 7: Run the Project

Open the browser and go to:

```text
http://localhost/RestView/index.php
```

The RestView homepage should appear.

## 8. How to Use the System

### Browse Restaurants

Open:

```text
http://localhost/RestView/index.php
```

The restaurant list will be displayed.

### Search Restaurant

Use the search bar on the homepage.

Enter a restaurant name or part of a name, then submit the search.

### View Restaurant Details

Click on a restaurant card or thumbnail.

The system opens:

```text
restaurant-details.php?id=X
```

### Submit Review

Open the submit review page from the restaurant details page.

Fill in all required fields and submit the form.

### Edit Restaurant

Open the edit page from the restaurant details page.

Update the restaurant name, cuisine type, or description.

Submit the form to save changes.

## 9. Validation Explanation

RestView uses two types of validation.

### JavaScript Validation

JavaScript checks the form before it is submitted.

It checks:

* Required fields
* Valid email format
* Rating selection

### PHP Validation

PHP validates the data again on the server side.

It checks:

* Empty fields
* Valid email format
* Valid rating value
* Safe input before database insertion

## 10. Security Explanation

RestView applies the following security practices:

1. PDO is used for database connection.
2. Prepared statements are used for SQL queries.
3. PHP validation is applied before database insertion.
4. Output is escaped using `htmlspecialchars()`.
5. Database errors are handled using try-catch blocks.

## 11. Design Decisions

### Minimal Layout

The design is intentionally simple so users can browse, search, review, and edit restaurants without confusion.

### Modular PHP Files

The database connection, header, and footer are separated into reusable files.

This avoids repeated code.

### Prepared Statements

Prepared statements are used for all database queries involving user input.

This improves security.

### JavaScript and PHP Validation

Both client-side and server-side validation are used.

JavaScript improves user experience, while PHP protects the server.

### Local XAMPP Deployment

The project is designed for XAMPP because the development and deployment environment is assumed to be a Windows machine.

## 12. Limitations

RestView does not include:

* User login
* Admin dashboard
* Online deployment
* Payment system
* Video documentation

These are not required for the code-based mini project scope.

## 13. Conclusion

RestView is a lightweight restaurant listing and review system that fulfills the required features using PHP, HTML, CSS, JavaScript, SQL, MySQL, and XAMPP. The system is simple, organized, secure, and suitable for local development and testing.