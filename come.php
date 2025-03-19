<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: 'Georgia ';
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1abc9c;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .event-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            transition: transform 0.2s;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .event-title {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .event-date {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .event-description {
            font-size: 14px;
            color: #34495e;
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
        <h1>Upcoming Events</h1>
        <a href="index1.php" class="back-home">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Back to Home
</a>
        <u><b><p>price will be declared soon</P></b></u>
       <?php
       session_name('user');
       session_start(); 

       if (!isset($_SESSION['username'])) {
           header('Location: login.php');
           exit();
       }
       
        include 'insert.php'; 

        $sql = "SELECT title, event_date, description FROM event";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="event-card">';
                echo '<div class="event-title">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="event-date">' . htmlspecialchars($row['event_date']) . '</div>';
                echo '<div class="event-description">' . htmlspecialchars($row['description']) . '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="event-card">No upcoming events available.</div>';
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
