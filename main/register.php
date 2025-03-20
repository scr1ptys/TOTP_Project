<?php
    session_start();
    require "db.php";
    
    if (isset($_POST) && isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $id = $key->prepare("SELECT id FROM users.accounts WHERE username = :username;");
        $id->bindParam(":username", $username);
        $id->execute();
        $user_id = $id->fetchAll();

        $q = $key->prepare("SELECT * FROM users.accounts WHERE username = :username;");
        $q->bindParam(":username", $username);
        $q->execute();
        $data = $q->fetchAll();
        
        if (empty($data)){
            $q = $key->prepare("INSERT INTO users.accounts (username, password) VALUES (:username, :password);");
            $q->bindParam(":username", $username);
            $q->bindParam(":password", $password);
            
            if ($q->execute()){
                $_SESSION["message"] = "You are registered";
                header("Location:index.php");
            } else {
                $_SESSION["message"] = "Error";
                header("Location:index.php");
            }
        } else{
            $_SESSION["message"] = "Username alredy used";
            header("Location:index.php");
        }

    }else {
        $_SESSION["message"] = "No username or password were given";
        header("Location:index.php");
    }

?>