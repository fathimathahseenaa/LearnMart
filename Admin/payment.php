<?php
include 'nav.php'; // Include the navigation file

// Fetch payment data
$query = "SELECT p.payment_id, u.username, c.title, p.course_id, p.amount, p.payment_date, p.status 
          FROM payment p 
          JOIN users u ON p.user_id = u.user_id 
          JOIN course c ON p.course_id = c.course_id";
$result = mysqli_query($conn, $query);
$payments = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    
    <style>
        .payment-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
        }
        .payment-box .username {
            font-weight: bold;
        }
        .payment-box .amount {
            color: green;
        }
        .payment-box .status {
            margin-top: 10px;
        }
        .payment-box .date {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.9em;
            color: #888;
        }
        .icon {
            margin-right: 5px;
        }
        h1 {
            margin-top: 5px;
        }
    </style>
</head>
<body>
<center><h1>Payments</h1></center>
<div class="container mt-4">
   
    <div class="row">
        <div class="col-12">
            <?php if (!empty($payments)): ?>
                <?php foreach ($payments as $payment): ?>
                    <div class="payment-box">
                        <div class="username">
                            <i class="fas fa-user icon"></i><?= $payment['username'] ?> (ID: <?= $payment['payment_id'] ?>)
                        </div>
                        <div class="course">
                            <i class="fas fa-book icon"></i><?= $payment['title'] ?> (Course ID: <?= $payment['course_id'] ?>)
                        </div>
                        <div class="amount">
                            <i class="fas fa-dollar-sign icon"></i><?= $payment['amount'] ?>
                        </div>
                        <div class="status">
                            <i class="fas fa-info-circle icon"></i><span class="status-green"><?= $payment['status'] ?></span>
                        </div>
                        <div class="date">
                            <?= date('Y-m-d', strtotime($payment['payment_date'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h1>No payment records found.</h1>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
