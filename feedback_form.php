<?php
session_name('user');
session_start(); // Start the session to access session variables
include 'insert.php';  // Your database connection script

// Check if the booking_id is passed through the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Check if the session variable for the username is set
    if (isset($_SESSION['username'])) {
        // Get the logged-in user's username from the session
        $logged_in_username = trim($_SESSION['username']);
    } else {
        header('Location: adminlog.php');
        exit();
    }
} else {
    echo "No booking ID found.";
    exit();
}

// Process the feedback submission when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the feedback input
    $feedback = trim($_POST['feedback']);
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0; // Ensure the rating is an integer

    // Check if the feedback and rating are valid
    if (!empty($feedback) && $rating > 0 && $rating <= 5) {
        // SQL query to insert feedback into the database
        $sql = "INSERT INTO feedback (booking_id, username, feedback, rating) 
                VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters and execute the statement
            $stmt->bind_param("issi", $booking_id, $logged_in_username, $feedback, $rating);
            if ($stmt->execute()) {
                // Redirect user after successful feedback submission
                header('Location: index1.php');  // Change 'thank_you.php' to your desired page
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    } else {
        echo "<p>Please provide both feedback and a rating between 1 and 5.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        form {
            width: 60%; /* Increased width of the form */
            max-width: 600px; /* Set a maximum width */
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s; /* Transition for hover effect */
        }

        form:hover {
            transform: translateY(-5px); /* Lift the form on hover */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #495057;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            resize: none;
            font-size: 14px;
            color: #495057;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating input:checked ~ label,
        .star-rating input:hover ~ label {
            color: #f39c12; /* Yellow color for selected stars */
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
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
    </style>
</head>
<body>

<h2>Leave Your Feedback</h2>

<form method="POST">
    <a href='data.php' class='back-home'> 
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'> 
            <path fill-rule='evenodd' d='M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z'/> 
        </svg> 
        Back to list page 
    </a>
    <label for="rating">Rating (1 to 5):</label>
    <div class="star-rating">
        <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
        <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
        <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
        <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
        <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
    </div>

    <label for="feedback">Your Feedback:</label>
    <textarea id="feedback" name="feedback" required></textarea>

    <input type="submit" value="Submit Feedback">
</form>

</body>
</html>