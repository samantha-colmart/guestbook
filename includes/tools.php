<?php

// Vérification si les champs du formulaire sont bien remplis
function empty_fields($post, $fields) {
    foreach ($fields as $field) {
        if (empty($post[$field])) {
            return true;
        }
    }
    return false;
}



// Vérification validité données inscription utilisateur
function field_verification($login, $password, $confirm_password){
    if (strlen($login) < 3 || strlen($login) > 255) {
        return "Le login doit contenir entre 3 et 255 caractères";
    }
    elseif (strlen($password) < 6 || !preg_match('/[0-9]/', $password)) {
        return "Le mot de passe doit contenir au moins 6 caractères et au moins un chiffre";
    }
    elseif ($password != $confirm_password) {
        return "Les deux mots de passe doivent être égaux";
    }
    return true;
}



// Récupération des informations d'un utilisateur
function user_by_login($pdo, $login) {
    $sql = "SELECT * FROM user WHERE login = :login";
    $query = $pdo->prepare($sql);
    $query->execute([':login' => $login]);
    return $query->fetch(PDO::FETCH_ASSOC);
}



// Vérification si login existe déjà dans la BDD
function login_exists($pdo, $login, $id = null) {
    if ($id === null) {
        $sql = "SELECT id FROM user WHERE login = :login";
        $params = [':login' => $login];
    } else {
        $sql = "SELECT id FROM user WHERE login = :login AND id != :id";
        $params = [':login' => $login, ':id'    => $id];
    }
    $query = $pdo->prepare($sql);
    $query->execute($params);
    if ($query->fetch(PDO::FETCH_ASSOC)) {
        return true;
    }
    return false;
}



// Fonction pour enregistrer les données d'inscription de l'utilisateur dans la BDD
function recording($pdo, $login, $password) {
    if (login_exists($pdo, $login)) {
        return "Ce nom d'utilisateur est déjà utilisé";
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (login, password) VALUES (:login, :password)";
    $query = $pdo->prepare($sql);
    $query->execute([':login' => $login, ':password' => $hash]);
    return true;
}



// Processus d'appel pour vérification puis enregistrement inscription dans BDD
function sign_up($pdo, $post) {
    if (empty_fields($post, ["login", "password", "confirm_password"])) {
        return "Veuillez remplir l'ensemble des champs.";
    }
    $result = field_verification(trim($post["login"]), $post["password"], $post["confirm_password"]);
    if ($result === true) {
        return recording($pdo, trim($post["login"]), $post["password"]);
    }
    return $result;
}



// Verification validité données et stockage dans session
function log_in($pdo, $login, $password) {
    $user = user_by_login($pdo, $login);
    if ($user === false) {
        return "Identifiant ou mot de passe incorrect";
    }
    if (!password_verify($password, $user["password"])) {
        return "Identifiant ou mot de passe incorrect";
    }
    $_SESSION["id"] = $user["id"];
    return true;
}



//  Processus d'appel pour vérification puis connexion
function login_process($pdo, $post) {
    if (empty_fields($post, ["login", "password"])) {
        return "Veuillez renseigner votre login et votre mot de passe.";
    }
    return log_in($pdo, trim($post["login"]), $post["password"]);
}



// Mise à jour des informations de l'utilisateur dans BDD
function update_profile($pdo, $id, $login, $password) {
    if (login_exists($pdo, $login, $id)) {
        return "Ce nom d'utilisateur est déjà utilisé";
    }
    $sql = "UPDATE user SET login = :login, password = :password WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->execute([':login' => $login, ':password' => password_hash($password, PASSWORD_DEFAULT), ':id'  => $id]);
    return true;
}


//  Processus d'appel pour vérification puis modification
function profile_modification_process($pdo, $post) {
    if (empty_fields($post, ["login", "password", "confirm_password"])) {
        return "Veuillez remplir l'ensemble des champs.";
    }
    $result = field_verification(trim($post["login"]), $post["password"], $post["confirm_password"]);
    if ($result === true) {
        return update_profile($pdo, $_SESSION["id"], trim($post["login"]), $post["password"]);
    }
    return $result;
}



// Récupération informations utilisateur par ID
function get_information_user($pdo, $id){
    $sql = "SELECT * FROM user WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->execute([':id' => $id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}



?>