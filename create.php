<?php
require 'db.php';
session_start();

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id'])) {
    header('Location: /hr/adminLogin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate form data
        if (
            empty($_POST['job_title']) || 
            empty($_POST['job_description']) || 
            empty($_POST['location']) || 
            empty($_POST['salary'])
        ) {
            throw new Exception("All fields are required.");
        }

        $job_title = $_POST['job_title'];
        $job_description = $_POST['job_description'];
        $location = $_POST['location'];
        $salary = $_POST['salary'];
        $image_path = null; // Default image path

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $imageName = basename($_FILES['image']['name']);
            $imageTmpName = $_FILES['image']['tmp_name'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

            // Create uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = $uploadDir . $imageName;

            // Move the uploaded file
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $image_path = '/uploads/' . $imageName; // Save relative path for database
            } else {
                throw new Exception("Failed to upload image.");
            }
        }

        // Insert new job posting into the database
        $stmt = $pdo->prepare("
            INSERT INTO job_postings (job_title, job_description, location, salary, image_path, last_updated) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$job_title, $job_description, $location, $salary, $image_path]);

        // Redirect to the admin page after successful submission
        header('Location: /hr/adminPage.php');
        exit;
    } catch (Exception $e) {
        // Handle errors and display feedback
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
