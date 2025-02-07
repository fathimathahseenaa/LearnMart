<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You are not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : null;

if ($course_id === null || !is_numeric($course_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid course ID.']);
    exit;
}

// Insert into enrollments table
$stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement: ' . htmlspecialchars($conn->error)]);
    exit;
}
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$enrollment_id = $stmt->insert_id;
$stmt->close();

// Insert into payment table
// $amount = 100; // Assuming a fixed amount for simplicity
// $status = 'pending';
// $stmt = $conn->prepare("INSERT INTO payment (user_id, course_id, amount, status) VALUES (?, ?, ?, ?)");
// if ($stmt === false) {
//     echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement: ' . htmlspecialchars($conn->error)]);
//     exit;
// }
// $stmt->bind_param("iiis", $user_id, $course_id, $amount, $status);
// $stmt->execute();
// $payment_id = $stmt->insert_id;
// $stmt->close();

// Generate payment link
// $response = generatepaymentlink($_SESSION['username'], $amount, $_SESSION['email'], $payment_id, $_SESSION['phone']);
// if (isset($response['short_url'])) {
//     // Update payment ID in the enrollments table
//     $payment_id = $response['id'];
//     $update_payment_query = "UPDATE enrollments SET payment_id = ? WHERE enrollment_id = ?";
//     $stmt = $conn->prepare($update_payment_query);
//     $stmt->bind_param("si", $payment_id, $enrollment_id);
//     $stmt->execute();
//     $stmt->close();

//     echo json_encode(['success' => true, 'payment_url' => $response['short_url']]);
// } else {
//     echo json_encode(['success' => false, 'message' => 'Error generating payment link.']);
// }

// $conn->close(); 
?>
