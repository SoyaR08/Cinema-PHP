<?php require("../shared/header.php"); 
require_once "../shared/Database.php";
$connection = Database::getInstance()->getConnection(); // Se conecta a la base de datos
?>
<div class='contenedor mt-5'>

<!-- Muestra una tabla de todos los personajes y las acciones que se pueden hacer con ellos -->
    
    <div class="contenedor-2 text-center">
        <h1>Listado de Personajes</h1>

        <table class="table table-stripped">
            <tr>
                <th>Nombre</th>
                <th>Acciones 

                    <?php if (isset($_SESSION['logued']) && $_SESSION['logued']): ?>

                    <a href="<?php echo $url; ?>/../characters/form.php?action=add" name="add" type="submit" class="btn btn-success mb-5">Añadir</a>

                    <?php endif;?>

                </th>
            </tr>

            <?php
            $query = "SELECT * FROM Personaje"; // Consulta que se quiere ejecutar en la bbdd
            $stmt = $connection->query($query); // Devuelve el resultado de la consulta
            $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Se convierte el resultado en un array asociativo.
            foreach ($personajes as $position => $personaje) : // Mostrar todos los personajes en la lista.
            ?>
                <tr>
                    <td><?= $personaje['nombre_persona'] ?></td>
                    <form>
                        <td>
                            <a href="<?php echo $url; ?>/../characters/form.php?action=showMore&name=<?= $personaje['nombre_persona'] ?>" name="showMore" type="submit" class="btn btn-info btn-sm">Ver más</a>
                            <a href="filmography.php?nombre_persona=<?php echo urlencode($personaje['nombre_persona']); ?>" class="btn btn-success">Ver Filmografía</a> <!-- Corregido aquí -->
                            <?php if (isset($_SESSION['logued']) && $_SESSION['logued']): ?>
                            <a href="<?php echo $url; ?>/../characters/form.php?action=edit&name=<?= $personaje['nombre_persona'] ?>" name="edit" type="submit" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?php echo $url; ?>/../characters/form.php?action=delete&name=<?= $personaje['nombre_persona'] ?>" name="delete" type="submit" class="btn btn-danger btn-sm">Eliminar</a>
                            <?php endif;?>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>

        </table>

    </div>
</div>
<?php require '../shared/footer.php'; ?>
