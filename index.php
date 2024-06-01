<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-image {
            background-image: url('./img/resume2.jpg'); 
            /* filter: blur(8px); */
            /* -webkit-filter: blur(8px); */
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .bg-text {
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0, 0.4);
            color: white;
            font-weight: bold;
            /* border: 3px solid #f1f1f1; */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 80%;
            padding: 20px;
            text-align: center;
        }
        .btn-custom {
            margin: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-text">
        <h1 class="mb-4">Welcome to Resume Builder</h1>
        <a href="login.php" class="btn btn-primary btn-custom">Login</a>
        <a href="register.php" class="btn btn-secondary btn-custom">Register</a>
    </div>
</body>
</html>
