<?php
// Database connection
include 'db.php';

// Fetch feedbacks
$sql = "SELECT users.username, feedbacks.feedback FROM feedbacks JOIN users ON feedbacks.user_id = users.user_id ORDER BY feedbacks.created_at DESC LIMIT 4";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . htmlspecialchars($conn->error);
    $conn->close();
    exit;
}

echo '<h2>Feedbacks from Learners</h2>';

if ($result->num_rows > 0) {
    echo '<div class="feedback-container">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="feedback-box">';
        echo '<div class="user-info">';
        echo '<i class="fa fa-user user-icon"></i>';
        echo '<span class="username">' . htmlspecialchars($row["username"]) . '</span>';
        echo '</div>';
        echo '<p class="feedback-text">' . htmlspecialchars($row["feedback"]) . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No feedbacks found.";
}

$conn->close();
?>

<style>
.feedback-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around; /* Ensure space between feedback boxes without touching corners */
    padding: 20px; /* Add padding to container */
}

.feedback-box {
    border: 1px solid #ccc;
    padding: 20px;
    width: 250px; /* Adjusted width */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Enhanced box shadow */
    background-color: #fff; /* Changed background color */
    border-radius: 10px; /* Added border radius */
    transition: transform 0.3s, box-shadow 0.3s; /* Added transition for hover effect */
}

.feedback-box:hover {
    transform: translateY(-10px); /* Lift the box on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px; /* Space between user info and feedback text */
}

.user-icon {
    font-size: 20px;
    margin-right: 10px;
    border-radius: 50%; /* Make the icon round */
    background-color: #28a745; /* Changed background color to match theme */
    color: #fff; /* Changed icon color */
    padding: 10px; /* Add padding to the icon */
}

.username {
    font-size: 14px;
    font-weight: bold;
    color: #28a745; /* Changed text color to match theme */
}

.feedback-text {
    font-size: 14px;
    color: #555; /* Adjusted text color */
}

h2 {
    text-align: center;
    margin-top: 20px;
    font-size: 24px;
    color: #333;
}
</style>

<!-- Include Font Awesome for user icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">