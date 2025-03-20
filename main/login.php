<?php

    session_start();
    require "db.php";
    require "totp.php";

    if (isset($_POST) && isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {

        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $code = filter_input(INPUT_POST,"a2f_code");

        $q = $key->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password;");
        $q->bindParam(":username", $username);
        $q->bindParam(":password", $password);
        $q->execute();
        $data = $q->fetch();

        if (!empty($data)) {

            if(!empty($data["secret_code"])){

                if (empty($code)) {
                    $_SESSION["message"] = "Code is required";
                    header("Location: index.php");
                } else if (verifyTOTPCode($data["secret_code"], $code)) {
                    $_SESSION["username"] = $username;
                    $_SESSION["message"] = "Connected";
                    header("Location: index.php");
                } else {
                    $_SESSION["message"] = "Wrong code";
                    header("Location: index.php");
                }

            }else {
                $_SESSION["username"] = $username;
                $_SESSION["message"] = "Connected";
                header("Location: index.php");
            }
        } else {
            $_SESSION["message"] = "User not found";
            header("Location:index.php");
        }
    } else{
        $_SESSION["message"] = "No username or password were given";
        header("Location:index.php");
    }
?>