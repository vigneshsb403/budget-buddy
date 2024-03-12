<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/lib/Database.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/lib/Folder.class.php";
require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

class Signup
{
    private $username;
    private $password;
    private $email;

    private $db;

    public function __construct($username, $password, $email)
    {
        $this->db = Database::getConnection();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        if ($this->userExists()) {
            throw new Exception("User already exists");
        }
        $bytes = random_bytes(16);
        $this->token = $token = bin2hex($bytes); //to verify users over email.
        $password = $this->hashPassword();
        $query = "INSERT INTO `auth` (`username`, `password`, `email`, `active`, `token`) VALUES ('$username', '$password', '$email', 1, '$token');";
        if (!mysqli_query($this->db, $query)) {
            throw new Exception(
                "Unable to signup, user account might already exist."
            );
        } else {
            $this->id = mysqli_insert_id($this->db);
            // $this->sendVerificationMail();
            $f = new Folder();
            session_start();
            $_SESSION["username"] = $this->username;
            $f->createNew("Default Folder");
        }
    }

    public function sendVerificationMail()
    {
    }

    public function getInsertID()
    {
        return $this->id;
    }

    public function userExists()
    {
        //TODO: Write the code to check if user exists.
        return false;
    }

    public function hashPassword($cost = 10)
    {
        //echo $this->password;
        $options = [
            "cost" => $cost,
        ];
        return password_hash($this->password, PASSWORD_BCRYPT, $options);
    }

    public static function verifyAccount($token)
    {
        $query = "SELECT * FROM apis.auth WHERE token='$token';";
        $db = Database::getConnection();
        $result = mysqli_query($db, $query);
        if ($result and mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            if ($data["active"] == 1) {
                throw new Exception("Already Verified");
            }
            mysqli_query(
                $db,
                "UPDATE `auth` SET `active` = '1' WHERE (`token` = '$token');"
            );
            return true;
        } else {
            return false;
        }
    }
}
