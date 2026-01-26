
<?php
$pageStyle = 'profil.css';
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$error = "";

if (!empty($_POST)) {
    $result = profile_modification_process($pdo, $_POST);
    if ($result === true) {
        header("Location: profil.php");
        exit;
    } else {
        $error = $result;
    }
}

$information = get_information_user($pdo, $_SESSION['id']);

?>

<main>
    <?php 
    if (!empty($error)){
        echo '<p class="form-error">' . $error .  '</p>';
    }
    ?>
    <form action="" method="POST">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($information['login']); ?>">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="Nouveau mot de passe">
        <label for="confirm_password">Confirmation du mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmation du mot de passe">
        <input type="submit" value="Modifier">
    </form>
</main>

<?php include '../includes/footer.php'; ?>
