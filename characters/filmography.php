<?php
include_once '../shared/header.php'; 
include_once '../shared/Database.php';
include_once 'content/utility.php';

// Comprueba si se ha pasado un nombre de personaje
$characterName = isset($_GET['nombre_persona']) ? $_GET['nombre_persona'] : null;

if ($characterName === null) {
    echo "<p>No se ha especificado un personaje válido.</p>";
    exit();
}

$dbConnection = Database::getInstance()->getConnection(); // Se conecta a la base de datos
$filmography = getFilmography($characterName, $dbConnection);
?>

<div class="container">
    <h2>Filmografía de <?php echo htmlspecialchars($characterName); ?></h2>

    <?php if (count($filmography) > 0): ?>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Título de la Película</th>
                    <th>Año de Lanzamiento</th>
                    <th>Papel Desempeñado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmography as $film): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($film['titulo_p']); ?></td> <!-- Corregido -->
                        <td><?php echo htmlspecialchars($film['ano_produccion']); ?></td> <!-- Corregido -->
                        <td><?php echo htmlspecialchars($film['tarea']); ?></td> <!-- Corregido -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron películas para este personaje.</p>
    <?php endif; ?>
</div>

<?php include_once '../shared/footer.php'; ?>
