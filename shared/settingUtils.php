<?php require("Database.php");


function getUser($user) {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT username, password FROM Usuario WHERE username = :user";
    $call = $db->prepare($query);
    $call -> bindParam(":user", $user, PDO::PARAM_STR);
    try {
        $call -> execute();
        $answer = $call->fetch(PDO::FETCH_ASSOC);
        return $answer;
    } catch (PDOException $e) {
        echo $e;
    }
}

function updatePassword($user, $password) {
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