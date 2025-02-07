<?php
include 'nav.php';
// include '../db.php';

$query = "SELECT * FROM course";
$result = mysqli_query($conn, $query);

$course = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $course[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];

    if (!empty($course_id)) {
        // Check if there are any feedbacks associated with the course
        $feedback_check_query = "SELECT COUNT(*) as count FROM feedbacks WHERE course_id = ?";
        $stmt = mysqli_prepare($conn, $feedback_check_query);
        mysqli_stmt_bind_param($stmt, 'i', $course_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $feedback_count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($feedback_count > 0) {
            echo "<script>alert('Cannot delete course. There are feedbacks associated with this course.');</script>";
        } else {
            $delete_query = "DELETE FROM course WHERE course_id = ?";
            $stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($stmt, 'i', $course_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>window.location.href = window.location.href;</script>"; // Redirect to the same page
                exit;
            } else {
                echo "Error deleting course: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Course ID is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    
    <style>
        .card {
            margin-bottom: 20px;
            height: 100%;
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* number of lines to show */
            -webkit-box-orient: vertical;
        }
        .icon {
            margin-right: 5px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .action-buttons a, .action-buttons form {
            display: inline-block;
        }
        .edit-icon, .delete-icon {
            cursor: pointer;
            font-size: 20px;
        }
        .edit-icon {
            color: #4CAF50;
        }
        .delete-icon {
            color: #f44336;
            border: none;
            background: none;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        h1 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h1><center>Course List</center></h1>
<div class="container mt-4">
    <div class="row">
        <?php if (!empty($course)): ?>
            <?php foreach ($course as $c): ?>
                <div class="col-12 col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="<?php echo $c['thumbnail'] ?>" class="card-img-top" alt="Course Thumbnail" onerror="this.onerror=null;this.src='default-thumbnail.jpg';">
                        <div class="card-body">
                            <h5 class="card-title"><?= $c['title'] ?> (ID: <?= $c['course_id'] ?>)</h5>
                            <p class="card-text"><?= $c['description'] ?></p>
                            <div class="card-info">
                                <p><i class="fas fa-clock icon"></i> <?= $c['duration_hours'] ?> hours</p>
                                <p><i class="fas fa-dollar-sign icon"></i> <?= $c['price'] ?></p>
                                <p><i class="fas fa-language icon"></i> <?= $c['languages'] ?></p>
                            </div>
                            <div class="action-buttons">
                                <a href="updatecourse.php?course_id=<?php echo $c['course_id']; ?>" class="edit-icon"><i class="fas fa-edit"></i></a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="course_id" value="<?php echo $c['course_id']; ?>">
                                    <button type="submit" class="delete-icon"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1>Sorry, no courses found. Please create a new course.</h1>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
