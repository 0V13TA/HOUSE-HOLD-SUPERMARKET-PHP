<?php
$pathsArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
$fileName = array_pop($pathsArray);
$fileName = explode('.', $fileName);
$fileName = strtoupper($fileName[0]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$fileName | HHS";  ?></title>
</head>

<body>
    <?php include './TEMPLATES/header.php'; ?>
</body>

</html>