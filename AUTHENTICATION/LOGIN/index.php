<?php
// Get the current file name and convert it to uppercase
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

// Initialize variables for user input and error handling
$userInput = ['email' => '', 'password' => ''];
$isError = false;
$errorMessage = '';

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Include the database connection file
    include '../../CONFIG/mysql_connection.php';

    // Sanitize user input to prevent SQL injection
    $userInput['email'] = mysqli_real_escape_string($conn, $_POST['email']);
    $userInput['password'] = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare a SQL query to retrieve user data
    $sqlQuery = "SELECT email, password, status FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sqlQuery);
    mysqli_stmt_bind_param($stmt, "s", $userInput['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);

    // Check if the user exists and the password is correct
    if (empty($userData)) {
        $isError = true;
        $errorMessage = 'Sorry, your password is incorrect or email not found';
    } else {
        if (!password_verify($userInput['password'], $userData['password'])) {
            $isError = true;
            $errorMessage = 'Sorry, your password is incorrect or email not found';
        }
    }

    // If no errors, start a new session and redirect the user
    if (!$isError) {
        // Start a new session
        session_start();

        // Set session variables
        $_SESSION['isLoggedIn'] = 'true';
        $_SESSION['role'] = $userData['status'];
        $_SESSION['userId'] = $userData['id']; // Use the actual user ID from the database

        // Redirect the user to the homepage
        header("Location: http://localhost/php_projects/house-hold-supermarket/");
        exit(0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$fileName | HHS";  ?></title>
</head>

<body>
    <?php include '../../TEMPLATES/header.php'; ?>
    <div class="container" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Login</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="input-field col s12">
                                <input name="email" type="email" class="validate" placeholder="Email" required>
                            </div>
                            <div class="input-field col s12">
                                <input name="password" type="password" class="validate" placeholder="Password" required>
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" name="submit">Login
                                <i class="material-icons right">send</i>
                            </button>
                            <p class="right-align">
                                <a href="http://localhost/php_projects/house-hold-supermarket/authentication/forgot_password"><small>Forgot Password?</small></a>
                            </p>
                        </form>
                        <?php if ($errorMessage !== ''): ?>
                            <div style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>