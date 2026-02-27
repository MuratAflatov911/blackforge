<?php

declare(strict_types=1);

namespace App\Models;

final class User extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT u.*, r.slug AS role_slug FROM users u JOIN roles r ON r.id=u.role_id WHERE email=:email LIMIT 1');
        $stmt->execute(['email' => $email]);

        return $stmt->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT u.*, r.slug AS role_slug FROM users u JOIN roles r ON r.id=u.role_id WHERE u.id=:id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(string $email, string $passwordHash, string $firstName, string $lastName, string $phone): void
    {
        $stmt = $this->db->prepare('INSERT INTO users (role_id, email, password_hash, full_name, phone, email_verified) VALUES (3, :email, :password_hash, :full_name, :phone, 0)');
        $stmt->execute([
            'email' => $email,
            'password_hash' => $passwordHash,
            'full_name' => trim($firstName . ' ' . $lastName),
            'phone' => $phone,
        ]);
    }

    public function all(): array
    {
        return $this->db->query('SELECT u.id, u.email, u.full_name, u.email_verified, r.name AS role_name FROM users u JOIN roles r ON r.id=u.role_id ORDER BY u.created_at DESC')->fetchAll();
    }

    public function orderHistory(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE user_id=:user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function orderItems(int $orderId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id=:order_id');
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    public function updateProfile(int $id, string $fullName, string $phone, string $address, ?string $avatarUrl): void
    {
        $stmt = $this->db->prepare('UPDATE users SET full_name=:full_name, phone=:phone, address=:address, avatar_url=:avatar_url WHERE id=:id');
        $stmt->execute([
            'id' => $id,
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address,
            'avatar_url' => $avatarUrl,
        ]);
    }

    public function changePassword(int $id, string $hash): void
    {
        $stmt = $this->db->prepare('UPDATE users SET password_hash=:hash WHERE id=:id');
        $stmt->execute(['id' => $id, 'hash' => $hash]);
    }
}
