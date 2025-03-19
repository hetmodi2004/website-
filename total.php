<?php
session_name('admin');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: adminlog.php');
    exit();
}
include 'insert.php';  

$message = ""; 

// Default date filter values
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : '';
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : '';

// Check if either date or month is selected, otherwise don't execute the query
if ($selected_date || $selected_month) {
    // Build query based on selected filters
    $query = "SELECT customer_name, event_date, package_name, status FROM booking WHERE 1";

    // Filter by specific date
    if ($selected_date) {
        $query .= " AND event_date = ?";
    }

    // Filter by specific month (format as YYYY-MM)
    if ($selected_month) {
        $query .= " AND DATE_FORMAT(event_date, '%Y-%m') = ?";
    }

    $stmt = $conn->prepare($query);

    if ($selected_date && $selected_month) {
        // Bind both date and month
        $stmt->bind_param('ss', $selected_date, $selected_month);
    } elseif ($selected_date) {
        // Bind only date
        $stmt->bind_param('s', $selected_date);
    } elseif ($selected_month) {
        // Bind only month
        $stmt->bind_param('s', $selected_month);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error executing query: " . $conn->error);
    }

    $stmt->close();
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
            font-size:20px;
            font-family: 'Poppins';
            margin: 20px;
            background-color: #f4f4f4;
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
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
        .filter-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .filter-form select {
            padding: 10px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <a href="admin.php" class="back-home">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
        </svg> Back to Home
    </a>

    <h1>Monthly Data</h1>

    <div class="filter-form">
        <form method="post" action="">
            <label for="selected_date">Select Date: </label>
            <input type="date" name="selected_date" value="<?php echo $selected_date; ?>">

            <label for="selected_month">Select Month: </label>
            <input type="month" name="selected_month" value="<?php echo $selected_month; ?>">

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <?php if ($selected_date || $selected_month): ?>
        <?php if (isset($result) && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>event Date</th>
                        <th>Package Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["event_date"]); ?></td>
                            <td><?php echo htmlspecialchars($row["package_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["status"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
