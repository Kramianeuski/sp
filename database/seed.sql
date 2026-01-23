CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language VARCHAR(10) NOT NULL,
    `key` VARCHAR(190) NOT NULL,
    `value` TEXT NOT NULL,
    UNIQUE KEY unique_translation (language, `key`)
);

CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language VARCHAR(10) NOT NULL,
    `key` VARCHAR(190) NOT NULL,
    `value` TEXT NOT NULL,
    UNIQUE KEY unique_setting (language, `key`)
);

CREATE TABLE navigation_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language VARCHAR(10) NOT NULL,
    label VARCHAR(190) NOT NULL,
    url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(190) NOT NULL UNIQUE
);

CREATE TABLE page_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    meta_title VARCHAR(255) NOT NULL,
    meta_description TEXT NOT NULL,
    canonical VARCHAR(255) NOT NULL,
    robots VARCHAR(255) NOT NULL,
    og_title VARCHAR(255) NOT NULL,
    og_description TEXT NOT NULL,
    indexable TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE,
    UNIQUE KEY unique_page_translation (page_id, language)
);

CREATE TABLE page_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    block_key VARCHAR(190) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(190) NOT NULL UNIQUE
);

CREATE TABLE category_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    name VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    meta_title VARCHAR(255) NOT NULL,
    meta_description TEXT NOT NULL,
    seo_text TEXT NOT NULL,
    official_seller TEXT NOT NULL,
    faq TEXT NOT NULL,
    indexable TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_category_translation (category_id, language)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    slug VARCHAR(190) NOT NULL UNIQUE,
    sku VARCHAR(190) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE product_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    name VARCHAR(255) NOT NULL,
    h1 VARCHAR(255) NOT NULL,
    short_description TEXT NOT NULL,
    description TEXT NOT NULL,
    meta_title VARCHAR(255) NOT NULL,
    meta_description TEXT NOT NULL,
    indexable TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_product_translation (product_id, language)
);

CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE product_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE product_faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE product_specs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    language VARCHAR(10) NOT NULL,
    label VARCHAR(255) NOT NULL,
    value VARCHAR(255) NOT NULL,
    unit VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$12$dFyrNsz86EwKyO3zhvuprO4EI0MHKCHdX8mTm10bFDZy.IKncuUvK');

INSERT INTO site_settings (language, `key`, `value`) VALUES
('ru', 'brand_name', 'System Power'),
('ru', 'brand_description', 'Производитель электротехнического оборудования для инженерных систем.'),
('ru', 'site_title', 'System Power — официальный сайт бренда'),
('ru', 'site_description', 'Бренд-портал производителя System Power: продукция, документация и официальные партнёры.'),
('ru', 'footer_title', 'System Power'),
('ru', 'footer_text', 'Официальный бренд-портал производителя электротехнической продукции.'),
('ru', 'footer_contacts_title', 'Контакты'),
('ru', 'footer_contacts', 'Служба поддержки: info@systempower.example\nПартнёр: sissol.ru'),
('ru', 'official_seller_text', 'Эксклюзивный официальный дистрибьютор продукции System Power.'),
('en', 'brand_name', 'System Power'),
('en', 'brand_description', 'Manufacturer of electrical equipment for engineering systems.'),
('en', 'site_title', 'System Power — official brand site'),
('en', 'site_description', 'Brand portal of System Power: products, documentation, and official distributors.'),
('en', 'footer_title', 'System Power'),
('en', 'footer_text', 'Official brand portal of the electrical equipment manufacturer.'),
('en', 'footer_contacts_title', 'Contacts'),
('en', 'footer_contacts', 'Support: info@systempower.example\nPartner: sissol.ru'),
('en', 'official_seller_text', 'Exclusive official distributor of System Power products.');

