<?php
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

$flagVariable = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resetPassword'])) {
    include '../../CONFIG/mysql_connection.php';
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sqlQuery = "SELECT email, username FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sqlQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);

    if (empty($userData)) {
        $errorMessage = "Email not found.";
    } else {
        require '../../CONFIG/phpMailer.php';
        $myEmail = $_ENV['EMAIL_ADDRESS'];
        $verificationCode = rand(100000, 999999);
        $mail->setFrom($myEmail, 'Omorogbe Vincentpaul');
        $mail->addAddress($email, $userData['username']);
        $mail->addReplyTo($myEmail, 'Your Name');
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body = 'Your verification code is: <b>' . $verificationCode . '</b>';
        $mail->AltBody = 'Your verification code is: ' . $verificationCode;

        if (!$mail->send()) {
            $errorMessage = 'Error sending email: ' . $mail->ErrorInfo;
        } else {
            $errorMessage = 'Verification code sent successfully!';
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
    <div class="container" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Forgot Password</span>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="input-field col s12">
                                <input name="email" type="email" class="validate" placeholder="Email">
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" name="resetPassword">Reset Password
                                <i class="material-icons right">send</i>
                            </button>
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