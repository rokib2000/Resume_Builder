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

$query = "SELECT * FROM resumes WHERE resume_id = '$resume_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit;
}

$resume = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resume_title = $_POST['resume_title'];
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $present_address = $_POST['present_address'];
    $permanent_address = $_POST['permanent_address'];
    $date_of_birth = $_POST['date_of_birth'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $marital_status = $_POST['marital_status'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $professional_title = $_POST['professional_title'];
    $summary = $_POST['summary'];
    $skills = implode(', ', $_POST['skills']);
    $languages = implode(', ', $_POST['languages']);
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $update_query = "UPDATE resumes SET
                        resume_title = '$resume_title',
                        name = '$name',
                        father_name = '$father_name',
                        mother_name = '$mother_name',
                        present_address = '$present_address',
                        permanent_address = '$permanent_address',
                        date_of_birth = '$date_of_birth',
                        nationality = '$nationality',
                        religion = '$religion',
                        marital_status = '$marital_status',
                        gender = '$gender',
                        blood_group = '$blood_group',
                        professional_title = '$professional_title',
                        summary = '$summary',
                        skills = '$skills',
                        languages = '$languages',
                        email = '$email',
                        phone_number = '$phone_number'
                    WHERE resume_id = '$resume_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .container {
            max-width: 800px;
        }

        .btn-add {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Edit Resume</h2>
        <form action="edit_resume.php?id=<?php echo $resume_id; ?>" method="POST">
            <h4>Personal Information</h4>
            <div class="mb-3">
                <label for="resume_title" class="form-label">Resume Title</label>
                <input type="text" class="form-control" id="resume_title" name="resume_title" value="<?php echo htmlspecialchars($resume['resume_title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($resume['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="father_name" class="form-label">Father's Name</label>
                <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo htmlspecialchars($resume['father_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="mother_name" class="form-label">Mother's Name</label>
                <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?php echo htmlspecialchars($resume['mother_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="present_address" class="form-label">Present Address</label>
                <textarea class="form-control" id="present_address" name="present_address" rows="2" required><?php echo htmlspecialchars($resume['present_address']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="permanent_address" class="form-label">Permanent Address</label>
                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2" required><?php echo htmlspecialchars($resume['permanent_address']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($resume['date_of_birth']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo htmlspecialchars($resume['nationality']); ?>"
                required>
            </div>
            <div class="mb-3">
                <label for="religion" class="form-label">Religion</label>
                <select class="form-select" id="religion" name="religion" required>
                    <option value="">Select Religion</option>
                    <option value="Christianity" <?php if ($resume['religion'] == 'Christianity') echo 'selected'; ?>>Christianity</option>
                    <option value="Islam" <?php if ($resume['religion'] == 'Islam') echo 'selected'; ?>>Islam</option>
                    <option value="Hinduism" <?php if ($resume['religion'] == 'Hinduism') echo 'selected'; ?>>Hinduism</option>
                    <option value="Buddhism" <?php if ($resume['religion'] == 'Buddhism') echo 'selected'; ?>>Buddhism</option>
                    <option value="Other" <?php if ($resume['religion'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="marital_status" class="form-label">Marital Status</label>
                <div>
                    <label class="form-check-label mr-4 ml-3">
                        <input type="radio" class="form-check-input" name="marital_status" value="Single" <?php if ($resume['marital_status'] == 'Single') echo 'checked'; ?> required> Single
                    </label>
                    <label class="form-check-label mr-4">
                        <input type="radio" class="form-check-input" name="marital_status" value="Married" <?php if ($resume['marital_status'] == 'Married') echo 'checked'; ?> required> Married
                    </label>
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="marital_status" value="Other" <?php if ($resume['marital_status'] == 'Other') echo 'checked'; ?> required> Other
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <div>
                    <label class="form-check-label mr-4 ml-3">
                        <input type="radio" class="form-check-input" name="gender" value="Male" <?php if ($resume['gender'] == 'Male') echo 'checked'; ?> required> Male
                    </label>
                    <label class="form-check-label mr-4">
                        <input type="radio" class="form-check-input" name="gender" value="Female" <?php if ($resume['gender'] == 'Female') echo 'checked'; ?> required> Female
                    </label>
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" value="Other" <?php if ($resume['gender'] == 'Other') echo 'checked'; ?> required> Other
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="blood_group" class="form-label">Blood Group</label>
                <select class="form-select" id="blood_group" name="blood_group" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+" <?php if ($resume['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if ($resume['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if ($resume['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if ($resume['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="AB+" <?php if ($resume['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if ($resume['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                    <option value="O+" <?php if ($resume['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if ($resume['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="professional_title" class="form-label">Professional Title</label>
                <input type="text" class="form-control" id="professional_title" name="professional_title" value="<?php echo htmlspecialchars($resume['professional_title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="summary" class="form-label">Summary</label>
                <textarea class="form-control" id="summary" name="summary" rows="3" required><?php echo htmlspecialchars($resume['summary']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Skills</label>
                <button type="button" class="btn btn-secondary btn-sm float-right mb-2" id="add_skill">Add Skill</button>
                <div id="skills_section">
                    <?php
                    $skills_array = explode(', ', $resume['skills']);
                    foreach ($skills_array as $skill) {
                        echo '<input type="text" class="form-control mb-2" name="skills[]" value="' . htmlspecialchars($skill) . '" required>';
                    }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="languages" class="form-label">Languages</label>
                <button type="button" class="btn btn-secondary btn-sm float-right mb-2" id="add_language">Add Language</button>
                <div id="languages_section">
                    <?php
                    $languages_array = explode(', ', $resume['languages']);
                    foreach ($languages_array as $language) {
                        echo '<input type="text" class="form-control mb-2" name="languages[]" value="' . htmlspecialchars($language) . '" required>';
                    }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($resume['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($resume['phone_number']) ? htmlspecialchars($resume['phone_number']) : ''; ?>"                required>
            </div>
            
            <h4>Experience</h4>
            <div id="experience_section">
                <?php
                $exp_query = "SELECT * FROM experiences WHERE resume_id = '$resume_id'";
                $exp_result = mysqli_query($conn, $exp_query);
                while ($experience = mysqli_fetch_assoc($exp_result)) {
                    echo '<div class="experience_entry">';
                    echo '<hr>';
                    echo '<div class="mb-3">';
                    echo '<label for="company" class="form-label">Company</label>';
                    echo '<input type="text" class="form-control" name="experience[' . $experience['experience_id'] . '][company]" value="' . htmlspecialchars($experience['company']) . '" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="role" class="form-label">Role</label>';
                    echo '<input type="text" class="form-control" name="experience[' . $experience['experience_id'] . '][role]" value="' . htmlspecialchars($experience['role']) . '" required>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '<div class="col-md-6">';
                    echo '<label for="start_date" class="form-label">Start Date</label>';
                    echo '<input type="date" class="form-control" name="experience[' . $experience['experience_id'] . '][start_date]" value="' . htmlspecialchars($experience['start_date']) . '" required>';
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo '<label for="end_date" class="form-label">End Date</label>';
                    echo '<input type="date" class="form-control" name="experience[' . $experience['experience_id'] . '][end_date]" value="' . htmlspecialchars($experience['end_date']) . '" required>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="description" class="form-label">Description</label>';
                    echo '<textarea class="form-control" name="experience[' . $experience['experience_id'] . '][description]" rows="3" required>' . htmlspecialchars($experience['description']) . '</textarea>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <button type="button" class="btn btn-secondary btn-add" id="add_experience">Add Experience</button>
            
            <h4>Education</h4>
            <div id="education_section">
                <?php
                $edu_query = "SELECT * FROM educations WHERE resume_id = '$resume_id'";
                $edu_result = mysqli_query($conn, $edu_query);
                while ($education = mysqli_fetch_assoc($edu_result)) {
                    echo '<div class="education_entry">';
                    echo '<hr>';
                    echo '<div class="mb-3">';
                    echo '<label for="institution" class="form-label">Institution</label>';
                    echo '<input type="text" class="form-control" name="education[' . $education['education_id'] . '][institution]" value="' . htmlspecialchars($education['institution']) . '" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="degree" class="form-label">Degree</label>';
                    echo '<input type="text" class="form-control" name="education[' . $education['education_id'] . '][degree]" value="' . htmlspecialchars($education['degree']) . '" required>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '<div class="col-md-6">';
                    echo '<label for="start_date" class="form-label">Start Date</label>';
                    echo '<input type="date" class="form-control" name="education[' . $education['education_id'] . '][start_date]" value="' . htmlspecialchars($education['start_date']) . '" required>';
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo '<label for="end_date" class="form-label">End Date</label>';
                    echo '<input type="date" class="form-control" name="education[' . $education['education_id'] . '][end_date]" value="' . htmlspecialchars($education['end_date']) . '" required>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <button type="button" class="btn btn-secondary btn-add" id="add_education">Add Education</button>
            
            <div class="mt-4">
                <a href="dashboard.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        let expCount = <?php echo mysqli_num_rows($exp_result); ?>;
        document.getElementById('add_experience').addEventListener('click', function() {
            let expSection = document.getElementById('experience_section');
            let expEntry = document.createElement('div');
            expEntry.classList.add('experience_entry');
            expEntry.innerHTML = `
                <hr>
                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" name="experience[${expCount}][company]" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" class="form-control" name="experience[${expCount}][role]" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="experience[${expCount}][start_date]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="experience[${expCount}][end_date]" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="experience[${expCount}][description]" rows="3" required></textarea>
                </div>`;
            expSection.appendChild(expEntry);
            expCount++;
        });

        let eduCount = <?php echo mysqli_num_rows($edu_result); ?>;
        document.getElementById('add_education').addEventListener('click', function() {
            let
            let eduSection = document.getElementById('education_section');
            let eduEntry = document.createElement('div');
            eduEntry.classList.add('education_entry');
            eduEntry.innerHTML = `
                <hr>
                <div class="mb-3">
                    <label for="institution" class="form-label">Institution</label>
                    <input type="text" class="form-control" name="education[${eduCount}][institution]" required>
                </div>
                <div class="mb-3">
                    <label for="degree" class="form-label">Degree</label>
                    <input type="text" class="form-control" name="education[${eduCount}][degree]" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="education[${eduCount}][start_date]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="education[${eduCount}][end_date]" required>
                    </div>
                </div>`;
            eduSection.appendChild(eduEntry);
            eduCount++;
        });
    </script>
</body>

</html>
