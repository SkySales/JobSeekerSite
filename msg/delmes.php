<?php
include '../db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
}

header('Location: ../hr/adminPage.php');
exit;
?>
