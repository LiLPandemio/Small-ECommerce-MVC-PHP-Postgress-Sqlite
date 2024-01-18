<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
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

    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $result = $this->db->query($query);

        $products = $result->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function getProductByID($productID)
    {
        $query = "SELECT * FROM product WHERE id = :productID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    public function getProductsByCategory($categoryId)
    {
        $query = "SELECT * FROM product WHERE id_category = :categoryId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":categoryId", $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function addToCart($productId, $quantity)
    {
        // Implementa la lógica para agregar productos al carrito
        // Esto podría incluir actualizar una tabla de carrito en la base de datos
        // o almacenar temporalmente los productos seleccionados en una sesión
        // Aquí solo se muestra como un ejemplo simple
        $cartItem = [
            'product_id' => $productId,
            'quantity' => $quantity
        ];

        // Guarda el elemento del carrito en la sesión (puedes adaptarlo según tu lógica)
        session_start();
        $_SESSION['cart'][] = $cartItem;
    }
}
