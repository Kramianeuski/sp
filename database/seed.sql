-- Seed: AI/SEO updates, content restructuring, FAQ, filters

-- Header slogan + home content + FAQ + form copy
INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('header.slogan', 'ru', 'System Power — инженерные решения, за которые мы отвечаем', 0),
    ('header.slogan', 'en', 'System Power — engineering solutions we stand behind', 0),
    ('header.slogan_sub', 'ru', 'Системный подход к проектированию и производству оборудования для электропитания.', 0),
    ('header.slogan_sub', 'en', 'A systematic approach to designing and manufacturing power supply equipment.', 0),
    ('home.hero.title', 'ru', 'System Power — инженерные решения, за которые мы отвечаем', 0),
    ('home.hero.title', 'en', 'System Power — engineering solutions we stand behind', 0),
    ('home.hero.subtitle', 'ru', 'Системный подход к проектированию и производству оборудования для электропитания', 0),
    ('home.hero.subtitle', 'en', 'A systematic approach to designing and manufacturing power supply equipment', 0),
    ('home.production.title', 'ru', 'Производство и инженерный подход', 0),
    ('home.production.title', 'en', 'Manufacturing and engineering approach', 0),
    ('home.production.text', 'ru', '<p>System Power — российская производственная компания, специализирующаяся на разработке и изготовлении электротехнического оборудования для систем распределения и защиты электропитания.</p><p>Компания «Системные Решения» успешно развивается с 2014 года. В 2022 году, на основе накопленного практического опыта в поставках электрооборудования и понимания реальных потребностей заказчиков, было запущено собственное производство под торговой маркой System Power.</p><p>Мы проектируем и производим оборудование, исходя из условий эксплуатации и задач объекта, а не абстрактных требований каталога.</p>', 1),
    ('home.production.text', 'en', '<p>System Power is a Russian manufacturing company specializing in the development and production of electrical equipment for power distribution and protection systems.</p><p>The System Solutions company has been operating successfully since 2014. In 2022, based on accumulated practical experience in supplying electrical equipment and an understanding of real customer needs, we launched our own production under the System Power brand.</p><p>We design and manufacture equipment based on operating conditions and the tasks of the facility, not abstract catalog requirements.</p>', 1),
    ('home.workflow.title', 'ru', 'Как мы работаем', 0),
    ('home.workflow.title', 'en', 'How we work', 0),
    ('home.workflow.text', 'ru', '<p>Мы рассматриваем каждое изделие как инженерную систему, а не как отдельный продукт. Наша задача — обеспечить стабильную и безопасную работу оборудования в реальных условиях эксплуатации.</p><ul><li>анализ условий эксплуатации и требований объекта</li><li>подбор оптимальных технических решений</li><li>проектирование и производство оборудования</li><li>контроль качества и проверка схем</li><li>техническая поддержка и сопровождение</li></ul><p>Наша работа не заканчивается передачей оборудования заказчику. Мы остаёмся на связи и несем ответственность за принятые инженерные решения.</p>', 1),
    ('home.workflow.text', 'en', '<p>We treat every unit as an engineering system, not just a standalone product. Our task is to ensure stable and safe operation in real-world conditions.</p><ul><li>analysis of operating conditions and project requirements</li><li>selection of optimal technical solutions</li><li>design and manufacturing of equipment</li><li>quality control and schematic verification</li><li>technical support and after-sales assistance</li></ul><p>Our work does not end with delivery. We stay in touch and take responsibility for the engineering decisions made.</p>', 1),
    ('home.usage.title', 'ru', 'Где применяется оборудование System Power', 0),
    ('home.usage.title', 'en', 'Where System Power equipment is used', 0),
    ('home.usage.text', 'ru', '<p>Оборудование System Power применяется в системах электропитания на следующих типах объектов:</p><ul><li>строительные площадки</li><li>промышленные объекты</li><li>коммерческая недвижимость</li><li>инфраструктурные и инженерные системы</li><li>временные и полустационарные объекты</li></ul><p>Все изделия проектируются с учетом условий эксплуатации и нормативных требований.</p>', 1),
    ('home.usage.text', 'en', '<p>System Power equipment is used in power supply systems at the following types of facilities:</p><ul><li>construction sites</li><li>industrial facilities</li><li>commercial real estate</li><li>infrastructure and engineering systems</li><li>temporary and semi-permanent facilities</li></ul><p>All products are designed with operating conditions and regulatory requirements in mind.</p>', 1),
    ('home.responsibility.title', 'ru', 'Ответственность производителя', 0),
    ('home.responsibility.title', 'en', 'Manufacturer responsibility', 0),
    ('home.responsibility.text', 'ru', '<p>Мы понимаем, что от надежности электротехнического оборудования зависит стабильная работа инженерных систем и безопасность на объекте.</p><p>Именно поэтому System Power — это не просто производство, а ответственность за каждое выпущенное изделие.</p>', 1),
    ('home.responsibility.text', 'en', '<p>We understand that the reliability of electrical equipment determines the stable operation of engineering systems and safety at the facility.</p><p>That is why System Power is not just manufacturing, but responsibility for every unit produced.</p>', 1),
    ('home.products.title', 'ru', 'Продукция', 0),
    ('home.products.title', 'en', 'Products', 0),
    ('home.faq.title', 'ru', 'Часто задаваемые вопросы', 0),
    ('home.faq.title', 'en', 'Frequently asked questions', 0),
    ('home.faq.q1', 'ru', 'Что производит компания System Power?', 0),
    ('home.faq.q1', 'en', 'What does System Power manufacture?', 0),
    ('home.faq.a1', 'ru', 'System Power производит электротехнические шкафы и распределительные устройства для систем электропитания промышленных и коммерческих объектов.', 0),
    ('home.faq.a1', 'en', 'System Power manufactures electrical enclosures and distribution units for power supply systems in industrial and commercial facilities.', 0),
    ('home.faq.q2', 'ru', 'Можно ли изготовить оборудование по индивидуальному проекту?', 0),
    ('home.faq.q2', 'en', 'Can equipment be manufactured to a custom project?', 0),
    ('home.faq.a2', 'ru', 'Да, компания System Power выполняет проектирование и производство оборудования по техническому заданию заказчика.', 0),
    ('home.faq.a2', 'en', 'Yes. System Power designs and manufactures equipment according to the customer’s technical specification.', 0),
    ('home.faq.q3', 'ru', 'Где находится производство System Power?', 0),
    ('home.faq.q3', 'en', 'Where is System Power manufacturing located?', 0),
    ('home.faq.a3', 'ru', 'Производственные мощности System Power расположены в Смоленске, Российская Федерация.', 0),
    ('home.faq.a3', 'en', 'System Power manufacturing facilities are located in Smolensk, Russian Federation.', 0),
    ('home.faq.q4', 'ru', 'Какие комплектующие используются в оборудовании?', 0),
    ('home.faq.q4', 'en', 'Which components are used in the equipment?', 0),
    ('home.faq.a4', 'ru', 'В базовых комплектациях используются комплектующие IEK, TDM, EKF. По запросу возможна установка ABB, DKC, System Electric, Schneider Electric и других брендов.', 0),
    ('home.faq.a4', 'en', 'Base configurations use IEK, TDM, and EKF components. On request, ABB, DKC, System Electric, Schneider Electric, and other brands can be installed.', 0),
    ('home.faq.q5', 'ru', 'Кто несет ответственность за качество оборудования?', 0),
    ('home.faq.q5', 'en', 'Who is responsible for equipment quality?', 0),
    ('home.faq.a5', 'ru', 'Ответственность за качество и соответствие оборудования техническим требованиям несет компания System Power как производитель.', 0),
    ('home.faq.a5', 'en', 'System Power, as the manufacturer, is responsible for quality and compliance with technical requirements.', 0),
    ('faq.title', 'ru', 'Часто задаваемые вопросы', 0),
    ('faq.title', 'en', 'Frequently asked questions', 0),
    ('faq.hatches.q1', 'ru', 'Что такое напольный лючок?', 0),
    ('faq.hatches.q1', 'en', 'What is a floor box?', 0),
    ('faq.hatches.a1', 'ru', 'Напольный лючок — это электротехническое изделие для организации удобного и безопасного доступа к электрическим и слаботочным подключениям, установленным в полу.', 0),
    ('faq.hatches.a1', 'en', 'A floor box is electrical equipment that provides convenient and safe access to power and low-current connections installed in a floor.', 0),
    ('faq.hatches.q2', 'ru', 'Для чего используются напольные лючки?', 0),
    ('faq.hatches.q2', 'en', 'What are floor boxes used for?', 0),
    ('faq.hatches.a2', 'ru', 'Напольные лючки используются для подключения электрооборудования и оргтехники, организации рабочих мест в помещениях с открытой планировкой и размещения точек электропитания и связи вдали от стен.', 0),
    ('faq.hatches.a2', 'en', 'Floor boxes are used for connecting equipment and office devices, organizing workplaces in open-plan spaces, and placing power and data points away from walls.', 0),
    ('faq.hatches.q3', 'ru', 'Где применяются напольные лючки?', 0),
    ('faq.hatches.q3', 'en', 'Where are floor boxes used?', 0),
    ('faq.hatches.a3', 'ru', 'Напольные лючки применяются в офисных помещениях, коммерческой недвижимости, общественных и административных зданиях.', 0),
    ('faq.hatches.a3', 'en', 'Floor boxes are used in office spaces, commercial real estate, and public or administrative buildings.', 0),
    ('faq.hatches.q4', 'ru', 'Что означает количество модулей в напольном лючке?', 0),
    ('faq.hatches.q4', 'en', 'What does the module count mean?', 0),
    ('faq.hatches.a4', 'ru', 'Количество модулей обозначает число посадочных мест внутри корпуса лючка. Чем больше модулей, тем больше подключений можно установить.', 0),
    ('faq.hatches.a4', 'en', 'The module count indicates the number of mounting slots inside the box. The more modules, the more connections can be installed.', 0),
    ('faq.hatches.q5', 'ru', 'Какие модули можно установить в напольный лючок?', 0),
    ('faq.hatches.q5', 'en', 'Which modules can be installed?', 0),
    ('faq.hatches.a5', 'ru', 'Лючки рассчитаны на модули формата 22,5×45 мм. Возможны силовые розетки 220 В, RJ45, мультимедийные и комбинированные решения. Одна стандартная розетка 220 В занимает два модуля.', 0),
    ('faq.hatches.a5', 'en', 'The boxes are designed for 22.5×45 mm modules. Power sockets 220 V, RJ45, multimedia, and mixed configurations are possible. One standard 220 V socket occupies two modules.', 0),
    ('faq.hatches.q6', 'ru', 'Подойдут ли мои розетки для установки и можно ли изменить комплектацию?', 0),
    ('faq.hatches.q6', 'en', 'Will my sockets fit, and can the configuration be changed?', 0),
    ('faq.hatches.a6', 'ru', 'Лючки System Power совместимы с модульными механизмами формата 22,5×45 мм, включая Mosaic®. Возможна индивидуальная комплектация по количеству и типу модулей.', 0),
    ('faq.hatches.a6', 'en', 'System Power floor boxes are compatible with 22.5×45 mm modular mechanisms, including Mosaic®. Custom configurations are possible by module count and type.', 0),
    ('faq.hatches.q7', 'ru', 'Какие розетки используются по умолчанию?', 0),
    ('faq.hatches.q7', 'en', 'Which sockets are used by default?', 0),
    ('faq.hatches.a7', 'ru', 'В стандартной комплектации используются силовые розетки 220 В. По запросу возможны решения со степенью защиты IP44 или IP54.', 0),
    ('faq.hatches.a7', 'en', 'Standard configurations use 220 V power sockets. On request, IP44 or IP54 protection options are available.', 0),
    ('faq.hatches.q8', 'ru', 'Из какого материала изготовлен корпус?', 0),
    ('faq.hatches.q8', 'en', 'What material is the housing made of?', 0),
    ('faq.hatches.a8', 'ru', 'В базовой комплектации корпус изготовлен из стали. По запросу возможны варианты из алюминия.', 0),
    ('faq.hatches.a8', 'en', 'The base housing is made of steel. Aluminum options are available on request.', 0),
    ('faq.hatches.q9', 'ru', 'Предусмотрены ли вводы кабеля в корпусе лючка?', 0),
    ('faq.hatches.q9', 'en', 'Are cable entries provided?', 0),
    ('faq.hatches.a9', 'ru', 'Да. Корпус оснащён штампованными отверстиями для ввода труб стандарта M25, что упрощает монтаж и прокладку кабельных трасс.', 0),
    ('faq.hatches.a9', 'en', 'Yes. The housing has stamped openings for M25 conduit entries, which simplifies installation and cable routing.', 0),
    ('faq.hatches.q10', 'ru', 'Где производится оборудование System Power?', 0),
    ('faq.hatches.q10', 'en', 'Where is System Power equipment manufactured?', 0),
    ('faq.hatches.a10', 'ru', 'Все напольные лючки System Power производятся в Российской Федерации.', 0),
    ('faq.hatches.a10', 'en', 'All System Power floor boxes are manufactured in the Russian Federation.', 0),
    ('faq.rusp.q1', 'ru', 'Что такое РУСП?', 0),
    ('faq.rusp.q1', 'en', 'What is RUSP?', 0),
    ('faq.rusp.a1', 'ru', 'РУСП — распределительное устройство для строительных площадок, предназначенное для безопасного подключения, распределения и защиты электрооборудования.', 0),
    ('faq.rusp.a1', 'en', 'RUSP is a distribution unit for construction sites designed for safe connection, distribution, and protection of electrical equipment.', 0),
    ('faq.rusp.q2', 'ru', 'Нет варианта, который подходит мне. Что делать?', 0),
    ('faq.rusp.q2', 'en', 'I need a custom configuration. What should I do?', 0),
    ('faq.rusp.a2', 'ru', 'System Power изготавливает РУСП по индивидуальному техническому заданию. Доступны параметры: номинальный ток от 32А до 120А, степень защиты корпуса от IP44 до IP54, напольное или настенное исполнение, индивидуальная комплектация розеток и защитных аппаратов.', 0),
    ('faq.rusp.a2', 'en', 'System Power manufactures RUSP according to a custom technical specification. Available parameters include rated current from 32A to 120A, enclosure protection from IP44 to IP54, floor or wall mounting, and custom socket/protection configurations.', 0),
    ('faq.rusp.q3', 'ru', 'Комплектующие каких брендов используются?', 0),
    ('faq.rusp.q3', 'en', 'Which component brands are used?', 0),
    ('faq.rusp.a3', 'ru', 'В базовых комплектациях используются компоненты IEK, TDM, EKF. По запросу возможна установка ABB, DKC, System Electric, Schneider Electric и других брендов.', 0),
    ('faq.rusp.a3', 'en', 'Base configurations use IEK, TDM, EKF components. On request, ABB, DKC, System Electric, Schneider Electric, and other brands can be installed.', 0),
    ('faq.rusp.q4', 'ru', 'Можно ли купить РУСП сегодня?', 0),
    ('faq.rusp.q4', 'en', 'Can I buy RUSP immediately?', 0),
    ('faq.rusp.a4', 'ru', 'В карточках товаров указаны партнёры и дистрибьюторы, у которых оборудование может быть доступно на складе. При наличии товара возможно оформление заказа в день обращения.', 0),
    ('faq.rusp.a4', 'en', 'Product cards list partners and distributors where equipment may be in stock. If available, an order can be processed the same day.', 0),
    ('faq.rusp.q5', 'ru', 'Какая стандартная комплектация РУСП?', 0),
    ('faq.rusp.q5', 'en', 'What is the standard RUSP configuration?', 0),
    ('faq.rusp.a5', 'ru', 'Стандартная комплектация включает щит РУСП, ключи от дверей, паспорт изделия, электрическую схему и сертификат соответствия.', 0),
    ('faq.rusp.a5', 'en', 'The standard set includes the RUSP panel, door keys, product passport, wiring diagram, and certificate of conformity.', 0),
    ('faq.rusp.q6', 'ru', 'Где производится оборудование System Power?', 0),
    ('faq.rusp.q6', 'en', 'Where is System Power equipment manufactured?', 0),
    ('faq.rusp.a6', 'ru', 'Все распределительные устройства System Power производятся в Российской Федерации.', 0),
    ('faq.rusp.a6', 'en', 'All System Power distribution units are manufactured in the Russian Federation.', 0),
    ('product.sku', 'ru', 'Артикул:', 0),
    ('product.sku', 'en', 'SKU:', 0),
    ('product.country', 'ru', 'Страна производства: Российская Федерация 🇷🇺', 0),
    ('product.country', 'en', 'Country of origin: Russian Federation 🇷🇺', 0),
    ('form.telegram_placeholder', 'ru', '@username', 0),
    ('form.telegram_placeholder', 'en', '@username', 0),
    ('form.telegram_hint', 'ru', 'Укажите никнейм в формате @username', 0),
    ('form.telegram_hint', 'en', 'Enter your username in the format @username', 0),
    ('form.error.contact', 'ru', 'Укажите контактные данные выбранного способа связи.', 0),
    ('form.error.contact', 'en', 'Provide contact details for the selected communication method.', 0),
    ('form.error.email', 'ru', 'Укажите корректный адрес электронной почты.', 0),
    ('form.error.email', 'en', 'Enter a valid email address.', 0),
    ('form.error.telegram', 'ru', 'Никнейм Telegram должен начинаться с символа @.', 0),
    ('form.error.telegram', 'en', 'Telegram username must start with @.', 0),
    ('form.consent', 'ru', 'Согласен на обработку персональных данных', 0),
    ('form.consent', 'en', 'I consent to the processing of personal data', 0)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

