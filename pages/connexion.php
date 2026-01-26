
<?php
$pageStyle = 'connexion.css';
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';


$error = "";

if (!empty($_POST)) {
    $result = login_process($pdo, $_POST);
    if ($result === true) {
        header("Location: profil.php");
        exit;
    } else {
        $error = $result;
    }
}
?>


<main>
    <h1>Page de connexion</h1>
    <?php 
    if (!empty($error)){
        echo '<p>' . $error .  '</p>';
    }
    ?>
    <form action="" method="POST">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" placeholder="Votre identifiant">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="Votre mot de passe">
        <input type="submit" value="Se connecter">
    </form>
</main>


<?php include '../includes/footer.php'; ?>
