-- Seed updates for System Power UI refresh

CREATE TABLE IF NOT EXISTS partners (
  id int NOT NULL AUTO_INCREMENT,
  type varchar(40) NOT NULL DEFAULT 'official_distributor',
  url varchar(255) NOT NULL,
  logo_path varchar(255) NOT NULL DEFAULT '',
  city varchar(190) NOT NULL DEFAULT '',
  lat decimal(10,6) DEFAULT NULL,
  lng decimal(10,6) DEFAULT NULL,
  is_active tinyint(1) NOT NULL DEFAULT '1',
  sort_order int NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS partner_translations (
  id int NOT NULL AUTO_INCREMENT,
  partner_id int NOT NULL,
  language varchar(10) NOT NULL,
  name varchar(255) NOT NULL,
  description text NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY unique_partner_translation (partner_id, language),
  CONSTRAINT partner_translations_ibfk_1 FOREIGN KEY (partner_id) REFERENCES partners (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_partners (
  product_id int NOT NULL,
  partner_id int NOT NULL,
  sort_order int NOT NULL DEFAULT '0',
  PRIMARY KEY (product_id, partner_id),
  CONSTRAINT product_partners_ibfk_1 FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
  CONSTRAINT product_partners_ibfk_2 FOREIGN KEY (partner_id) REFERENCES partners (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
  id int NOT NULL AUTO_INCREMENT,
  scope varchar(20) NOT NULL DEFAULT 'brand',
  language varchar(10) NOT NULL,
  title varchar(255) NOT NULL,
  file_path varchar(255) NOT NULL,
  doc_type varchar(190) NOT NULL DEFAULT '',
  sort_order int NOT NULL DEFAULT '0',
  is_active tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS document_products (
  document_id int NOT NULL,
  product_id int NOT NULL,
  sort_order int NOT NULL DEFAULT '0',
  PRIMARY KEY (document_id, product_id),
  CONSTRAINT document_products_ibfk_1 FOREIGN KEY (document_id) REFERENCES documents (id) ON DELETE CASCADE,
  CONSTRAINT document_products_ibfk_2 FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Navigation update
DELETE FROM navigation_items;
INSERT INTO navigation_items (language, label, url, sort_order) VALUES
('ru','Продукция','/ru/products/',1),
('ru','О бренде','/ru/about/',2),
('ru','Производство и качество','/ru/manufacturing/',3),
('ru','Документация','/ru/documentation/',4),
('ru','Где купить','/ru/where-to-buy/',5),
('ru','Контакты','/ru/contacts/',6),
('en','Products','/en/products/',1),
('en','About','/en/about/',2),
('en','Manufacturing & Quality','/en/manufacturing/',3),
('en','Documentation','/en/documentation/',4),
('en','Where to buy','/en/where-to-buy/',5),
('en','Contacts','/en/contacts/',6);

-- Update page translations for contacts and where-to-buy (remove custom HTML)
UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.custom_html = ''
WHERE p.slug IN ('contacts', 'where-to-buy');

-- Update manufacturing page titles
UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Производство и качество',
    pt.h1 = 'Производство и качество',
    pt.meta_title = 'Производство и качество',
    pt.meta_description = 'Производство System Power построено на контролируемых процессах качества и управлении рисками.'
WHERE p.slug = 'manufacturing' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Manufacturing & Quality',
    pt.h1 = 'Manufacturing & Quality',
    pt.meta_title = 'Manufacturing & Quality',
    pt.meta_description = 'System Power manufacturing follows controlled quality processes and risk management.'
WHERE p.slug = 'manufacturing' AND pt.language = 'en';

-- Update documentation page title
UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Документация',
    pt.h1 = 'Документация',
    pt.meta_title = 'Документация',
    pt.meta_description = 'Документы бренда System Power и документы по изделиям.'
WHERE p.slug = 'documentation' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Documentation',
    pt.h1 = 'Documentation',
    pt.meta_title = 'Documentation',
    pt.meta_description = 'Brand documents and product documentation for System Power.'
WHERE p.slug = 'documentation' AND pt.language = 'en';

-- Home page blocks
SET @home_id = (SELECT id FROM pages WHERE slug = 'home' LIMIT 1);
DELETE FROM page_blocks WHERE page_id = @home_id;
INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(@home_id,'ru','hero','System Power — инженерные решения для электроснабжения','Новый бренд, за которым стоит команда с практическим опытом в электротехнике и эксплуатации объектов.',1),
(@home_id,'ru','order','Заказ и сопровождение','Выберите подходящий формат — серийное изделие или индивидуальное исполнение.',2),
(@home_id,'ru','brand','О бренде','System Power — это бренд с короткой и понятной логикой продукта: стабильные исполнения, предсказуемые характеристики и корректная документация. Команда за брендом имеет опыт подбора и применения электротехнических решений на объектах энергетики, строительства и промышленности.',3),
(@home_id,'ru','categories','Направления продукции','Два направления продукции с прозрачными характеристиками и документацией.',4),
(@home_id,'ru','production','Качество — управляемый процесс','В производстве и продажах мы используем три базовых подхода международных стандартов.',5),
(@home_id,'ru','certificates','Документы','Общие документы бренда (ТУ, регистрации, товарный знак, бренд-бук) доступны в разделе документации. Документы по изделию — в карточке соответствующего товара.',6),
(@home_id,'ru','where-to-buy','Где купить','Продукция доступна через официальных дистрибьюторов и маркетплейс-канал.',7),
(@home_id,'ru','support','Контакты','Email · телефон · адрес. Мы отвечаем на запросы по продукции и документам.',8),
(@home_id,'en','hero','System Power — engineered solutions for power supply','A new brand backed by a team with hands-on experience in electrical engineering and field operations.',1),
(@home_id,'en','order','Order & support','Choose the right format — serial product or custom execution.',2),
(@home_id,'en','brand','About','System Power is a brand with a clear product logic: stable configurations, predictable specifications, and correct documentation. The team behind the brand has experience in applying electrical solutions in energy, construction, and industrial facilities.',3),
(@home_id,'en','categories','Product directions','Two product directions with clear specifications and documentation.',4),
(@home_id,'en','production','Quality is a managed process','We apply three baseline approaches based on international standards in manufacturing and sales.',5),
(@home_id,'en','certificates','Documentation','Brand documents (specifications, registrations, trademark, brand book) are available in the documentation section. Product documents are on the relevant product page.',6),
(@home_id,'en','where-to-buy','Where to buy','Products are available through official distributors and a marketplace channel.',7),
(@home_id,'en','support','Contacts','Email · phone · address. We respond to product and documentation requests.',8);

-- Documentation page blocks
SET @docs_id = (SELECT id FROM pages WHERE slug = 'documentation' LIMIT 1);
DELETE FROM page_blocks WHERE page_id = @docs_id;
INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(@docs_id,'ru','documentation','Документация','Общие документы бренда и документы по изделиям собраны в одном разделе.'),
(@docs_id,'en','documentation','Documentation','Brand documents and product documentation are collected here.');

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
(1,'official_distributor','https://argument-energo.ru','', 'Москва',55.630141,37.474453,1,1),
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

-- Translations update
INSERT INTO translations (language, `key`, `value`) VALUES
('ru','nav.close','Закрыть меню'),
('en','nav.close','Close menu'),
('ru','cta.production','Производство и качество'),
('en','cta.production','Manufacturing & Quality'),
('ru','cta.open','Открыть'),
('en','cta.open','Open'),
('ru','product.purpose_title','Назначение'),
('en','product.purpose_title','Purpose'),
('ru','product.kit_title','Комплектация'),
('en','product.kit_title','Package contents'),
('ru','product.kit_text','Комплектация зависит от исполнения изделия. Уточните состав по карточке модели или у партнёра.'),
('en','product.kit_text','Package contents depend on the configuration. Check the product card or ask a partner for the exact set.'),
('ru','order.title','Заказ и сопровождение'),
('en','order.title','Order & support'),
('ru','order.description','Выберите подходящий формат — серийное изделие или индивидуальное исполнение.'),
('en','order.description','Choose the right format — serial product or custom execution.'),
('ru','order.series_title','Серийное изделие по наличию'),
('en','order.series_title','Serial product in stock'),
('ru','order.series_text','Выберите серийное изделие из каталога и оформите заказ у партнёра. Вы получите стандартную комплектацию и документы, предусмотренные для модели.'),
('en','order.series_text','Choose a serial product from the catalog and place an order through a partner. You will receive the standard configuration and model documentation.'),
('ru','order.custom_title','Индивидуальное исполнение под требования проекта'),
('en','order.custom_title','Custom execution for project requirements'),
('ru','order.custom_text','Обратитесь к одному из партнёров для оформления заказа и проектного сопровождения. По вашим параметрам будет подготовлено индивидуальное предложение под объём и сроки.'),
('en','order.custom_text','Contact a partner for order placement and project support. An individual offer will be prepared based on your parameters, volume, and timelines.'),
('ru','order.cta_catalog','К каталогу'),
('en','order.cta_catalog','Go to catalog'),
('ru','order.cta_where','Где купить'),
('en','order.cta_where','Where to buy'),
('ru','categories.rusp.fact1','220/380 В'),
('ru','categories.rusp.fact2','IP54'),
('ru','categories.rusp.fact3','типовые конфигурации выходов'),
('ru','categories.rusp.fact4','документация в карточке модели'),
('en','categories.rusp.fact1','230/400 V'),
('en','categories.rusp.fact2','IP54'),
('en','categories.rusp.fact3','typical output configurations'),
('en','categories.rusp.fact4','documentation on the model page'),
('ru','categories.floor.fact1','сталь'),
('ru','categories.floor.fact2','вводы M25'),
('ru','categories.floor.fact3','модульность 45×45'),
('ru','categories.floor.fact4','серии IP41/IP54'),
('en','categories.floor.fact1','steel'),
('en','categories.floor.fact2','M25 entries'),
('en','categories.floor.fact3','45×45 modularity'),
('en','categories.floor.fact4','IP41/IP54 series'),
('ru','iso.9001.code','ISO 9001:2015'),
('ru','iso.9001.title','Quality Management Systems'),
('ru','iso.9001.text','Фиксируем требования к изделию, контролируем входящие комплектующие, контролируем сборку и маркировку, ведём записи проверок и корректирующие действия при отклонениях.'),
('ru','iso.14001.code','ISO 14001:2015'),
('ru','iso.14001.title','Environmental Management Systems'),
('ru','iso.14001.text','Контролируем обращение с отходами и упаковкой, выбираем материалы и процессы с учётом жизненного цикла, фиксируем экологические аспекты в дисциплине производства.'),
('ru','iso.45001.code','ISO 45001:2018'),
('ru','iso.45001.title','Occupational Health & Safety Management Systems'),
('ru','iso.45001.text','Оценка рисков работ, регламенты безопасности, допуски и обучение, предотвращение инцидентов и расследование причин.'),
('en','iso.9001.code','ISO 9001:2015'),
('en','iso.9001.title','Quality Management Systems'),
('en','iso.9001.text','We document product requirements, control incoming components, verify assembly and marking, and keep records with corrective actions for deviations.'),
('en','iso.14001.code','ISO 14001:2015'),
('en','iso.14001.title','Environmental Management Systems'),
('en','iso.14001.text','We control waste and packaging, choose materials and processes based on life-cycle thinking, and record environmental aspects in production discipline.'),
('en','iso.45001.code','ISO 45001:2018'),
('en','iso.45001.title','Occupational Health & Safety Management Systems'),
('en','iso.45001.text','Risk assessment, safety regulations, permits and training, incident prevention and root-cause investigations.'),
('ru','partners.filter_all','Все'),
('ru','partners.filter_official','Официальный дистрибьютор'),
('ru','partners.filter_marketplace','Маркетплейс'),
('en','partners.filter_all','All'),
('en','partners.filter_official','Official distributor'),
('en','partners.filter_marketplace','Marketplace'),
('ru','partner.type.official_distributor','Официальный дистрибьютор'),
('ru','partner.type.marketplace','Маркетплейс'),
('en','partner.type.official_distributor','Official distributor'),
('en','partner.type.marketplace','Marketplace'),
('ru','partners.empty','Партнёры будут добавлены в ближайшее время.'),
('en','partners.empty','Partners will be added soon.'),
('ru','contacts.email_label','Email'),
('ru','contacts.email_value','teh@sissol.ru'),
('ru','contacts.phone_label','Телефон'),
('ru','contacts.phone_value','+7 (4812) 54-82-55'),
('ru','contacts.address_label','Адрес'),
('ru','contacts.address_value','ул. Тенишевой 15, Смоленск, Россия'),
('ru','contacts.legal_label','Юридическое лицо'),
('ru','contacts.legal_text','ООО «Системные Решения»'),
('en','contacts.email_label','Email'),
('en','contacts.email_value','teh@sissol.ru'),
('en','contacts.phone_label','Phone'),
('en','contacts.phone_value','+7 (4812) 54-82-55'),
('en','contacts.address_label','Address'),
('en','contacts.address_value','15 Tenisheva St, Smolensk, Russia'),
('en','contacts.legal_label','Legal entity'),
('en','contacts.legal_text','Systemnye Resheniya LLC'),
('ru','documents.type.default','Документ'),
('en','documents.type.default','Document'),
('ru','admin.nav_partners','Партнёры'),
('en','admin.nav_partners','Partners'),
('ru','admin.nav_documents','Документы'),
('en','admin.nav_documents','Documents'),
('ru','admin.nav_import','Импорт товаров'),
('en','admin.nav_import','Product import'),
('ru','admin.nav_home_hero','Главная (Hero)'),
('en','admin.nav_home_hero','Home hero'),
('ru','admin.partners_title','Партнёры'),
('en','admin.partners_title','Partners'),
('ru','admin.partner_create_title','Создание партнёра'),
('en','admin.partner_create_title','Create partner'),
('ru','admin.partner_edit_title','Редактирование партнёра'),
('en','admin.partner_edit_title','Edit partner'),
('ru','admin.partner_name','Название'),
('en','admin.partner_name','Name'),
('ru','admin.partner_description','Описание'),
('en','admin.partner_description','Description'),
('ru','admin.partner_type','Тип'),
('en','admin.partner_type','Type'),
('ru','admin.partner_url','URL'),
('en','admin.partner_url','URL'),
('ru','admin.partner_city','Город'),
('en','admin.partner_city','City'),
('ru','admin.partner_coordinates','Координаты'),
('en','admin.partner_coordinates','Coordinates'),
('ru','admin.partner_logo','Логотип'),
('en','admin.partner_logo','Logo'),
('ru','admin.partner_active','Активен'),
('en','admin.partner_active','Active'),
('ru','admin.documents_title','Документы'),
('en','admin.documents_title','Documents'),
('ru','admin.document_create_title','Создание документа'),
('en','admin.document_create_title','Create document'),
('ru','admin.document_edit_title','Редактирование документа'),
('en','admin.document_edit_title','Edit document'),
('ru','admin.document_scope','Тип документа'),
('en','admin.document_scope','Document scope'),
('ru','admin.document_scope_brand','Документы бренда'),
('en','admin.document_scope_brand','Brand documents'),
('ru','admin.document_scope_product','Документы товара'),
('en','admin.document_scope_product','Product documents'),
('ru','admin.document_title','Название документа'),
('en','admin.document_title','Document title'),
('ru','admin.document_type','Тип/категория'),
('en','admin.document_type','Type/category'),
('ru','admin.document_file','Файл'),
('en','admin.document_file','File'),
('ru','admin.document_active','Активен'),
('en','admin.document_active','Active'),
('ru','admin.home_hero_title','Hero главной страницы'),
('en','admin.home_hero_title','Home hero'),
('ru','admin.hero_video','Видео (mp4/webm)'),
('en','admin.hero_video','Video (mp4/webm)'),
('ru','admin.hero_poster','Постер'),
('en','admin.hero_poster','Poster'),
('ru','admin.hero_autoplay','Автовоспроизведение (muted loop)'),
('en','admin.hero_autoplay','Autoplay (muted loop)'),
('ru','admin.hero_title_label','Заголовок'),
('en','admin.hero_title_label','Title'),
('ru','admin.hero_subtitle_label','Подзаголовок'),
('en','admin.hero_subtitle_label','Subtitle'),
('ru','admin.hero_primary_cta','Primary CTA'),
('en','admin.hero_primary_cta','Primary CTA'),
('ru','admin.hero_secondary_cta','Secondary CTA'),
('en','admin.hero_secondary_cta','Secondary CTA'),
('ru','admin.hero_cta_label','Текст'),
('en','admin.hero_cta_label','Label'),
('ru','admin.import_title','Импорт товаров'),
('en','admin.import_title','Product import'),
('ru','admin.import_upload','Загрузка CSV/XLSX'),
('en','admin.import_upload','Upload CSV/XLSX'),
('ru','admin.import_preview','Показать предпросмотр'),
('en','admin.import_preview','Show preview'),
('ru','admin.import_mode','Режим импорта'),
('en','admin.import_mode','Import mode'),
('ru','admin.import_mode_create','Создать новые'),
('en','admin.import_mode_create','Create new'),
('ru','admin.import_mode_update','Обновить по SKU'),
('en','admin.import_mode_update','Update by SKU'),
('ru','admin.import_mode_skip','Пропустить если SKU уже есть'),
('en','admin.import_mode_skip','Skip if SKU exists'),
('ru','admin.import_map_title','Маппинг колонок'),
('en','admin.import_map_title','Column mapping'),
('ru','admin.import_preview_title','Предпросмотр 20 строк'),
('en','admin.import_preview_title','Preview 20 rows'),
('ru','admin.import_start','Запустить импорт'),
('en','admin.import_start','Run import'),
('ru','admin.import_result','Результат импорта'),
('en','admin.import_result','Import result'),
('ru','admin.import_created','Создано'),
('en','admin.import_created','Created'),
('ru','admin.import_updated','Обновлено'),
('en','admin.import_updated','Updated'),
('ru','admin.import_skipped','Пропущено'),
('en','admin.import_skipped','Skipped'),
('ru','admin.import_errors','Ошибки'),
('en','admin.import_errors','Errors'),
('ru','admin.product_partners','Партнёры для товара'),
('en','admin.product_partners','Product partners'),
('ru','admin.product_documents','Документы товара'),
('en','admin.product_documents','Product documents')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);
