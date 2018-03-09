<?php
require 'vendor/autoload.php';

use Core\Route;

try {
    Route::start();
} catch (Exception $e) {
    echo 'Woops... sorry!  ' . $e->getMessage();
}