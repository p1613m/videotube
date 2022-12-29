<?php
include 'includes/header.php';

$errors = [];
if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = $db->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
    $query->execute([
        $email,
        md5($password),
    ]);
    if($user = $query->fetch()) {
        $_SESSION['user_id'] = $user['id'];
        redirect('index.php');
    }

    $errors['email'] = 'Invalid data';
}
?>

    <h1>Authorization</h1>
    <form action="auth.php" method="post" novalidate>
        <label>
            Email:<br>
            <input type="email" name="email" value="<?= $email ?? '' ?>">
            <?= $errors['email'] ?? '' ?>
        </label><br>
        <label>
            Password:<br>
            <input type="password" name="password">
            <?= $errors['password'] ?? '' ?>
        </label><br>
        <input type="submit" name="submit" value="Auth">
    </form>

<?php
include 'includes/footer.php';