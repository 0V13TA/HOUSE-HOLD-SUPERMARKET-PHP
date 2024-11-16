<?php
// Get the current file name and convert it to uppercase
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

// Initialize an array to store user input values
$values = [
    'username' => '',
    'email' => '',
    'phoneNumber' => '',
    'profilePicture' => ''
];

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
    $values['password'] = mysqli_real_escape_string($conn, $_POST['password']);
    $values['verifyPassword'] = mysqli_real_escape_string($conn, $_POST['verifyPassword']);
    $values['profilePicture'] = '';
    $values['address'] = mysqli_real_escape_string($conn, $_POST['address']);

    // Initialize the picture
    $targetDir = "../../uploads/";
    $pictureName = basename($_FILES["profilePicture"]["name"]);
    $targetFilePath = $targetDir . $pictureName;

    // Check if a file was uploaded
    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] == UPLOAD_ERR_OK) {
        // Check if the file upload is successful
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
            $values['profilePicture'] = 'http://' . $_SERVER['SERVER_NAME'] . str_ireplace('authentication/register/index.php', '', $_SERVER['REQUEST_URI']) . "uploads/" . $pictureName;
        } else {
            $flagVariable = true;
            $error = 'Sorry, there was an error uploading your file.';
        }
    } else {
        $values['profilePicture'] = 'https://picsum.photos/200?grayscale';
    }

    // Validate password
    if (!validatePassword($values['password'])) {
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

        // Prepare the SQL statement
        $sqlQuery = "INSERT INTO users(`username`, `email`, `phone_no`, `address`, `user_image`, `password`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sqlQuery);

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, 'ssssss', $values['username'], $values['email'], $values['phoneNumber'], $values['address'], $values['profilePicture'], $hashedPassword);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
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
                $error = 'Error: ' . mysqli_stmt_error($stmt);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $error = 'Error preparing statement: ' . mysqli_error($conn);
        }
    }
}

// Function to validate password
function validatePassword($password)
{
    return strlen($password) >= 8 && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $password);
}
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="col s12" enctype="multipart/form-data" style="position:absolute;top:calc(50% + 65px);left:50%;transform:translate(-50%,-50%);">
        <div class="row">
            <div class="input-field col s6">
                <input id="username" type="text" name="username" placeholder="Username:" required>
            </div>
            <div class="input-field col s6">
                <input id="email" type="email" name="email" placeholder="Email:" required>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="phoneNumber" type="text" name="phoneNumber" placeholder="Phone Number:" required>
            </div>
            <div class="input-field col s6">
                <input id="address" type="text" name="address" placeholder="Address:" required>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="password" type="password" name="password" placeholder="Password:" required>
            </div>
            <div class="input-field col s6">
                <input id="verifyPassword" type="password" name="verifyPassword" placeholder="Verify Password:" required>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <span>Profile Picture:</span>
                <input type="file" name="profilePicture" accept="image/*" required>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input type="submit" name="register" value="Register" class="btn">
            </div>
        </div>
        <?php if (!empty($error)): ?>
            <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </form>
</body>

</html>