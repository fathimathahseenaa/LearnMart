<?php
session_start(); // Start the session
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: ../home.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        $error = "Database query failed.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
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
        .login-container .form-title { 
            color: #000;
        }
        .login-container a {
            color: #28a745;
            text-decoration: none;
        }
        .login-container a:hover {
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
        .alert-top-center {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center alert-top-center" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="login-container">
        <div class="icon-container">
            <i class="fas fa-user-circle"></i>
        </div>
        <h4 class="form-title text-center">Log in to Continue Your Learning Journey</h4>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log In</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="signup.php" class="signup-link">Sign Up</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
