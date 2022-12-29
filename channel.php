<?php
include 'includes/header.php';
$channel = getUser($_GET['id']);
if(!$channel) {
    redirect('index.php');
}

$videos = $db->query('SELECT * FROM videos WHERE user_id = ' . $channel['id'])
    ->fetchAll();
?>

<h1><?= $channel['name'] ?></h1>
<p><?= $channel['description'] ?></p>
<p>Count videos: <b><?= count($videos) ?></b></p>

    <?php
    foreach ($videos as $video):
    $video = prepareVideo($video);
    ?>

    <div style="margin-bottom: 20px;">
        <a href="video.php?id=<?= $video['id'] ?>">
            <img src="<?=$video['cover_path']?>" alt="" style="display: block;width: 150px;">
            <b><?=$video['name']?></b><br>
            <u><?=$video['channel']['name']?></u>
        </a>
    </div>

<?php endforeach; ?>

<?php
include 'includes/footer.php';