<?php
$forAuth = true;
include 'includes/header.php';

$errors = [];
if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $cover = $_FILES['cover'];
    $video = $_FILES['video'];

    if(!validateMax($name, 50)) {
        $errors['name'] = 'Incorrect field';
    }
    if(!validateMax($description, 500, false)) {
        $errors['description'] = 'Incorrect field';
    }
    if(!validateFile($cover, ['image/jpeg', 'image/png'], 2)) {
        $errors['cover'] = 'Incorrect file';
    }
    if(!validateFile($video, ['video/mp4'], 500)) {
        $errors['video'] = 'Incorrect file';
    }
    if(count($errors) === 0) {
        $coverPath = uploadFile($cover);
        $videoPath = uploadFile($video);
        $query = $db->prepare('INSERT INTO videos (name, description, cover_path, video_path, user_id) VALUES (:name, :description, :cover_path, :video_path, :user_id)');
        $query->execute([
            'name' => $name,
            'description' => $description,
            'cover_path' => $coverPath,
            'video_path' => $videoPath,
            'user_id' => $user['id'],
        ]);

        redirect('video.php?id=' . $db->lastInsertId());
    }
}
?>

    <h1>Add video</h1>
    <form action="create.php" method="post" novalidate enctype="multipart/form-data">
        <label>
            Video name:<br>
            <input type="text" name="name" value="<?= $name ?? '' ?>">
            <?= $errors['name'] ?? '' ?>
        </label><br>
        <label>
            Video description:<br>
            <textarea name="description"><?= $description ?? '' ?></textarea>
            <?= $errors['description'] ?? '' ?>
        </label><br>
        <label>
            Cover image:<br>
            <input type="file" name="cover">
            <?= $errors['cover'] ?? '' ?>
        </label><br>
        <label>
            Video file:<br>
            <input type="file" name="video">
            <?= $errors['video'] ?? '' ?>
        </label><br>
        <br>
        <input type="submit" name="submit" value="Add video">
    </form>

<?php
include 'includes/footer.php';