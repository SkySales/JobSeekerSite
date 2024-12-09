<?php
include '../db.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the record exists
    $stmt = $pdo->prepare("SELECT * FROM job_applications WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        // Log activity (optional, uncomment if needed)
        // $userId = $_SESSION['user_id'];
        // $details = "Deleted job application with ID $id";
        // logActivity($pdo, $userId, 'Delete', $details);

        // Delete the record
        $stmt = $pdo->prepare("DELETE FROM job_applications WHERE id = ?");
        $stmt->execute([$id]);

        // Optionally, delete the uploaded resume file
        $resumePath = '../uploads/' . $record['resume'];
        if (file_exists($resumePath)) {
            unlink($resumePath);
        }
    }

    // Redirect to the view page
    header("Location: ../hr/adminpage.php");
    exit;
}
?>
