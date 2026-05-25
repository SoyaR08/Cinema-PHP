<?php

// Validamos que la película exista
function validateName($connection, $name)
{
    $query = "SELECT * FROM Personaje WHERE nombre_persona = :name"; // Prepara la consulta para buscar el personaje
    $stmt = $connection->prepare($query); // La prepara para su ejecución
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); // Vincula el parámetro de la consulta
    $stmt->execute(); // Ejecuta la consulta
    $personaje = $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un array asociativo
    return $personaje; // Devuelve el personaje o null
}

// Validamos que la acción sea válida
function validateAction($action)
{
    if (isset($action) && (($action == 'showMore') || ($action == 'delete') || ($action == 'edit')) || ($action == 'add') || ($action == 'alreadyDeleted') || ($action == 'alreadyEdited') || ($action == 'alreadyAdded')) {
        return htmlspecialchars($action);
        // Si la acción es válida la devuelve
    } else {
        echo "<script>window.location.href = \"../shared/error.php?msg=La acción no es válida\";</script>";
        exit();
        // Si no es válida te lleva a la página de error
    }
}

// Muestra el título de la página según la acción

function showTitle($action)
{
    switch ($action) {
        case 'showMore':
            echo '<h1>Mostrando Personaje</h1>';
            break;
        case 'delete':
            echo '<h1>Borrando Personaje</h1>';
            break;
        case 'alreadyDeleted':
            echo '<h1>Personaje borrado</h1>';
            break;
        case 'alreadyEdited':
            echo '<h1>Personaje editado</h1>';
            break;
        case 'edit':
            echo '<h1>Editando Personaje</h1>';
            break;
        case 'alreadyAdded':
            echo '<h1>Personaje añadido</h1>';
            break;
        case 'add':
            echo '<h1>Añadir Personaje</h1>';
            break;
    }
}

// Deshabilita campos según la acción
function readOnlyOrNot($action)
{
    switch ($action) {
        case 'showMore':
            echo " disabled ";
            break;
        case 'delete':
            echo 'disabled';
            break;
        case 'alreadyDeleted':
            echo 'disabled';
            break;
        case 'alreadyEdited':
            echo 'disabled';
            break;
        case 'alreadyAdded':
            echo 'disabled';
            break;
    }
}

// Habilita o deshabilita el campo del nombre
function readOnlyName($action)
{
    switch ($action) {
        case 'delete':
            echo 'disabled';
            break;
        case 'alreadyDeleted':
            echo 'disabled';
            break;
        case 'alreadyEdited':
            echo 'disabled';
            break;
        case 'alreadyAdded':
            echo 'disabled';
            break;
        case 'edit':
            echo 'disabled';
            break;
        case 'showMore':
            echo 'disabled';
            break;
    }
}

// Muestra los botones de acción según la acción
function showButton($action)
{
    echo "<a href=\"./characters.php\" class=\"btn btn-info btn-sm m-2\">Volver</a>";

    switch ($action) {
        case 'alreadyDeleted':
            echo "<button type='submit' class='btnEditDelete btn btn-danger btn-sm'>Confirmar</button>";
            break;
        case 'delete':
            echo "<button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>";
            break;
        case 'edit':
            echo "<button type='submit' class='btn btn-success btn-sm'>Guardar</button>";
            break;
        case 'add':
            echo "<button type='submit' class='btn btn-success btn-sm'>Añadir</button>";
            break;
        case 'alreadyAdded':
            echo "<a href=\"./characters.php\" class=\"btn btn-outline-success\">El personaje ha sido añadido</a>";
            break;
        case 'alreadyEdited':
            echo '<div class="alert alert-success">Actualizado con éxito</div>';
    }
}


function deletepersonaje($connection, $name)
{
    // Consulta SQL para eliminar un cliente con un ID específico
    $personaje = validateName($connection, $name);
    $query = "DELETE FROM Personaje WHERE nombre_persona = :name";
    $stmt = $connection->prepare($query);
    // Asignar el valor a la consulta
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    // Ejecutar la consulta
    $stmt->execute();
    // Comprobar si la eliminación fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=El personaje no existe.\"</script>"; // Si el cliente no es válido se redirige a la pagina de error.
        exit;
    }

    return $personaje;
}


