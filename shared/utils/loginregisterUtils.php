<?php require_once("../shared/Database.php");

function checkIfExist($userName, $userPassword) {
    $result = null;
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM Usuario WHERE username = :name";
    $call = $db->prepare($query);
    $call -> bindParam(":name", $userName, PDO::PARAM_STR);
    
    try {
        $call->execute();
        $result = $call->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $error) {
        echo $error;
    }

}

function signIn($name, $password) {
    $result = null;
    $default = "USER";
    $db = Database::getInstance()->getConnection();
    $query = "INSERT INTO Usuario (username, password, role) VALUES (:newUserName, :newPassword, :defaultRole)";
    $call = $db->prepare($query);
    $call -> bindParam(":newUserName", $name, PDO::PARAM_STR);
    $securePassword = password_hash($password, PASSWORD_DEFAULT);
    $call -> bindParam(":newPassword", $securePassword, PDO::PARAM_STR);
    $call -> bindParam(":defaultRole", $default, PDO::PARAM_STR);
    try {
        $call->execute();
        $result = true;
        return $result;
    } catch (PDOException $e) {
        echo $e;
    }
}