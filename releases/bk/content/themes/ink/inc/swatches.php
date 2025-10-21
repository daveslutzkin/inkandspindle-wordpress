<?php
/* -----------------------------------------------------------------------------------------------------------------

	Json data.

----------------------------------------------------------------------------------------------------------------- */

function basecloths_json(){

	$data = array();
	$sort_order  = array();

	if ( function_exists('ACF') ):

		$args = array( 'numberposts' => -1, 'post_type' => 'basecloths', 'orderby' => 'menu_order', 'order' => 'ASC' );
		$basecloths = get_posts( $args );

		foreach( $basecloths as $basecloth ) :

			$specs = get_field( 'basecloth_specs', $basecloth->ID )[0];
			$wsp = is_wholesaler();
			$img = '';
			$full = '';

			if ( has_post_thumbnail( $basecloth->ID ) ){
				$thumbdata = wp_get_attachment_image_src( get_post_thumbnail_id($basecloth->ID), 'thumbnail' );
				$thumb = $thumbdata[0]; //$img = '<img src="' . $imagedata[0] . '" alt="" width="105" height="105" />';

				$rendersizedata = wp_get_attachment_image_src( get_post_thumbnail_id($basecloth->ID), 'render' );
				$render = $rendersizedata[0]; //$img = '<img src="' . $imagedata[0] . '" alt="" width="105" height="105" />';

			}

			$data[ $basecloth->ID ] = array(
				'id' => $basecloth->ID,
				'title' => get_the_title( $basecloth->ID ),
				'images' => array(
					'thumb' => $thumb,
					'render' => $render
				),
				'specs' => $specs,
				'wsp' => $wsp,
				'retail_price_one_colour' => get_field( 'basecloth_retail_price_one_colour', $basecloth->ID ),
				'retail_price_two_colour' => get_field( 'basecloth_retail_price_two_colour', $basecloth->ID ),
				'trade_price_one_colour' => get_field( 'basecloth_trade_price_one_colour', $basecloth->ID ),
				'trade_price_two_colour' => get_field( 'basecloth_trade_price_two_colour', $basecloth->ID ),
			);

			$sort_order[] = $basecloth->ID;

		endforeach;

	endif;

	return json_encode( array( $data, $sort_order ) );

} // json_basecloths()






function colours_json( $id_suffix = '', $none_swatch = false ){

	$data = array();
	$sort_order = array();

	if ( function_exists('ACF') ):

		$args = array(
			'numberposts' => -1,
			'post_type' => 'colours',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);

		$colours = get_posts( $args );


		if ( $none_swatch ):

			$data[0] = array(
				'id' => 0,
				'title' => 'None',
				'hex' => 'ffffff',
				'opacity' => '100',
				'white' => '0'
			);
			$sort_order[] = 0;

		endif;


		foreach( $colours as $colour ) :

			$specs = get_field( 'colour_data', $colour->ID )[0];

//			$data[] = array(
			$data[ $colour->ID ] = array(
				'id' => $colour->ID . $id_suffix,
				'title' => get_the_title( $colour->ID ),
				'hex' => str_replace( '#', '', $specs['hex'] ),
				'opacity' => $specs['opacity'],
				'white' => $specs['white_pigment']
			);

			$sort_order[] = $colour->ID;


		endforeach;

	endif; // function_exists('ACF')

	return json_encode( array( $data, $sort_order ) );

} // colours_json()



