<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Update user's password in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $update_query = "UPDATE `student_database` SET password = '$hashed_password' WHERE email = '$email'";
    mysqli_query($conn, $update_query);

    // Redirect the user to a confirmation page
    header("Location: login_screen.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset</title>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #222;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        background-color: #333;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color:white;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: whitesmoke;
    }

    input[type="password"],
    input[type="email"],
    button[type="submit"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button[type="submit"] {
        background-color: #00FA9A;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #008000;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Reset Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Enter your new password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</div>
</body>
</html>
