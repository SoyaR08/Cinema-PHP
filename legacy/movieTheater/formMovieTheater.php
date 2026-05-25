<?php require_once("../shared/header.php")?>
<?php require_once("utils.php"); 
validateValues($_GET);
$movieTheater = locateTheMovieTheater($_GET['cinema'], $_GET['room'])?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas de cine</title>
</head>
<body>

    <h1 class="text-center mt-3"><?php showTheTitle($_GET['action'])?></h1>

    <div class="container mt-2">
        <form method="post" class="form">
            <div class="row my-2">
                <label for="cine" class="form-label">Nombre del cine</label>
                <input type="text" name="cine" id="cine" class="form-control" value="<?php echo $movieTheater['cine']?>" <?php disabledOrNot($_GET['action']) ?>>
            </div>
            <div class="row my-2">
                <label for="sala" class="form-label">Nº de sala</label>
                <input type="text" name="sala" id="sala" class="form-control" value="<?php echo $movieTheater['sala']?>" <?php disabledOrNot($_GET['action']) ?>>
            </div>
            <div class="row my-2">
                <label for="aforo" class="form-label">Aforo</label>
                <input type="text" name="aforo" id="aforo" class="form-control" value="<?php echo $movieTheater['aforo']?>" <?php disabledOrNot($_GET['action']) ?>>
            </div>
        </form>
    </div>

    
    

</body>
</html>