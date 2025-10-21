<?php get_header() ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php
		global $current_user;
		wp_get_current_user();
	?>

	<?php if ( is_wholesaler() ): ?>

		<div class="c">

			<h1 class="main-title">
				<span><?php echo $current_user->display_name; ?></span>
			</h1>

			<p class="login-actions">
				<a class="logout btn" href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a>
			</p>
			<div class="copy">
				<p>Hey there, <?php echo $current_user->display_name; ?>! Welcome to the Ink & Spindle Trade Portal. Please choose from the options below:
			</div>
			<div class="narrow-copy wholesaler-actions">
				<p>
					<a class="boxbtn babyblue" href="<?php echo customise_url(); ?>">Custom Textiles</a>
					<small>
						Build your own unique colourways using our custom design tool.
						<br/><br/><br/>
						<b>Download PDF Pricelist:</b>
					</small>
					<small>
						<a class="boxbtn babyblue" href="http://inkandspindle.com/downloads/trade_pricelist.pdf">Custom & Stock Textiles Trade Pricelist — 2023</a>
					</small>
				</p>
				<p>
					<a class="boxbtn" href="https://shop.inkandspindle.com/discount/trade_250815">Ready Made Shop</a>
					<small>
						Our stock fabric & product range is available to purchase directly from our online store at trade prices (20% off RRP), using the following code at checkout:
						<br/>
						<br/>
						coupon code: <input type="text" value="trade_250815"/>
						<br/>
						<br/>
						(min. spend $100 RRP)
						<br/>
					</small>
				</p>
			</div>
		</div>

		<div class="c wholesaler-data">

			<div class="orderhistory">
				<h2>
					<span>Order History</span>
				</h2>
				<div class="orderhistory-box">
					<?php
					$args = array( 'post_type' => 'orders', 'author' => $current_user->ID, 'numberposts' => -1 );
					$my_orders = get_posts( $args );

					if ( $my_orders ): ?>


						<?php foreach( $my_orders as $order ): ?>

							<a class="orderhistory-entry" href="<?php echo get_permalink( $order->ID ); ?>">
								<small class="date"><?php echo get_the_date(); ?></small>
								<span class="orderid">Order #<?php echo $order->ID; ?></span>
							</a>

						<?php endforeach; ?>

					<?php else: ?>

						<p>No order history found.</p>

					<?php endif; ?>
				</div><!-- .orderhistory-list -->
			</div><!-- .orderhistory -->

			<?php get_template_part( 'partials/account-details' ); ?>

		</div><!-- .c -->




	<?php else: ?>





		<div class="c">

			<h1 class="main-title">
				<span><?php the_title() ?></span>
			</h1>

			<p class="login-actions">
				<a class="boxbtn" href="<?php echo wp_login_url( get_permalink() ); ?>"><span>Trade Portal Login</span></a>
				<?php if ( current_user_can('administrator') ): ?>
					<a class="boxbtn" href="/lookup" title="Lookup"><span>Lookup</span></a>
				<?php endif; ?>
			</p>

			<div class="copy">

				<?php the_content(); ?>

			</div>

		</div><!-- .c -->






	<?php endif; ?>


<?php endwhile; else: endif; ?>

<?php get_footer();