INSERT INTO navigation_items (language, label, url, sort_order) VALUES
('ru', 'Продукция', '/ru/products/', 1),
('ru', 'О бренде', '/ru/about/', 2),
('ru', 'Производство', '/ru/manufacturing/', 3),
('ru', 'Документация', '/ru/documentation/', 4),
('ru', 'Поддержка', '/ru/support/', 5),
('ru', 'Контакты', '/ru/contacts/', 6),
('ru', 'Где купить', '/ru/where-to-buy/', 7),
('en', 'Products', '/en/products/', 1),
('en', 'About', '/en/about/', 2),
('en', 'Manufacturing', '/en/manufacturing/', 3),
('en', 'Documentation', '/en/documentation/', 4),
('en', 'Support', '/en/support/', 5),
('en', 'Contacts', '/en/contacts/', 6),
('en', 'Where to buy', '/en/where-to-buy/', 7);

INSERT INTO pages (slug) VALUES
('home'),
('about'),
('manufacturing'),
('documentation'),
('support'),
('contacts'),
('where-to-buy');

INSERT INTO page_translations (page_id, language, title, h1, meta_title, meta_description, canonical, robots, og_title, og_description, indexable) VALUES
(1, 'ru', 'System Power', 'System Power — электротехническое оборудование для инженерных систем', 'System Power — официальный сайт', 'Производитель электротехнической продукции System Power.', '', 'index,follow', 'System Power', 'Производитель электротехнической продукции System Power.', 1),
(1, 'en', 'System Power', 'System Power — electrical equipment for engineering systems', 'System Power — official site', 'Manufacturer of electrical equipment System Power.', '', 'index,follow', 'System Power', 'Manufacturer of electrical equipment System Power.', 1),
(2, 'ru', 'О бренде', 'System Power — производитель электротехнического оборудования', 'О бренде System Power', 'Сведения о производителе электротехнического оборудования System Power.', '', 'index,follow', 'О бренде', 'Сведения о производителе System Power.', 1),
(2, 'en', 'About', 'System Power — manufacturer of electrical equipment', 'About System Power', 'Information about System Power electrical equipment manufacturer.', '', 'index,follow', 'About', 'Information about System Power.', 1),
(3, 'ru', 'Производство', 'Локальная сборка и контроль параметров изделий', 'Производство System Power', 'Производственные процессы и контроль качества System Power.', '', 'index,follow', 'Производство', 'Производственные процессы и контроль качества System Power.', 1),
(3, 'en', 'Manufacturing', 'Local assembly and product quality control', 'System Power manufacturing', 'Manufacturing processes and quality control of System Power.', '', 'index,follow', 'Manufacturing', 'Manufacturing processes and quality control of System Power.', 1),
(4, 'ru', 'Документация', 'Техническая документация System Power', 'Документация System Power', 'Технические паспорта и инструкции System Power.', '', 'index,follow', 'Документация', 'Технические паспорта и инструкции System Power.', 1),
(4, 'en', 'Documentation', 'System Power technical documentation', 'System Power documentation', 'Technical passports and manuals of System Power.', '', 'index,follow', 'Documentation', 'Technical passports and manuals of System Power.', 1),
(5, 'ru', 'Поддержка', 'Поддержка клиентов System Power', 'Поддержка System Power', 'Служба поддержки System Power.', '', 'index,follow', 'Поддержка', 'Служба поддержки System Power.', 1),
(5, 'en', 'Support', 'System Power customer support', 'System Power support', 'System Power support service.', '', 'index,follow', 'Support', 'System Power support service.', 1),
(6, 'ru', 'Контакты', 'Контакты System Power', 'Контакты System Power', 'Контактная информация System Power.', '', 'index,follow', 'Контакты', 'Контактная информация System Power.', 1),
(6, 'en', 'Contacts', 'System Power contacts', 'System Power contacts', 'System Power contact information.', '', 'index,follow', 'Contacts', 'System Power contact information.', 1),
(7, 'ru', 'Где купить', 'Где приобрести продукцию System Power', 'Где купить System Power', 'Официальные партнёры и дистрибьюторы System Power.', '', 'index,follow', 'Где купить', 'Официальные партнёры и дистрибьюторы System Power.', 1),
(7, 'en', 'Where to buy', 'Where to buy System Power products', 'Where to buy System Power', 'Official partners and distributors of System Power.', '', 'index,follow', 'Where to buy', 'Official partners and distributors of System Power.', 1);

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order) VALUES
(1, 'ru', 'hero', 'System Power — электротехническое оборудование для инженерных систем', 'Производство и сборка электротехнических изделий для распределения электропитания и организации точек подключения в зданиях и технических зонах.\nПродукция выпускается с локальной сборкой в России и применяется в системах временного и стационарного электроснабжения.', 1),
(1, 'ru', 'categories', 'Категории продукции', 'Две основные категории продукции для инженерных систем.', 2),
(1, 'ru', 'brand', 'О бренде', 'System Power — производитель электротехнической продукции, в ассортименте которого представлены: электрощитовое оборудование для распределения и защиты электрических цепей; напольные лючки для скрытой установки электрики и слаботочных линий.\nИзделия предназначены для применения на строительных объектах, в коммерческих и промышленных зданиях, а также в инженерной инфраструктуре.', 3),
(1, 'ru', 'manufacturing', 'Производство и сборка', 'Сборка продукции System Power осуществляется на территории Российской Федерации.\nВ производстве используются металлические корпуса и стандартные электротехнические компоненты промышленного назначения.\nКонтроль включает: проверку комплектности изделий; контроль геометрических параметров корпусов; визуальный контроль сборки; оформление паспортов и сопроводительной документации.', 4),
(1, 'ru', 'where-to-buy', 'Где приобрести', 'Продукция System Power поставляется через партнёров и дистрибьюторов. Доступность продукции и условия поставки зависят от региона и складских остатков конкретного поставщика.', 5),
(1, 'ru', 'advantages', 'Преимущества и технологии', 'Инженерные решения для надежного распределения питания, совместимые с современными стандартами монтажа и эксплуатации.', 6),
(1, 'ru', 'official-seller', 'Официальный продавец', 'Эксклюзивный официальный дистрибьютор продукции System Power.', 7),
(1, 'ru', 'certificates', 'Сертификаты и доверие', 'Изделия сопровождаются паспортами, схемами и декларациями соответствия при наличии.', 8),
(1, 'ru', 'seo-text', 'System Power', 'System Power — производитель электротехнических решений для инженерной инфраструктуры.', 9),
(1, 'en', 'hero', 'System Power — electrical equipment for engineering systems', 'Production and assembly of electrical products for power distribution and connection points in buildings and technical zones.\nProducts are assembled locally in Russia and used in temporary and stationary power supply systems.', 1),
(1, 'en', 'categories', 'Product categories', 'Two main product categories for engineering systems.', 2),
(1, 'en', 'brand', 'About the brand', 'System Power is a manufacturer of electrical products, including electrical enclosures for power distribution and protection and floor boxes for concealed installation of power and low-voltage lines. Products are used at construction sites, commercial and industrial buildings, and engineering infrastructure.', 3),
(1, 'en', 'manufacturing', 'Manufacturing and assembly', 'System Power products are assembled in the Russian Federation using metal enclosures and industrial-grade components. Control includes completeness checks, geometric inspection, visual assembly control, and documentation issuance.', 4),
(1, 'en', 'where-to-buy', 'Where to buy', 'System Power products are supplied through partners and distributors. Availability depends on region and stock levels of the supplier.', 5),
(1, 'en', 'advantages', 'Advantages and technologies', 'Engineering solutions for reliable power distribution, compatible with modern installation and operation standards.', 6),
(1, 'en', 'official-seller', 'Official distributor', 'Exclusive official distributor of System Power products.', 7),
(1, 'en', 'certificates', 'Certificates and trust', 'Products are supplied with passports, diagrams, and conformity declarations when applicable.', 8),
(1, 'en', 'seo-text', 'System Power', 'System Power is a manufacturer of electrical solutions for engineering infrastructure.', 9),
(2, 'ru', 'generic', 'О бренде', 'System Power разрабатывает и выпускает электротехнические изделия, предназначенные для эксплуатации в составе инженерных и распределительных систем зданий.\nАссортимент бренда включает: щиты механизации и распределительные электрощиты; металлические лючки для скрытой установки электрики и кабельных линий.\nПродукция производится с локальной сборкой в России.\nВсе основные технические параметры, габариты и варианты исполнения указываются в паспортах изделий и технической документации на конкретные модели.', 1),
(2, 'en', 'generic', 'About System Power', 'System Power develops and manufactures electrical products for engineering and distribution systems. The range includes distribution boards and floor boxes for concealed installation of power and cable lines. Products are locally assembled in Russia. Key parameters and configurations are specified in technical documentation for each model.', 1),
(3, 'ru', 'generic', 'Локальная сборка и контроль параметров изделий', 'Производственный процесс System Power включает сборку изделий на территории Российской Федерации с использованием металлических корпусов и электротехнических компонентов промышленного класса.\nПеред выпуском продукция проходит: проверку комплектности; контроль геометрических размеров корпусов; проверку маркировки; оформление эксплуатационной документации.\nИзделия поставляются с паспортами и схемами, а также с сертификатами или декларациями соответствия при наличии для конкретной модели.', 1),
(3, 'en', 'generic', 'Local assembly and quality control', 'System Power manufacturing includes assembly in the Russian Federation using metal enclosures and industrial-grade components. Before release, products undergo completeness checks, geometry inspection, marking control, and documentation issuance. Products are supplied with passports, diagrams, and certificates or declarations when available.', 1),
(4, 'ru', 'generic', 'Документация', 'Технические паспорта, схемы и инструкции доступны для каждой модели продукции.', 1),
(4, 'en', 'generic', 'Documentation', 'Technical passports, diagrams, and manuals are available for each product model.', 1),
(5, 'ru', 'generic', 'Поддержка', 'Служба поддержки предоставляет консультации по подбору и эксплуатации продукции System Power.', 1),
(5, 'en', 'generic', 'Support', 'Support service provides guidance on System Power product selection and operation.', 1),
(6, 'ru', 'generic', 'Контакты', 'Свяжитесь с нами по вопросам партнёрства, документации и поддержки.', 1),
(6, 'en', 'generic', 'Contacts', 'Contact us for partnerships, documentation, and support.', 1),
(7, 'ru', 'generic', 'Где купить', 'Продукция System Power поставляется через официальных партнёров и дистрибьюторов. Единственный официальный продавец — SISSOL.\nСсылки на партнёра размещаются с атрибутом nofollow sponsored.', 1),
(7, 'en', 'generic', 'Where to buy', 'System Power products are supplied through official partners and distributors. The exclusive official seller is SISSOL. Links to the partner use nofollow sponsored attributes.', 1);