-- Category descriptions
UPDATE category_i18n
SET description = '<p>Напольные лючки System Power предназначены для организации точек подключения к электросети и слаботочным линиям в полу.</p><p>Решения подходят для офисов, коммерческих и общественных пространств. Лючки совместимы с модулями 22,5×45 мм и системами Mosaic®.</p><ul><li>степень защиты корпуса: IP54</li><li>варианты по числу модулей и установочных мест</li><li>корпус из стали, возможны варианты из алюминия</li></ul>',
    is_html = 1
WHERE category_id = 1 AND locale = 'ru';

UPDATE category_i18n
SET description = '<p>System Power floor boxes are designed for organizing access to power and low-current connections in floors.</p><p>Suitable for office, commercial, and public spaces. Compatible with 22.5×45 mm modules and Mosaic® systems.</p><ul><li>enclosure protection: IP54</li><li>options by module count and capacity</li><li>steel housing with aluminum options on request</li></ul>',
    is_html = 1
WHERE category_id = 1 AND locale = 'en';

UPDATE category_i18n
SET description = '<p>РУСП System Power — распределительные устройства для строительных площадок и временных объектов.</p><p>Шкафы обеспечивают распределение электропитания и защиту линий. Комплектации подбираются по току, типу исполнения и степени защиты.</p><ul><li>номинальный ток: от 32А до 120А</li><li>степень защиты корпуса: IP44</li><li>напольное или настенное исполнение</li></ul>',
    is_html = 1
