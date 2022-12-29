<?php
include 'includes/header.php';
$video = getVideo($_GET['id']);

if(!$video) {
    redirect('index.php');
}

$errors = [];
if(checkAccess($video) && isset($_POST['submit'])) {
    $cover = $_FILES['cover'];

    if(!validateFile($cover, ['image/png', 'image/jpeg'], 2)) {
        $errors['cover'] = 'Incorrect file';
    } else {
        @unlink($video['cover_path']);
        $coverPath = uploadFile($cover);
        $db->query('UPDATE videos SET cover_path = "' . $coverPath . '" WHERE id = ' . $video['id']);
        $errors['cover'] = 'Success update';
    }
}
?>

    <h1><?= $video['name'] ?></h1>
    <u><a href="channel.php?id=<?=$video['channel']['id']?>"><?= $video['channel']['name'] ?></a></u><br>

    <video src="<?=$video['video_path']?>" controls></video>
    <p><?= $video['description'] ?></p><br>
    <?php if(checkAccess($video)): ?>
        <a href="delete.php?id=<?= $_GET['id'] ?>">Delete video</a><br>

        <h2>Change cover</h2>
        <form action="video.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
            <input type="file" name="cover"> <?= $errors['cover'] ?? '' ?><br>
            <input type="submit" name="submit" value="Change cover">
        </form>
    <?php endif; ?>

<?php
include 'includes/footer.php';