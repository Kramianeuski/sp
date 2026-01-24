-- Content updates for System Power pages

INSERT INTO translations (language, `key`, `value`) VALUES
('ru', 'cta.catalog', 'Каталог продукции'),
('en', 'cta.catalog', 'Catalogue'),
('ru', 'cta.production', 'Производство и контроль'),
('en', 'cta.production', 'Manufacturing & Quality'),
('ru', 'cta.about', 'О бренде'),
('en', 'cta.about', 'About'),
('ru', 'cta.documents', 'Документы'),
('en', 'cta.documents', 'Documents'),
('ru', 'cta.contacts', 'Контакты'),
('en', 'cta.contacts', 'Contacts'),
('ru', 'cta.open_category', 'Перейти в направление'),
('en', 'cta.open_category', 'Go to direction'),
('ru', 'where_to_buy.button', 'Где купить'),
('en', 'where_to_buy.button', 'Where to buy'),
('ru', 'products.title', 'Продукция System Power'),
('ru', 'products.h1', 'Продукция System Power'),
('ru', 'products.meta_title', 'Продукция System Power'),
('ru', 'products.meta_description', 'Линейка System Power включает два направления, разработанные для применения на объектах строительства, эксплуатации и промышленности.'),
('en', 'products.title', 'System Power products'),
('en', 'products.h1', 'System Power products'),
('en', 'products.meta_title', 'System Power products'),
('en', 'products.meta_description', 'Two focused directions: RUSP IP54 boards (50–100A) for on-site distribution, and 45×45 modular steel floor boxes with M25 entries (IP41/IP54 series).'),
('ru', 'admin.delete', 'Удалить'),
('en', 'admin.delete', 'Delete'),
('ru', 'admin.header_links', 'Ссылки в хэдере'),
('en', 'admin.header_links', 'Header links'),
('ru', 'admin.header_link_label', 'Название'),
('en', 'admin.header_link_label', 'Label'),
('ru', 'admin.header_link_url', 'Ссылка'),
('en', 'admin.header_link_url', 'URL')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'System Power',
    pt.h1 = 'System Power — инженерные решения для электроснабжения на объекте',
    pt.meta_title = 'System Power — инженерные решения для электроснабжения на объекте',
    pt.meta_description = 'Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.',
    pt.og_title = 'System Power — инженерные решения для электроснабжения на объекте',
    pt.og_description = 'Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'home' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'System Power',
    pt.h1 = 'System Power — engineered solutions for on-site power distribution',
    pt.meta_title = 'System Power — engineered solutions for on-site power distribution',
    pt.meta_description = 'A new brand built by a team with hands-on experience in electrical engineering and field operation.',
    pt.og_title = 'System Power — engineered solutions for on-site power distribution',
    pt.og_description = 'A new brand built by a team with hands-on experience in electrical engineering and field operation.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'home' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'О бренде System Power',
    pt.h1 = 'О бренде System Power',
    pt.meta_title = 'О бренде System Power',
    pt.meta_description = 'System Power — производственное направление для практических задач электроснабжения.',
    pt.og_title = 'О бренде System Power',
    pt.og_description = 'System Power — производственное направление для практических задач электроснабжения.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'about' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'About',
    pt.h1 = 'About System Power',
    pt.meta_title = 'About System Power',
    pt.meta_description = 'System Power is a manufacturing brand focused on practical on-site electrical tasks.',
    pt.og_title = 'About System Power',
    pt.og_description = 'System Power is a manufacturing brand focused on practical on-site electrical tasks.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'about' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Производство и контроль качества System Power',
    pt.h1 = 'Производство и контроль качества System Power',
    pt.meta_title = 'Производство и контроль качества System Power',
    pt.meta_description = 'Производственные процессы System Power организованы по принципам ISO 9001:2015 и отраслевой верификации.',
    pt.og_title = 'Производство и контроль качества System Power',
    pt.og_description = 'Производственные процессы System Power организованы по принципам ISO 9001:2015 и отраслевой верификации.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'manufacturing' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Manufacturing & Quality',
    pt.h1 = 'Manufacturing & Quality',
    pt.meta_title = 'System Power manufacturing and quality control',
    pt.meta_description = 'Quality management follows ISO 9001:2015 principles with documented control points and verification.',
    pt.og_title = 'Manufacturing & Quality',
    pt.og_description = 'Quality management follows ISO 9001:2015 principles with documented control points and verification.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'manufacturing' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Документы и сертификаты',
    pt.h1 = 'Документы и сертификаты',
    pt.meta_title = 'Документы и сертификаты System Power',
    pt.meta_description = 'Паспорта, схемы и подтверждающие документы публикуются в карточках изделий.',
    pt.og_title = 'Документы и сертификаты',
    pt.og_description = 'Паспорта, схемы и подтверждающие документы публикуются в карточках изделий.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'documentation' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Documents',
    pt.h1 = 'Documents',
    pt.meta_title = 'System Power documents',
    pt.meta_description = 'Product passports, wiring diagrams and supporting documents are published per model.',
    pt.og_title = 'Documents',
    pt.og_description = 'Product passports, wiring diagrams and supporting documents are published per model.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'documentation' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Поддержка',
    pt.h1 = 'Поддержка',
    pt.meta_title = 'Поддержка System Power',
    pt.meta_description = 'Консультации по подбору, эксплуатации и документации System Power.',
    pt.og_title = 'Поддержка',
    pt.og_description = 'Консультации по подбору, эксплуатации и документации System Power.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'support' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Support',
    pt.h1 = 'Support',
    pt.meta_title = 'System Power support',
    pt.meta_description = 'Contact support for application, documentation and compatibility inquiries.',
    pt.og_title = 'Support',
    pt.og_description = 'Contact support for application, documentation and compatibility inquiries.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'support' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Контакты',
    pt.h1 = 'Контакты',
    pt.meta_title = 'Контакты System Power',
    pt.meta_description = 'Контактная информация и техническая поддержка System Power.',
    pt.og_title = 'Контакты',
    pt.og_description = 'Контактная информация и техническая поддержка System Power.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'contacts' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Contacts',
    pt.h1 = 'Contacts',
    pt.meta_title = 'System Power contacts',
    pt.meta_description = 'Support email, phone and office address for System Power.',
    pt.og_title = 'Contacts',
    pt.og_description = 'Support email, phone and office address for System Power.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'contacts' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Где купить System Power',
    pt.h1 = 'Где купить System Power',
    pt.meta_title = 'Где купить System Power',
    pt.meta_description = 'Официальные дистрибьюторы и маркетплейс-канал System Power.',
    pt.og_title = 'Где купить System Power',
    pt.og_description = 'Официальные дистрибьюторы и маркетплейс-канал System Power.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'where-to-buy' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Where to buy',
    pt.h1 = 'Where to buy',
    pt.meta_title = 'Where to buy System Power',
    pt.meta_description = 'System Power products are available via official distributors and a marketplace channel.',
    pt.og_title = 'Where to buy',
    pt.og_description = 'System Power products are available via official distributors and a marketplace channel.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'where-to-buy' AND pt.language = 'en';

