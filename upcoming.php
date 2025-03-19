<?php
// Start the session
session_name('admin');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: adminlog.php');
    exit();
}

// Include your database connection file
include 'insert.php'; // Ensure this file contains the correct database connection code

$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['eventTitle']);
    $event_date = htmlspecialchars($_POST['eventDate']);
    $description = htmlspecialchars($_POST['eventDescription']);

    // Check if the event date is valid
    if (strtotime($event_date) < time() || (strtotime($event_date) < strtotime("+2 months"))) {
        $errorMessage = "Error: Event date must be at least two months from the current date.";
    } else {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO event (title, event_date, description) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $title, $event_date, $description);

            if ($stmt->execute()) {
                $successMessage = "New event added successfully!";
                $stmt->close();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
        } else {
            $errorMessage = "Error preparing statement: " . $conn->error;
        }
    }
}

// Fetch upcoming events, filtering out past events
$sql = "SELECT title, event_date, description FROM event WHERE event_date >= NOW()";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Manage Upcoming Events</title>
    <style>
        body {
            font-size: 20px;
            font-family: 'Poppins';
            background-color: #f0f4f8;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1abc9c;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #1abc9c;
            border-color: #16a085;
        }

        .btn-primary:hover {
            background-color: #16a085;
            border-color: #149174;
        }

        table {
            margin-top: 30px;
            width: 100%;
            overflow-y: auto;
            display: block;
            max-height: 300px; /* Set a maximum height for the table */
        }

        th,
        td {
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d9d9d9;
        }

        .alert {
            margin-top: 20px;
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
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
    <script>
        function validateDate() {
            const eventDateInput = document.getElementById('eventDate');
            const eventDate = new Date(eventDateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

            // Calculate the date two months from today
            const twoMonthsFromNow = new Date();
            twoMonthsFromNow.setMonth(today.getMonth() + 2);

            const errorMessageDiv = document.getElementById('error-message');
            const submitButton = document.querySelector('button[type="submit"]');

            if (eventDate < twoMonthsFromNow) {
                errorMessageDiv.textContent = "Error: Event date must be at least two months from the current date.";
                submitButton.disabled = true; // Disable the submit button
            } else {
                errorMessageDiv.textContent = ""; // Clear the error message
                submitButton.disabled = false; // Enable the submit button
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('eventDate').addEventListener('change', validateDate);
        });
    </script>
</head>

<body>
    <div class="container">
        <a href="admin.php" class="back-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
            </svg> Back to Home
        </a>
        <h1>Add Upcoming Event</h1>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="eventTitle">Event Title:</label>
                <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date:</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                <div id="error-message" class="error-message"></div> <!-- Error message area -->
            </div>
            <div class="form-group">
                <label for="eventDescription">Event Description:</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
    </div>

    <div class="container">
        <h1>Upcoming Events</h1>

        <div style="overflow-y: auto; max-height: 300px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Event Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['event_date']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No upcoming events available.</td></tr>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
        <div class="alert alert-danger">
            <?php echo $errorMessage; ?>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>