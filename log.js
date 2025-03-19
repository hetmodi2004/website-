<script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous errors
            document.getElementById('usernameError').textContent = '';
            document.getElementById('passwordError').textContent = '';

            // Username validation
            let username = document.getElementById('username').value;
            if (username.trim() === '') {
                document.getElementById('usernameError').textContent = 'Username is required';
                isValid = false;
            }

            // Password validation
            let password = document.getElementById('password').value;
            if (password.trim() === '') {
                document.getElementById('passwordError').textContent = 'Password is required';
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>