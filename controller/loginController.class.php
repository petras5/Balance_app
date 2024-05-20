<?php

require_once __DIR__ . '/../model/userService.class.php';

class LoginController
{
    public $message = "";
    function index()
    {
        $title = 'Login';

        require_once __DIR__ . '/../view/login.php';
    }

    function checkUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $us = new UserService();
        $user = $us->verifyUser($username, $password);
        if ($user) // ako takav user postoji, ispisi home page i njegov username, ako ne postoji opet ispisi formu za login
        {
            $_SESSION['user'] = $user;
            header('Location: balance.php'); // zamijeniti s header('Location: balance.php'); nakon kaj napravim userController->index()
        } else {
            $this->message = "Incorrect password or username.";
            require_once __DIR__ . '/../view/login.php';
        }
    }

    function logout()
    {
        session_unset();
        session_destroy();

        header('Location: balance.php');
        exit();
    }
}
