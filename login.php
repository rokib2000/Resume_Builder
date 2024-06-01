<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-image {
            background-image: url('./img/login.png'); /* Replace with your background image */
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
            /* border: 3px solid #f1f1f1; */
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
        <h2 class="mb-4">Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-primary btn-custom">Login</button>
        </form>
        <?php if(isset($error)) echo "<div class='alert alert-danger mt-3'>$error</div>"; ?>
        <div class="additional-links">
            <p>Not registered? <a href="register.php" class="text-light font-weight-bold">Register here</a></p>
            <p><a href="index.php" class="text-light font-weight-bold">Go to Home</a></p>
        </div>
    </div>
</body>
</html>
