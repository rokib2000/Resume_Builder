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

// Fetch resume data
$query = "SELECT * FROM resumes WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit;
}

$resume = mysqli_fetch_assoc($result);

// Fetch experiences
$exp_query = "SELECT * FROM experiences WHERE resume_id = '$resume_id'";
$exp_result = mysqli_query($conn, $exp_query);

// Fetch educations
$edu_query = "SELECT * FROM educations WHERE resume_id = '$resume_id'";
$edu_result = mysqli_query($conn, $edu_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resume</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            padding-top: 50px;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .back-btn {
            margin-bottom: 20px;
        }

        .resume-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .resume-header h2 {
            font-size: 36px;
            margin-bottom: 5px;
        }

        .resume-header p {
            font-size: 18px;
            color: #666;
        }

        .section-title {
            font-size: 24px;
            color: #007bff;
            margin-top: 30px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #007bff;
        }

        .section-content {
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .personal-info th {
            width: 30%;
            font-weight: bold;
            color: #007bff;
            text-align: left;
        }

        .personal-info td {
            font-weight: normal;
        }

        .professional-info p,
        .experience-info p,
        .education-info p {
            font-size: 16px;
            color: #333;
        }

        .professional-info p span,
        .experience-info p span,
        .education-info p span {
            font-weight: bold;
            color: #007bff;
        }

        .experience-item,
        .education-item {
            margin-bottom: 20px;
        }

        .experience-item h5,
        .education-item h5 {
            margin-bottom: 5px;
            font-size: 18px;
            color: #333;
        }

        .experience-item p,
        .education-item p {
            margin: 0;
        }

        .experience-item .date,
        .education-item .date {
            font-size: 14px;
            color: #999;
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-btn">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <div class="resume-header">
            <h2><?php echo htmlspecialchars($resume['name']); ?></h2>
            <p><?php echo htmlspecialchars($resume['professional_title']); ?></p>
        </div>

        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="section-content">
                <table class="table table-borderless personal-info">
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td><?php echo htmlspecialchars($resume['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Father's Name:</th>
                            <td><?php echo htmlspecialchars($resume['father_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Mother's Name:</th>
                            <td><?php echo htmlspecialchars($resume['mother_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Present Address:</th>
                            <td><?php echo htmlspecialchars($resume['present_address']); ?></td>
                        </tr>
                        <tr>
                            <th>Permanent Address:</th>
                            <td><?php echo htmlspecialchars($resume['permanent_address']); ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth:</th>
                            <td><?php echo htmlspecialchars($resume['date_of_birth']); ?></td>
                        </tr>
                        <tr>
                            <th>Nationality:</th>
                            <td><?php echo htmlspecialchars($resume['nationality']); ?></td>
                        </tr>
                        <tr>
                            <th>Religion:</th>
                            <td><?php echo htmlspecialchars($resume['religion']); ?></td>
                        </tr>
                        <tr>
                            <th>Marital Status:</th>
                            <td><?php echo htmlspecialchars($resume['marital_status']); ?></td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td><?php echo htmlspecialchars($resume['gender']); ?></td>
                        </tr>
                        <tr>
                            <th>Blood Group:</th>
                            <td><?php echo htmlspecialchars($resume['blood_group']); ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo htmlspecialchars($resume['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number:</th>
                            <td><?php echo htmlspecialchars($resume['phone_number']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Professional Information</div>
            <div class="section-content professional-info">
                <p><span>Summary:</span> <?php echo nl2br(htmlspecialchars($resume['summary'])); ?></p>
                <p><span>Skills:</span> <?php echo htmlspecialchars($resume['skills']); ?></p>
                <p><span>Languages:</span> <?php echo htmlspecialchars($resume['languages']); ?></p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Experience</div>
            <div class="section-content experience-info">
                <?php while ($experience = mysqli_fetch_assoc($exp_result)) { ?>
                    <div class="experience-item">
                        <h5><?php echo htmlspecialchars($experience['role']); ?> at <?php echo htmlspecialchars($experience['company']); ?></h5>
                        <p class="date"><?php echo htmlspecialchars($experience['start_date']); ?> - <?php echo htmlspecialchars($experience['end_date']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($experience['description'])); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Education</div>
            <div class="section-content education-info">
                <?php while ($education = mysqli_fetch_assoc($edu_result)) { ?>
                    <div class="education-item">
                        <h5><?php echo htmlspecialchars($education['degree']); ?> from <?php echo htmlspecialchars($education['institution']); ?></h5>
                        <p class="date"><?php echo htmlspecialchars($education['start_date']); ?> - <?php echo htmlspecialchars($education['end_date']); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="print-btn">
            <button class="btn btn-primary" onclick="window.print()">Print Resume</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>
