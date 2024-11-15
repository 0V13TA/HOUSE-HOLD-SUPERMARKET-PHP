<?php
// Get the current file name and convert it to uppercase
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

// Initialize an array to store user input values
$values = ['username' => '', 'email' => '', 'phoneNumber' => '', 'profilePicture' => ''];

// Initialize a flag variable to track errors
$flagVariable = false;
$error = '';

// Check if the register form has been submitted
if (isset($_POST['register'])) {
    // Include the MySQL connection file
    include "../../config/mysql_connection.php";

    // Escape user input values to prevent SQL injection
    $values['username'] = mysqli_real_escape_string($conn, $_POST['username']);
    $values['email'] = mysqli_real_escape_string($conn, $_POST['email']);
    $values['phoneNumber'] = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $values['profilePicture'] = mysqli_real_escape_string($conn, $_POST['profilePicture']);
    $values['password'] = mysqli_real_escape_string($conn, $_POST['password']);
    $values['verifyPassword'] = mysqli_real_escape_string($conn, $_POST['verifyPassword']);

    // Initialize an empty SQL query string
    $sqlQuery = '';

    // Initialize the picture
    $targetDir = "images/";
    $fileName = basename($_FILES["profilePicture"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
        $values['profilePicture'] = $targetFilePath;
    } else {
        $flagVariable = true;
        $error = 'Sorry, there was an error uploading your file.';
    }

    // Check if the password is valid (at least 8 characters, contains uppercase, lowercase, and numbers)
    if (strlen($values['password']) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $values['password'])) {
        $flagVariable = true;
        $error = 'Sorry, Password must not be less than 8 characters and must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number.';
    }

    // Check if the password and verify password fields match
    if ($values['password'] !== $values['verifyPassword']) {
        $flagVariable = true;
        $error = 'Sorry Passwords Must be the same';
    }

    // If no errors, proceed with the registration
    if (!$flagVariable) {
        // Hash the password using bcrypt
        $hashedPassword = password_hash($values['password'], PASSWORD_BCRYPT);

        // Construct the SQL query based on the user input values
        if ($values['profilePicture'] == '') {
            $sqlQuery = "INSERT INTO users(`username`,`email`,`phone_no`, `password`) VALUES('{$values['username']}', '{$values['email']}', '{$values['phoneNumber']}', '{$hashedPassword}')";
        } elseif ($values["phoneNumber"] == '') {
            $sqlQuery = "INSERT INTO users(`username`,`email`,`user_image`, `password`) VALUES('{$values['username']}', '{$values['email']}', '{$values['profilePicture']}', '{$hashedPassword}')";
        } else {
            $sqlQuery = "INSERT INTO users(`username`,`email`,`phone_no`,`user_image`, `password`) VALUES('{$values['username']}', '{$values['email']}', '{$values['phoneNumber']}', '{$values['profilePicture']}', '{$hashedPassword}')";
        }

        // Execute the SQL query
        if (mysqli_query($conn, $sqlQuery)) {
            // Get the user ID from the last inserted ID
            $id = mysqli_insert_id($conn);

            // Start a new session
            session_start();

            // Set session variables
            $_SESSION['isLoggedIn'] = 'true';
            $_SESSION['role'] = 'user';
            $_SESSION['userId'] = $id;

            // Redirect the user to the homepage
            header("Location: http://localhost/php_projects/house-hold-supermarket/");
            exit(0);
        } else {
            $error = 'Error: ' . mysqli_error($conn);
        }
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="col s12" enctype="multipart/form-data" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" name="verifyPassword" required>
        </div>
        <div>
            <label for="profilePicture">Profile Picture:</label>
            <input type="file" name="profilePicture" accept="image/*" required>
        </div>
        <div>
            <input type="submit" name="register" value="Register">
        </div>
        <?php if (!empty($error)): ?>
            <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </form>
</body>

</html>