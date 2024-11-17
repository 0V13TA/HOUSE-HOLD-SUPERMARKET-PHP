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
            <img src="<?php echo $userData['user_image']; ?>" alt="Profile Picture" class="circle responsive-img profile-picture" style="width: 150px; height: 150px; object-fit: cover;">
            <h2 style="font-size: 24px; margin-top: 10px;"><?php echo $userData['username']; ?></h2>
        </div>
        <div class="dashboard-links" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <a href="receipts.php" class="dashboard-link">View Receipts</a>
            <a href="wishlist.php" class="dashboard-link">Wishlist</a>
        </div>
        <div class="dashboard-info">
            <h3 style="font-size: 20px;">Account Information</h3>
            <p style="font-size: 16px;">Email: <?php echo $userData['email']; ?></p>
            <p style="font-size: 16px;">Phone Number: <?php echo $userData['phone_no']; ?></p>
            <p style="font-size: 16px;">Address: <?php echo $userData['address']; ?></p>
        </div>
        <div class="dashboard-actions" style="display: flex; justify-content: space-around;">
            <a href="../AUTHENTICATION/EDIT_PROFILE/"><button class="btn waves-effect waves-light">Edit Profile</button></a>
            <a href="../AUTHENTICATION/CHANGE_PASSWORD/">
                <button class="btn waves-effect waves-light">Change Password</button></a>
        </div>
        <div class="dashboard-notifications">
            <h3 style="font-size: 20px;">Notifications</h3>
            <ul class="collection">
                <li class="collection-item">New order placed!</li>
                <li class="collection-item">Order shipped!</li>
                <li class="collection-item">Order delivered!</li>
            </ul>
        </div>
        <div class="dashboard-recommendations">
            <h3 style="font-size: 20px;">Recommended Products</h3>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product1.jpg" alt="Product 1" style="width: 100%; height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-content">
                            <p style="font-size: 16px;">Product 1</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product2.jpg" alt="Product 2" style="width: 100%; height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-content">
                            <p style="font-size: 16px;">Product 2</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="product3.jpg" alt="Product 3" style="width: 100%; height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-content">
                            <p style="font-size: 16px;">Product 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-link {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .dashboard-link:hover {
            background-color: #f0f0f0;
        }
    </style>
</body>

</html>