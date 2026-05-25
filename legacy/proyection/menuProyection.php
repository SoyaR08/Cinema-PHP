<?php require("../shared/header.php");
require("content/utilsProyection.php");
$maxProyections = 5;

$pagesNumber = ceil(getNumberOfProyections() / $maxProyections);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
elseif ($page > $pagesNumber) {
    $page = $pagesNumber;
}

$offset = ($page - 1) * $maxProyections;

$proyection = getProyections($maxProyections, $offset);

$aviablePages = 5;
$start = max(1, $page - floor($aviablePages / 2));
/**
 * $start explicación:
 * con floor lo que hago es coger el suelo de las páginas visibles (en este caso son 5) entre 2 para centrarlo,
 * luego le restamos el valor de la página actual para obtener el inicio del rango que en caso de ser negativo será 1
 */
$end = min($pagesNumber, $start + $aviablePages - 1);
/**
 * $start explicación:
 * Aquí calculamos que nº de página debería finalizar el rango al sumar el inicio con el límite asignado
 * En caso de que ese cálculo supere al número de páginas obtenido previamente se tomará este como final de rango
 * 
 */

if ($end - $start + 1 < $aviablePages) {
    $inicio = max(1, $end - $aviablePages + 1);
}

?>

<div class="container mt-5">
    <h1 class="text-center">Listado de proyecciones</h1>
    
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page == 1 ? "disabled" : "";?>">
                <a class="page-link" href="?page=<?php echo $page - 1?>">Anterior</a>
            </li>
                       
            <?php for ($i = $start; $i <= $end; $i++):?>

                <li class="page-item" <?php echo $page == $i ? "active" : "";?>>
                    <a class="page-link <?php echo $page == $i ? "text-secondary" : ""?>" href="?page=<?php echo $i?>"><?php echo $i?></a>
                </li>

            <?php endfor;?>
            <li class="page-item <?php echo $page == $pagesNumber ? "disabled" : "";?>">
                <a class="page-link" href="?page=<?php echo $page + 1?>">Siguiente</a>
            </li>
        </ul>
    </nav>

    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <table class="table table-stripped">
                <tr>
                    <th>Proyecciones</th>
                    <th>Acciones
                        <?php if(isset($_SESSION['loged']) && $_SESSION['loged']):?>
                            <a href="proyection.php?action=add" class="btn btn-success">Añadir Proyección</a>
                        <?php endif?>
                    </th>
                </tr>
                <?php

                
                foreach ($proyection as $row) {
                    echo "<tr>
                        <td>{$row['cine']}</td>
                        <td>
                            <a href='proyection.php?action=showMore&cine={$row['cine']}&sala={$row['sala']}&cip={$row['cip']}&fecha_estreno={$row['fecha_estreno']}' class='btn btn-info btn-sm'>Info</a>";
                            if (isset($_SESSION['loged']) && $_SESSION['loged']) {
                               echo  "<a href='proyection.php?action=edit&cine={$row['cine']}&sala={$row['sala']}&cip={$row['cip']}&fecha_estreno={$row['fecha_estreno']}' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='proyection.php?action=delete&cine={$row['cine']}&sala={$row['sala']}&cip={$row['cip']}&fecha_estreno={$row['fecha_estreno']}' class='btn btn-danger btn-sm'>Eliminar</a>";
                            }
                            
                        echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php require("../shared/footer.php"); ?>
