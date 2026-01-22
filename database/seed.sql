CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL
);

CREATE TABLE navigation_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label_ru VARCHAR(255) NOT NULL,
    label_en VARCHAR(255) NOT NULL,
    url_ru VARCHAR(255) NOT NULL,
    url_en VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL UNIQUE,
    title_ru VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NOT NULL,
    text_ru TEXT NOT NULL,
    text_en TEXT NOT NULL,
    seo_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_title_en VARCHAR(255) NOT NULL DEFAULT '',
    seo_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    seo_description_en VARCHAR(500) NOT NULL DEFAULT '',
    seo_h1_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_h1_en VARCHAR(255) NOT NULL DEFAULT '',
    canonical VARCHAR(255) NOT NULL DEFAULT '',
    noindex TINYINT(1) NOT NULL DEFAULT 0,
    og_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    og_title_en VARCHAR(255) NOT NULL DEFAULT '',
    og_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    og_description_en VARCHAR(500) NOT NULL DEFAULT '',
    twitter_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    twitter_title_en VARCHAR(255) NOT NULL DEFAULT '',
    twitter_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    twitter_description_en VARCHAR(500) NOT NULL DEFAULT '',
    address_ru VARCHAR(255) NOT NULL DEFAULT '',
    address_en VARCHAR(255) NOT NULL DEFAULT '',
    email VARCHAR(255) NOT NULL DEFAULT '',
    phone VARCHAR(120) NOT NULL DEFAULT ''
);

CREATE TABLE page_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    block_type VARCHAR(120) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    content_ru JSON NOT NULL,
    content_en JSON NOT NULL,
    FOREIGN KEY (page_id) REFERENCES pages(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL UNIQUE,
    name_ru VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    description_ru TEXT NOT NULL,
    description_en TEXT NOT NULL,
    seo_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_title_en VARCHAR(255) NOT NULL DEFAULT '',
    seo_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    seo_description_en VARCHAR(500) NOT NULL DEFAULT '',
    seo_h1_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_h1_en VARCHAR(255) NOT NULL DEFAULT '',
    canonical VARCHAR(255) NOT NULL DEFAULT '',
    noindex TINYINT(1) NOT NULL DEFAULT 0,
    og_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    og_title_en VARCHAR(255) NOT NULL DEFAULT '',
    og_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    og_description_en VARCHAR(500) NOT NULL DEFAULT '',
    twitter_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    twitter_title_en VARCHAR(255) NOT NULL DEFAULT '',
    twitter_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    twitter_description_en VARCHAR(500) NOT NULL DEFAULT ''
);

CREATE TABLE category_advantages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    text_ru VARCHAR(255) NOT NULL,
    text_en VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL UNIQUE,
    sku VARCHAR(64) NOT NULL,
    category_id INT NOT NULL,
    name_ru VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    short_desc_ru TEXT NOT NULL,
    short_desc_en TEXT NOT NULL,
    description_ru TEXT NOT NULL,
    description_en TEXT NOT NULL,
    seo_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_title_en VARCHAR(255) NOT NULL DEFAULT '',
    seo_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    seo_description_en VARCHAR(500) NOT NULL DEFAULT '',
    seo_h1_ru VARCHAR(255) NOT NULL DEFAULT '',
    seo_h1_en VARCHAR(255) NOT NULL DEFAULT '',
    canonical VARCHAR(255) NOT NULL DEFAULT '',
    noindex TINYINT(1) NOT NULL DEFAULT 0,
    og_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    og_title_en VARCHAR(255) NOT NULL DEFAULT '',
    og_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    og_description_en VARCHAR(500) NOT NULL DEFAULT '',
    twitter_title_ru VARCHAR(255) NOT NULL DEFAULT '',
    twitter_title_en VARCHAR(255) NOT NULL DEFAULT '',
    twitter_description_ru VARCHAR(500) NOT NULL DEFAULT '',
    twitter_description_en VARCHAR(500) NOT NULL DEFAULT '',
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE product_specs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    label_ru VARCHAR(255) NOT NULL,
    value_ru VARCHAR(255) NOT NULL,
    label_en VARCHAR(255) NOT NULL,
    value_en VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE product_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    label_ru VARCHAR(255) NOT NULL,
    label_en VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE product_features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    feature_type VARCHAR(50) NOT NULL,
    text_ru VARCHAR(255) NOT NULL,
    text_en VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE product_certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    title_ru VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NOT NULL,
    description_ru TEXT NOT NULL,
    description_en TEXT NOT NULL,
    position INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE faq_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    scope VARCHAR(50) NOT NULL,
    scope_id INT NOT NULL,
    question_ru TEXT NOT NULL,
    answer_ru TEXT NOT NULL,
    question_en TEXT NOT NULL,
    answer_en TEXT NOT NULL,
    position INT NOT NULL DEFAULT 0
);

