<?php
session_start();

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once $filename;
}

try {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception("Datas have to be send by POST. ");
    }

    if($_POST['email'] == null || $_POST['password'] == null) {
        throw new Exception("You should fill all text boxes. ");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $authorization = new Authorization(new Connection());

    if($authorization->signIn($email, $password)) {
        echo 'Congratulation! You are logged in.';
    } else {
        echo 'Incorrect email or password. ';
    }
} catch (Exception $e) {
    echo $e->getMessage();
}