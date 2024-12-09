<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if required parameters are present
    if (!empty($_GET['action']) && !empty($_GET['application_id'])) {
        $application_id = $_GET['application_id'];
        $action = $_GET['action'];
        
        // Determine status based on action
        $status = $action === 'accept' ? 'Accepted' : ($action === 'reject' ? 'Rejected' : null);

        if ($status) {
            // Update the application status
            $stmt = $pdo->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
            $stmt->execute([$status, $application_id]);

            // Fetch applicant's details for email
            $stmt = $pdo->prepare("SELECT email, firstname FROM job_applications WHERE id = ?");
            $stmt->execute([$application_id]);
            $applicant = $stmt->fetch();

            if ($applicant) {
                // Send email notification
                $subject = "Your Job Application Status - " . $status;
                $message = "Dear " . htmlspecialchars($applicant['firstname']) . ",\n\nWe are writing to inform you that your application for the job has been " . strtolower($status) . ".\n\nBest regards,\nFindHire Team";
                mail($applicant['email'], $subject, $message);

                // Redirect back to the applications page with a success message
                header('Location: ../hr/adminPage.php');
                exit;
            } else {
                echo "Error: Application not found.";
            }
        } else {
            echo "Error: Invalid action.";
        }
    } else {
        echo "Error: Missing action or application ID.";
    }
}
?>
