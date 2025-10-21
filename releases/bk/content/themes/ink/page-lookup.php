<?php
	// PRIVATE
	if ( ! current_user_can('administrator') ){
	    wp_redirect( home_url() );
	    exit();
	}
?>

<?php get_header() ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php if ( current_user_can('administrator') ): ?>
	
		<h1 class="main-title">
			<span><?php the_title(); ?></span>
		</h1>

		<div class="c">

			<div class="orderhistory">
<!-- 				<h2>Order History:</h2> -->
				<div class="orderhistory-box">
					<?php
					$args = array( 'post_type' => 'orders', 'numberposts' => -1 );
					$my_orders = get_posts( $args );
					
					if ( $my_orders ): ?>
	
						<?php foreach( $my_orders as $order ): ?>
								
							<div class="orderhistory-entry">
								<a href="<?php echo get_permalink( $order->ID ); ?>">
									<span class="date"><?php echo get_the_date(); ?></span>
									<span class="orderid">Order ID <?php echo $order->ID; ?></span>
									<?php echo $order->post_author; ?>
								</a>
							</div>
												
						<?php endforeach; ?>
	
					<?php else: ?>
					
						<p>No order history found.</p>
	
					<?php endif; ?>
				</div><!-- .orderhistory-list -->
			</div><!-- .orderhistory -->
			
<!--
			<hr />
			
			<div class="wholesalerlist">
				<h2>Wholesalers:</h2>
				<div class="wholesalerlist-box">
					<?php
				    	$wholesalers = get_users( "blog_id=1&orderby=nicename" );
					    if ( $wholesalers ):
						    foreach ( $wholesalers as $wholesaler ):
						        echo '<li><a href="' . get_author_posts_url( $wholesaler->ID ) . '">' . $wholesaler->tradingname . '</a></li>';
						    endforeach;
					    endif;
					?>
					
				</div>

			</div>
-->


	<?php else: ?>
		
		<!-- nothing, or redirect -->	
	
	<?php endif; ?>		
	
	
<?php endwhile; else: endif; ?>

<?php get_footer();
