<?php
include 'insert.php';  // Your database connection script

// Retrieve all past user reviews
$sql_reviews = "SELECT username, feedback, rating FROM feedback";
$result_reviews = $conn->query($sql_reviews);

$reviews = [];
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
} else {
    echo "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <style>
        body {
            font-family:'poppins';
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 30px;
            font-size: 2rem;
        }
        .review-container {
            width: 70%;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .review {
            margin-bottom: 20px;
        }
        .review h3 {
            color: #333;
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .review p {
            color: #555;
            font-size: 1rem;
            line-height: 1.6;
        }
        .star-rating {
            color: #f39c12; /* Yellow color for stars */
            font-size: 1.2rem;
        }
        .star-rating span {
            margin-right: 5px;
        }
        .no-reviews {
            text-align: center;
            font-size: 1rem;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h2>Customer Reviews</h2>

<?php if (!empty($reviews)): ?>
    <div class="review-container">
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <h3><?php echo htmlspecialchars($review['username']); ?> - <?php echo $review['rating']; ?>/5</h3>
                <p><?php echo htmlspecialchars($review['feedback']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="no-reviews">No reviews available at the moment.</p>
<?php endif; ?>

</body>
</html>
