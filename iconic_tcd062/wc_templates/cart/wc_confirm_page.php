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
							<li><span><?php _e( '3.Deli. & Pay.', 'tcd-w' ); ?></span></li>
							<li class="is-current"><span><?php _e( '4.Confirm', 'tcd-w' ); ?></span></li>
						</ul>
					</div>
					<p class="confiem_notice">
						<?php _e( 'Please do not change product addition and amount of it with the other window with displaying this page.', 'tcd-w' ); ?>
					</p>
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_confirm_page_header' ); ?></div>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>

					<table class="p-wc-cart_table">
						<thead>
							<tr>
								<th scope="row" class="num"><?php _e( 'No.', 'tcd-w' ); ?></th>
								<th class="thumbnail">&nbsp;&nbsp;</th>
								<th><?php _e( 'Items', 'tcd-w' ); ?></th>
								<th class="price"><?php _e( 'Unit price', 'tcd-w' ); ?></th>
								<th class="quantity"><?php _e( 'Quantity', 'tcd-w' ); ?></th>
								<th class="subtotal"><?php _e( 'Amount', 'tcd-w' ); ?><?php usces_guid_tax(); ?></th>
								<th class="action"></th>
							</tr>
						</thead>
						<tbody>
<?php
	usces_get_confirm_rows();
?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="aright"><?php _e( 'total items', 'tcd-w' ); ?></th>
								<th class="aright"><?php usces_crform( $usces_entries['order']['total_items_price'], true, false ); ?></th>
								<th></th>
							</tr>
