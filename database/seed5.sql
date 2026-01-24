-- Seed 5: update System Power page content

INSERT INTO translations (language, `key`, `value`) VALUES
('ru', 'cta.documents', 'Документы и сертификаты'),
('ru', 'products.title', 'Продукция System Power'),
('ru', 'products.h1', 'Продукция System Power'),
('ru', 'products.meta_title', 'Продукция System Power'),
('ru', 'products.meta_description', 'Линейка System Power включает два направления, разработанные для применения на объектах строительства, эксплуатации и промышленности.\n\n1) Щиты механизации РУСП (IP54)\nРаспределительные щиты для организации питания и подключения потребителей 220/380 В на площадке. Исполнения под типовые сценарии объекта и задачи электроснабжения.\n\n2) Металлические напольные лючки 45×45\nЛючки для скрытой установки в пол с модульной компоновкой 45×45. Стальной корпус и вводы M25 обеспечивают аккуратный подвод кабельных линий и монтажную готовность.')
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
SET pt.title = 'Производство и контроль',
    pt.h1 = 'Производство и контроль',
    pt.meta_title = 'Производство и контроль System Power',
    pt.meta_description = 'На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки.',
    pt.og_title = 'Производство и контроль System Power',
    pt.og_description = 'На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки.',
    pt.custom_html = '',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'manufacturing' AND pt.language = 'ru';

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
SET pt.title = 'Где купить System Power',
    pt.h1 = 'Где купить System Power',
    pt.meta_title = 'Где купить System Power',
    pt.meta_description = 'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.',
    pt.og_title = 'Где купить System Power',
    pt.og_description = 'Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.',
    pt.custom_html = '<section class="content-block">
    <div class="container">
        <h2>Карта партнёров — Яндекс.Карты</h2>
        <iframe
          src="https://yandex.ru/map-widget/v1/?ll=34.765130%2C55.202455&z=5&pt=32.055806%2C54.774769,pm2rdm~37.474453%2C55.630141,pm2blm"
          width="100%" height="420" frameborder="0"
          style="border:0;border-radius:16px;overflow:hidden"
          allowfullscreen>
        </iframe>
    </div>
</section>
<section class="content-block">
    <div class="container">
        <h2>Карта партнёров — OpenStreetMap</h2>
        <h3>Смоленск (Системные Решения)</h3>
        <iframe
          width="100%" height="420" frameborder="0" scrolling="no"
          style="border:0;border-radius:16px;overflow:hidden"
          src="https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806">
        </iframe>
        <h3>Москва (Аргумент Энерго)</h3>
        <iframe
          width="100%" height="420" frameborder="0" scrolling="no"
          style="border:0;border-radius:16px;overflow:hidden"
          src="https://www.openstreetmap.org/export/embed.html?bbox=37.464453%2C55.625141%2C37.484453%2C55.635141&layer=mapnik&marker=55.630141%2C37.474453">
        </iframe>
    </div>
</section>',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'where-to-buy' AND pt.language = 'ru';

UPDATE page_translations pt
JOIN pages p ON p.id = pt.page_id
SET pt.title = 'Контакты',
    pt.h1 = 'Контакты',
    pt.meta_title = 'Контакты System Power',
    pt.meta_description = 'Email: teh@sissol.ru',
    pt.og_title = 'Контакты',
    pt.og_description = 'Email: teh@sissol.ru',
    pt.custom_html = '<section class="content-block">
    <div class="container">
        <h2>Контакты — Яндекс.Карты</h2>
        <iframe
          src="https://yandex.ru/map-widget/v1/?ll=32.055806%2C54.774769&z=16&pt=32.055806%2C54.774769,pm2rdm"
          width="100%" height="420" frameborder="0"
          style="border:0;border-radius:16px;overflow:hidden"
          allowfullscreen>
        </iframe>
    </div>
</section>
<section class="content-block">
    <div class="container">
        <h2>Контакты — OpenStreetMap</h2>
        <iframe
          width="100%" height="420" frameborder="0" scrolling="no"
          style="border:0;border-radius:16px;overflow:hidden"
          src="https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806">
        </iframe>
    </div>
</section>',
    pt.custom_css = '',
    pt.use_layout = 1,
    pt.replace_styles = 0,
    pt.indexable = 1
WHERE p.slug = 'contacts' AND pt.language = 'ru';

DELETE FROM page_blocks
WHERE page_id IN (SELECT id FROM pages WHERE slug IN ('home', 'about', 'manufacturing', 'documentation', 'where-to-buy', 'contacts'))
  AND language = 'ru';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'hero', 'System Power — инженерные решения для электроснабжения на объекте',
'Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации. Делаем два направления, которые реально применяются на площадке: щиты механизации РУСП (IP54) и металлические напольные лючки 45×45.',
1 FROM pages WHERE slug = 'home';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'brand', 'О бренде',
'System Power — это бренд с короткой и понятной логикой продукта: стабильные исполнения, предсказуемые характеристики и корректная документация. Бренд новый, но команда за ним — опытная: мы работали с подбором и применением электротехнических решений на объектах энергетики, строительства и промышленности. Поэтому в линейке нет “лишнего”: только изделия, которые упрощают монтаж, эксплуатацию и закупку.',
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
SELECT id, 'ru', 'generic', '',
'System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов. Мы развиваем линейку изделий, которые используются в условиях площадки и эксплуатации: распределение питания, подключение потребителей, организация точек подключения в полу.\n\nБренд новый, но создан командой специалистов с опытом в электротехнике, поставках и применении оборудования на объектах. Наш принцип — делать исполнения понятными и стабильными: чтобы монтаж, ввод в эксплуатацию и последующее обслуживание проходили без “сюрпризов”.\n\nФокус линейки:\n\nщиты механизации РУСП (IP54)\n\nметаллические напольные лючки 45×45 (вводы M25; серии IP41/IP54)',
1 FROM pages WHERE slug = 'about';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки. Для каждого изделия предусмотрена сопроводительная документация; подтверждающие документы (сертификат/декларация) предоставляются при наличии для конкретной модели.',
1 FROM pages WHERE slug = 'manufacturing';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация. Набор документов зависит от модели и исполнения.\n\nКак устроено\n\nдокументы публикуются в карточке конкретного изделия;\nпаспорт и схема — по соответствующим моделям;\nсертификат/декларация соответствия — при наличии для конкретной модели/партии.\n\nЕсли вам нужен документ, которого нет на сайте, направьте запрос на почту — укажите артикул и исполнение изделия.',
1 FROM pages WHERE slug = 'documentation';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'partners', 'Партнёры',
'[Официальные дистрибьюторы]
Аргумент Энерго (Москва) | https://argument-energo.ru | Официальный дистрибьютор | Аргумент Энерго специализируется на поставках электротехнической продукции для объектов и монтажных организаций. Позиции System Power представлены в структурированном каталоге по сериям и исполнениям, что ускоряет подбор. Партнёр ориентирован на корректный документооборот и понятные условия поставки. Подходит для закупок под проект и плановых поставок.
ООО «Системные Решения» / SISSOL (Смоленск) | https://sissol.ru | Официальный дистрибьютор | ООО «Системные Решения» работает в сфере электроснабжения и электроосвещения более 10 лет. Решения формируются на продукции проверенных торговых марок и поставляются на основании прямых дистрибьюторских контрактов, что позволяет подтверждать происхождение и качество и соблюдать гарантийные обязательства. Компания ориентирована не только на продажу, но и на подбор оптимального решения под задачу. География проектов включает регионы России и страны ЕАЭС — в зависимости от проекта.

[Маркетплейсы]
ВсеИнструменты | https://www.vseinstrumenti.ru | Маркетплейс / онлайн-гипермаркет | Канал для оперативных закупок и широкой доступности ассортимента. Удобен для быстрого заказа, сравнения характеристик и понятной логистики. Подходит как массовый канал присутствия System Power для монтажников и конечных заказчиков. Условия поставки и документооборот зависят от формата конкретной продажи на платформе.',
1 FROM pages WHERE slug = 'where-to-buy';

INSERT INTO page_blocks (page_id, language, block_key, title, body, sort_order)
SELECT id, 'ru', 'generic', '',
'Email: teh@sissol.ru\n\nТелефон: +7 (4812) 54-82-55\nАдрес: ул. Тенишевой 15, Смоленск, Россия\n\nЮридическое лицо\n\nООО «Системные Решения» — производитель и дистрибьютор электрооборудования с историей более 10 лет. Компания формирует решения на базе продукции проверенных торговых марок и поставляет оборудование по прямым дистрибьюторским контрактам, что позволяет подтверждать происхождение и качество продукции и обеспечивать соблюдение гарантийных обязательств. По вопросам продукции System Power предоставляется консультация по исполнению, применению и документации.\n\nКак быстрее получить ответ\n\nВ письме укажите: тип изделия (РУСП / люк), артикул (если есть), нужные параметры (ток/исполнение/IP/модульность), регион и формат закупки (проект/оперативно).',
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
