<?php

class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;

    public function __construct()
    {
        $this->id = -1;
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUser(Connection $connection, $email)
    {
        $sql = sprintf("SELECT *
                        FROM users
                        WHERE email='%s'", $email);
        $result = $connection->query($sql);
        $result = $result->fetch_assoc();

        if($result == 0) {
            throw new Exception("Can't get user data");
        }

        $user = new User();
        $user->id = $result['id'];
        $user->name = $result['name'];
        $user->surname = $result['surname'];
        $user->email = $result['email'];

        return $user;
    }

}