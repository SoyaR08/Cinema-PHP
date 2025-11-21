<?php require_once("header.php")?>
<?php require("utils/loginregisterUtils.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
</head>
<body>

    <?php 
    
        if (!empty($_POST)) {
            $valid = signIn($_POST['username'], $_POST['password']);

            if ($valid) {
                echo "<div class=\"alert alert-success text-center\"><h1>Usuario Añadido Correctamente</h1></div>";
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['loged'] = true;
            }

        }
    
    
    ?>

    <div class="container my-3 text-center"><h1>Regístrate</h1></div>

    <div class="container mt-4 text-center border border-primary p-3" id="formContainer">
        <form method="post" class="form" id="register">
            <div class="row mb-2 mx-2">
                <label for="username" class="form-label">Nombre de usuario:</label>
                <input type="text" name="username" id="username" class="form-control" >
            </div>
            <div class="row mb-2 mx-2">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" >
            </div>

            <div class="row mb-2 mx-2">
                <label for="password" class="form-label">Vuelve a introducir tu contraseña:</label>
                <input type="password" name="Newpassword" id="Newpassword" class="form-control" >
            </div>

            <button type="submit" name="submit" class="btn btn-success mt-2">Registrarse</button>

        </form>
    </div>

    <?php require_once("footer.php")?>
    <script src="register2.js"></script>
</body>
</html>