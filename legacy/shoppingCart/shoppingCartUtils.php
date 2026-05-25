<?php require_once("../shared/Database.php");
function formatData($data, $user) {
    $formated = [
        "cine" => $data["cine"],
        "sala" => $data["sala"],
        "cip" => $data["cip"],
        "titulo_p" => $data["titulo_p"],
        "quantity" => $data["quantity"],
        "fecha" => $data["fecha"],
        "username" => $user
    ];

    return $formated;
}

function checkIfExists($data) {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM Entradas WHERE cine = :cine AND sala = :sala AND cip = :cip AND fecha = :fecha AND username = :username";
    $call = $db->prepare($query);
    $call -> bindParam(":cine", $data['cine'], PDO::PARAM_STR);
    $call -> bindParam(":sala", $data['sala'], PDO::PARAM_INT);
    $call -> bindParam(":cip", $data['cip'], PDO::PARAM_STR);
    $call -> bindParam(":fecha", $data['fecha']);
    $call -> bindParam(":username", $data['username'], PDO::PARAM_STR);

    try {
        $call->execute();
        $answer = $call->fetchAll(PDO::FETCH_ASSOC);
        return $answer ? true : false;
    } catch (PDOException $e) {
        echo $e;
    }

}

function addTicket($data) {
    $db = Database::getInstance()->getConnection();
    $query = "INSERT INTO Entradas (cine, sala, cip, fecha, numero, username) VALUES (:cine, :sala, :cip, :fecha, :numero, :username)";
    $call = $db->prepare($query);
    $call -> bindParam(":cine", $data['cine'], PDO::PARAM_STR);
    $call -> bindParam(":sala", $data['sala'], PDO::PARAM_INT);
    $call -> bindParam(":cip", $data['cip'], PDO::PARAM_STR);
    $call -> bindParam(":fecha", $data['fecha']);
    $call -> bindParam(":numero", $data['quantity'], PDO::PARAM_INT);
    $call -> bindParam(":username", $data['username'], PDO::PARAM_STR);

    try {
        $call->execute();
        $answer = "Entrada Añadida correctamente";
        return $answer;
    } catch (PDOException $e) {
        echo $e;
    }

}

function updateNumberOfTickets($data) {
    $db = Database::getInstance()->getConnection();
    $query = "UPDATE Entradas SET numero = :numero WHERE cine = :cine AND sala = :sala AND cip = :cip AND fecha = :fecha AND username = :username";
    $call = $db->prepare($query);
    $call -> bindParam(":cine", $data['cine'], PDO::PARAM_STR);
    $call -> bindParam(":sala", $data['sala'], PDO::PARAM_INT);
    $call -> bindParam(":cip", $data['cip'], PDO::PARAM_STR);
    $call -> bindParam(":fecha", $data['fecha']);
    $call -> bindParam(":numero", $data['quantity'], PDO::PARAM_INT);
    $call -> bindParam(":username", $data['username'], PDO::PARAM_STR);

    try {
        $call->execute();
        $answer = "Número de entradas actualizado";
        return $answer;
    } catch (PDOException $e) {
        echo $e;
    }
}