WHERE category_id = 2 AND locale = 'ru';

UPDATE category_i18n
SET description = '<p>System Power RUSP units are distribution enclosures for construction sites and temporary facilities.</p><p>The cabinets provide power distribution and line protection. Configurations are selected by current, mounting type, and protection class.</p><ul><li>rated current: 32A to 120A</li><li>enclosure protection: IP44</li><li>floor-standing or wall-mounted version</li></ul>',
    is_html = 1
WHERE category_id = 2 AND locale = 'en';

-- Home page sections
DELETE FROM page_sections WHERE page_id = 1;
INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (1, 'hero', 1, 'hero_video', '{"title_key":"home.hero.title","subtitle_key":"home.hero.subtitle","cta_primary":{"text_key":"home.hero.cta_primary","url":"/ru/products/","style":"accent-primary"},"cta_secondary":{"text_key":"home.hero.cta_secondary","url":"/ru/custom-production/","style":"accent-secondary"},"overlay_opacity":0.45,"gradient":true}', NOW(), NOW()),
    (1, 'production', 2, 'text_block', '{"title_key":"home.production.title","text_key":"home.production.text"}', NOW(), NOW()),
    (1, 'workflow', 3, 'text_block', '{"title_key":"home.workflow.title","text_key":"home.workflow.text"}', NOW(), NOW()),
    (1, 'usage', 4, 'text_block', '{"title_key":"home.usage.title","text_key":"home.usage.text"}', NOW(), NOW()),
    (1, 'responsibility', 5, 'text_block', '{"title_key":"home.responsibility.title","text_key":"home.responsibility.text"}', NOW(), NOW()),
    (1, 'products', 6, 'category_cards', '{"title_key":"home.products.title","items":[{"category_code":"hatches","title_key":"home.categories.hatches.title","text_key":"home.categories.hatches.text","image_id":3,"url":"/ru/products/hatches/"},{"category_code":"electrical_cabinets","title_key":"home.categories.cabinets.title","text_key":"home.categories.cabinets.text","image_id":3,"url":"/ru/products/electrical-cabinets/"}]}', NOW(), NOW()),
    (1, 'faq', 7, 'faq_block', '{"title_key":"home.faq.title","items":[{"question_key":"home.faq.q1","answer_key":"home.faq.a1"},{"question_key":"home.faq.q2","answer_key":"home.faq.a2"},{"question_key":"home.faq.q3","answer_key":"home.faq.a3"},{"question_key":"home.faq.q4","answer_key":"home.faq.a4"},{"question_key":"home.faq.q5","answer_key":"home.faq.a5"}]}', NOW(), NOW());

