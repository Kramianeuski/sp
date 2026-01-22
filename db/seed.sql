-- System Power initial schema and content

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS product_documents;
DROP TABLE IF EXISTS product_specs;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS product_translations;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS category_highlights;
DROP TABLE IF EXISTS category_translations;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS page_block_translations;
DROP TABLE IF EXISTS page_blocks;
DROP TABLE IF EXISTS page_translations;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS partners;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lang VARCHAR(5) NOT NULL,
    setting_key VARCHAR(64) NOT NULL,
    setting_value TEXT NOT NULL,
    UNIQUE KEY settings_lang_key (lang, setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(64) NOT NULL UNIQUE,
    nav_order INT UNSIGNED NOT NULL DEFAULT 0,
    show_in_nav TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE page_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    seo_title VARCHAR(255) NOT NULL,
    seo_description TEXT NOT NULL,
    seo_canonical VARCHAR(255) NOT NULL,
    seo_robots VARCHAR(64) NOT NULL,
    UNIQUE KEY page_lang (page_id, lang),
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE page_blocks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id INT UNSIGNED NOT NULL,
    block_type VARCHAR(32) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE page_block_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    block_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    cta_label VARCHAR(128) NOT NULL,
    cta_url VARCHAR(255) NOT NULL,
    UNIQUE KEY block_lang (block_id, lang),
    FOREIGN KEY (block_id) REFERENCES page_blocks(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(64) NOT NULL UNIQUE,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE category_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    seo_title VARCHAR(255) NOT NULL,
    seo_description TEXT NOT NULL,
    seo_robots VARCHAR(64) NOT NULL,
    UNIQUE KEY category_lang (category_id, lang),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE category_highlights (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    slug VARCHAR(128) NOT NULL UNIQUE,
    sku VARCHAR(64) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE product_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    short_description TEXT NOT NULL,
    description TEXT NOT NULL,
    seo_title VARCHAR(255) NOT NULL,
    seo_description TEXT NOT NULL,
    seo_robots VARCHAR(64) NOT NULL,
    UNIQUE KEY product_lang (product_id, lang),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE product_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    url VARCHAR(255) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE product_specs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    label VARCHAR(255) NOT NULL,
    value VARCHAR(255) NOT NULL,
    value_type VARCHAR(32) NOT NULL,
    unit VARCHAR(32) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE product_documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    entity_type VARCHAR(32) NOT NULL,
    entity_id INT UNSIGNED NOT NULL,
    lang VARCHAR(5) NOT NULL,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE partners (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    rel_attr VARCHAR(255) NOT NULL,
    logo_url VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    is_primary TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (username, password_hash)
VALUES ('admin', '$2y$12$hgZCLUEI/FxQ/gMgcAraG.oMi4KCzoC4x59k17yAEj4rd.dpT32Om');

INSERT INTO settings (lang, setting_key, setting_value) VALUES
('ru', 'site_name', 'System Power'),
('ru', 'brand_name', 'System Power'),
('ru', 'site_url', 'https://system-power.example'),
('ru', 'logo_text', 'System Power'),
('ru', 'partner_title', 'Официальный продавец'),
('ru', 'partner_cta', 'Перейти на сайт sissol.ru'),
('ru', 'specs_title', 'Характеристики'),
('ru', 'docs_title', 'Документация'),
('ru', 'faq_title', 'FAQ'),
('ru', 'footer_text', 'Официальный бренд-портал производителя System Power.'),
('ru', 'contact_text', 'Контакты и реквизиты предоставляются официальным продавцом.'),
('ru', 'not_found_title', 'Страница не найдена'),
('ru', 'not_found_text', 'Запрошенная страница не найдена или недоступна.'),
('en', 'site_name', 'System Power'),
('en', 'brand_name', 'System Power'),
('en', 'site_url', 'https://system-power.example'),
('en', 'logo_text', 'System Power'),
('en', 'partner_title', 'Official distributor'),
('en', 'partner_cta', 'Go to sissol.ru'),
('en', 'specs_title', 'Specifications'),
('en', 'docs_title', 'Documentation'),
('en', 'faq_title', 'FAQ'),
('en', 'footer_text', 'Official brand portal of System Power.'),
('en', 'contact_text', 'Contacts and legal details are provided by the official distributor.'),
('en', 'not_found_title', 'Page not found'),
('en', 'not_found_text', 'The requested page was not found or is unavailable.');

INSERT INTO pages (slug, nav_order, show_in_nav) VALUES
('home', 1, 1),
('products', 2, 1),
('where-to-buy', 3, 1),
('about', 4, 1),
('manufacturing', 5, 1),
('documentation', 6, 1),
('support', 7, 1),
('contacts', 8, 1);

INSERT INTO page_translations (page_id, lang, title, h1, body, seo_title, seo_description, seo_canonical, seo_robots) VALUES
(1, 'ru', 'System Power', 'System Power — электротехническое оборудование для инженерных систем', 'Производство и сборка электротехнических изделий для распределения электропитания и организации точек подключения в зданиях и технических зонах.\nПродукция выпускается с локальной сборкой в России и применяется в системах временного и стационарного электроснабжения.', 'System Power — официальный бренд', 'System Power — официальный бренд-портал производителя электротехнического оборудования.', '/ru/', 'index, follow'),
(1, 'en', 'System Power', 'System Power — electrical equipment for engineering systems', 'Manufacturing and assembly of electrical equipment for power distribution and connection points in buildings and technical areas.\nProducts are locally assembled in Russia and used in temporary and permanent power supply systems.', 'System Power — official brand', 'System Power official brand portal for electrical engineering equipment.', '/en/', 'index, follow'),
(2, 'ru', 'Продукция', 'Каталог продукции', 'Категории электротехнической продукции System Power.', 'Каталог продукции System Power', 'Каталог продукции System Power для инженерных систем.', '/ru/products/', 'index, follow'),
(2, 'en', 'Products', 'Product catalog', 'System Power electrical product categories.', 'System Power products', 'System Power product catalog for engineering systems.', '/en/products/', 'index, follow'),
(3, 'ru', 'Где приобрести', 'Где приобрести', 'Продукция System Power поставляется через партнёров и дистрибьюторов. Доступность зависит от региона.', 'Где приобрести System Power', 'Партнёры и поставщики продукции System Power.', '/ru/where-to-buy/', 'index, follow'),
(3, 'en', 'Where to buy', 'Where to buy', 'System Power products are supplied through partners and distributors. Availability depends on region.', 'Where to buy System Power', 'Partners and distributors for System Power products.', '/en/where-to-buy/', 'index, follow'),
(4, 'ru', 'О бренде', 'System Power — производитель электротехнического оборудования', 'System Power разрабатывает и выпускает электротехнические изделия для инженерных систем зданий.\nАссортимент включает щиты механизации и напольные лючки для скрытой установки электрики.', 'О бренде System Power', 'System Power — производитель электротехнического оборудования.', '/ru/about/', 'index, follow'),
(4, 'en', 'About', 'System Power — manufacturer of electrical equipment', 'System Power develops and produces electrical equipment for engineering systems.\nThe range includes distribution boards and floor boxes for hidden installation.', 'About System Power', 'System Power is a manufacturer of electrical equipment.', '/en/about/', 'index, follow'),
(5, 'ru', 'Производство', 'Локальная сборка и контроль параметров изделий', 'Производственный процесс включает сборку изделий на территории Российской Федерации с использованием металлических корпусов и компонентов промышленного класса.\nПеред выпуском продукция проходит контроль комплектности, геометрии и маркировки.', 'Производство System Power', 'Локальная сборка и контроль качества изделий System Power.', '/ru/manufacturing/', 'index, follow'),
(5, 'en', 'Manufacturing', 'Local assembly and quality control', 'Manufacturing includes assembly in the Russian Federation using metal enclosures and industrial-grade components.\nProducts undergo completeness, geometry, and labeling checks.', 'System Power manufacturing', 'Local assembly and quality control for System Power products.', '/en/manufacturing/', 'index, follow'),
(6, 'ru', 'Документация', 'Техническая документация', 'Паспорта изделий, схемы и декларации соответствия публикуются по каждой модели.', 'Документация System Power', 'Технические документы и паспорта изделий System Power.', '/ru/documentation/', 'index, follow'),
(6, 'en', 'Documentation', 'Technical documentation', 'Product passports, diagrams, and compliance declarations are published per model.', 'System Power documentation', 'Technical documents and passports for System Power products.', '/en/documentation/', 'index, follow'),
(7, 'ru', 'Поддержка', 'Техническая поддержка', 'Поддержка по подбору продукции и документации предоставляется через официального продавца.', 'Поддержка System Power', 'Поддержка по продукции System Power через официального продавца.', '/ru/support/', 'index, follow'),
(7, 'en', 'Support', 'Technical support', 'Support for selection and documentation is provided by the official distributor.', 'System Power support', 'Support for System Power products via the official distributor.', '/en/support/', 'index, follow'),
(8, 'ru', 'Контакты', 'Контакты и реквизиты', 'Контактная информация предоставляется официальным продавцом и партнёрами.', 'Контакты System Power', 'Контакты официального продавца System Power.', '/ru/contacts/', 'index, follow'),
(8, 'en', 'Contacts', 'Contacts and legal details', 'Contact details are provided by the official distributor and partners.', 'System Power contacts', 'Official distributor contacts for System Power.', '/en/contacts/', 'index, follow');

INSERT INTO page_blocks (page_id, block_type, sort_order) VALUES
(1, 'hero_action', 1),
(1, 'hero_action', 2),
(1, 'section', 3),
(1, 'section', 4),
(1, 'section', 5),
(1, 'section', 6),
(1, 'section', 7);

INSERT INTO page_block_translations (block_id, lang, title, body, cta_label, cta_url) VALUES
(1, 'ru', '', '', 'Продукция', '/ru/products/'),
(1, 'en', '', '', 'Products', '/en/products/'),
(2, 'ru', '', '', 'Где приобрести', '/ru/where-to-buy/'),
(2, 'en', '', '', 'Where to buy', '/en/where-to-buy/'),
(3, 'ru', 'System Power — производитель', 'System Power — производитель электротехнической продукции с линейкой электрощитов и напольных лючков для инженерных систем зданий.', '', ''),
(3, 'en', 'System Power — manufacturer', 'System Power manufactures electrical equipment with a range of distribution boards and floor boxes for engineering systems.', '', ''),
(4, 'ru', 'Производство и сборка', 'Сборка продукции System Power осуществляется на территории Российской Федерации. Контроль включает проверку комплектности, геометрических параметров корпусов и маркировки.', '', ''),
(4, 'en', 'Manufacturing and assembly', 'System Power products are assembled in the Russian Federation with completeness, geometry, and labeling checks.', '', ''),
(5, 'ru', 'Категории продукции', 'Две ключевые категории: электрощитовое оборудование и напольные лючки. Каждая модель сопровождается паспортами и техническими документами.', '', ''),
(5, 'en', 'Product categories', 'Two key categories: electrical enclosures and floor boxes. Each model includes technical documentation.', '', ''),
(6, 'ru', 'Где приобрести', 'Официальный продавец продукции System Power — компания SISSOL. Поставки через партнёров и дистрибьюторов.', '', ''),
(6, 'en', 'Where to buy', 'Official distributor of System Power products is SISSOL. Supplies are provided through partners and distributors.', '', ''),
(7, 'ru', 'Сертификаты и доверие', 'Документация и декларации соответствия доступны по запросу для каждой модели.', '', ''),
(7, 'en', 'Certificates and trust', 'Documentation and declarations of conformity are available for each model upon request.', '', '');

INSERT INTO categories (slug, sort_order) VALUES
('electrical-enclosures', 1),
('floor-boxes', 2);

INSERT INTO category_translations (category_id, lang, title, h1, description, seo_title, seo_description, seo_robots) VALUES
(1, 'ru', 'Электрощитовое оборудование', 'Электрощитовое оборудование', 'Электрощитовое оборудование System Power предназначено для распределения и защиты электрических цепей. Категория включает щиты механизации и распределительные шкафы для строительных и промышленных объектов.', 'Электрощитовое оборудование System Power', 'Электрощитовое оборудование для распределения и защиты цепей System Power.', 'index, follow'),
(1, 'en', 'Electrical enclosures', 'Electrical enclosures', 'System Power electrical enclosures distribute and protect power circuits for construction and industrial facilities.', 'System Power electrical enclosures', 'Electrical enclosures for distribution and protection by System Power.', 'index, follow'),
(2, 'ru', 'Лючки напольные', 'Лючки напольные', 'Напольные лючки System Power предназначены для скрытой установки в полу и организации точек подключения электрики и слаботочных систем.', 'Лючки System Power', 'Напольные лючки для инженерных систем System Power.', 'index, follow'),
(2, 'en', 'Floor boxes', 'Floor boxes', 'System Power floor boxes are designed for hidden installation in floors and connection points for electrical and low-voltage systems.', 'System Power floor boxes', 'Floor boxes for engineering systems by System Power.', 'index, follow');

INSERT INTO category_highlights (category_id, lang, title, body, sort_order) VALUES
(2, 'ru', 'Надёжная защита', 'Степень защиты IP54 обеспечивает защиту от пыли и влаги в офисных и коммерческих помещениях.', 1),
(2, 'ru', 'Скрытый монтаж', 'Лючки органично интегрируются в пол и сохраняют эстетику интерьера.', 2),
(2, 'ru', 'Гибкая конфигурация', 'Поддержка модульных решений 45×45 и 22.5×45 мм.', 3),
(2, 'en', 'Reliable protection', 'IP54 protection safeguards from dust and moisture in commercial environments.', 1),
(2, 'en', 'Hidden installation', 'Floor boxes integrate into the floor to preserve interior aesthetics.', 2),
(2, 'en', 'Flexible configuration', 'Supports 45×45 and 22.5×45 mm modular systems.', 3);

INSERT INTO products (category_id, slug, sku, sort_order)
VALUES (2, 'floor-box-sp01-0212', 'SP01-0212', 1);

INSERT INTO product_translations (product_id, lang, title, h1, short_description, description, seo_title, seo_description, seo_robots) VALUES
(1, 'ru', 'Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212', 'Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212', 'Электротехническое изделие для скрытой установки в полу и организации точек подключения электрики и слаботочных линий.', 'Серия System Power SP01-02 — это решение для тех, кто ценит удобный и безопасный доступ к электропроводке и слаботочным кабелям внутри помещений. Люк этой серии легко встраивается в конструкцию пола и благодаря скрытому монтажу органично вписывается в любой интерьер, не нарушая его эстетики. Идеально подходит для жилых, офисных и коммерческих пространств. Корпус люка изготовлен из прочной стали и оснащён штампованными отверстиями под трубы диаметром M25. По запросу доступны варианты из алюминия или нержавеющей стали — под любые условия эксплуатации.', 'Лючок System Power SP01-0212', 'Напольный лючок-невидимка System Power SP01-0212 с IP54 и модульной компоновкой.', 'index, follow'),
(1, 'en', 'Invisible floor box for 12 modules (6 sockets 45x45) IP54 System Power SP01-0212', 'Invisible floor box for 12 modules (6 sockets 45x45) IP54 System Power SP01-0212', 'Electrical product for hidden floor installation and connection points for power and low-voltage lines.', 'System Power SP01-02 series provides convenient and safe access to electrical wiring and low-voltage cables indoors. The floor box integrates into the floor with a concealed installation, keeping interiors clean and functional. The enclosure is made of durable steel and includes stamped openings for M25 conduits. Aluminum or stainless steel versions are available on request for specific conditions.', 'System Power SP01-0212 floor box', 'System Power SP01-0212 floor box with IP54 protection and modular configuration.', 'index, follow');

INSERT INTO product_images (product_id, url, sort_order) VALUES
(1, '/assets/placeholder.svg', 1),
(1, '/assets/placeholder.svg', 2),
(1, '/assets/placeholder.svg', 3),
(1, '/assets/placeholder.svg', 4),
(1, '/assets/placeholder.svg', 5);

INSERT INTO product_specs (product_id, lang, label, value, value_type, unit, sort_order) VALUES
(1, 'ru', 'Степень защиты', 'IP54', 'string', '', 1),
(1, 'ru', 'Габариты', '200x245x120', 'string', 'мм', 2),
(1, 'ru', 'Вместимость', 'до 6 розеток 45×45 мм / до 12 модулей 22.5×45 мм', 'string', '', 3),
(1, 'ru', 'Варианты поставки', 'с розетками 220 В или без комплектации', 'string', '', 4),
(1, 'ru', 'Совместимость', 'модули 220 В, RJ45, ТВ и другие стандартные подключения', 'string', '', 5),
(1, 'ru', 'Материал корпуса', 'сталь, доступны алюминий или нержавеющая сталь', 'string', '', 6),
(1, 'en', 'Ingress protection', 'IP54', 'string', '', 1),
(1, 'en', 'Dimensions', '200x245x120', 'string', 'mm', 2),
(1, 'en', 'Capacity', 'up to 6 sockets 45×45 mm / up to 12 modules 22.5×45 mm', 'string', '', 3),
(1, 'en', 'Supply options', 'with 220 V sockets or without configuration', 'string', '', 4),
(1, 'en', 'Compatibility', '220 V modules, RJ45, TV and other standard connections', 'string', '', 5),
(1, 'en', 'Enclosure material', 'steel, aluminum or stainless steel on request', 'string', '', 6);

INSERT INTO product_documents (product_id, lang, title, url, sort_order) VALUES
(1, 'ru', 'Паспорт изделия', '/docs/passport-sp01-0212.pdf', 1),
(1, 'ru', 'Инструкция по монтажу и эксплуатации', '/docs/manual-sp01-0212.pdf', 2),
(1, 'ru', 'Схема электрическая', '/docs/schematic-sp01-0212.pdf', 3),
(1, 'en', 'Product passport', '/docs/passport-sp01-0212.pdf', 1),
(1, 'en', 'Installation and operation manual', '/docs/manual-sp01-0212.pdf', 2),
(1, 'en', 'Electrical schematic', '/docs/schematic-sp01-0212.pdf', 3);

INSERT INTO faqs (entity_type, entity_id, lang, question, answer, sort_order) VALUES
('category', 2, 'ru', 'Можно ли использовать лючки System Power в офисных помещениях?', 'Да, изделия рассчитаны на офисные и коммерческие пространства и обеспечивают скрытый монтаж точек подключения.', 1),
('category', 2, 'ru', 'Какие модули подходят для лючков?', 'Поддерживаются форматы 45×45 мм и 22.5×45 мм, включая силовые и слаботочные модули.', 2),
('category', 2, 'en', 'Can System Power floor boxes be used in offices?', 'Yes, products are designed for office and commercial spaces with concealed connection points.', 1),
('category', 2, 'en', 'Which modules are supported?', 'Supports 45×45 mm and 22.5×45 mm formats for power and low-voltage modules.', 2),
('product', 1, 'ru', 'Можно ли заказать лючок без комплектации?', 'Да, доступна поставка без предустановленных розеток для индивидуальной сборки.', 1),
('product', 1, 'ru', 'Какие материалы корпуса доступны?', 'Стандартно применяется сталь; по запросу возможны алюминий или нержавеющая сталь.', 2),
('product', 1, 'en', 'Can the floor box be supplied without configuration?', 'Yes, the product can be supplied without pre-installed sockets for custom assembly.', 1),
('product', 1, 'en', 'Which enclosure materials are available?', 'Standard steel is used; aluminum or stainless steel options are available on request.', 2);

INSERT INTO partners (name, url, rel_attr, logo_url, description, is_primary) VALUES
('SISSOL', 'https://sissol.ru', 'nofollow sponsored', '/assets/placeholder.svg', 'Эксклюзивный официальный дистрибьютор продукции System Power.', 1);

SET FOREIGN_KEY_CHECKS = 1;
