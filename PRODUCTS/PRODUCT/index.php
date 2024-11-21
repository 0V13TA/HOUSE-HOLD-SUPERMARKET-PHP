<?php
// Get the current file name and convert it to uppercase

use PhpOption\None;

$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = $pathsArray[count($pathsArray) - 2];
$fileName = strtoupper($fileName);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fileName; ?></title>
</head>

<body>
    <?php
    include '../../TEMPLATES/header.php';

    if(isset($_GET['id'])) {
    include '../../CONFIG/mysql_connection.php';
    }
    ?>
</body>

</html>