<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login_screen.php");
    exit();
}

// Include database connection
include("db_connect.php");

// Fetch student details from the database based on the user ID
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `student_database` WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Check if student exists
if (mysqli_num_rows($result) == 0) {
    echo "Error: Student not found";
    exit();
}

// Fetch student data
$student = mysqli_fetch_assoc($result);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to JME University</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #333;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border: 3px solid #00FA9A;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: wheat;
        }

        .profile {
            text-align: left;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #222;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .profile h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .profile-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .profile-info span {
            font-weight: bold;
        }

        .logout-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #00FA9A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #444;
        }

        /* Header Styles */
        .header {
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        .header .logo {
            width: 60px;
            height: 60px;
            background-image: url(images/school1.jpg);
            background-size: cover;
            border-radius: 50%;
        }

        .header ul {
            display: flex;
            list-style-type: none;
        }

        .header li {
            margin-left: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .header li:hover {
            color: #00FA9A;
        }
    </style>
</head>
<body>


    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Message -->
        <h1>Student Profile</h1>
        
        <!-- Student Profile -->
        <div class="profile">
            <h2>Student Profile</h2>
            <div class="profile-info">
                <span>Name:</span>
                <span><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></span>

                <span>Email:</span>
                <span><?php echo $student['email']; ?></span>

                <span>Department:</span>
                <span><?php echo $student['department']; ?></span>

                <span>Course:</span>
                <span><?php echo $student['course']; ?></span>

                <span>Level:</span>
                <span><?php echo $student['level']; ?></span>

                <span>Gender:</span>
                <span><?php echo $student['gender']; ?></span>

                <span>Phone Number:</span>
                <span><?php echo $student['phone_number']; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
