<?php 
    session_start(); 
    include("totp.php");
    
    if (empty($verif)) {
        $secret_code = generateTOTPSecret($_SESSION["username"]);
        $_SESSION["totp_secret"] = $secret_code["secret_code"];
        $_SESSION["totp_qrcode_url"] = $secret_code["qr_code"];
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet A2F-TOTP</title>
</head>
<body>
    <h1>Welcome !</h1><br>   

    <?php if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }?>
    
    <?php if(!isset($_SESSION['username'])): ?>

        <h2>You are disconnected</h2>
        <br>
        <h3>Register page</h3>
            <form action="register.php" method='POST'>
                <input type="text" placeholder="Enter the username" name="username">
                <input type="password" placeholder="Enter the password" name="password">
                <input type="submit" value="Register">
        </form>

        <h3>Login page</h3>
        <form action="login.php" method="POST">
            <input type="text" placeholder="Enter the username" name="username">
            <input type="password" placeholder="Enter the password" name="password">
            <input type="text" placeholder="Enter the code" name="a2f_code">
            
            <input type="submit" value="Login">
        </form>

    <?php elseif(!$verif["secret_code"]):?>
        
            <h2>You are connected</h2>

            <h3>Here is your secret_code:</h3>
            <?php print_r($_SESSION["totp_secret"]);?>


            <h3>Here is your QrCode liked to your secret_code:</h3><br>
            <img src="data:image/png;base64,<?= displayQRCode($_SESSION["totp_qrcode_url"]); ?>" alt="QR Code">

            <form action="totp.php" method="POST">  
                <input type="text" placeholder="Enter your code" name="code">
                <input type="submit" value="Submit">
            </form>

            <h3>Logout</h3>
            <form action="logout.php" method='POST'>
                <input type="submit" value="Logout">
            </form>

    <?php else: ?>
        <h3>A2F activated</h3>

        <h3>Logout</h3>
        <form action="logout.php" method='POST'>
            <input type="submit" value="Logout">
        </form>

    <?php endif?>
    
        <h3>Delete all users</h3>
        <form action="dusers.php" method='POST'>
            <input type="submit" value="Delete all users">
        </form>

</body>
</html>