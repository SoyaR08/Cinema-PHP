<?php include "../shared/header.php";
    unset($_SESSION['editedData']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peliculas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
    
    
<?php
    
    
    echo "<div class='contenedor mt-5 text-center'>";
    
    echo "<h1>Listado de Peliculas</h1>";
    
    include "content/menu.php";

    echo "</div>";
    
    include "../shared/footer.php";
    ?>

</body>
</html>