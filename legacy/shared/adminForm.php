<?php require_once("header.php"); require("adminUtils.php");


    if (!empty($_GET) && isset($_GET['action']) && !empty($_GET['action']) 
    && ($_GET['action'] == "role" || $_GET['action'] == "password") && isset($_GET['user']) && !empty($_GET['user']) 
    && searchUser($_GET['user'])) {

        $valid = true;
    } else {
        $valid = false;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>

    <?php if ($valid):?> 

    <div class="container mt-5">
        <h1 class="text-center"><?php echo showTheTitle($_GET['action'])?></h1>

        <?php if($_GET['action'] == "role"): ?>

            <?php 
                
                if(!empty($_POST)) {
                    changeRole($_POST['user'], $_POST['role']);
                    echo "<div class=\"alert alert-success\"><h1>Rol Actualizado con éxito</h1></div>";
                }    
                
                
            ?>

            <div class="mt-3" id="formContainer">
                <form class="form" id="role" method="post">
                    <label for="user" class="form-label">Usuario: </label>
                    <input type="text" class="form-control mb-3" name="user" id="user" readonly value="<?php echo $_GET['user']?>">
                    <label for="role" class="form-label">Rol: </label>
                    <select name="role" id="role" class="form-control mb-3">
                        <option value="ADMIN">administrador</option>
                        <option value="USER" selected>usuario regular</option>
                    </select>
                    <button type="submit" class="btn btn-primary text-center">Enviar</button>
                </form>
            </div>


        <?php else :?>

            <?php 
                if (!empty($_POST)) {
                    $user = searchUser($_SESSION['user']);
                    if (password_verify($_POST['currentPassword'], $user['password'])) {
                        $result = adminupdatePassword($_SESSION['user'], password_hash($_POST['newPassword'], PASSWORD_DEFAULT));
                    
                    if ($result) {
                        echo "<div class=\"alert alert-success\"><h1>Contraseña Actualizada con éxito</h1></div>";
                    }
                    } else {
                        echo "<div class=\"alert alert-danger\"><h1>Contraseña Incorrecta</h1></div>";
                    }

                }
            ?>

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
                        <button type="submit" class="text-center btn btn-primary">Enviar</button>
                    </form>
            </div>

        <?php endif;?>

    </div>


    <?else : echo "Algo salió mal"?>

    <?endif;?>
    <script src="settings.js"></script>
</body>
</html>