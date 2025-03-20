<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    //session_start();
    require 'vendor/autoload.php';
    require "db.php";

    use OTPHP\TOTP;
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;    


    function generateTOTPSecret($username) {
        // Create a TOTP instance
        $totp = TOTP::create();
        // Set the label (e.g., "YourAppName:Username")
        $totp->setLabel("Project_TOTP-{$username}");
        // Optional: Set issuer (displayed in authenticator apps)
        $totp->setIssuer("Project_TOTP");
        // Secret key for storage
        $secret = $totp->getSecret($username);
        // Generate QR Code URL (optional)
        $qrCodeURL = $totp->getProvisioningUri($secret);
        // Return the secret and QR code URL
        return [
            'secret_code' => $secret,
            'qr_code' => $qrCodeURL,
        ];
    }


    function displayQRCode($qrCodeURL) {
        $qrCode = QrCode::create($qrCodeURL);
        $writer = new PngWriter();
        // Generate QR Code as a PNG
        $result = $writer->write($qrCode);
        // Output the image directly
        $dataBrut = $result->getString();
        return base64_encode($dataBrut);
    }

    function verifyTOTPCode($userSecret, $userInputCode) {
        $totp = TOTP::create($userSecret);
        // Verify the OTP code
        if ($totp->verify($userInputCode)) {
            return true; // Code is valid
        } else {
            return false; // Invalid code
        }
    }

    if (isset($_POST) && isset($_POST["code"]) && !empty($_POST["code"])){

        $code = filter_input(INPUT_POST, "code");
        $_SESSION["code"] = $code;

        if(verifyTOTPCode($_SESSION["totp_secret"], $_SESSION["code"])){

            $q = $key->prepare("UPDATE users.accounts SET secret_code = :secret_code WHERE username = :username;");
            $q->bindParam(":secret_code", $_SESSION["totp_secret"]);
            $q->bindParam(":username", $_SESSION["username"]);
            
            if($q->execute()){
                $_SESSION["message"] = "Success";
                header("Location:index.php");
            } else{
                $_SESSION["message"] = "Error";
                header("Location:index.php");
            }

        } else{
            $_SESSION["message"] = "Wrong code";
            header("Location:index.php");
        }
    }

    $q = $key->prepare("SELECT secret_code FROM users.accounts WHERE username = :username");
    $q->bindParam(":username", $_SESSION["username"]);
    $q->execute();
    $verif = $q->fetch();


?>  