<?php
session_start();

// Vaciar el carrito (eliminar la variable de sesión)
unset($_SESSION['cart']);

// Redirigir a la página principal
header("Location: /");
exit();
?>
