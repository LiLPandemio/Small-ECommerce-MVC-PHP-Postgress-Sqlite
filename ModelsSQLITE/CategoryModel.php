<?php
class CategoryModel {
    private $db;

    public function __construct() {
        $dbPath = $GLOBALS["path"] . "/db.db";
        $this->db = new SQLite3($dbPath);
    }

    public function getAllCategories() {
        $query = "SELECT * FROM category";
        $result = $this->db->query($query);

        $categories = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $categories[] = $row;
        }

        return $categories;
    }
}
?>
