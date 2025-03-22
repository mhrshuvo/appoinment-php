<?php
require_once 'config/database.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    $stmt = $db->prepare("INSERT INTO users (name, email, phone, password, otp) VALUES (:name, :email, :phone, :password, :otp)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":otp", $otp);

    if ($stmt->execute()) {
        sendOTP($email, $otp);
        header("Location: verify.php?email=$email");
        exit;
    } else {
        echo "Error: Could not register.";
    }
}

function sendOTP($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Replace with your email
        $mail->Password = 'your-email-password'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@example.com', 'Your App');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        $mail->send();
        echo "OTP sent!";
    } catch (Exception $e) {
        echo "Error sending OTP: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking System</title>

    <link rel="stylesheet" href="./resources/css/index.css">
    <link rel="stylesheet" href="./resources/css/login.css">

</head>

<body>
    <div class="landing-page">
        <?php include './view/components/header.php'; ?>
        <div class="content">
            <div class="container">
                <div class="login-box">
                    <h2>Register</h2>
                    <form method="POST">
                        <div class="user-box">
                            <input type="text" name="name" required>
                            <label>Username</label>
                        </div>
                        <div class="user-box">
                            <input type="text" name="email" required>
                            <label>Email</label>
                        </div>
                        <div class="user-box">
                            <input type="number" name="phone" required>
                            <label>Phone</label>
                        </div>
                        <div class="user-box">
                            <input type="password" name="password" required>
                            <label>Password</label>
                        </div>
                        <button type="submit">Register</button>
                        <p>If you already have account <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <?php include './view/components/footer.php'; ?>
        </footer>
    </div>

</body>

</html>