<?php
/**
 * Prevent Wordfence from loading on non-production environments.
 */

declare(strict_types=1);

if (! defined('WP_ENV') || WP_ENV !== 'production') {
    // Remove Wordfence from the active plugins list before it loads.
    add_filter('option_active_plugins', function (array $plugins): array {
        $plugins = array_filter(
            $plugins,
            static fn(string $plugin): bool => $plugin !== 'wordfence/wordfence.php'
        );
        return array_values($plugins);
    }, 20);

    add_filter('site_option_active_sitewide_plugins', function (array $plugins): array {
        unset($plugins['wordfence/wordfence.php']);
        return $plugins;
    }, 20);

    add_filter('wordfence_ls_enabled', '__return_false', 20);
}
