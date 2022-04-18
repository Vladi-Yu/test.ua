<?php
require_once 'Models/UsersModels.php';
require_once 'Controllers/UsersController.php';
$test = new \App\Controllers\UsersController\UsersController();
$test->index();
?>