<?php
include 'core.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VideoTube</title>
</head>
<body>
<nav>
    <a href="index.php"><b>Home</b></a> |
    <?php if(!$user): ?>
        <a href="registration.php">Registration</a> |
        <a href="auth.php">Authorization</a>
    <?php else: ?>
        <a href="create.php">Add video</a> |
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</nav>
