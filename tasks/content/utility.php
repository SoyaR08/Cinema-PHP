<?php


function validateTask($connection, $task)
{
    $query = "SELECT * FROM Tarea WHERE tarea = :task";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':task', $task, PDO::PARAM_STR);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if($task === false){
        return null;
    }
    return $task;
}


function validateAction($action)
{
    if (isset($action) && (($action == 'showMore') || ($action == 'delete') || ($action == 'edit')) || ($action == 'add')) {
        return htmlspecialchars($action);
    } else {
        echo "<script>window.location.href = \"../shared/error.php?msg=La acción no es válida\";</script>";
        exit();
    }
}


function showTitle($action)
{
    switch ($action) {
        case 'showMore':
            echo '<h1 class=\"mb-4\">Mostrando Tarea</h1>';
            break;
        case 'delete':
            echo '<h1 class=\"mb-4\">Borrando Tarea</h1>';
            break;
        case 'alreadyDeleted':
            echo '<h1 class=\"mb-4\">Tarea borrada</h1>';
            break;
        case 'alreadyEdited':
            echo '<h1 class=\"mb-4\">Tarea editada</h1>';
            break;
        case 'edit':
            echo '<h1 class=\"mb-4\">Editando Tarea</h1>';
            break;
        case 'alreadyAdded':
            echo '<h1 class=\"mb-4\">Tarea añadida</h1>';
            break;
        case 'add':
            echo '<h1 class=\"mb-4\">Añadir Tarea</h1>';
            break;
    }
}


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

function showButton($action)
{

    switch ($action) {
        case 'showMore':
            echo "<a href=\"./task.php\" class=\"btn btn-outline-success\">Volver</a>";
            break;
        case 'alreadyDeleted':
            echo "<a href=\"./task.php\" class=\"btn btn-outline-success\">La tarea ha sido eliminada</a>";
            break;

        case 'delete':
            echo '<input type="submit" class="btn btn-outline-success" value="Eliminar">';
            break;

        case 'edit':
            echo '<input type="submit" class="btn btn-outline-success" value="Guardar cambios">';
            break;
        case 'alreadyEdited':
            echo "<a href=\"./task.php\" class=\"btn btn-outline-success\">La tarea ha sido editada</a>";
            break;
        case 'add':
            echo '<input type="submit" class="btn btn-outline-success" value="Añadir tarea">';
            break;
        case 'alreadyAdded':
            echo "<a href=\"./task.php\" class=\"btn btn-outline-success\">La tarea ha sido añadida</a>";
            break;
    }
}


function deletetask($connection, $task)
{
    // Consulta SQL para eliminar un cliente con un ID específico
    $taskData = validateTask($connection, $task);
    $query = "DELETE FROM Tarea WHERE tarea = :task";
    $stmt = $connection->prepare($query);
    // Asignar el valor a la consulta
    $stmt->bindParam(':task', $taskData['tarea'], PDO::PARAM_STR);
    // Ejecutar la consulta
    $stmt->execute();
    // Comprobar si la eliminación fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=La tarea no existe.\"</script>"; // Si el cliente no es válido se redirige a la pagina de error.
        exit;
    }

    return $taskData;
}


function editTask($connection, $actualtask, $newGender, $base_salary)
{
    if ($base_salary < 0 || !preg_match('/^\d+(\.\d{1,2})?$/', $base_salary)) {
        echo "<script>window.location.href = \"../shared/error.php?msg=El salario debe ser un número mayor o igual a 0 y con un máximo de 2 decimales.\"</script>";
        exit;
    }
    // Consulta SQL para actualizar el cliente con un ID específico
    $query = "UPDATE Tarea SET sexo_tarea = :newGender, salario_base = :base_salary WHERE tarea = :actualTask";
    $stmt = $connection->prepare($query);
    // Asignar los valores a la consulta
    $stmt->bindParam(':actualTask', $actualtask, PDO::PARAM_STR);
    $stmt->bindParam(':newGender', $newGender, PDO::PARAM_STR);
    $stmt->bindParam(':base_salary', $base_salary, PDO::PARAM_STR);
    

    // Ejecutar la consulta
    $stmt->execute();
    // Comprobar si la actualización fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Ocurrió un fallo al intentar editar la tarea, por favor inténtelo de nuevo.\"</script>"; // Si el cliente no es válido se redirige a la pagina de error.
        exit;
    }

    return ["tarea" => $actualtask, "sexo_tarea" => $newGender, "salario_base" => $base_salary];
}

function addtask($connection, $newTask, $newGender, $newSalary)
{
    if(!isset($connection) && !isset($newTask) && !isset($newGender) && !isset($newSalary) && empty($connection) && empty($newTask) && empty($newGender) && empty($newSalary)){
        echo "<script>window.location.href = \"../shared/error.php?msg=Todos los campos son obligatorios para crear una tarea\"</script>"; 
        exit;
    }

    if ($newSalary < 0 || !preg_match('/^\d+(\.\d{1,2})?$/', $newSalary)) {
        echo "<script>window.location.href = \"../shared/error.php?msg=El salario debe ser un número mayor o igual a 0 y con un máximo de 2 decimales.\"</script>";
        exit;
    }

    $existe = validateTask($connection,$newTask);
    if ($existe){
        echo "<script>window.location.href = \"../shared/error.php?msg=Ya existe una tarea con este nombre.\"</script>"; 
        exit;
    }
    // Consulta SQL para insertar un nuevo cliente
    $query = "INSERT INTO Tarea (tarea, sexo_tarea, salario_base) VALUES (:task, :gender, :salary)";
    $stmt = $connection->prepare($query);
    // Asignar los valores a la consulta
    $stmt->bindParam(':task', $newTask);
    $stmt->bindParam(':gender', $newGender);
    $stmt->bindParam(':salary', $newSalary, PDO::PARAM_STR);
    // Ejecutar la consulta
    $stmt->execute();

    // Comprobar si la actualización fue exitosa
    if ($stmt->rowCount() <= 0) {
        echo "<script>window.location.href = \"../shared/error.php?msg=Ocurrió un fallo al intentar crear una tarea, por favor inténtelo de nuevo.\"</script>"; // Si el cliente no es válido se redirige a la pagina de error.
        exit;
    }

    return ["tarea" => $newTask, "sexo_tarea" => $newGender, "salario_base" => $newSalary];

}
