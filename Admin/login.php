<?php
include '../db.php'; 
$error_message = ''; // Initialize an empty error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        session_start(); // Start the session
        $_SESSION['username'] = $username;
        $_SESSION['admin_id'] = $admin_id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password"; // Set error message on incorrect credentials
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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

        /* Override btn-primary styles */
        .btn-primary {
            background-color: #28a745; /* Green color */
            border: none;
            color: white;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Remove focus outline */
        .btn-primary:focus {
            outline: none;
            box-shadow: none;
            background-color: #28a745;
        }

        /* Active state (when clicked) */
        .btn-primary:active {
            background-color: #1e7e34; /* Even darker green */
            box-shadow: none;
        }
         /* Ensure there's no border or blue color when focused (across browsers) */
         .btn-primary:focus-visible {
            outline: none;
            box-shadow: none;
        }

        .icon-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .icon-container i {
            font-size: 3rem;
            color: #28a745;
        }

        /* Floating form style */
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

        /* Remove Firefox inner border for focusable buttons */
        .btn-primary::-moz-focus-inner {
            border: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="icon-container">
            <i class="fas fa-user-shield"></i>
        </div>
        <h4 class="form-title text-center">Admin Login</h4>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                Log In
            </button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
