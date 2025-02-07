<?php
include 'nav.php'; // Include the navigation file

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Fetch course name
    $course_query = "SELECT title FROM course WHERE course_id = $course_id";
    $course_result = mysqli_query($conn, $course_query);
    $course_name = mysqli_fetch_assoc($course_result)['title'];

    // Fetch Feedbacks for the specific course
    $query = "SELECT f.*, u.username FROM feedbacks f JOIN users u ON f.user_id = u.user_id WHERE f.course_id = $course_id";
    $result = mysqli_query($conn, $query);
    $feedbacks = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $feedbacks[] = $row;
        }
    }
} else {
    echo "No course ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    
    <style>
        .feedback-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
        }
        .feedback-box .username {
            font-weight: bold;
        }
        .feedback-box .rating {
            color: #FFD700;
        }
        .feedback-box .feedback {
            margin-top: 10px;
        }
        .feedback-box .date {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.9em;
            color: #888;
        }
        .icon {
            margin-right: 5px;
        }
        h2 {
            margin-top: 5px;
        }
    </style>
</head>
<body>
<center><h2><?php echo $course_name; ?></h2></center>
<div class="container mt-4">
    
    <div class="row">
        <div class="col-12">
            <?php if (!empty($feedbacks)): ?>
                <?php foreach ($feedbacks as $feedback): ?>
                    <div class="feedback-box">
                        <div class="username">
                            <i class="fas fa-user icon"></i><?= $feedback['username'] ?> (ID: <?= $feedback['user_id'] ?>)
                        </div>
                        <div class="feedback">
                            <i class="fas fa-comment icon"></i><?= $feedback['feedback'] ?>
                        </div>
                        <div class="rating">
                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $feedback['rating']) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <div class="date">
                            <?= date('Y-m-d', strtotime($feedback['created_at'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h1>Sorry, no feedbacks found for this course.</h1>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>

</html>