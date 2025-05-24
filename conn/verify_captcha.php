<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $captcha = $_POST['captchaResponse'];

    if (empty($captcha)) {
        echo json_encode(['success' => false, 'message' => 'CAPTCHA not completed.']);
        exit;
    }

    $secretKey = getenv('CAPTCHA_KEY'); // Replace with your actual secret key
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success']) {
        echo json_encode(['success' => false, 'message' => 'CAPTCHA verification failed.']);
        exit;
    }else{
        // CAPTCHA verification passed
        echo json_encode(['success' => true, 'message' => 'CAPTCHA verified successfully.']);
        exit;
    }
}
?>