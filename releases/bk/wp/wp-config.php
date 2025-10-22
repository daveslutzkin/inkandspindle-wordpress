<?php
  // On the server the path to the "real" config is a little different.
  define('INK_SKIP_WP_SETTINGS', true);
  require_once(ABSPATH . '../../../wp-config.php');

  require_once('wp-settings.php');
