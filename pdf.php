<?php
session_name('user');
session_start();
include 'insert.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Check if booking_id is provided
if (isset($_GET['booking_id'])) {
    $booking_id = htmlspecialchars($_GET['booking_id']);

    // SQL query to fetch booking details
    $sql = "SELECT customer_name, package_name, event_date, status FROM booking WHERE package_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_name = htmlspecialchars($row['customer_name']);
            $package_name = htmlspecialchars($row['package_name']);
            $booking_date = htmlspecialchars($row['event_date']);
            $status = htmlspecialchars($row['status']);

            // Initialize Dompdf with options
            $options = new Options();
            $options->set('defaultFont', 'Georgia');
            $dompdf = new Dompdf($options);

            // HTML content for the PDF
            $html = "
            <style>
                body {
                    font-family: 'Georgia';
                    margin: 20px;
                    padding: 10px;
                    background-color: #fff;
                }
                .invoice-container {
                    border: 1px solid #ddd;
                    padding: 20px;
                    border-radius: 10px;
                    width: 80%;
                    margin: auto;
                }
                h2 {
                    text-align: center;
                    color: #333;
                }
                .invoice-details p {
                    font-size: 18px;
                    line-height: 1.5;
                }
                .footer {
                    text-align: center;
                    font-size: 16px;
                    margin-top: 30px;
                }
            </style>
            <div class='invoice-container'>
                <h2>Invoice for Package Booking</h2>
                <div class='invoice-details'>
                    <p><strong>Customer Name:</strong> $customer_name</p>
                    <p><strong>Package Name:</strong> $package_name</p>
                    <p><strong>Event Date:</strong> $booking_date</p>
                    <p><strong>Status:</strong> $status</p>
                </div>
                <div class='footer'>
                    <p>Thank you for booking with us!</p>
                </div>
            </div>";

            // Load HTML into Dompdf
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Stream the PDF file
            $dompdf->stream("invoice_$booking_id.pdf", ["Attachment" => true]);
        } else {
            echo "No booking details found.";
        }
        $stmt->close();
    } else {
        echo "Error fetching data: " . $conn->error;
    }
} else {
    echo "No booking ID provided.";
}

// Close the database connection
$conn->close();
?>
