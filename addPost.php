<?php
session_start();

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once($filename);
}

try {
    if(!isset($_SESSION['logged'])) {
        throw new Exception('You are not logged in. ');
    }
    if($_SERVER['REQUEST_METHOD'] != 'GET') {
        throw new Exception('Datas have to be send by GET. ');
    }

    $email = $_SESSION['logged'];
    $description = $_GET['description'];
    $title = $_GET['title'];
    $connection = new Connection();
    $user = new User();

    $user->getUser($connection, $email);
    if(Post::addPost($connection, $description, $title, $user->getId())) {
        echo 'Post added. ';
    } else {
        echo 'Post did not add';
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
