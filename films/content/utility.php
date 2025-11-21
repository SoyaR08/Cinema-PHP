<?php

function findFilm($conexion, $films, $id=null) {

    if ($id == null) {
        // $lastFilm = end($films);
        // $cont_aux = preg_replace('/\D/', '', $lastFilm['cip']);
        // $next_film_code = $cont_aux + 1 . "-S";

        return     [
            'cip' => '',
            'titulo_p' => '',
            'ano_produccion' => '',
            'titulo_s' => '',
            'nacionalidad' => '',
            'presupuesto' => '',
            'duracion' => ''
        ];

    }     
    
    $query = "SELECT * FROM Pelicula WHERE cip = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $film = $stmt->fetch(PDO::FETCH_ASSOC);

    return $film;
}

function validateID() {
    if (isset($_GET['id'])) {
        return strval($_GET['id']);
    } else {
        echo "<script>window.location.href = '../shared/error.php?msg=El id no puede estar vacío';</script>";
        exit();
    }
}

function validateAction() {
    if (isset($_GET['accion']) && ($_GET['accion'] == 'info' || $_GET['accion'] == 'editar' || $_GET['accion'] == 'eliminar' || $_GET['accion'] == 'add' || $_GET['accion'] == 'editConfirm' || $_GET['accion'] == 'deleteConfirm') ) {
        return $_GET['accion'];
    } else {
        echo "<script>window.location.href = '../shared/error.php?msg=La accion es incorrecta';</script>";
        exit();
    }
}

function showTitle($accion) {
    switch ($accion) {
        case 'info':
            return "Viendo película";

        case 'editar':
            return "Editando película";

        case 'eliminar':
            return "Eliminando película";
        
        case 'add':
            return "Añadiendo película";

        case 'editConfirm':
            return "Confirmar edición";

        case 'deleteConfirm':
            return "Confirmar borrado";
        }
}

function deleteFilm ($conexion, $id) {
    $query = "DELETE FROM Pelicula WHERE cip = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "<script>window.location.href = '../shared/error.php?msg=La película $id es incorrecta';</script>";
        exit();
    }
}

