<?php
session_name('admin');
session_start();

// Set the session timeout (15 minutes)
$session_lifetime = 15 * 60; // 15 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_lifetime) {
    // If the session has expired, destroy the session and redirect to login
    session_unset();
    session_destroy();
    header("Location: adminlog.php");
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity time to current time

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['loggedin1']) || $_SESSION['loggedin1'] !== true) {
    header("Location: adminlog.php");
    exit();
}

// Define the admin username
$admin_username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';

// Include database connection
include 'insert.php'; // Ensure this file handles database connection without closing it.

// Get the total number of packages
$sql = "SELECT COUNT(*) AS total_packages FROM package"; 
$result = $conn->query($sql);
$total_packages = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_packages'] : 0;

// Get the total number of users
$sql = "SELECT COUNT(*) AS total_users FROM user";
$result = $conn->query($sql);
$total_users = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_users'] : 0;

// Get total events for the graph
$sql = "SELECT COUNT(*) AS total_events FROM package"; // Assuming 'package' represents events
$result = $conn->query($sql);
$total_events = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_events'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-size: 20px;
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .hamburger {
            font-size: 24px;
            cursor: pointer;
            color: white;
            background: none;
            border: none;
        }

        .dashboard-title {
            font-size: 20px;
            color: white;
            margin: 0;
        }

        .welcome-message {
            font-size: 25px;
            color: #333;
            padding: 10px 20px;
            text-align: left;
            margin-top: 5px;
            transition: margin-top 0.3s; /* Transition for smooth movement */
        }

        .welcome-message.shifted {
            margin-top: 50px; /* Adjust the value as needed */
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            left: 0;
            width: 100%;
            background-color: #333;
            flex-wrap: wrap;
            padding: 10px 0;
        }

        .dropdown a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            display: inline-block;
        }

        .dropdown a:hover {
            background-color: #444;
        }

        .logout-btn {
            background-color: red; /* Set background color to red */
            color: white; /* Set text color to white */
            padding: 10px 20px; /* Add padding for better appearance */
            border-radius: 5px; /* Round the corners */
            text-align: center; /* Center the text */
            display: inline-block; /* Make it behave like a button */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .logout-btn:hover {
            background-color: darkred; /* Darker red on hover */
        }

        .admin-dashboard {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .counts-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 0 0 150px;
        }

        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .box h2 {
            margin: 0;
            font-size: 35px;
            color: #333;
        }

        .box p {
            font-size: 36px;
            color: #666;
            background-color: #f0f0f0;
            padding: 5px;
            border-radius: 5px;
            width: fit-content;
            margin: 0 auto 10px auto;
        }

        .content-container {
            flex: 1;
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .chart-container-wrapper {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 70px;
        }

        .chart-container {
            width: 300px;
            height: 240px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <button class="hamburger" onclick="toggleDropdown()">☰   MENU</button>
        <h1 class="dashboard-title">ADMIN DASHBOARD</h1>
    </div>

    <div class="welcome-message" id="welcome-message">
        <p>Welcome, <?php echo $admin_username; ?>!</p>
    </div>

    <div class="dropdown" id="dropdown">
        <a href="./list.php"><i class="fas fa-list"></i> Package List</a>
        <a href="./user.php"><i class="fas fa-users"></i> Registered Users</a>
        <a href="./customer.php"><i class="fas fa-calendar-check"></i> Booking Details</a>
        <a href="./upcoming.php"><i class="fas fa-calendar-alt"></i> Upcoming Events</a>
        <a href="./total.php"><i class="fas fa-chart-pie"></i> Overall Details</a>
        <a href="./show_feedback.php"><i class="fas fa-comments"></i> Feedback Details</a>
        <a href="./profile.php"><i class="fas fa-user"></i> Admin Profile</a>
        <a href="./adminout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="admin-dashboard">
        <div class="counts-container">
            <div class="box">
                <h2>TOTAL EVENTS</h2>
                <p><?php echo $total_packages; ?></p>
            </div>
            <div class="box">
                <h2>TOTAL USERS</h2>
                <p><?php echo $total_users; ?></p>
            </div>
        </div>

        <div class="content-container">
            <h2>Total Events Stats</h2>
            <div class="chart-container-wrapper">
                <div class="chart-container">
                    <canvas id="eventsChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Total Events Stats Chart
            var totalEvents = <?php echo json_encode($total_events); ?>;

            new Chart(document.getElementById('eventsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Total Events'],
                    datasets: [{
                        label: 'Total Events',
                        data: [totalEvents],
                        backgroundColor: 'rgba(46, 204, 113, 0.2)',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        borderWidth: 2,
                        barThickness: 200 // Set the thickness of the bar
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Adjust step size as needed
                            }
                        }
                    }
                }
            });

            // Total Users Stats Chart
            var totalUsers = <?php echo json_encode($total_users); ?>;

            new Chart(document.getElementById('usersChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Total Users'],
                    datasets: [{
                        label: 'Total Users',
                        data: [totalUsers],
                        backgroundColor: 'rgba(52, 152, 219, 0.2)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 2,
                        barThickness: 200 // Set the thickness of the bar
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Adjust step size as needed
                            }
                        }
                    }
                }
            });
        });

        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            var welcomeMessage = document.getElementById('welcome-message'); // Get the welcome message element
            var isDropdownVisible = dropdown.style.display === 'flex';

            // Toggle the visibility of the dropdown
            dropdown.style.display = isDropdownVisible ? 'none' : 'flex';

            // Toggle the shifted class on the welcome message
            if (isDropdownVisible) {
                welcomeMessage.classList.remove('shifted');
            } else {
                welcomeMessage.classList.add('shifted');
            }
        }
    </script>
</body>
</html>