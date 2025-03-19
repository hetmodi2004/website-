<?php

session_name('admin');
session_start();

include 'insert.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die('Invalid package ID.');
    }

    $id = intval($_POST['id']);
    $name = $_POST['package_name'];
    $price = $_POST['package_price'];
    $description = $_POST['package_description'];
    
    if (isset($_FILES['package_image']) && $_FILES['package_image']['error'] === 0) {
        $image = $_FILES['package_image']['name'];
        $target_directory = "uploads/";
        $target_file = $target_directory . basename($image);
        move_uploaded_file($_FILES['package_image']['tmp_name'], $target_file);
    } else {
        $image = $_POST['existing_image'];
    }
    $sql = "UPDATE package SET package_name = ?, package_price = ?, package_description = ?, package_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $price, $description, $image, $id);
    if ($stmt->execute()) {
        echo '<p class="text-success">Package updated successfully.</p>';
    } else {
        echo '<p class="text-danger">Failed to update package.</p>';
    }
    $stmt->close();
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid package ID.');
}

$id = intval($_GET['id']);
$sql = "SELECT package_name, package_price, package_description, package_image FROM package WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die('Package not found.');
}

$row = $result->fetch_assoc();
$stmt->close();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <title>Edit Package</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                background-color: #f4f4f4;
            }
            
            .container {
                max-width: 600px;
                margin: auto;
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            .form-control {
                border-radius: 4px;
            }
            
            .btn {
                padding: 10px 20px;
                border-radius: 4px;
            }
            
            .btn-primary {
                background-color: #4CAF50;
                border: none;
                color: white;
            }
            
            .btn-primary:hover {
                background-color: #45a049;
            }
            
            .btn-secondary {
                background-color: #f44336;
                border: none;
                color: white;
            }
            
            .btn-secondary:hover {
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
        </style>
    </head>

    <body>
        <div class="container">
            
            <!--- back button --->

        <a href="list.php" class="back-list">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg> Back to list page
        </a>

        <!--- main content --->

            <h2>Edit Package</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['package_image']); ?>">

                <div class="form-group">
                    <label for="package_name">Package Name:</label>
                    <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo htmlspecialchars($row['package_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="package_price">Package Price:</label>
                    <input type="text" class="form-control" id="package_price" name="package_price" value="<?php echo htmlspecialchars($row['package_price']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="package_description">Package Description:</label>
                    <textarea class="form-control" id="package_description" name="package_description" rows="4" required><?php echo htmlspecialchars($row['package_description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="package_image_url">Current Package Image URL:</label>
                    <input type="text" class="form-control" id="package_image_url" name="package_image_url" value="uploads/<?php echo htmlspecialchars($row['package_image']); ?>" readonly>
                    <br><br>
                    <label for="package_image">Upload New Package Image (Optional):</label>
                    <input type="file" class="form-control" id="package_image" name="package_image" accept="image/*">
                </div>


                <button type="submit" class="btn btn-primary">Update Package</button>
                <a href="list1.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </body>

    </html>

    <?php
$conn->close();
?>