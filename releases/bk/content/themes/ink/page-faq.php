<?php get_header() ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="c page--faq">

	<h1 class="main-title" id="faqpage">
		<span><?php the_title(); ?></span>
	</h1>

	<div class="faq_wrapper">

		<?php
			function string_to_class($string) {
			    //lower case everything
			    $string = strtolower($string);
			    //make alphaunermic
			    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
			    //Clean multiple dashes or whitespaces
			    $string = preg_replace("/[\s-]+/", " ", $string);
			    //Convert whitespaces and underscore to dash
			    $string = preg_replace("/[\s_]/", "-", $string);
			    return $string;
			}		?>
		<?php if ( function_exists('ACF') ): ?>
			<?php $faq = get_field( 'section' ); ?>
			<?php if ( $faq ): ?>
				<?php $i = 0; ?>
				<?php foreach ( $faq as $section ): ?>

					<div class="faq__section">
						<h2 class="faq__section-heading"><?php echo $section['section_title']; ?></h2>
						<div class="faq__topics">
						<?php foreach ( $section['section_content'] as $topic ): ?>
							<h3 class="faq__topic-heading toggle" data-topicID="faq-<?php echo $i ?>" <?php echo 'id="' . string_to_class( $topic['heading'] ) . '"'; ?>>
								<span><?php echo $topic['heading']; ?></span>
							</h3>
							<div class="collapse" id="faq-<?php echo $i ?>">
								<div>
									<div class="faq__topic-content">
										<?php echo $topic['content']; ?>
									</div><!-- faq__topic-content -->
								</div>
							</div><!-- .collapse -->
							<?php $i++; ?>
						<?php endforeach; ?>
						</div><!-- .faq__topic -->
					</div><!-- .faq__section -->


				<?php endforeach; ?>

			<?php endif; ?>
		<?php endif; // ACF ?>

	</div><!-- .faq_wrapper -->

</div><!-- .c -->

<?php endwhile; else: endif; ?>


<?php get_footer();