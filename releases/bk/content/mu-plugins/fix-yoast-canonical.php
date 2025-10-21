<?php
add_filter('wpseo_canonical', function ($canonical) {
    if (strpos($canonical, 'https://inkandspindle.com.au/') === 0
        && strpos($canonical, 'https://inkandspindle.com.au/main/') !== 0) {
        $canonical = str_replace(
            'https://inkandspindle.com.au/',
            'https://inkandspindle.com.au/main/',
            $canonical
        );
    }
    return $canonical;
});
