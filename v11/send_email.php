<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phonenumber'];
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA response
    $recaptcha_secret = '6LcZ0IgpAAAAAEOiwW1aylXRQCgmyrpa31wVYPgY'; // Replace 'YOUR_SECRET_KEY' with your actual reCAPTCHA secret key
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $recaptcha = file_get_contents($url, false, $context);
    $recaptcha = json_decode($recaptcha);

    if (!$recaptcha->success) {
        echo "Error: Please complete the reCAPTCHA.";
        exit;
    }

    // Proceed with sending email
    // ...

    // Email sending code here

    $to = "kannan@riotinfomedia.com";
    $subject = "New Enquiry";
    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Phone: $phone\n";
    
    $headers = "From: $email";
    
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you for your enquiry. We will get back to you shortly.";
    } else {
        echo "Error: Unable to send email. Please try again later.";
    }
}
?>
