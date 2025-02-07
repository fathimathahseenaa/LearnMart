<?php
// include '../db.php'; // Make sure to include your database connection file
include 'nav.php';
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
    
</head>
<body>
<div class="container mt-4">
    <center><h2>Feedbacks for Course: <?php echo $course_name; ?></h2></center>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Course ID</th>
                    <th>Feedback ID</th>
                    <th>Feedback</th>
                    <th>Ratings</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($feedbacks)): ?>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?= $feedback['user_id'] ?></td>
                            <td><?= $feedback['username'] ?></td>
                            <td><?= $feedback['course_id'] ?></td>
                            <td><?= $feedback['feedback_id'] ?></td>
                            <td><?= $feedback['feedback'] ?></td>
                            <td><?= $feedback['rating'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Sorry, no feedbacks found for this course.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>

</html>

course table

<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Duration (Hours)</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($course)): ?>
                <?php foreach ($course as $c): ?>
                    <tr>
                        <td><?php echo $c['course_id']; ?></td>
                        <td><?php echo $c['title']; ?></td>
                        <td><?php echo $c['description']; ?></td>
                        <td><?php echo $c['price']; ?></td>
                        <td><?php echo $c['duration_hours']; ?></td>
                        <td><?php echo $c['created_at']; ?></td>
                        <td><?php echo $c['updated_at']; ?></td>
                        <td class="action-buttons">
                            <a href="updatecourse.php?course_id=<?php echo $c['course_id']; ?>" class="edit-btn">Update</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="course_id" value="<?php echo $c['course_id']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Sorry, no courses found. Please create a new course.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>