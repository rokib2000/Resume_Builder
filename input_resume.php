<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $resume_title = $_POST['resume_title'];
    $professional_title = $_POST['professional_title'];
    $summary = $_POST['summary'];
    $skills = $_POST['skills'];
    $languages = $_POST['languages'];
    $personal_info = $_POST['personal_info'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $user_id = $_SESSION['user_id'];

    // Insert resume data
    $query = "INSERT INTO resumes (user_id, resume_title, professional_title, summary, skills, languages, personal_info, email, phone_number) 
              VALUES ('$user_id', '$resume_title', '$professional_title', '$summary', '$skills', '$languages', '$personal_info', '$email', '$phone_number')";
              
    if (mysqli_query($conn, $query)) {
        $resume_id = mysqli_insert_id($conn);

        // Insert experience data
        foreach ($_POST['experience'] as $experience) {
            $company = $experience['company'];
            $role = $experience['role'];
            $start_date = $experience['start_date'];
            $end_date = $experience['end_date'];
            $description = $experience['description'];
            $exp_query = "INSERT INTO experiences (resume_id, company, role, start_date, end_date, description) 
                          VALUES ('$resume_id', '$company', '$role', '$start_date', '$end_date', '$description')";
            mysqli_query($conn, $exp_query);
        }

        // Insert education data
        foreach ($_POST['education'] as $education) {
            $institution = $education['institution'];
            $degree = $education['degree'];
            $start_date = $education['start_date'];
            $end_date = $education['end_date'];
            $edu_query = "INSERT INTO educations (resume_id, institution, degree, start_date, end_date) 
                          VALUES ('$resume_id', '$institution', '$degree', '$start_date', '$end_date')";
            mysqli_query($conn, $edu_query);
        }

        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resume</title>
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
        <h2 class="mb-4">Create Resume</h2>
        <form action="input_resume.php" method="POST">
            <div class="form-group">
                <label for="resume_title">Resume Title</label>
                <input type="text" class="form-control" id="resume_title" name="resume_title" required>
            </div>
            <div class="form-group">
                <label for="professional_title">Professional Title</label>
                <input type="text" class="form-control" id="professional_title" name="professional_title" required>
            </div>
            <div class="form-group">
                <label for="summary">Summary</label>
                <textarea class="form-control" id="summary" name="summary" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
                <button type="button" class="btn btn-secondary btn-sm float-right mb-2" id="add_skill">Add Skill</button>
                <div id="skills_section"></div>
            </div>
            <div class="form-group">
                <label for="languages">Languages</label>
                <textarea class="form-control" id="languages" name="languages" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="personal_info">Personal Info</label>
                <textarea class="form-control" id="personal_info" name="personal_info" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <h4>Experience</h4>
            <div id="experience_section">
                <div class="experience_entry">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" name="experience[0][company]" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" name="experience[0][role]" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="experience[0][start_date]" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="experience[0][end_date]" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="experience[0][description]" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-add" id="add_experience">Add Experience</button>

            <h4>Education</h4>
            <div id="education_section">
                <div class="education_entry">
                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" class="form-control" name="education[0][institution]" required>
                    </div>
                    <div class="form-group">
                        <label for="degree">Degree</label>
                        <input type="text" class="form-control" name="education[0][degree]" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="education[0][start_date]" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="education[0][end_date]" required>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-add" id="add_education">Add Education</button>
            <div class="mt-4">
                <a href="dashboard.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        let expCount = 1;
        let eduCount = 1;
        let skillCount = 1;

        document.getElementById('add_experience').addEventListener('click', function() {
            let expSection = document.getElementById('experience_section');
            let expEntry = document.createElement('div');
            expEntry.classList.add('experience_entry');
            expEntry.innerHTML = `
                <hr>
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" name="experience[${expCount}][company]" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" name="experience[${expCount}][role]" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="experience[${expCount}][start_date]" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" name="experience[${expCount}][end_date]" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="experience[${expCount}][description]" rows="3" required></textarea>
                </div>
            `;
            expSection.appendChild(expEntry);
            expCount++;
        });

        document.getElementById('add_education').addEventListener('click', function() {
            let eduSection = document.getElementById('education_section');
            let eduEntry = document.createElement('div');
            eduEntry.classList.add('education_entry');
            eduEntry.innerHTML = `
                <hr>
                <div class="form-group">
                    <label for="institution">Institution</label>
                    <input type="text" class="form-control" name="education[${eduCount}][institution]" required>
                </div>
                <div class="form-group">
                    <label for="degree">Degree</label>
                    <input type="text" class="form-control" name="education[${eduCount}][degree]" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="education[${eduCount}][start_date]" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" name="education[${eduCount}][end_date]" required>
                    </div>
                </div>
            `;
            eduSection.appendChild(eduEntry);
            eduCount++;
        });

        document.getElementById('add_skill').addEventListener('click', function() {
            let skillsSection = document.getElementById('skills_section');
            let skillEntry = document.createElement('div');
            skillEntry.classList.add('form-group');
            skillEntry.innerHTML = `
                <input type="text" class="form-control" name="skills[${skillCount}]" required>
            `;
            skillsSection.appendChild(skillEntry);
            skillCount++;
        });
    </script>
</body>
</html>
