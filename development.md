# Development Notes

## Project Idea
Official brand site and admin panel for System Power with SSR, database-driven content, and strict SEO requirements. All public content is stored in the database and rendered server-side. The site exposes fixed routes for RU/EN, products, categories, and product details, with JSON-LD microdata, sitemap, and robots rules.

## Change Log
### Step 1 — Project skeleton
- Added core folders for public assets, source code, templates, storage cache, and database seed files.
- Added baseline PHP architecture for routing, rendering, and database access.
- Added initial SQL seed with required content (RU/EN) and single product.

### Step 2 — Public site rendering
- Added SSR templates for home, pages, categories, and product card.
- Added SEO metadata, hreflang, robots handling, and JSON-LD blocks.
- Added basic styling and layout for strict, engineering-focused UI.

### Step 3 — Admin panel
- Added admin authentication with a single admin user.
- Added CRUD screens for pages, categories, products, and settings.
- Added file/document management hooks and SEO fields editing.

### Step 4 — Infrastructure helpers
- Added sitemap generator, robots.txt, and cache helpers.
- Added .htaccess for local routing.
