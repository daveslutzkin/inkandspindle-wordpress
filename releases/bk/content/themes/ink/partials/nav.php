<?php
function home_nav(){
	?>
	<div class="secondary-navigation">
		<ul>
			<li><a class="js-scroll" href="#collection"><span>Inspiration</span></a></li>
			<li><a class="js-scroll" href="#sustainability"><span>Sustainability</span></a></li>
			<li><a class="js-scroll" href="#designers"><span>About Us</span></a></li>
			<li><a class="js-scroll" href="#process"><span>Process</span></a></li>
			<li><a class="js-scroll" href="#internships"><span>Interns</span></a></li>
			<li><a class="js-scroll" href="#stockists"><span>Stockists</span></a></li>
			<li><a class="js-scroll" href="#contact"><span>Contact</span></a></li>
			<?php cart_icon_menu() ?>
		</ul>
	</div>
	<?php
}


function window_furnishings_nav(){
        ?>
        <div class="secondary-navigation">
                <ul>
                        <li><a class="js-scroll" href="#roman-blinds"><span>Roman Blinds</span></a></li>
                        <li><a class="js-scroll" href="#curtains"><span>Curtains</span></a></li>
                        <li><a class="js-scroll" href="#roller-blinds"><span>Roller Blinds</span></a></li>
                        <li><a class="js-scroll" href="#how-to-order"><span>Measuring</span></a></li>
                        <li><a class="js-scroll" href="#installation"><span>Installation</span></a></li>
                        <li><a class="js-scroll" href="#specialists"><span>Specialists</span></a></li>
						<?php cart_icon_menu() ?>
                </ul>
        </div>
        <?php
}


function cart_icon_svg() {
?>
<svg class="svg-icon icon-shopping-basket " xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path d="M3 5.2L5.33333 2H14.6667L17 5.2V16.4C17 16.8243 16.8361 17.2313 16.5444 17.5314C16.2527 17.8314 15.857 18 15.4444 18H4.55556C4.143 18 3.74733 17.8314 3.45561 17.5314C3.16389 17.2313 3 16.8243 3 16.4V5.2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
    <path d="M3 5.20001H17" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
    <path d="M13.1111 8.40002C13.1111 9.24872 12.7834 10.0626 12.1999 10.6628C11.6165 11.2629 10.8251 11.6 10 11.6C9.17491 11.6 8.38359 11.2629 7.80014 10.6628C7.21669 10.0626 6.88892 9.24872 6.88892 8.40002" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
  </svg>
<?php
}

function cart_icon_menu() {
?>
          <li class="has-submenu">
            <a class="is-top-level has-submenu is-tight-spacing" href="/order/">
              <span>
                <?php cart_icon_svg() ?>
                <span class="cart-label"> Cart</span></span
              >
            </a>
            <button data-submenu-toggle type="button" aria-expanded="false">+</button>
            <ul class="hang-left" data-submenu hidden>
              <li>
                <a href="https://shop.inkandspindle.com/cart">
                  <span><?php cart_icon_svg() ?> Cart (Shop) </span>
                </a>
              </li>
              <li>
                <a href="/order/">
                  <span><?php cart_icon_svg() ?> Cart (Custom Textiles) </span>
                </a>
              </li>
            </ul>
          </li>
<?php
}

function textiles_nav(){
	?>
	<div class="secondary-navigation">
		<ul>
			<li <?php if ( is_post_type_archive( array( 'patterns' ) ) || is_singular('patterns') ){ echo 'class="current"'; }?> ><a href="/customise/#customise"><span>Customise Our Textiles</span></a></li>
			<?php //if ( $pattern_terms = get_terms( array( 'patterns_type' ), array( 'orderby' => 'menu' ) ) ): ?>
				<?php /*
				<?php foreach ( $pattern_terms as $term ): ?>
					<li <?php if ( is_tax('patterns_type', $term->term_id) ){ echo 'class="current"'; } ?>><a href="<?php echo get_term_link($term); ?>"><span><?php echo $term->name; ?></span></a></li>
				<?php endforeach; ?>
				*/ ?>
				<?php
				global $post;
				if ( $pattern_indexes = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-patternindex.php', 'sort_column' => 'menu_order', 'sort_order' => 'ASC' ) ) ):
					foreach ( $pattern_indexes as $index ): ?>
						<li <?php if ( $post->ID == $index->ID  ){ echo 'class="current"'; } ?>><a href="<?php echo get_permalink($index->ID); ?>"><span><?php echo $index->post_title; ?></span></a></li>
						<?php
					endforeach;
				endif;
				?>
			<?php //endif; ?>
			<li><a href="https://shop.inkandspindle.com/collections/fabrics"><span>Ready-made Collection</span></a></li>
			
			<li <?php if ( is_page( 'basecloths' ) ){ echo 'class="current"'; }?> ><a href="/basecloths"><span>Our Basecloths</span></a></li>
			
			<?php cart_icon_menu() ?>
		</ul>
	</div>
	<?php
}

function inspiration_subnav(){
	$filters = '';

	$field_key = INSPIRATION_FIELD_ID;
	$field = get_field_object($field_key);


	if( isset( $field['sub_fields'][2]['choices'] ) ){
		$choices = $field['sub_fields'][2]['choices'];


		foreach( $choices as $key => $value ){
			$filters .= '<li><a href="#" data-filter=".type-' . trim( strtolower( $key ) ) .'"><span>' . $value . '</span></a></li>';
		}
	}
	?>

	<div class="secondary-navigation" id="filters">
		<ul>
			<li class="current"><a href="#" data-filter="*"><span>All</span></a></li>
			<?php echo $filters; ?>
			<?php cart_icon_menu() ?>
		</ul>
	</div>
	<?php
}
?>


<div class="primary-navigation">
	<ul>
		<li <?php if ( is_front_page() ){ echo 'class="current"'; } ?>><a href="/main/"><span>About</span></a></li>
		<li <?php if ( is_textiles() ){ echo 'class="current"'; } ?>><a href="<?php echo customise_url(); ?>"><span>Textiles</span></a></li>
		<li><a href="<?php echo shop_url(); ?>"><span>Shop</span></a></li>
		<li <?php if ( is_page( 'curtains-blinds' ) ){ echo 'class="current"'; }?> >
			<a href="/curtains-blinds"><span>Window Furnishings</span></a>
		</li>
		<li <?php if ( is_page( 'environment' ) ){ echo 'class="current"'; }?> >
			<a href="/sustainable-fabrics"><span>Environment</span></a>
		</li>
		<li <?php if ( is_page( 'trade' ) ){ echo 'class="current"'; }?> ><a href="/trade"><span>Trade Portal</span></a></li>
		<li <?php if ( is_page( 'inspiration' ) ){ echo 'class="current"'; }?> ><a href="/inspiration"><span>Gallery</span></a></li>
		<li <?php if ( is_page( 'faq' ) ){ echo 'class="current"'; }?> ><a href="/faq"><span>FAQ</span></a></li>
	</ul>
</div>
<?php
if ( is_front_page() ){
	home_nav();
} elseif (is_page('curtains-blinds')) {
	window_furnishings_nav();
} elseif ( is_textiles() ){
	textiles_nav();
} elseif ( is_page( 'inspiration' ) ){
	inspiration_subnav();
}
