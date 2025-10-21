<?php get_header() ?>

	<?php if (have_posts()) : ?>
			
		<div class="c">
			<?php if ( is_tax('patterns_type') ): ?>
				<?php $current_term = get_term_by( 'slug', get_query_var( 'term' ), 'patterns_type' ); ?>

				<h1 class="main-title">
					<span><?php echo $current_term->name; ?></span>
				</h1>
				<div class="intro">
					<p><?php echo $current_term->description; ?></p>
					<?php 
						$related_terms = array(); 
						if ( $pattern_terms = get_terms( array( 'patterns_type' ), array( 'orderby' => 'menu' ) ) ):
							foreach ( $pattern_terms as $term ): 
								if ( $current_term->slug == $term->slug ) 
									continue;
								$related_terms[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
							endforeach;
						endif;
					?>
					<p>See also <?php echo join( ' and ', $related_terms ); ?></p>
				</div>

			<?php else: ?>
			
<div id="introduction" class="c waypoint-section">				
	<div class="group home-cta" style="margin-top:50px; float:none;">
		<a class="cta-customise" href="https://shop.inkandspindle.com/collections/fabrics">
			<span class="img">
				<img src="<?php echo THEME_URI; ?>/images/home/browse-ready-made-shop.jpg" alt="Browse ready-made shop" />
				<img src="<?php echo THEME_URI; ?>/images/home/browse-ready-made-shop-bw.jpg" alt="" />
			</span>
		</a>
		<a class="cta-readymade last" href="#customise">
			<span class="img">
				<img src="<?php echo THEME_URI; ?>/images/home/customise-our-textiles.jpg" alt="customise-our-textiles" />
				<img src="<?php echo THEME_URI; ?>/images/home/customise-our-textiles-bw.jpg" alt="" />
			</span>
		</a>
	</div>
</div>
			<div id="customise"></div>
				<h1 class="main-title" style="margin-top: 50px;">
					<span>Customise</span>
				</h1>
				<div class="intro">
					<p>Customise our texiles below with your choice of ink colour & cloth</p>
				</div>
			<?php endif; ?>
		
			<?php query_posts( $query_string . '&order=ASC&orderby=menu_order'); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<a class="pattern-preview" href="<?php the_permalink(); ?>">
					
					<div class="ratio">
						<?php 
							if ( has_post_thumbnail() ){
								$imagedata = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
								echo '<img src="' . $imagedata[0] . '" alt="' . get_the_title() . '" />';
							}
						?>
					</div>

					<div class="bd">
						<h2><?php the_title(); ?></h2>
						<p>View &amp; Customise &rarr;</p>
					</div>
					
				</a>
		
			<?php endwhile; ?>
		</div><!-- .c -->
		
	<?php else: ?>	
		
		<p>Nothing Found...</p>
		
	<?php endif; ?>


<?php get_footer();