INSERT INTO categories (slug) VALUES
('electrical-enclosures'),
('floor-boxes');

INSERT INTO category_translations (category_id, language, name, h1, description, meta_title, meta_description, seo_text, official_seller, faq, indexable) VALUES
(1, 'ru', 'Электрощитовое оборудование', 'Электрощитовое оборудование System Power', 'Электрощитовое оборудование System Power предназначено для распределения и защиты электрических цепей при подключении оборудования и потребителей электроэнергии.', 'Электрощитовое оборудование System Power', 'Электрощитовое оборудование System Power для распределения и защиты электрических цепей.', 'Категория включает щиты механизации, распределительные шкафы и изделия с силовыми и розеточными группами.', 'Эксклюзивный официальный дистрибьютор продукции System Power.', '[{"question":"Какие объекты используют электрощитовое оборудование?","answer":"Щиты используются на строительных площадках, в технических помещениях, на промышленных и коммерческих объектах."}]', 1),
(1, 'en', 'Electrical enclosures', 'System Power electrical enclosures', 'System Power electrical enclosures are designed for power distribution and protection of electrical circuits.', 'System Power electrical enclosures', 'System Power electrical enclosures for power distribution and circuit protection.', 'The category includes distribution boards, control panels, and units with power outlets.', 'Exclusive official distributor of System Power products.', '[{"question":"Where are electrical enclosures used?","answer":"They are used at construction sites, technical rooms, industrial and commercial facilities."}]', 1),
(2, 'ru', 'Лючки', 'Лючки напольные System Power', 'Напольные лючки System Power предназначены для скрытой установки в полу и организации точек подключения электрики и слаботочных систем.', 'Лючки System Power', 'Напольные лючки для скрытой установки в полу и организации точек подключения.', 'Изделия применяются в офисных, коммерческих и инженерных помещениях, где требуется вывод розеток и кабелей с защитой от внешних воздействий.', 'Эксклюзивный официальный дистрибьютор продукции System Power.', '[{"question":"Для каких помещений подходят лючки?","answer":"Лючки используются в офисных, коммерческих и инженерных помещениях для вывода розеток и кабелей."}]', 1),
(2, 'en', 'Floor boxes', 'System Power floor boxes', 'System Power floor boxes are designed for concealed installation and connection points for power and low-voltage systems.', 'System Power floor boxes', 'Floor boxes for concealed installation and connection points.', 'Products are used in office, commercial, and engineering spaces where protected power and cable outputs are required.', 'Exclusive official distributor of System Power products.', '[{"question":"Where are floor boxes used?","answer":"They are used in office, commercial, and engineering spaces for protected cable outputs."}]', 1);