-- Custom production page sections
DELETE FROM page_sections WHERE page_id = 3;
INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (3, 'custom-intro', 1, 'text_block', '{"text_key":"custom.production.intro"}', NOW(), NOW()),
    (3, 'custom-base', 2, 'text_block', '{"title_key":"custom.production.base.title","text_key":"custom.production.base.text"}', NOW(), NOW()),
    (3, 'custom-benefits', 3, 'text_block', '{"title_key":"custom.production.benefits.title","text_key":"custom.production.benefits.text"}', NOW(), NOW()),
    (3, 'custom-control', 4, 'text_block', '{"title_key":"custom.production.control.title","text_key":"custom.production.control.text"}', NOW(), NOW()),
    (3, 'custom-faq', 5, 'faq_block', '{"title_key":"custom.production.faq.title","items":[{"question_key":"custom.production.faq.q1","answer_key":"custom.production.faq.a1"},{"question_key":"custom.production.faq.q2","answer_key":"custom.production.faq.a2"},{"question_key":"custom.production.faq.q3","answer_key":"custom.production.faq.a3"},{"question_key":"custom.production.faq.q4","answer_key":"custom.production.faq.a4"},{"question_key":"custom.production.faq.q5","answer_key":"custom.production.faq.a5"}]}', NOW(), NOW()),
    (3, 'custom-form', 6, 'custom_production', '{"title_key":"custom.form.title","intro_key":"custom.form.text"}', NOW(), NOW());

