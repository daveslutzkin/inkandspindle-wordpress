<?php get_header() ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="c page--order">

	<h1 class="main-title">
		<span><?php the_title(); ?></span>
	</h1>
	
	<table id="cart" class="carttable">
		<!-- cart contents inserted her via JS and cookies. -->
	</table>

	
	<?php $wholesale_form = is_wholesaler() ? true : false; ?>

	<div id="cartform" class="group cartform <?php echo $wholesale_form ? 'wholesaler' : 'not-wholesaler'; ?>" style="display:none;">
		<?php if ( $wholesale_form ): ?>
		
			<?php 
				// Just the submit button.
				gravity_form( 'Wholesale Order', false, false, false, null, false ); 
			?>
			
			<div class="boxnote-wrapper">
				<div class="boxnote">
					<p>Once we’ve received your order we’ll get in touch to organise printing timelines, payment, and shipping costs and arrangements. We don’t take credit card or payment details at this stage.</p>
					<p>Amounts in Australian Dollars. GST is only charged to orders placed within Australia.</p>
				</div>
			</div>
			<?php get_template_part( 'partials/account-details' ); ?>
			
			
		<?php else: ?>
		
			<div class="narrow-copy">
				<div class="boxnote">
					<p>Once we’ve received your order we’ll get in touch to organise printing timelines, payment, and shipping costs and arrangements. We don’t take credit card or payment details at this stage.</p>
					<p>Amounts in Australian Dollars. GST is only charged to orders placed within Australia.</p>
				</div>
				
				<h2 class="form-heading"><span>Your Details</span></h2>
				
				<?php 
					// Form for public orders.
					gravity_form( 'Public Order', false, false, false, null, false ); 
				?>
			</div><!-- .copy-narrow -->
			
		
		<?php endif; ?>
	</div>

</div><!-- .c -->


<div>
	<input id="cart-basecloths" type="hidden" data-basecloths='<?php echo basecloths_json(); ?>' value=""/>
</div>
	
	
<?php endwhile; else: endif; ?>


<?php get_footer();