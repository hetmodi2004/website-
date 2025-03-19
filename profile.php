    <?php
    session_start();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Profile</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <style>
            body {
                font-size:20px;
                font-family: 'Poppins';
                background-color: #f0f4f8;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .profile-container {
                background-color: #fff;
                padding: 40px;
                border-radius: 12px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 350px;
                transition: box-shadow 0.3s ease-in-out;
            }

            .profile-container:hover {
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            }

            .profile-container h2 {
                font-size: 28px;
                color: black;
                margin-bottom: 25px;
            }

            .profile-container p {
                font-size: 18px;
                color: black;
                margin: 15px 0;
                font-weight: 500;
            }

            .profile-container p strong {
                color:red;
            }

            .profile-container .btn {
                margin-top: 20px;
                padding: 10px 20px;
                font-size: 16px;
                font-weight: bold;
                border-radius: 25px;
                background-color: black;
                color: white;
                border: none;
                transition: background-color 0.3s ease;
            }

            .profile-container .btn:hover {
                background-color: #16a085;
                color: #fff;
            }

            @media (max-width: 768px) {
                .profile-container {
                    width: 90%;
                    padding: 20px;
                }
            }
        </style>
    </head>

    <body>

        <div class="profile-container">
            <h2>Admin Profile</h2>
            <p><strong>Username:</strong> HET MODI</p>
            <p><strong>Email:</strong> hmdecoration@gmail.com</p>
            <p><strong>Role:</strong> Admin</p>
            <p><strong>Joined:</strong> September 2024</p>
            <a href="admin.php" class="btn btn-primary">Back to Dashboard</a>
        </div>

    </body>

    </html>
