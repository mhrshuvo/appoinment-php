<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND otp = :otp");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":otp", $otp);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $updateStmt = $db->prepare("UPDATE users SET is_verified = 1, otp = NULL WHERE email = :email");
        $updateStmt->bindParam(":email", $email);
        $updateStmt->execute();

        echo "Verification successful! <a href='login.php'>Login</a>";
    } else {
        echo "Invalid OTP.";
    }
}
?>

<form method="POST">
    <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
    <input type="text" name="otp" required placeholder="Enter OTP">
    <button type="submit">Verify</button>
</form>
