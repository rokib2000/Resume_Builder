<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch resumes
$resume_query = "SELECT * FROM resumes WHERE user_id = '$user_id'";
$resume_result = mysqli_query($conn, $resume_query);

// Fetch cover letters
$cover_letter_query = "SELECT * FROM cover_letters WHERE user_id = '$user_id'";
$cover_letter_result = mysqli_query($conn, $cover_letter_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .container {
            max-width: 1200px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn {
            margin-right: 5px;
        }

        .btn-add-resume,
        .btn-add-cover-letter {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dashboard</h2>
            <div>
                <a href="input_resume.php" class="btn btn-primary btn-add-resume">Create New Resume</a>
                <a href="input_cover_letter.php" class="btn btn-secondary btn-add-cover-letter">Create New Cover Letter</a>
                <a href="logout.php" class="btn btn-danger btn-add-cover-letter">Log Out</a>
            </div>
        </div>

        <h3>Resumes</h3>
        <?php if (mysqli_num_rows($resume_result) > 0): ?>
            <div class="row">
                <?php while ($resume = mysqli_fetch_assoc($resume_result)): ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($resume['resume_title']); ?></h5>
                                <p class="card-text"><strong>Name:</strong> <?php echo htmlspecialchars($resume['name']); ?></p>
                                <p class="card-text"><strong>Professional Title:</strong> <?php echo htmlspecialchars($resume['professional_title']); ?></p>
                                <a href="view_resume.php?id=<?php echo $resume['resume_id']; ?>" class="btn btn-info">View</a>
                                <a href="edit_resume.php?id=<?php echo $resume['resume_id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_resume.php?id=<?php echo $resume['resume_id']; ?>" class="btn btn-danger" onclick="return">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>You have not created any resumes yet. Click the "Create New Resume" button to get started.</p>
        <?php endif; ?>

        <h3 class="mt-5">Cover Letters</h3>
        <?php if (mysqli_num_rows($cover_letter_result) > 0): ?>
    <div class="row">
        <?php while ($cover_letter = mysqli_fetch_assoc($cover_letter_result)): ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($cover_letter['your_name']); ?></h5>
                        <p class="card-text">
                            <strong>Email:</strong> <?php echo htmlspecialchars($cover_letter['email']); ?><br>
                            <strong>Phone:</strong> <?php echo htmlspecialchars($cover_letter['phone_number']); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($cover_letter['date']); ?><br>
                            <!-- Add other relevant fields here -->
                        </p>
                        <a href="view_cover_letter.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-info">View</a>
                        <a href="edit_cover_letter.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_cover_letter.php?id=<?php echo $cover_letter['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this cover letter?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>You have not created any cover letters yet. Click the "Create New Cover Letter" button to get started.</p>
<?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
