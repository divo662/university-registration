<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'lecturer') {
    header("Location: login_lecturer.php");
    exit();
}

// Include database connection
include("db_connect.php");

// Fetch lecturer details from the database based on the user ID
$lecturer_id = $_SESSION['user_id'];
$query = "SELECT * FROM `lecturer_database` WHERE lecturer_id = $lecturer_id";

// Execute query
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Check if lecturer exists
if (mysqli_num_rows($result) == 0) {
    echo "Error: Lecturer not found";
    exit();
}

// Fetch lecturer data
$lecturer = mysqli_fetch_assoc($result);

// Fetch list of students
$students_query = "SELECT * FROM `student_database`";
$students_result = mysqli_query($conn, $students_query);

if (!$students_result) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    while ($student = mysqli_fetch_assoc($students_result)) {
        $student_id = $student['id'];
        $introduction_to_cs_score = mysqli_real_escape_string($conn, $_POST['introduction_to_cs_score_' . $student_id]);
        $data_structures_score = mysqli_real_escape_string($conn, $_POST['data_structures_score_' . $student_id]);
        $computer_networks_score = mysqli_real_escape_string($conn, $_POST['computer_networks_score_' . $student_id]);
        $database_management_score = mysqli_real_escape_string($conn, $_POST['database_management_score_' . $student_id]);

        // Update student's scores in the database
        $update_query = "UPDATE student_database SET 
            introduction_to_cs_grade = '$introduction_to_cs_score',
            data_structures_grade = '$data_structures_score',
            computer_networks_grade = '$computer_networks_score',
            database_management_grade = '$database_management_score'
            WHERE id = $student_id";

        $update_result = mysqli_query($conn, $update_query);

        if (!$update_result) {
            // Handle query error
            echo "Error updating scores for student ID $student_id: " . mysqli_error($conn);
        }
    }

    // JavaScript code to display pop-up message
    echo '<script>alert("Results uploaded successfully!");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Lecturer</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .header h1, .header h2 {
            margin: 0;
        }

        /* Form Styles */
        form {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #333;
        }

        button[type="submit"] {
            padding: 12px 24px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        .logout-btn {
            background-color: #ff6347;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #d4462f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GME University</h1>
            <h2>Result Upload Portal</h2>
            <h2>Welcome, <?php echo $lecturer['first_name'] . ' ' . $lecturer['last_name']; ?>!</h2>
            <a href="login_lecturer.php" class="logout-btn">Logout</a>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Student Scores</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Introduction to CS Score</th>
                    <th>Data Structures Score</th>
                    <th>Computer Networks Score</th>
                    <th>Database Management Score</th>
                </tr>
                <?php mysqli_data_seek($students_result, 0); // Reset the result pointer ?>
                <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                    <tr>
                        <td><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
                        <td><input type="text" name="introduction_to_cs_score_<?php echo $student['id']; ?>"></td>
                        <td><input type="text" name="data_structures_score_<?php echo $student['id']; ?>"></td>
                        <td><input type="text" name="computer_networks_score_<?php echo $student['id']; ?>"></td>
                        <td><input type="text" name="database_management_score_<?php echo $student['id']; ?>"></td>
                    </tr>
                <?php } ?>
            </table>
            <button type="submit">Submit Scores</button>
        </form>
    </div>
</body>
</html>