function editFilm($conexion, $films, $id, $postData) {

    $query = "UPDATE Pelicula 
              SET titulo_p = :titulo_p, 
                  ano_produccion = :ano_produccion, 
                  titulo_s = :titulo_s, 
                  nacionalidad = :nacionalidad, 
                  presupuesto = :presupuesto, 
                  duracion = :duracion 
              WHERE cip = :id";
    
    $stmt = $conexion->prepare($query);
    
    $stmt->bindParam(':titulo_p', $postData['titulo_p'], PDO::PARAM_STR);
    $stmt->bindParam(':ano_produccion', $postData['ano_produccion'], PDO::PARAM_INT);
    $stmt->bindParam(':titulo_s', $postData['titulo_s'], PDO::PARAM_STR);
    $stmt->bindParam(':nacionalidad', $postData['nacionalidad'], PDO::PARAM_STR);
    $stmt->bindParam(':presupuesto', $postData['presupuesto'], PDO::PARAM_INT);
    $stmt->bindParam(':duracion', $postData['duracion'], PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();

    $query = "SELECT * FROM Pelicula WHERE cip = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    
    $film = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $film;
}

function addFilm($conexion, $postData) {
    $film = [
        'cip' => $postData['cip'],
        'titulo_p' => $postData['titulo_p'],
        'ano_produccion' => $postData['ano_produccion'],
        'titulo_s' => $postData['titulo_s'],
        'nacionalidad' => $postData['nacionalidad'],
        'presupuesto' => $postData['presupuesto'],
        'duracion' => $postData['duracion']
    ];

    $query = "INSERT INTO Pelicula (cip, titulo_p, ano_produccion, titulo_s, nacionalidad, presupuesto, duracion) 
    VALUES (:cip, :titulo_p, :ano_produccion, :titulo_s, :nacionalidad, :presupuesto, :duracion)";

    $stmt = $conexion->prepare($query);

    $stmt->bindParam(':cip', $film['cip'], PDO::PARAM_STR);
    $stmt->bindParam(':titulo_p', $film['titulo_p'], PDO::PARAM_STR);
    $stmt->bindParam(':ano_produccion', $film['ano_produccion'], PDO::PARAM_INT);
    $stmt->bindParam(':titulo_s', $film['titulo_s'], PDO::PARAM_STR);
    $stmt->bindParam(':nacionalidad', $film['nacionalidad'], PDO::PARAM_STR);
    $stmt->bindParam(':presupuesto', $film['presupuesto'], PDO::PARAM_INT);
    $stmt->bindParam(':duracion', $film['duracion'], PDO::PARAM_INT);
    
    $stmt->execute();

    return $film;
}

function validateErrors (&$errors, $postData, $films, $accion, $id=0) {
    if ($accion == "editar") {
        foreach ($films as $key => $row) {
            if ($row['cip'] == $id) {
                unset($films[$key]);
            }
        }
    } else if ($accion == "add") {
        if (!isset($postData['cip']) || empty($postData['cip'])) {
            $errors [] = "El CIP es necesario";
        } else {
            $cip = htmlspecialchars($_POST['cip']);

            foreach ($films as $film) {
                if ($film['cip'] == $cip) {
                    $errors [] = "Ya existe una película con ese CIP";
                }
            }
        }
    }

    if (!isset ($_POST['titulo_p'])) {
        $errors [] = "El título es necesario";
      }

      if (!isset ($_POST['ano_produccion'])) {
        $errors [] = "El año de producción es necesario";
      } else if (!is_numeric($_POST['ano_produccion'])) {
        $errors [] = "El año de producción debe ser numérico";
      } else if ($_POST['ano_produccion'] <= 0) {
        $errors [] = "El año de producción debe ser mayor de 0";
      }

      if (!is_numeric($_POST['presupuesto'])) {
        $errors [] = "El presupuesto debe ser numérico";
      } else if ($_POST['presupuesto'] <= 0) {
        $errors [] = "El presupuesto debe ser mayor de 0";
      }

      if (!is_numeric($_POST['duracion'])) {
        $errors [] = "La duración debe ser numérica";
      } else if ($_POST['duracion'] <= 0) {
        $errors [] = "La duración debe ser mayor de 0";
      }

      if (isset($_POST['titulo_p']) && isset($_POST['ano_produccion'])) {
        foreach ($films as $row) {
          if ($row['titulo_p'] == $_POST['titulo_p'] && $row['ano_produccion'] == $_POST['ano_produccion']) {
            $errors [] = "Ya existe una película con el mismo título y año de producción";
          }
        }
      }

      return $errors;

}

function mostrarReparto($conexion, $id) {
    $query = "
        SELECT 
            Personaje.nombre_persona AS Nombre,
            Trabajo.tarea AS Papel
        FROM 
            Pelicula
        JOIN 
            Trabajo ON Pelicula.cip = Trabajo.cip
        JOIN 
            Personaje ON Trabajo.nombre_persona = Personaje.nombre_persona
        WHERE 
            Pelicula.cip = :cip
    ";

    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':cip', $id, PDO::PARAM_STR);  // Asegúrate de que el nombre del parámetro sea ":cip"
    $stmt->execute();

    $reparto = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "<ul class='list-group list-group-flush'>";

    // foreach($reparto as $row) {
    //     echo "<li class='list-group-item'><strong>NOMBRE: </strong>{$row['Nombre']}<br><strong>PAPEL: </strong>{$row['Papel']}</li>";
    // }

    // echo "</ul>";

    echo "<table class='table table-bordered table-striped'><tr><th>PAPEL</th><th>NOMBRE</th></tr>";

    foreach($reparto as $row) {
        echo "<tr'><td>{$row['Papel']}</td><td>{$row['Nombre']}</td></tr>";
    }

    echo "</table>";

}