-- Quality page sections
DELETE FROM page_sections WHERE page_id = 4;
INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (4, 'quality-intro', 1, 'text_block', '{"text_key":"quality.intro"}', NOW(), NOW()),
    (4, 'quality-steps', 2, 'text_block', '{"title_key":"quality.steps.title","text_key":"quality.steps.text"}', NOW(), NOW()),
    (4, 'quality-docs', 3, 'text_block', '{"title_key":"quality.docs.title","text_key":"quality.docs.text"}', NOW(), NOW()),
    (4, 'about-company', 4, 'text_block', '{"title_key":"about.title","text_key":"about.text"}', NOW(), NOW()),
    (4, 'about-production', 5, 'text_block', '{"title_key":"about.production.title","text_key":"about.production.text"}', NOW(), NOW()),
    (4, 'about-approach', 6, 'text_block', '{"title_key":"about.approach.title","text_key":"about.approach.text"}', NOW(), NOW());

-- Add new pages
INSERT INTO pages (id, slug, status)
VALUES (7, 'about', 'published')
ON DUPLICATE KEY UPDATE status = VALUES(status);

INSERT INTO pages (id, slug, status)
VALUES (8, 'personal-data', 'published')
ON DUPLICATE KEY UPDATE status = VALUES(status);

DELETE FROM page_sections WHERE page_id = 7;
INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (7, 'about-intro', 1, 'text_block', '{"text_key":"about.text"}', NOW(), NOW()),
    (7, 'about-production', 2, 'text_block', '{"title_key":"about.production.title","text_key":"about.production.text"}', NOW(), NOW()),
    (7, 'about-approach', 3, 'text_block', '{"title_key":"about.approach.title","text_key":"about.approach.text"}', NOW(), NOW());

DELETE FROM page_sections WHERE page_id = 8;
INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (8, 'privacy', 1, 'text_block', '{"text_key":"privacy.text"}', NOW(), NOW());

-- Page meta updates
UPDATE seo_meta
SET title = 'System Power — инженерные решения',
    description = 'System Power — инженерные решения и производство электротехнического оборудования для систем электропитания.',
    h1 = 'System Power — инженерные решения, за которые мы отвечаем'
WHERE entity_type = 'page' AND entity_id = 1 AND locale = 'ru';

UPDATE seo_meta
SET title = 'System Power — engineering solutions',
    description = 'System Power manufactures electrical equipment for power distribution and protection systems.',
    h1 = 'System Power — engineering solutions we stand behind'
WHERE entity_type = 'page' AND entity_id = 1 AND locale = 'en';

UPDATE seo_meta
SET title = 'Собственное производство System Power',
    description = 'Собственное производство электротехнического оборудования System Power в Смоленске.',
    h1 = 'Собственное производство System Power'
WHERE entity_type = 'page' AND entity_id = 3 AND locale = 'ru';

UPDATE seo_meta
SET title = 'System Power in-house manufacturing',
    description = 'In-house manufacturing of System Power electrical equipment in Smolensk.',
    h1 = 'System Power in-house manufacturing'
