<?php
session_start();
include 'db.php';
include 'nav.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
//     // Fetch user_id from the users table
//     $stmt_user = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
//     if ($stmt_user === false) {
//         echo "Error: " . htmlspecialchars($conn->error);
//         exit;
//     }
//     $stmt_user->bind_param("s", $username);
//     $stmt_user->execute();
//     $result_user = $stmt_user->get_result();
    
//     if ($result_user && $result_user->num_rows > 0) {
//         $user = $result_user->fetch_assoc();
//         $user_id = $user['user_id'];
//         $_SESSION['user_id'] = $user_id; // Ensure user_id is stored in session
//     } else {
//         echo "<script>
//                 alert('User details not found. Please log in again.');
//                 window.location.href='User/login.php';
//               </script>";
//         exit;
//     }
//     $stmt_user->close();
// } else {
//     echo "<script>
//             alert('You are not logged in. Please log in first.');
//             window.location.href='User/login.php';
//           </script>";
//     exit;
}

// Fetch course details from the database
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : 1; // Default to course_id 1 if not provided

$sql = "SELECT * FROM course WHERE course_id = $course_id";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    echo "No course found.";
    exit;
}

// Fetch ratings and feedback count from the feedbacks table
$sql_feedback = "SELECT AVG(rating) as avg_rating, COUNT(*) as feedback_count FROM feedbacks WHERE course_id = $course_id";
$result_feedback = $conn->query($sql_feedback);

if ($result_feedback === false) {
    echo "Error: " . $conn->error;
    exit;
}

$feedback = $result_feedback->fetch_assoc();
$avg_rating = round($feedback['avg_rating']);
$feedback_count = $feedback['feedback_count'];

// Fetch enrollments count from the enrollments table
$sql_enrollments = "SELECT COUNT(*) as enrollment_count FROM enrollments WHERE course_id = $course_id";
$result_enrollments = $conn->query($sql_enrollments);

if ($result_enrollments === false) {
    echo "Error: " . $conn->error;
    exit;
}

$enrollments = $result_enrollments->fetch_assoc();
$enrollment_count = $enrollments['enrollment_count'];

// Fetch feedbacks for the specific course
$sql_feedbacks = "SELECT users.username, feedbacks.feedback FROM feedbacks JOIN users ON feedbacks.user_id = users.user_id WHERE feedbacks.course_id = $course_id ORDER BY feedbacks.created_at DESC LIMIT 3";
$result_feedbacks = $conn->query($sql_feedbacks);




