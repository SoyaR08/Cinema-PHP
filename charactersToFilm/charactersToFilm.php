<?php require_once("../shared/header.php")?>
<?php require_once("utils.php");

$films = getAllFilms();
$characters = getAllCharacters();
$tasks = getAllTasks();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Actor a Película</title>
    <link rel="stylesheet" href="../shared/style.css">
</head>
<body>
    

    <?php 
    
        if (isset($_POST['submit'])) {
            $answer = checkNewCharacter($_POST['film'], $_POST['character'], $_POST['task']);
            
            if ($answer) {
                echo "<div class=\"alert alert-danger text-center\"> Este personaje ya está en esa película </div>";
            } else {
                addCharacterToFilm($_POST['film'], $_POST['character'], $_POST['task']);
                echo "<div class=\"alert alert-success text-center\">". 
                "Personaje Añadido con éxito".
                "</div>";
            }

        }
    
    ?>

    <div class="container mt-2 text-center">
        <h1>Asignando Actor a Película</h1>
    </div>

    <div class="container my-2">
        <form method="post" class="form text-center">
            <div class="row my-1">
            <label for="film" class="form-label">Seleccione una película</label>
            <select name="film" id="film" class="form-control">
            <?php 
                
                foreach($films as $film) {
                    echo "<option value=\"$film[cip]\">$film[titulo_p]</option>";
                }
            
            ?>
            </select>
            </div>

            <div class="row my-1">
            <label for="character" class="form-label">Seleccione un actor</label>
            <select name="character" id="character" class="form-control">
            <?php 
                
                foreach($characters as $character) {
                    echo "<option value=\"$character[nombre_persona]\">$character[nombre_persona]</option>";
                }
            
            ?>
            </select>
            </div>

            <div class="row my-1">
                <label for="task" class="form-label">Seleccione un papel</label>
                <select name="task" id="task" class="form-control">
                <?php 
                
                    foreach($tasks as $task) {
                        echo "<option value=\"$task[tarea]\">$task[tarea]</option>";
                    }
            
                ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary my-2">Enviar</button>
            
        </form>
    </div>

    <?php require_once("../shared/footer.php")?>
</body>
</html>