<?php
    include "../shared/Database.php";  


    function getProyections($limit, $offset) {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM Proyeccion LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($query);
        $stmt ->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt ->bindParam(":offset", $offset, PDO::PARAM_INT);
        try {
            $stmt->execute();
            $proyection = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $proyection;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getNumberOfProyections() {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT COUNT(*) FROM Proyeccion";
        $stmt = $db->query($query);
        $proyectionNumber = $stmt->fetchColumn();
        return $proyectionNumber;
    }

    function addProjection($proyection) {
        $conexion = new PDO('mysql:host=db;dbname=cinema', 'root', 'root');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Verificar que el cine y sala existen en la tabla `sala`
        $checkQuery = "SELECT COUNT(*) FROM sala WHERE cine = :cine AND sala = :sala";
        $checkStmt = $conexion->prepare($checkQuery);
        $checkStmt->execute([
            ':cine' => $proyection['cine'],
            ':sala' => $proyection['sala']
        ]);
        $exists = $checkStmt->fetchColumn();
    
        if ($exists == 0) {
            throw new Exception("El cine y la sala especificados no existen en la tabla `sala`.");
        }
    
        // Insertar la nueva proyección
        $query = "INSERT INTO proyeccion (cine, sala, cip, fecha_estreno, dias_estreno, espectadores, recaudacion) 
                  VALUES (:cine, :sala, :cip, :fecha_estreno, :dias_estreno, :espectadores, :recaudacion)";
        $stmt = $conexion->prepare($query);
        $stmt->execute([
            ':cine' => $proyection['cine'],
            ':sala' => $proyection['sala'],
            ':cip' => $proyection['cip'],
            ':fecha_estreno' => $proyection['fecha_estreno'],
            ':dias_estreno' => $proyection['dias_estreno'],
            ':espectadores' => $proyection['espectadores'],
            ':recaudacion' => $proyection['recaudacion']
        ]);
    }
    

    function viewProyection($cine, $sala, $cip, $fecha_estreno) {
        $conexion = new PDO('mysql:host=db;dbname=cinema', 'root', 'root');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Cambié las comas por AND en el WHERE
        $query = "SELECT * FROM Proyeccion WHERE cine = :cine AND sala = :sala AND cip = :cip AND fecha_estreno = :fecha_estreno";
    
        try {
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':cine', $cine, PDO::PARAM_STR);
            $stmt->bindParam(':sala', $sala, PDO::PARAM_STR);
            $stmt->bindParam(':cip', $cip, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_estreno', $fecha_estreno, PDO::PARAM_STR);
            $stmt->execute();
            
            // Recupera los resultados como un array asociativo
            $informacion = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $informacion; // Devuelve el array completo con los datos de la tarea
        } catch (PDOException $e) {
            die("Error al encontrar la proyección: " . $e->getMessage());
        }
    }
    

    function deleteProyection($cine, $sala, $cip, $fecha_estreno){
        try {
            
            // Conexión a la base de datos con PDO
            $conexion = new PDO('mysql:host=db;dbname=cinema', 'root', 'root');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Preparar la consulta SQL para insertar una película
            $sql = "DELETE FROM Proyeccion WHERE cine = :cine AND sala = :sala AND cip = :cip AND fecha_estreno = :fecha_estreno";
    
            // Preparar la sentencia
            $stmt = $conexion->prepare($sql);
    
            // Asociar parámetros a la consulta
            $stmt->bindParam(':cine', $cine);
            $stmt->bindParam(':sala', $sala);
            $stmt->bindParam(':cip', $cip);
            $stmt->bindParam(':fecha_estreno', $fecha_estreno);
        
            // Ejecutar la consulta
            return $stmt->execute();
            
            
        } catch (PDOException $e) {
            echo "Error al eliminar la proyección: " . $e->getMessage();
        }
    
        // Cerrar la conexión
        $conexion = null;
    }
    
    function editProyection($cine, $sala, $cip, $fecha_estreno, $dias_estreno, $espectadores, $recaudacion, 
    $original_cine, $original_sala, $original_cip, $original_fecha_estreno) {
        // Conectar a la base de datos
        $conexion = new PDO('mysql:host=db;dbname=cinema', 'root', 'root');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Convertir la fecha al formato adecuado
        $fecha_estreno = date('Y-m-d', strtotime($fecha_estreno));
    
        // SQL para actualizar la proyección
        $sql = "UPDATE Proyeccion 
                SET cine = :cine, sala = :sala, cip = :cip, fecha_estreno = :fecha_estreno, 
                    dias_estreno = :dias_estreno, espectadores = :espectadores, recaudacion = :recaudacion
                WHERE cine = :original_cine AND sala = :original_sala 
                  AND cip = :original_cip AND fecha_estreno = :original_fecha_estreno";
    
        // Preparar y ejecutar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':cine', $cine);
        $stmt->bindParam(':sala', $sala);
        $stmt->bindParam(':cip', $cip);
        $stmt->bindParam(':fecha_estreno', $fecha_estreno);
        $stmt->bindParam(':dias_estreno', $dias_estreno);
        $stmt->bindParam(':espectadores', $espectadores);
        $stmt->bindParam(':recaudacion', $recaudacion);
    
        // Pasar los valores originales a la consulta
        $stmt->bindParam(':original_cine', $original_cine);
        $stmt->bindParam(':original_sala', $original_sala);
        $stmt->bindParam(':original_cip', $original_cip);
        $stmt->bindParam(':original_fecha_estreno', $original_fecha_estreno);
    
        // Ejecutar la consulta y verificar
        if ($stmt->execute()) {
            echo "Proyección actualizada con éxito.";
        } else {
            echo "No se encontró ninguna proyección para actualizar con esos valores.";
        }
    
        // Cerrar conexión
        $conexion = null;
    }
    
    
    function validateAction() {
        if (isset($_GET['action']) && ($_GET['action'] == 'showMore' || $_GET['action'] == 'edit' ||
        $_GET['action'] == 'delete' || $_GET['action'] == 'add')) {
            return htmlspecialchars($_GET['action']);
        }
    }

    function isDisabled ($action) {
        if ($action == "showMore" || $action == "remove" || $action == "alreadyRemoved") {
            echo "disabled";
        }    
    }

    function showTitleByAction($action) {
        switch ($action) {
            case 'showMore':
                echo "<h1 class=\'mb-4\'>MOSTRANDO PROYECCIÓN</h1>";
                break;
            case 'edit':
                echo "<h1 class=\'mb-4\'>EDITANDO PROYECCIÓN</h1>";
                break;
            case 'delete':
                echo "<h1 class=\'mb-4\'>ELIMINANDO PROYECCIÓN</h1>";
                break;
            case 'alreadyRemoved':
                echo "<h1 class=\'mb-4\'>PROYECCIÓN YA ELIMINADA</h1>";
                break;
            case 'alreadyEdited':
                echo "<h1 class=\'mb-4\'>PROYECCIÓN EDITADA CON ÉXITO</h1>";
                break;
            case 'add':
                echo "<h1 class=\'mb-4\'>INSERTANDO NUEVA PROYECCIÓN</h1>";
                break;
                case 'alreadyAdded':
                echo "<h1 class=\'mb-4\'>NUEVA PROYECCIÓN INSERTADA CON ÉXITO</h1>";
                break;
            }  
    }

    function showButtonByAction($action) {
        // Dependiendo de la acción, se muestra un botón o un enlace específico
        switch ($action) {
            case 'showMore':
                echo '<a href="menuProyection.php" class="btn btn-primary">Volver</a>';
                break;
            case 'edit':
                echo '<button type="submit" class="btn btn-secondary">Guardar cambios</button>';
                break;
            case 'delete':
                echo '<button type="submit" class="btn btn-danger">Confirmar eliminación</button>';
                break;
            case 'alreadyRemoved':
                echo '<a href="menuProyection.php" class="btn btn-primary">Proyección ya eliminada. Volver</a>';
                break;
            case 'alreadyEdited':
                echo '<a href="menuProyection.php" class="btn btn-primary">Proyección ya editada. Volver</a>';
                break;
            case 'add':
                echo '<button type="submit" class="btn btn-success">Confirmar inserción</button>';
                break;
            case 'alreadyAdded':
                echo '<a href="menuProyection.php" class="btn btn-success">Proyección ya insertada. Volver</a>';
                break;
        }
    }

    function displayErrors($errors) {
        if (!empty($errors)) {
            echo "<div class='alert alert-danger'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
    }
?>