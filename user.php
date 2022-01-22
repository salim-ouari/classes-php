<?php

class User
{

    public $_id;
    public $_login;
    public $_email;
    public $_firstname;
    public $_lastname;

    public function __construct()
    {
    }

    public function register(string $login, string $password, string $email, string $firstname, string $lastname)
    {

        $connection_mysql = mysqli_connect("localhost", "root", "root", "classes");
        $query = "INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname','$lastname')";
        mysqli_query($connection_mysql, $query);
        $user = [$login, $password, $email, $firstname, $lastname];
        return $user;
    }

    public function connect(string $login, string $password)
    {
        $db = mysqli_connect("localhost", "root", "root", "classes");
        $req = mysqli_query($db, "SELECT * FROM `utilisateurs` WHERE login='$login' AND password='$password'");
        $res = mysqli_fetch_all($req, MYSQLI_ASSOC);
        if (!empty($res)) {
            $this->_login = $login;
            $this->_password = $password;
            $this->_email = $res[0]['email'];
            $this->_firstname = $res[0]['firstname'];
            $this->_lastname = $res[0]['lastname'];
            $this->_id = $res[0]['id'];
            session_start();
            $_SESSION['login'] = $login;
            echo 'Utilisateur connecté';
        } else {
            echo 'Utilisateur introuvable';
        }
    }

    public function disconnect()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
    }

    public function delete()
    {
        $db = mysqli_connect("localhost", "root", "root", "classes");
        $req = mysqli_query($db, "DELETE FROM `utilisateurs` WHERE `login`='$this->_login'");
        mysqli_query($db, $req);
        $this->disconnect();
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $db = mysqli_connect("localhost", "root", "root", "classes");
        $req = mysqli_query($db, "UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE `login`='$this->_login'");
        mysqli_query($db, $req);
        $this->_login = $login;
        $this->_password = $password;
        $this->_email = $email;
        $this->_firstname = $firstname;
        $this->_lastname = $lastname;
    }

    public function isConnected()
    {
        $connect = FALSE;
        if (isset($_SESSION['login'])) {
            $connect = TRUE;
            return $connect;
        } else {
            return $connect;
        }
    }

    public function getAllInfos()
    {
        $db = mysqli_connect("localhost", "root", "root", "classes");
        $requete = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login = :login ");

        $result = mysqli_fetch_all($requete, MYSQLI_ASSOC);
        var_dump($result);
    }

    public function getLogin()
    {
        return $this->_login;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }
}
// $user = new User();
// $user->connect("test", "test");
// // $user->update("test","test","test2","test2","test2");
// // $user->disconnect();