INSERT INTO products (category_id, slug, sku) VALUES
(2, 'sp01-0212', 'SP01-0212');

INSERT INTO product_translations (product_id, language, name, h1, short_description, description, meta_title, meta_description, indexable) VALUES
(1, 'ru', 'Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212', 'Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212', 'Электротехническое изделие для распределения электропитания и подключения оборудования в составе инженерных систем здания.', 'Серия System Power SP01-02 — это решение для тех, кто ценит удобный и безопасный доступ к электропроводке и слаботочным кабелям внутри помещений. Люк этой серии легко встраивается в конструкцию пола и благодаря скрытому монтажу органично вписывается в любой интерьер, не нарушая его эстетики. Идеально подходит для жилых, офисных и коммерческих пространств. Корпус люка изготовлен из прочной стали и оснащён штампованными отверстиями под трубы диаметром M25. По запросу доступны варианты из алюминия или нержавеющей стали — под любые условия эксплуатации.', 'Лючок-невидимка System Power SP01-0212', 'Напольный лючок-невидимка IP54 System Power SP01-0212 с 12 модулями и скрытым монтажом.', 1),
(1, 'en', 'Floor box invisible 12 modules (6 outlets 45x45) IP54 System Power SP01-0212', 'Floor box invisible 12 modules (6 outlets 45x45) IP54 System Power SP01-0212', 'Electrical product for power distribution and equipment connection within engineering systems.', 'System Power SP01-02 series provides convenient and safe access to power and low-voltage cables indoors. The floor box integrates into the floor structure with concealed mounting and fits interior aesthetics. Suitable for residential, office, and commercial spaces. The enclosure is made of durable steel with stamped openings for M25 conduits. Aluminum or stainless steel versions are available upon request.', 'System Power SP01-0212 floor box', 'Invisible floor box IP54 System Power SP01-0212 with 12 modules and concealed mounting.', 1);

