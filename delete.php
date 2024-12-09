<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM job_postings WHERE job_id = ?");
    $stmt->execute([$id]);

    $imgPath = '/uploads/' . $record['image_path'];
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }

    header('Location: /hr/adminPage.php');
    exit;
}
?>
 