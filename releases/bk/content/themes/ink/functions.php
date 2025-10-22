<?php
define("THEME_VER", "2.5.1");
define("THEME_MODIFIED_DATE", "202410221105"); // Update when you change CSS or JavaScript in order force browsers to get a fresh version of CSS files etc.
define("VENDOR_MODIFIED_DATE", "20190930-1130");


// Redirect non admins to wholesale page on login

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
function my_login_redirect($redirect_to, $request, $user ) {
  //is there a user to check?
  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
    //check for admins
    if ( in_array( 'administrator', $user->roles ) ) {
      // redirect them to the default place
      return $redirect_to;
    } else {
			return wholesale_url();
    }
  } else {
    return $redirect_to;
  }
}

add_action('wp_head', 'add_favicon');
function add_favicon(){
?>
<link rel="icon" href="https://cdn.shopify.com/s/files/1/0031/9032/t/7/assets/favicon.svg?v=<?php echo THEME_MODIFIED_DATE ?>" type="image/svg+xml">
<?php
};



/* -----------------------------------------------------------------------------------------------------------------

	Definitions

----------------------------------------------------------------------------------------------------------------- */

define( 'HOME_URI', get_bloginfo('url') );
define( 'THEME_URI', get_stylesheet_directory_uri() );

define( 'INSPIRATION_FIELD_ID', 'field_51ff276853a98' );



/* -----------------------------------------------------------------------------------------------------------------

	Theme Setup

----------------------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'wknds_setup' ) ) :
function wknds_setup() {

	include("inc/cycle.php");

	include("inc/post-types.php");
	include("inc/template-tags.php");
	include("inc/template-tags--pattern.php");
	include("inc/swatches.php");
	include("inc/user-fields.php");
	include("inc/gforms.php");


	add_theme_support( 'post-thumbnails' );


	register_nav_menus( array(
		'primary' => 'Primary Menu',
	) );

}
endif; // wknds_setup
add_action( 'after_setup_theme', 'wknds_setup' );

add_action("after_setup_theme", function() {
  add_image_size("render", 570, 570, true);
  add_image_size("render_full_width", 1440, 900, true);
  add_image_size("inspiration_default", 352, 235, true);
  add_image_size("inspiration_portrait", 352, 487, true);
  add_image_size("inspiration_featured", 727, 487, true);
});

add_filter("image_size_names_choose", function($sizes) {
  return array_merge($sizes, [
    "render"               => __("Render (570×570)"),
    "render_full_width"    => __("Render Full Width (1440×900)"),
    "inspiration_default"  => __("Inspiration Default (352×235)"),
    "inspiration_portrait" => __("Inspiration Portrait (352×487)"),
    "inspiration_featured" => __("Inspiration Featured (727×487)"),
  ]);
});





/* -----------------------------------------------------------------------------------------------------------------

	Don't show users the Dashboard.
	But still let them use the wp-admin/profile page to update user details etc.

----------------------------------------------------------------------------------------------------------------- */

function wp_dashboard_ban(){}
add_action( 'admin_init','wp_dashboard_ban' );








/* -----------------------------------------------------------------------------------------------------------------

	Admin Enhancements

----------------------------------------------------------------------------------------------------------------- */

//include("admin/admin.php");
//include("admin/menubar.php");


// admin styles for ACF textareas (they're hell large by default):
function acf_ui_admin_style_override(){
?>
	<style>
		.acf_postbox .field textarea {
			height: auto !important;
			min-height: 90px !important;
		}
		.acf-image-uploader[data-preview_size="thumbnail"] img {
			max-width: 90px;
		}
	</style>
<?php
}
add_action('admin_head', 'acf_ui_admin_style_override');








/* -----------------------------------------------------------------------------------------------------------------

	Enqueue scripts and styles

----------------------------------------------------------------------------------------------------------------- */

function wknds_scripts() {
	$date = THEME_MODIFIED_DATE;
	$vendor_date = VENDOR_MODIFIED_DATE;

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'jquery-ui-custom', get_template_directory_uri() . '/js/jquery-ui-1.10.3.custom.min.js', array( 'jquery' ), '1.10.3', true );

	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), $vendor_date, true );
	wp_enqueue_script( 'count-to', get_template_directory_uri() . '/js/jquery.countTo.js', array( 'jquery' ), $vendor_date, true );

	wp_enqueue_script( 'cookies', get_template_directory_uri() . '/js/cookies.min.js', array( 'jquery' ), $vendor_date, true );
	wp_enqueue_script( 'notifications', get_template_directory_uri() . '/js/jquery.notifications.js', array( 'jquery' ), $date, true );

	wp_enqueue_script( 'canvas-helpers', get_template_directory_uri() . '/js/canvas-helpers.js', array( 'jquery' ), $date, true );
	wp_enqueue_script( 'collapse', get_template_directory_uri() . '/js/jquery.collapse.js', array( 'jquery' ), $date, true );

	wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.min.js', array( 'jquery' ), $vendor_date, true );

	global $post;
	if ( is_page( 'inspiration' ) ){
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), $vendor_date, true );
	}

	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), $vendor_date, true );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/application.js', array( 'jquery' ), $date, true );
	wp_enqueue_script( 'go', get_template_directory_uri() . '/js/application-go.js', array( 'jquery' ), $date, true );
	wp_enqueue_script( 'wknds-gforms', get_template_directory_uri() . '/js/gravity-forms.js', array( 'jquery' ), $date, true );

}
add_action( 'wp_enqueue_scripts', 'wknds_scripts' );







/* -----------------------------------------------------------------------------------------------------------------

	Remove Junk from Head

----------------------------------------------------------------------------------------------------------------- */

// Bones
// remove some WP defaults
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link'); // remove windows live writer link
	remove_action('wp_head', 'wlwmanifest_link'); // remove the version number
	remove_action('wp_head', 'wp_generator'); // remove header links
	remove_action('wp_head', 'feed_links', 2 ); // Comment feed RSS links
	remove_action('wp_head','feed_links_extra', 3); // kill all extra RSS feed links in the head
}
add_action('init', 'removeHeadLinks');


add_theme_support("title-tag");

