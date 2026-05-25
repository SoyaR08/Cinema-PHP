<?php
include_once "../shared/header.php"; 
require_once '../shared/Database.php'; 
require_once 'utilities.php'; 

if (isset($_GET['id'])) {
    $cinemaName= $_GET['id'];

    $cinema=getCinema($cinemaName);

    if ($_SERVER['REQUEST_METHOD']== 'POST' && isset($_POST['confirm'])) {
        if (deleteCinema($cinemaName)) {
            echo "<div class='alert alert-success'>Cine eliminado exitosamente.</div>";
            echo "<div class='mt-3'><a href='indexCines.php' class='btn btn-primary'>Volver a la lista</a></div>";
            exit; 
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el cine.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Eliminación de Cine</title>
</head>
<body>
<div class="container px-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 rounded-3 shadow-lg">
                    <div class="card-body p-4">
                        <h3>¿Estás seguro de que deseas eliminar el cine: <?php echo htmlspecialchars($cinema['cine']); ?>?</h3>
                        <form method='POST'>
                            <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
                            <div>
                                <label for="name">Nombre</label>
                                <input type="text" id="name" class="form-control mb-3" name="cinema" value="<?php echo htmlspecialchars($cinema['cine']); ?>" readonly>
                            </div>
                            <div>
                                <label for="city">Ciudad</label>
                                <input type="text" id="city" class="form-control mb-3" name="ciudad_cine" value="<?php echo htmlspecialchars($cinema['ciudad_cine']); ?>" readonly>
                            </div>
                            <div>
                                <label for="address">Dirección</label>
                                <input type="text" id="address" class="form-control mb-3" name="direccion_cine" value="<?php echo htmlspecialchars($cinema['direccion_cine']); ?>" readonly>
                            </div>
                            <div>
                                <label for="age">Antigüedad</label>
                                <input type="text" id="age" class="form-control mb-3" name="antiguedad" value="<?php echo htmlspecialchars($cinema['antiguedad']); ?>" readonly>
                            </div>
                            <input type='hidden' name='confirm' value='1'>
                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                            <a href='indexCines.php' class='btn btn-outline-secondary'>Cancelar</a>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
