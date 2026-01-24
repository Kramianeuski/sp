-- Seed 6: refresh System Power content and translations

INSERT INTO translations (language, `key`, `value`) VALUES
('ru', 'nav.close', 'Закрыть'),
('en', 'nav.close', 'Close'),
('ru', 'products.title', 'Продукция System Power'),
('ru', 'products.h1', 'Продукция System Power'),
('ru', 'products.meta_title', 'Продукция System Power'),
('ru', 'products.meta_description', 'Линейка System Power включает два направления, разработанные для применения на объектах строительства, эксплуатации и промышленности.\n\n1) Щиты механизации РУСП (IP54)\nРаспределительные щиты для организации питания и подключения потребителей 220/380 В на площадке. Исполнения под типовые сценарии объекта и задачи электроснабжения.\n\n2) Металлические напольные лючки 45×45\nЛючки для скрытой установки в пол с модульной компоновкой 45×45. Стальной корпус и вводы M25 обеспечивают аккуратный подвод кабельных линий и монтажную готовность.'),
('en', 'products.title', 'System Power products'),
('en', 'products.h1', 'System Power products'),
('en', 'products.meta_title', 'System Power products'),
('en', 'products.meta_description', 'The System Power line includes two directions designed for construction, operation, and industrial sites.\n\n1) RUSP distribution boards (IP54)\nBoards for organizing power distribution and connecting 220/380 V loads on site. Configurations follow typical facility scenarios and power supply tasks.\n\n2) Metal floor boxes 45×45\nFloor boxes for concealed floor installation with 45×45 modular layout. Steel housing and M25 entries provide neat cable routing and installation readiness.'),
('en', 'cta.production', 'Production and control')
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
    pt.h1 = 'System Power — engineering solutions for on-site power supply',
    pt.meta_title = 'System Power — engineering solutions for on-site power supply',
    pt.meta_description = 'A new brand created by a team with hands-on experience in electrical engineering and operations.',
    pt.og_title = 'System Power — engineering solutions for on-site power supply',
    pt.og_description = 'A new brand created by a team with hands-on experience in electrical engineering and operations.',
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
    pt.meta_description = 'System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов.',
    pt.og_title = 'О бренде System Power',
    pt.og_description = 'System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'about' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'About System Power',
    pt.h1 = 'About System Power',
    pt.meta_title = 'About System Power',
    pt.meta_description = 'System Power is a manufacturing direction focused on practical on-site power supply tasks.',
    pt.og_title = 'About System Power',
    pt.og_description = 'System Power is a manufacturing direction focused on practical on-site power supply tasks.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'about' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Производство и контроль',
    pt.h1 = 'Производство и контроль',
    pt.meta_title = 'Производство и контроль System Power',
    pt.meta_description = 'Производство и контроль качества System Power организованы по принципам системы менеджмента качества ISO 9001:2015.',
    pt.og_title = 'Производство и контроль System Power',
    pt.og_description = 'Производство и контроль качества System Power организованы по принципам системы менеджмента качества ISO 9001:2015.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'manufacturing' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Production and control',
    pt.h1 = 'Production and control',
    pt.meta_title = 'System Power production and control',
    pt.meta_description = 'System Power production and quality control follow ISO 9001:2015 quality management principles.',
    pt.og_title = 'System Power production and control',
    pt.og_description = 'System Power production and quality control follow ISO 9001:2015 quality management principles.',
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
    pt.meta_description = 'В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация.',
    pt.og_title = 'Документы и сертификаты',
    pt.og_description = 'В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'documentation' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Documents and certificates',
    pt.h1 = 'Documents and certificates',
    pt.meta_title = 'System Power documents and certificates',
    pt.meta_description = 'This section provides files related to specific System Power products: passports, diagrams, and supporting documentation.',
    pt.og_title = 'Documents and certificates',
    pt.og_description = 'This section provides files related to specific System Power products: passports, diagrams, and supporting documentation.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'documentation' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Где купить System Power',
    pt.h1 = 'Где купить System Power',
    pt.meta_title = 'Где купить System Power',
    pt.meta_description = 'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.',
    pt.og_title = 'Где купить System Power',
    pt.og_description = 'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.',
    pt.custom_html = '<section class="content-block">\n    <div class="container">\n        <h2>Карта партнёров — Яндекс.Карты</h2>\n        <iframe\n          src="https://yandex.ru/map-widget/v1/?ll=34.765130%2C55.202455&z=5&pt=32.055806%2C54.774769,pm2rdm~37.474453%2C55.630141,pm2blm"\n          width="100%" height="420" frameborder="0"\n          style="border:0;border-radius:16px;overflow:hidden"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'where-to-buy' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Where to buy System Power',
    pt.h1 = 'Where to buy System Power',
    pt.meta_title = 'Where to buy System Power',
    pt.meta_description = 'System Power products are available via official distributors and a marketplace channel. For project procurement choose official distributors; for quick orders use the marketplace.',
    pt.og_title = 'Where to buy System Power',
    pt.og_description = 'System Power products are available via official distributors and a marketplace channel.',
    pt.custom_html = '<section class="content-block">\n    <div class="container">\n        <h2>Partner map — Yandex.Maps</h2>\n        <iframe\n          src="https://yandex.ru/map-widget/v1/?ll=34.765130%2C55.202455&z=5&pt=32.055806%2C54.774769,pm2rdm~37.474453%2C55.630141,pm2blm"\n          width="100%" height="420" frameborder="0"\n          style="border:0;border-radius:16px;overflow:hidden"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'where-to-buy' AND pt.language = 'en';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Контакты',
    pt.h1 = 'Контакты',
    pt.meta_title = 'Контакты System Power',
    pt.meta_description = 'Email: teh@sissol.ru',
    pt.og_title = 'Контакты',
    pt.og_description = 'Email: teh@sissol.ru',
    pt.custom_html = '<section class="content-block">\n    <div class="container">\n        <h2>Контакты — Яндекс.Карты</h2>\n        <iframe\n          src="https://yandex.ru/map-widget/v1/?ll=32.055806%2C54.774769&z=16&pt=32.055806%2C54.774769,pm2rdm"\n          width="100%" height="420" frameborder="0"\n          style="border:0;border-radius:16px;overflow:hidden"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>\n<section class="content-block">\n    <div class="container">\n        <h2>Контакты — OpenStreetMap</h2>\n        <iframe\n          width="100%" height="420" frameborder="0" scrolling="no"\n          style="border:0;border-radius:16px;overflow:hidden"\n          src="https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806">\n        </iframe>\n    </div>\n</section>',
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
    pt.meta_description = 'Email: teh@sissol.ru',
    pt.og_title = 'Contacts',
    pt.og_description = 'Email: teh@sissol.ru',
    pt.custom_html = '<section class="content-block">\n    <div class="container">\n        <h2>Contacts — Yandex.Maps</h2>\n        <iframe\n          src="https://yandex.ru/map-widget/v1/?ll=32.055806%2C54.774769&z=16&pt=32.055806%2C54.774769,pm2rdm"\n          width="100%" height="420" frameborder="0"\n          style="border:0;border-radius:16px;overflow:hidden"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>\n<section class="content-block">\n    <div class="container">\n        <h2>Contacts — OpenStreetMap</h2>\n        <iframe\n          width="100%" height="420" frameborder="0" scrolling="no"\n          style="border:0;border-radius:16px;overflow:hidden"\n          src="https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806">\n        </iframe>\n    </div>\n</section>',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'contacts' AND pt.language = 'en';

