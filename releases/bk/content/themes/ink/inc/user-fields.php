<?php

function modify_contact_methods($profile_fields) {
	
	// Add new fields
	$profile_fields['tradingname'] = 'Trading Name';
	$profile_fields['abn'] = 'ABN';
	$profile_fields['phone'] = 'Phone';
	$profile_fields['address_line1'] = 'Address Line 1';
	$profile_fields['address_line2'] = 'Address Line 2';
	$profile_fields['city'] = 'City';
	$profile_fields['state'] = 'State';
	$profile_fields['postcode'] = 'Post Code';
	$profile_fields['country'] = 'Country';

	$profile_fields['shopify_coupon'] = 'Coupon';


	// Remove old fields
	unset($profile_fields['aim']);
	unset($profile_fields['yim']);
	unset($profile_fields['jabber']);


	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');




remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );



