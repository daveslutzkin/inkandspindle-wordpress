<?php


// Next Project / Handy Helpers:

// There's no native fucntion for this.
function get_the_content_by_id( $id ){
	return apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
}

function the_content_by_id( $id ){
	echo apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
}




// END






// Helper to test if user is an approved wholesaler and logged in.
function is_wholesaler(){
//	return false;

	if ( current_user_can('subscriber') || current_user_can('administrator') ){
//	if ( is_user_logged_in() ){
		return true;
	}

	return false;
}






// Helper functions for URLs
function wholesale_url(){
	return HOME_URI . '/trade';
}

function customise_url(){
	return HOME_URI . '/customise'; // Comment this line out if you want your admin choice of pattern page to be the customis landing page.

	if ( $pattern_indexes = get_pages( array( 'number' => 1, 'meta_key' => '_wp_page_template', 'meta_value' => 'template-patternindex.php', 'sort_column' => 'menu_order', 'sort_order' => 'ASC' ) ) ):
		return get_permalink( $pattern_indexes[0]->ID );
	endif;
	return HOME_URI . '/customise';
}

function basecloths_url(){
	return HOME_URI . '/basecloths';
}

function shop_url(){
	return 'http://inkandspindle.com.au';
}

function blog_url(){
	return 'http://inkandspindle.blogspot.com.au/';
}

function lookup_url(){
	return HOME_URI . '/lookup';
}


function faq_url(){
	return HOME_URI . '/faq';
}



// Helper to tell if we're on the Textiles part of the site.
function is_textiles(){
	if (  
		is_post_type_archive( array( 'patterns', 'orders' ) ) 
		|| is_page_template( 'template-patternindex.php' )
		|| is_tax( 'patterns_type' )
		|| is_singular( array('patterns', 'orders') ) 
		|| is_page( array('basecloths', 'homewares', 'order', 'lookup') ) //'wholesale', 
	){
		return true;
	}
	return false;
}




