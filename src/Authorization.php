<?php


class Authorization
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    private function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('Not valid email address. ');
        }

        return true;
    }

    private function isEmailExist($email)
    {
        $sql = sprintf("SELECT email 
                        FROM users 
                        WHERE email='%s'", $email);
        $result = $this->connection->query($sql);
        if($result->num_rows != 0) {
            return true;
        }
    }

    public function signIn($email, $password)
    {
        $this->validateEmail($email);

        $sql = sprintf("SELECT password 
                    FROM users 
                    WHERE email='%s'", $email);
        $result = $this->connection->query($sql);
        $result = $result->fetch_assoc();
        $hashedPassword = $result['password'];

        if(password_verify($password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function signUp($name, $surname, $email, $password)
    {
        $this->validateEmail($email);
        if($this->isEmailExist($email)) {
            throw new Exception("Email exist. Please type other email address. ");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = sprintf("INSERT INTO users (name, surname, email, password) 
                        VALUES ('%s', '%s', '%s', '%s')", $name, $surname, $email, $hashedPassword);
        $result = $this->connection->query($sql);

        return true;
    }
}

