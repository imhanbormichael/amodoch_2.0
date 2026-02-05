<?php
// Only handle POST requests
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Spam check (hidden field must be empty)
    if(!empty($_POST['company'])) {
        echo "error";
        exit;
    }

    // Collect form data safely
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    if(!$name || !$email || !$message) {
        echo "error";
        exit;
    }

    // Recipient email
    $to = "amodoch2021@gmail.com"; // primary recipient
    $cc = "info@amodochlogistics.com"; // CC email

    $subject = "New Message from $name | Phone: " . ($phone ?: "N/A");

    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: " . ($phone ?: "N/A") . "\n";
    $body .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "CC: $cc\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if(mail($to, $subject, $body, $headers)){
        echo "success";
    } else {
        echo "error";
    }

} else {
    echo "error";
}
?>