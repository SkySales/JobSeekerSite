<?php
require '../db.php';

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM job_postings WHERE job_id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($job) {
        echo json_encode($job);
    } else {
        echo json_encode(['error' => 'Job not found']);
    }
}
?>
