<?php
session_start();
require_once("db_conn.php");

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: loginform.php');
    exit;
}

// User's username for a personalized message (optional)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 shadow-lg p-3 mb-5 bg-white rounded">
                <h1 class="text-center">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
                <p class="text-center">This is your home page.</p>
                <!-- Logout Button -->
                <div class="text-center">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
