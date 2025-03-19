<?php
session_name('user');
session_start();

require 'insert.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header('Location: index1.php');
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
            padding: 40px;
            border-radius: 12px;
            width: 700px;
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
            margin-bottom: 20px;
            font-weight: 600; /* Bold font for the heading */
            text-align: center; /* Center the heading */
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease; /* Smooth transition for border color */
        }

        .form-group input:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 14px;
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
            color: #0056b3; /* Change color on hover */
        }

        .error {
            color: red; /* Error message color */
            font-size: 14px; /* Error message font size */
            margin-top: -10px; /* Adjust margin for error message */
            margin-bottom: 10px; /* Space below error message */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo-container">
            <img src="./uploads/logo.png" alt="Decoration Company Logo" class="logo">
        </div>
        <div class="form-content">
            <h2>Login Form</h2>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form id="loginForm" action="#" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="username" required>
                    <span class="error" id="usernameError"></span>
                </div>

                <div class="form-group password-container">
                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="password" required>
                    <span class="eye-icon" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                    <span class="error" id="passwordError"></span>
                </div>

                

                <button type="submit">Login</button>
                <a href="registration.php">Don't have an account? Register here</a>
                <a href="forgot.php" > Forgot password <a>
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

        function validateForm() {
            let valid = true;
            document.getElementById('usernameError').innerText = '';
            document.getElementById('passwordError').innerText = '';

            const username = document.getElementById('username').value.trim();
            if (username === '') {
                document.getElementById('usernameError').innerText = 'Username is required.';
                valid = false;
            }

            const password = passwordInput.value.trim();
            if (password === '') {
                document.getElementById('passwordError').innerText = 'Password is required.';
                valid = false;
            } else if (password.length < 6) {
                document.getElementById('passwordError').innerText = 'Password must be at least 6 characters.';
                valid = false;
            }

            return valid;
        }
    </script>
</body>
</html>