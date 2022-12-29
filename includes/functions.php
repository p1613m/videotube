<?php
// dump data
function dd($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

// redirect to url
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function getUser($id) {
    global $db;
    $user = $db->query('SELECT * FROM users WHERE id = ' . intval($id))
        ->fetch();

    if($user) {
        $user['name'] = htmlspecialchars($user['name']);
        $user['description'] = htmlspecialchars($user['description']);
    }

    return $user;
}

// upload file
function uploadFile($file) {
    $fileExArray = explode('.', $file['name']);
    $ex = $fileExArray[count($fileExArray) - 1];
    $filePath = 'files/' . uniqid() . '.' . $ex;

    move_uploaded_file($file['tmp_name'], $filePath);

    return $filePath;
}

// validate string max length
function validateMax($string, $maxLength, $required = true) {
    return mb_strlen($string) <= $maxLength && (!$required || $string);
}

// validate file by mime type and size
function validateFile($file, $mimes, $size) {
    return in_array($file['type'], $mimes) && $file['size'] < $size * 1024 * 1024;
}

// prepare video data
function prepareVideo($video) {
    $video['name'] = htmlspecialchars($video['name']);
    $video['description'] = htmlspecialchars($video['description']);
    $video['channel'] = getUser($video['user_id']);

    return $video;
}

function getVideo($id) {
    global $db;
    $video = $db->query('SELECT * FROM videos WHERE id = ' . intval($id))->fetch();

    return $video ? prepareVideo($video) : false;
}

function checkAccess($video) {
    global $user;

    return $video && $user && $video['user_id'] === $user['id'];
}