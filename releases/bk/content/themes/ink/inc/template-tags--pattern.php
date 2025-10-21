<?php


function pattern__vertical_repeat(){
	if ( function_exists('ACF') ):
		$field = get_field('specs');
		echo isset( $field[0]['vertical_repeat'] ) ? $field[0]['vertical_repeat'] : '';
	endif;
}


function pattern__specs(){

	if ( function_exists('ACF') ):
		$specs = get_field('specs')[0];
		echo '<strong>Horizontal Repeat:</strong> ' . $specs['horizontal_repeat'] . 'mm' . '<br />';
		echo '<strong>Vertical Repeat:</strong> ' . $specs['vertical_repeat'] . 'mm' . '<br />';
		echo '<strong>Designer:</strong> ' . $specs['designer'];
		echo '<input id="repeat_value" type="hidden" value="' . trim( $specs['vertical_repeat'] ) . '" />';
	endif;

} // END pattern__specs()


function pattern__favourite_colourways(){
	if ( function_exists('ACF') ):

		$colourways = get_field( 'colourways' );
		if ( $colourways ):
			foreach ( $colourways as $colourway ){

				$url = $colourway['colourway_ids'] ? trailingslashit( get_permalink() ) . '#!' . $colourway['colourway_ids'] : false;
				$img_src = isset( $colourway['image']['sizes']['thumbnail'] ) ? $colourway['image']['sizes']['thumbnail'] : false;

				// Skip if no URL or img:
				if ( ! $url || ! $img_src ) continue;

				echo '<a class="js-force-rebuild" href="' . $url . '">';
				echo 	'<img src="' . $img_src .'" alt="" width="50" height="50" />';
				echo '</a>';

			}
		endif;
	endif; // function_exists('ACF')
}



function pattern__customiser_swatches(){

	// Builds the base markup for javascript to populate with the actual colours and basecloth swatches.

	if ( function_exists('ACF') ){

		$default_basecloth = get_field( 'default_basecloth' );
		if ( $default_basecloth ):
		?>
			<div class="currentbasecloth collapse-toggle open group" id="current-basecloth">
				<span class="media"><!-- current img set as bg image here --></span>
				<h4 class="heading label">Basecloth</h4>
				<span class="title mini-heading"><!-- current basecloth name dropped here --></span>
				<input id="basecloth" type="hidden" data-basecloths='<?php echo basecloths_json(); ?>' data-defaultid="<?php echo $default_basecloth->ID; ?>" value=""/>
				<div class="specs">
					<!-- SPecs here with js -->
				</div>
				<b></b>
			</div>
			<div id="basecloth-collapse" class="collapse open">
				<div id="basecloth-swatches" class="swatch-container x-basecloth-swatches">
					<!-- basecloth swatches added via JS here -->
				</div>
			</div>


		<?php
		endif;


		$screens = get_field( 'screens' );
		if ( $screens ):

			$i = 1;
			$screen_data = array();
			$screens_count = count( $screens );

			echo '<div class="colours-section-' . $i . '">';

			foreach ( $screens as $screen ):
				if ( isset( $screen['default_colour'] ) && isset( $screen['screen'] ) ){
				?>
					<div class="currentcolour currentcolour-<?php echo $i; ?> collapse-toggle" id="current-colour-<?php echo $i; ?>">
						<span class="droplet"></span>
						<h4 class="heading label">Colour N<sup>o</sup><?php echo $i; ?></h4>
						<span class="title mini-heading"></span>
						<?php
							$screen_img_src = isset($screen['screen']['sizes']['render']) ? $screen['screen']['sizes']['render'] : '';
							$screen_full_repeat_img_src = isset($screen['screen_full_repeat']['sizes']['render_full_width']) ? $screen['screen_full_repeat']['sizes']['render_full_width'] : '';
							$id_suffix = '';
							$none_swatch = ( $screens_count > 1 && $i == 1 ) ? true : false;
						?>
						<input
							id="screen-<?php echo $i;?>"
							type="hidden"
							data-screenSrc='<?= $screen_img_src ?>'
							data-fullRepeatSrc='<?= $screen_full_repeat_img_src ?>'
							data-colours='<?php echo colours_json( $id_suffix, $none_swatch ); ?>'
							data-defaultid="<?php echo $screen['default_colour']->ID; ?>"
							value=""
						/>
						<b></b>
					</div>
					<div id="colour-<?php echo $i; ?>-collapse" class="collapse">
						<div id="colour-swatches-<?php echo $i; ?>" class="swatch-container">
							<!-- colour swatches added via JS here -->
						</div>
					</div>
				<?php
				}
				$i++;
			endforeach;

			echo '</div>';

		endif;

	} // function_exists('ACF')



} // END pattern__customiser_swatches()
