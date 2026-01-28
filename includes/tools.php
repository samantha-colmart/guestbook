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


// Récupération informations message par ID
function get_information_message($pdo, $id, $id_user){
    $sql = "SELECT message FROM message WHERE id = :id AND id_user = :id_user";
    $query = $pdo->prepare($sql);
    $query->execute([':id' => $id, ':id_user' => $id_user]);
    return $query->fetch(PDO::FETCH_ASSOC);
}


// Fonction pour enregistrer le message dans la BDD
function add_message($pdo, $message, $id_user, $date){
    $sql = "INSERT INTO message (message, id_user, date) VALUES (:message, :id_user, :date)";
    $query = $pdo->prepare($sql);
    $query->execute([':message' => $message, ':id_user' => $id_user, ':date' => $date]);
    return true;
}


// Processus d'appel pour vérification message
function message_process($pdo, $post, $message, $id_user, $date){
    if (empty_fields($post, ["message"])) {
        return "Veuillez remplir l'ensemble des champs.";
    } elseif(strlen($message) > 450){
        return "Le message ne doit pas dépasser 450 caractères";
    }
    return add_message($pdo, $message, $id_user, $date);
}


// Fonction supprimer message
function message_deletion($pdo, $id, $id_user){
    $sql = "DELETE FROM message WHERE id = :id AND id_user = :id_user";
    $query = $pdo->prepare($sql);
    $query->execute([':id' => $id, ':id_user' => $id_user]);
    return true;
}


// Fonction modification message
function edit_message($pdo, $id, $message, $date, $id_user){
    if(strlen($message) > 450){
        return "Le message ne doit pas dépasser 450 caractères";
    }
    $sql = "UPDATE message SET message = :message, date = :date WHERE id = :id AND id_user = :id_user";
    $query = $pdo->prepare($sql);
    $query->execute([':message' => $message, ':date' => $date, ':id' => $id, ':id_user' => $id_user]);
    return true;
}



// Fonction pour récupérer toutes les infos de chaque message
function get_all($pdo, $offset, $limit){
    $sql = "SELECT message.id, message.message, message.date, message.id_user, user.login FROM message INNER JOIN user ON user.id = message.id_user
            ORDER BY message.date DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Fonction pour compter le nombre total de messages
function count_message($pdo){
    $sql = 'SELECT COUNT(*) AS nb_messages FROM message;';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $nbArticles = (int) $result['nb_messages'];
    return $nbArticles;
}


// Récup des messages en fonction de la barre de recherche
function search_messages($pdo, $search, $limit, $offset) {
    $sql = "SELECT message.id, message.message, message.date, message.id_user, user.login FROM message INNER JOIN user ON user.id = message.id_user
            WHERE user.login LIKE :search OR message.message LIKE :search ORDER BY message.date DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Fonction pour compter le nombre de messages en fonction de la recherche
function count_search_messages($pdo, $search){
    $sql = 'SELECT COUNT(*) AS nb_messages FROM message INNER JOIN user ON user.id = message.id_user WHERE user.login LIKE :search OR message.message LIKE :search';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    $nbArticles = (int) $result['nb_messages'];
    return $nbArticles;
}


// Fonction pour enregistrer un like dans la BDD
function add_like($pdo, $id_user, $id_message){
    $sql = "INSERT INTO likes (id_user, id_message) VALUES (:id_user, :id_message)";
    $query = $pdo->prepare($sql);
    $query->execute([':id_user' => $id_user, ':id_message' => $id_message]);
    return true;
}



// Fonction supprimer like
function like_deletion($pdo, $id_user, $id_message){
    $sql = "DELETE FROM likes WHERE id_user = :id_user AND id_message = :id_message";
    $query = $pdo->prepare($sql);
    $query->execute([':id_user' => $id_user, ':id_message' => $id_message]);
    return true;
}


// Fonction pour compter le nombre total de likes
function count_likes($pdo, $id_message){
    $sql = 'SELECT COUNT(*) AS nb_likes FROM likes WHERE id_message = :id_message;';
    $query = $pdo->prepare($sql);
    $query->execute(['id_message' => $id_message]);
    $result = $query->fetch();
    $nbLikes = (int) $result['nb_likes'];
    return $nbLikes;
}


// Vérifier si l'utilisateur à déjà liké le message
function user_liked($pdo, $id_user, $id_message){
    $sql = 'SELECT COUNT(*) AS user_liked FROM likes WHERE id_user = :id_user AND id_message = :id_message;';
    $query = $pdo->prepare($sql);
    $query->execute(['id_user' => $id_user, 'id_message' => $id_message]);
    $result = $query->fetch();
    $userLiked = (int) $result['user_liked'];
    return $userLiked > 0;
}