INSERT INTO product_images (product_id, language, file_path, alt_text, sort_order) VALUES
(1, 'ru', '/themes/default/placeholder-product.svg', 'System Power SP01-0212', 1),
(1, 'en', '/themes/default/placeholder-product.svg', 'System Power SP01-0212', 1);

INSERT INTO product_documents (product_id, language, title, file_path, sort_order) VALUES
(1, 'ru', 'Паспорт изделия', '/storage/uploads/passport-sp01-0212.pdf', 1),
(1, 'ru', 'Инструкция по монтажу и эксплуатации', '/storage/uploads/manual-sp01-0212.pdf', 2),
(1, 'ru', 'Схема электрическая', '/storage/uploads/scheme-sp01-0212.pdf', 3),
(1, 'en', 'Product passport', '/storage/uploads/passport-sp01-0212.pdf', 1),
(1, 'en', 'Installation and operation manual', '/storage/uploads/manual-sp01-0212.pdf', 2),
(1, 'en', 'Electrical diagram', '/storage/uploads/scheme-sp01-0212.pdf', 3);

INSERT INTO product_faqs (product_id, language, question, answer, sort_order) VALUES
(1, 'ru', 'Какая глубина установки лючка?', 'Глубина установки регулируется и может быть изменена до 20 мм.', 1),
(1, 'ru', 'Какие модули совместимы?', 'Совместимы модули 220 В, RJ45, ТВ и другие стандартные подключения.', 2),
(1, 'en', 'What is the installation depth?', 'Installation depth is adjustable up to 20 mm.', 1),
(1, 'en', 'Which modules are compatible?', 'Compatible with 220 V, RJ45, TV, and other standard modules.', 2);