CREATE TABLE regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ru VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 0
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(120) NOT NULL,
    file_size INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE redirects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    source VARCHAR(255) NOT NULL,
    target VARCHAR(255) NOT NULL,
    status_code INT NOT NULL DEFAULT 301
);

INSERT INTO settings (setting_key, setting_value) VALUES
('official_seller_name', 'SISSOL'),
('official_seller_url', 'https://sissol.ru'),
('brand_name', 'System Power'),
('brand_url', 'https://systempower.example'),
('default_robots', 'index, follow'),
('default_og_title', 'System Power'),
('default_og_description', 'System Power — производитель электротехнического оборудования.');

INSERT INTO navigation_links (label_ru, label_en, url_ru, url_en, position) VALUES
('Продукция', 'Products', '/ru/products/', '/en/products/', 1),
('Где купить', 'Where to buy', '/ru/where-to-buy/', '/en/where-to-buy/', 2),
('О бренде', 'About', '/ru/about/', '/en/about/', 3),
('Производство', 'Manufacturing', '/ru/manufacturing/', '/en/manufacturing/', 4),
('Документация', 'Documentation', '/ru/documentation/', '/en/documentation/', 5),
('Поддержка', 'Support', '/ru/support/', '/en/support/', 6),
('Контакты', 'Contacts', '/ru/contacts/', '/en/contacts/', 7);

INSERT INTO pages (slug, title_ru, title_en, text_ru, text_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en, address_ru, address_en, email, phone)
VALUES
('home', 'System Power — электротехническое оборудование для инженерных систем', 'System Power — electrical equipment for engineering systems',
 '', '',
 'System Power — электротехническое оборудование для инженерных систем', 'System Power — electrical equipment for engineering systems',
 'Производство и сборка электротехнических изделий System Power для инженерных систем.', 'System Power electrical products for engineering systems with local assembly.',
 'System Power — электротехническое оборудование', 'System Power — electrical equipment',
 'System Power', 'System Power',
 'Производитель электротехнического оборудования System Power.', 'System Power electrical equipment manufacturer.',
 'System Power', 'System Power',
 'Бренд System Power и официальный продавец SISSOL.', 'System Power brand with exclusive seller SISSOL.',
 '', '', '', ''),
('about', 'System Power — производитель электротехнического оборудования', 'System Power — manufacturer of electrical equipment',
 'System Power разрабатывает и выпускает электротехнические изделия, предназначенные для эксплуатации в составе инженерных и распределительных систем зданий. Ассортимент бренда включает щиты механизации и распределительные электрощиты, а также металлические лючки для скрытой установки электрики и кабельных линий. Продукция производится с локальной сборкой в России. Все основные технические параметры, габариты и варианты исполнения указываются в паспортах изделий и технической документации на конкретные модели.',
 'System Power develops and manufactures electrical products designed for engineering and distribution systems in buildings. The brand portfolio includes mechanization boards, distribution panels, and metal floor boxes for concealed power and cable installation. Products are locally assembled in Russia. Key technical parameters, dimensions, and configurations are documented in product passports and technical documentation for each model.',
 'System Power — производитель электротехнического оборудования', 'System Power — manufacturer of electrical equipment',
 'О бренде System Power и позиционирование производителя электротехнического оборудования.', 'About System Power as an electrical equipment manufacturer.',
 'System Power — производитель', 'System Power — manufacturer',
 'System Power', 'System Power',
 'Бренд System Power и официальные сведения о производителе.', 'System Power brand and official manufacturer information.',
 'System Power', 'System Power',
 'Информация о бренде System Power.', 'System Power brand information.',
 '', '', '', ''),
