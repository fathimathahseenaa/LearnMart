<?php

// include "../db.php";
include 'nav.php';
if(isset($_GET['course_id'])){

$course_id = $_GET['course_id'];

$sql = "SELECT * FROM course WHERE course_id = $course_id";
$result = mysqli_query($conn, $sql);

// $course_data = [];

if(mysqli_num_rows($result) > 0){
    $course_data = mysqli_fetch_assoc($result);
} else {
    echo "No course found with the given ID.";
}

//print_r($course_data);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration_hours = $_POST['duration_hours'];
    $languages = $_POST['languages'];
    $thumbnail = $_FILES['thumbnail']['name'] ? $_FILES['thumbnail']['name'] : $course_data['thumbnail'];
    $video_path = $_FILES['video_path']['name'] ? $_FILES['video_path']['name'] : $course_data['video_path'];

    // Handle file uploads
    $target_dir = "uploads/";
    if ($_FILES['thumbnail']['name']) {
        $thumbnail_target = $target_dir . basename($thumbnail);
        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail_target);
    } else {
        $thumbnail_target = $course_data['thumbnail'];
    }

    if ($_FILES['video_path']['name']) {
        $video_target = $target_dir . basename($video_path);
        move_uploaded_file($_FILES["video_path"]["tmp_name"], $video_target);
    } else {
        $video_target = $course_data['video_path'];
    }

    $update_sql = "UPDATE course SET title='$title', description='$description', price='$price', duration_hours='$duration_hours', languages='$languages', thumbnail='$thumbnail_target', video_path='$video_target' WHERE course_id=$course_id";

    if (mysqli_query($conn, $update_sql)) {
        $message = "Course updated successfully.";
    } else {
        $message = "Error updating course: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
   
    <style>
        .form-container {
            background-color: #fff;
            padding: 40px; /* Increased padding */
            border-radius: 10px; /* Slightly larger radius */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Softer shadow */
            position: relative;
            margin-top: 60px; /* Added margin from the navbar */
            margin-bottom: 40px; /* Space at the bottom of the container */
        }
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f1f1f1; /* Slightly lighter background */
        }
        .btn-custom {
            background-color: #218838; /* Bootstrap primary color */
            color: #fff;
            border: none;
            padding: 10px 20px; /* Added padding */
            border-radius: 5px; /* Rounded corners */
        }
        .btn-custom:hover {
            background-color: #196f2d; /* Darker shade for hover effect */
        }
        .back-arrow {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
            color: #000;
        }
        .alert {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            color: #28a745;
            z-index: 1000;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        .form-label {
            font-weight: bold; /* Bold labels */
            margin-bottom: 5px; /* Space below labels */
        }
        .form-control {
            border: 1px solid #ced4da; /* Border color */
            border-radius: 5px; /* Rounded corners */
            padding: 10px; /* Padding inside input */
            margin-bottom: 15px; /* Space between inputs */
        }
        .media-container {
            display: flex;
            align-items: center;
            gap: 20px; /* Space between thumbnail and video */
        }
        .media-container img, .media-container video {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }
        .video-container {
            position: relative;
        }
    </style>
</head>
<body>

<?php if (isset($message)): ?>
    <div class="alert alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.class.add('fade');
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }
        }, 3000);
    </script>
<?php endif; ?>


<div class="centered-container">
    <div class="form-container col-lg-6 col-md-8 col-sm-10"> <!-- Adjusted size for smaller appearance -->
        <form method="post" action="" enctype="multipart/form-data">
            <a href="courses.php" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
            <div class="form-group">
                <label for="title" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($course_data['title']); ?>">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($course_data['description']); ?>">
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($course_data['price']); ?>">
            </div>

            <div class="form-group">
                <label for="duration_hours" class="form-label">Duration</label>
                <input type="text" class="form-control" id="duration_hours" name="duration_hours" value="<?php echo htmlspecialchars($course_data['duration_hours']); ?>">
            </div>

            <div class="form-group">
                <label for="languages" class="form-label">Languages</label>
                <input type="text" class="form-control" id="languages" name="languages" value="<?php echo htmlspecialchars($course_data['languages']); ?>">
            </div>

            <div class="form-group">
                <label for="thumbnail" class="form-label">Current Thumbnail and Video</label>
                <div class="media-container">
                    <img src="<?php echo htmlspecialchars($course_data['thumbnail']); ?>" alt="Current Thumbnail">
                    <div class="video-container">
                        <video controls>
                            <source src="<?php echo htmlspecialchars($course_data['video_path']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <label for="thumbnail" class="form-label">Thumbnail </label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                <label for="thumbnail" class="form-label">Video </label>
                <input type="file" class="form-control" id="video_path" name="video_path">
            </div>

            <input type="hidden" class="form-control" id="course_id" name="course_id" value="<?php echo htmlspecialchars($course_data['course_id']); ?>">

            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS and dependencies
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

</body>
</html>

<?php

}else{

    echo "<a href='courses.php'>Page Not found. Click to view all courses </a>";
    
}
?>