// Check if the user has paid for the course
$sql_payment = "SELECT * FROM payment WHERE user_id = (SELECT user_id FROM users WHERE username = '$username') AND course_id = $course_id";
$result_payment = $conn->query($sql_payment);
if ($result_payment === false) {
  echo "Error: " . $conn->error;
  exit;
}
$has_paid = $result_payment->num_rows > 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Details</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    .big-box {
      flex: 1; /* Increase the size of the big box */
      padding: 20px;
      background-color: #d9f9d9;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start; /* Align items to the left */
    }

    .big-box h1 {
      margin: 0 0 10px;
      font-size: 28px; /* Increase text size */
      color: #333;
    }

    .big-box p {
      margin: 5px 0;
      font-size: 18px; /* Increase text size */
      color: #555;
    }

    .enroll-button {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #4caf50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      font-size: 18px; /* Increase text size */
    }

    .enroll-button:hover {
      background-color: #45a049;
    }

    .details-box {
      background-color: white;
      border-radius: 8px;
      padding: 30px 50px; /* Increase padding */
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 10px;
      margin: 20px;
      margin-top: -40px; /* Move the box a little higher */
      margin-left: 40px; /* Adjust space to the left */
      margin-right: 40px; /* Adjust space to the right */
      box-sizing: border-box;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .details-box span {
      font-size: 16px; /* Increase text size */
      color: #333;
      flex: 1 1 45%; /* Ensure contents are in the same row and have equal width */
      box-sizing: border-box;
      padding: 10px;
      text-align: center; /* Center align text */
    }

    .details-box span {
      font-size: 16px; /* Increase text size */
      color: #333;
      flex: 1 1 auto; /* Ensure contents are in the same row */
    }

   

    .user-info {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }

    .user-icon {
      font-size: 20px;
      margin-right: 10px;
      border-radius: 50%;
      background-color: #28a745;
      color: #fff;
      padding: 10px;
    }

    .username {
      font-size: 14px;
      font-weight: bold;
      color: #28a745;
    }

    .feedback-text {
      font-size: 14px;
      color: #555;
    }

    h3 {
      text-align: center;
      margin-top: 20px;
      font-size: 20px;
      color: #333;
    }
  </style>
  <!-- Include Font Awesome for user icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  
  <div class="big-box" style="flex: 2; padding: 40px; background-color: #e0f7e0;">
    <div style="display: flex; justify-content: space-between; width: 100%;">
      <div style="flex: 1; padding-right: 40px;">
        <h1><strong><?php echo $course['title']; ?></strong></h1>
        <p><?php echo $course['description']; ?></p>
        <p>Created By: <?php echo $course['createdby']; ?></p>
        <a href="#" class="enroll-button">Enroll</a>
      </div>
      <div style="flex: 1; padding-left: 200px;">
        <div class="media">
          <div class="lock-overlay">
            <img src="<?php echo $course['thumbnail']; ?>" alt="Course Thumbnail" class="thumbnail">
            <?php if (!$has_paid): ?>
            <div class="lock-text"><strong>Enroll for Access</strong></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div id="enrollModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2><?php echo $course['title']; ?></h2>
      <p><strong>$<?php echo $course['price']; ?></p></strong> 
      <p>Enroll Today & Get:</p>
      <ul>
        <li>Unlimited access to engaging lessons (videos & readings)</li>
        <li>Hands-on graded assignments</li>
        <li>Your final grade upon completion</li>
        <li>A certificate to showcase your achievement!</li>
      </ul>
      <a href="enroll.php?course_id=<?php echo $course_id; ?>" class="continue-button" onclick="enrollUser(<?php echo $course_id; ?>)">Continue to Enroll</a>
    </div>
    
  </div>

  <script>
    var modal = document.getElementById("enrollModal");
    var btn = document.querySelector(".enroll-button");
    var span = document.getElementsByClassName("close")[0];
    var content = document.querySelector("body > :not(#enrollModal)");

    btn.onclick = function() {
      modal.style.display = "block";
      content.style.filter = "blur(5px)";
    }

    span.onclick = function() {
      modal.style.display = "none";
      content.style.filter = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
        content.style.filter = "none";
      }
    }

    function enrollUser(courseId) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "process_enrollment.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
            alert('Enrollment successful. Please complete the payment to start the course.');
            window.location.href = response.payment_url;
          } else {
            alert('Error during enrollment: ' + response.message);
          }
        }
      };
      xhr.send("course_id=" + courseId);
    }
  </script>

  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      text-align: center;
      position: relative;
    }

    .close {
      color: #aaa;
      position: absolute;
      top: 5px;
      right: 10px;
      font-size: 28px;
      font-weight: normal;
    }

    .close:hover,
    .close:focus {
      color: #888;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-content p strong {
      color: black;
    }

    .modal-content p:nth-of-type(2) {
      font-weight: bold;
      color: black;
    }

    .modal-content ul {
      list-style: none;
      padding: 0;
      text-align: left;
    }

    .modal-content ul li {
      margin: 10px 0;
    }

    .modal-content ul li::before {
      content: "✔";
      color: black;
      margin-right: 10px;
    }

    .continue-button {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4caf50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      font-size: 18px;
      width: auto;
    }
    

    .continue-button:hover {
      background-color: #45a049;
    }
    .thumbnail {
    width: 400px; /* Set a fixed width */
    height: 400; /* Set a fixed height */
    object-fit: cover; /* Ensure the image covers the area */
    border: 2px solid #ddd;
    border-radius: 10px;
    margin-bottom: 10px;
  }

  .lock-overlay {
    position: relative;
    display: inline-block;
    text-align: center;
  }

  .lock-overlay img {
    display: block;
  }

  .lock-overlay::after {
    content: "\f023";
    font-family: FontAwesome;
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 48px;
    color:white; /* Changed the color to red with some transparency */
  }

  .lock-text {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    color: white;
  }
  </style>
  </div>
  <div class="details-box">
    <span><strong>Price:</strong> $<?php echo $course['price']; ?></span>
    <span><strong>Language:</strong> <?php echo $course['languages']; ?></span>
    <span><strong>Ratings:</strong> <?php echo str_repeat('&#9733;', $avg_rating) . str_repeat('&#9734;', 5 - $avg_rating); ?> (<?php echo $feedback_count; ?> reviews)</span>
    <span><strong>Enrollments:</strong> <?php echo $enrollment_count; ?></span>
  </div>



  <div class="container">
        <h2 class="title"><b>Learner Reviews</b></h2>
        <div class="review-section">
            <!-- Left: Ratings Summary -->
            <div class="rating-summary">
                <span class="average-rating"><i class="fas fa-star" style="color: gold !important;"></i> 4.7</span>
                <span class="total-reviews">317 reviews</span>
                <div class="rating-bars">
                    <div class="rating-row">
                        <span>5 stars</span>
                        <div class="bar"><div class="fill" style="width: 82%;"></div></div>
                        <span>82.37%</span>
                    </div>
                    <div class="rating-row">
                        <span>4 stars</span>
                        <div class="bar"><div class="fill" style="width: 13%;"></div></div>
                        <span>13.37%</span>
                    </div>
                    <div class="rating-row">
                        <span>3 stars</span>
                        <div class="bar"><div class="fill" style="width: 2%;"></div></div>
                        <span>2.43%</span>
                    </div>
                    <div class="rating-row">
                        <span>2 stars</span>
                        <div class="bar"><div class="fill" style="width: 1%;"></div></div>
                        <span>0.91%</span>
                    </div>
                    <div class="rating-row">
                        <span>1 star</span>
                        <div class="bar"><div class="fill" style="width: 1%;"></div></div>
                        <span>0.91%</span>
                    </div>
                </div>
            </div>

            <!-- Right: Reviews List -->
             
            <div class="reviews">
                <div class="review">
                    <div class="user-initial">Y</div>
                    <div class="review-content">
                        <div class="user-name">YE</div>
                        <div class="review-rating"><i class="fas fa-star" style="color: gold !important;"></i> 5 • Reviewed on Dec 2, 2024</div>
                        <p>An excellent course. The instructors presented the course very well. I have learnt a lot.</p>
                    </div>
                </div>

                <div class="review">
                    <div class="user-initial">M</div>
                    <div class="review-content">
                        <div class="user-name">MP</div>
                        <div class="review-rating"><i class="fas fa-star" style="color: gold !important;"></i> 5 • Reviewed on Jan 22, 2025</div>
                        <p>I really appreciate the form and quiz. Final PDF summary of the course received at the end is very useful. I highly recommend this training.</p>
                    </div>
                </div>

                <div class="review">
                    <div class="user-initial">A</div>
                    <div class="review-content">
                        <div class="user-name">AK</div>
                        <div class="review-rating"><i class="fas fa-star" style="color: gold !important;"></i> 5 • Reviewed on Nov 10, 2024</div>
                        <p>The only component missing is free access to Generative AI tools during the course.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="view-more">View more reviews</a>
    </div>

    <style>
   /* body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    margin: 0;
    padding: 20px;
} */

