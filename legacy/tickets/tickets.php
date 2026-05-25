<?php require_once("../shared/header.php"); require("ticketUtils.php");
$perPage = 5; //La cantidad de resultados que quiero que se muestren a la vez
$page = isset($_GET['page']) && ($_GET['page'] >= 1 && $_GET['page'] <= $perPage) ? (int)$_GET['page'] : 1; //Obtengo la página de la url y en caso de no tenerla la inicio en 1
$offset = ($page - 1) * $perPage; //Primero resto el índice para pasarlo a las cuentas del sistema, 
//luego lo multiplico por el número de resultados que quiero y obtenemos el índice en el que empezar la nueva cuenta
$pageNumber = ceil((int) numberOfPages() / 5); //ceil redondea siempre hacia arriba
$actualProyections = getActualProjections($perPage, $offset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de entradas</title>
    <link rel="stylesheet" href="tickets.css">
</head>
<body>

    <?php if (isset($_SESSION['loged']) && $_SESSION['loged']):?>



    <div class="container-fluid mt-5">
        <div class="row text-center">
            <div class="col">
                <h1>Proyecciones activas</h1>

                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $page == 1 ? "disabled" : "";?>">
                            <a class="page-link" href="?page=<?php echo $page - 1?>">Anterior</a>
                        </li>
                       
                        <?php for ($i = 1; $i <= $pageNumber; $i++):?>

                            <li class="page-item" <?php echo $page == $i ? "active" : "";?>>
                                <a class="page-link <?php echo $page == $i ? "text-secondary" : ""?>" href="?page=<?php echo $i?>"><?php echo $i?></a>
                            </li>

                        <?php endfor;?>
                        <li class="page-item <?php echo $page == $pageNumber ? "disabled" : "";?>">
                            <a class="page-link" href="?page=<?php echo $page + 1?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>


                <table class="table table-stripped mt-3">
                    <thead>
                        <tr>
                            <th>Cine</th>
                            <th>Sala</th>
                            <th>Película</th>
                            <th>Fecha Estreno</th>
                            <th>Entradas Disponibles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($actualProyections as $projection):?>
                            <tr>
                                <td><?= $projection['cine']?></td>
                                <td><?= $projection['sala']?></td>
                                <td><?= $projection['titulo_p']?></td>
                                <td><?= $projection['fecha_estreno']?></td>
                                <td><?= $projection['aforo']?></td>
                                <td>
                                    <form action="<?php echo "../shoppingCart/shoppingCart.php"?>" method="post">
                                        <input type="text" class="d-none" name="cine" id="cine" value="<?= $projection['cine']?>">
                                        <input type="number" class="d-none" name="sala" id="sala" value="<?= $projection['sala']?>">
                                        <input type="text" class="d-none" name="cip" id="cip" value="<?= $projection['cip']?>">
                                        <input type="text" class="d-none" name="titulo_p" id="titulo_p" value="<?= $projection['titulo_p']?>">
                                        <input type="number" name="quantity" id="quantity" placeholder="Introduzca nº de entradas a comprar" required>
                                        <input type="text" class="d-none" name="fecha" id="fecha" value="<?= $projection['fecha']?>">
                                        <a href="<?php echo "../proyection/proyection.php?action=showMore&cine=$projection[cine]&sala=$projection[sala]&cip=$projection[cip]&fecha_estreno=$projection[fecha_estreno]"?>" class="btn btn-primary">Ver Más</a>
                                        <button type="submit" class="btn btn-success" min="1" max="20">Comprar</button>
                                    </form>
                                   
                                    <!--<a href="<?php echo "../shoppingCart/shoppingCart.php?proyeccion={$projection["cine"]}&cantidad={quantity}"?>" class="btn btn-success">Comprar</a>-->
                                
                                    
                                </td>
                            </tr>
                            
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php else: echo "Debes iniciar sesión"?>

    <?php endif;?>
</body>
</html>