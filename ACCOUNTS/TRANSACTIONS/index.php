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
</body>

</html>