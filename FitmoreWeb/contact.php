<?php
// contact.php

// Database configuration
$host = "sql105.infinityfree.com";      // e.g. localhost
$user = "if0_40210474";           // your MySQL username
$pass = "6oaYZH9G0QZ9PFv";               // your MySQL password
$dbname = "if0_40210474_fitness";   // your database name

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data safely
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "Please fill out all fields.";
        exit;
    }

    // Prepare and bind to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Execute
    if ($stmt->execute()) {
        echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
