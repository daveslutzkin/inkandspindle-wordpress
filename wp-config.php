<?php

define( 'DB_NAME', 'wordpressdb' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'Sh@keD0wnTheThund3rFr0mTh3Sky' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY',          '#wOqyc7o<Q2YD,H#:rBT=<nzAK:a~k9I.vAF2CwtU`jngl:PAKj|B&L]@).GUzKW' );
define( 'SECURE_AUTH_KEY',   '_HN 5oO!=i?PHvMT`r]_&Wou4j-&We:vRw1DNcV QBpx4+x8!ojy^*R0(3,-WM$a' );
define( 'LOGGED_IN_KEY',     '6g^T!m 3OmpQK^_O_r`xJ{3HN372=Z,`Y2X_CjNZ{oV/?5^Au^C?A4Zhz-Kb8O0a' );
define( 'NONCE_KEY',         'uEQr--Fz[6hC=S3uLKB#v#H}r<>f;w$Y#}N2i0q2^Jv3V43+e>jPGm.i!Eq:l/y2' );
define( 'AUTH_SALT',         '_/*0af0hXEawW%=!{u3UI0<_,*iM.m%_T#m{?IQ6qkeQXcgC6d$;v$k@3*PJjRZ$' );
define( 'SECURE_AUTH_SALT',  '~]:RbM_K8fNF}1De-Kk*zwk9m5~I3z$5cPeB9>[QF`9EemZ]@m{dMXuwT5M>s]yx' );
define( 'LOGGED_IN_SALT',    '}^kg+a*<ZUAYO!/5$gDVOZc=M>3>rA^KftxRk8M[ZkG4YSaunLJGBDKD~eZRPD9R' );
define( 'NONCE_SALT',        'V7INqB2Ay%|oV}Q:iZn{_$v#TgI+fKl,!pH9.VIehNVIybfM^pm>cpG{=:c2<lDs' );
define( 'WP_CACHE_KEY_SALT', ',*>zQ,Ajout}+JJU(SkV}`Rq53d}b>k `foL^Oi<F<-kgQ/K9hql7e? {Xq*EEh_' );

$table_prefix = 'wp_';

define("WP_DEBUG", false);
define("WP_DEBUG_LOG", false);
define("WP_DEBUG_DISPLAY", false);
@ini_set("display_errors", 0);

define("WP_SITEURL", "https://inkandspindle.com.au/app/wp");
define("WP_HOME", "https://inkandspindle.com.au/main");
define("WP_CONTENT_DIR", dirname(__FILE__) . "/content");
define("WP_CONTENT_URL", "https://inkandspindle.com.au/content");

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/app/wp/' );
}

# @NOTE: We require settings from the wp-config.php in the app/project directory. But we have to keep this comment because WP CLI errors if the line is missing.

# require_once( ABSPATH . 'wp-settings.php' );
