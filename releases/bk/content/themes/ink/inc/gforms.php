<?php
/* -----------------------------------------------------------------------------------------------------------------

	Gravity Forms extra Jazz

----------------------------------------------------------------------------------------------------------------- */



add_filter( 'gform_field_value_wholesaler_email', 'populate_wholesaler_email');
//			 gform_field_value_%my-parameter%
function populate_wholesaler_email(){
	global $current_user;
	wp_get_current_user();

//	echo 'Username: ' . $current_user->user_login . "\n";
//	echo 'User email: ' . $current_user->user_email . "\n";
//	echo 'User first name: ' . $current_user->user_firstname . "\n";
//	echo 'User last name: ' . $current_user->user_lastname . "\n";
//	echo 'User display name: ' . $current_user->display_name . "\n";
//	echo 'User ID: ' . $current_user->ID . "\n";

    return $current_user->user_email;
}

add_filter( 'gform_field_value_address_line1', 'populate_address_line1');
//			 gform_field_value_%my-parameter%
function populate_address_line1(){
	global $current_user;
	wp_get_current_user();
    return $current_user->address_line1 ?? "";
}

add_filter( 'gform_field_value_address_line2', 'populate_address_line2');
//			 gform_field_value_%my-parameter%
function populate_address_line2(){
	global $current_user;
	wp_get_current_user();
    return $current_user->address_line2 ?? "";
}

add_filter( 'gform_field_value_city', 'populate_city');
//			 gform_field_value_%my-parameter%
function populate_city(){
	global $current_user;
	wp_get_current_user();
    return $current_user->city ?? "";
}

add_filter( 'gform_field_value_state', 'populate_state');
//			 gform_field_value_%my-parameter%
function populate_state(){
	global $current_user;
	wp_get_current_user();
    return $current_user->state ?? "";
}

add_filter( 'gform_field_value_postcode', 'populate_postcode');
//			 gform_field_value_%my-parameter%
function populate_postcode(){
	global $current_user;
	wp_get_current_user();
    return $current_user->postcode ?? "";
}

add_filter( 'gform_field_value_country', 'populate_country');
//			 gform_field_value_%my-parameter%
function populate_country(){
	global $current_user;
	wp_get_current_user();
    return $current_user->country ?? "";
}


add_filter( 'gform_field_value_tradingname', 'populate_tradingname');
//			 gform_field_value_%my-parameter%
function populate_tradingname(){
	global $current_user;
	wp_get_current_user();
    return $current_user->tradingname ?? "";
}


add_filter( "gform_allowable_tags", "allow_basic_tags", 10, 3 );


// Allows tags in submitted form fields.
// In this case we're allowing table markup so we can have our shopping cart in the email as a table.
function allow_basic_tags( $allowable_tags ){
    return '<table><tr><th><td><a><br>';
}
