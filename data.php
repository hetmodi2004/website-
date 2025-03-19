<?php
session_name('user');
session_start(); // Start the session to access session variables
include 'insert.php';

// Check if the session variable for the username is set
if (isset($_SESSION['username'])) {
    // Get the logged-in user's username from the session and trim whitespace
    $logged_in_username = trim($_SESSION['username']);

    // SQL query to fetch package bookings for the logged-in user, including payment_status
    $sql = "SELECT customer_name, package_id, package_name, event_date, status, payment_status 
            FROM booking 
            WHERE TRIM(customer_name) = ?"; // Use TRIM() in the SQL query

    if ($stmt = $conn->prepare($sql)) {
        // Bind the username parameter and execute the query
        $stmt->bind_param("s", $logged_in_username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the bookings for the logged-in user
        if ($result->num_rows > 0) {
            echo "<style>
                    body {
                         font-family: 'Georgia ';
                        margin: 20px;
                        background-color: #f4f4f4; /* Light background for contrast */
                    }
                    h1, h2 {
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
                    .no-bookings {
                        text-align: center;
                        font-size: 18px;
                        color: #555;
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
                  </style>";

            // Back to Home link
            echo '<a href="index1.php" class="back-home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                    </svg>
                    Back to Home
                  </a>';

            echo "<h2>Your Package Bookings</h2>";
            echo "<table>
                    <tr>
                        <th>Customer Name</th>
                        <th>Order No.</th>
                        <th>Package Name</th>
                        <th>event Date</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Feedback</th>
                        <th>Invoice</th> <!-- Added column for invoice -->
                    </tr>";

            // Fetch and display each booking record for the logged-in user
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['customer_name']) . "</td>
                        <td>" . htmlspecialchars($row['package_id']) . "</td>
                        <td>" . htmlspecialchars($row['package_name']) . "</td>
                        <td>" . htmlspecialchars($row['event_date']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>";

                // If the status is 'Rejected', show the "Sorry, we are unable to provide service" message
                if (strtolower($row['status']) == 'rejected') {
                    echo "<td colspan='4'><span style='color: red; font-weight: bold;'>Sorry, we are unable to provide service for this booking.</span></td>";
                } else {
                    // Check if the status is 'Completed' and show "Collected" for payment status
                    if (strtolower($row['status']) == 'completed') {
                        echo "<td>Collected</td>"; // Show 'Collected' for completed bookings
                    } else {
                        echo "<td>" . htmlspecialchars($row['payment_status']) . "</td>"; // Show normal payment status
                    }

                    // Check if the status is 'Completed' to enable the feedback link
                    if (strtolower($row['status']) == 'completed') {
                        echo "<td><a href='feedback_form.php?booking_id=" . htmlspecialchars($row['package_id']) . "'>Leave Feedback</a></td>";
                    } else {
                        echo "<td><span style='color: #ccc;'>Feedback Option Disabled</span></td>";
                    }

                    // Provide an invoice download link for completed bookings
                    if (strtolower($row['status']) == 'completed') {
                        echo "<td><a href='invoice.php?booking_id=" . htmlspecialchars($row['package_id']) . "'>Download Invoice</a></td>"; // Link to invoice.php
                    } else {
                        echo "<td><span style='color: #ccc;'>No Invoice Available</span></td>";
                    }
                }

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-bookings'>No bookings found for username: " . htmlspecialchars($logged_in_username) . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display error message if the statement fails
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    header('Location: adminlog.php');
    exit();
}

// Close the connection
$conn->close();
?>