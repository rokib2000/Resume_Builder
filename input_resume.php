<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
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
    $user_id = $_SESSION['user_id'];

    // Insert resume data
    $query = "INSERT INTO resumes (user_id, resume_title, name, father_name, mother_name, present_address, permanent_address, date_of_birth, nationality, religion, marital_status, gender, blood_group, professional_title, summary, skills, languages, email, phone_number) 
              VALUES ('$user_id', '$resume_title', '$name', '$father_name', '$mother_name', '$present_address', '$permanent_address', '$date_of_birth', '$nationality', '$religion', '$marital_status', '$gender', '$blood_group', '$professional_title', '$summary', '$skills', '$languages', '$email', '$phone_number')";

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
            <h4>Personal Information</h4>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="father_name">Father’s Name</label>
                <input type="text" class="form-control" id="father_name" name="father_name" required>
            </div>
            <div class="form-group">
                <label for="mother_name">Mother’s Name</label>
                <input type="text" class="form-control" id="mother_name" name="mother_name" required>
            </div>
            <div class="form-group">
                <label for="present_address">Present Address</label>
                <textarea class="form-control" id="present_address" name="present_address" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="permanent_address">Permanent Address</label>
                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality" required>
            </div>
            <div class="form-group">
                <label for="religion">Religion</label>
                <select class="form-control" id="religion" name="religion" required>
                    <option value="">Select Religion</option>
                    <option value="Christianity">Christianity</option>
                    <option value="Islam">Islam</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Buddhism">Buddhism</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="marital_status">Marital Status</label>
                <div>
                    <label class="radio-inline mr-3">
                        <input type="radio" name="marital_status" value="Single" required> Single
                    </label>
                    <label class="radio-inline mr-3">
                        <input type="radio" name="marital_status" value="Married" required> Married
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="marital_status" value="Other" required> Other
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <div>
                    <label class="radio-inline mr-3">
                        <input type="radio" name="gender" value="Male" required> Male
                    </label>
                    <label class="radio-inline mr-3">
                        <input type="radio" name="gender" value="Female" required> Female
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="Other" required> Other
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <select class="form-control" id="blood_group" name="blood_group" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
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
                <label for="languages
                <label for="languages">Languages</label>
                <button type="button" class="btn btn-secondary btn-sm float-right mb-2" id="add_language">Add Language</button>
                <div id="languages_section"></div>
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
        let langCount = 1;

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
                </div>`;
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
                </div>`;
            eduSection.appendChild(eduEntry);
            eduCount++;
        });

        document.getElementById('add_skill').addEventListener('click', function() {
            let skillsSection = document.getElementById('skills_section');
            let skillEntry = document.createElement('div');
            skillEntry.classList.add('form-group');
            skillEntry.innerHTML = `
                <input type="text" class="form-control mb-2" name="skills[]" required>`;
            skillsSection.appendChild(skillEntry);
            skillCount++;
        });

        document.getElementById('add_language').addEventListener('click', function() {
            let languagesSection = document.getElementById('languages_section');
            let langEntry = document.createElement('div');
            langEntry.classList.add('form-group');
            langEntry.innerHTML = `
                <input type="text" class="form-control mb-2" name="languages[]" required>`;
            languagesSection.appendChild(langEntry);
            langCount++;
        });
    </script>
</body>

</html>
