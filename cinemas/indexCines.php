<?php include_once "../shared/header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cines</title>
</head>

<body>
<?php 
require_once '../shared/Database.php'; 


    $conexion = Database::getInstance()->getConnection();   

    $query= "SELECT * FROM Cine";
    $call= $conexion->query($query);
    $cinemaList= $call->fetchAll(PDO::FETCH_ASSOC); 

?>


<div class='contenedor mt-5'>

    <h1 class="text-center mt-4"> Cinemas' list </h1>




    <div class="contenedor-2 text-center"> 
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th scope="col">Cinemas</th> 
                    <th scope="col">Acciones 

                        <?php if(isset($_SESSION['loged']) && $_SESSION['loged']):?>

                            <a href='./formCinema.php?action=add' class="btn btn-success text-center" >Añadir</a>

                        <?php endif;?>

                    </th>
                </tr>
            </thead>
            <?php 
        
                foreach ($cinemaList as $cinema) {
                    echo '<tr>';
                    echo "<td>$cinema[cine]</td>";
                    echo "<td class='text-center'>";
                    if(isset($_SESSION['loged']) && $_SESSION['loged']) {
                        echo "<a href='./formCinema.php?action=edit&id=$cinema[cine]' class='btn btn-warning btn-sm mr-2'>Editar</a>".
                        "<a href='./deleteCinema.php?id=$cinema[cine]' class='btn btn-danger btn-sm'>Eliminar</a></td></tr>";
                    }
                    
                }

            ?>
        </table>
    </div>
</div>

</body>
</html>