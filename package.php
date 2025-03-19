<?php
session_name('user');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'insert.php'; 

$sql = "SELECT id, package_name, package_price, package_description, package_image FROM package";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Available Packages</title>
    <style>
        body {
            font-family: 'Georgia ';
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .package {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .package:hover {
            background-color: #fafafa;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .package img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .package:hover img {
            transform: scale(1.08); 
            opacity: 0.85; 
        }

        .package h3 {
            font-size: 22px;
            margin: 10px 0;
            color: #34495e;
        }

        .package-price {
            color: #27ae60;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .package-description {
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            color: #fff;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
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
<div class="container">
   <u><h2>Available Decoration Packages</h2></u>
   <a href="index1.php" class="back-home">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Back to home 
   </a>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='package' data-id='" . $row['id'] . "'>";
            if (!empty($row['package_image'])) {
                echo "<img src='uploads/" . htmlspecialchars($row['package_image']) . "' alt='" . htmlspecialchars($row['package_name']) . "'>";
            }
            echo "<h3>" . htmlspecialchars($row['package_name']) . "</h3>";
            echo "<p class='package-price'>Price: ₹" . number_format($row['package_price'], 2) . "</p>";
            echo "<p class='package-description'>" . htmlspecialchars($row['package_description']) . "</p><br>";
            echo "<a href='booking.php?package_name=" . urlencode($row['package_name']) . "' class='btn btn-primary'>Book Package</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No packages found.</p>";
    }
    $conn->close(); // Close the database connection
    ?>
</div>
</body>
</html>
