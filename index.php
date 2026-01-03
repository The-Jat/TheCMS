<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}


if (version_compare(phpversion(), "8.2", "<=")) {
    exit("Error: You must have PHP version 8.2 or greater to run ClinicMaster");
}


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {

    echo "Please run the following command to install the project's dependencies:<br>";
    echo "<code>composer install</code>";
    exit(1);
}

if(defined('LARAVEL_START')){
    return;
}

ini_set('memory_limit', '1024M');

require_once __DIR__.'/public/index.php';
