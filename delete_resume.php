<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$resume_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        $delete_exp_query = "DELETE FROM experiences WHERE resume_id = '$resume_id'";
        mysqli_query($conn, $delete_exp_query);

        $delete_edu_query = "DELETE FROM educations WHERE resume_id = '$resume_id'";
        mysqli_query($conn, $delete_edu_query);

        $delete_resume_query = "DELETE FROM resumes WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
        if (mysqli_query($conn, $delete_resume_query)) {
            header("Location: dashboard.php?message=Resume+deleted+successfully");
            exit;
        } else {
            $error_message = "Error deleting resume: " . mysqli_error($conn);
        }
    } else {
        header("Location: dashboard.php");
        exit;
    }
}

$query = "SELECT * FROM resumes WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit;
}

$resume = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Resume</title>
    <style>
        body {
            background-color: #f0f2f5;
            padding-top: 50px;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        p.lead {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            font-size: 16px;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #d9534f;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Resume</h2>
        <p class="lead">Are you sure you want to delete the resume titled "<strong><?php echo htmlspecialchars($resume['resume_title']); ?></strong>"?</p>
        
        <form method="POST">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Confirm Delete</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>

        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
</body>
</html>
