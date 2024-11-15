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
    <title><?php echo $fileName;  ?></title>
</head>

<body>
    <?php include './TEMPLATES/header.php'; ?>
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h1 class="header center-on-small-only">Welcome to Our Online Store</h1>
                    <h4 class="light center-on-small-only">Your one-stop shop for all household needs</h4>
                </div>
                <div class="col s12 m6 l6">
                    <img src="https://picsum.photos/200/300" alt="Household Items" class="responsive-img">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="https://picsum.photos/200/300">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Kitchen Essentials<i class="material-icons right">more_vert</i></span>
                        <p><a href="#">Shop Now</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Kitchen Essentials<i class="material-icons right">close</i></span>
                        <p>Get the best kitchen essentials at our online store!</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="https://picsum.photos/200/301">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Home Decor<i class="material-icons right">more_vert</i></span>
                        <p><a href="#">Shop Now</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Home Decor<i class="material-icons right">close</i></span>
                        <p>Get the best home decor items at our online store!</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="https://picsum.photos/200/302">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Cleaning Supplies<i class="material-icons right">more_vert</i></span>
                        <p><a href="#">Shop Now</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Cleaning Supplies<i class="material-icons right">close</i></span>
                        <p>Get the best cleaning supplies at our online store!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>