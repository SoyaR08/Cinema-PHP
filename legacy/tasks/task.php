<?php include "../shared/header.php";

// if (isset($_POST['reset'])) {
//     require "../componentes/bd_save.php";
//     echo "<script>window.location.href = '/ejercicioClientes/Clientes/clientes.php';</script>";
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    
<?php
    
    echo "<div class='contenedor mt-5 text-center'>";
    
    echo "<h1>Listado de Tareas</h1>";

    include "../tasks/content/menu.php";

    echo "</div>";
    
    include "../shared/footer.php";
    ?>
</body>
</html>