<?php
    session_start();
    require "db.php";


    $q = $key->prepare("DELETE FROM users.accounts;");

    if($q->execute()){
        $_SESSION["message"] = "All users deleted";
        header("Location:index.php");
    } else {
        $_SESSION["message"] = "Error";
        header("Location:index.php");
    }

?>