<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

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
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO cover_letters (user_id, your_name, your_address, city_state_zip, email, phone_number, date, employer_name, company_name, company_address, company_city_state_zip, job_title, background, previous_company, specific_skills, relevant_skills, interest_reason) 
              VALUES ('$user_id', '$your_name', '$your_address', '$city_state_zip', '$email', '$phone_number', '$date', '$employer_name', '$company_name', '$company_address', '$company_city_state_zip', '$job_title', '$background', '$previous_company', '$specific_skills', '$relevant_skills', '$interest_reason')";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Cover Letter</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Create Cover Letter</h2>
    <form action="input_cover_letter.php" method="POST">
        <div class="form-group">
            <label for="your_name">Your Name</label>
            <input type="text" class="form-control" id="your_name" name="your_name" required>
        </div>
        <div class="form-group">
            <label for="your_address">Your Address</label>
            <input type="text" class="form-control" id="your_address" name="your_address" required>
        </div>
        <div class="form-group">
            <label for="city_state_zip">City, State, ZIP Code</label>
            <input type="text" class="form-control" id="city_state_zip" name="city_state_zip" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="employer_name">Employer's Name</label>
            <input type="text" class="form-control" id="employer_name" name="employer_name" required>
        </div>
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name" required>
        </div>
        <div class="form-group">
            <label for="company_address">Company Address</label>
            <input type="text" class="form-control" id="company_address" name="company_address" required>
        </div>
        <div class="form-group">
            <label for="company_city_state_zip">Company City, State, ZIP Code</label>
            <input type="text" class="form-control" id="company_city_state_zip" name="company_city_state_zip" required>
        </div>
        <div class="form-group">
            <label for="job_title">Job Title</label>
            <input type="text" class="form-control" id="job_title" name="job_title" required>
        </div>
        <div class="form-group">
            <label for="background">Background</label>
            <textarea class="form-control" id="background" name="background" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="previous_company">Previous Company</label>
            <input type="text" class="form-control" id="previous_company" name="previous_company" required>
        </div>
        <div class="form-group">
            <label for="specific_skills">Specific Skills</label>
            <textarea class="form-control" id="specific_skills" name="specific_skills" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="relevant_skills">Relevant Skills</label>
            <textarea class="form-control" id="relevant_skills" name="relevant_skills" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="interest_reason">Interest Reason</label>
            <textarea class="form-control" id="interest_reason" name="interest_reason" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-2">Back</a>
</div>
</body>
</html>
