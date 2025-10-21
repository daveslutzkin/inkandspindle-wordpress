<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="p:domain_verify" content="b1991f1351cc46ded428464815aef1ad"/>

	<link rel="stylesheet" href="https://fonts.typotheque.com/WF-021117-002395.css" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>

	<link rel="stylesheet"  href="<?php echo get_template_directory_uri() . '/css/application.css' . '?ver=' . THEME_MODIFIED_DATE ?>" />

	<?php wp_head(); ?>

	<?php if (!current_user_can("administrator")): ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-6BD0SPT56X"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-6BD0SPT56X');
		</script>
	<?php endif ?>

</head>
<body>

	<div class="page <?php if ( is_page( array('basecloths', 'homewares') ) ){ echo '-basecloths'; } ?>">

		<header class="site-header <?php if ( is_textiles() ){ echo '-textiles'; }?>">
			<div class="site-title">
				<a href="<?php echo home_url() ?>"><img src="<?php echo THEME_URI; ?>/images/ink-and-spindle.png" alt="Ink & Spindle" width="145" height="16"></a>
				<span id="navtoggle" class="nav-toggle"></span>
			</div>
			<div id="navigation" class="site-navigation">
				<div class="site-navigation-menus">
					<?php get_template_part( 'partials/nav' ); ?>
				</div>
			</div>

		</header>

		<div class="primary-content">
