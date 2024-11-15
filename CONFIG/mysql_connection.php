<?php
$directory = str_replace('\CONFIG', '', __DIR__);
require_once $directory . '\vendor\autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable($directory);
$dotenv->load();

$conn = mysqli_connect($_ENV['DB_HOSTNAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (mysqli_connect_errno()) {
    printf("Connection error: ", mysqli_connect_error());
    exit(1);
}
