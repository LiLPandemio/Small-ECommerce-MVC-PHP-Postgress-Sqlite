<?php
// Inicias la sesión si aún no está iniciada
session_start();

// Verificas si existe la clave "cart" en $_SESSION y si $_GET["quitar"] está definido
if (isset($_SESSION["cart"]) && isset($_GET["quitar"])) {
    // Obtiene el valor de $_GET["quitar"]
    $idToRemove = $_GET["quitar"];

    // Verifica si el elemento con la clave $idToRemove existe en $_SESSION["cart"]
    if (isset($_SESSION["cart"][$idToRemove])) {
        // Elimina el elemento con la clave $idToRemove del array $_SESSION["cart"]
        unset($_SESSION["cart"][$idToRemove]);

        // Puedes imprimir el nuevo estado del array para verificar que se eliminó correctamente
        var_dump($_SESSION["cart"]);
    } else {
        // Manejo de error si el elemento no existe en el array
        echo "El elemento con la clave $idToRemove no existe en el carrito.";
    }
} else {
    // Manejo de error si la clave "cart" no está presente en $_SESSION o $_GET["quitar"] no está definido
    echo "No se proporcionó un ID para quitar o el carrito no está inicializado.";
}
header("Location:/Carrito");