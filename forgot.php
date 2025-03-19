<?php
session_start();
include "insert.php"; // Ensure this file correctly connects to your database

$error = ""; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email'])); // Prevent SQL injection and trim whitespace

    $sql = "SELECT email FROM user WHERE email = '$email'";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Query failed: " . mysqli_error($conn)); // Display SQL error (for debugging)
    }

    if (mysqli_num_rows($res) > 0) {
        $_SESSION['email'] = $email; // Store email in session
        $email = $_SESSION['email'];
    
        include('smtp/PHPMailerAutoload.php');
        
        $otp1 = rand(11111,99999);
        
        $sql1 = "UPDATE user SET otp='$otp1' WHERE email='$email'";
        
        $res1 = @mysqli_query($conn, $sql1);
    
        function smtp_mailer($to, $subject, $msg) {
            $mail = new PHPMailer(); 
            $mail->IsSMTP(); 
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587; 
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            //$mail->SMTPDebug = 2; 
            $mail->Username = "hetmodi206@gmail.com";
            $mail->Password = "kgzfghnsbsozeoku";
            $mail->SetFrom("hetmodi206@gmail.com");
            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->AddAddress($to);
            $mail->SMTPOptions = array('ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false
            ));
            if (!$mail->Send()) {
                echo $mail->ErrorInfo;
            }
        }
        
        smtp_mailer($email, 'OTP Verification', 'Your one-time OTP is <br> <h1>' . $otp1 . '</h1>');
        header("Location: change.php?email=" . urlencode($email)); // Redirect with a properly formatted URL
        exit(); // Ensure script stops execution after redirection
    } else {
        $error = "Invalid email or account does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
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
        text-align: center;
        color: #444;
        margin-bottom: 20px;
        font-size: 24px;
    }

    label {
        display: block;
        font-size: 16px;
        color: #555;
        text-align: left;
        margin-bottom: 5px;
    }

    input[type="email"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    input[type="email"]:focus {
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

    .error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
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
    <a href="login.php" class="back-home"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> 
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/> 
        </svg> 
            Back to login 
        </a> 
        <h2>Add Email</h2>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name ="email" required>
            <button type="submit">Submit</button>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
