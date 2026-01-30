-- Documentation page blocks
SET @docs_id = (SELECT id FROM pages WHERE slug = 'documentation' LIMIT 1);
DELETE FROM page_blocks WHERE page_id = @docs_id;

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(@docs_id,'ru','documentation','Документация','Общие документы бренда и документы по изделиям собраны в одном разделе.',1),
(@docs_id,'en','documentation','Documentation','Brand documents and product documentation are collected here.',1);

-- Where to buy page blocks
SET @where_id = (SELECT id FROM pages WHERE slug = 'where-to-buy' LIMIT 1);
DELETE FROM page_blocks WHERE page_id = @where_id;

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(@where_id,'ru','partners','Партнёры','Официальные дистрибьюторы и маркетплейс-канал для закупок System Power.',1),
(@where_id,'en','partners','Partners','Official distributors and a marketplace channel for System Power.',1);

-- Contacts page blocks
SET @contacts_id = (SELECT id FROM pages WHERE slug = 'contacts' LIMIT 1);
DELETE FROM page_blocks WHERE page_id = @contacts_id;

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(@contacts_id,'ru','contact-details','Контакты','Свяжитесь с нами по вопросам продукции и документации.',1),
(@contacts_id,'en','contact-details','Contacts','Get in touch for product and documentation requests.',1);

-- Site settings updates
INSERT INTO site_settings (language, `key`, `value`) VALUES
('ru','footer_contacts','Email: teh@sissol.ru\nТелефон: +7 (4812) 54-82-55\nАдрес: ул. Тенишевой 15, Смоленск, Россия'),
('en','footer_contacts','Email: teh@sissol.ru\nPhone: +7 (4812) 54-82-55\nAddress: 15 Tenisheva St, Smolensk, Russia'),
('ru','hero_title','System Power — инженерные решения для электроснабжения'),
('ru','hero_subtitle','Новый бренд, за которым стоит команда с практическим опытом в электротехнике и эксплуатации объектов.'),
('ru','hero_cta_primary_label','Каталог продукции'),
('ru','hero_cta_primary_url','/ru/products/'),
('ru','hero_cta_secondary_label','Где купить'),
('ru','hero_cta_secondary_url','/ru/where-to-buy/'),
('en','hero_title','System Power — engineered solutions for power supply'),
('en','hero_subtitle','A new brand backed by a team with hands-on experience in electrical engineering and field operations.'),
('en','hero_cta_primary_label','Product catalog'),
('en','hero_cta_primary_url','/en/products/'),
('en','hero_cta_secondary_label','Where to buy'),
('en','hero_cta_secondary_url','/en/where-to-buy/'),
('ru','hero_video_autoplay','1'),
('en','hero_video_autoplay','1')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

-- Partners data
DELETE FROM partner_translations;
DELETE FROM partners;

INSERT INTO partners (id, type, url, logo_path, city, lat, lng, is_active, sort_order) VALUES
(1,'official_distributor','https://argument-energo.ru','','Москва',55.630141,37.474453,1,1),
(2,'official_distributor','https://sissol.ru','', 'Смоленск',54.774769,32.055806,1,2),
(3,'marketplace','https://www.vseinstrumenti.ru','', '',NULL,NULL,1,3);

INSERT INTO partner_translations (partner_id, language, name, description) VALUES
(1,'ru','Аргумент Энерго','Аргумент Энерго специализируется на поставках электротехнической продукции через интернет и для объектов и монтажных организаций.'),
(1,'en','Argument Energo','Argument Energo delivers electrical products for online procurement and project supply to installation companies.'),
(2,'ru','ООО «Системные Решения»','ООО «Системные Решения» работает в сфере электроснабжения и электроосвещения более 10 лет. Решения формируются на продукции проверенных торговых марок и поставляются на основании прямых дистрибьюторских контрактов, что позволяет подтверждать происхождение и качество и соблюдать гарантийные обязательства. Компания ориентирована не только на продажу, но и на подбор оптимального решения под задачу. География проектов включает регионы России и страны ЕАЭС.'),
(2,'en','Systemnye Resheniya LLC','Systemnye Resheniya has 10+ years of experience in power supply and lighting. Solutions are built on verified brands and direct distributor contracts, enabling guaranteed origin and quality. The company focuses on both sales and project-specific selection across Russia and the EAEU.'),
(3,'ru','ВсеИнструменты','Маркетплейс, которому доверяют миллионы.'),
(3,'en','VseInstrumenty','Marketplace trusted by millions.');

DELETE FROM product_partners;

INSERT INTO product_partners (product_id, partner_id, sort_order) VALUES
((SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),1,0),
((SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),2,1),
((SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),3,2);

-- Documents data
DELETE FROM document_products;
DELETE FROM documents;

INSERT INTO documents (id, scope, language, title, file_path, doc_type, sort_order, is_active) VALUES
(1,'brand','ru','Технические условия','/storage/uploads/system-power-tu.pdf','ТУ',1,1),
(2,'brand','ru','Свидетельство о регистрации','/storage/uploads/system-power-registration.pdf','Регистрация',2,1),
(3,'brand','ru','Товарный знак System Power','/storage/uploads/system-power-trademark.pdf','Товарный знак',3,1),
(4,'brand','ru','Бренд-бук System Power','/storage/uploads/system-power-brandbook.pdf','Бренд-бук',4,1),
(5,'brand','en','Technical specifications','/storage/uploads/system-power-tu.pdf','TU',1,1),
(6,'brand','en','Registration certificate','/storage/uploads/system-power-registration.pdf','Registration',2,1),
(7,'brand','en','System Power trademark','/storage/uploads/system-power-trademark.pdf','Trademark',3,1),
(8,'brand','en','System Power brand book','/storage/uploads/system-power-brandbook.pdf','Brand book',4,1),
(9,'product','ru','Паспорт изделия','/storage/uploads/passport-sp01-0212.pdf','',1,1),
(10,'product','ru','Инструкция по монтажу и эксплуатации','/storage/uploads/manual-sp01-0212.pdf','',2,1),
(11,'product','ru','Схема электрическая','/storage/uploads/scheme-sp01-0212.pdf','',3,1),
(12,'product','en','Product passport','/storage/uploads/passport-sp01-0212.pdf','',1,1),
(13,'product','en','Installation and operation manual','/storage/uploads/manual-sp01-0212.pdf','',2,1),
(14,'product','en','Electrical diagram','/storage/uploads/scheme-sp01-0212.pdf','',3,1);

INSERT INTO document_products (document_id, product_id, sort_order) VALUES
(9,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),1),
(10,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),2),
(11,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),3),
(12,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),1),
(13,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),2),
(14,(SELECT id FROM products WHERE sku = 'SP01-0212' LIMIT 1),3);