('manufacturing', 'Локальная сборка и контроль параметров изделий', 'Local assembly and product quality control',
 'Производственный процесс System Power включает сборку изделий на территории Российской Федерации с использованием металлических корпусов и электротехнических компонентов промышленного класса. Перед выпуском продукция проходит проверку комплектности, контроль геометрических размеров корпусов, проверку маркировки и оформление эксплуатационной документации. Изделия поставляются с паспортами и схемами, а также с сертификатами или декларациями соответствия при наличии для конкретной модели.',
 'The System Power manufacturing process includes assembly in the Russian Federation using metal housings and industrial-grade electrical components. Before release, products undergo completeness checks, housing geometry control, marking verification, and documentation preparation. Products are supplied with passports and wiring schemes, plus certificates or declarations of conformity when available for the specific model.',
 'Производство System Power', 'System Power manufacturing',
 'Производство и контроль качества изделий System Power.', 'System Power manufacturing and quality control.',
 'Производство System Power', 'System Power manufacturing',
 'System Power', 'System Power',
 'Производственные процессы System Power.', 'System Power manufacturing processes.',
 'System Power', 'System Power',
 'Производство System Power.', 'System Power manufacturing.',
 '', '', '', ''),
('documentation', 'Документация', 'Documentation',
 'Техническая документация System Power включает паспорта изделий, инструкции по монтажу и схемы. Документы доступны в формате PDF для каждой модели.',
 'System Power technical documentation includes product passports, installation manuals, and wiring schemes. Documents are available in PDF format for each model.',
 'Документация System Power', 'System Power documentation',
 'Паспорта, инструкции и схемы System Power.', 'System Power passports, manuals, and wiring schemes.',
 'Документация', 'Documentation',
 'System Power', 'System Power',
 'Техническая документация System Power.', 'System Power technical documentation.',
 'System Power', 'System Power',
 'Документация System Power.', 'System Power documentation.',
 '', '', '', ''),
('support', 'Поддержка', 'Support',
 'По вопросам подбора оборудования и технических характеристик обращайтесь к официальному продавцу SISSOL. Специалисты помогут подобрать конфигурацию и предоставят актуальные документы.',
 'For equipment selection and technical information, contact the official seller SISSOL. Specialists will help with configuration and provide up-to-date documents.',
 'Поддержка System Power', 'System Power support',
 'Поддержка и консультации по оборудованию System Power.', 'Support and consultation for System Power equipment.',
 'Поддержка', 'Support',
 'System Power', 'System Power',
 'Поддержка System Power.', 'System Power support.',
 'System Power', 'System Power',
 'Поддержка System Power.', 'System Power support.',
 '', '', '', ''),
('contacts', 'Контакты', 'Contacts',
 'По вопросам сотрудничества и поставок обращайтесь к официальному продавцу SISSOL. Ответы на технические вопросы предоставляются через партнерскую службу поддержки.',
 'For partnership and supply inquiries, contact the official seller SISSOL. Technical support is provided through the partner service.',
 'Контакты System Power', 'System Power contacts',
 'Контакты и реквизиты System Power.', 'System Power contacts and requisites.',
 'Контакты', 'Contacts',
 'System Power', 'System Power',
 'Контактная информация System Power.', 'System Power contact information.',
 'System Power', 'System Power',
 'Контакты System Power.', 'System Power contacts.',
 'Россия, Москва, деловой центр', 'Russia, Moscow, business district',
 'info@systempower.example', '+7 (495) 000-00-00'),
