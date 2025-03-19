<?php
include 'insert.php';  // Your database connection script


// Fetch all feedbacks from the database
$sql = "SELECT username, feedback, rating FROM feedback ";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("SQL error: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Feedbacks</title>
    <style>
        body {
            font-size:20px;
            font-family: 'Poppins';
            margin: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .rating {
            color: #f39c12;
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
<a href="admin.php" class="back-home">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
    </svg> Back to Home
</a>

<h2>Customer Feedback</h2>

<table>
    <tr>
        <th>Username</th>
        <th>Feedback</th>
        <th>Rating</th>
    </tr>

    <?php
    // Display all feedback records
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['feedback']}</td>
                    <td><span class='rating'>" . str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) . "</span></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>No feedbacks available.</td></tr>";
    }
    ?>

</table>

</body>
</html>
