<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("
        SELECT restaurants.*, users.username 
        FROM restaurants 
        JOIN users ON restaurants.added_by = users.user_id
        WHERE restaurants.restaurant_id = :id
    ");
    $stmt->execute([$id]);
    $restaurant = $stmt->fetch();

    if (!$restaurant) {
        echo "Restaurant not found!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Restaurant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/img/logo.png" alt="Restaurant Manager Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            Resto Lookups
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">🏠 Home</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit.php">➕ Add Restaurant</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login/logout.php">
                        <i class="fas fa-sign-out-alt"></i> 🔒 Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h1 class="text-center mb-4">Restaurant Details</h1>
    
    <div class="card restaurant-card">
        <div class="card-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($restaurant['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($restaurant['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td><?php echo htmlspecialchars($restaurant['phone_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($restaurant['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Added By:</th>
                        <td><?php echo htmlspecialchars($restaurant['username']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Update:</th>
                        <td><?php echo htmlspecialchars($restaurant['last_updated']); ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
