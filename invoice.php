<?php
session_name('user');
session_start(); // Start the session to access session variables
include 'insert.php';
require 'vendor/autoload.php';

// Check if the booking_id is provided in the URL
if (isset($_GET['booking_id'])) {
    // Sanitize the booking_id parameter from the URL
    $booking_id = htmlspecialchars($_GET['booking_id']);

    // SQL query to fetch the booking details based on the booking_id
    $sql = "SELECT customer_name, package_name, event_date, status 
            FROM booking 
            WHERE package_id = ?"; // Use package_id as the unique identifier for the booking

    if ($stmt = $conn->prepare($sql)) {
        // Bind the booking_id parameter and execute the query
        $stmt->bind_param("s", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if booking details are found
        if ($result->num_rows > 0) {
            // Fetch the booking details
            $row = $result->fetch_assoc();
            $customer_name = htmlspecialchars($row['customer_name']);
            $package_name = htmlspecialchars($row['package_name']);
            $booking_date = htmlspecialchars($row['event_date']);
            $status = htmlspecialchars($row['status']);

            // Enhanced CSS for the invoice
            echo "<style>
                    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
                    body {
                        font-family: 'Georgia';
                        margin: 0;
                        padding: 0;
                        background-color: #f4f7fa;
                    }
                    h1, h2 {
                        text-align: center;
                        color: #333;
                        margin-bottom: 20px;
                    }
                    .invoice-container {
                        width: 80%;
                        margin: 40px auto;
                        padding: 30px;
                        background-color: white;
                        border-radius: 10px;
                        border: 1px solid #e0e0e0;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                        transition: transform 0.3s;
                    }
                    .invoice-container:hover {
                        transform: scale(1.02);
                    }
                    .invoice-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 30px;
                    }
                    .invoice-details {
                        margin-bottom: 20px;
                        padding: 20px;
                        border: 1px solid #dee2e6;
                        border-radius: 5px;
                        background-color: #f8f9fa;
                    }
                    .invoice-details p {
                        font-size: 18px;
                        line-height: 1.6;
                        margin: 5px 0;
                    }
                    .invoice-footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 16px;
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
                    .download-button {
                        display: inline-block;
                        padding: 12px 24px;
                        font-size: 18px;
                        color: white;
                        background-color: #28a745; /* Green color */
                        border: none;
                        border-radius: 5px;
                        text-decoration: none;
                        transition: background-color 0.3s, transform 0.2s;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                    }
                    .download-button:hover {
                        background-color: #218838; /* Darker green on hover */
                        transform: translateY(-2px); /* Slightly lift on hover */
                    }
                    a {
                        color: #007bff;
                        text-decoration: none;
                    }
                    a:hover {
                        text-decoration: underline;
                    }
                  </style>";

            // Back button at the top with arrow icon
            echo "<div class='invoice-container'>
                    <div class='invoice-header'>
                        <a href='data.php' class='back-home'> 
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'> 
                                <path fill-rule='evenodd' d='M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z'/> 
                            </svg> 
                            Back to list page 
                        </a>
                        <h2>Invoice for Package Booking</h2>
                    </div>";

            // Display the booking details
            echo "<div class='invoice-details'>
                    <p><strong>Customer Name:</strong> " . $customer_name . "</p>
                    <p><strong>Package Name:</strong> " . $package_name . "</p>
                    <p><strong>Event Date:</strong> " . $booking_date . "</p>
                    <p><strong>Status:</strong> " . $status . "</p>
                  </div>";

            // Invoice footer with stylish download button
            echo "<div class='invoice-footer'>
                    <p><a href='pdf.php?booking_id=" . $booking_id . "' class='download-button'>Download PDF</a></p>
                  </div>";

            echo "</div>"; // Close the invoice container
        } else {
            echo "<p>No booking details found for the given booking ID.</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display error message if the statement fails
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    echo "<p>No booking ID provided.</p>";
}

// Close the connection
$conn->close();
?>