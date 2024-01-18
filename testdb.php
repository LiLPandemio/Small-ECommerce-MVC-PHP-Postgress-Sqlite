<?php
$host = 'localhost';
$dbname = 'sneeaking';
$user = 'postgres';
$pass = 'root';

try {
    // Establecer la conexión
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);

    // Configurar el modo de error y excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el nombre de todas las tablas en la base de datos
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Imprimir información de las tablas
    foreach ($tables as $table) {
        echo "Tabla: $table\n";
        
        // Obtener la información de las columnas
        $stmt = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$table'");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Imprimir información de las columnas
        foreach ($columns as $column) {
            echo "  Columna: {$column['column_name']}, Tipo de dato: {$column['data_type']}\n";
        }

        echo "\n";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
