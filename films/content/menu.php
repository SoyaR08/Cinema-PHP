
    <div class="form-group form-art addFilmButton">

    <form method="post">
        <div class="form-art">
    </form>
        </div>
    </div>

<div class="contenedor-2">

<table class="table table-stripped">

    <tr>

    <!-- <th>Cip</th> -->
    <th>Título película</th>
    <!-- <th>Año de producción</th>
    <th>Título secundario</th>
    <th>Nacionalidad</th>
    <th>Presupuesto</th>
    <th>Duración</th> -->
    <th>Acciones </th>
        <?php if (isset($_SESSION['loged']) && $_SESSION['loged']) :?>
                    
            <a href='./form.php?accion=add' class="btn btn-success text-center" >Añadir</a>

        <?php endif?>
    </tr>

<?php
    require_once("../shared/Database.php");
    $conexion= Database::getInstance()->getConnection();

    $query = "SELECT * FROM Pelicula";
    $stmt = $conexion->query($query);
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($films as $row) {
        echo "<tr>
        <td>$row[titulo_p]</td>
        <td>";
        echo "<a href='form.php?accion=info&id=$row[cip]' class='btn btn-info btn-sm'>Info</a>";
        if (isset($_SESSION['loged']) && $_SESSION['loged']) { 

            
            echo "<a href='form.php?accion=editar&id=$row[cip]' class='btn btn-warning btn-sm'>Editar</a>
            <a href='form.php?accion=eliminar&id=$row[cip]' class='btn btn-danger btn-sm'>Eliminar</a>";
            
        }
        echo "</td>";
    }
?>

</table>

</div>