WHERE entity_type = 'page' AND entity_id = 3 AND locale = 'en';

UPDATE seo_meta
SET title = 'Контроль качества',
    description = 'Контроль качества и ответственность производителя System Power.',
    h1 = 'Контроль качества и ответственность производителя'
WHERE entity_type = 'page' AND entity_id = 4 AND locale = 'ru';

UPDATE seo_meta
SET title = 'Quality control',
    description = 'Quality control and manufacturer responsibility at System Power.',
    h1 = 'Quality control and manufacturer responsibility'
WHERE entity_type = 'page' AND entity_id = 4 AND locale = 'en';

INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, created_at, updated_at)
VALUES
    ('page', 7, 'ru', 'О компании System Power', 'О компании System Power и производственном подходе.', 'О компании System Power', 'about', NOW(), NOW()),
    ('page', 7, 'en', 'About System Power', 'About System Power and its manufacturing approach.', 'About System Power', 'about', NOW(), NOW()),
    ('page', 8, 'ru', 'Политика конфиденциальности', 'Политика обработки персональных данных System Power.', 'Политика конфиденциальности', 'personal-data', NOW(), NOW()),
    ('page', 8, 'en', 'Privacy policy', 'System Power personal data processing policy.', 'Privacy policy', 'personal-data', NOW(), NOW());

-- Custom production content
INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('custom.production.intro', 'ru', '<p>System Power — производственная компания, осуществляющая разработку и выпуск электротехнического оборудования на собственных производственных мощностях.</p><p>Собственное производство позволяет нам контролировать качество изделий, адаптировать оборудование под задачи заказчика и нести ответственность за инженерные решения.</p>', 1),
    ('custom.production.intro', 'en', '<p>System Power is a manufacturing company that develops and produces electrical equipment on its own facilities.</p><p>In-house manufacturing allows us to control product quality, adapt equipment to customer tasks, and take responsibility for engineering decisions.</p>', 1),
    ('custom.production.base.title', 'ru', 'Производственная база', 0),
    ('custom.production.base.title', 'en', 'Manufacturing base', 0),
    ('custom.production.base.text', 'ru', '<p>Производственные мощности System Power расположены в Смоленске.</p><p>Производство соответствует современным требованиям промышленной безопасности, охраны труда и экологических нормативов.</p><p>Все процессы организованы с учетом действующих стандартов и требований к электротехническому производству.</p>', 1),
    ('custom.production.base.text', 'en', '<p>System Power manufacturing facilities are located in Smolensk.</p><p>The production site complies with modern industrial safety, labor protection, and environmental requirements.</p><p>All processes are organized according to current standards for electrical manufacturing.</p>', 1),
    ('custom.production.benefits.title', 'ru', 'Что дает собственное производство', 0),
    ('custom.production.benefits.title', 'en', 'What in-house manufacturing provides', 0),
    ('custom.production.benefits.text', 'ru', '<ul><li>разработку изделий под конкретные условия эксплуатации</li><li>гибкую комплектацию оборудования</li><li>контроль качества на всех этапах</li><li>техническую поддержку и сопровождение</li></ul><p>Мы не являемся сборочной площадкой без ответственности — все решения принимаются на инженерном уровне.</p>', 1),
    ('custom.production.benefits.text', 'en', '<ul><li>development for specific operating conditions</li><li>flexible equipment configurations</li><li>quality control at every stage</li><li>technical support and assistance</li></ul><p>We are not a simple assembly shop without responsibility — all decisions are made at the engineering level.</p>', 1),
    ('custom.production.control.title', 'ru', 'Инженерный контроль и ответственность', 0),
    ('custom.production.control.title', 'en', 'Engineering control and responsibility', 0),
    ('custom.production.control.text', 'ru', '<p>Каждое изделие проходит контроль сборки, соответствия схемам и финальную проверку перед отгрузкой.</p><p>Мы понимаем, что от надежности оборудования зависит безопасность эксплуатации на объекте, и поэтому несем ответственность за выпускаемые изделия.</p>', 1),
    ('custom.production.control.text', 'en', '<p>Each unit undergoes assembly control, schematic compliance checks, and final inspection before shipment.</p><p>We understand that equipment reliability affects operational safety, so we take responsibility for the products we manufacture.</p>', 1),
    ('custom.production.faq.title', 'ru', 'Часто задаваемые вопросы', 0),
    ('custom.production.faq.title', 'en', 'Frequently asked questions', 0),
    ('custom.production.faq.q1', 'ru', 'Где расположено производство System Power?', 0),
    ('custom.production.faq.q1', 'en', 'Where is System Power production located?', 0),
    ('custom.production.faq.a1', 'ru', 'Производственные мощности System Power расположены в Смоленске, Российская Федерация.', 0),
    ('custom.production.faq.a1', 'en', 'System Power production facilities are located in Smolensk, Russian Federation.', 0),
    ('custom.production.faq.q2', 'ru', 'Соответствует ли производство требованиям безопасности и экологии?', 0),
    ('custom.production.faq.q2', 'en', 'Does production comply with safety and environmental requirements?', 0),
    ('custom.production.faq.a2', 'ru', 'Да, производство соответствует современным требованиям промышленной безопасности, охраны труда и экологических нормативов.', 0),
    ('custom.production.faq.a2', 'en', 'Yes. Production complies with modern industrial safety, labor protection, and environmental standards.', 0),
    ('custom.production.faq.q3', 'ru', 'Является ли System Power производителем или сборщиком?', 0),
    ('custom.production.faq.q3', 'en', 'Is System Power a manufacturer or an assembler?', 0),
    ('custom.production.faq.a3', 'ru', 'System Power является производителем электротехнического оборудования. Проектирование, подбор комплектующих, сборка и контроль качества выполняются на собственных мощностях компании.', 0),
    ('custom.production.faq.a3', 'en', 'System Power is a manufacturer of electrical equipment. Design, component selection, assembly, and quality control are performed in-house.', 0),
    ('custom.production.faq.q4', 'ru', 'Можно ли изготовить оборудование под индивидуальное техническое задание?', 0),
    ('custom.production.faq.q4', 'en', 'Can equipment be made to a custom technical specification?', 0),
    ('custom.production.faq.a4', 'ru', 'Да, собственное производство позволяет изготавливать оборудование по индивидуальному техническому заданию с учетом условий эксплуатации и требований заказчика.', 0),
    ('custom.production.faq.a4', 'en', 'Yes. In-house manufacturing allows equipment to be produced to a custom specification based on operating conditions and customer requirements.', 0),
    ('custom.production.faq.q5', 'ru', 'Кто несет ответственность за качество оборудования?', 0),
    ('custom.production.faq.q5', 'en', 'Who is responsible for equipment quality?', 0),
    ('custom.production.faq.a5', 'ru', 'Ответственность за качество и соответствие оборудования техническим требованиям несет компания System Power как производитель.', 0),
    ('custom.production.faq.a5', 'en', 'System Power, as the manufacturer, is responsible for quality and compliance with technical requirements.', 0),
    ('custom.form.title', 'ru', 'Запрос на производство', 0),
    ('custom.form.title', 'en', 'Manufacturing request', 0),
    ('custom.form.text', 'ru', 'Опишите задачу и выберите удобный способ связи. Мы ответим после технического рассмотрения запроса.', 0),
    ('custom.form.text', 'en', 'Describe your task and choose a convenient contact method. We will respond after a technical review.', 0)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

