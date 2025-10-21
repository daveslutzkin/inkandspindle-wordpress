<?php
	global $current_user;
	wp_get_current_user();
?>

<div class="accountdetails">
	<h2>
		<span>Account Details</span>
		<a class="update-account" href="<?php echo get_edit_user_link(); ?>">Update</a>
	</h2>
	<div class="accountdetails-box">
		<h3>Trading details</h3>
		<p>
			<?php echo $current_user->tradingname . '<br />' . 'ABN ' . $current_user->abn; ?>
		</p>
		<h3>Street Address</h3>
		<p>
			<?php
			if ( $current_user->address_line1 ){
				echo $current_user->address_line1 . '<br />';
			}

			if ( $current_user->address_line2 ){
				echo $current_user->address_line2 . '<br />';
			}

			if ( $current_user->city ){
				echo $current_user->city . '<br />';
			}

			if ( $current_user->state && $current_user->postcode ){
				echo $current_user->state . ', ' . $current_user->postcode . '<br />';
			}

			echo $current_user->country;
			?>
		</p>
		<h3>Contact</h3>
		<p>
			<?php
			if ( $current_user->user_firstname || $current_user->user_lastname ){
				echo $current_user->user_firstname . ' ' . $current_user->user_lastname . '<br />';
			}

			if ( $current_user->phone ){
				echo $current_user->phone . '<br />';
			}

			if ( $current_user->user_email ){
				echo '<a href="mailto:'.$current_user->user_email.'">' . $current_user->user_email . '</a>' . '<br />';
			}

			if ( $current_user->user_firstname ){
				echo '<a href="'.$current_user->user_url.'">' . $current_user->user_url . '</a>';
			}
			?>
		</p>
	</div><!--  -->
</div><!-- accountdetails -->
