<?php
include 'insert.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['package_name'];
    $price = $_POST['package_price'];
    $description = $_POST['package_description'];

    // Handle file upload
    $target_dir = "uploads/"; // Directory where images will be saved
    $target_file = $target_dir . basename($_FILES["package_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["package_image"]["tmp_name"]);
    if ($check === false) {
        echo '<p class="text-danger">File is not an image.</p>';
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["package_image"]["size"] > 500000) { // 500 KB limit
        echo '<p class="text-danger">Sorry, your file is too large.</p>';
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<p class="text-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<p class="text-danger">Sorry, your file was not uploaded.</p>';
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["package_image"]["tmp_name"], $target_file)) {
            // Insert package details into the database
            $sql = "INSERT INTO package (package_name, package_price, package_description, package_image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $price, $description, $target_file);

            if ($stmt->execute()) {
                echo '<p class="text-success">Package added successfully.</p>';
            } else {
                echo '<p class="text-danger">Failed to add package.</p>';
            }
            $stmt->close();
        } else {
            echo '<p class="text-danger">Sorry, there was an error uploading your file.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Add New Package</title>
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
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #f44336; /* Red */
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
<a href="list.php" class="back-list">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Back to list page
</a>
    <h2>Add New Package</h2>
    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="package_name">Package Name:</label>
            <input type="text" class="form-control" id="package_name" name="package_name" required>
        </div>
        <div class="form-group">
            <label for="package_price">Package Price:</label>
            <input type="text" class="form-control" id="package_price" name="package_price" required>
        </div>
        <div class="form-group">
            <label for="package_description">Package Description:</label>
            <textarea class="form-control" id="package_description" name="package_description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="package_image">Upload Package Image:</label>
            <input type="file" class="form-control" id="package_image" name="package_image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Package</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