('where-to-buy', 'Где купить System Power', 'Where to buy System Power',
 'Эксклюзивным официальным продавцом продукции System Power является компания SISSOL. Доступность продукции зависит от региона и складских остатков партнёра.',
 'The exclusive official seller of System Power products is SISSOL. Availability depends on region and partner stock.',
 'Где купить System Power', 'Where to buy System Power',
 'Официальный продавец System Power и доступность по регионам.', 'Official seller and regional availability.',
 'Где купить', 'Where to buy',
 'System Power', 'System Power',
 'Где купить System Power.', 'Where to buy System Power.',
 'System Power', 'System Power',
 'Официальный продавец System Power.', 'Official System Power seller.',
 '', '', '', '');

INSERT INTO page_blocks (page_id, block_type, position, content_ru, content_en) VALUES
((SELECT id FROM pages WHERE slug = 'home'), 'hero', 1,
 '{"title":"System Power — электротехническое оборудование для инженерных систем","subtitle":"Производство и сборка электротехнических изделий для распределения электропитания и организации точек подключения в зданиях и технических зонах.","text":"Продукция выпускается с локальной сборкой в России и применяется в системах временного и стационарного электроснабжения."}',
 '{"title":"System Power — electrical equipment for engineering systems","subtitle":"Manufacturing and assembly of electrical products for power distribution and connection points in buildings and technical zones.","text":"Products are locally assembled in Russia and used in temporary and permanent power supply systems."}'),
((SELECT id FROM pages WHERE slug = 'home'), 'brand', 2,
 '{"title":"System Power — производитель электротехнической продукции","text":"В ассортименте представлены электрощитовое оборудование для распределения и защиты электрических цепей и напольные лючки для скрытой установки электрики и слаботочных линий. Изделия предназначены для применения на строительных объектах, в коммерческих и промышленных зданиях, а также в инженерной инфраструктуре."}',
 '{"title":"System Power — manufacturer of electrical products","text":"The portfolio includes electrical enclosures for distribution and protection, and floor boxes for concealed power and low-voltage installation. The products are designed for construction sites, commercial and industrial buildings, and engineering infrastructure."}'),
((SELECT id FROM pages WHERE slug = 'home'), 'manufacturing', 3,
 '{"title":"Производство и сборка","text":"Сборка продукции System Power осуществляется на территории Российской Федерации. В производстве используются металлические корпуса и стандартные электротехнические компоненты промышленного назначения.","list":["Проверка комплектности изделий","Контроль геометрических параметров корпусов","Визуальный контроль сборки","Оформление паспортов и сопроводительной документации"]}',
 '{"title":"Manufacturing and assembly","text":"System Power products are assembled in the Russian Federation. Production uses metal housings and industrial-grade electrical components.","list":["Completeness checks","Housing geometry control","Visual assembly inspection","Issuing passports and supporting documentation"]}'),
((SELECT id FROM pages WHERE slug = 'home'), 'where', 4,
 '{"title":"Где приобрести","text":"Продукция System Power поставляется через партнёров и дистрибьюторов. Доступность продукции и условия поставки зависят от региона и складских остатков конкретного поставщика."}',
 '{"title":"Where to buy","text":"System Power products are supplied through partners and distributors. Availability and terms depend on the region and supplier stock."}'),
((SELECT id FROM pages WHERE slug = 'home'), 'seo', 5,
 '{"text":"System Power — производитель электротехнического оборудования с локальной сборкой в России. Официальный продавец бренда — компания SISSOL, которая обеспечивает поставку и консультации по всей линейке продукции."}',
 '{"text":"System Power is an electrical equipment manufacturer with local assembly in Russia. The exclusive official seller is SISSOL, providing supply and consultation for the product range."}');

