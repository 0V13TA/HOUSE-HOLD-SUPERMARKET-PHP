<?php
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);
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
    include '../../TEMPLATES/header.php';
    include '../../CONFIG/mysql_connection.php';

    $sqlQuery = 'SELECT username, email, phone_no, address, user_image FROM users WHERE id = ?';
    $stmt = mysqli_prepare($conn, $sqlQuery);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION['userId']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);

    $values = [
        'username' => '',
        'email' => '',
        'phoneNumber' => '',
        'address' => '',
        'profilePicture' => '',
    ];
    $error = '';

    if (isset($_POST['change']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $values['username'] = $_POST['username'];
        $values['email'] = $_POST['email'];
        $values['phoneNumber'] = $_POST['phoneNumber'];
        $values['address'] = $_POST['address'];

        // Check if a file was uploaded
        if ($_FILES["profilePicture"]["error"] != UPLOAD_ERR_NO_FILE) {
            // Delete former profile picture
            unlink($userData['user_image']);

            // Initialize the picture
            $targetDir = "../../uploads/";
            $pictureName = basename($_FILES["profilePicture"]["name"]);
            $targetFilePath = $targetDir . $pictureName;

            // Check if the file upload is successful
            if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
                $values['profilePicture'] = 'http://' . $_SERVER['SERVER_NAME'] . str_ireplace('authentication/edit_profile/index.php', '', $_SERVER['REQUEST_URI']) . "uploads/" . $pictureName;
            } else {
                $error = 'Sorry, there was an error uploading your file.';
            }
        } else {
            // If no file is uploaded, retain the existing profile picture
            $values['profilePicture'] = $userData['user_image'];
        }

        $sqlQuery = 'UPDATE users SET username=?, email=?, phone_no=?, user_image=?, address=? WHERE id=?';
        $stmt = mysqli_prepare($conn, $sqlQuery);
        mysqli_stmt_bind_param($stmt, 'ssssss', $values['username'], $values['email'], $values['phoneNumber'], $values['profilePicture'], $values['address'], $_SESSION['userId']);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: http://localhost/php_projects/house-hold-supermarket/dashboard');
        } else {
            $error = 'Sorry An Error Occurred';
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <h1 class="center-align">Edit Profile</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="col s12" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="username" type="text" name="username" placeholder="Username:" value="<?php echo $userData['username'] ?>" required>
                        </div>
                        <div class="input-field col s6">
                            <input id="email" type="email" name="email" placeholder="Email:" value="<?php echo $userData['email'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="phoneNumber" type="text" name="phoneNumber" placeholder="Phone Number:" value="<?php echo $userData['phone_no'] ?>" required>
                        </div>
                        <div class="input-field col s6">
                            <input id="address" type="text" name="address" placeholder="Address:" value="<?php echo $userData['address'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <span>Profile Picture:</span>
                            <input type="file" name="profilePicture" accept="image/*" value="<?php echo $userData['user_image'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" name="change" value="Change" class="btn">
                        </div>
                    </div>
                    <?php if ($error !== ''): ?>
                        <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>