INSERT INTO product_specs (product_id, language, label, value, unit, type, sort_order) VALUES
(1, 'ru', 'Степень защиты', 'IP54', '', 'string', 1),
(1, 'ru', 'Габариты', '200x245x120', 'мм', 'number', 2),
(1, 'ru', 'Вместимость', 'до 6 розеток 45×45 мм или до 12 модулей 22.5×45 мм', '', 'string', 3),
(1, 'ru', 'Материал корпуса', 'Сталь', '', 'string', 4),
(1, 'ru', 'Кабельные вводы', 'Отверстия под трубы M25', '', 'string', 5),
(1, 'en', 'Protection rating', 'IP54', '', 'string', 1),
(1, 'en', 'Dimensions', '200x245x120', 'mm', 'number', 2),
(1, 'en', 'Capacity', 'Up to 6 outlets 45×45 mm or up to 12 modules 22.5×45 mm', '', 'string', 3),
(1, 'en', 'Enclosure material', 'Steel', '', 'string', 4),
(1, 'en', 'Cable entries', 'Stamped openings for M25 conduits', '', 'string', 5);

INSERT INTO translations (language, `key`, `value`) VALUES
('ru', 'hero.products', 'Продукция'),
('ru', 'hero.where', 'Где приобрести'),
('ru', 'where_to_buy.button', 'Партнёры и поставщики'),
('ru', 'official.seller_title', 'Официальный продавец'),
('ru', 'official.seller_text', 'Эксклюзивный официальный дистрибьютор продукции System Power'),
('ru', 'official.seller_button', 'Перейти на сайт sissol.ru'),
('ru', 'official.seller_link', 'https://sissol.ru'),
('ru', 'products.title', 'Продукция System Power'),
('ru', 'products.h1', 'Каталог продукции'),
('ru', 'products.meta_title', 'Каталог продукции System Power'),
('ru', 'products.meta_description', 'Категории продукции System Power'),
('ru', 'faq.title', 'FAQ'),
('ru', 'seo.title', 'System Power'),
('ru', 'product.description_title', 'Описание'),
('ru', 'product.specs_title', 'Характеристики'),
('ru', 'product.documents_title', 'Документация'),
('ru', 'product.related_title', 'Похожие товары'),
('ru', 'error.not_found', 'Страница не найдена'),
('ru', 'error.not_found_text', 'Запрашиваемая страница недоступна.'),
('ru', 'breadcrumb.home', 'Главная'),
('ru', 'admin.login_title', 'Вход в админку'),
('ru', 'admin.username', 'Логин'),
('ru', 'admin.password', 'Пароль'),
('ru', 'admin.login', 'Войти'),
('ru', 'admin.login_failed', 'Неверные учетные данные'),
('ru', 'admin.panel_title', 'Админка System Power'),
('ru', 'admin.nav_pages', 'Страницы'),
('ru', 'admin.nav_categories', 'Категории'),
('ru', 'admin.nav_products', 'Продукты'),
('ru', 'admin.nav_translations', 'Переводы'),
('ru', 'admin.nav_files', 'Файлы'),
('ru', 'admin.logout', 'Выход'),
('ru', 'admin.pages_title', 'Страницы'),
('ru', 'admin.page_slug', 'Слаг'),
('ru', 'admin.page_title', 'Заголовок'),
('ru', 'admin.page_h1', 'H1'),
('ru', 'admin.page_edit_title', 'Редактирование страницы'),
('ru', 'admin.meta_title', 'Title'),
('ru', 'admin.meta_description', 'Description'),
('ru', 'admin.canonical', 'Canonical'),
('ru', 'admin.robots', 'Robots'),
('ru', 'admin.og_title', 'OG Title'),
('ru', 'admin.og_description', 'OG Description'),
('ru', 'admin.indexable', 'Индексировать'),
('ru', 'admin.blocks', 'Блоки'),
('ru', 'admin.blocks_title', 'Блоки страницы'),
('ru', 'admin.block_key', 'Ключ блока'),
('ru', 'admin.block_title', 'Заголовок блока'),
('ru', 'admin.block_body', 'Текст блока'),
('ru', 'admin.block_edit_title', 'Редактирование блока'),
('ru', 'admin.sort_order', 'Порядок'),
('ru', 'admin.categories_title', 'Категории'),
('ru', 'admin.category_slug', 'Слаг'),
('ru', 'admin.category_name', 'Название'),
('ru', 'admin.category_h1', 'H1'),
('ru', 'admin.category_description', 'Описание'),
('ru', 'admin.category_edit_title', 'Редактирование категории'),
('ru', 'admin.seo_text', 'SEO текст'),
('ru', 'admin.official_seller', 'Официальный продавец'),
('ru', 'admin.faq', 'FAQ JSON'),
('ru', 'admin.products_title', 'Продукты'),
('ru', 'admin.product_slug', 'Слаг'),
('ru', 'admin.product_sku', 'Артикул'),
('ru', 'admin.product_name', 'Название'),
('ru', 'admin.product_h1', 'H1'),
('ru', 'admin.product_short', 'Краткое описание'),
('ru', 'admin.product_description', 'Описание'),
('ru', 'admin.product_edit_title', 'Редактирование продукта'),
('ru', 'admin.specs', 'Характеристики'),
('ru', 'admin.specs_title', 'Характеристики продукта'),
('ru', 'admin.spec_label', 'Параметр'),
('ru', 'admin.spec_value', 'Значение'),
('ru', 'admin.spec_unit', 'Ед. изм.'),
('ru', 'admin.translations_title', 'Переводы'),
('ru', 'admin.translation_key', 'Ключ'),
('ru', 'admin.translation_value', 'Значение'),
('ru', 'admin.translation_edit_title', 'Редактирование перевода'),
('ru', 'admin.files_title', 'Файлы'),
('ru', 'admin.file_upload', 'Загрузка файла'),
('ru', 'admin.upload', 'Загрузить'),
('ru', 'admin.file_name', 'Имя файла'),
('ru', 'admin.file_path', 'Путь'),
('ru', 'admin.language', 'Язык'),
('ru', 'admin.edit', 'Редактировать'),
('ru', 'admin.save', 'Сохранить'),
('en', 'hero.products', 'Products'),
('en', 'hero.where', 'Where to buy'),
('en', 'where_to_buy.button', 'Partners and suppliers'),
('en', 'official.seller_title', 'Official distributor'),
('en', 'official.seller_text', 'Exclusive official distributor of System Power products'),
('en', 'official.seller_button', 'Go to sissol.ru'),
('en', 'official.seller_link', 'https://sissol.ru'),
('en', 'products.title', 'System Power products'),
('en', 'products.h1', 'Product catalog'),
('en', 'products.meta_title', 'System Power product catalog'),
('en', 'products.meta_description', 'System Power product categories'),
('en', 'faq.title', 'FAQ'),
('en', 'seo.title', 'System Power'),
('en', 'product.description_title', 'Description'),
('en', 'product.specs_title', 'Specifications'),
('en', 'product.documents_title', 'Documentation'),
('en', 'product.related_title', 'Related products'),
('en', 'error.not_found', 'Page not found'),
('en', 'error.not_found_text', 'The requested page is unavailable.'),
('en', 'breadcrumb.home', 'Home');
