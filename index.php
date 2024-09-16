<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App - Landing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="landing-page">
        <h1>Welcome to the To-Do App</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p><a href="home.php">Home</a></p>
        <p><a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a></p>
        <p><a href="register.php">Register</a></p>
    <?php endif; ?>
    </div>
    
</body>
</html>
