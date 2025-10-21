<?php get_header() ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<input id="post_id" type="hidden" value="<?php echo $post->ID; ?>"/>
	<input id="post_title" type="hidden" value="<?php the_title(); ?>"/>
	<input id="post_url" type="hidden" value="<?php the_permalink(); ?>"/>

	<div class="centre">
	
		<table id="cart" class="carttable">
			<?php the_content(); ?>
		</table>
		
		<p>
			Order lookups are the records of ... provided for your convenience. 
			Please note that this is not a tax receipt nor confirmation that an order has been accepted or fulfilled. 
		</p>

	</div><!-- .centre -->

	<?php endwhile; else: endif; ?>

<?php get_footer();

