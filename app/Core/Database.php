<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $db = $GLOBALS['config']['db'];
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $db['host'], $db['port'], $db['database'], $db['charset']);

        try {
            self::$pdo = new PDO($dsn, $db['username'], $db['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException) {
            $sqlitePath = __DIR__ . '/../../storage/blackforge.sqlite';
            self::$pdo = new PDO('sqlite:' . $sqlitePath);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::initSqlite(self::$pdo);
        }

        return self::$pdo;
    }

    private static function initSqlite(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE IF NOT EXISTS roles (id INTEGER PRIMARY KEY, name TEXT, slug TEXT UNIQUE)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, role_id INTEGER, email TEXT UNIQUE, password_hash TEXT, email_verified INTEGER DEFAULT 0, created_at TEXT DEFAULT CURRENT_TIMESTAMP)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, slug TEXT UNIQUE)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS manufacturers (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, country TEXT)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS products (id INTEGER PRIMARY KEY AUTOINCREMENT, category_id INTEGER, manufacturer_id INTEGER, name TEXT, slug TEXT UNIQUE, description TEXT, diameter INTEGER, pcd TEXT, width REAL, offset_et INTEGER, material TEXT, type TEXT, color TEXT, price REAL, stock INTEGER DEFAULT 0, popularity INTEGER DEFAULT 0, created_at TEXT DEFAULT CURRENT_TIMESTAMP)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS product_images (id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER, image_url TEXT, source TEXT, sort_order INTEGER DEFAULT 0)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS orders (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NULL, customer_email TEXT, total_amount REAL, status TEXT DEFAULT "new", promo_code TEXT NULL, created_at TEXT DEFAULT CURRENT_TIMESTAMP)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS order_items (id INTEGER PRIMARY KEY AUTOINCREMENT, order_id INTEGER, product_id INTEGER, quantity INTEGER, unit_price REAL)');

        $exists = (int) $pdo->query('SELECT COUNT(*) AS cnt FROM products')->fetch()['cnt'];
        if ($exists === 0) {
            $pdo->exec("INSERT INTO roles(id,name,slug) VALUES (1,'Администратор','admin'), (2,'Пользователь','user')");
            $pdo->exec("INSERT INTO users(role_id,email,password_hash,email_verified) VALUES (1,'admin@blackforge.local','$2y$12$8hC6kJxLCDLxeIhVbHjeOuLnGHwq7eBYAFIu0OQpSq8np4Fyx0Pdy',1)");
            $pdo->exec("INSERT INTO categories(name,slug) VALUES ('Литые диски','litye'), ('Кованые диски','kovanye')");
            $pdo->exec("INSERT INTO manufacturers(name,country) VALUES ('BLACKFORGE Atelier','Germany'), ('Aurum Wheels','Italy')");
            $pdo->exec("INSERT INTO products(category_id, manufacturer_id, name, slug, description, diameter, pcd, width, offset_et, material, type, color, price, stock, popularity) VALUES
                (1,1,'BLACKFORGE Obsidian R19','blackforge-obsidian-r19','Спортивный дизайн в графитовом цвете.',19,'5x112',8.5,35,'литые','спортивные','graphite',125000,12,95),
                (2,2,'BLACKFORGE Royale R21','blackforge-royale-r21','Люксовая кованая серия в золоте.',21,'5x120',9.5,40,'кованые','люкс','gold',249000,4,99)");
            $pdo->exec("INSERT INTO product_images(product_id, image_url, source, sort_order) VALUES (1,'/assets/images/placeholder.svg','url',1),(2,'/assets/images/placeholder.svg','url',1)");
        }

        $adminExists = (int) $pdo->query("SELECT COUNT(*) AS cnt FROM users WHERE role_id = 1")->fetch()['cnt'];
        if ($adminExists === 0) {
            $pdo->exec("INSERT INTO users(role_id,email,password_hash,email_verified) VALUES (1,'admin@blackforge.local','$2y$12$8hC6kJxLCDLxeIhVbHjeOuLnGHwq7eBYAFIu0OQpSq8np4Fyx0Pdy',1)");
        }
    }
}
