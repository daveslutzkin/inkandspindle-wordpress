<?php
/**
 * Sample per-environment WordPress configuration.
 *
 * Copy this file to config/wp-config-local.php (for developers) or
 * config/wp-config-production.php (for the live site) and fill in the
 * appropriate values. Files matching wp-config-*.php are ignored by git,
 * so credentials stay out of version control.
 */

define('WP_ENV', 'local'); // e.g. local, staging, production

define('DB_NAME', 'database_name_here');
define('DB_USER', 'username_here');
define('DB_PASSWORD', 'password_here');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

// Replace these with fresh salts (wp config shuffle-salts) per environment.
define('AUTH_KEY',         'generate-unique-phrase');
define('SECURE_AUTH_KEY',  'generate-unique-phrase');
define('LOGGED_IN_KEY',    'generate-unique-phrase');
define('NONCE_KEY',        'generate-unique-phrase');
define('AUTH_SALT',        'generate-unique-phrase');
define('SECURE_AUTH_SALT', 'generate-unique-phrase');
define('LOGGED_IN_SALT',   'generate-unique-phrase');
define('NONCE_SALT',       'generate-unique-phrase');

// URLs differ between environments, so keep them here.
define('WP_SITEURL', 'http://localhost:8080/app/wp');
define('WP_HOME',    'http://localhost:8080');
define('WP_CONTENT_URL', 'http://localhost:8080/content');

// Debug defaults; tighten on production.
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// Example cache key for object caches; adjust per environment as needed.
// define('WP_CACHE_KEY_SALT', 'local-inkandspindle');