INSERT INTO categories (slug, name_ru, name_en, description_ru, description_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en)
VALUES
('electrical-enclosures', 'Электрощитовое оборудование', 'Electrical enclosures',
 'Электрощитовое оборудование System Power предназначено для распределения и защиты электрических цепей в инженерных системах зданий и технических зон. В категории представлены щиты механизации, распределительные шкафы и изделия с розеточными группами, которые применяются на строительных площадках, в промышленных и коммерческих объектах. Металлические корпуса обеспечивают устойчивость к механическим воздействиям, а стандартные комплектующие позволяют легко обслуживать оборудование на протяжении всего срока эксплуатации.',
 'System Power electrical enclosures are designed for power distribution and circuit protection in engineering systems and technical areas. The category includes mechanization boards, distribution cabinets, and configurations with socket groups used at construction sites, industrial facilities, and commercial buildings. Metal housings provide durability, while standard components make the equipment easy to service throughout its lifecycle.',
 'Электрощитовое оборудование System Power', 'System Power electrical enclosures',
 'Категория электрощитов System Power для распределения и защиты цепей.', 'System Power electrical enclosures for distribution and circuit protection.',
 'Электрощитовое оборудование', 'Electrical enclosures',
 'System Power — электрощитовое оборудование', 'System Power electrical enclosures',
 'Категория электрощитов System Power.', 'System Power electrical enclosures category.',
 'System Power — электрощитовое оборудование', 'System Power electrical enclosures',
 'Категория электрощитов System Power.', 'System Power electrical enclosures category.'),
('floor-boxes', 'Лючки напольные', 'Floor boxes',
 'Напольные лючки System Power предназначены для скрытой установки в полу и организации точек подключения электрики и слаботочных линий. Изделия применяются в офисных, коммерческих и инженерных пространствах, где требуется аккуратный вывод розеток и кабелей с защитой от внешних воздействий. Конструкции позволяют использовать стандартные модули 45×45 мм и 22,5×45 мм, обеспечивая удобный доступ к коммуникациям.',
 'System Power floor boxes are designed for concealed floor installation and for organizing power and low-voltage connection points. They are used in office, commercial, and engineering spaces where neat cable outlets and protection against external impacts are required. The design supports standard 45×45 mm and 22.5×45 mm modules for flexible configurations.',
 'Лючки напольные System Power', 'System Power floor boxes',
 'Напольные лючки для скрытых точек подключения System Power.', 'System Power floor boxes for concealed connection points.',
 'Лючки напольные', 'Floor boxes',
 'System Power — напольные лючки', 'System Power floor boxes',
 'Напольные лючки System Power.', 'System Power floor boxes.',
 'System Power — напольные лючки', 'System Power floor boxes',
 'Напольные лючки System Power.', 'System Power floor boxes.');

INSERT INTO category_advantages (category_id, text_ru, text_en, position) VALUES
(1, 'Серийные металлические корпуса промышленного класса', 'Industrial-grade metal housings', 1),
(1, 'Готовые конфигурации для временного и стационарного электроснабжения', 'Ready configurations for temporary and fixed power supply', 2),
(1, 'Документация и паспорта на каждую модель', 'Documentation and product passports for every model', 3),
(2, 'Скрытый монтаж без визуального шума в интерьере', 'Concealed installation keeps interiors clean and minimal', 1),
(2, 'Совместимость с модульными решениями 45×45 мм', 'Compatible with 45×45 mm modular systems', 2),
(2, 'Защита от пыли и кратковременной влаги', 'Protection against dust and short-term moisture', 3);

