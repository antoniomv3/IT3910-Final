<?php
    ini_set('display_errors', true);
    error_reporting(E_ALL);

    require 'finalController.php';
    $controller = new finalController();
    $controller->run();
?>