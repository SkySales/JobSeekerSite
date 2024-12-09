<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /hr/adminLogin.php');
    exit;
}

$job_id = '';
$job_title = '';
$job_description = '';
$location = '';
$salary = '';
$image_path = null;

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM job_postings WHERE job_id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();

    if ($job) {
        $job_title = $job['job_title'];
        $job_description = $job['job_description'];
        $location = $job['location'];
        $salary = $job['salary'];
        $image_path = $job['image_path'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $image_path = '/uploads/' . basename($imageName);
        move_uploaded_file($imageTmpName, $_SERVER['DOCUMENT_ROOT'] . $image_path);
    }

    if ($job_id) {
        // Update job posting
        $stmt = $pdo->prepare("
            UPDATE job_postings 
            SET job_title = ?, job_description = ?, location = ?, salary = ?, image_path = ?, last_updated = NOW() 
            WHERE job_id = ?
        ");
        $stmt->execute([$job_title, $job_description, $location, $salary, $image_path, $job_id]);
    } else {
        // Insert new job posting
        $stmt = $pdo->prepare("
            INSERT INTO job_postings (job_title, job_description, location, salary, image_path, last_updated) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$job_title, $job_description, $location, $salary, $image_path]);
    }

    header('Location: /hr/adminPage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $job_id ? 'Edit' : 'Add'; ?> Job Posting</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/img/logo.png" alt="Job Portal Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            Job Portal
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/hr/adminPage.php">🏠 Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login/logout.php">🔒 Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo $job_id ? 'Edit' : 'Add'; ?> Job Posting</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo htmlspecialchars($job_title); ?>" required>
                </div>
                <div class="form-group">
                    <label for="job_description">Job Description</label>
                    <textarea class="form-control" id="job_description" name="job_description" rows="4" required><?php echo htmlspecialchars($job_description); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
                </div>
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="text" class="form-control" id="salary" name="salary" value="<?php echo htmlspecialchars($salary); ?>">
                </div>
                <div class="form-group">
                    <label for="image">Upload Image (Optional)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <?php if ($image_path): ?>
                        <img src="<?php echo $image_path; ?>" alt="Job Image" class="img-fluid mt-2" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    <a href="/hr/adminPage.php" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
