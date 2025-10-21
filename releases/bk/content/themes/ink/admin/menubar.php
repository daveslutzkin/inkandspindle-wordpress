<?php
if ( is_user_logged_in() ){

	function wknds_menubar() {
		
		echo '<style>';
		echo 	'#wknds-menubar { position:fixed; bottom: 20px; right: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.3); text-align:centre; } ';
		echo 	'#wknds-menubar a { display:inline-block; line-height:40px; width:40px; color:blue; text-decoration:none; background:#fff; } ';
		echo 	'#wknds-menubar a:first-child { border-right: 1px solid #eee; } ';
		echo '</style>';
		
		global $post;
		echo '<div id="wknds-menubar">';
		echo 	'<a class="wknds-icon-dashboard" href="'. admin_url() .'">X</a> ';
		echo 	is_singular() ? '<a class="wknds-icon-pencil" href="' . admin_url( 'post.php?post=' . $post->ID . '&amp;action=edit' ) . '">E</a>' : '';
		echo '</div>';
	}
	add_action('wp_footer', 'wknds_menubar');

}
