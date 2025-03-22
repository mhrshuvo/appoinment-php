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
                    <h2>Login</h2>
                    <form method="POST">
                        <div class="user-box">
                            <input type="text" name="email" required>
                            <label>Email</label>
                        </div>
                        <div class="user-box">
                            <input type="password" name="password" required>
                            <label>Password</label>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
            <footer>
                <?php include './view/components/footer.php'; ?>
            </footer>
        </div>
    </div>

</body>

</html>