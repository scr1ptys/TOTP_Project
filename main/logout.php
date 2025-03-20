<?php
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION["totp_secret"]);
    unset($_SESSION["totp_qrcode_url"]);
    $_SESSION['message'] = 'Disconnected';
    header('Location:index.php');
?>