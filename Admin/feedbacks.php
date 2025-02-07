<?php
include 'nav.php'; // Include the navigation file

// Fetch courses with average rating and total reviews
$query = "SELECT c.*, AVG(f.rating) as average_rating, COUNT(f.feedback_id) as total_reviews 
          FROM course c 
          LEFT JOIN feedbacks f ON c.course_id = f.course_id 
          GROUP BY c.course_id";
$result = mysqli_query($conn, $query);
$course = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $course[] = $row;
    }
}

// Print the courses array
// print_r($course);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    
    <style>
        .card {
            height: 100%;
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .btn-primary {
            background-color: #218838;
            border-color: #218838;
        }
        .btn-primary:hover {
            background-color: #196f2d;
            border-color: #196f2d;
        }
        .star-rating {
            color: #FFD700;
        }
        h1 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h1><center>Feedbacks</center></h1>
<div class="container mt-4">
    <div class="row">
        <?php if (!empty($course)): ?>
            <?php foreach ($course as $c): ?>
                <div class="col-12 col-lg-3 col-md-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $c['thumbnail'] ?>" class="card-img-top" alt="Course Thumbnail" onerror="this.onerror=null;this.src='default-thumbnail.jpg';">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $c['title'] ?></h5>
                            <p class="star-rating">
                                <?php
                                $average_rating = round($c['average_rating']);
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $average_rating) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </p>
                            <p><?= $c['total_reviews'] ?> reviews</p>
                            <a href="feedback_view.php?course_id=<?php echo $c['course_id'] ?>" class="btn btn-primary">View</a>
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








