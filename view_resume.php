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
        }

        .container {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .section-title {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px 5px 0 0;
        }

        .section-content {
            padding: 20px;
            border: 1px solid #007bff;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="back-btn">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <h2 class="text-center mb-4">Resume Details</h2>

        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="section-content">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th>Resume Title</th>
                            <td><?php echo htmlspecialchars($resume['resume_title']); ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo htmlspecialchars($resume['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td><?php echo htmlspecialchars($resume['father_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Mother's Name</th>
                            <td><?php echo htmlspecialchars($resume['mother_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Present Address</th>
                            <td><?php echo htmlspecialchars($resume['present_address']); ?></td>
                        </tr>
                        <tr>
                            <th>Permanent Address</th>
                            <td><?php echo htmlspecialchars($resume['permanent_address']); ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?php echo htmlspecialchars($resume['date_of_birth']); ?></td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td><?php echo htmlspecialchars($resume['nationality']); ?></td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td><?php echo htmlspecialchars($resume['religion']); ?></td>
                        </tr>
                        <tr>
                            <th>Marital Status</th>
                            <td><?php echo htmlspecialchars($resume['marital_status']); ?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?php echo htmlspecialchars($resume['gender']); ?></td>
                        </tr>
                        <tr>
                            <th>Blood Group</th>
                            <td><?php echo htmlspecialchars($resume['blood_group']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($resume['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo htmlspecialchars($resume['phone_number']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Professional Information</div>
            <div class="section-content">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th>Professional Title</th>
                            <td><?php echo htmlspecialchars($resume['professional_title']); ?></td>
                        </tr>
                        <tr>
                            <th>Summary</th>
                            <td><?php echo nl2br(htmlspecialchars($resume['summary'])); ?></td>
                        </tr>
                        <tr>
                            <th>Skills</th>
                            <td><?php echo htmlspecialchars($resume['skills']); ?></td>
                        </tr>
                        <tr>
                            <th>Languages</th>
                            <td><?php echo htmlspecialchars($resume['languages']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Experience</div>
            <div class="section-content">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Role</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($experience = mysqli_fetch_assoc($exp_result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($experience['company']); ?></td>
                                <td><?php echo htmlspecialchars($experience['role']); ?></td>
                                <td><?php echo htmlspecialchars($experience['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($experience['end_date']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($experience['description'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Education</div>
            <div class="section-content">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Institution</th>
                            <th>Degree</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($education = mysqli_fetch_assoc($edu_result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($education['institution']); ?></td>
                                <td><?php echo htmlspecialchars($education['degree']); ?></td>
                                <td><?php echo htmlspecialchars($education['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($education['end_date']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>

</html>
