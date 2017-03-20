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
    if($_SERVER['REQUEST_METHOD'] != 'GET') {
        throw new Exception('Datas have to be send by GET. ');
    }
    if($_GET['postId'] == null) {
        throw new Exception("You have to choose post");
    }

    $postId = $_GET['postId'];

    if(Post::deletePost(new Connection(), $postId)) {
        echo "Post $postId has been removed. ";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}