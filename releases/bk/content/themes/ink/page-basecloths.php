<?php get_header() ?>

<?php query_posts( $query_string . '&order=ASC&orderby=menu_order'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<div class="c">

		<h2 class="main-title">
			<span><?php the_title() ?></span>
		</h2>

		<div class="intro">
			<p>The foundations behind our collection.</p>
		</div>

		<div class="copy">
			<?php the_content(); ?>
		</div>

	</div>

<?php endwhile; else: endif; ?>

<div class="basecloth-index">
<?php
	$args = array( 'numberposts' => -1, 'post_type' => 'basecloths' );
	$basecloths = get_posts( $args );

	foreach( $basecloths as $basecloth ) :
?>

		<div class="basecloth-wrapper">

			<div class="c basecloth">

				<div class="media">
					<div class="shear-wrapper">
						<div class="img shear">
							<?php
								if ( has_post_thumbnail( $basecloth->ID ) ){
									$imagedata = wp_get_attachment_image_src( get_post_thumbnail_id( $basecloth->ID ), 'render' );
									echo '<img src="' . $imagedata[0] . '" alt="" />';
								}
							?>
						</div>
					</div>
				</div>

				<div class="bd">
					<h2 class="heading"><?php echo get_the_title( $basecloth->ID ); ?></h2>
					<?php
						if ( function_exists('ACF') ):
							$specs = get_field( 'basecloth_specs', $basecloth->ID )[0];
							?>
							<p>
								<span>Fibre:</span> <?php echo $specs['fibre']; ?><br />
								<span>Weight:</span> <?php echo $specs['weight']; ?><br />
								<span>Width:</span> <?php echo $specs['width']; ?>
							</p>
							<p>
								<span>Usage:</span> <?php echo $specs['usage']; ?>
							</p>
							<?php
						endif;
					?>
				</div>

				<div class="pricing-table">
					<p>Our designs printed on this basecloth</p>
					<?php $is_wholesale_customer = is_wholesaler(); ?>
					<?php if ( function_exists('ACF') ): ?>
						<table class="display-table">
							<thead>
								<tr>
									<th>1&times; colour</th>
									<th>2&times; colour</th>
									<th class="empty">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>$<?php echo get_field( 'basecloth_retail_price_one_colour', $basecloth->ID ); ?>/m</td>
									<td>$<?php echo get_field( 'basecloth_retail_price_two_colour', $basecloth->ID ); ?>/m</td>
									<th>(RRP)</th>
								</tr>
								<tr>
									<?php if ( $is_wholesale_customer ){ ?>
										<td>$<?php echo get_field( 'basecloth_trade_price_one_colour', $basecloth->ID ); ?>/m</td>
										<td>$<?php echo get_field( 'basecloth_trade_price_two_colour', $basecloth->ID ); ?>/m</td>
									<?php } else { ?>
										<td class="wholesaler-cell" colspan="2">
											<a href="<?php echo wholesale_url(); ?>">Trade pricing to approved customers</a>
										</td>
									<?php } ?>
									<th>
										<a href="<?php echo wholesale_url(); ?>">(Trade)</a>
									</th>
								</tr>
							</tbody>
						</table>
					<?php endif; ?>
				</div>

			</div>

		</div>

<?php
	endforeach;
?>
</div>
