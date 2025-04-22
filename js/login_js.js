document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form');
    const emailInput = document.querySelector('input[type="email"]');
    const passwordInput = document.querySelector('input[type="password"]');
    
    // Function to validate email format
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Function to display error
    function showError(input, message) {
        const formGroup = input.parentElement;
        
        // Remove any existing error message
        const existingError = formGroup.querySelector('.error-message');
        if (existingError) {
            formGroup.removeChild(existingError);
        }
        
        // Create and append error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.color = '#ff3333';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '5px';
        errorDiv.style.textAlign = 'left';
        formGroup.appendChild(errorDiv);
        
        // Add red border to input
        input.style.borderColor = '#ff3333';
    }
    
    // Function to clear error
    function clearError(input) {
        const formGroup = input.parentElement;
        const existingError = formGroup.querySelector('.error-message');
        if (existingError) {
            formGroup.removeChild(existingError);
        }
        input.style.borderColor = '';
    }
    
    // Form submission handler
    loginForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Clear previous errors
        clearError(emailInput);
        clearError(passwordInput);
        
        // Validate email
        if (emailInput.value.trim() === '') {
            showError(emailInput, 'Email is required');
            isValid = false;
        } else if (!isValidEmail(emailInput.value.trim())) {
            showError(emailInput, 'Please enter a valid email');
            isValid = false;
        }
        
        // Validate password
        if (passwordInput.value.trim() === '') {
            showError(passwordInput, 'Password is required');
            isValid = false;
        }
        
        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        } else {
            // Form is valid - you can add AJAX submission here
            console.log('Form submitted successfully');
            // Uncomment below line to allow normal form submission
            // return true;
        }
    });
    
    // Clear errors when user starts typing
    emailInput.addEventListener('input', function() {
        clearError(emailInput);
    });
    
    passwordInput.addEventListener('input', function() {
        clearError(passwordInput);
    });
});