-- Quality + About content
INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('quality.intro', 'ru', '<p>Качество оборудования System Power формируется на всех этапах производства — от подбора комплектующих до финальной проверки готового изделия.</p><p>Контроль качества является частью инженерного процесса и направлен на обеспечение надежной и безопасной эксплуатации оборудования.</p>', 1),
    ('quality.intro', 'en', '<p>System Power quality is formed at every stage — from component selection to final inspection of the finished product.</p><p>Quality control is part of the engineering process and ensures reliable and safe operation of the equipment.</p>', 1),
    ('quality.steps.title', 'ru', 'Этапы контроля качества', 0),
    ('quality.steps.title', 'en', 'Quality control stages', 0),
    ('quality.steps.text', 'ru', '<ul><li>входной контроль комплектующих</li><li>контроль сборки и монтажа</li><li>проверка электрических соединений</li><li>контроль соответствия электрическим схемам</li><li>финальная функциональная и визуальная проверка</li></ul>', 1),
    ('quality.steps.text', 'en', '<ul><li>incoming inspection of components</li><li>assembly and installation control</li><li>verification of electrical connections</li><li>compliance with electrical schematics</li><li>final functional and visual inspection</li></ul>', 1),
    ('quality.docs.title', 'ru', 'Документация и соответствие', 0),
    ('quality.docs.title', 'en', 'Documentation and compliance', 0),
    ('quality.docs.text', 'ru', '<p>Оборудование System Power сопровождается технической документацией, которая может включать:</p><ul><li>паспорт изделия</li><li>электрическую схему</li><li>сертификаты соответствия</li></ul><p>Перечень документации зависит от типа изделия и требований проекта.</p>', 1),
    ('quality.docs.text', 'en', '<p>System Power equipment is supplied with technical documentation that may include:</p><ul><li>product passport</li><li>electrical diagram</li><li>certificates of conformity</li></ul><p>The documentation set depends on product type and project requirements.</p>', 1),
    ('about.title', 'ru', 'О компании System Power', 0),
    ('about.title', 'en', 'About System Power', 0),
    ('about.text', 'ru', '<p>System Power — торговая марка производственной компании «Системные Решения».</p><p>Компания начала деятельность в 2014 году с поставок электротехнического оборудования. Работа с различными объектами и заказчиками позволила накопить практический опыт и глубокое понимание требований к электротехническим системам.</p><p>В 2022 году было запущено собственное производство под брендом System Power.</p>', 1),
    ('about.text', 'en', '<p>System Power is a trademark of the manufacturing company System Solutions.</p><p>The company started operations in 2014 with the supply of electrical equipment. Work with various facilities and customers provided practical experience and a deep understanding of requirements for electrical systems.</p><p>In 2022, in-house manufacturing was launched under the System Power brand.</p>', 1),
    ('about.production.title', 'ru', 'Почему собственное производство', 0),
    ('about.production.title', 'en', 'Why in-house manufacturing', 0),
    ('about.production.text', 'ru', '<ul><li>контроль качества оборудования</li><li>гибкая адаптация изделий под задачи заказчика</li><li>учет реальных условий эксплуатации</li><li>техническая поддержка</li></ul><p>Мы производим оборудование, за которое готовы нести ответственность.</p>', 1),
    ('about.production.text', 'en', '<ul><li>quality control of equipment</li><li>flexible adaptation to customer tasks</li><li>consideration of real operating conditions</li><li>technical support</li></ul><p>We manufacture equipment we are ready to stand behind.</p>', 1),
    ('about.approach.title', 'ru', 'Наш подход', 0),
    ('about.approach.title', 'en', 'Our approach', 0),
    ('about.approach.text', 'ru', '<p>System Power — это системность в проектировании, инженерная логика в решениях и ответственность за результат.</p><p>Мы ориентируемся на профессиональных заказчиков и долгосрочную эксплуатацию оборудования.</p>', 1),
    ('about.approach.text', 'en', '<p>System Power is about systematic design, engineering logic in decisions, and responsibility for results.</p><p>We focus on professional customers and long-term equipment operation.</p>', 1),
    ('privacy.text', 'ru', '<h2>Общие положения</h2><p>Использование сайта означает согласие пользователя с настоящей Политикой конфиденциальности и условиями обработки персональных данных.</p><p>Настоящая Политика разработана в соответствии с Федеральным законом РФ № 152-ФЗ «О персональных данных».</p><p>Оператор персональных данных — ООО «Системные Решения», ИНН 6950156688.</p><h2>Персональные данные пользователей</h2><p>К персональным данным относятся имя, фамилия, email, телефон, данные мессенджеров (Telegram, WhatsApp), организация и содержание сообщения.</p><p>Также могут обрабатываться обезличенные данные: IP-адрес, cookie, сведения о браузере и действиях пользователя на сайте.</p><h2>Цели обработки</h2><ul><li>обработка обращений и запросов пользователей</li><li>обратная связь по выбранному способу связи</li><li>предоставление технической и консультационной информации</li><li>выполнение требований законодательства РФ</li></ul><h2>Правовые основания</h2><p>Обработка персональных данных осуществляется на основании согласия пользователя и требований законодательства РФ.</p><h2>Срок хранения</h2><p>Персональные данные хранятся не дольше, чем это требуется для достижения целей обработки, либо в сроки, установленные законом.</p>', 1),
    ('privacy.text', 'en', '<h2>General provisions</h2><p>Using the site means the user agrees to this Privacy Policy and the terms of personal data processing.</p><p>This Policy is developed in accordance with Federal Law of the Russian Federation No. 152-FZ “On Personal Data”.</p><p>The personal data operator is System Solutions LLC.</p><h2>User personal data</h2><p>Personal data includes name, email, phone, messenger contacts (Telegram, WhatsApp), organization, and message content.</p><p>Depersonalized data such as IP address, cookies, and browser information may also be processed.</p><h2>Processing purposes</h2><ul><li>handling user inquiries and requests</li><li>providing feedback via the chosen contact method</li><li>providing technical and consultation information</li><li>compliance with Russian law</li></ul><h2>Legal basis</h2><p>Personal data is processed based on user consent and legal requirements.</p><h2>Retention period</h2><p>Personal data is stored only as long as necessary to achieve processing purposes or as required by law.</p>', 1)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

