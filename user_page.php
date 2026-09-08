<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = basename($_SERVER['HTTP_REFERER']);
} else {
    $previous_page = 'home.php';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">    
    <title>Document</title>
</head>
<body class='profile-body'>
    <div class='profile-info'>
        <h1 style='color:orange;'>Welcome <?= $_SESSION['name']; ?></h1>
        <p>Name:&nbsp;&nbsp;&nbsp;<span><?= $_SESSION['name']; ?></span></p>
        <p>Email:&nbsp;&nbsp;&nbsp;<span><?= $_SESSION['email']; ?></span></p>
        <div class='buttons'>
            <button onclick="window.location.href='<?= $previous_page ?>'">Back</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>