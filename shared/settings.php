<?php require_once("header.php"); require("settingUtils.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>

</head>
<body>

    <?php if (isset($_SESSION['loged']) && $_SESSION['loged']):?>

        <?php 
            if (!empty($_POST)) {
                $user = getUser($_SESSION['user']);
                if (password_verify($_POST['currentPassword'], $user['password'])) {
                    $result = updatePassword($_SESSION['user'], password_hash($_POST['newPassword'], PASSWORD_DEFAULT));
                   
                   if ($result) {
                    echo "<div class=\"alert alert-success\"><h1>Contraseña Actualizada con éxito</h1></div>";
                   }
                } else {
                    echo "<div class=\"alert alert-danger\"><h1>Contraseña Incorrecta</h1></div>";
                }

            }
        ?>

    <div class="container mt-5">

        <h1 class="text-center mb-4">Configuración de Usuario</h1>

        
        <div class="card shadow">
            <div class="card-body">

                
                <h3 class="text-center">Cambiar Contraseña</h3>
                <div id="formContainer">
                    <form class="form" id="changeForm" method="post">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña Actual</label>
                            <input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Contraseña actual">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Nueva contraseña">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirmar nueva contraseña">
                        </div>
                        <button type="submit" class="text-center btn btn-primary">Confirmar Cambios</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <?php else: echo "ajaja";?>


    <?endif;?>
    <script src="settings.js"></script>
</body>
</html>
