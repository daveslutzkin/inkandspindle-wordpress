<?php
	// PRIVATE
	if ( ! current_user_can('administrator') ){
	    wp_redirect( home_url() );
	    exit();
	}
?>

<?php get_header() ?>

<?php if ( have_posts() ): ?>
	<?php the_post(); ?>

	<div class="heading-group">
		<h1 class="heading"><?php the_author(); ?></h1>
		<p>author.php</p>
	</div>

	<?php rewind_posts(); ?>
	
	<div class="c">
		<ul>
		
			<?php while ( have_posts() ): ?>
				<?php the_post(); ?>
				<li><?php the_title(); ?></li>
			<?php endwhile; ?>
		</ul>
	</div>

<?php else: ?>
	
	<p>No orders, bro.</p>

<?php endif; ?>

<?php get_footer();