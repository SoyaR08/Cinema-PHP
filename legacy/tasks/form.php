<?php require "../shared/header.php";
require_once "./content/utility.php";
require_once "../shared/Database.php";
$connection = Database::getInstance()->getConnection();




$action = validateAction($_GET["action"]);

if (! ($action == "add")) {
    $task = validateTask($connection, $_GET["task"]);
    if (!$task) {
        echo '<script>window.location.href = "' . $url . '/../shared/error.php?msg=La tarea seleccionada no existe, por favor inténtelo de nuevo."</script>';
        exit;
    }
} else {
    $task =
        [
            'tarea' => '',
            'sexo_tarea' => '',
            'salario_base' => ''
        ];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'delete') {
        $action = "alreadyDeleted";
        $task = deletetask($connection, $task['tarea']);
    } elseif ($action == "edit") {
        $task = editTask($connection, $_POST['task'], $_POST["gender"], $_POST["salary"]);
        $action = "alreadyEdited";
    } elseif ($action == "add") {
        $task = addtask($connection, $_POST["task"], $_POST["gender"], $_POST["salary"]);
        $action = "alreadyAdded";
    }
}
?>
<main class="container">
    <div class="container mt-5">
        <?php showTitle($action); ?>
        <form method="post" class="m-3">
            <div class="mb-3">
                <label for="task" class="form-label">Tarea:</label>
                <input type="text" class="form-control" name="task" id="task" value="<?= $task["tarea"] ?>" <?= $action == 'edit' || $action == 'delete' || $action == 'alreadyDeleted' ? 'readonly' : '' ?> required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Género:</label>
                <select class="form-select" id="gender" name="gender" <?php readOnlyOrNot($action); ?> required>
                    <option></option>
                    <option value="H" <?php ($task["sexo_tarea"] == "H") ? print "selected" : ""; ?>>Hombre</option>
                    <option value="M" <?php ($task["sexo_tarea"] == "M") ? print "selected" : ""; ?>>Mujer</option>
                    <option value="O" <?php ($task["sexo_tarea"] == "O") ? print "selected" : ""; ?>>Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salario:</label>
                <input type="text" class="form-control" name="salary" id="salary" value="<?= $task["salario_base"] ?>" <?php readOnlyOrNot($action); ?> required>
            </div>
            

            <?php showButton($action); ?>
        </form>

    </div>

</main>

<?php
require "../shared/footer.php"; ?>