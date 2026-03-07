<?php

declare(strict_types=1);

namespace App\Models;

final class Product extends BaseModel
{
    public function list(array $filters): array
    {
        $sql = 'SELECT p.*, c.name AS category_name, m.name AS manufacturer_name
                FROM products p
                JOIN categories c ON c.id = p.category_id
                JOIN manufacturers m ON m.id = p.manufacturer_id
                WHERE 1=1';
        $params = [];

        if (!empty($filters['diameter'])) {
            $sql .= ' AND p.diameter = :diameter';
            $params['diameter'] = (int) $filters['diameter'];
        }
        if (!empty($filters['pcd'])) {
            $sql .= ' AND p.pcd = :pcd';
            $params['pcd'] = $filters['pcd'];
        }
        if (!empty($filters['width'])) {
            $sql .= ' AND p.width = :width';
            $params['width'] = (float) $filters['width'];
        }
        if (!empty($filters['offset_et'])) {
            $sql .= ' AND p.offset_et = :offset_et';
            $params['offset_et'] = (int) $filters['offset_et'];
        }
        if (!empty($filters['manufacturer_id'])) {
            $sql .= ' AND p.manufacturer_id = :manufacturer_id';
            $params['manufacturer_id'] = (int) $filters['manufacturer_id'];
        }
        if (!empty($filters['material'])) {
            $sql .= ' AND p.material = :material';
            $params['material'] = $filters['material'];
        }
        if (!empty($filters['type'])) {
            $sql .= ' AND p.type = :type';
            $params['type'] = $filters['type'];
        }
        if (!empty($filters['color'])) {
            $sql .= ' AND p.color = :color';
            $params['color'] = $filters['color'];
        }
        if (!empty($filters['price_min'])) {
            $sql .= ' AND p.price >= :price_min';
            $params['price_min'] = (float) $filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $sql .= ' AND p.price <= :price_max';
            $params['price_max'] = (float) $filters['price_max'];
        }
        if (!empty($filters['in_stock'])) {
            $sql .= ' AND p.stock > 0';
        }

        $sort = $filters['sort'] ?? 'new';
        $sql .= match ($sort) {
            'price_asc' => ' ORDER BY p.price ASC',
            'price_desc' => ' ORDER BY p.price DESC',
            'popular' => ' ORDER BY p.popularity DESC',
            default => ' ORDER BY p.created_at DESC',
        };

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT p.*, m.name AS manufacturer_name FROM products p JOIN manufacturers m ON m.id=p.manufacturer_id WHERE p.slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch();
        if (!$product) {
            return null;
        }

        $imgStmt = $this->db->prepare('SELECT * FROM product_images WHERE product_id = :id ORDER BY sort_order');
        $imgStmt->execute(['id' => $product['id']]);
        $product['images'] = $imgStmt->fetchAll();

        return $product;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id=:id LIMIT 1');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function top(int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY popularity DESC LIMIT :limit');
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function latest(int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function recommended(int $productId, int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id <> :id ORDER BY popularity DESC LIMIT :limit');
        $stmt->bindValue('id', $productId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
