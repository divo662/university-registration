<!DOCTYPE html>
<html>
<head>
    <title>GME University</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        .header h2 {
            margin: 0;
        }

        .logo {
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

        /* Body Styles */
        .body {
            text-align: center;
            margin-top: 50px;
        }

        .body h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }

        .body h4 {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }

        .body p {
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }

        .body a button {
            padding: 15px 30px;
            background-color: #00FA9A;
            border: none;
            border-radius: 5px;
            color: #333;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .body a button:hover {
            background-color: #007c5d;
            color: #fff;
        }

        /* Footer Styles */
        .footer {
            margin-top: 50px;
            background-color: #333;
            padding: 20px;
            text-align: center;
        }

        .footer ul {
            list-style-type: none;
            padding: 0;
        }

        .footer li {
            display: inline-block;
            margin: 0 10px;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
            transition: color 0.3s;
        }

        .footer li:hover {
            color: #00FA9A;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo"></div>
            <h2>GME University</h2>
            <ul>
                <li>About</li>
                <li>Study</li>
                <a href="login_screen.php" ><li>Login as Student</li></a>
                <a href="login_lecturer.php"><li>Login as Admin</li></a>
                <li>Contact</li>
            </ul>
        </div>

        <!-- Body -->
        <div class="body">
            <h1>Welcome to GME University</h1>
            <h4>Experience Excellence in Education</h4>
            <p>GME University is a leading educational institution dedicated to providing high-quality education to students from all over the world.</p>
            <p>Our campus offers state-of-the-art facilities, modern classrooms, and a vibrant learning environment.</p>
            <p>At GME University, we offer a wide range of undergraduate and postgraduate programs in various fields including Engineering, Business, Computer Science, Arts, and Humanities.</p>
            <p>Our experienced faculty members are committed to helping students achieve their academic and career goals.</p>
            <a href="student_reg.php"><button>Register as a Student</button></a>
            <p>Located in Lagos, Nigeria</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <ul>
                <li>Terms of Service</li>
                <li>Cookie Policy</li>
                <li>FAQ</li>
                <li>Support</li>
                <li>Careers</li>
            </ul>
        </div>
    </div>
</body>
</html>
