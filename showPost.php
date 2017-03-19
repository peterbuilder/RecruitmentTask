<?php

function __autoload($classname)
{
    $filename = 'src/' . $classname . '.php';
    include_once $filename;
}

$posts = Post::showAllPostsDESC(new Connection());

$posts = json_decode($posts);
$posts = unserialize($posts);

echo "<table>";
for($i = 0; $i < sizeof($posts); $i++) {
    echo "<tr><td>" . $posts[$i]['title'] . "</td>";
    echo "<td>" . $posts[$i]['description']  . "</td>";
    echo "<td>" . $posts[$i]['name']  . "</td>";
    echo "<td>" . $posts[$i]['surname'] . "</td>";
    echo "<td>" . $posts[$i]['date'] . "</td></tr>";

}
echo "</table>";
