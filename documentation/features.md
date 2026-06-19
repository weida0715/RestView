# RestView Features Documentation

This document lists the main features available in RestView and explains where each feature is implemented.

## Feature 1: Database Connection Using PDO

| Item           | Details                                                                                                       |
| -------------- | ------------------------------------------------------------------------------------------------------------- |
| Feature Name   | PDO Database Connection                                                                                       |
| File           | `includes/db.php`                                                                                             |
| Page           | All pages that require database access                                                                        |
| How to Perform | Include `includes/db.php` in PHP pages that need database access.                                             |
| Description    | Connects the system to the `fooddb` MySQL database using PDO with exception-based error handling. |

## Feature 2: Restaurant Listing

| Item           | Details                                                                                                                                 |
| -------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Display Restaurant Listings                                                                                                             |
| File           | `index.php`                                                                                                                             |
| Page           | Homepage                                                                                                                                |
| How to Perform | Open `http://localhost/RestView/index.php`.                                                                                             |
| Description    | Displays restaurant thumbnails and basic restaurant information from the database. Each restaurant can be clicked to view full details. |

## Feature 3: Restaurant Thumbnail Display

| Item           | Details                                                                                       |
| -------------- | --------------------------------------------------------------------------------------------- |
| Feature Name   | Restaurant Thumbnails                                                                         |
| File           | `index.php`, `assets/images/`                                                                 |
| Page           | Homepage                                                                                      |
| How to Perform | View the homepage after restaurant records and image paths are available in the database.     |
| Description    | Shows restaurant images or thumbnails to make the listing page more visual and easier to scan. |

## Feature 4: Restaurant Details Page

| Item           | Details                                                                                                           |
| -------------- | ----------------------------------------------------------------------------------------------------------------- |
| Feature Name   | View Full Restaurant Details                                                                                      |
| File           | `restaurant-details.php`                                                                                          |
| Page           | Restaurant details page                                                                                           |
| How to Perform | Click a restaurant from the homepage.                                                                             |
| Description    | Displays full restaurant information using the restaurant ID from the URL, such as `restaurant-details.php?id=1`. |

## Feature 5: Search Restaurant by Name

| Item           | Details                                                                                                                                             |
| -------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Restaurant Search                                                                                                                                   |
| File           | `index.php`                                                                                                                                         |
| Page           | Homepage                                                                                                                                            |
| How to Perform | Enter a restaurant name in the search bar and submit.                                                                                               |
| Description    | Searches restaurants by name using SQL `LIKE` with a PDO prepared statement. Matching results are shown as clickable restaurant cards or links. |

## Feature 6: Cuisine Filter

| Item           | Details                                                                                                     |
| -------------- | ----------------------------------------------------------------------------------------------------------- |
| Feature Name   | Filter by Cuisine                                                                                           |
| File           | `index.php`                                                                                                 |
| Page           | Homepage                                                                                                    |
| How to Perform | Select a cuisine type from the filter dropdown.                                                             |
| Description    | Allows users to filter restaurants by cuisine type. This is an optional enhancement that improves browsing. |

## Feature 7: Sorting Restaurants

| Item           | Details                                                                                                                           |
| -------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Sort Restaurants                                                                                                                  |
| File           | `index.php`                                                                                                                       |
| Page           | Homepage                                                                                                                          |
| How to Perform | Select sorting option such as A-Z or rating.                                                                                      |
| Description    | Allows users to sort restaurants alphabetically or by rating. This improves usability and supports better search browsing. |

## Feature 8: Submit Review Form

| Item           | Details                                                                                                        |
| -------------- | -------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Submit Restaurant Review                                                                                       |
| File           | `submit-review.php`                                                                                            |
| Page           | Submit review page                                                                                             |
| How to Perform | Fill in the review form and click submit.                                                                      |
| Description    | Allows users to submit a review by entering the restaurant name, customer name, email, rating, and review message. |

## Feature 9: JavaScript Form Validation

| Item           | Details                                                                                                     |
| -------------- | ----------------------------------------------------------------------------------------------------------- |
| Feature Name   | Client-Side Review Validation                                                                               |
| File           | `assets/js/validation.js`                                                                                   |
| Page           | Submit review page                                                                                          |
| How to Perform | Try submitting the review form with empty fields or invalid email.                                          |
| Description    | Checks that all required fields are filled and that the email format is valid before the form is submitted. |

## Feature 10: PHP Server-Side Validation

| Item           | Details                                                                                                                    |
| -------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Server-Side Review Validation                                                                                              |
| File           | `submit-review.php`                                                                                                        |
| Page           | Submit review page                                                                                                         |
| How to Perform | Submit the review form. PHP validates the input before inserting into the database.                                        |
| Description    | Ensures that required fields, a valid email, and a valid rating are checked on the server side even if JavaScript is bypassed. |

## Feature 11: Insert Review into Database

| Item           | Details                                                                   |
| -------------- | ------------------------------------------------------------------------- |
| Feature Name   | Save Review                                                               |
| File           | `submit-review.php`                                                       |
| Page           | Submit review page                                                        |
| How to Perform | Submit a valid review form.                                               |
| Description    | Saves review data into the `reviews` table using PDO prepared statements. |

