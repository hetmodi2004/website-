<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
    <style>
        body {
            font-family: 'Georgia ';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        #contact-us {
            padding: 40px;
            background-color: white;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 40px auto;
            max-width: 800px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        #contact-us h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }
        
        .contact-info {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .contact-item {
            flex: 1;
            margin: 15px;
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        
        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .contact-item h2 {
            font-size: 1.5em;
            color: #007BFF;
            margin-bottom: 10px;
        }
        
        .contact-item a {
            color: #333;
            text-decoration: none;
            font-size: 1.1em;
        }
        
        .contact-item a:hover {
            color: #007BFF;
            text-decoration: underline;
        }
        
        hr {
            border: 0;
            height: 2px;
            background: #007BFF;
            margin: 20px 0;
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
    <section id="contact-us">
        <a href="index1.php" class="back-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg> Back to home
        </a>
        <hr>
        <h1>CONTACT US</h1>
        <div class="contact-info">
            <div class="contact-item">
                <h2>Phone</h2>
                <p><a href="tel:+91 6351709559">+91 6351709559</a></p>
            </div>
            <div class="contact-item">
                <h2>Email</h2>
                <p><a href="mailto:hmdecoration@gmail.com">hmdecoration@gmail.com</a></p>
            </div>
            <div class="contact-item">
                <h2>Instagram</h2>
                <p><a href="https://www.instagram.com/mistry_decoration" target="_blank">@mistry_decoration</a></p>
            </div>
        </div>
    </section>
</body>

</html>