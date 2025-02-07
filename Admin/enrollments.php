<?php
include 'nav.php';

// Fetch data from enrollments table
$query = "
    SELECT 
        enrollments.enrollment_id, 
        users.username, 
        users.user_id, 
        course.title, 
        course.course_id, 
        payment.amount, 
        enrollments.enrollment_date, 
        payment.status 
    FROM enrollments
    JOIN users ON enrollments.user_id = users.user_id
    JOIN course ON enrollments.course_id = course.course_id
    JOIN payment ON payment.course_id = course.course_id AND payment.user_id = users.user_id
    GROUP BY enrollments.enrollment_id
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<h1><center>Enrollments</center></h1>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="enrollment-box">
                        <div class="enrollment-id">
                            <i class="fas fa-id-badge icon"></i>Enrollment ID: <?php echo $row['enrollment_id']; ?>
                        </div>
                        <div class="username">
                            <i class="fas fa-user icon"></i><?php echo $row['username']; ?> (User ID: <?php echo $row['user_id']; ?>)
                        </div>
                        <div class="course">
                            <i class="fas fa-book icon"></i><?php echo $row['title']; ?> (Course ID: <?php echo $row['course_id']; ?>)
                        </div>
                        <div class="amount">
                            <i class="fas fa-dollar-sign icon"></i><?php echo $row['amount']; ?>
                        </div>
                        <div class="enrollment-date">
                            <i class="fas fa-calendar-alt icon"></i><?php echo $row['enrollment_date']; ?>
                        </div>
                        <div class="status">
                            <i class="fas fa-info-circle icon"></i><?php echo $row['status']; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No enrollment records found.</h1>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .enrollment-box {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background-color: #f9f9f9;
        position: relative;
    }
    .enrollment-box .enrollment-id,
    .enrollment-box .username,
    .enrollment-box .course,
    .enrollment-box .amount,
    .enrollment-box .enrollment-date,
    .enrollment-box .status {
        margin-top: 10px;
    }
    .icon {
        margin-right: 5px;
    }
    h1 {
        margin-top: 5px;
    }
</style>
