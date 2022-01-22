<?php
session_start();
class Userpdo
{
    private $_id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $bdd;

    public function __construct()
    {
        try {

            $this->bdd = new PDO(
                'mysql:host=localhost;dbname=classes',
                'root',
                "",
            );
            var_dump($this->bdd);
        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }
    }



    public function register($login, $password, $email, $firstname, $lastname)
    {

        $requete = $this->bdd->prepare("INSERT INTO utilisateurs (login,password,email,firstname,lastname)
    VALUES (:login,:password,:email,:firstname,:lastname)");
        $requete->execute(array("login" => $login, "password" => $password, "email" => $email, "firstname" => $firstname, "lastname" => $lastname));
    }

    public function connect($login, $password)
    {

        $requete = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login= :login AND password=:password");
        $requete->execute(["login" => $login, "password" => $password]);
        $resultat = $requete->fetchall(PDO::FETCH_ASSOC);
        var_dump($requete->execute());


        if (!empty($resultat)) {
            $this->login = $resultat[0]['login'];
            $this->password = $resultat[0]['password'];
            $this->email = $resultat[0]['email'];
            $this->firstname = $resultat[0]['firstname'];
            $this->lastname = $resultat[0]['lastname'];
            $_SESSION['login'] = $this->login;

            echo "Vous êtes à présent connecté";
        } else {
            echo "Login ou mot de passe incorrect";
        }

        return ($resultat);
    }

    public function disconnect()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
    }
    public function delete()
    {

        $user = $this->login;
        $req_delete = $this->bdd->query("DELETE FROM `utilisateurs` WHERE `login` = '$user'");
        $req_delete->execute();

        return ($req_delete);
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {

        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $req_Update = $this->bdd->prepare("UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname'");
        $req_Update->execute();
    }

    public function isConnected()
    {

        $connect = FALSE;
        if (isset($SESSION['login'])) {
            $connect = TRUE;
            return $connect;
        } else {
            return $connect;
        }
    }
    public function getAllInfos($login)
    {
        $requete = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = :login ");
        $requete->execute(["login" => $login]);
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
    }
    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {

        return $this->lastname;
    }
}

$User = new Userpdo();
// $User->register("do", "do", "odo@gmail.com", "do", "do");
// $User->connect("do", "do");
// $User->disconnect();
// $User->update("do", "do", "do@gmail.com", "zz", "do");
// var_dump($User->isConnected());
// $User->getLastname();
// $User->getEmail();
// $User->getFirstname();
// $User->delete();
// echo $User->getAllInfos("do");