INSERT INTO products (slug, sku, category_id, name_ru, name_en, short_desc_ru, short_desc_en, description_ru, description_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en)
VALUES
('sp01-0212', 'SP01-0212', 2,
 'Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212',
 'Invisible floor box for 12 modules (6 sockets 45x45) IP54 System Power SP01-0212',
 'Электротехническое изделие для скрытого монтажа в полу и организации точек подключения электрики и слаботочных линий.',
 'Electrical product for concealed floor installation and organized power and low-voltage connection points.',
 'Серия System Power SP01-02 — это решение для тех, кто ценит удобный и безопасный доступ к электропроводке и слаботочным кабелям внутри помещений. Люк этой серии легко встраивается в конструкцию пола и благодаря скрытому монтажу органично вписывается в любой интерьер, не нарушая его эстетики. Идеально подходит для жилых, офисных и коммерческих пространств.\nКорпус люка изготовлен из прочной стали и оснащён штампованными отверстиями под трубы диаметром M25. По запросу доступны варианты из алюминия или нержавеющей стали — под любые условия эксплуатации.',
 'The System Power SP01-02 series is built for users who need safe, convenient access to power and low-voltage cables indoors. The box integrates into the floor and stays visually discreet thanks to concealed mounting, making it suitable for residential, office, and commercial spaces.\nThe housing is made of durable steel and includes stamped openings for M25 conduits. Aluminum or stainless steel versions are available on request for specific operating conditions.',
 'Лючок-невидимка System Power SP01-0212', 'System Power SP01-0212 floor box',
 'Напольный лючок-невидимка IP54 для модульных решений System Power.', 'IP54 floor box for modular solutions by System Power.',
 'Напольный лючок System Power SP01-0212', 'System Power SP01-0212 floor box',
 'System Power SP01-0212', 'System Power SP01-0212',
 'Напольный лючок-невидимка IP54 System Power.', 'IP54 System Power floor box.',
 'System Power SP01-0212', 'System Power SP01-0212',
 'Напольный лючок-невидимка IP54 System Power.', 'IP54 System Power floor box.');

INSERT INTO product_images (product_id, file_path, position) VALUES
(1, '/assets/images/floor-box-1.svg', 1),
(1, '/assets/images/floor-box-2.svg', 2),
(1, '/assets/images/floor-box-3.svg', 3),
(1, '/assets/images/floor-box-4.svg', 4),
(1, '/assets/images/floor-box-5.svg', 5);

INSERT INTO product_features (product_id, feature_type, text_ru, text_en, position) VALUES
(1, 'feature', 'Степень защиты IP54: надёжная защита от пыли и кратковременной влаги', 'IP54 protection rating for dust and short-term moisture resistance', 1),
(1, 'feature', 'Габариты: 200×245×120 мм', 'Dimensions: 200×245×120 mm', 2),
(1, 'feature', 'Вместимость: до 6 розеток формата 45×45 мм или до 12 модулей 22,5×45 мм', 'Capacity: up to 6 sockets 45×45 mm or 12 modules 22.5×45 mm', 3),
(1, 'feature', 'Варианты поставки: с предустановленными розетками 220 В или без комплектации', 'Supply options: with preinstalled 220 V sockets or empty for custom assembly', 4),
(1, 'feature', 'Совместимость: модули 220 В, RJ45, ТВ и другие стандартные подключения', 'Compatibility: 220 V, RJ45, TV, and other standard modules', 5),
(1, 'advantage', 'Изменяемая глубина установки лючка — до 20 мм', 'Adjustable installation depth up to 20 mm', 1),
(1, 'advantage', 'Полная совместимость с модульными решениями типа Mosaic®', 'Full compatibility with Mosaic®-type modular solutions', 2),
(1, 'advantage', 'Возможность изготовления под конкретные задачи', 'Custom manufacturing for specific tasks', 3),
(1, 'advantage', 'Широкий выбор конфигураций — до 32 установочных мест', 'Wide range of configurations up to 32 installation points', 4),
(1, 'advantage', 'Идеально подходит для любых интерьеров и типов помещений', 'Fits any interior and space type', 5),
(1, 'advantage', 'Индивидуальные решения и оптовые заказы', 'Custom solutions and wholesale orders', 6);

