<?php 
/*
* Template Name: Pattern Index
*/
get_header() ?>

	<?php if (have_posts()) : ?>
			
		<div class="c">			
			<h1 class="main-title">
				<span><?php the_title(); ?></span>
			</h1>
			<div class="intro -capped-width">
				<p><?php the_field('description'); ?></p>
				<?php 
					// $pattern_indexes = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-patternindex.php', 'orderby' => 'menu' ) );
					// echo '<pre clas="xpr">' . print_r( $pattern_indexes, true ) . '</pre>';
					$related_terms = array(); 
					if ( $pattern_indexes = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-patternindex.php', 'sort_column' => 'menu_order', 'sort_order' => 'ASC' ) ) ):
						foreach ( $pattern_indexes as $index ): 
							if ( $post->ID == $index->ID ) 
								continue;
							$related_terms[] = '<a href="' . get_permalink($index->ID) . '">' . $index->post_title . '</a>';
						endforeach;
					endif;
				?>
				<?php if ( $related_terms ): ?>
					<p>See also <?php echo join( ' and ', $related_terms ); ?></p>
				<?php endif; ?>
			</div>
		
			<?php if ( $patterns = get_field('patterns') ): ?>
				<?php foreach ( $patterns as $post ): ?>					
					<a class="pattern-preview" href="<?php echo get_permalink( $post->ID ); ?>">
						<div class="ratio">
							<?php 
								if ( has_post_thumbnail( $post->ID ) ){
									$imagedata = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
									echo '<img src="' . $imagedata[0] . '" alt="' . get_the_title() . '" />';
								}
							?>
						</div>
						<div class="bd">
							<h2><?php echo get_the_title( $post->ID ); ?></h2>
							<p>View &amp; Customise &rarr;</p>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
			
		</div><!-- .c -->
		
	<?php else: ?>	
		
		<p>Nothing Found...</p>
		
	<?php endif; ?>


<?php get_footer();