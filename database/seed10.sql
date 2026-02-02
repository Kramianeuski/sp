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

INSERT INTO pages (slug, status)
VALUES ('privacy-policy', 'published')
ON DUPLICATE KEY UPDATE status = VALUES(status);

SELECT id INTO @privacy_page_id FROM pages WHERE slug = 'privacy-policy';

DELETE FROM page_sections WHERE page_id = @privacy_page_id;

INSERT INTO page_sections (page_id, section_key, sort_order, template, data_json, created_at, updated_at)
VALUES
    (@privacy_page_id, 'privacy-content', 1, 'text_block', '{"title_key": "privacy.title", "text_key": "privacy.text"}', NOW(), NOW());

INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, canonical, created_at, updated_at)
VALUES
    ('page', @privacy_page_id, 'ru', 'Политика конфиденциальности', 'Правила обработки персональных данных System Power.', 'Политика конфиденциальности', 'privacy-policy', NULL, NOW(), NOW()),
    ('page', @privacy_page_id, 'en', 'Privacy Policy', 'Personal data processing policy for System Power.', 'Privacy Policy', 'privacy-policy', NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    title = VALUES(title),
    description = VALUES(description),
    h1 = VALUES(h1),
    slug = VALUES(slug),
    canonical = VALUES(canonical),
    updated_at = VALUES(updated_at);

INSERT INTO i18n_strings (`key`, locale, value, is_html)
VALUES
    ('filters.toggle', 'ru', 'Фильтры', 0),
    ('filters.toggle', 'en', 'Filters', 0),
    ('filters.close', 'ru', 'Закрыть', 0),
    ('filters.close', 'en', 'Close', 0),
    ('footer.privacy', 'ru', 'Политика конфиденциальности', 0),
    ('footer.privacy', 'en', 'Privacy policy', 0),
    ('form.privacy_link', 'ru', 'Политикой конфиденциальности', 0),
    ('form.privacy_link', 'en', 'Privacy policy', 0),
    ('contacts.legal_label', 'ru', 'Юридическая информация', 0),
    ('contacts.legal_label', 'en', 'Legal information', 0),
    ('contacts.legal_text', 'ru', "ООО «Системные Решения»\nИНН: 6950156688\nКПП: 673201001", 0),
    ('contacts.legal_text', 'en', "System Solutions LLC\nINN: 6950156688\nKPP: 673201001", 0),
    ('form.error.email_required', 'ru', 'Введите адрес электронной почты.', 0),
    ('form.error.email_required', 'en', 'Enter your email address.', 0),
    ('privacy.title', 'ru', 'Политика конфиденциальности', 0),
    ('privacy.title', 'en', 'Privacy Policy', 0),
    ('privacy.text', 'ru', '<p>Мы собираем и обрабатываем персональные данные только для связи по вашему запросу и предоставления информации о продукции System Power.</p><p>Мы не передаем ваши данные третьим лицам без законных оснований и обеспечиваем их защиту.</p><p>Вы можете отозвать согласие на обработку данных, написав нам по контактному email.</p>', 1),
    ('privacy.text', 'en', '<p>We collect and process personal data only to respond to your inquiry and provide information about System Power products.</p><p>We do not share your data with third parties without legal grounds and keep it protected.</p><p>You can withdraw your consent by contacting us via the email listed in the contacts section.</p>', 1)
ON DUPLICATE KEY UPDATE value = VALUES(value), is_html = VALUES(is_html);

UPDATE partner_i18n
SET description = 'Petrovich is a large Russian building materials retailer. Suitable for purchases through a familiar DIY platform with logistics and a wide assortment. As a sales channel it provides access to private contractors, crews, and corporate buyers.'
WHERE partner_id = 3 AND locale = 'en';
