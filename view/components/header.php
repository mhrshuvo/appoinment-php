<header>
    <div class="container">
        <a href="./index.php" class="logo">Your <b>Website</b></a>
        <ul class="links">
            <li><a href="index.php">Home</a></li>
            <li><a href="appoinment.php">Book Appoinment</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="all-appointments.php">All Appoinment</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>