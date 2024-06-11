<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

// Check if cover letter ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$cover_letter_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch cover letter data from the database
$query = "SELECT * FROM cover_letters WHERE id = $cover_letter_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if cover letter exists and belongs to the user
if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit;
}

$cover_letter = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cover Letter</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Cover Letter</h2>

    <p><?php echo $cover_letter['date']; ?></p>

    <p><?php echo $cover_letter['employer_name']; ?></p>
    <p><?php echo $cover_letter['company_name']; ?></p>
    <p><?php echo $cover_letter['company_address']; ?></p>
    <p><?php echo $cover_letter['city_state_zip']; ?></p>

    <p>Dear <?php echo $cover_letter['employer_name']; ?>,</p>

    <p>I am excited to apply for the <?php echo $cover_letter['job_title']; ?> position at <?php echo $cover_letter['company_name']; ?>. With my background in <?php echo $cover_letter['background']; ?>, I am eager to bring my skills to your team.</p>

    <p>At <?php echo $cover_letter['previous_company']; ?>, I gained experience in <?php echo $cover_letter['specific_skills']; ?>. I am confident that my abilities in <?php echo $cover_letter['relevant_skills']; ?> will help me contribute to <?php echo $cover_letter['company_name']; ?>.</p>

    <p>I am particularly interested in this role because <?php echo $cover_letter['interest_reason']; ?>. I look forward to discussing how I can support your team.</p>

    <p>Thank you for considering my application. Please contact me at <?php echo $cover_letter['phone_number']; ?> or <?php echo $cover_letter['email']; ?> to schedule an interview.</p>

    <p>Sincerely,</p>

    <p><?php echo $cover_letter['your_name']; ?></p>

    <a href="dashboard.php" class="btn btn-secondary">Back</a>
    <button onclick="window.print()" class="btn btn-primary">Print</button>
</div>
</body>
</html>
