<?php require_once("../shared/Database.php");

/**
 * Explanation of getAllFilms
 * @return array of all the films in the database
 */
function getAllFilms(){
    $db = Database::getInstance()->getConnection();
    $query = "SELECT cip, titulo_p FROM Pelicula ORDER BY titulo_p ASC";
    $call = $db->query($query);
    $filmList = $call->fetchAll(PDO::FETCH_ASSOC);

    return $filmList;
}

/**
 * Explanation of getAllCharacters
 * @return array of all the characters in the database
 */
function getAllCharacters(){
    $db = Database::getInstance()->getConnection();
    $query = "SELECT nombre_persona FROM Personaje ORDER BY nombre_persona ASC";
    $call = $db->query($query);
    $charcterList = $call->fetchAll(PDO::FETCH_ASSOC);

    return $charcterList;
}

/**
 * Explanation of getAllTasks
 * @return array of all the task in the database
 */
function getAllTasks(){
    $db = Database::getInstance()->getConnection();
    $query = "SELECT tarea FROM Tarea ORDER BY tarea ASC";
    $call = $db->query($query);
    $taskList = $call->fetchAll(PDO::FETCH_ASSOC);

    return $taskList;
}

// Validation of given values
function checkNewCharacter($codeFilm, $nameActor, $taskGiven) {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT COUNT(*) FROM Trabajo WHERE cip = :code AND nombre_persona = :actorName AND tarea = :task";
    $call = $db->prepare($query);
    $call -> bindParam(":code", $codeFilm, PDO::PARAM_STR);
    $call -> bindParam(":actorName", $nameActor, PDO::PARAM_STR);
    $call -> bindParam(":task", $taskGiven, PDO::PARAM_STR);

    try {
        $call -> execute();
        $valid = $call->fetchColumn();
        return $valid > 0;
    } catch (PDOException $e) {
        echo $e;
    }
}

/**
 * Explanation of addCharacterToFilm
 * @param string $codeFilm // The code of the film selected
 * @param string $nameActor // The name of the actor selected
 * @param string $taskGiven // The name of the task selected
 * @return void
 */
function addCharacterToFilm($codeFilm, $nameActor, $taskGiven) {
    $db = Database::getInstance()->getConnection();
    $query = "INSERT INTO Trabajo (cip, nombre_persona, tarea) VALUES (:code, :actorName, :task)";
    $call = $db->prepare($query);
    $call -> bindParam(":code", $codeFilm, PDO::PARAM_STR);
    $call -> bindParam(":actorName", $nameActor, PDO::PARAM_STR);
    $call -> bindParam(":task", $taskGiven, PDO::PARAM_STR);

    try {
        $call -> execute();
    } catch (PDOException $e) {
        echo $e;
    }
}