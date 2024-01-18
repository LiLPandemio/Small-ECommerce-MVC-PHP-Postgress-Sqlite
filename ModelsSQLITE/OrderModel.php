<?php
class OrderModel
{
    private $db;

    public function __construct()
    {
        $dbPath = $GLOBALS["path"] . "/db.db";
        $this->db = new SQLite3($dbPath);
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

    public function addProductToOrder($orderID, $productID, $quantity)
    {
        // Obtén el precio del producto desde el modelo de productos
        // OrderModel.php
        
        $productPrice = $this->getProductByID($productID);
        $productPrice = $productPrice["preu"];
        $query = "INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES (:orderID, :productID, :quantity, :totalPrice)";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":orderID", $orderID, SQLITE3_INTEGER);
        $stmt->bindParam(":productID", $productID, SQLITE3_INTEGER);
        $stmt->bindParam(":quantity", $quantity, SQLITE3_INTEGER);
        
        // Calcula el precio total utilizando el precio del producto y la cantidad
        $totalPrice = $productPrice * $quantity;
        $stmt->bindParam(":totalPrice", $totalPrice, SQLITE3_FLOAT);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $this->db->lastErrorMsg());
        }
    }


    public function createOrder($userID)
    {
        $query = "INSERT INTO orders (user_id, order_date) VALUES (:userID, datetime('now'))";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":userID", $userID, SQLITE3_INTEGER);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $this->db->lastErrorMsg());
        }

        // Devolver el ID del pedido recién creado
        return $this->db->lastInsertRowID();
    }
}
