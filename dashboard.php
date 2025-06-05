<?php
include "auth.php";
include "includes/navbar.php"; 
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Applied Computer Technology</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    

    <div class="content">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>You are logged in as <strong><?php echo $role; ?></strong>.</p>
    </div>
</body>
</html>