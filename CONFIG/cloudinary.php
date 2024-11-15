<?php
$directory = str_replace('\CONFIG', '', __DIR__);

require $directory . '\vendor\autoload.php';


use Cloudinary\Configuration\Configuration;

Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_KEY']}:{$_ENV['CLOUDINARY_SECRET_KEY']}@{$_ENV['CLOUDINARY_CLOUD_NAME']}?secure=true");
