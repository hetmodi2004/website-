<?php
session_start();
include "insert.php"; // Database connection file

$message = ""; // Message to display feedback

if (!isset($_SESSION['email'])) {
    echo "No email found in session.";
    exit();
}

if (isset($_POST['submit'])) {
    $email = $_SESSION['email'];
    $entered_otp = $_POST['otp'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm'];

    // Validate password match
    if ($new_pass !== $confirm_pass) {
        $message = "<div class='error'>Passwords do not match</div>";
    } else {
        // Fetch OTP from the database
        $sql = "SELECT otp FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $db_otp = $row['otp'];

            // Check if OTP matches
            if ($entered_otp == $db_otp) {
                // Store the new password in plain text
                $update_sql = "UPDATE user SET password = ?, otp = NULL WHERE email = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $new_pass, $email);
                
                if ($update_stmt->execute()) {
                    $message = "<div class='success'>Password changed successfully</div>";
                } else {
                    $message = "<div class='error'>Failed to update password</div>";
                }
            } else {
                $message = "<div class='error'>Invalid OTP</div>";
            }
        } else {
            $message = "<div class='error'>User  not found</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient background */
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 380px;
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        }

        h2 {
            color: #444;
            margin-bottom: 20px;
            font-size: 24px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error, .success {
            text-align: center;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .back-home {
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .back-home:hover {
            color: #007BFF;
        }

        .back-home svg {
            margin-right: 8px;
            fill: currentColor;
            transition: transform 0.3s;
        }

        .back-home:hover svg {
            transform: translateX(-3px);
        }

        /* Floating bubbles effect */
        .form-container::before, .form-container::after {
            content: "";
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            z-index: -1;
            animation: floatAnimation 6s infinite ease-in-out alternate;
        }

        .form-container::before {
            top: -20px;
            left: -20px;
        }

        .form-container::after {
            bottom: -20px;
            right: -20px;
            animation-delay: 3s;
        }

        @keyframes floatAnimation {
            from {
                transform: translateY(0px);
            }
            to {
                transform: translateY(15px);
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <a href="forgot.php" class="back-home"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> 
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/> 
            </svg> 
            Back
        </a> 
        <h2>OTP Verification</h2>
        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <input type="password" name="new_pass" placeholder="New Password" required>
            <input type="password" name="confirm" placeholder="Confirm Password" required>
            <button type="submit" name="submit">Submit</button>
        </form>
        <?php if (!empty($message)): ?>
            <?php echo $message; ?>
        <?php endif; ?>
    </div>

</body>
</html>