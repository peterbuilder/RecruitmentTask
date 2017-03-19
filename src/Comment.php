<?php


class Comment
{
    static public function addComment(Connection $connection, $postId, $userId, $comment)
    {
        if(strlen($comment) > 255) {
            throw new Exception("Comment is too long (max 255 characters)");
        }

        if(!Post::isPostExist($connection, $postId)) {
            throw new Exception("Post number $postId does not exist. ");
        }

        $date = date('Y-m-d H:i:s');

        $sql = sprintf("INSERT INTO comments (post_id, user_id, comment, date)
                        VALUES ('%s', '%s', '%s', '%s')", $postId, $userId, $comment, $date);
        $result = $connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }

}