<?php


class Post
{
    static public function addPost(Connection $connection, $description, $title, $userId)
    {
        if(strlen($title) > 100 || strlen($description) > 255) {
            throw new Exception("Title or description is too long 
                                (title max 100 characters, description max 255 characters)");
        }

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
        $sql = "SELECT p.id, p.title, p.description, u.name, u.surname, p.date
                        FROM posts AS p
                        JOIN users AS u
                        ON p.user_id = u.id
                        ORDER BY p.date DESC";
        $result = $connection->query($sql);
        if($result->num_rows == 0) {
            throw new Exception("No posts. ");
        }

        while($row = $result->fetch_assoc())
        {
            $rows[] = $row;
        }

        $result = serialize($rows);
        return $result = json_encode($result);
    }

    static public function isPostExist(Connection $connection, $id)
    {
        $sql = sprintf("SELECT id
                FROM posts
                WHERE id=%s", $id);
        $result = $connection->query($sql);

        if($result->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    static public function showPostWithComments(Connection $connection, $postId)
    {

        //Get post
        $sql = sprintf("SELECT p.title, p.description, u.name, u.surname, p.date
                        FROM posts AS p
                        JOIN users AS u
                        ON p.user_id = u.id
                        WHERE p.id = %s", $postId);
        $result = $connection->query($sql);
        $post = $result->fetch_assoc();

        //Get comments
        $sql = sprintf("SELECT u.name, u.surname, c.comment, c.date 
                        FROM comments AS c 
                        LEFT JOIN users AS u 
                        ON c.user_id = u.id 
                        WHERE c.post_id = %s", $postId);
        $result = $connection->query($sql);

        while($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $postAndComments = [
            'post' => $post,
            'comments' => $comments
        ];

        $postAndComments = serialize($postAndComments);
        $postAndComments = json_encode($postAndComments);

        return $postAndComments;
    }

    //Delete post with comments
    static public function deletePost(Connection $connection, $postId)
    {
        $sql = sprintf("DELETE FROM comments
                        WHERE post_id=%s", $postId);
        $connection->query($sql);
        $sql = sprintf("DELETE FROM posts
                        WHERE id=%s", $postId);
        $connection->query($sql);

        return true;
    }
}