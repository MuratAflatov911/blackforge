<?php

declare(strict_types=1);

namespace App\Models;

final class Order extends BaseModel
{
    public function create(?int $userId, string $email, array $items, float $total, ?string $promoCode = null): int
    {
        $this->db->beginTransaction();
        $stmt = $this->db->prepare('INSERT INTO orders (user_id, customer_email, total_amount, status, promo_code) VALUES (:user_id, :email, :total, :status, :promo_code)');
        $stmt->execute([
            'user_id' => $userId,
            'email' => $email,
            'total' => $total,
            'status' => 'new',
            'promo_code' => $promoCode,
        ]);
        $orderId = (int) $this->db->lastInsertId();

        $itemStmt = $this->db->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (:order_id, :product_id, :quantity, :unit_price)');
        foreach ($items as $item) {
            $itemStmt->execute([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        $this->db->commit();
        return $orderId;
    }

    public function adminStats(): array
    {
        $sales = $this->db->query('SELECT COALESCE(SUM(total_amount),0) AS revenue, COUNT(*) AS orders_count FROM orders')->fetch();
        $popular = $this->db->query('SELECT p.name, SUM(oi.quantity) AS sold
            FROM order_items oi JOIN products p ON p.id = oi.product_id
            GROUP BY oi.product_id, p.name ORDER BY sold DESC LIMIT 5')->fetchAll();

        return ['sales' => $sales, 'popular' => $popular];
    }

    public function allWithUsers(): array
    {
        return $this->db->query('SELECT o.*, u.email FROM orders o LEFT JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC')->fetchAll();
    }
}
