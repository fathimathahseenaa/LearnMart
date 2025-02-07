<?php
include 'nav.php';
// include '../db.php'; // Make sure to include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $languages = $_POST['languages'];
    $duration = $_POST['duration'];

    // Handle video file upload
    $target_dir = "uploads/videos/";
    $target_file = $target_dir . basename($_FILES["video"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a actual video or fake video
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["video"]["tmp_name"]);
    finfo_close($finfo);
    if (strpos($mime, 'video') !== false) {
        $uploadOk = 1;
    } else {
        $message = "File is not a video.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["video"]["size"] > 50000000) { // 50MB limit
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov" && $videoFileType != "wmv") {
        $message = "Sorry, only MP4, AVI, MOV & WMV files are allowed.";
        $uploadOk = 0;
    }

    // Handle thumbnail file upload
    $thumbnail_dir = "uploads/thumbnails/";
    $thumbnail_file = $thumbnail_dir . basename($_FILES["thumbnail"]["name"]);
    $thumbnailOk = 1;
    $thumbnailFileType = strtolower(pathinfo($thumbnail_file, PATHINFO_EXTENSION));

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if ($check !== false) {
        $thumbnailOk = 1;
    } else {
        $message = "File is not an image.";
        $thumbnailOk = 0;
    }

    // Check file size
    if ($_FILES["thumbnail"]["size"] > 5000000) { // 5MB limit
        $message = "Sorry, your thumbnail file is too large.";
        $thumbnailOk = 0;
    }

    // Allow certain file formats
    if ($thumbnailFileType != "jpg" && $thumbnailFileType != "png" && $thumbnailFileType != "jpeg" && $thumbnailFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for thumbnails.";
        $thumbnailOk = 0;
    }

    // Check if $uploadOk and $thumbnailOk are set to 0 by an error
    if ($uploadOk == 0 || $thumbnailOk == 0) {
        $message = "Sorry, your files were not uploaded.";
    // if everything is ok, try to upload files
    } else {
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail_file)) {
            $video_path = $target_file;
            $thumbnail = $thumbnail_file;

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO course (title, description, price, languages, duration_hours, video_path, thumbnail) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssss", $title, $description, $price, $languages, $duration, $video_path, $thumbnail);

            // Execute the statement
            if ($stmt->execute()) {
                $message = "New course created successfully";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your files.";
            $message .= " Error details: " . $_FILES["video"]["error"] . " " . $_FILES["thumbnail"]["error"];
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    
    <style>
        .form-container {
            background-color: #fff;
            padding: 40px; /* Increased padding */
            border-radius: 10px; /* Slightly larger radius */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Softer shadow */
            position: relative;
            margin-top: 60px; /* Added margin from the navbar */
            margin-bottom: 60px; /* Added margin below the form container */
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
        <form action="" method="post" enctype="multipart/form-data">
            <a href="dashboard.php" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Course Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="languages">Languages:</label>
                    <input type="text" class="form-control" id="languages" name="languages" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="duration">Duration:</label>
                    <input type="number" class="form-control" id="duration" name="duration" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="thumbnail">Upload Thumbnail:</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="video">Upload Video:</label>
                    <input type="file" class="form-control" id="video" name="video" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-custom">Create Course</button>
        </form>
    </div>
</div>


</body>
</html>

