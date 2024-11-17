<?php
// Get the current file name and convert it to uppercase
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$fileName | HHS"; ?></title>
</head>

<body>
    <?php include '../../TEMPLATES/header.php'; ?>
    <?php
    // Initialize variables to track errors and user input
    $error = '';
    $oldPassword = '';
    $newPassword = '';
    $verifyNewPassword = '';

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Get user input from the form
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $verifyNewPassword = $_POST['verifyNewPassword'];

        // Connect to the database
        include '../../CONFIG/mysql_connection.php';

        // Check the old password
        $sqlQuery = 'SELECT password FROM users WHERE id=?';
        $stmt = mysqli_prepare($conn, $sqlQuery);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION['userId']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        // Check if the old password is correct
        if (!password_verify($oldPassword, $userData['password'])) {
            $error = 'Sorry but your old password is wrong';
        }

        // Check if the new passwords match
        if ($newPassword !== $verifyNewPassword) {
            $error = 'Sorry but your passwords don\'t match';
        }

        // Check if the new password is different from the old one
        if ($newPassword === $oldPassword) {
            $error = 'Sorry your password must be different from your old one.';
        }

        // Check if the new password is valid
        if (!validatePassword($newPassword)) {
            $error = 'Sorry, Password must not be less than 8 characters and must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number.';
        }

        // If there are no errors, update the password
        if (!$error) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sqlQuery = 'UPDATE users SET password = ? WHERE id=?';
            $stmt = mysqli_prepare($conn, $sqlQuery);
            mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $_SESSION['userId']);
            if (!mysqli_stmt_execute($stmt)) {
                $error = 'Error Changing Password. Pls Try Again Later.';
                exit(1);
            } else {
                header('Location: http://localhost/php_projects/house-hold-supermarket/dashboard');
            }
        }
    }

    // Function to validate a password
    function validatePassword($password)
    {
        return strlen($password) >= 8 && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $password);
    }
    ?>
    <div class="container" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Change Password</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="input-field col s12">
                                <input name="oldPassword" type="password" class="validate" placeholder="Old Password" required>
                            </div>
                            <div class="input-field col s12">
                                <input name="newPassword" type="password" class="validate" placeholder="New Password" required>
                            </div>
                            <div class="input-field col s12">
                                <input name="verifyNewPassword" type="password" class="validate" placeholder="Verify New Password" required>
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" name="submit">Change
                                <i class="material-icons right">send</i>
                            </button>
                        </form>
                        <?php if ($error): ?>
                            <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>