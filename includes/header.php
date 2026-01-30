
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d’or du restaurant</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../images/logo.png" alt="Logo du restaurant">
                <span>Le Bistrot Français</span>
            </div>
            <nav>
            <a href="accueil.php">Accueil</a>
            <a href="guestbook.php">Livre d’or</a>
            <?php
            if(!empty($_SESSION['id'])){
                echo '
                <a href="profil.php">Profil</a>
                <a href="messages.php">Ajouter un message</a>
                <a href="deconnexion.php">Deconnexion</a>';
            } else{
                echo '
                <a href="inscription.php">Inscription</a>
                <a href="connexion.php">Connexion</a>';
            }
            ?>
            </nav>
        </div>
    </header>
