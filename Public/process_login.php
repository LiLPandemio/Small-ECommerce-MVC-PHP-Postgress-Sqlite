<?php
require("../CONFIG.php");
require_once($GLOBALS["path"] . '/Controllers/UserController.php');

$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $user = $userController->login($email, $password);

    if ($user !== false && isset($user['id'])) {
        // Inicio de sesión exitoso, puedes almacenar información del usuario en la sesión si es necesario
        $_SESSION['user'] = $user;

        echo "Inicio de sesión exitoso para el usuario con ID: " . $user['id'];
        header("Location: /");
        exit(); // Detener la ejecución del script después de redirigir
    } else {
        // Inicio de sesión fallido, redirigir o mostrar un mensaje de error
        echo "Inicio de sesión fallido. Verifica tus credenciales. [LOGIN PROCESSOR]";
        #header("Location: /Login/Fail");
        exit(); // Detener la ejecución del script después de redirigir
    }
} else {
    // Manejar otros casos, como si se accede directamente a este script por GET
    echo "Acceso no permitido.";
}
?>
