<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

$cover_letter_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $your_name = $_POST['your_name'];
    $your_address = $_POST['your_address'];
    $city_state_zip = $_POST['city_state_zip'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $date = $_POST['date'];
    $employer_name = $_POST['employer_name'];
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $company_city_state_zip = $_POST['company_city_state_zip'];
    $job_title = $_POST['job_title'];
    $background = $_POST['background'];
    $previous_company = $_POST['previous_company'];
    $specific_skills = $_POST['specific_skills'];
    $relevant_skills = $_POST['relevant_skills'];
    $interest_reason = $_POST['interest_reason'];

    $query = "UPDATE cover_letters SET your_name='$your_name', your_address='$your_address', city_state_zip='$city_state_zip', email='$email', phone_number='$phone_number', date='$date', employer_name='$employer_name', company_name='$company_name', company_address='$company_address', company_city_state_zip='$company_city_state_zip', job_title='$job_title', background='$background', previous_company='$previous_company', specific_skills='$specific_skills', relevant_skills='$relevant_skills', interest_reason='$interest_reason' WHERE id='$cover_letter_id' AND user_id='$user_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$query = "SELECT * FROM cover_letters WHERE id='$cover_letter_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $query);
$cover_letter = mysqli_fetch_assoc($result);

if (!$cover_letter) {
    echo "Cover letter not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Cover Letter</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edit Cover Letter</h2>
    <form action="edit_cover_letter.php?id=<?php echo $cover_letter_id; ?>" method="POST">
        <div class="form-group">
            <label for="your_name">Your Name</label>
            <input type="text" class="form-control" id="your_name" name="your_name" value="<?php echo htmlspecialchars($cover_letter['your_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="your_address">Your Address</label>
            <input type="text" class="form-control" id="your_address" name="your_address" value="<?php echo htmlspecialchars($cover_letter['your_address']); ?>" required>
        </div>
        <div class="form-group">
            <label for="city_state_zip">City, State, ZIP Code</label>
            <input type="text" class="form-control" id="city_state_zip" name="city_state_zip" value="<?php echo htmlspecialchars($cover_letter['city_state_zip']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cover_letter['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($cover_letter['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($cover_letter['date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="employer_name">Employer's Name</label>
            <input type="text" class="form-control" id="employer_name" name="employer_name" value="<?php echo htmlspecialchars($cover_letter['employer_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo htmlspecialchars($cover_letter['company_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="company_address">Company Address</label>
            <input type="text" class="form-control" id="company_address" name="company_address" value="<?php echo htmlspecialchars($cover_letter['company_address']); ?>" required>
        </div>
        <div class="form-group">
            <label for="company_city_state_zip">Company City, State, ZIP Code</label>
            <input type="text" class="form-control" id="company_city_state_zip" name="company_city_state_zip" value="<?php echo htmlspecialchars($cover_letter['company_city_state_zip']); ?>" required>
        </div>
        <div class="form-group">
            <label for="job_title">Job Title</label>
            <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo htmlspecialchars($cover_letter['job_title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="background">Background</label>
            <textarea class="form-control" id="background" name="background" rows="3" required><?php echo htmlspecialchars($cover_letter['background']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="previous_company">Previous Company</label>
            <input type="text" class="form-control" id="previous_company" name="previous_company" value="<?php echo htmlspecialchars($cover_letter['previous_company']); ?>" required>
        </div>
        <div class="form-group">
            <label for="specific_skills">Specific Skills</label>
            <textarea class="form-control" id="specific_skills" name="specific_skills" rows="3" required><?php echo htmlspecialchars($cover_letter['specific_skills']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="relevant_skills">Relevant Skills</label>
            <textarea class="form-control" id="relevant_skills" name="relevant_skills" rows="3" required><?php echo htmlspecialchars($cover_letter['relevant_skills']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="interest_reason">Interest Reason</label>
            <textarea class="form-control" id="interest_reason" name="interest_reason" rows="3" required><?php echo htmlspecialchars($cover_letter['interest_reason']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
