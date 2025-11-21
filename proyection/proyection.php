<?php include_once("../shared/header.php"); ?>
<?php
include_once "content/utilsProyection.php"; 
include_once "../shared/Database.php";
include_once "../cinemas/utilities.php"; 

$action = validateAction();
$proyection = [
    'cine' => $_GET['cine'] ?? null,
    'sala' => $_GET['sala'] ?? null,
    'cip' => $_GET['cip'] ?? null,
    'fecha_estreno' => $_GET['fecha_estreno'] ?? null,
    'dias_estreno' => $_GET['dias_estreno'] ?? null,
    'espectadores' => $_GET['espectadores'] ?? null,
    'recaudacion' => $_GET['recaudacion'] ?? null,
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cine = $_POST['cine'] ?? null;
    $sala = $_POST['sala'] ?? null;
    $cip = $_POST['cip'] ?? null;
    $fecha_estreno = $_POST['fecha_estreno'] ?? null;
    $dias_estreno = $_POST['dias_estreno'] ?? null;
    $espectadores = $_POST['espectadores'] ?? 0;
    $recaudacion = $_POST['recaudacion'] ?? 0;

    if ($action === 'delete') {
        deleteProyection($cine, $sala, $cip, $fecha_estreno);
        $action = 'alreadyRemoved';
    } elseif ($action === 'edit') {
        // Validaciones de campos
        if (!$cine || !$sala || !$cip || !$fecha_estreno || !$dias_estreno) {
            $errors[] = "Todos los campos obligatorios deben estar completos.";
        }
        if (!is_numeric($sala) || $sala < 0) {
            $errors[] = "La sala debe ser un valor numérico positivo.";
        }
        if (!is_numeric($dias_estreno) || $dias_estreno < 0) {
            $errors[] = "Los días de estreno deben ser un valor numérico positivo.";
        }
        if ($espectadores !== "" && (!is_numeric($espectadores) || $espectadores < 0)) {
            $errors[] = "El número de espectadores debe ser un valor numérico positivo o dejarse en blanco.";
        }
        if ($recaudacion !== "" && (!is_numeric($recaudacion) || $recaudacion < 0)) {
            $errors[] = "La recaudación debe ser un valor numérico positivo o dejarse en blanco.";
        }

        if (empty($errors)) {
            //editProyection($proyection);
            $action = 'alreadyEdited';
        }
    } elseif ($action === 'add') {
        if (!$cine || !$sala || !$cip || !$fecha_estreno || !$dias_estreno) {
            $errors[] = "Todos los campos obligatorios deben estar completos.";
        }
        if (!is_numeric($sala) || $sala < 0) {
            $errors[] = "La sala debe ser un valor numérico positivo.";
        }
        if (!is_numeric($dias_estreno) || $dias_estreno < 0) {
            $errors[] = "Los días de estreno deben ser un valor numérico positivo.";
        }
        if ($espectadores !== "" && (!is_numeric($espectadores) || $espectadores < 0)) {
            $errors[] = "El número de espectadores debe ser un valor numérico positivo o dejarse en blanco.";
        }
        if ($recaudacion !== "" && (!is_numeric($recaudacion) || $recaudacion < 0)) {
            $errors[] = "La recaudación debe ser un valor numérico positivo o dejarse en blanco.";
        }

        if (empty($errors)) {
            $newProjection = [
                "cine" => $cine,
                "sala" => $sala,
                "cip" => $cip,
                "fecha_estreno" => $fecha_estreno,
                "dias_estreno" => $dias_estreno,
                "espectadores" => $espectadores,
                "recaudacion" => $recaudacion
            ];
            addProjection($newProjection);
            $action = 'alreadyAdded';
        }
    }
} else {
    $info = ($proyection['cine'] && $proyection['sala'] && $proyection['cip'] && $proyection['fecha_estreno']) 
        ? viewProyection($proyection['cine'], $proyection['sala'], $proyection['cip'], $proyection['fecha_estreno']) 
        : [];
}

displayErrors($errors);
?>


<main class="container">
    <div class="container mt-5">
        <?php showTitleByAction($action); ?>
        <form method="POST">
    <!-- Cine -->
    <div class="form-group row">
        <label for="cine" class="col-4 col-form-label">Cine</label>
        <div class="col-8">
            <input id="cine" name="cine" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['cine'] ?? ''); ?>" required <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- Sala -->
    <div class="form-group row">
        <label for="sala" class="col-4 col-form-label">Sala</label>
        <div class="col-8">
            <input id="sala" name="sala" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['sala'] ?? ''); ?>" required <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- CIP (Código de Identificación de la Película) -->
    <div class="form-group row">
        <label for="cip" class="col-4 col-form-label">Película (CIP)</label>
        <div class="col-8">
            <input id="cip" name="cip" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['cip'] ?? ''); ?>" required <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- Fecha de estreno -->
    <div class="form-group row">
        <label for="fecha_estreno" class="col-4 col-form-label">Fecha de estreno</label>
        <div class="col-8">
            <input id="fecha_estreno" name="fecha_estreno" type="date" class="form-control" 
                   value="<?php echo htmlspecialchars($info['fecha_estreno'] ?? ''); ?>" required <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- Días de estreno -->
    <div class="form-group row">
        <label for="dias_estreno" class="col-4 col-form-label">Días de estreno</label>
        <div class="col-8">
            <input id="dias_estreno" name="dias_estreno" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['dias_estreno'] ?? ''); ?>" required <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- Espectadores (opcional) -->
    <div class="form-group row">
        <label for="espectadores" class="col-4 col-form-label">Espectadores (opcional)</label>
        <div class="col-8">
            <input id="espectadores" name="espectadores" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['espectadores'] ?? ''); ?>" <?php isDisabled($action); ?>>
        </div>
    </div>

    <!-- Recaudación (opcional) -->
    <div class="form-group row">
        <label for="recaudacion" class="col-4 col-form-label">Recaudación (opcional)</label>
        <div class="col-8">
            <input id="recaudacion" name="recaudacion" type="text" class="form-control" 
                   value="<?php echo htmlspecialchars($info['recaudacion'] ?? ''); ?>" <?php isDisabled($action); ?>>
        </div>
    </div>

    <?php showButtonByAction($action); ?>
</form>

    </div>

<?php include '../shared/footer.php' ?>
