<?php
session_start();

// Verificar si la sesión del carrito ya está inicializada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Obtener la información del producto del formulario
$productID = isset($_POST['productID']) ? $_POST['productID'] : '';
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Verificar si el producto ya está en el carrito
if (array_key_exists($productID, $_SESSION['cart'])) {
    // Si el producto ya está en el carrito, actualiza la cantidad
    $_SESSION['cart'][$productID] += $quantity;
} else {
    // Si el producto no está en el carrito, agrégalo
    $_SESSION['cart'][$productID] = $quantity;
}

// Redirigir a la página del carrito
header("Location: /Carrito");
exit();
?>
