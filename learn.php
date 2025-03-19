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
            font-size: 2.5rem;
            margin-top: 20px;
        }

        h3 {
            text-align: center;
            color: #333;
            font-weight: bold;
            margin-top: 30px;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="topnav">
            <a class="active">LEARN MORE</a>
            <div>
                <a href="./contact.php">Contact Us</a>
                <a href="./about.php">About Us</a>
            </div>
        </div>

        <div>
            <h1>LEARN MORE ABOUT OUR SERVICES</h1>
            <h3><u>OUR EXPERTISE</u></h3>
            <h4>
                <ul>
                    <li>We offer a comprehensive range of event planning services, tailored to meet your specific needs.</li>
                    <li>Our team has extensive experience in coordinating events of all sizes, from intimate gatherings to grand celebrations.</li>
                    <li>We believe in making your vision a reality, ensuring every detail is meticulously planned and executed.</li>
                    <li>Our commitment to excellence is reflected in our attention to detail and exceptional customer service.</li>
                </ul>
            </h4>
            <h6>hm decoration@2004</h6>
        </div>
    </div>
</body>

</html>
