<?php

class ProductController
{
    private $productModel;
    
    public function __construct()
    {
        require_once($GLOBALS["path"] . '/Models/ProductModel.php');
        $this->productModel = new ProductModel();
    }

    public function getProductByID($productID)
    {
        return $this->productModel->getProductByID($productID);
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->productModel->getProductsByCategory($categoryId);
    }

    public function getAllProducts()
    {
        return $this->productModel->getAllProducts();
    }
}


?>