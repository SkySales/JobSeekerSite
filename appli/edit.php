<?php
include '../db.php';
session_start();

// Ensure the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../hr/adminLogin.php');
//     exit;
// }

// Fetch the application details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM job_applications WHERE id = ?");
    $stmt->execute([$id]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$application) {
        header("Location: ../hr/adminPage.php");
        exit; 
    }
}

// Update the application details
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cover_letter = $_POST['cover_letter'];

    // Handle resume file upload (optional)
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['resume']['tmp_name'];
        $fileName = $_FILES['resume']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = '../uploads/';
            $destPath = $uploadFileDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Optionally delete the old resume
                $oldResumePath = '../uploads/' . $application['resume'];
                if (file_exists($oldResumePath)) {
                    unlink($oldResumePath);
                }

                // Update the record with the new resume
                $stmt = $pdo->prepare("UPDATE job_applications 
                                       SET firstname = ?, lastname = ?, email = ?, phone = ?, cover_letter = ?, resume = ? 
                                       WHERE id = ?");
                $stmt->execute([$firstname, $lastname, $email, $phone, $cover_letter, $fileName, $id]);
            } else {
                $error_message = "Failed to upload the new resume.";
            }
        } else {
            $error_message = "Invalid file type. Only PDF files are allowed.";
        }
    } else {
        // Update without changing the resume
        $stmt = $pdo->prepare("UPDATE job_applications 
                               SET firstname = ?, lastname = ?, email = ?, phone = ?, cover_letter = ? 
                               WHERE id = ?");
        $stmt->execute([$firstname, $lastname, $email, $phone, $cover_letter, $id]);
    }

    header("Location: ../hr/adminPage.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Application</h1>
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        <form action=" " method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <input type="hidden" name="id" value="<?= $application['id']; ?>">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstname" value="<?= htmlspecialchars($application['firstname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?= htmlspecialchars($application['lastname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($application['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($application['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cover_letter" class="form-label">Cover Letter</label>
                <textarea class="form-control" name="cover_letter" rows="5" required><?= htmlspecialchars($application['cover_letter']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Resume (PDF Only)</label>
                <input type="file" class="form-control" name="resume" accept=".pdf">
                <small class="form-text text-muted">Leave blank to keep the current resume.</small>
            </div>
            <button type="submit" name="update" class="btn btn-success w-100">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>