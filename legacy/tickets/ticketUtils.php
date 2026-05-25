<?php require("../shared/Database.php");

function getMovies() {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT cip, titulo_p FROM Pelicula";
    $call = $db->query($query);
    try {
        $call->execute();
        $result = $call->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo $e;
    }

   
}

function numberOfPages() {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT COUNT(*)
    FROM Proyeccion p JOIN Pelicula pe JOIN sala s WHERE p.cip = pe.cip 
    AND CURRENT_DATE() BETWEEN p.fecha_estreno AND p.fecha_estreno + p.dias_estreno
    AND p.sala = s.sala AND p.cine = s.cine";
    $call = $db->query($query);
    try {
        $call->execute();
        $result = $call->fetchColumn();
        return $result;
    } catch (PDOException $e) {
        echo $e;
    }
}

function getActualProjections($limit, $offset) {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT p.cine, p.sala, p.fecha_estreno, pe.titulo_p, p.cip, s.aforo, CURRENT_DATE() AS fecha
    FROM Proyeccion p JOIN Pelicula pe JOIN sala s WHERE p.cip = pe.cip 
    AND CURRENT_DATE() BETWEEN p.fecha_estreno AND p.fecha_estreno + p.dias_estreno
    AND p.sala = s.sala AND p.cine = s.cine LIMIT $limit OFFSET $offset";
    $call = $db->query($query);
    try {
        $call->execute();
        $result = $call->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo $e;
    }
}

function getNumberOfTickets() {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT aforo FROM Sala";
    $call = $db->query($query);
    try {
        $call->execute();
        $result = $call->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        //throw $th;
    }
}