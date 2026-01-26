<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Module de connexion</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php
    if (isset($pageStyle)) {
        echo '<link rel="stylesheet" href="../css/' . $pageStyle . '">';
    }
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="accueil.php">Accueil</a>
                </li>
                <?php 
                if(!empty($_SESSION['id'])){
                    echo '
                    <li>
                        <a href="profil.php">Modification</a>
                    </li>
                    <li>
                        <a href="deconnexion.php">Deconnexion</a>
                    </li>';
                } else{
                    echo '
                    <li>
                        <a href="inscription.php">Inscription</a>
                    </li>
                    <li>
                        <a href="connexion.php">Connexion</a>
                    </li>';
                }
                ?>
            </ul>
        </nav>
    </header>