## Feature 12: Display Submitted Review

| Item           | Details                                                                                                                   |
| -------------- | ------------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Review Confirmation Display                                                                                               |
| File           | `submit-review.php`                                                                                                       |
| Page           | Submit review page                                                                                                        |
| How to Perform | Submit a valid review form.                                                                                               |
| Description    | Displays the submitted review information, including restaurant name, customer name, email, rating, review, and timestamp. |

## Feature 13: Display Reviews on Restaurant Details Page

| Item           | Details                                                                                              |
| -------------- | ---------------------------------------------------------------------------------------------------- |
| Feature Name   | Restaurant Review List                                                                               |
| File           | `restaurant-details.php`                                                                             |
| Page           | Restaurant details page                                                                              |
| How to Perform | Open a restaurant details page with existing reviews.                                                |
| Description    | Displays reviews related to the selected restaurant. Reviews are retrieved from the `reviews` table. |

## Feature 14: Average Restaurant Rating

| Item           | Details                                                                                                                 |
| -------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Average Restaurant Rating                                                                                               |
| File           | `restaurant-details.php`, `index.php`                                                                                   |
| Page           | Homepage and restaurant details page                                                                                    |
| How to Perform | View a restaurant that has reviews.                                                                                     |
| Description    | Calculates and displays the average rating for a restaurant using the review records. This is a meaningful enhancement. |

## Feature 15: Edit Restaurant Information

| Item           | Details                                                                                                        |
| -------------- | -------------------------------------------------------------------------------------------------------------- |
| Feature Name   | Edit Restaurant                                                                                                |
| File           | `edit-restaurant.php`                                                                                          |
| Page           | Edit restaurant page                                                                                           |
| How to Perform | Open `edit-restaurant.php?id=X`, update the form, and submit.                                                  |
| Description    | Displays existing restaurant data and allows the restaurant name, cuisine type, and description to be updated. |

## Feature 16: Redirect After Update

| Item           | Details                                                                                                                        |
| -------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| Feature Name   | Redirect After Successful Edit                                                                                                 |
| File           | `edit-restaurant.php`                                                                                                          |
| Page           | Edit restaurant page                                                                                                           |
| How to Perform | Successfully update restaurant information.                                                                                    |
| Description    | Redirects the user back to the restaurant details page after the update is completed. This helps prevent duplicate form submission. |

## Feature 17: Delete Review

| Item           | Details                                                                                         |
| -------------- | ----------------------------------------------------------------------------------------------- |
| Feature Name   | Delete Review                                                                                   |
| File           | `delete-review.php`                                                                             |
| Page           | Restaurant details page                                                                         |
| How to Perform | Click the delete button beside a review.                                                        |
| Description    | Optional enhancement that allows a review to be deleted from the database using a POST request. |

## Feature 18: Reusable Header

| Item           | Details                                                                      |
| -------------- | ---------------------------------------------------------------------------- |
| Feature Name   | Common Header                                                                |
| File           | `includes/header.php`                                                        |
| Page           | All main pages                                                               |
| How to Perform | Include the header file using PHP `include`.                                 |
| Description    | Provides a reusable page header and navigation area to reduce repeated code. |

## Feature 19: Reusable Footer

| Item           | Details                                                                     |
| -------------- | --------------------------------------------------------------------------- |
| Feature Name   | Common Footer                                                               |
| File           | `includes/footer.php`                                                       |
| Page           | All main pages                                                              |
| How to Perform | Include the footer file using PHP `include`.                                |
| Description    | Provides a reusable footer section for consistent layout across the system. |

## Feature 20: Responsive Styling

| Item           | Details                                                                                                   |
| -------------- | --------------------------------------------------------------------------------------------------------- |
| Feature Name   | Responsive User Interface                                                                                 |
| File           | `assets/css/style.css`                                                                                    |
| Page           | All pages                                                                                                 |
| How to Perform | Open the system on different screen sizes.                                                                |
| Description    | Uses CSS to make restaurant cards, forms, and page layout readable and usable on different screen widths. |

## Feature 21: Error and Success Messages

| Item           | Details                                                                                             |
| -------------- | --------------------------------------------------------------------------------------------------- |
| Feature Name   | Feedback Messages                                                                                   |
| File           | `submit-review.php`, `edit-restaurant.php`, `index.php`                                             |
| Page           | Review form, edit form, homepage                                                                    |
| How to Perform | Perform actions such as submitting invalid input or updating restaurant data.                       |
| Description    | Displays helpful messages when actions succeed or fail. This improves usability and error handling. |

## Feature 22: Safe Output Display

| Item           | Details                                                                                                   |
| -------------- | --------------------------------------------------------------------------------------------------------- |
| Feature Name   | Output Escaping                                                                                           |
| File           | All PHP files that display database content                                                               |
| Page           | All dynamic pages                                                                                         |
| How to Perform | View restaurant or review data on the page.                                                               |
| Description    | Uses `htmlspecialchars()` when displaying database content to reduce the risk of unwanted HTML injection. |
