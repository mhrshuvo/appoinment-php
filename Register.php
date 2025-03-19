<?php
require_once 'config/database.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    $stmt = $db->prepare("INSERT INTO users (email, password, otp) VALUES (:email, :password, :otp)");
    $stmt->bindParam(":email", $email);
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

function sendOTP($email, $otp) {
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

<form method="POST">
    <input type="email" name="email" required placeholder="Enter Email">
    <input type="password" name="password" required placeholder="Enter Password">
    <button type="submit">Register</button>
</form>
