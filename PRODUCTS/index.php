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
    <title><?= $fileName ?> | HHS</title>
    <link rel="stylesheet" href="../ASSETS/CSS/style.css">
</head>

<body>
    <?php include '../TEMPLATES/header.php'; ?>
    <?php
    $name = 'All Products';
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include '../CONFIG/mysql_connection.php';

        $result = null;

        if (strtolower($_GET['category']) === 'all products') {
            $sqlQuery = "SELECT * FROM products";
            $stmt = mysqli_prepare($conn, $sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sqlQuery = "SELECT * FROM products WHERE category = ?";
            $stmt = mysqli_prepare($conn, $sqlQuery);
            $stmt->bind_param("s", $_GET["category"]);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if (!$result) {
            echo 'Connection error: ' . mysqli_error($conn);
            exit(1);
        }

        $name = $_GET['category'];
        $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    ?>

    <div class="filter-section">
        <h1 class="center-align"><?= $name ?></h1>
        <form action="http://localhost/php_projects/house-hold-supermarket/products" class="filter-form">
            <select name="category" class="center">
                <option value="All Products">All Products</option>
                <option value="Kitchen Equipment">Kitchen Equipment</option>
                <option value="Laundry Equipment">Laundry Equipment</option>
                <option value="Cleaning Equipment">Cleaning Equipment</option>
                <option value="Bathroom Equipment">Bathroom Equipment</option>
                <option value="Bedroom Equipment">Bedroom Equipment</option>
                <option value="Living Room Equipment">Living Room Equipment</option>
                <option value="Outdoor Equipment">Outdoor Equipment</option>
                <option value="Safety Equipment">Safety Equipment</option>
                <option value="Tools">Tools</option>
                <option value="Miscellaneous">Miscellaneous</option>
            </select>
            <button class="filter-btn">Filter</button>
        </form>
    </div>

    <section class="container">
        <div class="row">
            <?php foreach ($userData as $key => $value): ?>
                <div class="col s6 md3">
                    <div class="card">
                        <div class="card-content center">
                            <?php if ($value['image'] == 'None'): ?>
                                <img src="../assets/images/image.jpg" alt="<?= $value['name']; ?>">
                            <?php else: ?>
                                <img src="<?= $value['image'] ?>" alt="<?= $value['name']; ?>">
                            <?php endif; ?>
                            <h3><?= $value['name']; ?></h3>
                            <p><strike>N</strike><?= $value['price_naira']; ?></p>
                            <div class="card-action right-align">
                                <a href="http://localhost/php_projects/house-hold-supermarket/products/product/?id=<?= $value['id']; ?>" class="brand-text">More Info</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <style>
        .filter-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .filter-form {
            display: block;
            width: 40%;
            height: auto;
            margin: 10px auto;
        }

        .filter-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background-color: #3e8e41;
        }

        .card {
            margin: 20px;
        }

        .card-content {
            padding: 20px;
        }

        .card-content img {
            width: 20%;
            height: auto;
            object-fit: cover;
        }

        .card-action {
            padding: 10px;
        }

        .brand-text {
            color: #4CAF50;
            text-decoration: none;
        }

        .brand-text:hover {
            color: #3e8e41;
        }
    </style>

    <script src="../ASSETS/JQUERY/jquery-1.12.4.js"></script>
    <script>
        $('.filter-form select').on('change', () => {
            $('.center-align').empty();
            $('.center-align').append($('.filter-form select').val());
            $('.filter-form').submit();
        })
    </script>
</body>

</html>