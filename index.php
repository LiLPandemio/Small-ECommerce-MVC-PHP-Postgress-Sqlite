<?php

$showErrors = false;         //Mostrara o no los errores en la pagina web.
$disableCache = false;       //Desactivara el cache (Header)

//DEBUG - MUESTRA LOS ERRORES EN EL NAVEGADOR
if ($showErrors) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}
if ($disableCache) {
    //NO CACHE
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

// Cargar las variables globales
require_once('./CONFIG.php');
// Incluir archivos comunes (head y header)
include($GLOBALS["path"] . '/Views/_head.phtml');
include($GLOBALS["path"] . '/Views/_header.phtml');

// Determinar la acción solicitada
$accion = isset($_GET['accio']) ? strtok($_GET['accio'], '/#') : 'landing';

// Definir rutas de las vistas según la acción
$vistaRuta = 'Views/' . $accion . '.phtml';

// Verificar si el archivo de vista existe
if (file_exists($vistaRuta)) {
    // Incluir la vista correspondiente
    include($vistaRuta);
} else {
    // Vista por defecto (landing) si la acción no es reconocida
    include('Views/landing.phtml');
}
include('./Views/_footer.phtml');

?>
