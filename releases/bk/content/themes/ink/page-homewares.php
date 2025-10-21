<?php get_header() ?>


<?php query_posts( $query_string . '&order=ASC&orderby=menu_order'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<div class="c">

		<h2 class="main-title">
			<span><?php the_title() ?></span>
		</h2>

		<div class="intro">
			<p>Made to order objects with a textile twist</p>
		</div>

		<div class="copy">
			<?php the_content(); ?>
		</div>

	</div><!-- .c -->


<?php endwhile; else: endif; ?>


<div class="basecloth-index">
<?php
	$args = array( 'numberposts' => -1, 'post_type' => 'homewares', 'orderby' => 'menu_order', 'order' => 'ASC' );
	$homewares = get_posts( $args );

	foreach( $homewares as $homeware ) :
		//setup_postdata($homeware);
		?>

		<div class="basecloth-wrapper">

			<div class="c basecloth _homeware">

				<div class="media">
					<div>
						<div class="img">
							<?php
								// Get the full size image and (initially) show just a section of it.
								if ( has_post_thumbnail( $homeware->ID ) ){
									$imagedata = wp_get_attachment_image_src( get_post_thumbnail_id( $homeware->ID ), 'render' );
									echo '<img src="' . $imagedata[0] . '" alt="" />';
								}
							?>
							<?php // echo '<img class="magnify" src="' . THEME_URI . '/images/magnify.png" alt="" width="18" height="18" />'; ?>
						</div>
					</div>
				</div><!-- .media -->

				<div class="bd">
					<h2 class="heading"><?php echo get_the_title( $homeware->ID ); ?></h2>
					<?php echo apply_filters( 'the_content', get_post_field( 'post_content', $homeware->ID ) ); ?>
				</div><!-- .bd -->

				<div class="pricing-table">
					<?php if ( function_exists('ACF') ):
						$rows = get_field( 'pricing_table', $homeware->ID );

						$head_row = '';
						$rrp_row = '';
						$wsp_row = '';

						foreach ( $rows as $row ){
							$head_row .= '<th>' . $row['heading'] . '</th>';
							$rrp_row .= '<td>' . $row['rrp'] . '</td>';
							$wsp_row .= '<td>' . $row['wsp'] . '</td>';
						}

						?>
						<table class="display-table">
							<thead>
								<tr>
									<?php echo $head_row; ?>
									<th class="empty">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php echo $rrp_row; ?>
									<th>(RRP)</th>
								</tr>
								<tr>
									<?php if ( is_wholesaler() ){ ?>
										<?php echo $wsp_row; ?>
									<?php } else { ?>
										<td class="wholesaler-cell" colspan="<?php echo count($rows); ?>">
											<a href="<?php echo wholesale_url(); ?>">Wholesaler Pricing to approved customers</a>
										</td>
									<?php } ?>
									<th>
										<a href="<?php echo wholesale_url(); ?>">(WSP)</a>
									</th>
								</tr>
							</tbody>
						</table>
						<?php $footnote = get_field( 'footnote', $homeware->ID ); ?>
						<?php if ( $footnote ): ?>
							<p><?php echo $footnote; ?></p>
						<?php endif; ?>

					<?php endif; // ACF ?>
				</div><!-- pricing table -->

			</div><!-- .basecloth -->

		</div><!-- .basecloth-wrapper -->

		<?php
	endforeach;
?>
</div><!-- .basecloth-index -->

<?php get_footer();