DELETE FROM page_blocks
WHERE page_id IN (SELECT id FROM pages WHERE slug IN ('home', 'about', 'manufacturing', 'documentation', 'where-to-buy', 'contacts'))
  AND language IN ('ru', 'en');

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'hero', 'System Power — инженерные решения для электроснабжения на объекте',
'Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.',
1 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'brand', 'О бренде',
'System Power — молодой бренд, но команда за ним — опытная: мы работали с подбором и применением электротехнических решений на объектах энергетики, строительства и промышленности.',
2 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'categories', 'Направления продукции',
'',
3 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'production', 'Производство и контроль',
'На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки. Для каждого изделия предусмотрена сопроводительная документация; подтверждающие документы (сертификат/декларация) предоставляются при наличии для конкретной модели.',
4 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'certificates', 'Документы',
'Документы публикуются по моделям: паспорт, схема (где предусмотрено), сопроводительные файлы. Актуальные версии доступны в карточке изделия.',
5 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'where-to-buy', 'Где купить',
'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Выберите поставщика по региону, формату закупки и требованиям к документам.',
6 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'support', 'Контакты',
'Технические и общие вопросы по продукции System Power:\nteh@sissol.ru\n· +7 (4812) 54-82-55 · Смоленск, ул. Тенишевой 15',
7 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'hero', 'System Power — engineering solutions for on-site power supply',
'A new brand created by a team with hands-on experience in electrical engineering and operations.',
1 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'brand', 'About the brand',
'System Power is a young brand, but the team behind it is experienced: we have worked with selecting and applying electrical engineering solutions at energy, construction, and industrial sites.',
2 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'categories', 'Product directions',
'',
3 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'production', 'Production and control',
'Manufacturing uses regulated assembly and acceptance control: incoming inspection of components, control of layout and labeling, control of documentation compliance, and recording of inspection results. Each product has supporting documentation; confirming documents (certificate/declaration) are provided when available for a specific model.',
4 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'certificates', 'Documents',
'Documents are published by model: passport, diagram (where applicable), supporting files. Current versions are available on the product page.',
5 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'where-to-buy', 'Where to buy',
'System Power products are available through official distributors and a marketplace channel. Choose a supplier by region, purchasing format, and documentation requirements.',
6 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'support', 'Contacts',
'Technical and general questions about System Power products:\nteh@sissol.ru\n· +7 (4812) 54-82-55 · Smolensk, 15 Tenisheva St',
7 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов. Мы развиваем линейку изделий, которые используются в условиях площадки и эксплуатации: распределение питания, подключение потребителей, организация точек подключения в полу.\n\nБренд новый, но создан командой специалистов с опытом в электротехнике, поставках и применении оборудования на объектах. Наш принцип — делать исполнения понятными и стабильными: чтобы монтаж, ввод в эксплуатацию и последующее обслуживание проходили без “сюрпризов”.\n\nФокус линейки:\n\nщиты механизации РУСП (IP54)\n\nметаллические напольные лючки 45×45 (вводы M25; серии IP41/IP54)',
1 FROM pages WHERE slug = 'about';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'System Power is a manufacturing direction focused on practical on-site power supply tasks. We develop a product line used at construction and operating facilities: power distribution, connecting loads, and organizing floor connection points.\n\nThe brand is new but built by a team with experience in electrical engineering, supplies, and application on facilities. Our principle is to keep configurations clear and stable so installation, commissioning, and service are predictable.\n\nFocus of the line:\n\nRUSP distribution boards (IP54)\n\nmetal 45×45 floor boxes (M25 entries; IP41/IP54 series)',
1 FROM pages WHERE slug = 'about';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Производство и контроль качества System Power\nПринципы управления качеством (на базе ISO 9001:2015)\n\nПроизводственные процессы System Power организованы по принципам системы менеджмента качества ISO 9001:2015: процессный подход, планирование и управляемость операций, документирование, оценка рисков и предупреждение несоответствий. Для каждого изделия устанавливаются критерии приемки и контрольные точки, а изменения в изделии и документации проходят регламентированное согласование.\n\nМы обеспечиваем управление полным циклом: от фиксации требований (исполнение, комплектация, степень защиты, маркировка) до выпуска изделия и передачи сопроводительных документов.\n\nУправление измерениями и калибровкой (на базе ISO 10012)\n\nДля операций контроля применяются измерительные средства и методики, которые проходят метрологическое подтверждение и ведутся по графикам проверки/калибровки. Учет измерительного инструмента и контроль измерительных процессов обеспечивают воспроизводимость результатов и сопоставимость показаний при приемке.\n\nВходной контроль комплектующих и материалов\n\nПеред запуском в производство выполняется входной контроль:\n\nидентификация комплектующих и проверка соответствия спецификациям (номиналы, типы, исполнение);\nвизуальный контроль качества и комплектности;\nпроверка маркировки и сопроводительных документов поставки (при необходимости — подтверждение происхождения и статуса поставки);\nрегистрация партии (прослеживаемость) и допуск в производство.\n\nПроизводственный контроль (сборка и компоновка)\n\nСборка выполняется по технологическим картам и инструкциям, обеспечивающим повторяемость:\n\nконтроль компоновки и монтажа (расположение аппаратов, вводы/выводы, крепеж);\nконтроль затяжки и механической фиксации;\nконтроль маркировки (кабели/цепи/клеммы/выходы);\nконтроль соответствия сборки электрической схеме и спецификации изделия.\n\nЭлектрические испытания и верификация (логика отрасли)\n\nДля электрощитового оборудования применяется подход «верификации» в соответствии с отраслевой практикой, используемой для низковольтных комплектных устройств: подтверждение соответствия требованиям достигается испытаниями, расчетами/измерениями и/или применением проектных правил — в зависимости от параметров изделия и применимого уровня проверки.\n\nТиповой перечень контрольных проверок включает:\n\nпроверку целостности цепей и правильности подключений;\nпроверку наличия и корректности защитных проводников;\nфункциональную проверку силовых выходов и защитной аппаратуры (по исполнению);\nрегистрацию результата контроля и выпуск изделия в статус «годно».\n\nКонтроль несоответствий и корректирующие действия (ISO 9001:2015)\n\nЛюбые несоответствующие выходы процесса (изделия, узлы, документация) идентифицируются и изолируются, чтобы исключить непреднамеренную отгрузку или использование. По результатам анализа назначаются действия: доработка/ремонт, замена, пересборка либо списание — с фиксацией причины и мерами предупреждения повторения.\n\nДокументация и прослеживаемость\n\nДля изделий System Power предусматривается комплект документации, необходимый для эксплуатации и приемки на объекте:\n\nпаспорт изделия;\nэлектрическая схема (по исполнению);\nкомплектность поставки (перечень);\nподтверждающие документы (сертификат/декларация — при наличии для конкретной модели/партии).\n\nДокументы выдаются в актуальной редакции и привязаны к конкретному изделию/исполнению.\n\nКонтроль продукции по направлениям\nЭлектрощитовое оборудование (РУСП и др. исполнения)\n\nКонтроль ориентирован на безопасную эксплуатацию на объекте:\n\nпроверка соответствия выходов/разъемов и их маркировки;\nпроверка работоспособности защитных функций и логики включения;\nконтроль корпуса и степени защиты по исполнению;\nвыпуск документов и комплектности (ключи, паспорт, схема и т.д. — согласно конкретному изделию).\n\nМеталлические напольные лючки\n\nКонтроль ориентирован на механическую надежность и монтажную готовность:\n\nпроверка геометрии корпуса и крышки, качества подгонки;\nконтроль антикоррозионного покрытия и качества поверхности;\nпроверка монтажных элементов и вводов (например, под трубы/вводы по исполнению);\nконтроль модульной компоновки и совместимости с заявленной системой (например, 45×45).\n\nПостоянное улучшение\n\nМы регулярно пересматриваем производственные инструкции, анализируем причины отклонений и обратную связь от партнеров/эксплуатации, обучаем персонал и уточняем контрольные операции. Цель — стабильность характеристик изделий, повторяемость сборки и предсказуемость качества поставки.',
1 FROM pages WHERE slug = 'manufacturing';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'System Power production and quality control\nQuality management principles (based on ISO 9001:2015)\n\nSystem Power production processes are organized according to ISO 9001:2015 quality management principles: process approach, planning and control of operations, documentation, risk assessment, and prevention of nonconformities. Acceptance criteria and control points are defined for each product, and changes in the product and documentation go through regulated approval.\n\nWe manage the full cycle: from fixing requirements (configuration, completeness, protection rating, labeling) to product release and delivery of supporting documentation.\n\nMeasurement management and calibration (based on ISO 10012)\n\nControl operations use measuring instruments and methods that undergo metrological verification and are maintained on verification/calibration schedules. Instrument accounting and control of measurement processes ensure repeatability and comparability of results at acceptance.\n\nIncoming inspection of components and materials\n\nBefore production start, incoming inspection is performed:\n\nidentification of components and verification against specifications (ratings, types, configurations);\nvisual inspection of quality and completeness;\nverification of labels and accompanying supply documents (when required — confirmation of origin and supply status);\nbatch registration (traceability) and release to production.\n\nProduction control (assembly and layout)\n\nAssembly follows routing cards and instructions to ensure repeatability:\n\nchecking layout and installation (device placement, inlets/outlets, fastening);\nchecking torque and mechanical fastening;\nchecking labeling (cables/circuits/terminals/outputs);\nchecking compliance of assembly with the electrical diagram and product specification.\n\nElectrical tests and verification (industry practice)\n\nFor switchgear, a verification approach is used per industry practice for low-voltage switchgear assemblies: compliance is confirmed by tests, calculations/measurements and/or application of design rules depending on product parameters and verification level.\n\nTypical control checks include:\n\ncontinuity and correct wiring checks;\nverification of protective conductors;\nfunctional testing of power outputs and protective devices (by configuration);\nrecording inspection results and releasing the product as acceptable.\n\nNonconformity control and corrective actions (ISO 9001:2015)\n\nAny nonconforming outputs (products, assemblies, documentation) are identified and isolated to prevent unintended shipment or use. Based on analysis, actions are assigned: rework/repair, replacement, reassembly, or disposal — with recorded causes and preventive measures.\n\nDocumentation and traceability\n\nSystem Power products include the documentation package required for operation and acceptance:\n\nproduct passport;\nelectrical diagram (by configuration);\npacking list;\nconfirming documents (certificate/declaration — when available for the specific model/batch).\n\nDocuments are issued in the current revision and tied to the specific product/configuration.\n\nProduct control by direction\nSwitchgear equipment (RUSP and other configurations)\n\nControl focuses on safe on-site operation:\n\nverification of outputs/connectors and their labeling;\nverification of protective functions and switching logic;\ncontrol of enclosure and protection rating by configuration;\nrelease of documentation and completeness (keys, passport, diagram, etc. — per the specific product).\n\nMetal floor boxes\n\nControl focuses on mechanical reliability and installation readiness:\n\nverification of enclosure and cover geometry, fit quality;\ncontrol of anti-corrosion coating and surface quality;\nverification of mounting elements and inlets (e.g., conduit entries by configuration);\ncontrol of modular layout and compatibility with the declared system (e.g., 45×45).\n\nContinuous improvement\n\nWe regularly review production instructions, analyze deviations and partner/operations feedback, train personnel, and refine control operations. The goal is stable product characteristics, repeatable assembly, and predictable quality.',
1 FROM pages WHERE slug = 'manufacturing';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация. Набор документов зависит от модели и исполнения.\n\nКак устроено\n\nдокументы публикуются в карточке конкретного изделия;\nпаспорт и схема — по соответствующим моделям;\nсертификат/декларация соответствия — при наличии для конкретной модели/партии.\n\nЕсли вам нужен документ, которого нет на сайте, направьте запрос на почту — укажите артикул и исполнение изделия.',
1 FROM pages WHERE slug = 'documentation';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'This section provides files related to specific System Power products: passports, diagrams (where applicable), and supporting documentation. The document set depends on the model and configuration.\n\nHow it works\n\nDocuments are published in the product card;\npassport and diagram — for the relevant models;\ncertificate/declaration of conformity — when available for the specific model/batch.\n\nIf you need a document that is not on the site, send a request by email — include the product SKU and configuration.',
1 FROM pages WHERE slug = 'documentation';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'partners', 'Партнёры',
'Аргумент Энерго (Москва) - a-energ.ru — официальный дистрибьютор\nАргумент Энерго специализируется на поставках электротехнической продукции через интернет и для объектов и монтажных организаций.\n\nООО «Системные Решения» - sissol.ru — официальный дистрибьютор\nООО «Системные Решения» работает в сфере электроснабжения и электроосвещения более 10 лет. Решения формируются на продукции проверенных торговых марок и поставляются на основании прямых дистрибьюторских контрактов, что позволяет подтверждать происхождение и качество и соблюдать гарантийные обязательства. Компания ориентирована не только на продажу, но и на подбор оптимального решения под задачу. География проектов включает регионы России и страны ЕАЭС.\n\nВсеИнструменты — vseinstrumenti.ru - маркетплейс / онлайн-гипермаркет\nМаркетплейс, которому доверяют миллионы',
1 FROM pages WHERE slug = 'where-to-buy';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'partners', 'Partners',
'Argument Energo (Moscow) - a-energ.ru — official distributor\nArgument Energo specializes in supplying electrical equipment online and for project and installation organizations.\n\nSystemnye Resheniya LLC - sissol.ru — official distributor\nSystemnye Resheniya LLC has worked in power supply and lighting for more than 10 years. Solutions are built on proven brands and supplied under direct distributor contracts, which confirms origin, quality, and warranty obligations. The company focuses not only on sales but also on selecting optimal solutions for each task. The project geography includes regions of Russia and EAEU countries.\n\nVseinstrumenti — vseinstrumenti.ru - marketplace / online hypermarket\nA marketplace trusted by millions.',
1 FROM pages WHERE slug = 'where-to-buy';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Email: teh@sissol.ru\n\nТелефон: +7 (4812) 54-82-55\nАдрес: ул. Тенишевой 15, Смоленск, Россия\n\nЮридическое лицо\n\nООО «Системные Решения» — производитель и дистрибьютор электрооборудования с историей более 10 лет. Компания формирует решения на базе продукции проверенных торговых марок и поставляет оборудование по прямым дистрибьюторским контрактам, что позволяет подтверждать происхождение и качество продукции и обеспечивать соблюдение гарантийных обязательств. По вопросам продукции System Power предоставляется консультация по исполнению, применению и документации.\n\nКак быстрее получить ответ\n\nВ письме укажите: тип изделия (РУСП / люк), артикул (если есть), нужные параметры (ток/исполнение/IP/модульность), регион и формат закупки (проект/оперативно).',
1 FROM pages WHERE slug = 'contacts';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'en', 'generic', '',
'Email: teh@sissol.ru\n\nPhone: +7 (4812) 54-82-55\nAddress: 15 Tenisheva St, Smolensk, Russia\n\nLegal entity\n\nSystemnye Resheniya LLC is a manufacturer and distributor of electrical equipment with more than 10 years of experience. The company builds solutions based on proven brands and supplies equipment under direct distributor contracts, which confirms origin, quality, and warranty obligations. For System Power products, consultation is provided on configuration, application, and documentation.\n\nHow to get a faster response\n\nIn your email, include: product type (RUSP / floor box), SKU (if available), required parameters (current/configuration/IP/modularity), region, and purchasing format (project/operational).',
1 FROM pages WHERE slug = 'contacts';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Щиты механизации РУСП (IP54)',
    ct.h1 = 'Щиты механизации РУСП System Power (IP54)',
    ct.description = 'Щиты для распределения питания и подключения потребителей 220/380 В на строительных и производственных площадках. Исполнения формируются под типовые задачи объекта: понятные выходы, маркировка, комплект документов.',
    ct.meta_title = 'Щиты механизации РУСП System Power (IP54)',
    ct.meta_description = 'РУСП — распределительные щиты для безопасного распределения питания и подключения потребителей 220/380 В на площадке.',
    ct.seo_text = 'Ключевые особенности\n\nстепень защиты корпуса: IP54\n\nисполнение под типовые потребности площадки (по конфигурации модели)\n\nудобство подключения: силовые выходы 220/380 В в зависимости от исполнения\n\nсопроводительная документация по изделию\n\nДокументы\n\nПаспорт и схема предоставляются для соответствующих исполнений. Подтверждающие документы (сертификат/декларация) — при наличии для конкретной модели/партии.',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'electrical-enclosures' AND ct.language = 'ru';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'RUSP distribution boards (IP54)',
    ct.h1 = 'System Power RUSP distribution boards (IP54)',
    ct.description = 'Boards for power distribution and connecting 220/380 V loads at construction and industrial sites. Configurations are formed for typical site tasks: clear outputs, labeling, and a document set.',
    ct.meta_title = 'System Power RUSP distribution boards (IP54)',
    ct.meta_description = 'RUSP boards for safe power distribution and connecting 220/380 V loads on site.',
    ct.seo_text = 'Key features\n\nprotection rating: IP54\n\nconfiguration for typical site needs (by model)\n\nconnection convenience: 220/380 V power outputs depending on configuration\n\nproduct documentation package\n\nDocuments\n\nPassport and diagram are provided for applicable configurations. Confirming documents (certificate/declaration) are provided when available for the specific model/batch.',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'electrical-enclosures' AND ct.language = 'en';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Металлические напольные лючки (45×45)',
    ct.h1 = 'Металлические напольные лючки System Power (45×45)',
    ct.description = 'Лючки для скрытой установки в пол и организации точек подключения силовых и слаботочных линий. Стальной корпус, вводы под трубы M25, модульная компоновка 45×45. Доступны серии с IP41 и IP54 — в зависимости от условий эксплуатации.',
    ct.meta_title = 'Металлические напольные лючки System Power (45×45)',
    ct.meta_description = 'Металлические напольные лючки System Power 45×45 с вводами M25 и сериями IP41/IP54.',
    ct.seo_text = 'Конструкция и монтаж\n\nстальной корпус\n\nвводы под трубы M25 (по модели)\n\nмодульная компоновка 45×45\n\nсерии IP41 и IP54 — в зависимости от условий эксплуатации',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'floor-boxes' AND ct.language = 'ru';

UPDATE category_translations ct
JOIN categories c ON c.id = ct.category_id
SET ct.name = 'Metal floor boxes (45×45)',
    ct.h1 = 'System Power metal floor boxes (45×45)',
    ct.description = 'Floor boxes for concealed floor installation and organizing power and low-current connection points. Steel housing, M25 conduit entries, and a 45×45 modular layout. IP41 and IP54 series are available depending on operating conditions.',
    ct.meta_title = 'System Power metal floor boxes (45×45)',
    ct.meta_description = 'System Power 45×45 metal floor boxes with M25 entries and IP41/IP54 series.',
    ct.seo_text = 'Construction and installation\n\nsteel housing\n\nM25 conduit entries (by model)\n\n45×45 modular layout\n\nIP41 and IP54 series depending on operating conditions',
    ct.official_seller = '',
    ct.faq = '[]',
    ct.indexable = 1
WHERE c.slug = 'floor-boxes' AND ct.language = 'en';
