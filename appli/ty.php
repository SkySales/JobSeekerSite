<?php
include '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Job Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }

        .thank-you-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .thank-you-icon {
            font-size: 80px;
            color: #28a745;
        }

        .thank-you-message {
            font-size: 1.25rem;
            color: #333;
            margin-top: 20px;
        }

        .thank-you-submessage {
            font-size: 1rem;
            color: #777;
            margin-top: 10px;
        }

        .btn-home {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-home:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="thank-you-container">
        <!-- Icon for Thank You -->
        <div class="thank-you-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <!-- Message -->
        <div class="thank-you-message">
            Thank you for your application!
        </div>
        <!-- Sub-message -->
        <div class="thank-you-submessage">
            Your application has been successfully submitted. We will review it and get back to you soon via SMS/Email.
        </div>
        <br>
        <!-- Button to Home -->
        <a href="/" class="btn-home">Go to Homepage</a>
    </div>

    <!-- Bootstrap JS & FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
