<?php


function showTitle($action) {
    switch ($action) {
        case 'show': 
            echo 'Mostrando cine';
            break;
        case 'add':
            echo 'Añadir Cine';
            break;
        case 'edit':
            echo 'Editando Cine';
            break;
        case 'delete':
            echo 'Eliminando Cine';
            break;
    }
}

function submitButton($action) {
    switch ($action) {
        case 'add':
            echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\" value=\"added\">Añadir</button>";
            break;
        case 'edit':
            echo "<button type=\"submit\" class=\"btn btn-warning\" name=\"submit\" value=\"edited\">Editar</button>";
            break;
        case 'delete':
            echo "<button type=\"submit\" class=\"btn btn-danger\" name=\"submit\" value=\"deleted\">Eliminar</button>";
            break;
    }

}

function showValue($action, $field) {
    switch ($action) {
        case 'add':
            echo "";
            break;
        
        default:
        echo $field;
            break;
    }
}

function disabledOrNot($action, $field) {
    switch ($action) {
        case 'show': 
            echo 'disabled';
            break;
        case 'delete':
            echo 'readonly';
            break;
        case 'edit':
            if ($field) {
                echo 'readonly';
            }
            break;
    }
}

function addCinema($cinemaName, $city, $address, $age) {
    try {
        $pdo = Database::getInstance()->getConnection();
        $sql = "INSERT INTO Cine (cine, ciudad_cine, direccion_cine, antiguedad) VALUES (:cine, :ciudad_cine, :direccion_cine, :antiguedad)";
        $stmt = $pdo->prepare($sql); 

        $stmt->bindParam(':cine', $cinemaName);
        $stmt->bindParam(':ciudad_cine', $city);
        $stmt->bindParam(':direccion_cine', $address);
        $stmt->bindParam(':antiguedad', $age);

        if ($stmt->execute()) {
            return "<div class='alert alert-success'>Cine guardado exitosamente.</div>";
        } else {
            return "<div class='alert alert-danger'>Error al guardar el cine.</div>";
        }
    } catch (PDOException $e) {
        return "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}


function deleteCinema($cinemaName) {
    try {
        $pdo = Database::getInstance()->getConnection();
        $sql = "DELETE FROM Cine WHERE cine = :cine";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cine', $cinemaName);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        return false;
    }
}

function getCinema($cinemaName) {
    try {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM Cine WHERE cine = :cine";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cine', $cinemaName);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        return false;
    }
}

function updateCinema($cinemaName, $ciudad_cine, $direccion_cine, $antiguedad) {
    try {
        $pdo = Database::getInstance()->getConnection();
        $sql = "UPDATE Cine SET ciudad_cine = :ciudad_cine, direccion_cine = :direccion_cine, antiguedad = :antiguedad WHERE cine = :cine";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cine', $cinemaName); 
        $stmt->bindParam(':ciudad_cine', $ciudad_cine);
        $stmt->bindParam(':direccion_cine', $direccion_cine);
        $stmt->bindParam(':antiguedad', $antiguedad);
        if ($stmt->execute()) {
            return "<div class='alert alert-success'>Cine actualizado exitosamente.</div>";
        } else {
            return "<div class='alert alert-danger'>Error al actualizar el cine.</div>";
        }
    } catch (PDOException $e) {
        return "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}


