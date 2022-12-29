<?php
include 'includes/header.php';

$errors = [];
if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!validateMax($name, 20)) {
        $errors['name'] = 'Field is incorrect';
    }
    $query = $db->prepare('SELECT * FROM users WHERE name = :name');
    $query->execute([
        'name' => $name,
    ]);
    if($query->fetch()) {
        $errors['name'] = 'Name is exists';
    }

    if(!validateMax($description, 500, false)) {
        $errors['description'] = 'Field is incorrect';
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Field is incorrect';
    }
    $query = $db->prepare('SELECT * FROM users WHERE email = :email');
    $query->execute([
        'email' => $email,
    ]);
    if($query->fetch()) {
        $errors['email'] = 'Email is exists';
    }

    if(mb_strlen($password) < 6) {
        $errors['password'] = 'Field is incorrect';
    }

    if(count($errors) === 0) {
        $query = $db->prepare('INSERT INTO users (name, description, email, password) VALUES (:name, :description, :email, :password)');
        $query->execute([
            'name' => $name,
            'description' => $description,
            'email' => $email,
            'password' => md5($password),
        ]);
        redirect('auth.php');
    }
}
?>

    <h1>Registration</h1>
    <form action="registration.php" method="post" novalidate>
        <label>
            Channel name:<br>
            <input type="text" name="name" value="<?= $name ?? '' ?>">
            <?= $errors['name'] ?? '' ?>
        </label><br>
        <label>
            Channel description:<br>
            <textarea name="description"><?= $description ?? '' ?></textarea>
            <?= $errors['description'] ?? '' ?>
        </label><br>
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
        <input type="submit" name="submit" value="Registration">
    </form>

<?php
include 'includes/footer.php';