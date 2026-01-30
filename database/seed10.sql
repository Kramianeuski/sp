-- Seed 10: product URLs, quality page content, and contact cleanup

DELETE FROM page_sections WHERE page_id = 4;

INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (4, 'quality-intro', 1, 'text_block', '{"title_key": "quality.title", "text_key": "quality.intro"}', NOW(), NOW()),
    (4, 'quality-iso', 2, 'list_block', '{"title_key": "quality.iso.title", "items": [{"title_key": "quality.iso.9001", "text_key": "quality.iso.9001.text"}, {"title_key": "quality.iso.14001", "text_key": "quality.iso.14001.text"}]}', NOW(), NOW()),
    (4, 'quality-trts', 3, 'text_block', '{"title_key": "quality.trts.title", "text_key": "quality.trts.text"}', NOW(), NOW()),
    (4, 'quality-principles', 4, 'list_block', '{"title_key": "quality.principles.title", "items": [{"text_key": "quality.principles.1"}, {"text_key": "quality.principles.2"}, {"text_key": "quality.principles.3"}, {"text_key": "quality.principles.4"}, {"text_key": "quality.principles.5"}]}', NOW(), NOW()),
    (4, 'quality-conclusion', 5, 'text_block', '{"title_key": "quality.conclusion.title", "text_key": "quality.conclusion"}', NOW(), NOW());

INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('quality.intro', 'ru', 'Контроль качества System Power — это последовательная система проверок на каждом этапе производства, которая обеспечивает стабильность характеристик и надежность изделий.', 0),
    ('quality.intro', 'en', 'System Power quality control is a step-by-step inspection system throughout production that ensures consistent performance and reliability.', 0),
    ('quality.iso.title', 'ru', 'Стандарты ISO', 0),
    ('quality.iso.title', 'en', 'ISO standards', 0),
    ('quality.iso.9001', 'ru', 'ISO 9001', 0),
    ('quality.iso.9001', 'en', 'ISO 9001', 0),
    ('quality.iso.9001.text', 'ru', 'Система менеджмента качества', 0),
    ('quality.iso.9001.text', 'en', 'Quality management system', 0),
    ('quality.iso.14001', 'ru', 'ISO 14001', 0),
    ('quality.iso.14001', 'en', 'ISO 14001', 0),
    ('quality.iso.14001.text', 'ru', 'Экологический менеджмент', 0),
    ('quality.iso.14001.text', 'en', 'Environmental management system', 0),
    ('quality.trts.title', 'ru', 'Техническое регулирование', 0),
    ('quality.trts.title', 'en', 'Technical regulation', 0),
    ('quality.trts.text', 'ru', 'Продукция соответствует требованиям ТР ТС 004/2011 «О безопасности низковольтного оборудования» и проходит необходимые проверки.', 0),
    ('quality.trts.text', 'en', 'Products comply with TR TS 004/2011 “On the safety of low-voltage equipment” and undergo the required inspections.', 0),
    ('quality.principles.title', 'ru', 'Принципы контроля качества', 0),
    ('quality.principles.title', 'en', 'Quality control principles', 0),
    ('quality.principles.1', 'ru', 'Входной контроль комплектующих', 0),
    ('quality.principles.1', 'en', 'Incoming inspection of components', 0),
    ('quality.principles.2', 'ru', 'Контроль сборки на каждом этапе', 0),
    ('quality.principles.2', 'en', 'Assembly control at every stage', 0),
    ('quality.principles.3', 'ru', 'Электрические испытания перед отгрузкой', 0),
    ('quality.principles.3', 'en', 'Electrical testing before shipment', 0),
    ('quality.principles.4', 'ru', 'Маркировка и трассируемость', 0),
    ('quality.principles.4', 'en', 'Labeling and traceability', 0),
    ('quality.principles.5', 'ru', 'Документирование результатов контроля', 0),
    ('quality.principles.5', 'en', 'Documenting inspection results', 0),
    ('quality.conclusion.title', 'ru', 'Заключение', 0),
    ('quality.conclusion.title', 'en', 'Conclusion', 0),
    ('quality.conclusion', 'ru', 'Система контроля качества позволяет гарантировать соответствие продукции заявленным характеристикам и требованиям заказчиков.', 0),
    ('quality.conclusion', 'en', 'Quality control ensures that products meet declared specifications and customer requirements.', 0),
    ('gallery.prev', 'ru', 'Предыдущее изображение', 0),
    ('gallery.prev', 'en', 'Previous image', 0),
    ('gallery.next', 'ru', 'Следующее изображение', 0),
    ('gallery.next', 'en', 'Next image', 0)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

UPDATE product_i18n
SET description = REPLACE(
    REPLACE(
        REPLACE(
            REPLACE(
                REPLACE(description, 'sale@a-energ.ru', ''),
                'mailto:sale@a-energ.ru', ''
            ),
            '+7 495 409-12-78', ''
        ),
        'Контакты для заказа', ''
    ),
    'Индивидуальные решения и оптовые заказы', ''
);

UPDATE seo_meta
SET description = REPLACE(
    REPLACE(
        REPLACE(
            REPLACE(
                description,
                'sale@a-energ.ru',
                ''
            ),
            '+7 495 409-12-78',
            ''
        ),
        'Контакты для заказа',
        ''
    ),
    'Индивидуальные решения и оптовые заказы',
    ''
)
WHERE entity_type = 'product';
