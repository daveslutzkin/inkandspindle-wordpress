# Repository Guidelines

## Project Structure & Module Organization
This WordPress installation keeps the active release under `releases/bk`, with the root-level `app` and `content` directories symlinked there. Custom theme work lives in `content/themes/ink`; use `inc/` for PHP helpers, `partials/` for template fragments, and the `css/` and `js/` folders for assets. Keep plugin-level tweaks inside `content/plugins` and leave the `wp/` core tree untouched. The separate `inkformulas/` directory serves the calculator microsite; update its static assets in-place.

## Build, Test, and Development Commands
- `wp server --host=localhost --port=8080 --docroot=.` — Spin up a local development server that respects the current release layout.
- `wp theme activate ink` — Ensure the custom Ink & Spindle theme is active after database imports.
- `wp cache flush` — Clear the object cache (`content/object-cache.php`) after deploying PHP or ACF changes.
- `php -d detect_unicode=0 -S localhost:8001 index.php` — Alternative built-in PHP server for quick smoke checks when WP-CLI is unavailable.

## Coding Style & Naming Conventions
Follow WordPress PHP standards: tabs for indentation, snake_case functions, and descriptive filter/action names. Mirror existing file conventions when adding templates, e.g. `page-{slug}.php` and `single-{post_type}.php`. When adjusting front-end assets, edit `css/application.css` or `js/application.js`, then bump the `THEME_MODIFIED_DATE` constant in `content/themes/ink/functions.php` to bust caches. Commit ACF field updates by exporting to `acf-json/` inside the theme.

## Testing Guidelines
No automated test suite is present, so rely on targeted manual verification. After theme or plugin edits, load key templates (homepage, trade pages, ordering flows) and confirm Gravity Forms, wholesale logins, and Isotope/Packery interactions behave. Clear caches, in-browser and via `wp cache flush`, before validating fixes. Document edge cases covered in the pull request description.

## Commit & Pull Request Guidelines
Keep commits small, with descriptive commit messages. Commit messages should have clear subjects and more details in the body.

## Security & Configuration Tips
Never commit credentials from `wp-config.php` or plugin settings exports. Review Redis or CDN settings before deployment to avoid stale assets, and rotate API keys through environment configuration rather than hardcoding them in theme files. Remove temporary debugging toggles and restore production error levels before committing.
