<?php session_start(); $url = str_replace( $_SERVER['DOCUMENT_ROOT'], "", __DIR__); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    
    
    <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">Rafa's Cinema</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <img class="navbar-toggler-icon" src="<?php echo $url . "/img/menu_24dp_F8F9FA_FILL0_wght400_GRAD0_opsz24.svg"?>" alt="menu navbar">
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a href="<?php echo $url . "/../index.php";?>" class="mx-2 my-2 text-light">Inicio</a>
                <a href="<?php echo $url . "/../films/films.php";?>" class="mx-2 my-2 text-light">Peliculas</a>
                <a href="<?php echo $url . "/../tasks/task.php";?>" class="mx-2 my-2 text-light">Tareas</a>
                <a href="<?php echo $url . "/../characters/characters.php";?>" class="mx-2 my-2 text-light">Personajes</a>
                <a href="<?php echo $url . "/../cinemas/indexCines.php";?>" class="mx-2 my-2 text-light">Cines</a>
                <a href="<?php echo $url . "/../proyection/menuProyection.php";?>" class="mx-2 my-2 text-light">Proyecciones</a>
                <a href="<?php echo $url . "/../movieTheater/movieTheater.php";?>" class="mx-2 my-2 text-light">Salas</a>
                <a href="<?php echo $url . "/../tickets/tickets.php";?>" class="mx-2 my-2 text-light">Compra tus Entradas</a>

                <?php if(!isset($_SESSION['loged']) || !$_SESSION['loged']):?>
                
                <a href="<?php echo $url . "/login.php";?>" class="btn btn-primary" class="mx-4">Inicia Sesión</a>
                <a href="<?php echo $url . "/register.php";?>" class="btn btn-warning" class="mx-4">Registrate</a>

                <?php else:?>
                    <a href="<?php echo $url . "/../charactersToFilm/charactersToFilm.php";?>" class="mx-2 my-2 text-light">Asignar Actor a Película</a>
                    <div class="row mx-2">
                        <p class="text-primary m-2"><?php echo $_SESSION['user']?></p> <a href="<?php echo $url . "/settings.php";?>" class="my-2"><img src="<?php echo $url . "/img/manage_accounts_24dp_FFC107_FILL0_wght400_GRAD0_opsz24.svg"?>" class="me-2"></a>
                        <a href="<?php echo $url . "/logout.php";?>" class="mt-2"><img src="<?php echo $url . "/img/logout_24dp_FFC107_FILL0_wght400_GRAD0_opsz24.svg"?>"></a>
                        <a href="<?php echo $url . "/../shoppingCart/shoppingCart.php";?>" class="mt-2"><img src="<?php echo $url . "/img/shopping_cart_24dp_FFC107_FILL0_wght400_GRAD0_opsz24.svg"?>"></a>
                    </div>

                    <?php if(isset($_SESSION['userrole']) && $_SESSION['userrole'] === "ADMIN"):?>

                    <a href="<?php echo $url . "/admin.php";?>" class="btn btn-danger" class="mx-4">Admin Section</a>

                    <?php endif;?>

                <?php endif;?>

            </div>
        </div>
    </div>
    </nav>
</body>