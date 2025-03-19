<?php
    session_name('user');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Georgia ';
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .topnav {
            background-color: #333;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }

        .topnav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
        }

        .topnav a:hover {
            background-color: #04AA6D;
            color: white;
        }

        .topnav a.active {
            background-color: #04AA6D;
        }

        h1 {
            text-align: center;
            font-family: 'Cursive', sans-serif;
            color: #333;
            font-size: 30px;
        }

        h3 {
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        h4 {
            color: #555;
            line-height: 1.8;
            margin: 20px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 15px;
            font-size: 1.3rem;
            color: #666;
            padding-left: 20px;
            position: relative;
        }

        ul li:before {
            content: '\2022';
            color: #04AA6D;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        h6 {
            text-align: center;
            margin-top: 50px;
            color: #999;
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
        <a href="index1.php" class="back-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            Back to home 
        </a>
        <div class="topnav">
            <a class="active">ABOUT US</a>
            <div>
                <a href="./contact.php">Contact Us</a>
            </div>
        </div>

        <div>
            <h1>LET'S EXPLORE TOGETHER</h1>
            <h3><u>ABOUT US</u></h3>
            <h4>
                <ul>
                    <li>Every business has an origin story worth telling, and usually one that justifies why you do business and have clients.</li>
                    <li>H M Event Planning specializes in planning weddings and events in tents, private homes, and raw spaces.</li>
                    <li>By providing a short description of the effortless elegance of their weddings, Brilliant Event Planning gives their potential clients a clear vision of what to expect.</li>
                    <li>Highlighting your team establishes trust with your audience and creates a connection that can help in the sales process.</li>
                </ul>
            </h4>
            <h6>hm decoration@2004</h6>
            <a href="./learn.php" class="btn btn-success">Learn more</a>
        </div>
    </div>
</body>

</html>
