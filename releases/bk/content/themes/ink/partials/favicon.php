<?php
	$favicon = 'favicon.ico';

	if ( defined('WKNDS_DEBUG') && WKNDS_DEBUG == 'dev' ){
		$favicon = 'favicon-dev-blue.ico';
	} else if ( defined('WKNDS_DEBUG') && WKNDS_DEBUG == 'temp' ){
		$favicon = 'favicon-dev-green.ico';
	}
?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/images/' . $favicon; ?>"/>
