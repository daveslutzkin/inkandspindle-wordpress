<?php
/**
 * Prevent heavy production-only plugins from loading outside production.
 */

declare(strict_types=1);

if (! defined('WP_ENV') || WP_ENV !== 'production') {
    $disabled_plugins = [
        'wordfence/wordfence.php',
        'updraftplus/updraftplus.php',
    ];

    $remove_plugins = static function (array $plugins) use ($disabled_plugins): array {
        $plugins = array_filter(
            $plugins,
            static fn(string $plugin): bool => ! in_array($plugin, $disabled_plugins, true)
        );
        return array_values($plugins);
    };

    add_filter('option_active_plugins', $remove_plugins, 20);

    add_filter('site_option_active_sitewide_plugins', function (array $plugins) use ($disabled_plugins): array {
        foreach ($disabled_plugins as $plugin) {
            unset($plugins[$plugin]);
        }
        return $plugins;
    }, 20);

    add_filter('wordfence_ls_enabled', '__return_false', 20);
}
