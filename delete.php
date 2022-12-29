<?php
$forAuth = true;
include 'includes/core.php';

$video = getVideo($_GET['id']);

if(checkAccess($video)) {
    @unlink($video['cover_path']);
    @unlink($video['video_path']);
    $db->query('DELETE FROM videos WHERE id = ' . $video['id']);
}

redirect('index.php');