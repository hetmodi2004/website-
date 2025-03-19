<?php
session_name('admin');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim to remove any extra spaces
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $defaultUsername = 'hetmodi'; 
    $defaultPassword = 'het2004'; 

    if (strcasecmp($username, $defaultUsername) === 0 && $password === $defaultPassword) {
        $_SESSION['loggedin1'] = true;
        $_SESSION['username'] = $username;

        header("Location: admin.php"); 
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins';
            background: linear-gradient(to right, #e2e2e2, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px; /* Adjusted padding */
            border-radius: 12px;
            width: 500px; /* Adjusted width */
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.2);
            display: flex; /* Flexbox for horizontal layout */
            align-items: center; /* Center items vertically */
            transition: transform 0.3s, box-shadow 0.3s; /* Transition for hover effect */
        }

        .login-container:hover {
            transform: scale(1.02); /* Slightly scale up on hover */
            box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.3); /* Increase shadow on hover */
        }

        .logo {
            max-width: 150px; 
            margin-right: 20px; 
        }

        .form-container {
            flex-grow: 1; /* Allow form to take remaining space */
            text-align: left; /* Align text to the left */
        }

        h2 {
            color: #333333;
            margin-bottom: 20px;
            animation: blink 1s infinite;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #dcdcdc;
            border-radius: 25px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s, background-color 0.3s;
            cursor: pointer; /* Change cursor on hover */
        }

        .input-field:hover {
            background-color: #ececec;
        }

        .input-field:focus {
            border-color: #007bff;
            background-color: #ffffff;
            outline: none;
        }

        .btn-login {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 25px;
            font-size: 18px;
            cursor: pointer; /* Change cursor on hover */
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-login:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            cursor: pointer; /* Ensure cursor changes on hover */
        }

        .message {
            padding: 10px;
            margin-top: 15px;
            font-size: 14px;
            color: white;
            border-radius: 5px;
        }

        .error-message {
            background-color: #dc3545;
        }

        .password-container {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #007bff;
            font-size: 18px;
            transition: color 0.3s;
            z-index: 1;
        }

        .eye-icon:hover {
            color: #0056b3;
        }

        .eye-icon .fa-eye-slash {
            color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <img src="./uploads/logo.png" alt="Decoration Company Logo" class="logo">

        <div class="form-container">
            <h2>ADMIN LOGIN</h2>

            <!-- Show error message if username or password is wrong -->
            <?php if (isset($error)) { ?>
                <div id="errorMessage" class="message error-message">
                    <?= $error ?>
                </div><br>
            <?php } ?>

            <form id="loginForm" action="adminlog.php" method="POST">
                <input type="text" id="username" name="username" class="input-field" placeholder="Username" required>
                <div class="password-container">
                    <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
                    <span class="eye-icon" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.firstElementChild.classList.toggle('fa-eye-slash'); 
        });
    </script>

</body>

</html>