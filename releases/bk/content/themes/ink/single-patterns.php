<?php get_header() ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<input id="post_id" type="hidden" value="<?php echo $post->ID; ?>"/>
	<input id="post_title" type="hidden" value="<?php the_title(); ?>"/>
	<input id="post_url" type="hidden" value="<?php the_permalink(); ?>"/>

	<div class="single-pattern">

		<div class="c c--noPadding">
			<?php get_template_part( 'partials/gallery' ); ?>
		</div>

		<div class="pattern-introduction c">
			<h1 class="heading"><?php the_title() ?></h1>
			<div class="content">
				<?php the_content(); ?>
			</div>
			<div class="specs">
				<p><?php pattern__specs(); ?></p>
			</div>
		</div>


		<div class="canvas-only">
			<div id="no-canvas-cover" style="display:none;">

			</div>



			<div id="customise" class="c favourite-colourways">
				<h2 class="med-heading">Design Your Colourway</h2>
				<div class="group">
					<?php pattern__favourite_colourways(); ?>
				</div>
			</div>

			<div class="pattern-customise c">

				<div class="render-wrapper">
					<div class="render" id="render"><!-- Canvas image gets rendered here. --></div>
					<?php
						$has_full_repeat = true;
						if ($screens = get_field( 'screens' )) {
							foreach($screens as $screen) {
								$full_repeat = isset($screen['screen_full_repeat']['sizes']['render_full_width']) ? $screen['screen_full_repeat']['sizes']['render_full_width'] : '';
								if (!$full_repeat) $has_full_repeat = false;
							}
						}
					?>

					<?php if ($has_full_repeat): ?>
						<button class="full-repeat-button" type="button">
							<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
								<path d="M0 0v4.08h.68V1.16l4.86 4.86.48-.48L1.16.68h2.92V0H0zm11.22 0v.68h2.92L9.28 5.54l.48.48 4.86-4.86v2.92h.68V0h-4.08zM5.54 9.28L.68 14.14v-2.92H0v4.08h4.08v-.68H1.16l4.86-4.86-.48-.48zm4.22 0l-.48.48 4.86 4.86h-2.92v.68h4.08v-4.08h-.68v2.92L9.76 9.28z" fill="currentColor"/>
							</svg>
							View full repeat
						</button>
					<?php endif; ?>
					<div class="render-caption">
						200mm &times; 200mm
						<!--
						<div id="share-container" class="share-container">
							<a href="#!" id="share__facebook">Share via Facebook</a>
							<a href="#!" id="share__twitter">Share via Twitter</a>
						</div>
						-->
					</div><!-- render-caption -->
				</div>

				<div class="swatches-wrapper">
					<?php pattern__customiser_swatches(); ?>
				</div><!-- .swatches-wrapper -->

			</div><!-- .pattern-customise -->

			<div class="full-repeat-modal" id="full-repeat-modal">
				<div class="full-repeat-modal-body">
					<a title="Close" class="fancybox-close" href="javascript:;"></a>
					<div class="full-repeat-modal-img" id="render-full-repeat">
						<!-- Canvas image gets rendered here. -->
					</div>
					<div class="full-repeat-modal-caption">
						<!-- Caption inserted ehre -->
					</div>
				</div>
			</div>

			<div class="cart-actions c" id="cart-actions">


				<div class="ordering-info">
					<h3><span>Ordering Info</span></h3>
					<p>Our screen printing table allows for a maximum length of 13m metres in a single run. Lengths are based on the vertical repeat of each individual design. Please note that despite our best efforts colourways shown on screen may not render with complete accuracy. Sample swatches are available in our <a href="http://shop.inkandspindle.com/products/colour-sample-swatch">ready-made store</a> for a fee of $10 per colour and are highly recommended. <a href="https://shop.inkandspindle.com/collections/hand-printed-meterage/products/strike-off-custom-printed-sample">Strike-offs</a> are also available.</p>
					<ul>
						<li>Prices are based on the selected basecloth</li>
						<li>Minimum order: <span id="min_order">2.5</span>m</li>
						<li>Available in repeats of <?php pattern__vertical_repeat(); ?>m</li>
						<!-- <li>See our <a href="<?php echo faq_url(); ?>">FAQ</a> for more</li> -->
					</ul>
					<p>
						Please see our <a href="https://inkandspindle.com.au/downloads/I&S_technical_data.pdf">Technical Data & Care</a> document for all custom fabrics & products prior to placing your order.
					</p>
				</div><!-- .ordering-info -->


				<div class="ordering-lengths">
					<h3><span>Specify Length(s)</span></h3>
					<ul id="order-lengths" class="order-lengths">
						<!-- JS creates lengths here. -->
					</ul>
					<div class="addlengths">
						<span class="small" id="total-meterage"></span>
						<a href="#!" id="addlength">Add a length <span>+</span></a>
					</div>

				</div><!-- .ordering-lengths -->

				<div class="ordering-pricing">
					<h3><span>Pricing</span></h3>
					<?php $number_of_screens = count(get_field('screens')); ?>
					<div class="tabgroup">
						<div class="tabnav">
							<a href="#tab1" class="<?php if ( ! is_wholesaler() ) echo 'active'; ?>">Retail</a>
							<a href="#tab2" class="<?php if ( is_wholesaler() ) echo 'active'; ?>">Trade</a>
						</div>
						<div class="tabcontent">
							<div class="tabpane" id="tab1" style="<?php if ( is_wholesaler() ) echo 'display:none;'; ?>">
								<h4>Price per metre</h4>
								<ul id="retail-pricebrackets">
									<li><div class="row">1&times; colour <span id="retail-one-colour"></span></div></li>
									<?php if ($number_of_screens === 2): ?>
										<li><div class="row">2&times; colour <span id="retail-two-colour"></span></div></li>
									<?php endif ?>
								</ul>
								<div class="small">Prices exclude GST</div>
							</div>
							<div class="tabpane" id="tab2" style="<?php if ( ! is_wholesaler() ) echo 'display:none;'; ?>">
								<h4>Price per metre</h4>
								<?php if ( is_wholesaler() ): ?>
									<ul id="wholesale-pricebrackets">
										<li><div class="row">1&times; colour <span id="trade-one-colour"></span></div></li>
										<?php if ($number_of_screens === 2): ?>
											<li><div class="row">2&times; colour <span id="trade-two-colour"></span></div></li>
										<?php endif ?>
									</ul>
									<div class="small">Trade price: 20% off RRP</div>
									<div class="small">Prices exclude GST</div>
									<br>
									<div class="small">
										<strong>TRADE BULK DISCOUNTS (applied to invoice)</strong>
										<br>
										Per print totalling 10m+ = 25% off RRP<br>
										Per print totalling 20m+ = 30% off RRP<br>
										Per print totalling 30m+ = 35% off RRP<br>
									</div>
								<?php else: ?>
									<p>
										<a href="<?php echo wholesale_url(); ?>">Trade pricing available on application.</a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div><!-- .tabgroup -->

					<div class="ordering-total">

						<h3><span>Cost</span></h3>

						<div class="cart-price">
							<span class="currency">$</span><span id="price">0.00</span>
						</div>

						<p>
							<span class="price-col">GST</span> $<span id="price-gst">10.00</span><br>
							<span class="price-col">Total</span> $<span id="price-total">19872.38</span>
						</p>

						<?php if ( is_wholesaler() ): ?>
							<p class="small">Total shows trade pricing.</p>
						<?php endif; ?>

						<p>
							<a href="#!" id="addtocart" class="boxbtn">Add to Order</a>
						</p>
						<p>
							<a href="/main/order" id="viewcart" class="boxbtn">View Cart</a>
						</p>

					</div><!-- .ordering-total -->

				</div><!-- .ordering-meterage -->


			</div><!-- .cart-actions -->








		</div><!-- .canvas-only -->



	</div><!-- .single-pattern -->

	<?php endwhile; else: endif; ?>

<?php get_footer();

