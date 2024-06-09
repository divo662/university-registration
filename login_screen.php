<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $user_type = 'student'; // Set user_type as 'student'

        $table = 'student_database';

        $query = "SELECT * FROM `$table` WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                // Generate and store OTP in session
                $_SESSION['otp'] = mt_rand(100000, 999999);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $user_type; // Set user_type session variable

                // Redirect user to OTP verification page
                header("Location: otp_verification.php");
                exit();
            } else {
                showAlert('Incorrect password');
            }
        } else {
            showAlert('User not found');
        }

        mysqli_stmt_close($stmt);
    } else {
        showAlert('Email and password are required');
    }
}

function showAlert($message) {
    echo "<script>alert('$message');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
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
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .login-form {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #00FA9A;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #333;
            color: #fff;
        }

        p {
            margin-top: 10px;
            text-align: center;
            color: black;
        }

        p a {
            color: #00FA9A;
            text-decoration: none;
            transition: color 0.3s;
        }

        p a:hover {
            color: #fff;
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
        <div class="login-form">
            <h2>Student Login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="student_reg.php">Register here</a></p>
            <p>Forgotten password? <a href="password_reset.php">Reset Password</a></p>
        </div>
    </div>
</body>
</html>
