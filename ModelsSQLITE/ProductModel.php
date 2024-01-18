<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $dbPath = $GLOBALS["path"] . "/db.db";
        $this->db = new SQLite3($dbPath);
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $result = $this->db->query($query);

        $products = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $products[] = $row;
        }

        return $products;
    }

    public function getProductByID($productID)
    {
        $query = "SELECT * FROM product WHERE id = :productID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":productID", $productID, SQLITE3_INTEGER);
        $result = $stmt->execute();

        $product = $result->fetchArray(SQLITE3_ASSOC);

        return $product;
    }
    
    public function getProductsByCategory($categoryId)
    {
        $query = "SELECT * FROM product WHERE id_category = :categoryId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":categoryId", $categoryId, SQLITE3_INTEGER);
        $result = $stmt->execute();

        $products = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $products[] = $row;
        }

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
