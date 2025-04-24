<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400); // Bad Request
        echo "Error: All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo "Error: Invalid email address.";
        exit;
    }

    // Email details
    $to = "siahgertz@gmail.com";
    $subject = "New Contact Form Submission from $name";
    $body = "You have received a new message from your website contact form.\n\n" .
            "Name: $name\n" .
            "Email: $email\n\n" .
            "Message:\n$message";
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n";

    // Try to send the email
    try {
        if (mail($to, $subject, $body, $headers)) {
            http_response_code(200); // OK
            echo "Thank you for your message, $name. We will get back to you shortly.";
        } else {
            http_response_code(500); // Internal Server Error
            echo "Failed to send.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo "Failed to send.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Error: Invalid request method.";
}
?>