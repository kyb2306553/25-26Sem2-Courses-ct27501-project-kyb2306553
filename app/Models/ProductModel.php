<?php

namespace App\Models;

use Config\Database;
use PDO;

class ProductModel
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getFeaturedProducts()
    {

        $stmt = $this->conn->prepare("
        SELECT p.id, p.name, p.price, p.stock, p.description, c.name AS category_name, b.name AS brand_name, pi.image_path
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN product_images pi ON pi.id = (
            SELECT pi2.id
            FROM product_images pi2
            WHERE pi2.product_id = p.id
            ORDER BY pi2.is_main DESC, pi2.sort_order ASC, pi2.id ASC
            LIMIT 1
        )
        ORDER BY RANDOM()
        LIMIT 8
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts()
    {
        $sql = "
            SELECT p.id, p.name, p.price, p.stock, p.description, c.name AS category_name, b.name AS brand_name, pi.image_path
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN product_images pi ON pi.id = (
                SELECT pi2.id
                FROM product_images pi2
                WHERE pi2.product_id = p.id
                ORDER BY pi2.is_main DESC, pi2.sort_order ASC, pi2.id ASC
                LIMIT 1
            )
            ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($productId)
    {
        $sql = "
            SELECT p.id, p.name, p.price, p.stock, p.description, c.name AS category_name,
                b.name AS brand_name, pi.image_path
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN product_images pi ON pi.id = (
                SELECT pi2.id
                FROM product_images pi2
                WHERE pi2.product_id = p.id
                ORDER BY pi2.is_main DESC, pi2.sort_order ASC, pi2.id ASC
                LIMIT 1
            )
            WHERE p.id = :product_id
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null;
        }

        $images = $this->getProductImages($productId);

        if (empty($images) && !empty($product['image_path'])) {
            $images[] = (string) $product['image_path'];
        }

        $product['images'] = array_slice($images, 0, 3);
        $product['image_path'] = $product['images'][0] ?? $product['image_path'];

        return $product;
    }

    public function getProductsByIds($productIds)
    {
        if (empty($productIds)) {
            return [];
        }

        $productIds = array_values(array_unique(array_map('intval', $productIds)));
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $sql = "
            SELECT p.id, p.name, p.price, p.stock, p.description, c.name AS category_name,
                b.name AS brand_name, pi.image_path
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN product_images pi ON pi.id = (
                SELECT pi2.id
                FROM product_images pi2
                WHERE pi2.product_id = p.id
                ORDER BY pi2.is_main DESC, pi2.sort_order ASC, pi2.id ASC
                LIMIT 1
            )
            WHERE p.id IN ($placeholders)
            ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        foreach ($productIds as $index => $productId) {
            $stmt->bindValue($index + 1, $productId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        $sql = 'SELECT id, name FROM categories ORDER BY id ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBrands()
    {
        $sql = 'SELECT id, name FROM brands ORDER BY id ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getProductImages($productId)
    {
        $sql = "
            SELECT image_path
            FROM product_images
            WHERE product_id = :product_id
            ORDER BY is_main DESC, sort_order ASC, id ASC
            LIMIT 3";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $imageRows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return array_values(array_filter(
            array_map(static fn($imagePath) => is_string($imagePath) ? trim($imagePath) : '', $imageRows),
            static fn($imagePath) => $imagePath !== ''
        ));
    }


    public function createProduct($data, $imagePath)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO products (name, price, stock, description, category_id, brand_id) 
                VALUES (:name, :price, :stock, :description, :category_id, :brand_id) RETURNING id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'],
                ':price' => $data['price'],
                ':stock' => $data['stock'],
                ':description' => $data['description'],
                ':category_id' => $data['category_id'],
                ':brand_id' => $data['brand_id']
            ]);
            $productId = $stmt->fetchColumn();

            if ($imagePath) {
                $sqlImg = "INSERT INTO product_images (product_id, image_path, is_main) VALUES (?, ?, true)";
                $this->conn->prepare($sqlImg)->execute([$productId, $imagePath]);
            }

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateProduct($id, $data, $imagePath = null)
    {
        $sql = "UPDATE products SET name = :name, price = :price, stock = :stock, 
            description = :description, category_id = :category_id, brand_id = :brand_id 
            WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':name' => $data['name'],
            ':price' => (int)$data['price'],
            ':stock' => (int)$data['stock'],
            ':description'  => !empty($data['description']) ? $data['description'] : null,
            ':category_id' => (int)$data['category_id'],
            ':brand_id' => !empty($data['brand_id']) ? (int)$data['brand_id'] : null,
            ':id' => (int)$id
        ]);

        if ($imagePath) {
            $this->conn->prepare("DELETE FROM product_images WHERE product_id = ?")->execute([$id]);
            $this->conn->prepare("INSERT INTO product_images (product_id, image_path, is_main) VALUES (?, ?, true)")->execute([$id, $imagePath]);
        }
        return $result;
    }

    public function deleteProduct($id)
    {
        $this->conn->prepare("DELETE FROM product_images WHERE product_id = ?")->execute([$id]);
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
