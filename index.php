<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking System</title>

    <link rel="stylesheet" href="./resources/css/index.css">

</head>

<body>
    <div class="landing-page">
        <?php include './view/components/header.php'; ?>
        <div class="content">
            <div class="container">
                <div class="info">
                    <h1>Looking For Inspiration</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus odit nihil ullam nesciunt quidem iste, Repellendus odit nihil</p>
                    <a href="appoinment.php"><button>Book Appoinment</button></a>
                </div>
                <div class="image">
                    <img src="./resources/images/Strategy.png" alt="Strategy">
                </div>
            </div>
        </div>
        <footer>
            <?php include './view/components/footer.php'; ?>
        </footer>
    </div>

</body>

</html>

