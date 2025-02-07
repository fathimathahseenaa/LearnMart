<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll - Learnmart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #28a745; /* Changed header color */
            color: #fff;
            padding: 10px 20px;
        }
        .header .logo {
            font-size: 24px;
        }
        .header .profile {
            position: relative;
        }
        .header .profile .initials {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff; /* Background color */
            color: #28a745; /* Text color */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
        }
        .header .profile .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            color: #333;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .header .profile .dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }
        .header .profile .dropdown a:hover {
            background-color: #ddd;
        }
        .content {
            padding: 20px;
        }
        .course {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .course img {
            width: 150px;
            height: 100px;
            margin-right: 20px;
        }
        .course-details {
            flex-grow: 1;
        }
        .course-title {
            font-size: 24px;
            margin: 0 0 10px;
        }
        .course-price {
            font-size: 18px;
            color: #888;
        }
        .enroll-count {
            background-color:rgb(10, 16, 13);
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: none;
            margin-right: 10px;
            border-radius:20px;
        }
        .payment-button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
   
</head>
<body>
    <div class="header">
        <div class="logo">LearnMart</div>
        <div class="profile">
            <?php
            session_start();
            include 'db.php';
        

            if (isset($_SESSION['username'])) {
                $user_name = $_SESSION['username'];
                $initial = strtoupper($user_name[0]);
                
                // Fetch user details from the database
                $stmt_user = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
                if ($stmt_user === false) {
                    echo "<p>Failed to prepare the SQL statement: " . htmlspecialchars($conn->error) . "</p>";
                    exit;
                }
                $stmt_user->bind_param("s", $user_name);
                $stmt_user->execute();
                $result_user = $stmt_user->get_result();
                
                if ($result_user && $result_user->num_rows > 0) {
                    $user = $result_user->fetch_assoc();
                    $_SESSION['user_id'] = $user['user_id'];
    
            
                    $user_id = $user['user_id'];
                } else {
                    echo "<script>
                            alert('User details not found. Please log in again.');
                            window.location.href='User/login.php';
                          </script>";
                    exit;
                }
                $stmt_user->close();
            ?>
                <div class="initials" onclick="toggleDropdown()"><?php echo $initial; ?></div>
                <div class="dropdown" id="dropdown">
                    <a href="logout.php">Logout</a>
                </div>
            <?php
            } else {
            ?>
                <a href="User/login.php" class="login-button">Login</a>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="content">
        <?php
        // Assuming you have a database connection established
        include 'db.php';
        
        // Fetch the course ID from the URL
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;

        // Validate course ID
        if ($course_id === null || !is_numeric($course_id)) {
            echo "<p>Invalid course ID.</p>";
            exit; 
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM course WHERE course_id = ?");
        if ($stmt === false) {
            echo "<p>Failed to prepare the SQL statement: " . htmlspecialchars($conn->error) . "</p>";
            exit;
        }
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $course = $result->fetch_assoc();

            // Fetch enrollments count from the enrollments table
            $stmt_enrollments = $conn->prepare("SELECT COUNT(*) as enrollment_count FROM enrollments WHERE course_id = ?");
            if ($stmt_enrollments === false) {
                echo "<p>Failed to prepare the SQL statement: " . htmlspecialchars($conn->error) . "</p>";
                exit;
            }
            $stmt_enrollments->bind_param("i", $course_id);
            $stmt_enrollments->execute();
            $result_enrollments = $stmt_enrollments->get_result();
            $enrollments = $result_enrollments->fetch_assoc();
            $enrollment_count = $enrollments['enrollment_count'];
        ?>
            <div class="course">
                <img src="<?php echo htmlspecialchars($course['thumbnail']); ?>" alt="Course Thumbnail">
                <div class="course-details">
                    <div class="course-title"><?php echo htmlspecialchars($course['title']); ?></div>
                    <div class="course-price">Total Price: $<?php echo htmlspecialchars($course['price']); ?></div>
                </div>
                <button class="enroll-count"> <?php echo htmlspecialchars($enrollment_count); ?> already enrolled</button>
                <!-- <button class="payment-button" onclick="continueToPayment(<?php echo htmlspecialchars($course['course_id']); ?>, <?php echo htmlspecialchars($course['price']); ?>)">Continue to Payment</button> -->
                <form method="POST" action="payment.php">
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['course_id']); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($course['price']); ?>">
                    <button type="submit" class="payment-button">Continue to Payment</button>
                </form>

            </div>
        <?php
            $stmt_enrollments->close();
        } else {
            echo "<p>Course not found.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
    <!-- <script>
        function continueToPayment(courseId, amount) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_payment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var options = {
                            "key": "rzp_test_RcJak5fcO3zfR9", // Your Razorpay API Key
                            "amount": amount * 100, // Amount is in currency subunits. Default currency is INR. Hence, 100 refers to 100 paise
                            "currency": "INR",
                            "name": "Learnmart",
                            "description": "Course Payment",
                            "image": "https://example.com/your_logo",
                            "order_id": response.payment_id, // This is a sample Order ID. Pass the `id` obtained in the previous step
                            "handler": function (response){
                                // Handle successful payment here
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", "update_payment_status.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        alert('Payment successful. Your course has been enrolled.');
                                        window.location.href = 'success.php';
                                    }
                                };
                                xhr.send("payment_id=" + response.razorpay_payment_id);
                            },
                            "prefill": {
                                "name": "<?php echo $_SESSION['username']; ?>",
                                "email": "<?php echo $_SESSION['email']; ?>",
                                "contact": "<?php echo $_SESSION['phone']; ?>"
                            },
                            "notes": {
                                "address": "Learnmart Corporate Office"
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else {
                        alert('Error during payment initiation: ' + response.message);
                    }
                }
            };
            xhr.send("course_id=" + courseId + "&amount=" + amount);
        }
    </script> -->
    <div class="footer">
        &copy; 2025 Learnmart
    </div>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }
    </script>
</body>
</html>