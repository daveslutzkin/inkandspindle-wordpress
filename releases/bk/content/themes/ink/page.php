<?php get_header() ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="c">
			<h1 class="main-title"><?php the_title() ?></h1>
			<div class="narrow-copy">
				<?php the_content(); ?>
			</div>
		</div>

	<?php endwhile; else: endif; ?>

<?php get_footer();