function editpersonaje($connection, $actualName, $newNationality, $newGender)
{

    // Consulta SQL para actualizar el cliente con un ID específico 
    $query = "UPDATE Personaje SET nacionalidad_persona = :newNationality, sexo_persona = :newGender WHERE nombre_persona = :actualName";
    $stmt = $connection->prepare($query);
    // Asignar los valores a la consulta
    $stmt->bindParam(':newNationality', $newNationality);
    $stmt->bindParam(':newGender', $newGender);
    $stmt->bindParam(':actualName', $actualName);

    // Ejecutar la consulta
    $stmt->execute();
    // Comprobar si la actualización fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Ocurrió un fallo al intentar editar el personaje, por favor inténtelo de nuevo.\"</script>";
        exit;
    }
    return ["nombre_persona" => $actualName, "nacionalidad_persona" => $newNationality, "sexo_persona" => $newGender];
}


function addpersonaje($connection, $newName, $newNationality, $newGender)
{
    if (!isset($connection) && !isset($newName) && !isset($newNationality) && !isset($newGender) && empty($connection) && empty($newName) && empty($newNationality) && empty($newGender)) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Todos los campos son obligatorios para crear un personaje\"</script>";
        exit;
    }

    $existe = validateName($connection, $newName);
    if ($existe) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Este personaje ya existe\"</script>";
        exit;
    }
    // Consulta SQL para insertar un nuevo cliente
    $query = "INSERT INTO Personaje (nombre_persona, nacionalidad_persona, sexo_persona) VALUES (:name, :nationality, :gender)";
    $stmt = $connection->prepare($query);
    // Asignar los valores a la consulta
    $stmt->bindParam(':name', $newName);
    $stmt->bindParam(':nationality', $newNationality);
    $stmt->bindParam(':gender', $newGender);
    // Ejecutar la consulta
    $stmt->execute();

    // Comprobar si la actualización fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Ocurrió un fallo al intentar crear un personaje, por favor inténtelo de nuevo.\"</script>"; // Si el cliente no es válido se redirige a la pagina de error.
        exit;
    }

    return ["nombre_persona" => $newName, "nacionalidad_persona" => $newNationality, "sexo_persona" => $newGender];
}


// Valida errores en la entrada
function validateErrors(&$errors, $connection)
{
// Valida que los campos no estén vacios ni repetidos
    if (!isset($_POST['name']) && empty($_POST['name'])) {
        $errors[] = "El nombre es necesario"; // Añade un error
    }

    if (!isset($_POST['nationality'])&& empty($_POST['nationality'])) {
        $errors[] = "La nacionalidad es necesaria";
    }
    if (!isset($_POST['gender'])&& empty($_POST['gender'])) {
        $errors[] = "El género es necesario";

        $query = "SELECT * FROM Personaje"; // Consulta que se quiere ejecutar en la bbdd
        $stmt = $connection->query($query); // Devuelve el resultado de la consulta
        $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Se convierte el resultado en un array asociativo.

        // Verfica si el personaje ya existe
        if (isset($_POST['name']) && isset($_POST['nationality']) && !empty($_POST['name']) && !empty($_POST['nationality']) && isset($_POST['gender']) && !empty($_POST['gender']) ) {
            foreach ($personajes as $personaje) {
                if ($personaje['nombre_persona'] == $_POST['name'] && $personaje['nacionalidad_persona'] == $_POST['nationality'] && $personaje['sexo_persona'] == $_POST['gender']) {
                    // Si existe lo da como un error
                    $errors[] = "Ya existe un personaje con el mismo nombre y nacionalidad";
                }
            }
        }
        // Retorna todos los errores
        return $errors;
    }
}

// Obtiene la filmografía de un personaje
function getFilmography($characterName, $dbConnection) {
    $query = "
    SELECT 
        Pelicula.titulo_p,  -- Aquí cambiamos 'titulo' por 'titulo_p' para que coincida con la estructura de la tabla
        Pelicula.ano_produccion,  -- También, 'año_producción' por 'ano_produccion' (sin acento)
        Trabajo.tarea 
    FROM 
        Trabajo
    JOIN 
        Personaje ON Personaje.nombre_persona = Trabajo.nombre_persona
    JOIN 
        Pelicula ON Trabajo.cip = Pelicula.cip
    WHERE 
        Personaje.nombre_persona = ?
    ";

    $stmt = $dbConnection->prepare($query);
    $stmt->execute([$characterName]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
