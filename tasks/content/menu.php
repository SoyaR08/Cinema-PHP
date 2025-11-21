<?php require("../shared/Database.php"); ?>

<?php

$conexion = Database::getInstance()->getConnection();
?>
<div class="contenedor-2 text-center">

    <table class="table table-center">

        <tr>

            <th>Tarea</th>
            <th>Acciones
                <?php if(isset($_SESSION['loged']) && $_SESSION['loged']):?>

                    <a href="<?php echo $url; ?>/../tasks/form.php?action=add" name="add" type="submit" class="btn btn-success mb-2">Añadir</a>

                <?php endif;?>
            </th>

        </tr>
        <?php

        $query = "SELECT * FROM Tarea";
        $stmt = $conexion->query($query);
        $tarea = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tarea as $row) {
            echo "<tr>
            <td>$row[tarea]</td>";
            echo "<td><a href='form.php?action=showMore&task=$row[tarea]&gender=$row[sexo_tarea]' class='btn btn-info btn-sm'>Info</a>";

            if (isset($_SESSION['loged']) && $_SESSION['loged']) {
                echo "<a href='form.php?action=edit&task=$row[tarea]&gender=$row[sexo_tarea]' class='btn btn-warning btn-sm'>Editar</a>
                <a href='form.php?action=delete&task=$row[tarea]&gender=$row[sexo_tarea]' class='btn btn-danger btn-sm'>Eliminar</a>";
            }
                  
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>