<?php
// ================================
// The Testing Tech - Contact Backend
// ================================

// CHANGE THIS EMAIL TO YOUR BUSINESS EMAIL
$to = "ranashahid43@gmail.com";  

// Security: Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit("Access denied.");
}

// Sanitize inputs
$name    = htmlspecialchars(strip_tags(trim($_POST["name"] ?? "")));
$email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($_POST["message"] ?? "")));

// Validate inputs
if (empty($name) || empty($email) || empty($message)) {
    exit("Please fill in all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid email address.");
}

// Email subject & body
$subject = "New Contact Request | The Testing Tech";

$body = "
New contact request received:

Name: $name
Email: $email

Message:
$message
";

// Email headers
$headers  = "From: The Testing Tech <no-reply@thetestingtech.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $body, $headers)) {
    // Success response
    echo "Thank you! Your message has been sent successfully.";
} else {
    // Failure response
    http_response_code(500);
    echo "Sorry, something went wrong. Please try again later.";
}
?>
