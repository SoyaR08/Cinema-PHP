<?php require_once("../shared/Database.php");

/**
 * Función para comprobar si el usuario existe en la base de datos
 * @param mixed $userName El nombre del usuario
 * @param mixed $userPassword La contraseña (muy probablemente lo acabe borrando)
 */
function checkIfExist($userName, $userPassword) {
    $result = null; //Inicializo para que no de errores
    $db = Database::getInstance()->getConnection(); //Creo un objeto Database y obtengo la conexión
    $query = "SELECT * FROM Usuario WHERE username = :name"; //Escribo la query sql y lo guardo como string
    $call = $db->prepare($query); //Le digo a la base de datos que prepare la query con parámetro
    $call -> bindParam(":name", $userName, PDO::PARAM_STR); //le paso el valor del parámetro
    
    //Try catch para evitar errores
    try {
        $call->execute(); //Ejecuto la query
        $result = $call->fetch(PDO::FETCH_ASSOC); //Pido que me devuelva el resultado como array asociativo
        return $result;
    } catch (PDOException $error) {
        echo $error;
    }

}

/**
 * Método para iniciar sesión en el sistema
 * @param mixed $name El nickname del usuario
 * @param mixed $password La contraseña del usuario
 */
function signIn($name, $password) {
    $result = null;
    $default = "USER";
    $db = Database::getInstance()->getConnection();
    $query = "INSERT INTO Usuario (username, password, role) VALUES (:newUserName, :newPassword, :defaultRole)";
    $call = $db->prepare($query);
    $call -> bindParam(":newUserName", $name, PDO::PARAM_STR);
    $securePassword = password_hash($password, PASSWORD_DEFAULT);
    $call -> bindParam(":newPassword", $securePassword, PDO::PARAM_STR);
    $call -> bindParam(":defaultRole", $default, PDO::PARAM_STR);
    try {
        $call->execute();
        $result = true;
        return $result;
    } catch (PDOException $e) {
        echo $e;
    }
}