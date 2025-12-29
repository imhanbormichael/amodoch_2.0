<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $to = "amodoch2021@gmail.com"; 
    $subject = "New Contact Message From Website";

    $body = "
    Name: $name
    Email: $email
    Phone: $phone

    Message:
    $message
    ";

    $headers = "From: $email";

    if(mail($to, $subject, $body, $headers)){
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

} else {
    echo json_encode(["success" => false]);
}