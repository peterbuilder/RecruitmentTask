<?php
session_start();

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once($filename);
}
try{
    if(!isset($_SESSION['logged'])) {
        throw new Exception('You are not logged in. ');
    }
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception('Datas have to be send by POST. ');
    }

    $comment = $_POST['comment'];
    $postId = $_POST['postId'];
    $email = $_SESSION['logged'];
    $connection = new Connection();
    $user = new User();
    $user = $user->getUser($connection, $email);
    $userId = $user->getId();

    Comment::addComment($connection, $postId, $userId, $comment);
    echo 'Congratulation! Comment added!';

} catch (Exception $e) {
    echo $e->getMessage();
}
