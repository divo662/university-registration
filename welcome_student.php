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

// Fetch grades for each course
$grades_query = "SELECT introduction_to_cs_grade, data_structures_grade, computer_networks_grade, database_management_grade FROM `student_database` WHERE id = $user_id";
$grades_result = mysqli_query($conn, $grades_query);

if (!$grades_result) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Fetch grades data
$grades = mysqli_fetch_assoc($grades_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to GME University</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #222;
            color: #fff;
        }
    
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            padding: 0 20px;
            background-color: #333;
        }

        .logo {
            width: 60px;
            height: 60px;
            background-image: url(images/school1.jpg);
            background-size: cover;
            border-radius: 50%;
        }

        .header h2 {
            margin-left: 10px;
            color: #fff;
        }

        .header ul {
            display: flex;
            list-style-type: none;
        }

        .header li {
            margin-left: 20px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .header li:hover {
            color: #00FA9A;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }


        /* Body Styles */
        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .body p {
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header_container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 8px;
        }

        .header_container h1 {
            color: #00FA9A;
            margin-bottom: 20px;
        }

        .header_container ul {
            list-style-type: none;
            padding: 0;
            color: #fff;
        }

        .header_container li {
            margin-bottom: 10px;
            background-color: #555;
            padding: 10px;
            border-radius: 5px;
        }

        .header_container li span:first-child {
            font-weight: bold;
            margin-right: 10px;
        }

        .header_container li span.grade {
            color: #00FA9A;
        }

        /* Portal Features Section */
        .features {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .feature {
            flex: 0 0 calc(33.33% - 20px);
            background-color: #555;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .feature h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #00FA9A;
        }

        .feature p {
            font-size: 16px;
            line-height: 1.6;
        }

        /* Footer Styles */
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #444;
            border-radius: 8px;
            margin-top: 50px;
        }

        .footer ul {
            list-style-type: none;
            padding: 0;
        }

        .footer li {
            display: inline-block;
            margin-right: 10px;
        }

        .footer li:last-child {
            margin-right: 0;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #00FA9A;
        }

        /* Course Form Styles */
        .course-form {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #555;
            border-radius: 8px;
            color: #fff;
        }

        .course-form h2 {
            color: #00FA9A;
            margin-bottom: 20px;
        }

        .course-form ul {
            list-style-type: none;
            padding: 0;
        }

        .course-form li {
            margin-bottom: 10px;
        }

        .course-form li span:first-child {
            font-weight: bold;
            margin-right: 10px;
        }

        .course-form li span.grade {
            color: #00FA9A;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo"></div>
        <h3>GME University Student Portal</h3>
        <ul>
            <li>Welcome, <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>!</li>
            <a href="profile_info.php"><li>Profile Information</li></a>
            <a href="login_screen.php"><li>Logout</li></a>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Message -->
        <h1>Welcome to GME University</h1>
        <div class="body">
            <p>
                Welcome back, <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>. We hope you're ready for another exciting semester.
                We're thrilled to have you here as part of our academic community.
                As you embark on your journey with us, we're here to support you every step of the way.
                Whether you're exploring new academic opportunities, engaging in extracurricular activities,
                or seeking support services, we're committed to your success. Welcome aboard!
            </p>
        </div>

        <!-- Course Form -->
        <div class="header_container">
            <h1>Your Course Form</h1>
            <ul>
    <li>
        <span>Introduction to Computer Science</span>
        <span class="grade"><?php echo $grades['introduction_to_cs_grade'] ?? 'N/A'; ?></span>
        <?php if ($grades['introduction_to_cs_grade']) : ?>
            <a href="Course Introduction to Computer Sci.txt" download>Download Textbook</a>
        <?php endif; ?>
    </li>
    <li>
        <span>Data Structures and Algorithms</span>
        <span class="grade"><?php echo $grades['data_structures_grade'] ?? 'N/A'; ?></span>
        <?php if ($grades['data_structures_grade']) : ?>
            <a href="Course Data Structures and Algorith.txt" download>Download Textbook</a>
        <?php endif; ?>
    </li>
    <li>
        <span>Computer Networks</span>
        <span class="grade"><?php echo $grades['computer_networks_grade'] ?? 'N/A'; ?></span>
        <?php if ($grades['computer_networks_grade']) : ?>
            <a href="Course Computer Networks.txt" download>Download Textbook</a>
        <?php endif; ?>
    </li>
    <li>
        <span>Database Management Systems</span>
        <span class="grade"><?php echo $grades['database_management_grade'] ?? 'N/A'; ?></span>
        <?php if ($grades['database_management_grade']) : ?>
            <a href="Course_Database_Management_Systems.txt" download>Download Textbook</a>
        <?php endif; ?>
    </li>
</ul>

        </div>

        <!-- Portal Features -->
        <div class="features">
            <div class="feature">
                <h2>Course Enrollment</h2>
                <p>Enroll in your desired courses for the semester with ease.</p>
            </div>
            <div class="feature">
                <h2>Academic Resources</h2>
                <p>Access a wide range of academic resources, including study materials and research databases.</p>
            </div>
            <div class="feature">
                <h2>Campus Events</h2>
                <p>Stay updated with upcoming campus events, workshops, and seminars.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <ul>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
</body>
</html>
