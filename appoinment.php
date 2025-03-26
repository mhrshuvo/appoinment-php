<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resources/css/index.css">
    <link rel="stylesheet" href="resources/css/appoinment.css">
    
</head>

<body>
    <div class="landing-page">
    <?php include './view/components/header.php'; ?>
        <div class="content">
            <div class="container">
                <div class="form-appointment">
                    <div class="wpcf7" id="wpcf7-f560-p590-o1">
                        <form action="controllers/AppointmentController.php" method="POST" class="wpcf7-form">
                            <div class="group">
                                <div style="width: 48%; float: left;">
                                    <span>
                                        <input type="text" name="name" placeholder="Name" required>
                                    </span>
                                    <br>
                                    <span>
                                        <input type="email" name="email" placeholder="Email" required>
                                    </span>
                                    <br>
                                    <span>
                                        <input type="tel" name="phone" placeholder="Phone" required>
                                    </span>
                                    <br>
                                    <span>
                                        <textarea name="notes" placeholder="Special notes, concerns, or requirements" required> </textarea>
                                    </span>
                                </div>
                                <div style="width: 48%; float: right;">
                                    <h4>What is the best way to reach you?</h4>
                                    <p>
                                        <span class="list-item">
                                            <label>
                                                <input type="radio" name="contact_method" value="Phone">
                                                <span class="list-item-label">
                                                    Phone
                                                </span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="radio" name="contact_method" value="Email">
                                                <span class="list-item-label">
                                                    Email
                                                </span>
                                            </label>
                                        </span>
                                    </p>
                                    <h4>Days of the week you are available for appointment:</h4>
                                    <p>

                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="available_days[]" value="Monday"><span class="list-item-label">Monday</span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="available_days[]" value="Tuesday"><span class="list-item-label">Tuesday</span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="available_days[]" value="Wednesday"><span class="list-item-label">Wednesday</span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="available_days[]" value="Thursday"><span class="list-item-label">Thursday</span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="available_days[]" value="Friday"><span class="list-item-label">Friday</span>
                                            </label>
                                        </span>

                                    </p>
                                    <h4>Best time of day for your appointment:</h4>
                                    <p>

                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="preferred_time[]" value="Morning"><span class="list-item-label">Morning</span>
                                            </label>
                                        </span>
                                        <span class="list-item">
                                            <label>
                                                <input type="checkbox" name="preferred_time[]" value="Afternoon"><span class="list-item-label">Afternoon</span>
                                            </label>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div style="text-align: center; padding-top: 2em; border-top: 1px solid rgb(153, 202, 129); margin-top: 1em;">
                                <input type="submit" value="Request My Appointment" class="  wpcf7-submit">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include './view/components/footer.php'; ?>
    </div>
</body>

</html>