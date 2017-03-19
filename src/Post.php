<?php


class Post
{
    static public function addPost(Connection $connection, $description, $title, $userId)
    {
        $date = date('Y-m-d H:i:s');

        $sql = sprintf("INSERT INTO posts (user_id, title, description, date)
                        VALUES ('%s', '%s', '%s', '%s')",$userId, $title, $description, $date);
        $result = $connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }

    static public function showAllPostsDESC(Connection $connection)
    {
        $sql = "SELECT p.title, p.description, u.name, u.surname, p.date
                        FROM posts AS p
                        JOIN users AS u
                        ON p.user_id = u.id
                        ORDER BY p.date
                        DESC";
        $result = $connection->query($sql);

        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }


        $result = serialize($rows);
        $result = json_encode($result);

        if($result == true) {
            return $result;
        } else {
            return false;
        }
    }
}