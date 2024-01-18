-- Definición de tablas
CREATE TABLE IF NOT EXISTS usuaris (
  id INTEGER PRIMARY KEY,
  nom TEXT,
  Correu_electronic TEXT,
  password TEXT,
  adreca TEXT,
  poblacio TEXT,
  Codi_postal INTEGER,
  temps_creacio DATETIME
);

CREATE TABLE IF NOT EXISTS category (
  id INTEGER PRIMARY KEY,
  nom TEXT
);

CREATE TABLE IF NOT EXISTS product (
  id INTEGER PRIMARY KEY,
  id_category INTEGER,
  nom TEXT,
  preu DECIMAL,
  imatge TEXT,
  descripcio TEXT,
  FOREIGN KEY (id_category) REFERENCES category(id)
);

CREATE TABLE IF NOT EXISTS orders (
  id INTEGER PRIMARY KEY,
  user_id INTEGER,
  order_date DATETIME,
  FOREIGN KEY (user_id) REFERENCES usuaris(id)
);

CREATE TABLE IF NOT EXISTS order_items (
  id INTEGER PRIMARY KEY,
  order_id INTEGER,
  product_id INTEGER,
  quantity INTEGER,
  total_price DECIMAL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Carga de datos
INSERT INTO category (id, nom) VALUES
  (1, 'Chanclas'),
  (2, 'Deportivas'),
  (3, 'Botas'),
  (4, 'Montaña'),
  (5, 'Zapatillas de casa'),
  (6, 'Zapatos de vestir');

INSERT INTO product (id, id_category, nom, preu, imatge, descripcio) VALUES
  (1, 1, 'Pier One', 18.99, 'https://img01.ztat.net/article/spp-media-p1/5a1a57558c5b46b9abc882216af4258e/3c4e3137afcb4ab7a67ed12eeb98e0ed.jpg?imwidth=1800&filter=packshot', 'Sandalias planas de fibra sintética con punta abierta.'),
  (2, 1, 'ADILETTE AQUA UNISEX', 24.95, 'https://img01.ztat.net/article/spp-media-p1/454770fa9d794f1ea5bdf7df33dd4273/8df1b82aa82945609b8db7fab6dfa714.jpg?imwidth=762&filter=packshot', 'Chanclas de fibra sintética unisex.'),
  (3, 1, 'MELLOW SLIDE', 49.99, 'https://img01.ztat.net/article/spp-media-p1/fc2e06d0fdd04568bea9bb511c1e2e24/ad9e360f23e24c308f9d6d3046e925d9.jpg?imwidth=762&filter=packshot', 'Chanclas de Croc sintéticas de diseño.'),
  (4, 2, 'ENERGEN LUX', 30, 'https://img01.ztat.net/article/spp-media-p1/d3e8e6d91667495fa6827d6193e13d92/8a7fc7fe593f4d6abcd76f74eb310137.jpg?imwidth=1800&filter=packshot', 'Zapatillas deportivas para running de piel.'),
  (5, 2, 'TOP SALA COMPETITION', 74.95, 'https://img01.ztat.net/article/spp-media-p1/fc5958f5b635414db5d2ee2656b877cc/fc2f6cf637194d6889d9a27b2e3a2fb8.jpg?imwidth=1800&filter=packshot', 'Zapatillas de fútbol sala de cuero duro.'),
  (6, 3, 'MYLAH BOOTS BOOTIE', 6, 'https://img01.ztat.net/article/spp-media-p1/eb9ed6a86a26429db36226cf00bfceb2/105aa82054e34fe5a8a61e6ac8ea135f.jpg?imwidth=1800', 'Botines de piel con puntera redonda.'),
  (7, 3, 'KITTEN HEEL BOOTS', 775, 'https://img01.ztat.net/article/spp-media-p1/13303f56111f456282945c67e76d038e/73c2bd42445842da88e24031236212b5.jpg?imwidth=1800&filter=packshot', 'Botas de lujo con cordones sin restock.'),
  (8, 4, 'PREDICT HIKE MID GTX', 144, 'https://img01.ztat.net/article/spp-media-p1/17f495f4ccd940a4adbea8be62a99faf/a44784bb4c974f22aa8a8df53309fcde.jpg?imwidth=1800&filter=packshot', 'Zapatos de senderismo de tela muy cómodas.'),
  (9, 4, 'JAGUAR WOMENS', 59.45, 'https://img01.ztat.net/article/spp-media-p1/5390a531559a3ce0ac86df2b451c3d9b/6a72738c7144467b8b754baa50efae18.jpg?imwidth=1800&filter=packshot', 'Zapatos de senderismo básicas de puntera redonda y suela adherente.'),
  (10, 5, 'Anna Field', 19.99, 'https://img01.ztat.net/article/spp-media-p1/a3b3d5d634f042958ca942601b373cfd/4e119c52ad3d4e4ab9dab9f1ad4255a8.jpg?imwidth=1800', 'Pantuflas blancas de tela muy cómodas con relleno cálido.'),
  (11, 5, 'Next', 33, 'https://img01.ztat.net/article/spp-media-p1/29781bea2ffb4f65a988e93eb5b732a0/94cc2249c13f460f9c95938fe666aef5.jpg?imwidth=1800&filter=packshot', 'Pantuflas de cuero velour y fibra acrílica de relleno cálido.'),
  (12, 6, 'Tamaris', 55.95, 'https://img01.ztat.net/article/spp-media-p1/6f8241c2ae5e4664ae1ecc3890642701/104b2027d5f94db6909c2f6af0a3041c.jpg?imwidth=1800', 'Zapatos para vestir con piel de imitación de alta calidad y suela sintética.'),
  (13, 6, 'Anna Field LEATHER', 44.99, 'https://img01.ztat.net/article/spp-media-p1/76d099b16a524f67b91ed1ef94e9f0f2/cf99fa7a790e47a9b52ac4fb8b0ad8ed.jpg?imwidth=1800', 'Zapatos de cuero con fibra de piel sintética especializados para el frío');

INSERT INTO orders (id, user_id, order_date) VALUES
  (1, 1, '2024-01-14 18:34:47.290255+01');

INSERT INTO order_items (id, order_id, product_id, quantity, total_price) VALUES
  (1, 1, 1, 1, 18.99);
