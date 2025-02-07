<?php
// Database connection
include 'db.php';

// Fetch unique categories
$category_sql = "SELECT DISTINCT category FROM course";
$category_result = $conn->query($category_sql);
if ($category_result === false) {
  die("Error: " . $conn->error);
}

// Fetch all courses
$sql = "SELECT course.course_id, course.title, course.thumbnail, course.createdby, course.price, course.category, 
         (SELECT AVG(rating) FROM feedbacks WHERE course_id = course.course_id) as avg_rating, 
         (SELECT COUNT(*) FROM feedbacks WHERE course_id = course.course_id) as feedback_count 
    FROM course";
$result = $conn->query($sql);
if ($result === false) {
  die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Online Courses</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
  .course-card img {
    border-radius: 10px;
    height: 180px;
    object-fit: cover;
  }
  .category-tabs .nav-link {
    border: 1px solid #ddd;
    margin-right: 5px;
    border-radius: 20px;
    color: black; /* Set default color to black */
  }
  .category-tabs {
    margin-top: 40px;
  }
  .category-tabs .nav-link.active {
    background-color: #000;
    color: #fff;
  }
  .course-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    transition: transform 0.3s;
    margin-bottom: 20px;
    text-decoration: none; /* Remove underline */
    color: inherit; /* Inherit text color */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .course-card:hover {
    transform: scale(1.05);
  }
  .star-rating i {
    color: #FFD700;
  }
  .course-card-column {
    padding: 10px; /* Add padding to the columns */
  }
  </style>
</head>
<body>
  <div class="container my-5">
  <h2 class="text-center fw-bold">Learn smarter, grow faster, succeed better - All in one place</h2>
  <p class="text-center text-muted">From foundational knowledge to advanced expertise, Learnmart supports your professional development.</p>
  
  <!-- Tabs for categories -->
  <ul class="nav category-tabs justify-content-center mb-4" id="category-tabs">
    <li class="nav-item">
    <a class="nav-link active" data-category="all" href="#">All</a>
    </li>
    <?php
    // Ensure unique categories
    $categories = [];
    if ($category_result->num_rows > 0) {
      while ($category_row = $category_result->fetch_assoc()) {
        $category = trim($category_row["category"]);
        if (!in_array($category, $categories)) { // Avoid duplicates
          $categories[] = $category; // Track added categories
          echo '<li class="nav-item">';
          echo '<a class="nav-link" data-category="' . htmlspecialchars($category) . '" href="#">' . htmlspecialchars($category) . '</a>';
          echo '</li>';
        }
      }
    }
    ?>
  </ul>

  <!-- Course sections -->
  <div id="course-container">
    <div class="row">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 course-card-column" data-category="' . htmlspecialchars($row["category"]) . '">';
        echo '  <a href="coursedetails.php?course_id=' . htmlspecialchars($row["course_id"]) . '" class="course-card">';
        echo '    <div class="course-card-inner">';
        // Check if the thumbnail is a URL or a base64 encoded string
        if (filter_var($row["thumbnail"], FILTER_VALIDATE_URL)) {
          echo '      <img src="' . htmlspecialchars($row["thumbnail"]) . '" alt="Course Image" class="img-fluid">';
        } else {
          // Determine the MIME type of the base64 encoded image
          $mime_type = '';
          if (strpos($row["thumbnail"], '/9j/') === 0) {
            $mime_type = 'image/jpeg';
          } elseif (strpos($row["thumbnail"], 'iVBORw0KGgo') === 0) {
            $mime_type = 'image/png';
          } elseif (strpos($row["thumbnail"], 'R0lGODlh') === 0) {
            $mime_type = 'image/gif';
          }
          echo '      <img src="data:' . $mime_type . ';base64,' . htmlspecialchars($row["thumbnail"]) . '" alt="Course Image" class="img-fluid">';
        }
        echo '      <h5 class="mt-3">' . htmlspecialchars($row["title"]) . '</h5>';
        echo '      <p class="text-muted mb-1">' . htmlspecialchars($row["createdby"]) . '</p>';
        echo '      <p class="star-rating">';
        $average_rating = round($row["avg_rating"]);
        for ($i = 0; $i < 5; $i++) {
          if ($i < $average_rating) {
            echo '<i class="fas fa-star"></i>';
          } else {
            echo '<i class="far fa-star"></i>';
          }
        }
        echo ' (' . htmlspecialchars($row["feedback_count"]) . ' reviews)</p>';
        echo '      <p class="fw-bold">₹' . htmlspecialchars($row["price"]) . ' <span class="text-decoration-line-through text-muted">₹3,099</span></p>';
        echo '    </div>';
        echo '  </a>';
        echo '</div>';
      }
    } else {
      echo "No courses found.";
    }
    ?>
    </div>
  </div>
  </div>

  <script>
  // Tab functionality
  const tabs = document.querySelectorAll('.category-tabs .nav-link');
  const courseCards = document.querySelectorAll('.course-card-column');

  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
    e.preventDefault();

    // Remove active class from all tabs
    tabs.forEach(t => t.classList.remove('active'));

    // Add active class to the clicked tab
    tab.classList.add('active');
    const category = tab.getAttribute('data-category');

    // Show/Hide courses based on category
    courseCards.forEach(card => {
      if (category === 'all' || card.getAttribute('data-category') === category) {
      card.style.display = 'block';
      } else {
      card.style.display = 'none';
      }
    });
    });
  });

  // Trigger click on the "All" tab to show all courses by default
  document.querySelector('.category-tabs .nav-link[data-category="all"]').click();
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>