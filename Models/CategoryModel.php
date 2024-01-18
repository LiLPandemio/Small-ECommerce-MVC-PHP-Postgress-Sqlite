<?php
class CategoryModel {
    private $db;

    public function __construct() {
        // Configura los parámetros de conexión a PostgreSQL
        $host = 'localhost';
        $dbname = 'sneeaking';
        $user = 'postgres';
        $pass = 'root';

        // Conecta a la base de datos PostgreSQL
        try {
            $this->db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getAllCategories() {
        $query = "SELECT * FROM category";
        
        try {
            $result = $this->db->query($query);
            $categories = $result->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }
}
?>