<?php
	if ( ! empty( $usces_entries['order']['discount'] ) ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php echo apply_filters( 'usces_confirm_discount_label', __( 'Campaign discount', 'tcd-w' ) ); ?></td>
								<td class="aright discount"><?php usces_crform( $usces_entries['order']['discount'], true, false ); ?></td>
								<td></td>
							</tr>
<?php
	endif;
	if ( usces_is_tax_display() && 'products' == usces_get_tax_target() ) :
 ?>
							<tr>
								<td colspan="5" class="aright"><?php usces_tax_label(); ?></td>
								<td class="aright"><?php usces_tax( $usces_entries ); ?></td>
								<td></td>
							</tr>
<?php
	endif;
	if ( usces_is_member_system() && usces_is_member_system_point() && ! empty( $usces_entries['order']['usedpoint'] ) && 0 == usces_point_coverage() ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php _e( 'Used points', 'tcd-w' ); ?></td>
								<td class="aright usedpoint"><?php echo number_format( $usces_entries['order']['usedpoint'] ); ?></td>
								<td></td>
							</tr>
<?php
	endif;
	if ( $shipped ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php _e( 'Shipping', 'tcd-w' ); ?></td>
								<td class="aright"><?php usces_crform( $usces_entries['order']['shipping_charge'], true, false ); ?></td>
								<td></td>
							</tr>
<?php
		if ( ! empty( $usces_entries['order']['cod_fee'] ) ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php echo apply_filters( 'usces_filter_cod_label', __( 'COD fee', 'tcd-w' ) ); ?></td>
								<td class="aright"><?php usces_crform( $usces_entries['order']['cod_fee'], true, false ); ?></td>
								<td></td>
							</tr>
<?php
		endif;
	endif;
	if ( usces_is_tax_display() && 'all' == usces_get_tax_target() ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php usces_tax_label(); ?></td>
								<td class="aright"><?php usces_tax( $usces_entries ); ?></td>
								<td></td>
							</tr>
<?php
	endif;
	if ( usces_is_member_system() && usces_is_member_system_point() && ! empty( $usces_entries['order']['usedpoint'] ) && 1 == usces_point_coverage() ) :
?>
							<tr>
								<td colspan="5" class="aright"><?php _e( 'Used points', 'tcd-w' ); ?></td>
								<td class="aright usedpoint"><?php echo number_format( $usces_entries['order']['usedpoint'] ); ?></td>
								<td></td>
							</tr>
<?php
	endif;
?>
							<tr>
								<th colspan="5" class="aright"><?php _e( 'Total Amount', 'tcd-w' ); ?></th>
								<th class="aright"><?php usces_crform( $usces_entries['order']['total_full_price'], true, false ); ?></th>
								<th></th>
							</tr>
						</tfoot>
					</table>

<?php do_action( 'usces_action_confirm_table_after' ); ?>

<?php
	if ( usces_is_member_system() && usces_is_member_system_point() && usces_is_login() && usces_is_available_point() ) :
?>
					<form action="<?php usces_url( 'cart' ); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
						<table class="p-wc-point_table">
							<tr>
								<th><?php _e( 'The current point', 'tcd-w' ); ?></th>
								<td><span class="point"><?php echo $usces_members['point']; ?></span>pt</td>
							</tr>
							<tr>
								<th><?php _e( 'Points you are using here', 'tcd-w' ); ?></th>
								<td><input name="offer[usedpoint]" class="used_point" type="number" value="<?php echo esc_attr( $usces_entries['order']['usedpoint'] ); ?>" min="0"> pt</td>
							</tr>
						</table>
						<?php do_action( 'usces_action_confirm_page_point_inform' ); ?>
						<div class="send send_use_point"><input name="use_point" type="submit" class="use_point_button p-button" value="<?php _e( 'Use the points', 'tcd-w' ); ?>"></div>
					</form>
<?php
	endif;
?>
	 				<?php do_action( 'usces_action_confirm_after_form' ); ?>

					<h3 class="p-wc-headline"><?php _e( 'Customer Information', 'tcd-w' ); ?></h3>
					<table class="p-wc-confirm_table">
						<tr>
							<th><?php _e( 'E-mail adress', 'tcd-w' ); ?></th>
							<td><?php echo esc_html( $usces_entries['customer']['mailaddress1'] ); ?></td>
						</tr>
<?php
	$confirm_table = uesces_addressform( 'confirm', $usces_entries, 'return' );
	if ( preg_match( '#<tr class="ttl">(.*?)</tr>#', $confirm_table, $matches ) ) :
		$replace = "\n\t\t\t\t\t</table>\n\t\t\t\t\t<h3 class=\"p-wc-headline\">" . strip_tags( $matches[1] ) . "</h3>\n\t\t\t\t\t<table class=\"p-wc-confirm_table\">\n";
		$confirm_table = str_replace( $matches[0], $replace, $confirm_table );
	endif;
	echo $confirm_table;
?>
					</table>
					<h3 class="p-wc-headline"><?php _e( 'Others', 'tcd-w' ); ?></h3>
					<table class="p-wc-confirm_table">
<?php
	if ( $shipped ) :
?>
						<tr>
							<th><?php _e( 'shipping option', 'tcd-w' ); ?></th><td><?php echo esc_html( usces_delivery_method_name( $usces_entries['order']['delivery_method'], 'return' ) ); ?></td>
						</tr>
						<tr>
							<th><?php _e( 'Delivery date', 'tcd-w' ); ?></th><td><?php echo esc_html( $usces_entries['order']['delivery_date'] ); ?></td>
						</tr>
						<tr class="bdc">
							<th><?php _e( 'Delivery Time', 'tcd-w' ); ?></th><td><?php echo esc_html( $usces_entries['order']['delivery_time'] ); ?></td>
						</tr>
<?php
	endif;
?>
						<tr>
							<th><?php _e( 'payment method', 'tcd-w' ); ?></th><td><?php echo esc_html( $usces_entries['order']['payment_name'] . usces_payment_detail( $usces_entries ) ); ?></td>
						</tr>
<?php
	usces_custom_field_info( $usces_entries, 'order', '' );

	if( $dlseller_content ) :
?>
						<tr>
							<th><?php _e( 'Terms of Use', 'dlseller' ); ?></th><td><?php echo ( $usces_entries['order']['terms'] ? __( 'agree', 'dlseller' ) : '' ); ?></td>
						</tr>
<?php
	endif;
?>
						<tr>
							<th><?php _e( 'Notes', 'tcd-w' ); ?></th><td><?php echo nl2br( esc_html( $usces_entries['order']['note'] ) ); ?></td>
						</tr>
					</table>

<?php do_action( 'usces_action_confirm_page_notes' ); ?>

<?php
	echo apply_filters( 'usces_filter_usces_purchase_button', usces_purchase_button( 'return' ) );
?>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_confirm_page_footer' ); ?></div>
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
