<?php require_once("../shared/header.php"); require_once('utils.php'); $rooms = getAllMovieTheater()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sala</title>

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Salas</h1>
    </div>
    <div class="container my-3 text-center">
        <table class="table table-striped">
            <tr class="text-center">
                <th scope="col">Cine</th>
                <th scope="col">Sala</th>
                <th scope="col">Acciones 

                <?php if (isset($_SESSION['loged']) && $_SESSION['loged']) :?>
                    
                    <a href="#" class="btn btn-success">Añadir</a>

                <?php endif?>

                </th>
            </tr>
        <? 
            foreach($rooms as $room) {
                echo "<tr>";
                echo "<td> $room[cine] </td>";
                echo "<td> $room[sala] </td>";
                echo "<td>";
                echo "<a href=\"formMovieTheater.php?action=showMore&cinema=$room[cine]&room=$room[sala]\" class=\"btn btn-info m-1\">Ver más</a>";
                if (isset($_SESSION['loged']) && $_SESSION['loged']) {
                    echo "<a href=\"#\" class=\"btn btn-warning m-1\">Editar</a>";
                    echo "<a href=\"#\" class=\"btn btn-danger m-1\">Eliminar</a>";
                }
                echo "</tr>";
            }
        ?>
        </table>

    </div>
    <?php require_once("../shared/footer.php")?>
</body>
</html>