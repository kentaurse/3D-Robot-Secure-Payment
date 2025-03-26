<?php
global $dp_options, $usces;

if ( ! $dp_options ) $dp_options = get_design_plus_option();
$active_sidebar = get_active_sidebar();

get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/page-header' );
get_template_part( 'template-parts/breadcrumb' );

if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
		<div class="l-primary">
<?php
else :
?>
	<div class="l-inner l-primary">
<?php
endif;

if ( have_posts() ) :
	the_post();
	usces_remove_filter();

	// DLSeller判別用変数
	$shipped = true;
	$dlseller_content = false;
	if ( defined( 'WCEX_DLSELLER' ) ) :
		$shipped = dlseller_have_shipped();
		$dlseller_content = dlseller_have_dlseller_content();
	endif;
?>
			<div class="p-entry p-wc p-wc-cart-page p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-cart_navi">
						<ul>
							<li><span><?php _e( '1.Cart', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '2.Customer Info', 'tcd-w' ); ?></span></li>
							<li class="is-current"><span><?php _e( '3.Deli. & Pay.', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '4.Confirm', 'tcd-w' ); ?></span></li>
						</ul>
					</div>
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_delivery_page_header' ); ?></div>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
					<form action="<?php usces_url( 'cart' ); ?>" method="post">
<?php
	if ( $shipped ) :
?>
						<table class="p-wc-customer_form p-wc-customer_form--shipping">
							<tr>
								<th rowspan="2" scope="row"><?php _e( 'shipping address', 'tcd-w' ); ?></th>
								<td><input name="delivery[delivery_flag]" type="radio" id="delivery_flag1" onclick="document.getElementById( 'delivery_table' ).style.display = 'none';" value="0"<?php if ( $usces_entries['delivery']['delivery_flag'] == 0 ) echo ' checked'; ?> onKeyDown="if (event.keyCode == 13) {return false;}"> <label for="delivery_flag1"><?php _e( 'same as customer information', 'tcd-w' ); ?></label></td>
							</tr>
							<tr>
								<td><input name="delivery[delivery_flag]" id="delivery_flag2" onclick="document.getElementById( 'delivery_table' ).style.display = 'table'" type="radio" value="1"<?php if ( $usces_entries['delivery']['delivery_flag'] == 1 ) echo ' checked'; ?> onKeyDown="if (event.keyCode == 13) {return false;}"> <label for="delivery_flag2"><?php _e( 'Chose another shipping address.', 'tcd-w' ); ?></label></td>
							</tr>
						</table>
						<?php do_action( 'usces_action_delivery_flag' ); ?>

						<table id="delivery_table" class="p-wc-customer_form p-wc-customer_form--delivery_table">
<?php
		echo uesces_addressform( 'delivery', $usces_entries );
?>
						</table>
<?php
	endif;
?>
						<table class="p-wc-customer_form p-wc-customer_form--time">
<?php
	if ( $shipped ) :
?>
							<tr>
								<th scope="row"><?php _e( 'shipping option', 'tcd-w' ); ?></th>
								<td colspan="2"><?php usces_the_delivery_method( $usces_entries['order']['delivery_method'] ); ?></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Delivery date', 'tcd-w' ); ?></th>
								<td colspan="2"><?php usces_the_delivery_date( $usces_entries['order']['delivery_date'] ); ?></td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Delivery Time', 'tcd-w' ); ?></th>
								<td colspan="2"><?php usces_the_delivery_time( $usces_entries['order']['delivery_time'] ); ?></td>
							</tr>
<?php
	endif;
?>
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'payment method', 'tcd-w' ); ?></th>
								<td colspan="2" class="payment_method"><?php usces_the_payment_method( $usces_entries['order']['payment_name'] ); ?></td>
							</tr>
						</table>
<?php
	usces_delivery_secure_form();

	$meta = usces_has_custom_field_meta( 'order' );
	if ( ! empty( $meta ) and is_array( $meta ) ) :
?>
						<table class="p-wc-customer_form p-wc-customer_form--custom_order">
<?php
	usces_custom_field_input( $usces_entries, 'order', '' );
?>
						</table>
<?php
	endif;

	if( $dlseller_content ) :
?>
						<table class="p-wc-customer_form p-wc-customer_form--dlseller">
							<tr>
								<th scope="row"><em><?php _e( '*', 'tcd-w' ); ?></em><?php _e( 'Terms of Use', 'dlseller' ); ?></th>
								<td>
									<div class="p-wc-customer_form--dlseller_terms"><?php dlseller_terms(); ?></div>
									<div class="p-wc-customer_form--dlseller_terms-checkbox">
										<label for="terms"><input type="checkbox" name="offer[terms]" id="terms"><?php _e( 'Agree', 'dlseller' ); ?></label>
									</div>
								</td>
							</tr>
						</table>
<?php
	endif;

	$entry_order_note = empty( $usces_entries['order']['note'] ) ? apply_filters( 'usces_filter_default_order_note', NULL ) : $usces_entries['order']['note'];
?>
						<table class="p-wc-customer_form p-wc-customer_form--notes_table">
							<tr>
								<th scope="row"><?php _e( 'Notes', 'tcd-w' ); ?></th>
								<td colspan="2"><textarea name="offer[note]" id="note" class="notes"><?php echo esc_html( $entry_order_note ); ?></textarea></td>
							</tr>
						</table>
						<div class="send">
							<input name="offer[cus_id]" type="hidden" value="">
							<input name="backCustomer" type="submit" class="back_to_customer_button p-button-back p-button--white p-button--lg" value="<?php _e( '&lt; Back', 'tcd-w' ); ?>"<?php echo apply_filters( 'usces_filter_deliveryinfo_prebutton', NULL ); ?>>
							<input name="confirm" type="submit" class="to_confirm_button p-button p-button--lg" value="<?php _e( ' Next ', 'tcd-w' ); ?>"<?php echo apply_filters( 'usces_filter_deliveryinfo_nextbutton', NULL ); ?>>
						</div>
						<?php do_action( 'usces_action_delivery_page_inform' ); ?>
					</form>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_delivery_page_footer' ); ?></div>
				</div>
			</div>
<?php
else:
?>
			<p><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
<?php
endif;

if ( $active_sidebar ) :
?>
		</div>
<?php
	get_sidebar();
?>
	</div>
<?php
else :
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
