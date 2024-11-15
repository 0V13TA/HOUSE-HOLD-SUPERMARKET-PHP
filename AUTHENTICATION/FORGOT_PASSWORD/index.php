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
    <?php include '../../TEMPLATES/header.php'; ?>
    <div class="container" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Forgot Password</span>
                        <form>
                            <div class="input-field col s12">
                                <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" name="action">Reset Password
                                <i class="material-icons right">send</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>