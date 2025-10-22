<?php
/**
 * WordPress configuration bootstrap.
 *
 * Loads the environment-specific configuration file located in config/.
 */

$root_dir    = __DIR__;
$config_dir  = $root_dir . '/config';
$env         = getenv('WP_ENV') ?: 'production';
$config_file = $config_dir . '/wp-config-' . $env . '.php';

if (! file_exists($config_file)) {
    if (PHP_SAPI !== 'cli') {
        header('HTTP/1.1 500 Internal Server Error');
    }
    $message = sprintf(
        "Missing WordPress configuration for environment '%s'. Expected file: %s",
        $env,
        $config_file
    );
    die($message);
}

require $config_file;

if (! isset($table_prefix)) {
    $table_prefix = 'wp_';
}

if (! defined('WP_CONTENT_DIR')) {
    define('WP_CONTENT_DIR', $root_dir . '/content');
}

if (! defined('ABSPATH')) {
    define('ABSPATH', $root_dir . '/app/wp/');
}

require_once ABSPATH . 'wp-settings.php';
