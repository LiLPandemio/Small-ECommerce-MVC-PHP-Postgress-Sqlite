<?php
class OrderModel
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

    public function getProductByID($productID)
    {
        $query = "SELECT * FROM product WHERE id = :productID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    public function addProductToOrder($orderID, $productID, $quantity)
    {
        // Obtén el precio del producto desde el modelo de productos
        $productPrice = $this->getProductByID($productID);
        $productPrice = $productPrice["preu"];

        $query = "INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES (:orderID, :productID, :quantity, :totalPrice)";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":orderID", $orderID, PDO::PARAM_INT);
        $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
        $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);

        // Calcula el precio total utilizando el precio del producto y la cantidad
        $totalPrice = $productPrice * $quantity;
        $stmt->bindParam(":totalPrice", $totalPrice, PDO::PARAM_STR);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $this->db->lastErrorMsg());
        }
    }

    public function createOrder($userID)
    {
        // Verificar si ya existe un pedido sin completar para el usuario
        $existingOrderQuery = "SELECT id FROM orders WHERE user_id = :userID AND order_date IS NULL";
        $existingOrderStmt = $this->db->prepare($existingOrderQuery);
        $existingOrderStmt->bindParam(":userID", $userID, PDO::PARAM_INT);
        $existingOrderStmt->execute();

        $existingOrder = $existingOrderStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingOrder) {
            // Ya existe un pedido sin completar, devolver su ID
            return $existingOrder['id'];
        }

        // Si no existe, crear un nuevo pedido
        $query = "INSERT INTO orders (user_id, order_date) VALUES (:userID, NOW())";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $this->db->lastErrorMsg());
        }

        // Devolver el ID del pedido recién creado
        return $this->db->lastInsertId();
    }

    public function getOrdersByUserID($userID)
    {
        $query = "SELECT orders.id, orders.order_date, product.nom as product_name, order_items.total_price, order_items.quantity 
              FROM orders 
              LEFT JOIN order_items ON orders.id = order_items.order_id
              LEFT JOIN product ON order_items.product_id = product.id
              WHERE user_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
        $stmt->execute();

        $orders = [];
        $currentOrderID = null;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['id'] !== $currentOrderID) {
                // Nuevo pedido encontrado
                $currentOrderID = $row['id'];
                $row['items'] = [];
                $orders[] = $row;
            }

            // Agrega la información del ítem al pedido actual
            if (!empty($row['product_name'])) {
                $orders[count($orders) - 1]['items'][] = [
                    'product_name' => $row['product_name'],
                    'total_price' => $row['total_price'],
                    'quantity' => $row['quantity'],
                ];
            }
        }

        return $orders;
    }


    public function getOrderItems($orderID)
    {
        $query = "SELECT * FROM order_items WHERE order_id = :orderID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":orderID", $orderID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
