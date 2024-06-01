<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

// Fetch user's resumes
$user_id = $_SESSION['user_id'];
$resume_query = "SELECT * FROM resumes WHERE user_id = '$user_id'";
$resume_result = mysqli_query($conn, $resume_query);
$resumes = mysqli_fetch_all($resume_result, MYSQLI_ASSOC);

// Fetch user's cover letters
$cover_query = "SELECT * FROM cover_letters WHERE user_id = '$user_id'";
$cover_result = mysqli_query($conn, $cover_query);
$cover_letters = mysqli_fetch_all($cover_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-light-blue {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-custom {
            margin: 5px;
        }
        .nav-item.active {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Resume Builder</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'input_resume.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="input_resume.php">Create Resume</a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'input_cover.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="input_cover.php">Create Cover Letter</a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="bg-light-blue">
        <div class="container">
            <h1 class="mb-4">Your Resumes</h1>
            <?php if (count($resumes) > 0): ?>
                <div class="row">
                    <?php foreach ($resumes as $resume): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($resume['resume_title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($resume['summary']); ?></p>
                                    <a href="view_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-primary btn-custom">View</a>
                                    <a href="edit_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-secondary btn-custom">Edit</a>
                                    <a href="delete_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-danger btn-custom">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No resumes found. <a href="input_resume.php">Create a new resume</a>.</p>
            <?php endif; ?>
            <hr>
            <h2 class="mb-4">Your Cover Letters</h2>
            <?php if (count($cover_letters) > 0): ?>
                <div class="row">
                    <?php foreach ($cover_letters as $cover_letter): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($cover_letter['cover_title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($cover_letter['message']); ?></p>
                                    <a href="view_cover.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-primary btn-custom">View</a>
                                    <a href="edit_cover.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-secondary btn-custom">Edit</a>
                                    <a href="delete_cover.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-danger btn-custom">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No cover letters found. <a href="input_cover.php">Create a new cover letter</a>.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
