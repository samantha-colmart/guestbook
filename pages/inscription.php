
<?php
$pageStyle = 'inscription.css';
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';

$error = "";

if (!empty($_POST)) {
    $result = sign_up($pdo, $_POST);

    if ($result === true) {
        header("Location: connexion.php");
        exit;
    } else {
        $error = $result;
    }
}


?>

<main>
    <h1>Page d'inscription</h1>
    <?php 
        if (!empty($error)){
            echo '<p>' . $error .  '</p>';
        }
    ?>
    <form action="" method="POST">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" placeholder="Votre identifiant">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="Min. 6 caractères">
        <label for="confirm_password">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmez votre mot de passe">
        <input type="submit" value="S'inscrire">
    </form>
</main>


<?php include '../includes/footer.php'; ?>
