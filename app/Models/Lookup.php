<?php

declare(strict_types=1);

namespace App\Models;

final class Lookup extends BaseModel
{
    public function categories(): array
    {
        return $this->db->query('SELECT * FROM categories ORDER BY name')->fetchAll();
    }

    public function manufacturers(): array
    {
        return $this->db->query('SELECT * FROM manufacturers ORDER BY name')->fetchAll();
    }
}
