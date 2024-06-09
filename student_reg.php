<?php
session_start();
include("db_connect.php");

function showAlert($message, $redirect = 'login_screen.php') {
    echo "<script>
            alert('$message');
            window.location.href = '$redirect';
          </script>";
    exit();
}

// Check if the form is submitted
if (isset($_POST["register"])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Initialize grades with default value
    $introduction_to_cs_grade = 'N/A';
    $data_structures_grade = 'N/A';
    $computer_networks_grade = 'N/A';
    $database_management_systems_grade = 'N/A';

    // Check if email already exists
    $checkQuery = mysqli_query($conn, "SELECT * FROM `student_database` WHERE email='$email'");
    $existingUser = mysqli_fetch_assoc($checkQuery);

    if ($existingUser) {
        showAlert('Email already exists. Please use a different one.');
    } else {
        // Perform SQL query to insert data
        $query = mysqli_prepare($conn, "INSERT INTO `student_database` (first_name, last_name, email, department, course, level, gender, phone_number, password, introduction_to_cs_grade, data_structures_grade, computer_networks_grade, database_management_grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        mysqli_stmt_bind_param($query, 'sssssssssssss', $firstname, $lastname, $email, $department, $course, $level, $gender, $phone, $hashed_password, $introduction_to_cs_grade, $data_structures_grade, $computer_networks_grade, $database_management_systems_grade);

        // Execute the query
        if (mysqli_stmt_execute($query)) {
            showAlert('Registered successfully, login now');
        } else {
            showAlert('Registration failed. Please try again.');
        }

        // Close the statement
        mysqli_stmt_close($query);
    }
}

// Check if there are saved form values in sessionStorage
$storedValues = isset($_SESSION['stored_values']) ? $_SESSION['stored_values'] : '{}';
$storedValues = json_decode($storedValues, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #222;
        }

        .header {
            height: 80px;
            display: flex;
            align-items: center;
            background-color: #333;
            padding: 0 20px;
            color: white;
        }

        .logo {
            width: 60px;
            height: 60px;
            border: 1px solid white;
            border-radius: 50%;
            margin-right: 20px;
        }

        .header h2 {
            margin-left: 10px;
        }

        .header ul {
            display: flex;
            list-style-type: none;
            margin-left: auto;
        }

        .header li {
            margin-left: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .header li:hover {
            border-bottom: 2px solid #00FA9A;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #00FA9A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #008000;
        }
    </style>
</head>
<body>
<div class="header">
        <div class="logo"></div>
        <h2>GME University</h2>
        <ul>
        <a href="landing_screen.php"><li>Home</li></a>
            <li>About</li>
            <li>Study</li>
            <li>Contact</li>
        </ul>
    </div>
    <div class="container">
        <form method="post" enctype="multipart/form-data" class="register-form">
            <h2>Student Registration</h2>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo isset($storedValues['firstname']) ? htmlspecialchars($storedValues['firstname']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname"  value="<?php echo isset($storedValues['lastname']) ? htmlspecialchars($storedValues['lastname']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"  value="<?php echo isset($storedValues['email']) ? htmlspecialchars($storedValues['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department"  value="<?php echo isset($storedValues['department']) ? htmlspecialchars($storedValues['department']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="course" name="course"  value="<?php echo isset($storedValues['course']) ? htmlspecialchars($storedValues['course']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <input type="text" id="level" name="level"  value="<?php echo isset($storedValues['level']) ? htmlspecialchars($storedValues['level']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option >Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit"  name="register" value = "Register">Register</button>
            <div id="registration-message"></div>
        </form>
        
    </div>

</body>
</html>