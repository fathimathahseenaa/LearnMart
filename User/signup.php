<?php
include '../db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $fullname = $_POST['fullname'];
  

    // Insert data into database
    $sql = "INSERT INTO users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .signup-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            top: -10px;
            left: 15px;
            font-size: 0.85rem;
            color: #28a745;
        }
        .form-floating>.form-control {
            height: 55px;
            padding: 20px 15px 10px;
        }
        .form-floating>label {
            top: 18px;
            left: 15px;
            transition: all 0.2s ease-in-out;
            color: #6c757d;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: none;
        }
        .signup-container .form-title { 
            color: #000;
        }
        .signup-container a {
            color: #28a745;
            text-decoration: none;
        }
        .signup-container a:hover {
            text-decoration: underline;
        }
        .icon-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .icon-container i {
            font-size: 3rem;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="icon-container">
            <i class="fas fa-user-circle"></i>
        </div>
        <h4 class="form-title text-center">Sign Up and Start Learning</h4>
        <form action="signup.php" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="fullname" name="fullname" placeholder=" " required>
                <label for="fullname">Full Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                <label for="email">Email Address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="login.php" class="login-link">Log In</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

