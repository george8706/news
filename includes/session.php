<?php

class Session {

    function __construct(){
        session_start();
    }

    public function errors() {
        if (isset($_SESSION["errors"])) {
            $errors = $_SESSION["errors"];
            
            $_SESSION["errors"] = null;

            return $errors;
        }
    }

}

$session = new Session();
$errors = $session->errors();
?>