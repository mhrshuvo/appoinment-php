<?php

use PHPMailer\PHPMailer\PHPMailer;
require_once '../vendor/autoload.php';
require_once '../config/database.php';
require_once '../models/Appointment.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->connect();

    $appointmentModel = new Appointment($db);

    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'notes' => $_POST['notes'],
        'contact_method' => $_POST['contact_method'],
        'available_days' => isset($_POST['available_days']) ? $_POST['available_days'] : [],
        'preferred_time' => isset($_POST['preferred_time']) ? $_POST['preferred_time'] : []
    ];

    if ($appointmentModel->saveAppointment($data)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '..................@gmail.com';
            $mail->Password = '... ... ... .. . . .';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email Settings
            $mail->setFrom('18103361@iubat.edu', 'Company Name');
            $mail->addAddress($data['email'], $data['name']);
            $mail->Subject = "Appointment Notification";

            $message = "Hello " . $data['name'] . ",<br><br>";
            $message .= "Thank you for scheduling an appointment with us. Here are the details:<br>";
            $message .= "<strong>Phone:</strong> " . $data['phone'] . "<br>";
            $message .= "<strong>Contact Method:</strong> " . $data['contact_method'] . "<br>";
            $message .= "<strong>Available Days:</strong> " . implode(', ', $data['available_days']) . "<br>";
            $message .= "<strong>Preferred Time:</strong> " . implode(', ', $data['preferred_time']) . "<br><br>";
            $message .= "We will contact you soon.<br><br>Regards,<br>Company Name";

            $mail->isHTML(true);
            $mail->Body = $message;

            if ($mail->send()) {
                echo "Appointment request submitted successfully. A confirmation email has been sent.";
            } else {
                echo "Appointment saved, but email notification failed.";
            }
        } catch (Exception $e) {
            echo "Appointment saved, but email sending failed: " . $mail->ErrorInfo;
        }

    } else {
        echo "Error submitting your appointment request.";
    }
}
?>
