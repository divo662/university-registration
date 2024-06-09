<?php
session_start();

// Check if OTP is set in session
if (!isset($_SESSION['otp'])) {
    // If OTP is not set, generate a new OTP
    $_SESSION['otp'] = mt_rand(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if entered OTP matches the one stored in the session
    if (!empty($_POST['otp']) && $_POST['otp'] == $_SESSION['otp']) {
        // If OTP is correct, redirect user to the welcome page
        header("Location: welcome_student.php");
        exit();
    } else {
        // If OTP is incorrect, display error message
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .otp-text {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
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

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p>Please enter the OTP sent to your email address.</p>
        <div class="otp-text"><?php echo $_SESSION['otp']; ?></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Verify OTP</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>
