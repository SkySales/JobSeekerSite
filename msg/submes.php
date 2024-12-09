<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO messages (username, email, message) VALUES (:username, :email, :message)");
    $stmt->execute([
        'email' => $email,
        'username' => $username,
        'message' => $message,
    ]);

    header('Location: ../index.php');
    exit;
}
?>
