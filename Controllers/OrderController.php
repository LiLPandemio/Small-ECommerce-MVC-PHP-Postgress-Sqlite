<?php
// OrderController.php

require_once($GLOBALS["path"] . '/Models/OrderModel.php');

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function processOrder($userID, $products)
    {
        // Verificar la existencia de los campos necesarios
        if ($userID && $products) {
            // Crear un nuevo pedido
            $orderID = $this->orderModel->createOrder($userID);

            if ($orderID) {
                // Pedido creado con éxito
                // Ahora añade los productos al pedido
                foreach ($products as $productID => $quantity) {
                    // Añade el producto al pedido
                    $this->orderModel->addProductToOrder($orderID, $productID, $quantity);
                }

                // Devuelve el ID del pedido recién creado
                return $orderID;
            } else {
                // Error al crear el pedido
                return false;
            }
        } else {
            // Campos faltantes, manejar el error
            return false;
        }
    }

    public function getUserOrders($userID)
    {
        // Obtener los pedidos asociados al usuario
        return $this->orderModel->getOrdersByUserID($userID);
    }
}
?>
