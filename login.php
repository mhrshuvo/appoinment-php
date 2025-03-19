<?php
require_once 'config/database.php';
session_start();

$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND is_verified = 1");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: all-appointments.php");
        exit;
    } else {
        echo "<script>alert('Invalid email or password, or account not verified.');</script>";
    }
}
?>

<form method="POST">
    <input type="email" name="email" required placeholder="Enter Email">
    <input type="password" name="password" required placeholder="Enter Password">
    <button type="submit">Login</button>
</form>
