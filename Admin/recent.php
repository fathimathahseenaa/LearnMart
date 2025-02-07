<?php
include 'nav.php';
// Fetch recent users and their courses
$sql = "SELECT users.username, course.title 
        FROM users 
        JOIN course ON users.course_id = course.id 
        ORDER BY users.created_at DESC 
        LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Users</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <style>
        .user-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info i {
            margin-right: 10px;
        }
        .view-button {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Recent Users</h1>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="user-box">';
            echo '<div class="user-info">';
            echo '<i class="fa fa-user"></i>';
            echo '<span>' . $row["username"] . '</span>';
            echo '<i class="fa fa-book"></i>';
            echo '<span>' . $row["title"] . '</span>';
            echo '</div>';
            echo '<button class="view-button">View</button>';
            echo '</div>';
        }
    } else {
        echo "No recent users found.";
    }
    $conn->close();
    ?>
</body>
</html>
