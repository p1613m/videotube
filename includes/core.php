<?php
session_start();
include 'functions.php';

// connect to db
$db = new PDO('mysql:host=localhost;dbname=videotube', 'root', 'root');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// auth user
$user = false;
if(isset($_SESSION['user_id'])) {
    $user = getUser($_SESSION['user_id']);
}

// todo: check access
if(isset($forAuth) && !$user) {
    redirect('auth.php');
}