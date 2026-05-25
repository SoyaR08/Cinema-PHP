<?php require("Database.php");

function listUsers() {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT username FROM Usuario";
    $call = $db->query($query);
    $list = $call->fetchAll(PDO::FETCH_ASSOC);
    return $list;
}

function searchUser($username) {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT username, password FROM Usuario WHERE username = :user";
    $call = $db->prepare($query);
    $call ->bindParam(":user", $username, PDO::PARAM_STR);

    try {
        $call ->execute();
        $list = $call->fetch(PDO::FETCH_ASSOC);
        return $list;
    } catch (PDOException $e) {
        echo $e;
    }

    
}

function showTheTitle($action) {
    switch ($action) {
        case 'role':
            echo "Cambiando Rol";
            break;
        
        case 'password':
            echo "Cambiando Contraseña";
            break;
    }
}

function changeRole($username, $role) {
    $db = Database::getInstance()->getConnection();
    $query = "UPDATE Usuario SET role = :role WHERE username = :user";
    $call = $db->prepare($query);
    $call ->bindParam(":user", $username, PDO::PARAM_STR);
    $call ->bindParam(":role", $role, PDO::PARAM_STR);

    try {
        $call ->execute();
        $list = $call->fetch(PDO::FETCH_ASSOC);
        return $list;
    } catch (PDOException $e) {
        echo $e;
    }
}

function adminupdatePassword($user, $password) {
    $db = Database::getInstance()->getConnection();
    $query = "UPDATE Usuario SET password = :pass WHERE username = :user";
    $call = $db->prepare($query);
    $call -> bindParam(":user", $user, PDO::PARAM_STR);
    $call -> bindParam(":pass", $password, PDO::PARAM_STR);
    try {
        $call -> execute();
        $answer = $call->fetch(PDO::FETCH_ASSOC);
        return $answer;
    } catch (PDOException $e) {
        echo $e;
    }
}