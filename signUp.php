<?php

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once $filename;
}

try {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception("Datas have to be send by POST. ");
    }
    if(
        $_POST['name'] == null
        || $_POST['surname'] == null
        || $_POST['email'] == null
        || $_POST['password'] == null
    ) {
        throw new Exception("You should fill all text boxes. ");
    }

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authorization = new Authorization(new Connection());

    $authorization->signUp($name, $surname, $email, $password);
    echo 'Congratulation! Please, log in on main page. ';
} catch (Exception $e) {
    echo $e->getMessage();
}



