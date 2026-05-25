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
            $answer = checkIfExist($_POST['username'], $_POST['password']);

            if ($answer && password_verify($_POST['password'], $answer['password'])) {
                echo "<div class=\"alert alert-success text-center\"><h1>Login Exitoso</h1></div>";
                $_SESSION['user'] = $answer['username'];
                $_SESSION['loged'] = true;
                $_SESSION['userrole'] = $answer['role'];
                echo "<script>window.location.href=\"../index.php\"</script>";
            } else if (!$answer) {
                echo "<div class=\"alert alert-danger text-center\"><h1>El usuario no existe</h1></div>";
            } else {
                echo "<div class=\"alert alert-danger text-center\"><h1>Contraseña incorrecta</h1></div>";
            }
            

        }
        
    
    ?>

    <div class="container my-3 text-center"><h1>Inicia Sesión</h1></div>

    <div class="container mt-4 text-center border border-primary p-3" id="formContainer">
        <form method="post" class="form" id="login">
            <div class="row mb-2 mx-2">
                <label for="username" class="form-label">Nombre de usuario:</label>
                <input type="text" name="username" id="username" class="form-control" >
            </div>
            <div class="row mb-2 mx-2">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" >
            </div>

            <button type="submit" name="submit" class="btn btn-success mt-2">Iniciar Sesión</button>

        </form>
    </div>

    
    <?php require_once("footer.php")?>
    <script src="login.js"></script>
</body>
</html>