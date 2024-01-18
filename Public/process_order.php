<?php
require("../CONFIG.php");
session_start(); // Inicia la sesión

if (!isset($_SESSION["user"])) {
    header("Location: /Login");
    exit();
} else {


    // Verifica si existe el carrito en la sesión
    if (isset($_SESSION['cart'])) {
        // Obtén el ID de usuario de la sesión
        $userID = $_SESSION['user']['id']; // Asegúrate de que el usuario esté autenticado

        // Incluye el archivo OrderController.php para poder usar la clase
        require_once($GLOBALS["path"] . '/Controllers/OrderController.php');

        // Crea una instancia del controlador de pedidos
        $orderController = new OrderController();

        $cartContents = $_SESSION['cart'];
        $orderID = $orderController->processOrder($userID, $cartContents);



        if ($orderID) {
            // Pedido creado con éxito
            // Puedes redirigir a una página de éxito o realizar otras acciones necesarias
            header("Location: /Gracias");
            echo "OK";
            exit();
        } else {
            // Error al crear el pedido
            // Puedes redirigir a una página de error o realizar otras acciones necesarias
            echo "E0";
            die("Error PROCESS_ORDER/0");
        }
    } else {
        // El carrito está vacío, maneja este caso según tus necesidades
        header("Location: /");
        echo "E1";
        exit();
    }
}
