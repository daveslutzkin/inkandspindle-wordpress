<?php get_header() ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="c page--faq">

	<h1 class="main-title">
		<span><?php the_title(); ?></span>
	</h1>

	<div class="inspiration-wrapper">
		<?php
			if ( function_exists('ACF') ):
				$tiles = get_field( 'inspiration' );
				if ( $tiles ):
					foreach ( $tiles as $tile ):

						$tile_cats = $tile['category'];
						$cat_class = '';
						if ( $tile_cats ):
							foreach ( $tile_cats as $cat ):
								$cat_class .= ' type-' . trim( strtolower( $cat ) ) . ' ';
							endforeach;
						endif;

						$caption = $tile['caption'] ? 'data-fancybox-title=\'' . $tile['caption'] . '\' ' : '';

						// echo '<pre clas="xpr">' . print_r( $tile, true ) . '</pre>';
						?>

						<a <?php echo $caption; ?> href="<?php echo $tile['image']['sizes']['large'] ?>" class="tile fancybox <?php echo '-' . $tile['size'] . ' ' . $cat_class; ?>" rel="group">
							<div class="img">
								<?php
					        $image_src = '';
					        $image_size = $tile['size'];

					        $image_id = isset( $tile['image']['id'] ) ? $tile['image']['id'] : null;

					        if ( $image_id ):
						        //echo $tile['size'];

										switch ( $tile['size'] ) {
									    case 'default':
								        $image_src = $tile['image']['sizes']['inspiration_default'];
								        break;
									    case 'portrait':
										    $image_src = $tile['image']['sizes']['inspiration_portrait'];
								        break;
									    case 'featured':
										    $image_src = $tile['image']['sizes']['inspiration_featured'];
								        break;
										}

				        	endif;

									echo '<img src="' . $image_src . '" alt="" />';

								?>
							</div>
						</a>
 					<?php
					endforeach;

				endif;
			endif; // ACF
		?>
	</div><!-- .inspiration_wrapper -->

	<?php //echo '<pre class="xpr">' . print_r( $tiles, true ) . '</pre>'; ?>

</div><!-- .c -->

<?php endwhile; else: endif; ?>


<?php get_footer();
