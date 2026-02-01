-- Seed 11: partners logos, deep links, and SEO cleanup

START TRANSACTION;

SET @has_logo_small := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'partners'
      AND COLUMN_NAME = 'logo_small_media_id'
);
SET @sql := IF(@has_logo_small = 0, 'ALTER TABLE partners ADD COLUMN logo_small_media_id int DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_logo_large := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'partners'
      AND COLUMN_NAME = 'logo_large_media_id'
);
SET @sql := IF(@has_logo_large = 0, 'ALTER TABLE partners ADD COLUMN logo_large_media_id int DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS product_partner_links (
    id INT NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    partner_id INT NOT NULL,
    product_url VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_product_partner (product_id, partner_id),
    CONSTRAINT fk_ppl_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    CONSTRAINT fk_ppl_partner FOREIGN KEY (partner_id) REFERENCES partners (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/sissol_small.png','image','image/png',NOW(),NOW());
SET @sissol_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/sissol_large.png','image','image/png',NOW(),NOW());
SET @sissol_large := LAST_INSERT_ID();

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/aenerg_small.png','image','image/png',NOW(),NOW());
SET @aenerg_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/aenerg_large.png','image','image/png',NOW(),NOW());
SET @aenerg_large := LAST_INSERT_ID();

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/petrovich_small.png','image','image/png',NOW(),NOW());
SET @petrovich_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/petrovich_large.png','image','image/png',NOW(),NOW());
SET @petrovich_large := LAST_INSERT_ID();

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/vseinstrumenti_small.png','image','image/png',NOW(),NOW());
SET @vseinstrumenti_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/vseinstrumenti_large.png','image','image/png',NOW(),NOW());
SET @vseinstrumenti_large := LAST_INSERT_ID();

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/avito_small.png','image','image/png',NOW(),NOW());
SET @avito_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/avito_large.png','image','image/png',NOW(),NOW());
SET @avito_large := LAST_INSERT_ID();

INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/smartshop_small.png','image','image/png',NOW(),NOW());
SET @smartshop_small := LAST_INSERT_ID();
INSERT INTO media (path, type, mime, created_at, updated_at) VALUES
    ('/storage/uploads/partners/smartshop_large.png','image','image/png',NOW(),NOW());
SET @smartshop_large := LAST_INSERT_ID();

INSERT INTO partners (id, type, name, city, url, sort_order, is_active, logo_media_id, logo_small_media_id, logo_large_media_id, created_at, updated_at)
VALUES
    (1, 'distributor', 'Системные Решения', 'Смоленск', 'https://sissol.ru', 10, 1, @sissol_small, @sissol_small, @sissol_large, NOW(), NOW()),
    (2, 'distributor', 'Аргумент Энерго', 'Москва', 'https://a-energ.ru', 20, 1, @aenerg_small, @aenerg_small, @aenerg_large, NOW(), NOW()),
    (3, 'marketplace', 'Петрович', NULL, 'https://petrovich.ru', 30, 1, @petrovich_small, @petrovich_small, @petrovich_large, NOW(), NOW()),
    (4, 'marketplace', 'ВсеИнструменты.ру', NULL, 'https://vseinstrumenti.ru', 40, 1, @vseinstrumenti_small, @vseinstrumenti_small, @vseinstrumenti_large, NOW(), NOW()),
    (5, 'marketplace', 'Авито', NULL, 'https://avito.ru', 50, 1, @avito_small, @avito_small, @avito_large, NOW(), NOW()),
    (6, 'marketplace', 'Smart-shop.pro', NULL, 'https://smart-shop.pro', 60, 1, @smartshop_small, @smartshop_small, @smartshop_large, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    type = VALUES(type),
    name = VALUES(name),
    city = VALUES(city),
    url = VALUES(url),
    sort_order = VALUES(sort_order),
    is_active = VALUES(is_active),
    logo_media_id = VALUES(logo_media_id),
    logo_small_media_id = VALUES(logo_small_media_id),
    logo_large_media_id = VALUES(logo_large_media_id),
    updated_at = VALUES(updated_at);

INSERT INTO partner_i18n (partner_id, locale, description, created_at, updated_at)
VALUES
    (1, 'ru', '«Системные Решения» — поставщик и интегратор электротехнической продукции, на сайте представлен ассортимент электротехнических брендов и отдельный раздел по System Power. Компания занимается электрощитовыми решениями и поставками оборудования, фокус на подборе, комплектации и поддержке клиентов. На витрине доступны бренды промышленного сегмента (ABB, DKC и др.), что подтверждает профиль B2B-поставок. Подходит как официальный канал закупки System Power с консультацией и сопровождением.', NOW(), NOW()),
    (1, 'en', 'System Solutions is a supplier and integrator of electrical products. The website showcases electrical brands and a dedicated System Power section. The company focuses on switchgear solutions, equipment supply, selection, and customer support. The assortment includes industrial brands, confirming a B2B profile. Suitable as an official procurement channel with consultation and support.', NOW(), NOW()),
    (2, 'ru', 'Компания занимается поставками электротехнического и светотехнического оборудования, а также электрощитовыми решениями. Указывается возможность изготовления электрощитового оборудования по индивидуальным проектам. Дополнительно заявлены комплексные услуги: доработка проектно-сметной документации, светотехнические расчеты, техсопровождение. Это делает партнера релевантным для B2B-заявок и комплексных поставок.', NOW(), NOW()),
    (2, 'en', 'The company supplies electrical and lighting equipment and switchgear solutions. It reports the ability to manufacture switchgear for custom projects. Additional services include design documentation adjustments, lighting calculations, and technical support. This makes the partner relevant for B2B requests and complex deliveries.', NOW(), NOW()),
    (3, 'ru', 'Строительный торговый дом «Петрович» — крупная российская компания по продаже товаров для строительства, ремонта и обустройства дома. Подходит для закупок через DIY-площадку с логистикой и широким ассортиментом. Как канал продаж дает доступ к аудитории частных мастеров, бригад и корпоративных клиентов.', NOW(), NOW()),
    (3, 'en', 'Petrovich is a large Russian building materials retailer. Suitable for purchases through a DIY platform with logistics and a wide assortment. As a sales channel it provides access to private contractors, crews, and corporate buyers.', NOW(), NOW()),
    (4, 'ru', '«ВсеИнструменты.ру» позиционируется как онлайн-гипермаркет для профессионалов и бизнеса, ориентирован на строительство, производство и сферу услуг. В публичном описании заявлен масштаб каталога (до 2 млн товаров) и упор на сервис и логистику. Подходит как канал B2B-закупок с удобным поиском и поставкой.', NOW(), NOW()),
    (4, 'en', 'Vseinstrumenti.ru is positioned as an online hypermarket for professionals and businesses in construction, manufacturing, and services. Public descriptions highlight a large catalog and a focus on service and logistics. Suitable as a B2B purchasing channel with convenient search and delivery.', NOW(), NOW()),
    (5, 'ru', 'Авито — российская платформа объявлений (товары/услуги/недвижимость/работа), где размещаются как частные лица, так и компании. Канал полезен для охвата спроса и работы с клиентами, которые ищут по объявлениям и предложениям продавцов. Требуется контроль официальных карточек и единый бренд-стиль объявлений.', NOW(), NOW()),
    (5, 'en', 'Avito is a Russian classifieds platform where both individuals and companies list products and services. It is useful for demand capture and for working with customers who search listings and seller offers. Requires control of official listings and consistent brand styling.', NOW(), NOW()),
    (6, 'ru', 'Smart-shop.pro — интернет-магазин электротехнической продукции, ориентирован на оптовые продажи для юрлиц и ИП, заявляет быструю доставку и сервис подбора аналогов. Позиционируется как официальный дистрибьютор электротехнического и инженерного оборудования. Подходит как канал профессиональных закупок.', NOW(), NOW()),
    (6, 'en', 'Smart-shop.pro is an online electrical equipment store focused on wholesale for businesses and entrepreneurs, offering fast delivery and selection of analogs. It positions itself as an official distributor of electrical and engineering equipment. Suitable as a professional procurement channel.', NOW(), NOW())
ON DUPLICATE KEY UPDATE description = VALUES(description), updated_at = VALUES(updated_at);

SET @partner_aenerg := (SELECT id FROM partners WHERE name = 'Аргумент Энерго' LIMIT 1);
INSERT INTO product_partner_links (product_id, partner_id, product_url, is_active)
SELECT p.id, @partner_aenerg, x.url, 1
FROM products p
JOIN (
    SELECT 'SP01-0102' AS sku, 'https://a-energ.ru/lyuk-v-pol-na-2-modulya-sp01-0202-system-power' AS url
    UNION ALL SELECT 'SP01-0104', 'https://a-energ.ru/lyuk-v-pol-na-2-modulya-sp01-0204-system-power'
) x ON x.sku = p.sku
ON DUPLICATE KEY UPDATE product_url = VALUES(product_url), is_active = 1;

UPDATE product_i18n
SET description = REPLACE(REPLACE(description, 'Аргумент Энерго', ''), 'a-energ', ''),
    short_description = REPLACE(REPLACE(short_description, 'Аргумент Энерго', ''), 'a-energ', '');

UPDATE seo_meta
SET title = REPLACE(REPLACE(title, 'Аргумент Энерго', 'System Power'), 'a-energ', 'System Power'),
    description = REPLACE(REPLACE(description, 'Аргумент Энерго', 'System Power'), 'a-energ', 'System Power'),
    h1 = REPLACE(REPLACE(h1, 'Аргумент Энерго', 'System Power'), 'a-energ', 'System Power')
WHERE entity_type IN ('product', 'category', 'page');

INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('product.where_buy', 'ru', 'Где купить?', 0),
    ('product.where_buy', 'en', 'Where to buy?', 0),
    ('carousel.prev', 'ru', 'Предыдущие партнёры', 0),
    ('carousel.prev', 'en', 'Previous partners', 0),
    ('carousel.next', 'ru', 'Следующие партнёры', 0),
    ('carousel.next', 'en', 'Next partners', 0),
    ('admin.nav_partner_links', 'ru', 'Ссылки товаров', 0),
    ('admin.partner_links_title', 'ru', 'Ссылки товаров у партнёров', 0),
    ('admin.partner_links_create', 'ru', 'Добавить ссылку товара', 0),
    ('admin.partner_links_edit', 'ru', 'Редактировать ссылку товара', 0),
    ('admin.partner_logo_small', 'ru', 'Логотип (малый)', 0),
    ('admin.partner_logo_large', 'ru', 'Логотип (большой)', 0),
    ('admin.partner_product_url', 'ru', 'Ссылка на товар у партнёра', 0),
    ('admin.product', 'ru', 'Товар', 0)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

COMMIT;
