<?php
require_once "./content/utility.php";
require "../shared/header.php";
require_once "../shared/Database.php";

//  Conectamos con la base de datos
$connection = Database::getInstance()->getConnection();

// Validamos que nos ha pasado una acción y que esta es válida
$action = validateAction($_GET["action"]);

// En caso de que la acción no sea añadir buscamos el personaje
if (! ($action == "add")) {
    $personaje = validateName($connection, $_GET["name"]);
    // Si no nos devuelve ningún personaje significa que no existe en nuestra base de datos y lo llevamos a la página de error
    if (!$personaje) {
        echo '<script>window.location.href = "' . $url . '/../shared/error.php?msg=El personaje seleccionado no existe, por favor inténtelo de nuevo."</script>';
        exit;
    }
    // Si la acción es añadir haremos un objeto vacío para no mostrar datos
} else {
    $personaje =
        [
            'nombre_persona' => '',
            'nacionalidad_persona' => '',
            'sexo_persona' => ''
        ];
}

$name = $personaje['nombre_persona']; // Obtenemos el nombre del personaje para usarlo más adelante

// Comprobamos que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si la acción es eliminar
    if ($action == 'delete') {
        echo "<script>window.location.href = './form.php?action=alreadyDeleted&name=$name';</script>";
        exit();
        // Si la acción es confirmar la eliminación
    } else if ($action == 'alreadyDeleted') {
        deletepersonaje($connection, $name);
        echo "<script>window.location.href = './characters.php';</script>";
        exit();
        // Si queremos editar un personaje
    } elseif ($action == "edit") {
        $errors = []; // Inicializa el array de errores
        $errors = validateErrors($errors, $connection); // Valida los errores
        if (!empty($errors)) {
            // Si hay errores los muestra
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // Edita el personaje en la base de datos
            $personaje = editpersonaje($connection, $personaje['nombre_persona'], $_POST["nationality"], $_POST["gender"]);
            // Redirige tras la edición
            echo "<script>window.location.href = './form.php?action=alreadyEdited&name=$name';</script>";
            exit();
        }
    } elseif ($action == "add") {
        // Añade un nuevo personaje
        $personaje = addpersonaje($connection, $_POST["name"], $_POST["nationality"], $_POST["gender"]);
        $action = "alreadyAdded";
    }
}
?>


<main class="container-fluid">
    <!-- Formulario en el que se mostraran y rellenaran los datos los personajes -->
    <div class="container mt-5">
        <?php showTitle($action); ?>
        <form method="post" class="m-3">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $personaje["nombre_persona"] ?>" <?php readOnlyName($action); ?> required>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nacionalidad:</label>
                <input type="text" class="form-control" name="nationality" id="nationality" value="<?= $personaje["nacionalidad_persona"] ?>" <?php readOnlyOrNot($action); ?> required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Género:</label>
                <select class="form-select" id="gender" name="gender" <?php readOnlyOrNot($action); ?> required>
                    <option></option>
                    <option value="H" <?php ($personaje["sexo_persona"] == "H") ? print "selected" : ""; ?>>Hombre</option>
                    <option value="M" <?php ($personaje["sexo_persona"] == "M") ? print "selected" : ""; ?>>Mujer</option>
                    <option value="O" <?php ($personaje["sexo_persona"] == "O") ? print "selected" : ""; ?>>Otros</option>
                </select>
            </div>
            <!-- Muestra el botón adecuado según la acción -->
            <?php showButton($action); ?>
        </form>

    </div>

</main>

<?php
require "../shared/footer.php"; ?>