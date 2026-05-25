<?php require_once("header.php")?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php 
        if (isset($_POST["logout"])) {
            unset($_SESSION['user']);
            unset($_SESSION['userrole']);
            $_SESSION['loged'] = false;
        }
        
    ?>

    <?php if (!isset($_POST["logout"])):?>
    <div class="container mt-3">
        <h1 class="text-center">¿Está seguro de que quiere cerrar sesión?</h1>

        <form class="form text-center my-2" method="post">
            <button class="btn btn-warning" type="submit" name="logout">Cerrar Sesión</button>
        </form>

    </div>

    <?php else: echo "<script>window.location.href=\"../index.php\"</script>"?>

        

    <?php endif?>

</body>
</html>