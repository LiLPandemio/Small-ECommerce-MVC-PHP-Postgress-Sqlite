<?php
// process_register.php
require("../CONFIG.php");
require_once($GLOBALS["path"] . '/Controllers/UserController.php');

$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $poblacio = $_POST["poblacio"];
    $codi_postal = $_POST["codi_postal"];
    $adreca = $_POST["adreca"];

    $userController->registerUser($username, $email, $password, $poblacio, $adreca, $codi_postal);
} else {
    // Manejar otros casos, como si se accede directamente a este script por GET
    echo "Acceso no permitido.";
}
?>
