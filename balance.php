<link rel="stylesheet" href="index.css">
<?php
require_once __DIR__ . '/model/user.class.php';
session_start();

if (isset($_POST['username']) and isset($_POST['password'])) {
    $con = 'login';
    $action = 'checkUser';
} else if (!isset($_SESSION['user'])) {
    $con = 'login';
    $action = 'index';
} else if (!isset($_GET['rt'])) {
    $con = 'users';         // con je controller na koji ga saljemo
    $action = 'index';      // action je funkcija u controlleru
} else {
    $rt = $_GET['rt'];
    $x = explode('/', $rt);

    if (count($x) === 1) {
        $con = $x[0];
        $action = 'index';
    } else {
        $con = $x[0];
        $action = $x[1];
    }
}

$controllerName = $con . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . '.class.php';
$c = new $controllerName;

$c->$action();
