<?php

/**
 * Extract the filename from the current script path and convert it to uppercase.
 */
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

/**
 * Start of HTML document.
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$fileName | HHS";  ?></title>
</head>

<body>
    <?php
    /**
     * Include the header template.
     */
    include '../TEMPLATES/header.php';

    /**
     * Include the MySQL connection configuration.
     */
    include '../CONFIG/mysql_connection.php';

    /**
     * Prepare a SQL query to retrieve user data based on the user ID.
     */
    $sqlQuery = 'SELECT * FROM users WHERE id = ?';
    $stmt = mysqli_prepare($conn, $sqlQuery);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);

    /**
     * Display the user's profile image.
     */
    ?>
    <div class="dashboard-container">
        <div class="profile-section">
            <img src="<?php echo $userData['user_image']; ?>" alt="Profile Picture" class="circle responsive-img profile-picture">
            <h2><?php echo $userData['username']; ?></h2>
        </div>
        <div class="dashboard-links">
            <a href="receipts.php">View Receipts</a>
            <a href="order-history.php">Order History</a>
            <a href="account-settings.php">Account Settings</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="coupons.php">Coupons</a>
            <a href="loyalty-program.php">Loyalty Program</a>
        </div>
        <div class="dashboard-info">
            <h3>Account Information</h3>
            <p>Email: <?php echo $userData['email']; ?></p>
            <p>Phone Number: <?php echo $userData['phone_no']; ?></p>
            <p>Address: <?php echo $userData['address']; ?></p>
        </div>
        <div class="dashboard-actions">
            <button class="btn waves-effect waves-light">Edit Profile</button>
            <button class="btn waves-effect waves-light">Change Password</button>
            <button class="btn waves-effect waves-light">Logout</button>
        </div>
        <div class="dashboard-notifications">
            <h3>Notifications</h3>
            <ul class="collection">
                <li class="collection-item">New order placed!</li>
                <li class="collection-item">Order shipped!</li>
                <li class="collection-item">Order delivered!</li>
            </ul>
        </div>
        <div class="dashboard-recommendations">
            <h3>Recommended Products</h3>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product1.jpg" alt="Product 1">
                        </div>
                        <div class="card-content">
                            <p>Product 1</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product2.jpg" alt="Product 2">
                        </div>
                        <div class="card-content">
                            <p>Product 2</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product3.jpg" alt="Product 3">
                        </div>
                        <div class="card-content">
                            <p>Product 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>