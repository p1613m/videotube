<?php
include 'includes/core.php';
$ids = explode(',', $_GET['ids']);

$videosCount = $db->query('SELECT * FROM videos')->rowCount();
$query = $db->prepare("SELECT * FROM videos WHERE id not in (" . str_repeat('?, ', count($ids) - 1) . "?) ORDER BY RAND() LIMIT 10");
$query->execute($ids);
$videos = [];
$videosFromDatabase = $query->fetchAll();
foreach ($videosFromDatabase as $video) {
    $video = prepareVideo($video);
    $videos []= $video;
}
echo json_encode([
    'count' => $videosCount - (count($ids) + count($videosFromDatabase)),
    'videos' => $videos
]);

