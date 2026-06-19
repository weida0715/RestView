document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(event) {
            let isValid = true;

            const customerName = document.getElementById('customer_name');
            const email = document.getElementById('email');
            const rating = document.getElementById('rating');
            const review = document.getElementById('review_message');

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            if (customerName.value.trim() === '') {
                displayError(customerName, 'Customer name is required.');
                isValid = false;
            }

            if (email.value.trim() === '') {
                displayError(email, 'Email is required.');
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                displayError(email, 'Please enter a valid email address.');
                isValid = false;
            }

            if (rating.value === '') {
                displayError(rating, 'Rating is required.');
                isValid = false;
            }

            if (review.value.trim() === '') {
                displayError(review, 'Review message cannot be empty.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    }

    function displayError(inputElement, message) {
        let errorElement = inputElement.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error-message')) {
            errorElement = document.createElement('span');
            errorElement.classList.add('error-message');
            inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
        }
        errorElement.textContent = message;
    }

    function isValidEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});