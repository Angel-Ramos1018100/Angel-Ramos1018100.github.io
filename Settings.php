<?php
// Define variables and set to empty values
$nameErr = $emailErr = $messageErr = "";
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate name
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  // Validate email
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  // Validate message
  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } else {
    $message = test_input($_POST["message"]);
  }

  // If no errors, send email
  if ($nameErr == "" && $emailErr == "" && $messageErr == "") {
    // Set the recipient email address
    $to = "ramoaj24@farmingdale.edu";

    // Set the email subject
    $subject = "New message from your portfolio website";

    // Build the email message
    $body = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

    // Set headers
    $headers = "From: $email\r\nReply-To: $email\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
      // Redirect to a thank you page
      header("Location: thank-you.html");
      exit();
    } else {
      // Display error message if email failed to send
      $emailErr = "Oops! Something went wrong and your message could not be sent. Please try again later.";
    }
  }
}

// Function to clean input data and prevent security issues
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>