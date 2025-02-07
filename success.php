<?php
session_start();
if (!isset($_GET['course_id'])) {
    die("Invalid access!");
}

$course_id = $_GET['course_id']; // Get course ID from URL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: green;
        }
        p {
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🎉 Payment Successful! 🎉</h1>
    <p>Your payment has been successfully completed.</p>
    <a href="coursedetails.php?course_id=<?php echo $course_id; ?>" class="btn">View Your Course</a>
</div>

</body>
</html>
