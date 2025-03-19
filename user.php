<?php
session_name('admin');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: adminlog.php');
    exit();
}

include 'insert.php'; // Ensure this file contains the database connection

// Fetch registered users
$sql = "SELECT username, email, password FROM user"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Registered Users</title>
    <style>
        body {
            font-size: 20px;
            font-family: 'Poppins';
            margin: 20px;
            background-color: #f4f4f4; /* Light background for contrast */
        }

        h1 {
            text-align: center;
            color: #333; /* Dark text color */
            margin-bottom: 20px; /* Space below the heading */
        }

        table {
            width: 80%; /* Increased width for better visibility */
            margin: 20px auto;
            border-collapse: collapse;
            background: white; /* White background for the table */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }

        th, td {
            padding: 12px; /* Increased padding for better spacing */
            border: 1px solid #ddd; /* Light grey border */
            text-align: center;
        }

        th {
            background-color: #333; /* Darker header background */
            color: white; /* White text color for contrast */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Light grey background for even rows */
        }

        tr:hover {
            background-color: #eaeaea; /* Light grey background on hover */
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
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Back to Home
</a>

<h1>Registered Users</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . str_repeat('*', strlen($row["password"])) . "</td>"; // Display masked password
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>