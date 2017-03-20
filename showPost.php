<?php

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once $filename;
}
try {
    if($_SERVER['REQUEST_METHOD'] != 'GET') {
        throw new Exception('Datas have to be send by GET. ');
    }
    $radio = $_GET['showPost'];

    if($radio[0] == 'all') {
        $posts = Post::showAllPostsDESC(new Connection());
        $posts = json_decode($posts);
        $posts = unserialize($posts);

        echo "<table>";
        for($i = 0; $i < sizeof($posts); $i++) {
            echo "<tr><td>" . $posts[$i]['title'] . "</td>";
            echo "<td>" . $posts[$i]['description']  . "</td>";
            echo "<td>" . $posts[$i]['name']  . "</td>";
            echo "<td>" . $posts[$i]['surname'] . "</td>";
            echo "<td>" . $posts[$i]['date'] . "</td>";
            echo "<td><a href='" . "deletePost.php?postId=" . $posts[$i]['id'] . "'/>USUŃ</td></tr>";
        }
        echo "</table>";
    } elseif($radio[0] == 'one') {
        if($_GET['postId'] == null) {
            throw new Exception("You have to type number of post");
        }

        $connection = new Connection();
        (int)$postId = $_GET['postId'];
        if(!Post::isPostExist($connection, $postId)) {
            throw new Exception("Post number $postId is not exist. ");
        }
        var_dump(Post::showPostWithComments($connection, $postId));
    }

} catch (Exception $e) {
    echo $e->getMessage();
}

