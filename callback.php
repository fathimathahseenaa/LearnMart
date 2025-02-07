<?php
require_once('db.php');

// Get the data sent via GET method
$data = $_GET;

// Log callback data for debugging
file_put_contents('razorpay_callback_log.txt', print_r($data, true), FILE_APPEND);

// Check if payment was successful
if (isset($data['razorpay_payment_link_status']) && $data['razorpay_payment_link_status'] == 'paid') {
    // Get the reference ID from Razorpay response (this is the payment ID stored in DB)
    $payment_id = $data['razorpay_payment_link_reference_id']; 

    // Fetch course_id from the database using the payment_id
    $stmt = $conn->prepare("SELECT course_id FROM payment WHERE payment_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $stmt->bind_result($course_id);
    $stmt->fetch();
    $stmt->close();

    // Ensure course_id is fetched correctly
    if (!$course_id) {
        die("Error: Course ID not found for payment.");
    }

    // Update the payment status
    $update_stmt = $conn->prepare("UPDATE payment SET status = 'completed' WHERE payment_id = ?");
    if (!$update_stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $update_stmt->bind_param("i", $payment_id);
    if ($update_stmt->execute()) {
        // Redirect user to success page with correct course_id
        header("Location: success.php?course_id=$course_id");
        exit();
    } else {
        echo "Error updating payment status: " . $update_stmt->error;
    }

    $update_stmt->close();
    $conn->close();
} else {
    // Payment failed or some error occurred
    echo "Payment failed or was not completed.";
}
?>
