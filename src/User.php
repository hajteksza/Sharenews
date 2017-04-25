<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $hashedPassword;

    public function __construct()
    {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashedPassword = "";
    }


    public function getId()
    {
        return $this->id;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword($password)
    {
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }

    public function saveToDB(mysqli $connection)
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO users(email, username, hashed_password) VALUES ('$this->email', '$this->username', '$this->hashedPassword')";
            $result = $connection->query($sql);
            var_dump($result);
            if ($result == true) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE users SET email = '$this->email', username = '$this->username', hashed_password = '$this->hashedPassword' WHERE id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    public function delete(mysqli $connection) {
        if($this->id != -1) {
            $sql = "DELETE FROM users WHERE id= $this->id";
            $result = $connection->query($sql);
            if($result == true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

    static public function loadUserByID(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM users where id = $id";
        $result = $connection->query($sql);
        if ($result == true and $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row ['hashed_password'];

            return $loadedUser;
        }
    }

    static public function loadAllUsers(mysqli $connection)
    {
        $sql = "SELECT * FROM users";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true and $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashedPassword = $row ['hashed_password'];

                $ret[] = $loadedUser;
            }

        }
        return $ret;
    }
}
