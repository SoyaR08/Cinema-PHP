<?php include "../shared/header.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peliculas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../shared/style.css">
</head>
<body>
    
    
<?php
    
    require "../shared/Database.php";
    require_once "content/utility.php";
    
    $conexion= Database::getInstance()->getConnection();
    $query = "SELECT * FROM Pelicula";
    $stmt = $conexion->query($query);
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Compruebo que me ha pasado ID y tiene valor numérico
    //Si hay algun error nos dirige a página de error
    $accion = validateAction();
    if ($accion != 'add') $id = validateID();

    $resultMessage = "";
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if ($accion == 'eliminar') {
        echo "<script>window.location.href = './form.php?accion=deleteConfirm&id=$id';</script>";
        exit();

      } else if ($accion == 'deleteConfirm') {
        deleteFilm($conexion, $id);

        echo "<script>window.location.href = './films.php';</script>";
        exit();

      } else if ($accion == 'editar') {

        $errors = validateErrors ($errors, $_POST, $films, $accion, $id);

        if (!empty($errors)) {
          foreach ($errors as $error) {
            $resultMessage .= "<div class='alert alert-danger'>$error</div>";
          }
        } else {
          $_SESSION['editedData'] = $_POST;

          echo "<script>window.location.href = './form.php?accion=editConfirm&id=$id';</script>";
          exit();
          
        }

      } else if ($accion == 'editConfirm') {
        $film = $_SESSION['editedData'];

        $film = editFilm($conexion, $films, $id, $film);
        unset($_SESSION['editedData']);
        // echo "<script>window.location.href = './form.php?accion=editar&id=$id';</script>";
        echo "<script>window.location.href = './films.php';</script>";
        exit();

      } else if ($accion == 'add') {
        $errors = validateErrors ($errors, $_POST, $films, $accion);

        if (!empty($errors)) {
          foreach ($errors as $error) {
            $resultMessage .= "<div class='alert alert-danger'>$error</div>";
          }
        } else {
          $film = addFilm($conexion, $_POST);
  
          echo "<script>window.location.href = './films.php';</script>";
          exit();

        }

      }

    } 

    if (!isset($film) && $accion != 'add') $film = findFilm($conexion, $films, $id);

     else if ($accion == 'add') $film = [
            'cip' => '',
            'titulo_p' => '',
            'ano_produccion' => '',
            'titulo_s' => '',
            'nacionalidad' => '',
            'presupuesto' => '',
            'duracion' => ''
    ];

    if (isset($_SESSION['editedData'])) $film = $_SESSION['editedData'];

    echo "<div class='contenedor mt-5'>";
        
    if ($film != null) {
        $msg = showTitle($accion);
        
        echo "<h2>$msg $film[titulo_p]</h2>";

    ?>


<form method="post">
  <div class="form-group row">
    <label for="cip" class="col-4 col-form-label">CIP</label> 
    <div class="col-8">
        <input name="cip" type="text" value="<?php echo $film['cip']; ?>" required class="form-control" <?php if ($_GET['accion']!='add')echo'readonly';?> >
    </div>
  </div>
  <div class="form-group row">
    <label for="titulo_p" class="col-4 col-form-label">Título</label> 
    <div class="col-8">
        <input id="titulo_p" name="titulo_p" type="text" required value="<?php echo $film['titulo_p']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <label for="ano_produccion" class="col-4 col-form-label">Año de producción</label> 
    <div class="col-8">
        <input id="ano_produccion" name="ano_produccion" type="number" required value="<?php echo $film['ano_produccion']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <label for="titulo_s" class="col-4 col-form-label">Título secundario</label> 
    <div class="col-8">
      <input id="titulo_s" name="titulo_s" type="text" value="<?php echo $film['titulo_s']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <label for="nacionalidad" class="col-4 col-form-label">Nacionalidad</label> 
    <div class="col-8">
      <input id="nacionalidad" name="nacionalidad" type="text" value="<?php echo $film['nacionalidad']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <label for="presupuesto" class="col-4 col-form-label">Presupuesto</label> 
    <div class="col-8">
        <input id="presupuesto" name="presupuesto" type="number" value="<?php echo $film['presupuesto']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <label for="duracion" class="col-4 col-form-label">Duración</label> 
    <div class="col-8">
        <input id="duracion" name="duracion" type="number" value="<?php echo $film['duracion']; ?>" class="form-control" <?php if ($_GET['accion']!='editar' && $_GET['accion']!='add')echo'readonly';?>>
    </div>
  </div>
  <div class="form-group row">
    <div class="offset-4 col-8">
        <a href='./films.php' class='btn btn-info btn-sm'>Volver</a>

        <?php if ($_GET['accion'] == 'info') echo "<button type='submit' class='btn btn-primary btn-sm'>Ver Reparto</button>"; ?>
        <?php if ($_GET['accion'] == 'editar') echo "<button type='submit' class='btn btn-success btn-sm'>Guardar</button>"; ?>
        <?php if ($_GET['accion'] == 'editConfirm') echo "<button type='submit' class='btnEditConfirm btn btn-success btn-sm'>Confirmar</button>"; ?>
        <?php if ($_GET['accion'] == 'eliminar') echo "<button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>"; ?>
        <?php if ($_GET['accion'] == 'deleteConfirm') echo "<button type='submit' class='btnEditDelete btn btn-danger btn-sm'>Confirmar</button>"; ?>
        <?php if ($_GET['accion'] == 'add') echo "<button type='submit' class='btn btn-success btn-sm'>Añadir</button>"; ?>

    </div>
  </div>
</form>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $accion == 'info')  {
      mostrarReparto($conexion, $id);
    }


    } else {
      echo "<script>window.location.href = '../shared/error.php?msg=No existe ninguna película con ese ID';</script>";
      exit();
    }
  
    echo $resultMessage;
  
    echo "</div>";
    
    include "../shared/footer.php";
?>

</body>
</html>