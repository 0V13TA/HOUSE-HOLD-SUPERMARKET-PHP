<?php
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);

$values = ['email' => '', 'password' => ''];

if (isset($_POST['submit'])) {
    include '../../CONFIG/mysql_connection.php';
    $values['email'] = mysqli_real_escape_string($conn, $_POST['email']);
    $values['password'] = mysqli_real_escape_string($conn, $_POST['password']);

    $sqlQuery = "SELECT email, ";
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
                                <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="password" type="password" class="validate">
                                <label for="password">Password</label>
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" name="submit">Login
                                <i class="material-icons right">send</i>
                            </button>
                            <p class="right-align">
                                <a href="http://localhost/php_projects/house-hold-supermarket/authentication/forgot_password"><small>Forgot Password?</small></a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>