/* Add some margin on the sides */
.container {
    max-width: 80%;
    margin: 0 auto;
}

.title {
    font-size: 22px;
    margin-bottom: 10px;
    text-align: left;
}

/* Layout for Ratings and Reviews */
.review-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    width: 100%;
}

/* Left: Ratings Summary */
.rating-summary {
    width: 30%;
}

.average-rating {
    font-size: 24px;
    font-weight: bold;
    color: #ff9800;
}

.total-reviews {
    font-size: 14px;
    color: gray;
    display: block;
    margin-bottom: 10px;
}

.rating-bars {
    width: 100%;
}

.rating-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    margin: 5px 0;
}

.bar {
    width: 50%;
    height: 8px;
    background: #ddd;
    border-radius: 5px;
    margin: 0 10px;
    overflow: hidden;
}

.fill {
    height: 100%;
    background: #28a745;
    border-radius: 5px;
}

/* Right: Reviews */
.reviews {
    width: 65%;
}

.review {
    display: flex;
    background: #ffffff;
    margin: 10px 0;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    align-items: center;
}

.user-initial {
    width: 40px;
    height: 40px;
    background: #28a745;
    color: white;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 10px;
}

.review-content {
    flex: 1;
}

.user-name {
    font-weight: bold;
}

.review-rating {
    font-size: 14px;
    color: gray;
    margin-bottom: 5px;
}

p {
    margin: 0;
}

.view-more {
    display: block;
    text-align: right;
    margin-top: 10px;
    color: #28a745;
    text-decoration: none;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 1024px) {
    .container {
        max-width: 90%;
    }
}

@media (max-width: 768px) {
    .review-section {
        flex-direction: column;
        align-items: center;
    }

    .rating-summary, .reviews {
        width: 100%;
        text-align: center;
    }

    .rating-row {
        justify-content: center;
    }
}
</style>
<?php
include 'foot.php'
?>

  
</body> 
</html>