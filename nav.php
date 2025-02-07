<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <style>
        .navbar {
            background-color: #28a745 !important;
        }
        .navbar .navbar-brand {
            color: #fff !important;
        }
        .navbar .form-control {
            border: none;
            border-radius: 20px;
        }
        .navbar .form-control:focus {
            box-shadow: none;
        }
        .navbar .btn-primary, .navbar .btn-outline-light {
            background-color: #fff;
            color: #28a745;
            border-color: #fff;
        }
        .navbar .btn-primary:hover, .navbar .btn-outline-light:hover {
            background-color: #e9ecef;
        }
        .centered-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .header .profile .initials {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color:rgb(105, 197, 197);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
        }
        .header .profile .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            color: #333;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }
        .header .profile .dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }
        .header .profile .dropdown a:hover {
            background-color: #ddd;
        }
        .profile .initials {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
            color: #28a745;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }
        .profile .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: #fff;
            color: #333;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }
        .profile .dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }
        .profile .dropdown a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="#">LearnMart</a>

            <!-- Toggler Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <form class="d-flex me-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for courses..." aria-label="Search">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Side Buttons -->
                <div class="d-flex align-items-center">
                    <!-- Notification Icon -->
                    <a href="#" class="btn btn-primary me-2">
                        <i class="fas fa-bell"></i>
                    </a>
                    <?php
                    // session_start();
                    if (isset($_SESSION['username'])) {
                        $user_name = $_SESSION['username'];
                        $initial = strtoupper($user_name[0]);
                    ?>
                        <div class="profile">
                            <div class="initials" onclick="toggleDropdown()"><?php echo $initial; ?></div>
                            <div class="dropdown" id="dropdown">
                                <a href="profile.php">View Profile</a>
                                <a href="user/logout.php">Logout</a>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <!-- Login Button -->
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                        <!-- Sign Up Button -->
                        <a href="user/signup.php" class="btn btn-primary">Sign Up</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Please choose your login type:</p>
                    <div class="d-flex justify-content-center">
                        <a href="admin/login.php" class="btn btn-success me-3">Admin Login</a>
                        <a href="user/login.php" class="btn btn-success">User Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" defer></script> -->
</body>
</html>
