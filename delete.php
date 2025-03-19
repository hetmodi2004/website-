<?php
session_name('admin');
session_start();
include 'insert.php'; // Include your database connection

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid package ID.');
}

$id = intval($_GET['id']);

// Prepare and execute the delete query
$sql = "DELETE FROM package WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirect to the list page after successful deletion
    header('Location: list.php');
    exit();
} else {
    echo '<p class="text-danger">Failed to delete package.</p>';
}

$stmt->close();
$conn->close();
?>
