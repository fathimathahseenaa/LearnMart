<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST['course_id'];
    $price = $_POST['price'];
    $username = $_SESSION["username"];

    // Fetch user ID from the users table using the session username
    $stmt = $conn->prepare("SELECT user_id, email FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        die("Error executing the SQL query: " . $stmt->error);
    }
    $stmt->bind_result($user_id,$email);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id && !$email) {
        die("User not found.");
    }

    // Insert payment details into the database
    $status = "pending";
    $stmt = $conn->prepare("INSERT INTO payment (user_id, course_id, amount, status) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }
    $stmt->bind_param("iids", $user_id, $course_id, $price, $status);
    if (!$stmt->execute()) {
        die("Error executing the SQL query: " . $stmt->error);
    }

    // Get the inserted ID (payment ID) to use as the reference_id
    $payment_id = $stmt->insert_id;
    $stmt->close();

    // Generate payment link
    $response = generatepaymentlink($email, $price * 100, $email, $payment_id, "987654321");
    print_r($response);
    if (isset($response['short_url'])) {
        header("Location: " . $response['short_url']); // Redirect to Razorpay payment link
        exit();
    } else {
        echo "Error generating payment link.";
    }
}

function generatepaymentlink($name, $amount, $email, $reference_id, $phone)
{
    date_default_timezone_set('Asia/Kolkata'); // Set timezone to Asia/Kolkata
    $expiry_timestamp = time() + (30 * 60); // Expiry time = current time + 30 minutes

    // Razorpay API credentials
    $api_key = "rzp_test_RcJak5fcO3zfR9";  // Your Razorpay Test API Key
    $api_secret = "ul8MqhYAbfpeikySEmq7vr6B"; // Your Razorpay Test API Secret

    // Razorpay API endpoint
    $url = "https://api.razorpay.com/v1/payment_links";

    // Payment request data
    $data = [
        "amount" => $amount, // Amount in paise
        "currency" => "INR",
        "accept_partial" => false,
        "expire_by" => $expiry_timestamp,
        "reference_id" => "$reference_id", // Use inserted payment ID as reference
        "description" => "Payment for Course ID: $reference_id",
        "customer" => [
            "name" => "$name",
            "contact" => "$phone",
            "email" => "$email"
        ],
        "notify" => [
            "sms" => true,
            "email" => true
        ],
        "reminder_enable" => true,
        "notes" => [
            "course_id" => "$reference_id"
        ],
        "callback_url" => "http://localhost/project/callback.php", // Update callback URL
        "callback_method" => "get"
    ];

    // Convert data to JSON
    $json_data = json_encode($data);

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$api_key:$api_secret")
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    // Execute cURL request
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response from Razorpay
    $response_data = json_decode($response, true);

    // Return payment link if successful
    if (isset($response_data['short_url'])) {
        return $response_data;
    } else {
        return ["error" => "Could not generate payment link", "response" => $response_data];
    }
}
?>
