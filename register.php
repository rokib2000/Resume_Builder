<?php
include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error registering user: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-image {
            background-image: url('./img/register.jpg'); 
            filter: blur(4px);
            -webkit-filter: blur(4px);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .bg-text {
            background-color: rgba(0,0,0, 0.5);
            color: white;
            font-weight: bold;
            border: 3px solid #f1f1f1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 300px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .additional-links {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-text">
        <h2 class="mb-4">Register</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-primary btn-custom">Register</button>
        </form>
        <?php if(isset($error)) echo "<div class='alert alert-danger mt-3'>$error</div>"; ?>
        <div class="additional-links">
            <p>Already registered? <a href="login.php" class="text-light font-weight-bold">Login here</a></p>
            <p><a href="index.php" class="text-light font-weight-bold">Go to Home</a></p>
        </div>
    </div>
</body>
</html>
