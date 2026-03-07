INSERT INTO categories(name, slug) VALUES ('Литые диски', 'litye'), ('Кованые диски', 'kovanye');
INSERT INTO manufacturers(name, country) VALUES ('BLACKFORGE Atelier', 'Germany'), ('Aurum Wheels', 'Italy');

INSERT INTO users(role_id, email, password_hash, email_verified)
VALUES (1, 'admin@blackforge.local', '$2y$12$8hC6kJxLCDLxeIhVbHjeOuLnGHwq7eBYAFIu0OQpSq8np4Fyx0Pdy', 1);

INSERT INTO products(category_id, manufacturer_id, name, slug, description, diameter, pcd, width, offset_et, material, type, color, price, stock, popularity)
VALUES
(1,1,'BLACKFORGE Obsidian R19','blackforge-obsidian-r19','Спортивный дизайн в графитовом цвете.',19,'5x112',8.5,35,'литые','спортивные','graphite',125000,12,95),
(2,2,'BLACKFORGE Royale R21','blackforge-royale-r21','Люксовая кованая серия в золоте.',21,'5x120',9.5,40,'кованые','люкс','gold',249000,4,99);

INSERT INTO product_images(product_id, image_url, source, sort_order)
VALUES
(1,'/assets/images/placeholder.svg','url',1),
(2,'/assets/images/placeholder.svg','url',1);

INSERT INTO promo_codes(code, discount_percent, active) VALUES ('BLACK10',10,1);
