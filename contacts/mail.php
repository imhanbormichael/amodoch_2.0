<?php
header('Content-Type: application/json');

// ---------------- SECURITY & VALIDATION ----------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false]);
    exit;
}

// Honeypot bot protection
if (!empty($_POST['company'])) {
    echo json_encode(["success" => false]);
    exit;
}

// Sanitize inputs
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

// Required fields check
if (!$name || !$email || !$message) {
    echo json_encode(["success" => false]);
    exit;
}

// Prevent header injection
if (preg_match("/[\r\n]/", $email)) {
    echo json_encode(["success" => false]);
    exit;
}

// ---------------- EMAIL CONFIG ----------------

$to = "amodoch2021@gmail.com"; 

$subject = "New Contact Form Message";

$emailBody = "
You have received a new message from your website:

Name: $name
Email: $email
Phone: $phone

Message:
$message
";

$headers  = "From: Amodoch Logistics <no-reply@amodoch.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

// ---------------- SEND MAIL ----------------

if (mail($to, $subject, $emailBody, $headers)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}