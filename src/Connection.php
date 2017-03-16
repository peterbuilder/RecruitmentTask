<?php


class Connection
{
    private $mysqli;
    private $insert_id;

    public function __construct()
    {
        require 'config.php';

        try {
            $this->mysqli = new mysqli($host, $user, $password, $database);

            if($this->mysqli->connect_error) {
                throw new Exception("Can't connect with database");
            }

            $this->mysqli->set_charset('utf8');
        }
        catch (Exception $e) {
            echo $e->getMessage() . ' -> ';
            echo $this->mysqli->connect_error;
        }
    }

    public function query($sql)
    {
        $result = $this->mysqli->query($sql);

        try {
            if($result == false) {
                throw new Exception("Query error");
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}