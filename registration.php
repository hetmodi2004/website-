<?php
session_name('user');
session_start();
include 'insert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $errors = [];

    // Validation
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    if (empty($confirmPassword)) {
        $errors['confirm_password'] = "Confirm Password is required.";
    } elseif ($password !== $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        // Insert into the database
        $sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to login page
            header('Location: login.php');
            exit(); // Always call exit after a header redirect
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins';
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 20px; /* Reduced padding */
            border-radius: 12px;
            width: 700px; /* Match the width of the login form */
            display: flex; /* Change to flex to make it horizontal */
            align-items: center; /* Center items vertically */
            justify-content: space-between; /* Space between logo and form */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .logo-container {
            flex: 1;
            text-align: center;
        }

        .logo {
            max-width: 250px;
            height: auto;
        }

        .form-content {
            flex: 2; /* Allow form content to take more space */
            padding-left: 20px; /* Keep some padding */
        }

        h2 {
            color: #333;
            margin-bottom: 15px; /* Reduced margin */
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            color: #555;
            display: block;
            margin-bottom: 5px; /* Reduced margin */
        }

        .form-group input {
            width: 100%;
            padding: 10px; /* Reduced padding */
            margin-bottom: 5px; /* Reduced margin */
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px; /* Reduced padding */
            width: 100%;
            border-radius: 25px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .eye-icon {
            margin-left: -30px; /* Adjust position of the eye icon */
            cursor: pointer; /* Change cursor to pointer */
        }

        a {
            display: block; /* Make the link a block element */
            margin-top: 20px; /* Add gap between password field and link */
            text-align: center; /* Center the link */
            color: #007bff; /* Link color */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Smooth transition for color */
        }

        a:hover {
            color: #0056b3; /* Darker color on hover */
        }

        .error-message {
            color: black; /* Change error message color to black */
            font-size: 14px; /* Error message font size */
            margin-top: 5px; /* Space above error message */
            text-align: left; /* Align error messages to the left */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo-container">
            <img src="./uploads/logo.png" alt="Decoration Company Logo" class="logo"> <!-- Update the logo path -->
        </div>
        <div class="form-content">
            <h2>Registration Form</h2>
            <form id="registrationForm" action="" method="POST">
                <div class="form-group">
                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="username" required>
                    <?php if (isset($errors['username'])): ?>
                        <span class="error-message"><?php echo $errors['username']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group password-container">
                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="password" required>
                    <span class="eye-icon" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error-message"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group password-container">
                    <label for="confirm_password"></label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="confirm password"  required>
                    <span class="eye-icon" id="toggleConfirmPassword">
                        <i class="fas fa-eye"></i>
                    </span>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email"></label>
                    <input type="email" id="email" name="email"placeholder="email"  required>
                    <?php if (isset($errors['email'])): ?>
                        <span class="error-message"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit">Register</button>
                <a href="./login.php">Already have an account? Login here</a>
            </form>
        </div>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
        });

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirm_password');

        toggleConfirmPassword.addEventListener('click', () => {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            toggleConfirmPassword.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>