INSERT INTO product_specs (product_id, label_ru, value_ru, label_en, value_en, position) VALUES
(1, 'Тип изделия', 'Напольный лючок-невидимка', 'Product type', 'Invisible floor box', 1),
(1, 'Номинальный ток', '16 А', 'Rated current', '16 A', 2),
(1, 'Степень защиты', 'IP54', 'Protection rating', 'IP54', 3),
(1, 'Материал корпуса', 'Сталь (опционально алюминий или нержавеющая сталь)', 'Housing material', 'Steel (optional aluminum or stainless steel)', 4),
(1, 'Количество розеток / модулей', '6 розеток 45×45 мм или 12 модулей 22,5×45 мм', 'Sockets / modules', '6 sockets 45×45 mm or 12 modules 22.5×45 mm', 5),
(1, 'Тип кабельных вводов', 'Штампованные отверстия под M25', 'Cable entries', 'Stamped openings for M25', 6),
(1, 'Габаритные размеры', '200×245×120 мм', 'Dimensions', '200×245×120 mm', 7);

INSERT INTO product_documents (product_id, label_ru, label_en, file_path, position) VALUES
(1, 'Паспорт изделия', 'Product passport', '/assets/docs/passport-sp01-0212.pdf', 1),
(1, 'Инструкция по монтажу и эксплуатации', 'Installation manual', '/assets/docs/manual-sp01-0212.pdf', 2),
(1, 'Схема электрическая', 'Wiring scheme', '/assets/docs/scheme-sp01-0212.pdf', 3);

INSERT INTO product_certificates (product_id, title_ru, title_en, description_ru, description_en, position) VALUES
(1, 'Гарантия соответствия', 'Compliance warranty', 'Изделие поставляется с паспортом и подтверждением характеристик для каждой партии.', 'The product is supplied with a passport and confirmed specifications for each batch.', 1),
(1, 'Локальная сборка', 'Local assembly', 'Сборка и проверка комплектности выполняются в России.', 'Assembly and completeness checks are performed in Russia.', 2);

INSERT INTO faq_items (scope, scope_id, question_ru, answer_ru, question_en, answer_en, position) VALUES
('category', 2, 'Какие модули поддерживают лючки System Power?', 'Лючки рассчитаны на модули форматов 45×45 мм и 22,5×45 мм, что позволяет устанавливать силовые и слаботочные розетки.', 'Which modules are supported?', 'The floor boxes support 45×45 mm and 22.5×45 mm modules for power and low-voltage outlets.', 1),
('category', 2, 'Можно ли выбрать комплектацию?', 'Да, доступна поставка с предустановленными розетками или без комплектации для индивидуальной сборки.', 'Can I order without preinstalled sockets?', 'Yes, supply options include preinstalled sockets or an empty configuration for custom assembly.', 2),
('product', 1, 'Можно ли установить модульные розетки других форматов?', 'Конструкция рассчитана на стандарт 45×45 мм и 22,5×45 мм, поэтому совместимость с другими форматами требует индивидуального согласования.', 'Can I install other module formats?', 'The design supports 45×45 mm and 22.5×45 mm modules; other formats require custom approval.', 1),
('product', 1, 'Насколько глубоко регулируется установка?', 'Глубина установки регулируется до 20 мм, что позволяет адаптировать лючок под разные покрытия пола.', 'How deep is the adjustment?', 'Installation depth is adjustable up to 20 mm to match different floor coverings.', 2);

INSERT INTO regions (name_ru, name_en, position) VALUES
('Москва и МО', 'Moscow region', 1),
('Санкт-Петербург', 'St. Petersburg', 2),
('Юг России', 'South of Russia', 3),
('Урал', 'Ural', 4),
('Сибирь', 'Siberia', 5);

INSERT INTO redirects (source, target, status_code) VALUES
('/ru/old-catalog/', '/ru/products/', 301);
