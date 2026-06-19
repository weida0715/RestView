document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        const review = document.getElementById('review_message');
        const wordCount = document.getElementById('reviewWordCount');
        const wordLimit = review ? parseInt(review.dataset.wordLimit || '500', 10) : 500;

        const updateWordCount = () => {
            const count = review.value.trim() ? review.value.trim().split(/\s+/).length : 0;
            if (wordCount) {
                wordCount.textContent = count;
            }
            review.classList.toggle('is-over-limit', count > wordLimit);
        };

        if (review) {
            updateWordCount();
            review.addEventListener('input', updateWordCount);
        }

        reviewForm.addEventListener('submit', function(event) {
            let isValid = true;

            const customerName = document.getElementById('customer_name');
            const email = document.getElementById('email');
            const rating = document.querySelector('input[name="rating"]:checked');
            const ratingFieldset = document.querySelector('.rating-fieldset');

            // Clear previous error messages
            document.querySelectorAll('.field-error').forEach(el => el.remove());

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

            if (!rating) {
                displayError(ratingFieldset, 'Rating is required.');
                isValid = false;
            }

            const reviewCount = review.value.trim() ? review.value.trim().split(/\s+/).length : 0;
            if (review.value.trim() === '') {
                displayError(review, 'Review message cannot be empty.');
                isValid = false;
            } else if (reviewCount > wordLimit) {
                displayError(review, `Review message must be ${wordLimit} words or fewer.`);
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    }

    function displayError(inputElement, message) {
        if (!inputElement || !inputElement.parentNode) {
            return;
        }
        let errorElement = inputElement.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('field-error')) {
            errorElement = document.createElement('span');
            errorElement.classList.add('field-error');
            inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
        }
        errorElement.textContent = message;
    }

    function isValidEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});
