<?php
session_name('admin');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: adminlog.php');
    exit();
}

include 'insert.php';

$message = ""; 

// Update booking status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    // Ensure the customer_name and status are received for the specific booking row
    $customer_name = $_POST['customer_name'];
    $new_status = isset($_POST['status']) ? $_POST['status'] : 'Pending';

    if (isset($customer_name) && isset($new_status)) {
        // Ensure that only the specific booking is updated based on customer_name
        $update_sql = "UPDATE booking SET status = ? WHERE customer_name = ? LIMIT 1";
        $stmt = $conn->prepare($update_sql);
        if ($stmt) {
            $stmt->bind_param('ss', $new_status, $customer_name);
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Status updated successfully for $customer_name.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error updating status: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Invalid customer name or status.</div>";
    }
}

$sql = "SELECT customer_name, event_date, package_name, status FROM booking";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Booking Data</title>
    <style>
        body {
            font-size: 20px;
            font-family: 'Poppins';
            margin: 20px;
            background-color: #f4f7fa;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #3c8dbc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
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

        table th:last-child,
        table td:last-child {
            text-align: center;
        }

        form {
            display: inline-block;
        }

        td select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
            width: 100%; 
            background-color: #ffffff; 
        }

        td select option {
            background-color: white; 
        }

        td select option[value="Pending"] {
            background-color: #ffcccb; 
            color: black; 
        }

        td select option[value="Completed"] {
            background-color: #add8e6; 
            color: black; 
        }

        td select option[value="Rejected"] {
            background-color: #90ee90; 
            color: black;
        }

        td select:hover {
            border-color: #007BFF; 
        }

        td select:focus {
            outline: none;
            border-color: #007BFF; 
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
        }

        td button {
            margin-left: 10px;
            padding: 8px 12px; 
            border: none;
            border-radius: 4px;
            background-color: #007BFF; 
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }

        td button:hover {
            background-color: #0056b3; 
        }

        .alert {
            margin: 10px auto;
            width: 80%;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
        }

        .alert-warning {
            background-color: #fcf8e3;
            color: #8a6d3b;
        }
    </style>
</head>
<body>
<a href="admin.php" class="back-home">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
    </svg> Back to Home
</a>

<?php echo $message; ?>

<h1>Booking Data</h1>
<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Booking Date</th>
            <th>Package Name</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { 
            // Get the booking date
            $booking_date = new DateTime($row['event_date']);
            $current_date = new DateTime(); // Current date
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                <td>
                    <form method="post" action="">
                        <select name="status">
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?> 
                                <?php if ($booking_date > $current_date) echo 'disabled'; ?>> Completed</option>
                            <option value="Rejected" <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                </td>
                <td>
                    <input type="hidden" name="customer_name" value="<?php echo htmlspecialchars($row['customer_name']); ?>">
                    <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>