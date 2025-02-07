<?php
include 'nav.php';

// Fetch data from users table
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>
<h1><center>Users</center></h1>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="user-box">
                        <div class="username">
                            <i class="fas fa-user icon"></i><?php echo $row['username']; ?> (ID: <?php echo $row['user_id']; ?>)
                        </div>
                        <div class="email">
                            <i class="fas fa-envelope icon"></i><?php echo $row['email']; ?>
                        </div>
                        <!-- Add other fields as needed -->
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No user records found.</h1>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .user-box {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background-color: #f9f9f9;
        position: relative;
    }
    .user-box .username {
        font-weight: bold;
    }
    .user-box .email {
        margin-top: 10px;
    }
    .icon {
        margin-right: 5px;
    }
    h1 {
        margin-top: 5px;
    }
</style>
