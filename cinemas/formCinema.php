<?php include "../shared/header.php";
require_once 'utilities.php'; 
require_once '../shared/Database.php'; 

?>
   

<body>
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : 'default';
    $cinema = isset($_POST['cinema']) ? $_POST : [];
    
    //Crear la conexión a la base de datos
    $pdo = Database::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cinemaName= isset($_POST['cinema']) ? trim($_POST['cinema']) : '';
        $city= isset($_POST['ciudad_cine']) ? trim($_POST['ciudad_cine']) : '';
        $address= isset($_POST['direccion_cine']) ? trim($_POST['direccion_cine']) : '';
        $age= isset($_POST['antiguedad']) ? trim($_POST['antiguedad']) : '';
    
        $errors = [];
    
        //Validación de campos
        if (empty($cinemaName) && $action !=='edit') {
            $errors[] = "El nombre del cine es obligatorio.";
        }
        if (empty($city)) {
            $errors[]= "La ciudad es obligatoria.";
        }
        if (!empty($address)) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Cine WHERE direccion_cine = :direccion");
            $stmt->bindParam(':direccion', $address);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                $errors[] = "Ya existe un cine en esta dirección.";
            }
        }
        if (!is_numeric($age) || $age < 0) {
            $errors[] = "La antigüedad debe ser un número positivo.";
        }
    
        if (!empty($errors)) {
            echo "<div class='alert alert-danger'>" . implode("<br>", $errors) . "</div>";
        } else {
            switch ($action) {
                case 'add':
                    echo addCinema($cinemaName, $city, $address, $age);
                    echo "<div class='mt-3'><a href='indexCines.php' class='btn btn-primary'>Volver a la lista</a></div>";
                    break;
                case 'edit':
                    echo updateCinema($_GET['id'], $city, $address, $age);
                    echo "<div class='mt-3'><a href='indexCines.php' class='btn btn-primary'>Volver a la lista</a></div>";
                    break;
                case 'delete':
                    echo deleteCinema($cinemaName);
                    echo "<div class='mt-3'><a href='indexCines.php' class='btn btn-primary'>Volver a la lista</a></div>";
                    break;
                default:
                    return "<div class='alert alert-danger'>Acción no válida.</div>";
            }
           
    }
}
    ?>
    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cine</title>
</head>
<body>
    <div class="container px-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 rounded-3 shadow-lg">
                    <div class="card-body p-4">
                        <h2><?php showTitle($action); ?></h2>
                        <form class="form" method="POST">
                            <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
                            <div>
                                <label for="name">Nombre</label>
                                <input type="text" id="name" class="form-control mb-3" name="cinema" 
                                       value="<?php echo htmlspecialchars(isset($cinema['cinema']) ? $cinema['cinema'] : ''); ?>" 
                                       <?php disabledOrNot($action, true); ?>>
                            </div>
                            <div>
                                <label for="city">Ciudad</label>
                                <input type="text" id="city" class="form-control mb-3" name="ciudad_cine" 
                                       value="<?php echo htmlspecialchars(isset($cinema['ciudad_cine']) ? $cinema['ciudad_cine'] : ''); ?>" 
                                       <?php disabledOrNot($action, false); ?>>
                            </div>
                            <div>
                                <label for="address">Dirección</label>
                                <input type="text" id="address" class="form-control mb-3" name="direccion_cine" 
                                       value="<?php echo htmlspecialchars(isset($cinema['direccion_cine']) ? $cinema['direccion_cine'] : ''); ?>" 
                                       <?php disabledOrNot($action, false); ?>>
                            </div>
                            <div>
                                <label for="age">Antigüedad</label>
                                <input type="text" id="age" class="form-control mb-3" name="antiguedad" 
                                       value="<?php echo htmlspecialchars(isset($cinema['antiguedad']) ? $cinema['antiguedad'] : ''); ?>" 
                                       <?php disabledOrNot($action, false); ?>>
                            </div>
                            <?php submitButton($action); ?>
                            <a href="indexCines.php" class='btn btn-info'>Volver</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>