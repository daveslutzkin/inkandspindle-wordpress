<?php

/* -----------------------------------------------------------------------------------------------------------------

	Custom Post Types

----------------------------------------------------------------------------------------------------------------- */

add_action( 'init', 'create_post_types' );
function create_post_types() {

	$custom_post_name = 'patterns';

	register_post_type( $custom_post_name,
		array(
			'labels' => array(
				'name' => __( 'Patterns' ),
				'singular_name' => __( 'Pattern' )
			),
			//'slug' => 'custom-design',
			'rewrite' => array( 'slug' => 'customise' ),
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);

	// register_taxonomy( 'patterns_type',
	// 	array( $custom_post_name ),
	// 	array(
	// 		'label' => 'Type',
	// 		'public' => true,
	// 		'show_ui' => true,
	// 		'show_admin_column' => true,
	// 		'rewrite' => array(
	// 			'slug' => '/customise-by-type',
	// 			'with_front' => true
	// 		),
	// 		'hierarchical' => true, // Category, not tags.
	// 	)
	// );


	$custom_post_name = 'basecloths';

	register_post_type( $custom_post_name,
		array(
			'labels' => array(
				'name' => __( 'Basecloths' ),
				'singular_name' => __( 'Basecloth' )
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);


	$custom_post_name = 'colours';

	register_post_type( $custom_post_name,
		array(
			'labels' => array(
				'name' => __( 'Colours' ),
				'singular_name' => __( 'Colour' )
			),
			'public' => true,
//			'publicly_queryable' => false,
//			'has_archive' => false,
			'supports' => array( 'title' )
		)
	);




	$custom_post_name = 'orders';

	register_post_type( $custom_post_name,
		array(
			'labels' => array(
				'name' => __( 'Orders' ),
				'singular_name' => __( 'Order' )
			),
			'public' => true,
//			'publicly_queryable' => false,
//			'has_archive' => false,
			'supports' => array( 'title', 'editor' )
		)
	);



	$custom_post_name = 'homewares';

	register_post_type( $custom_post_name,
		array(
			'labels' => array(
				'name' => __( 'Homewares' ),
				'singular_name' => __( 'Homewares' )
			),
			'public' => true,
//			'publicly_queryable' => false,
			'has_archive' => false,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);

}


/* -----------------------------------------------------------------------------------------------------------------

	Redirect Single "basecloths" Custom Post Type

----------------------------------------------------------------------------------------------------------------- */


/*
function redirect_basecloth_single() {
	if ( get_post_type() == 'basecloths' ){
    //if ( ! is_page('basecloths') ){
    //if ( is_singular() && get_post_type() == 'basecloths' ) {
        wp_redirect( home_url("/basecloths"), 301 );
        exit();
    }
}
add_action('template_redirect', 'redirect_basecloth_single' );
//*/




function single_cpt_redirect(){
    if ( is_singular( 'basecloths' ) ){
	    wp_redirect( home_url( '/basecloths/' ), 301 );
	    exit;
	} else if ( is_singular( 'colours' ) ){
	    wp_redirect( home_url(), 301 );
	    exit;
	}
}
add_action( 'template_redirect', 'single_cpt_redirect' );





/* -----------------------------------------------------------------------------------------------------------------

	Custom Admin Columns

----------------------------------------------------------------------------------------------------------------- */


/*-------------------------------------------------------------------------------
	Custom Columns for "colours"
-------------------------------------------------------------------------------*/

$post_type = 'colours';

add_filter( 'manage_edit-'.$post_type.'_columns', 'set_custom_edit_'.$post_type.'_columns' );
add_action( 'manage_'.$post_type.'_posts_custom_column' , 'custom_'.$post_type.'_column', 10, 2 );

function set_custom_edit_colours_columns($columns) {
    unset($columns['author']);
    unset($columns['date']);
    return $columns
         + array(
         	//'book_author' => __('Author'),
         	'colour' => __('Colour')
         );
}

function custom_colours_column( $column, $post_id ) {
    switch ( $column ) {
      case 'colour':
      	if ( function_exists('ACF') ){
      		$specs = get_field( 'colour_data', $post_id )[0];
      		echo '<div style="margin: -4px -6px; background:white url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAAUdEVYdENyZWF0aW9uIFRpbWUAMy82LzEz9bPs2gAAADNJREFUOI1jfPr06X8GPEBKSgqfNAMTXlkiwKgBg8EAxv///+NNB8+ePaOtC0YNGAwGAACMmwrJLQsb0gAAAABJRU5ErkJggg==) 0 0 repeat;">';
	        echo 	'<div style="height:4.4em; background:' . $specs['hex'] . '; opacity:' . $specs['opacity']/100 . ';"></div>';
	        echo '</div>';
      	}
      	break;

/*
      case 'publisher':
        echo get_post_meta( $post_id , 'publisher' , true );
        break;
*/
    }
}



/*-------------------------------------------------------------------------------
	Custom Columns for "colours"
-------------------------------------------------------------------------------*/

$post_type = 'basecloth';

add_filter( 'manage_edit-'.$post_type.'_columns', 'set_custom_edit_'.$post_type.'_columns' );
add_action( 'manage_'.$post_type.'_posts_custom_column' , 'custom_'.$post_type.'_column', 10, 2 );

function set_custom_edit_basecloth_columns($columns) {
    unset($columns['author']);
    unset($columns['date']);
    return $columns
         + array(
         	//'book_author' => __('Author'),
         	'basecloth' => __('Basecloth')
         );
}

function custom_basecloth_column( $column, $post_id ) {
    switch ( $column ) {
      case 'basecloth':
      	if ( get_post_thumbnail_id( $post_id ) ){
	      	$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
	        echo '<div style="height:3.3em; margin: -4px -6px; padding:4px; background:url('.$image_attributes[0].');">&nbsp;</div>';
      	}
      	break;
    }
}

