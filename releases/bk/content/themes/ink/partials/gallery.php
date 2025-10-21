<?php if ( function_exists('ACF') ): ?>

	<?php $slides = get_field( 'gallery' ); ?>
	<?php if ( $slides ): ?>

		<ul class="module-gallery -isstyle">
			<?php foreach ( $slides as $slide ): ?>

				<li class="slide">
					<div class="contents">
						<div class="img">
							<img src="<?php echo $slide['image']['url']; ?>" alt="" />
							<span class="toggle">
								<i></i>
								<i></i>
							</span>
						</div>
						<div class="description">
							<?php echo $slide['description']; ?>
						</div>
					</div>
				</li>
				<?php //echo '<pre class="xpr">' . print_r( $slide, true ) . '</pre>' . '<hr />'; ?>

			<?php endforeach; ?>
		</ul><!-- .gallery -->

	<?php endif; ?>
<?php endif; ?>



<?php
//$imagedata = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
//echo '<img src="' . $imagedata[0] . '" alt="' . get_the_title() . '" />';
?>
