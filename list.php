<?php 
session_name('admin');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: adminlog.php');
    exit();
}

include 'insert.php'; 

// Initialize search variable
$search = '';
if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
}

// Modify SQL query to include search functionality
$sql = "SELECT id, package_name, package_price FROM package WHERE package_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> 
    <title>Package List</title> 
    <style> 
        body { 
            font-size:20px;
            font-family: 'Poppins';
            margin: 20px; 
            background-color: #f4f4f4; 
        }  
        .container { 
            max-width: 900px; 
            margin: auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
        }  
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: #333; 
        }  
        .btn { 
            margin-bottom: 10px; 
            font-size: 16px; 
            border-radius: 5px; 
        }  
        .btn-primary { 
            background-color: #007BFF; 
            border: none; 
            color: white; 
        }  
        .btn-primary:hover { 
            background-color: #0056b3; 
        }  
        .btn-danger { 
            background-color: #f44336; 
            border: none; 
            color: white; 
        }  
        .btn-danger:hover { 
            background-color: #e53935; 
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

        .table { 
            width: 100%; 
            margin-top: 20px; 
            border-collapse: collapse; 
        }  
        .table th, .table td { 
            text-align: center; 
            padding: 10px; 
            border: 1px solid #ddd; 
        }  
        .table th { 
            background-color: #f1f1f1; 
            color: #333; 
        }  
        .table tr:nth-child(even) { 
            background-color: #f9f9f9; 
        }  
        .table tr:hover { 
            background-color: #f2f2f2; 
        }  
    </style> 
</head> 
<body> 
    <div class="container"> 
        <a href="admin.php" class="back-home"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> 
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/> 
        </svg> 
            Back to Home 
        </a> 

        <h2>Package List</h2> 
        <!-- Add search bar -->
        <form method="POST" class="form-inline" style="margin-bottom: 20px;margin-left:450px;";>
            <input type="text" name="search" class="form-control" placeholder="Search by package name" value="<?= htmlspecialchars($search) ?>" style="width: 300px; margin-right: 10px;">
            <button type="submit" class="btn btn-primary"style="margin-top:10px;">Search</button>
        </form>
        <a href="add.php" class="btn btn-primary">Add New Package</a> 
        <?php 
        if ($result->num_rows > 0) { 
            echo '<table class="table table-bordered">'; 
            echo '<thead><tr><th>ID</th><th>Package Name</th><th>Price</th><th>Action</th></tr></thead>'; 
            echo '<tbody>'; 
            while ($row = $result->fetch_assoc()) { 
                echo '<tr>'; 
                echo '<td>' . htmlspecialchars($row['id']) . '</td>'; 
                echo '<td>' . htmlspecialchars($row['package_name']) . '</td>'; 
                echo '<td>' . htmlspecialchars($row['package_price']) . '</td>'; 
                echo '<td>'; 
                echo '<a href="edit.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Edit</a> '; 
                echo '<a href="delete.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this package?\')">Delete</a><br/>'; 
                echo '</td>'; 
                echo '</tr>'; 
            } 
            echo '</tbody>'; 
            echo '</table>'; 
        } else { 
            echo '<p>No packages found.</p>'; 
        } 
        ?> 
    </div> 
</body> 
</html> 
<?php $conn->close(); ?>