-- IP protection updates
UPDATE product_i18n pi
JOIN products p ON p.id = pi.product_id
SET pi.name = REPLACE(pi.name, 'IP41', 'IP54'),
    pi.short_description = REPLACE(pi.short_description, 'IP41', 'IP54'),
    pi.description = REPLACE(pi.description, 'IP41', 'IP54')
WHERE p.category_id = 1;

UPDATE product_i18n pi
JOIN products p ON p.id = pi.product_id
SET pi.name = REPLACE(REPLACE(pi.name, 'IP54', 'IP44'), 'IР54', 'IP44'),
    pi.short_description = REPLACE(REPLACE(pi.short_description, 'IP54', 'IP44'), 'IР54', 'IP44'),
    pi.description = REPLACE(REPLACE(pi.description, 'IP54', 'IP44'), 'IР54', 'IP44')
WHERE p.category_id = 2;

UPDATE seo_meta sm
JOIN products p ON sm.entity_type = 'product' AND sm.entity_id = p.id
SET sm.title = REPLACE(sm.title, 'IP41', 'IP54'),
    sm.h1 = REPLACE(sm.h1, 'IP41', 'IP54')
WHERE p.category_id = 1;

UPDATE seo_meta sm
JOIN products p ON sm.entity_type = 'product' AND sm.entity_id = p.id
SET sm.title = REPLACE(REPLACE(sm.title, 'IP54', 'IP44'), 'IР54', 'IP44'),
    sm.h1 = REPLACE(REPLACE(sm.h1, 'IP54', 'IP44'), 'IР54', 'IP44')
WHERE p.category_id = 2;

UPDATE product_specs_i18n psi
JOIN product_specs ps ON ps.id = psi.product_spec_id
JOIN products p ON p.id = ps.product_id
SET psi.value = 'IP54'
WHERE ps.spec_key = 'stepen-zaschity-ip' AND p.category_id = 1;

UPDATE product_specs_i18n psi
JOIN product_specs ps ON ps.id = psi.product_spec_id
JOIN products p ON p.id = ps.product_id
SET psi.value = 'IP44'
WHERE ps.spec_key = 'stepen-zaschity-ip' AND p.category_id = 2;
