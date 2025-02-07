<?php
include '../db.php'; // Make sure to include your database connection file


// Function to get row count
function getRowCount($conn, $tableName) {
    $sql = "SELECT COUNT(*) as count FROM $tableName";
    $result = $conn->query($sql);


    if ($result === false) {
        // If the query failed, handle the error
        die("Error: " . $conn->error);
    }
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

// Function to get total payments
function getTotalPayments($conn) {
    $sql = "SELECT SUM(amount) as total FROM payment";
    $result = $conn->query($sql);

    if ($result === false) {
        // If the query failed, handle the error
        die("Error: " . $conn->error);
    }
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Get row counts
$coursesCount = getRowCount($conn, 'course');
$feedbackCount = getRowCount($conn, 'feedbacks');
$enrollmentCount = getRowCount($conn, 'enrollments');
$userCount = getRowCount($conn, 'users');
$totalPayments = getTotalPayments($conn);

// Close connection
$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
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
        h1 {
            margin: 10px;
        }
        /* Floating + Icon */
        #plus-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #28a745;  /* Change icon color */
      color: white;
      padding: 20px;  /* Increased padding for a larger button */
      border-radius: 50%;  /* Ensure the icon is circular */
      font-size: 30px; /* Font size of the "+" symbol */
      cursor: pointer;
      z-index: 100;
      display: flex;
      justify-content: center;
      align-items: center;
      text-decoration: none; /* Removes underline */
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
    .card {
        border: none; /* Remove default border */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
        transition: transform 0.2s; /* Smooth transition for transform */
    }

    .card:hover {
        transform: translateY(-10px); /* Lift the card on hover */
    }

    .card-title {
        font-size: 1.5rem; /* Increase font size */
        font-weight: bold; /* Make the title bold */
    }

    .card-text {
        font-size: 1.2rem; /* Increase font size */
        color: #555; /* Change text color */
    }
/* .custom-link:hover {
    color: #007BFF; /* Optional: Add a hover effect, change the color */
} */

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
    <center><h1 class="dash">Dashboard</h1></center>
    <div class="container mt-4">
    <div class="row">
        <!-- Courses Count Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-book"></i> Total Courses </h5>
                    <p class="card-text"><?php echo $coursesCount; ?></p>
                    <a href="courses.php" class="btn btn-view">View</a>
                </div>
            </div>
        </div>
        <!-- Enrollment Count Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-graduate"></i> Total Enrollments</h5>
                    <p class="card-text"><?php echo $enrollmentCount; ?></p>
                    <a href="enrollments.php" class="btn btn-view">View</a>
                </div>
            </div>
        </div>
        <!-- Feedback Count Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-comment-dots"></i> Total Feedbacks </h5>
                    <p class="card-text"><?php echo $feedbackCount; ?></p>
                    <a href="feedbacks.php" class="btn btn-view">View</a>
                </div>
            </div>
        </div>
        <!-- User Count Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                    <p class="card-text"><?php echo $userCount; ?></p>
                    <a href="users.php" class="btn btn-view">View</a>
                </div>
            </div>
        </div>
        <!-- Total Payments Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-credit-card"></i> Total Payments</h5>
                    <p class="card-text"><?php echo $totalPayments; ?></p>
                    <a href="payment.php" class="btn btn-view">View</a>
                </div>
            </div>
        </div>
        
    </div>
</div>


    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <!-- Floating + Icon -->
  <a href="createcourse.php" id="plus-icon">
    +
  </a>

  <!-- Options Menu
  <div id="options-menu">
    <ul>
      <li id="create-option">Create</li>
      <li id="update-option">Update</li>
    </ul>
  </div> -->



    <script>
        // Get references to elements
    const plusIcon = document.getElementById('plus-icon');
    const optionsMenu = document.getElementById('options-menu');
    const createOption = document.getElementById('create-option');
    const updateOption = document.getElementById('update-option');

    // Function to toggle the visibility of the options menu
    plusIcon.addEventListener('click', function () {
      optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Navigate to the Create or Update page
    createOption.addEventListener('click', function () {
      window.location.href = '/create-page'; // Replace with your create page URL
    });

    updateOption.addEventListener('click', function () {
      window.location.href = '/update-page'; // Replace with your update page URL
    });
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
</body>
</html>







