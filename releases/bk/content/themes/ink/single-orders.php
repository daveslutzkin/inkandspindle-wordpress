<?php

	// PRIVATE
	// Orders are only visible to admins, or to the respective wholesaler who placed the account

	if ( have_posts() ):
		the_post();
		global $current_user;
		wp_get_current_user();
	endif;
	rewind_posts();


	if ( current_user_can('administrator') || ( $current_user->ID == get_the_author_id() ) ){
		// Carry on, sir.
	} else {
		wp_redirect( home_url() );
	    exit();
	}
?>


<?php get_header() ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="c">


		<h1 class="main-title">
			<span>Order # <?php the_title(); ?></span>
		</h1>

		<p class="intro">
			<?php the_author(); ?> &mdash; <?php echo get_the_date(); ?>
		</p>

		<table class="carttable">
			<?php the_content(); ?>
		</table>

		<div class="boxnote">
			<p>Note: This is not a tax receipt nor a confirmation that an order has been accepted or fulfilled. </p>
			<p>For information about an active order, including payment and shipping status, contact Ink & Spindle.</p>
			<p>Prices shown were accurate at the time of placing an order and does not include shipping, handling, and related costs. Cost and availability is subject to change.</p>
		</div>

	</div><!-- .centre -->

	<?php endwhile; else: endif; ?>

<?php get_footer();

