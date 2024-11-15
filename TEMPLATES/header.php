<?php
session_start();

if ($_SERVER['PHP_SELF'] == 'http://localhost/php_projects/house-hold-supermarket/admin') {
    $_SESSION["role"] = "admin";
    $_SESSION["id"] = null;
    $_SESSION["isLoggedIn"] = 'false';
} else {
    $_SESSION["role"] = "user";
    $_SESSION["id"] = null;
    $_SESSION["isLoggedIn"] = 'false';
}

?>
<link rel="stylesheet" href="http://localhost/php_projects/house-hold-supermarket/dist/materialize.css">
<nav class="navbar" style="position: sticky; top: 0; z-index: 1000;">
    <div class="container">
        <a href="#!" class="brand-logo">SOVIETA</a>
        <ul class="right hide-on-med-and-down">
            <?php if (($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager') && $_SESSION['isLoggedIn'] === 'true'): ?>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="admins.php">Admins</a></li>
                <li><a href="products.php">Products</a></li>
            <?php else: ?>
                <li><a href="http://localhost/php_projects/house-hold-supermarket/">Home</a></li>
                <?php if ($_SESSION['isLoggedIn'] === 'false'): ?>
                    <li><a href="http://localhost/php_projects/house-hold-supermarket/authentication/login">Login</a></li>
                    <li><a href="http://localhost/php_projects/house-hold-supermarket/authentication/register">Register</a></li>
                <?php else: ?>
                    <li><a href="http://localhost/php_projects/house-hold-supermarket/dashboard">Dashboard</a></li>
                    <li><a href="http://localhost/php_projects/house-hold-supermarket/authentication/logout.php">Logout</a></li>
                <?php endif; ?>
                <li><a href="http://localhost/php_projects/house-hold-supermarket/cart.php">Cart</a></li>
                <li>
                    <form action="search.php" method="get">
                        <div class="input-group" style="display: flex; align-items: center;">
                            <input class="input" type="search" name="search" placeholder="search" required>
                            <button type="submit" class="btn btn-sm btn-danger" style="margin-left:10px;">Search</button>
                        </div>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>