DELETE FROM page_blocks
WHERE page_id IN (SELECT id FROM pages WHERE slug IN ('home', 'about', 'manufacturing', 'documentation', 'support', 'contacts', 'where-to-buy'));

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'hero', 'System Power — инженерные решения для электроснабжения на объекте',
'Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.\nМы разрабатываем и поставляем изделия, которые удобно применять на площадке: щиты механизации РУСП (IP54, 50–100A) и металлические напольные лючки 45×45 для силовых и слаботочных подключений.',
1 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'brand', 'О бренде',
'System Power — это бренд, сформированный профессиональной командой с опытом в подборе и применении электротехнических решений для энергетики, строительства и промышленности. Бренд новый, однако подход к продукту основан на отраслевых требованиях к безопасности, повторяемости исполнения и комплекту документации. Мы сознательно развиваем линейку в двух направлениях, чтобы обеспечить понятную спецификацию, предсказуемость параметров и удобство эксплуатации.',
2 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'categories', 'Направления продукции',
'Щиты механизации РУСП (IP54) и металлические напольные лючки 45×45 для силовых и слаботочных подключений.',
3 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'certificates', 'Качество и документация',
'К каждому изделию предусматривается комплект сопроводительных документов. Для ряда исполнений РУСП в комплект входят паспорт и электрическая схема; подтверждающие документы (сертификат/декларация) предоставляются при наличии для конкретной модели. Файлы для скачивания размещаются в карточке соответствующего изделия.',
4 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'where-to-buy', 'Где купить',
'Поставка продукции System Power осуществляется через партнёрскую сеть. На странице «Где купить» представлены официальные дистрибьюторы и маркетплейс-канал, через которые доступны актуальные исполнения.',
5 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'support', 'Поддержка',
'По вопросам подбора и эксплуатации продукции вы можете обратиться в техническую поддержку. Мы отвечаем по применению изделий, документации и совместимости исполнений.',
6 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'hero', 'System Power — engineered solutions for on-site power distribution',
'A new brand built by a team with hands-on experience in electrical engineering and field operation.\nOur product scope is focused and practical: RUSP IP54 distribution boards (50–100A) and 45×45 modular metal floor boxes for power and low-current connections.',
1 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'brand', 'About',
'System Power is a new brand created by a professional team with experience in selecting and applying electrical solutions for energy, construction and industrial facilities. While the brand is new, the product approach is based on safety, repeatable configurations and proper documentation. We develop two clear product directions to keep specifications transparent and predictable.',
2 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'categories', 'Product directions',
'Two focused directions for on-site power tasks.',
3 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'certificates', 'Documentation',
'Product passports, wiring diagrams (where applicable), and supporting certificates/declarations are provided depending on the specific model and configuration. Downloads are available on each product page.',
4 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'where-to-buy', 'Where to buy',
'Available via our partner network. The “Where to buy” page lists official distributors and a marketplace channel for current configurations.',
5 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'support', 'Support',
'Contact support for application and documentation inquiries.',
6 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов. Мы развиваем линейку изделий, которые применяются в условиях площадки: распределение питания, подключение потребителей, организация точек подключения в полу.\n\nБренд новый, однако он создан командой специалистов с опытом работы в электротехнике, поставках и эксплуатации. Приоритет — инженерная логика изделий, понятные исполнения, корректная документация и стабильность результата при применении.\n\nФокус линейки:\n— щиты механизации РУСП (IP54, исполнения 50–100A)\n— металлические напольные лючки 45×45 (сталь, вводы M25; серии IP41/IP54)',
1 FROM pages WHERE slug = 'about';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'System Power is a manufacturing brand focused on practical on-site electrical tasks: power distribution and safe connection points. The brand is new, yet built by an experienced engineering team. Our product scope is intentionally focused to maintain clear specifications, repeatable configurations and documentation.',
1 FROM pages WHERE slug = 'about';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Принципы управления качеством (на базе ISO 9001:2015)\nПроизводственные процессы System Power организованы по принципам системы менеджмента качества ISO 9001:2015: процессный подход, планирование и управляемость операций, документирование, оценка рисков и предупреждение несоответствий. Для каждого изделия устанавливаются критерии приемки и контрольные точки, а изменения в изделии и документации проходят регламентированное согласование.\n\nМы обеспечиваем управление полным циклом: от фиксации требований (исполнение, комплектация, степень защиты, маркировка) до выпуска изделия и передачи сопроводительных документов.\n\nУправление измерениями и калибровкой (на базе ISO 10012)\nДля операций контроля применяются измерительные средства и методики, которые проходят метрологическое подтверждение и ведутся по графикам проверки/калибровки. Учет измерительного инструмента и контроль измерительных процессов обеспечивают воспроизводимость результатов и сопоставимость показаний при приемке.\n\nВходной контроль комплектующих и материалов\nПеред запуском в производство выполняется входной контроль:\n— идентификация комплектующих и проверка соответствия спецификациям (номиналы, типы, исполнение);\n— визуальный контроль качества и комплектности;\n— проверка маркировки и сопроводительных документов поставки (при необходимости — подтверждение происхождения и статуса поставки);\n— регистрация партии (прослеживаемость) и допуск в производство.\n\nПроизводственный контроль (сборка и компоновка)\nСборка выполняется по технологическим картам и инструкциям, обеспечивающим повторяемость:\n— контроль компоновки и монтажа (расположение аппаратов, вводы/выводы, крепеж);\n— контроль затяжки и механической фиксации;\n— контроль маркировки (кабели/цепи/клеммы/выходы);\n— контроль соответствия сборки электрической схеме и спецификации изделия.\n\nЭлектрические испытания и верификация (логика отрасли)\nДля электрощитового оборудования применяется подход «верификации» в соответствии с отраслевой практикой, используемой для низковольтных комплектных устройств: подтверждение соответствия требованиям достигается испытаниями, расчетами/измерениями и/или применением проектных правил — в зависимости от параметров изделия и применимого уровня проверки.\n\nТиповой перечень контрольных проверок включает:\n— проверку целостности цепей и правильности подключений;\n— проверку наличия и корректности защитных проводников;\n— функциональную проверку силовых выходов и защитной аппаратуры (по исполнению);\n— регистрацию результата контроля и выпуск изделия в статус «годно».\n\nКонтроль несоответствий и корректирующие действия (ISO 9001:2015)\nЛюбые несоответствующие выходы процесса (изделия, узлы, документация) идентифицируются и изолируются, чтобы исключить непреднамеренную отгрузку или использование. По результатам анализа назначаются действия: доработка/ремонт, замена, пересборка либо списание — с фиксацией причины и мерами предупреждения повторения.\n\nДокументация и прослеживаемость\nДля изделий System Power предусматривается комплект документации, необходимый для эксплуатации и приемки на объекте:\n— паспорт изделия;\n— электрическая схема (по исполнению);\n— комплектность поставки (перечень);\n— подтверждающие документы (сертификат/декларация — при наличии для конкретной модели/партии).\nДокументы выдаются в актуальной редакции и привязаны к конкретному изделию/исполнению.\n\nКонтроль продукции по направлениям\nЭлектрощитовое оборудование (РУСП и др. исполнения)\nКонтроль ориентирован на безопасную эксплуатацию на объекте:\n— проверка соответствия выходов/разъемов и их маркировки;\n— проверка работоспособности защитных функций и логики включения;\n— контроль корпуса и степени защиты по исполнению;\n— выпуск документов и комплектности (ключи, паспорт, схема и т.д. — согласно конкретному изделию).\n\nМеталлические напольные лючки\nКонтроль ориентирован на механическую надежность и монтажную готовность:\n— проверка геометрии корпуса и крышки, качества подгонки;\n— контроль антикоррозионного покрытия и качества поверхности;\n— проверка монтажных элементов и вводов (например, под трубы/вводы по исполнению);\n— контроль модульной компоновки и совместимости с заявленной системой (например, 45×45).\n\nПостоянное улучшение\nМы регулярно пересматриваем производственные инструкции, анализируем причины отклонений и обратную связь от партнеров/эксплуатации, обучаем персонал и уточняем контрольные операции. Цель — стабильность характеристик изделий, повторяемость сборки и предсказуемость качества поставки.',
1 FROM pages WHERE slug = 'manufacturing';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'System Power manufacturing follows ISO 9001:2015 quality management principles with a process approach, planned operations, documented control points and risk prevention. Requirements, configuration and documentation are fixed at the start of each order, and any changes are approved through a controlled workflow.\n\nMeasurement and calibration follow ISO 10012 practices with verified instruments and traceable records. Incoming inspection validates components, markings and documentation before production. Assembly is executed per work instructions with checks for layout, fastening, labeling and compliance with electrical schematics.\n\nElectrical verification includes continuity checks, protective conductors, and functional tests of outputs and protection devices where applicable. Nonconformities are isolated and corrected by repair, rework or replacement with documented root-cause actions.\n\nDocumentation package includes the product passport, wiring diagram (where applicable), packing list and certificates/declarations when available.\n\nProduct-specific control:\n— RUSP and other switchgear: output labeling, protection logic, enclosure rating, documentation completeness.\n— Floor boxes: geometry, fit, coating, conduit entries and 45×45 modular compatibility.\n\nContinuous improvement is maintained through regular review of instructions, feedback analysis and staff training to ensure stable performance and predictable quality.',
1 FROM pages WHERE slug = 'manufacturing';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'В данном разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы и иные сопроводительные документы. Набор документов зависит от модели и исполнения.\n\nКак устроено\nДокументы публикуются в карточке конкретного изделия.\nДля ряда исполнений РУСП доступны паспорт и электрическая схема.\nПодтверждающие документы (сертификат/декларация соответствия) предоставляются при наличии для соответствующей модели/партии.\n\nЕсли вы не нашли нужный файл, обратитесь в техническую поддержку — мы подскажем актуальный комплект документации по вашему изделию.',
1 FROM pages WHERE slug = 'documentation';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'This section provides product-specific documentation: passports, wiring diagrams and supporting documents depending on the model and configuration. Files are published on each product page. Contact support if you need a specific document.',
1 FROM pages WHERE slug = 'documentation';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'По вопросам подбора и эксплуатации продукции вы можете обратиться в техническую поддержку. Мы отвечаем по применению изделий, документации и совместимости исполнений.',
1 FROM pages WHERE slug = 'support';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'Contact support for application, documentation and compatibility inquiries.',
1 FROM pages WHERE slug = 'support';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Техническая поддержка: teh@sissol.ru\n\nТелефон: +7 (4812) 54-82-55\nАдрес: ул. Тенишевой 15, Смоленск, Россия\n\nООО «Системные Решения»\nООО «Системные Решения» — производитель и дистрибьютор электрооборудования с историей более 10 лет. Компания работает с продукцией проверенных торговых марок на основании прямых дистрибьюторских контрактов, что позволяет подтверждать происхождение и качество продукции, обеспечивать инженерную поддержку заводов-изготовителей и соблюдать гарантийные обязательства. По запросу предоставляется консультация по подбору и применению изделий System Power.\n\nКак быстрее получить ответ\nВ обращении укажите: тип изделия (РУСП/люк), артикул (если известен), требуемые параметры (ток/конфигурация/степень защиты) и регион поставки.',
1 FROM pages WHERE slug = 'contacts';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'Support email: teh@sissol.ru\n\nPhone: +7 (4812) 54-82-55\nAddress: 15 Tenisheva St, Smolensk, Russia\n\nSystemnye Resheniya LLC — manufacturer and distributor with 10+ years of experience. Please include product type, SKU/configuration and region in your inquiry.',
1 FROM pages WHERE slug = 'contacts';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Мы рекомендуем выбирать поставщика исходя из задач проекта, региона и требований к документам.\n\nКарта партнёров (подпись к блоку карты)\nНа карте отмечены ключевые точки присутствия официальных партнёров: Смоленск — ООО «Системные Решения», Москва — Аргумент Энерго.\n(Интерактивная карта — OpenStreetMap, дополнительные точки расширяются по мере развития сети.)',
1 FROM pages WHERE slug = 'where-to-buy';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'System Power products are available via official distributors and a marketplace channel. Choose a supplier based on project needs, region and documentation requirements.\n\nPartner map\nKey partner locations: Smolensk — Systemnye Resheniya, Moscow — Argument Energo. (Interactive map: OpenStreetMap; more points added as the network expands.)',
1 FROM pages WHERE slug = 'where-to-buy';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Щиты механизации РУСП (IP54)',
    ct.h1 = 'Щиты механизации РУСП System Power (IP54)',
    ct.description = 'Распределительные щиты для строительных и производственных площадок. Предназначены для безопасного распределения питания и подключения потребителей 220/380 В. Линейка включает исполнения 50–100A и типовые конфигурации выходов.',
    ct.meta_title = 'Щиты механизации РУСП System Power (IP54)',
    ct.meta_description = 'РУСП — распределительные щиты для безопасного распределения питания 220/380 В на площадке.',
    ct.seo_text = 'Документы\nПаспорт и электрическая схема предоставляются для соответствующих исполнений. Подтверждающие документы (сертификат/декларация) — при наличии для конкретной модели.',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'electrical-enclosures' AND ct.language = 'ru';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'RUSP IP54 distribution boards',
    ct.h1 = 'System Power RUSP IP54 distribution boards',
    ct.description = 'RUSP boards are designed for construction and industrial sites to distribute power and connect 230/400V loads. Configurations range by model (50–100A; IP54 enclosure; typical 230V/400V outputs depending on configuration).',
    ct.meta_title = 'System Power RUSP IP54 distribution boards',
    ct.meta_description = 'RUSP boards for on-site power distribution with IP54 enclosures and 50–100A configurations.',
    ct.seo_text = 'Documentation\nProduct passports and wiring diagrams are provided for applicable models. Certificates/declarations are supplied when available for the specific configuration.',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'electrical-enclosures' AND ct.language = 'en';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Металлические напольные лючки (45×45)',
    ct.h1 = 'Металлические напольные лючки System Power (45×45)',
    ct.description = 'Лючки для скрытой установки в пол с модульной системой 45×45. Стальной корпус и вводы под трубы M25 обеспечивают удобный подвод кабельных линий. Доступны серии с IP41 и IP54 в зависимости от условий эксплуатации.',
    ct.meta_title = 'Металлические напольные лючки System Power 45×45',
    ct.meta_description = 'Напольные лючки System Power с модульной системой 45×45, сериями IP41/IP54 и вводами M25.',
    ct.seo_text = 'Конструкция и монтажная логика\nкорпус из стали\nвводы под трубы M25 (по модели)\nмодульная компоновка 45×45\nсерии с IP41 и IP54 — в зависимости от условий эксплуатации',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'floor-boxes' AND ct.language = 'ru';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Metal floor boxes 45×45',
    ct.h1 = 'System Power metal floor boxes 45×45',
    ct.description = 'System Power floor boxes are designed for concealed floor installation for power and low-current connections. Steel housing, modular 45×45 layout, and M25 conduit entries (model-dependent). IP41 and IP54 series are available.',
    ct.meta_title = 'System Power metal floor boxes 45×45',
    ct.meta_description = 'Steel 45×45 modular floor boxes with M25 entries and IP41/IP54 series.',
    ct.seo_text = 'Design and installation logic\nsteel housing\nM25 conduit entries (model-dependent)\nmodular 45×45 layout\nIP41/IP54 series based on conditions',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'floor-boxes' AND ct.language = 'en';
