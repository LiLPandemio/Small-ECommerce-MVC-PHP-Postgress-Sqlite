<?php

require_once($GLOBALS["path"] . '/Models/CategoryModel.php');
require_once($GLOBALS["path"] . '/Controllers/ProductController.php');

class CategoryController
{
    private $categoryModel;
    private $productController;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productController = new ProductController();
    }

    public function getAllCategories()
    {
        return $this->categoryModel->getAllCategories();
    }

    public function getCategoryWithProducts($categoryId)
    {
        $category = $this->categoryModel->getCategoryById($categoryId);

        if ($category) {
            $category['products'] = $this->productController->getProductsByCategory($categoryId);
        }

        return $category;
    }
}

?>
