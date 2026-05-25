<?php require_once("../shared/header.php"); require("shoppingCartUtils.php");
    //unset($_SESSION['cart']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $ticket = [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
<body>
    <?php if (isset($_SESSION['loged']) && $_SESSION['loged']): ?>

           <?php 

            if (!empty($_POST)) {

                if (isset($_POST['purchase'])) {
                    foreach ($_SESSION['cart'] as $array) {
                        foreach ($array as $value => $var) {
                             if (checkIfExists($var)) {
                                updateNumberOfTickets($var);
                            } else {
                            addTicket($var);
                            }
                        }
                       
                       
                    }
                    unset($_SESSION['cart']);

                } else {
                    $formatInfo = formatData($_POST, $_SESSION['user']);
                    array_push($ticket, $formatInfo);
                    $_SESSION['cart'][] = $ticket;
                    //print_r($_SESSION['cart']);
                }

                
            } ?>
            

            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):?>
                <table class="mt-5 table table-stripped">
                    <thead>
                        <tr>
                            <td>Cine</td>
                            <td>Sala</td>
                            <td>Película</td>
                            <td>Nº de entradas</td>
                            <td>Fecha</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $entrada): ?>
                            
                            <?php foreach ($entrada as $data):?>
                                <tr>
                                    <td><?= $data['cine']?></td>
                                    <td><?= $data['sala']?></td>
                                    <td><?= $data['titulo_p']?></td>
                                    <td><?= $data['quantity']?></td>
                                    <td><?= $data['fecha']?></td>
                                    
                                </tr>
                            <?php endforeach;?>

                        <?php endforeach;?>
                    </tbody>
                </table>
                <form method="post" class="form text-center mt-3">
                    <button type="submit" name="purchase" value="purchased" class="btn btn-success">Comprar</button>
                </form>
            <?php else :?>
                <?php echo "No tienes nada en el carrito";?>
            <?php endif;?>

    <?php else: echo "Debes iniciar Sesión";?>
    <?php endif;?>

</body>
</html>