<?php

declare(strict_types=1);

namespace App\Models;

use Throwable;

final class Review extends BaseModel
{
    public function byProduct(int $productId): array
    {
        try {
            $stmt = $this->db->prepare('SELECT r.*, u.email FROM reviews r LEFT JOIN users u ON u.id=r.user_id WHERE product_id=:product_id ORDER BY created_at DESC');
            $stmt->execute(['product_id' => $productId]);
            return $stmt->fetchAll();
        } catch (Throwable) {
            return [];
        }
    }

    public function add(int $productId, ?int $userId, int $rating, string $comment): void
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (:user_id, :product_id, :rating, :comment)');
            $stmt->execute([
                'user_id' => $userId ?? 1,
                'product_id' => $productId,
                'rating' => $rating,
                'comment' => $comment,
            ]);
        } catch (Throwable) {
            // no-op in demo mode
        }
    }
}
