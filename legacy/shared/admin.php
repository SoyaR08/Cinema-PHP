<?php require_once("header.php"); require("adminUtils.php"); $userList = listUsers(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1 class="mt-3 text-center">Lista de Usuarios</h1>

    <table class="table table-stripped mt-3 text-center">
        <thead>
            <tr>
                <th>Nombre usuario: </th>
                <th>Acciones: </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userList as $user) :?>
                <tr>
                    <td><?= $user['username']?></td>
                    <td>
                        <a href="<?php echo "adminForm.php?action=role&user=$user[username]"?>" class="btn btn-warning">Cambiar Rol</a>
                        <a href="<?php echo "adminForm.php?action=password&user=$user[username]"?>" class="btn btn-primary">Cambiar Contraseña</a>
                    </td>
                </tr>

            <?php endforeach;?>
        </tbody>
    </table>

</body>
</html>