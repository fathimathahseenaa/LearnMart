<?php
include '../db.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s ease;
            background-color: #f4f4f9;
        }

        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #218838;
            color: #fff;
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .left {
            display: flex;
            align-items: center;
        }

        .navbar .left .menu-icon {
            font-size: 24px;
            margin-right: 20px;
            cursor: pointer;
        }

        .navbar .search-bar {
            position: relative;
            margin-left: 20px;
            width: 200px;
        }

        .navbar .search-bar input {
            width: 100%;
            padding: 8px 35px 8px 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            background-color: #fff;
        }

        .navbar .search-bar .search-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #000;
        }

        .navbar .right {
            display: flex;
            align-items: center;
        }

        .navbar .right .notification-icon {
            font-size: 20px;
            color: #fff;
            margin-right: 20px;
            cursor: pointer;
        }

        .navbar .right .user-icon {
            font-size: 20px;
            color: #fff;
        }

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color:rgb(2, 45, 10);
            color: #fff;
            overflow-y: auto;
            transition: left 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar .close-btn {
            text-align: right;
            padding: 10px;
            cursor: pointer;
            color: #fff;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            display: flex;
            align-items: center;
            padding: 15px;
            cursor: pointer;
            font-size: 18px;
            color: #c9c9c9;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li i {
            margin-right: 15px;
        }

        .sidebar ul li:hover {
            background-color: #50505e;
        }

        .sidebar ul li.logout {
            color: #ff6b6b;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
        /* Button styling */
        .btn-view {
            background-color: #218838;
            color: white;
        }

        .btn-view:hover {
            background-color: #1e7e34;
            color: white;
        }
        .custom-link {
            text-decoration: none; /* Removes underline */
            color: inherit; /* Inherits color from the parent element */
        }
        

    /* Options Menu */
    #options-menu {
      position: fixed;
      bottom: 95px; /* Increased the space between the icon and options */
      right: 50px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 99;
      display: none;
    }

    #options-menu ul {
      list-style: none;
      padding: 10px;
      margin: 0;
    }

    #options-menu ul li {
      padding: 10px;
      cursor: pointer;
      text-align: center;
    }

    #options-menu ul li:hover {
      background-color:rgb(129, 188, 143);
    }
.custom-link:hover {
    color:none; /* Optional: Add a hover effect, change the color */
}
</style>
</head>

<body>
    <div class="navbar">
        <div class="left">
            <i class="fas fa-bars menu-icon" onclick="toggleSidebar()"></i>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        <div class="right">
            <i class="fas fa-bell notification-icon"></i>
            <i class="fas fa-user-circle user-icon"></i>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleSidebar()">&times;</div>
        <ul>
        <li><a href="dashboard.php" class="custom-link"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            <li><a href="analytics.php" class="custom-link"><i class="fas fa-chart-line"></i>Analytics</a></li>
            <li><a href="courses.php" class="custom-link"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="users.php" class="custom-link"><i class="fas fa-users"></i>Users</a></li>
            <li><a href="enrollments.php" class="custom-link"><i class="fas fa-user-graduate"></i>Enrollments</a></li>
            <li><a href="payment.php" class="custom-link"><i class="fas fa-credit-card"></i>Payments</a></li>
            <li><a href="feedbacks.php" class="custom-link"><i class="fas fa-comment-dots"></i>Feedbacks</a></li>
            <li><a href="settings.php" class="custom-link"><i class="fas fa-cog"></i>Settings</a></li>
            <li class="logout"><a href="logout.php" class="custom-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
           
            
        </ul>
    </div>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    </body>
    <script>
    function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isOpen = sidebar.style.left === '0px';

            if (isOpen) {
                sidebar.style.left = '-250px';
                overlay.style.display = 'none';
                document.body.style.backgroundColor = '';
            } else {
                sidebar.style.left = '0px';
                overlay.style.display = 'block';
                document.body.style.backgroundColor = 'rgba(0, 0, 0, 0.3)';
            }
        }
    </script>
</html>