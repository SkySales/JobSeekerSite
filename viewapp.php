<?php
require 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: /login/login.php');
    exit;
}

// Fetch applications for the logged-in user
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT * FROM job_applications WHERE username = ?");
$stmt->execute([$username]);
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/logorss.png" type="image/x-icon">
    <title>FindHire | Your Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            text-align: center; 
        } 
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#" data-bs-toggle="tooltip" title="Dashboard">
            <span class="find-hire-text">𝙵𝚒𝚗𝚍𝙷𝚒𝚛𝚎</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- ms-auto moves items to the right -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php" data-bs-toggle="tooltip" title="Home">🏠</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login/logout.php" data-bs-toggle="tooltip" title="Logout">
                        ↪︎
                        Logout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                        👤
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="content-wrapper">
    <div class="container text-center">
        <h1 class="mb-4">Your Applications</h1>

        <?php if (empty($applications)): ?>
            <div class="alert alert-info text-center">No applications found.</div>
        <?php else: ?>
            <div id="applicationsCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <?php foreach ($applications as $index => $app): ?>
                        <button 
                            type="button" 
                            data-bs-target="#applicationsCarousel" 
                            data-bs-slide-to="<?php echo $index; ?>" 
                            class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                            aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                            aria-label="Slide <?php echo $index + 1; ?>">
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <?php foreach ($applications as $index => $app): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                                <div class="card text-center" style="width: 100%; max-width: 500px;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($app['job_title']); ?></h5>
                                        <p class="card-text"><strong>Submission Date:</strong> <?php echo htmlspecialchars($app['created_at']); ?></p>
                                        <p class="card-text">
                                            <strong>Status:</strong> 
                                            <?php if ($app['status'] === 'Accepted'): ?>
                                                <span class="badge bg-success">✔ Accepted</span>
                                            <?php elseif ($app['status'] === 'Pending'): ?>
                                                <span class="badge bg-warning">⏳ Pending</span>
                                            <?php elseif ($app['status'] === 'Rejected'): ?>
                                                <span class="badge bg-danger">✖ Rejected</span>
                                            <?php endif; ?>
                                        </p>
                                        <a href="delete_application.php?id=<?php echo $app['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#applicationsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#applicationsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-center text-white py-3 mt-auto">
    <div class="container">
        <p class="mb-0">© <?php echo date('Y'); ?> FindHire. All Rights Reserved.</p>
    </div>
</footer>

<script>
  // Initialize tooltips for elements with data-bs-toggle="tooltip"
  document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  })
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
