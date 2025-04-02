<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'kentjarold57@gmail.com'; // SMTP username
        $mail->Password = base64_decode('bWNkeCBqbHlnIHhmcm0gaG5oYQ=='); // SMTP password (Base64 decoded)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('kentjarold57@gmail.com', 'Mailer');
        $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "
                <html>
                <head>
                    <style>
                        .email-container {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                        }
                        .email-header {
                            background-color: #f8f9fa;
                            padding: 10px;
                            text-align: center;
                            border-bottom: 1px solid #dee2e6;
                        }
                        .email-body {
                            padding: 20px;
                        }
                        .email-footer {
                            background-color: #f8f9fa;
                            padding: 10px;
                            text-align: center;
                            border-top: 1px solid #dee2e6;
                            font-size: 12px;
                            color: #6c757d;
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='email-header'>
                            <h2>DTS System Notification</h2>
                        </div>
                        <div class='email-body'>
                            <p>$message</p>
                        </div>
                        <div class='email-footer'>
                            <p>&copy; " . date('Y') . " DTS System. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";
    
            $mail->send();

        $mail->send();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        error_log("Failed to send email. Mailer Error: {$mail->ErrorInfo}");
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'invalid_request']);
}
?>