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
?>
			<div class="p-entry p-wc p-wc-cart-page p-wc-<?php usces_page_name(); ?>">
				<div class="p-entry__body p-wc__body">
					<div class="p-wc-cart_navi">
						<ul>
							<li class="is-current"><span><?php _e( '1.Cart', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '2.Customer Info', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '3.Deli. & Pay.', 'tcd-w' ); ?></span></li>
							<li><span><?php _e( '4.Confirm', 'tcd-w' ); ?></span></li>
						</ul>
					</div>
					<div class="p-wc-header_explanation"><?php do_action( 'usces_action_cart_page_header' ); ?></div>
					<div class="p-wc-error_message"><?php usces_error_message(); ?></div>
					<form action="<?php usces_url( 'cart' ); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
<?php
	if ( usces_is_cart() ) :
?>
						<div class="p-wc-upbutton"><?php _e( 'Press the `update` button when you change the amount of items.', 'tcd-w' ); ?><input name="upButton" type="submit" class="p-button" value="<?php _e( 'Quantity renewal', 'tcd-w' ); ?>" onclick="return uscesCart.upCart()"></div>
						<table class="p-wc-cart_table">
							<thead>
								<tr>
									<th scope="row" class="num">No.</th>
									<th class="thumbnail"> </th>
									<th><?php _e( 'item name', 'tcd-w' ); ?></th>
									<th class="quantity"><?php _e( 'Unit price', 'tcd-w' ); ?></th>
									<th class="quantity"><?php _e( 'Quantity', 'tcd-w' ); ?></th>
									<th class="subtotal"><?php _e( 'Amount', 'tcd-w' ); ?><?php usces_guid_tax(); ?></th>
									<th class="stock"><?php _e( 'Stock status', 'tcd-w' ); ?></th>
									<th class="action"></th>
								</tr>
							</thead>
							<tbody>
<?php
		usces_get_cart_rows();
?>
							</tbody>
							<tfoot>
							<tr>
								<th colspan="5" scope="row" class="aright"><?php _e( 'total items', 'tcd-w' ); ?><?php usces_guid_tax(); ?></th>
								<th class="aright"><?php usces_crform( usces_total_price( 'return' ), true, false ); ?></th>
								<th colspan="2"></th>
							</tr>
							</tfoot>
						</table>
<?php
		if ( $usces_gp ) :
?>
						<p class="gp"><img src="<?php echo USCES_PLUGIN_URL; ?>/images/gp.gif" alt="<?php _e( 'Business package discount', 'tcd-w' ); ?>"> <?php _e( 'The price with this mark applys to Business pack discount.', 'tcd-w' ); ?></p>
<?php
		endif;
	else :
?>
						<p class="p-wc-empty_cart"><?php _e( 'There are no items in your cart.', 'tcd-w' ); ?></p>
<?php
	endif;

	the_content();
?>
						<div class="send"><?php usces_get_cart_button(); ?></div>
						<?php do_action( 'usces_action_cart_page_inform' ); ?>
					</form>
					<div class="p-wc-footer_explanation"><?php do_action( 'usces_action_cart_page_footer' ); ?></div>
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
