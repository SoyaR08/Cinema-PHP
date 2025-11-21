<?php require("../shared/Database.php");

function validateValues($data) {
    if (!isset($_GET['action']) || empty($_GET['action']) || ($_GET['action'] != "showMore" 
    && $_GET['action'] != "edit" && $_GET['action'] != "add" && $_GET['action'] != "delete")
    || !isset($_GET['cinema']) || empty($_GET['cinema']) || !isset($_GET['room']) || empty($_GET['room']) || !is_numeric($_GET['room'])) {
        echo "<script>window.location.href='../shared/error.php?msg=Hay uno más valores inválidos'</script>";

    }
}

//Returns every movie
function getAllMovieTheater() {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM Sala";
    $call = $db->query($query);
    $listMovieTheater = $call->fetchAll(PDO::FETCH_ASSOC);

    return $listMovieTheater;

}

function showTheTitle($action) {
    switch ($action) {
        case 'showMore':
            echo "Mostrando Sala";
            break;
        

    }
}

function locateTheMovieTheater($cinemaName, $room){
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM Sala WHERE cine = :cine AND sala = :sala";
    $call = $db->prepare($query);
    $call -> bindParam(":cine", $cinemaName, PDO::PARAM_STR);
    $call -> bindParam(":sala", $room, PDO::PARAM_INT);
    try {
        $call->execute();
        $movieTheater = $call->fetch(PDO::FETCH_ASSOC);
        return $movieTheater;
    } catch (PDOException $e) {
        echo $e;
    }
    
}

function disabledOrNot($action) {
    switch ($action) {
        case 'showMore':
            echo "disabled";
            break;
        
        
    }
}