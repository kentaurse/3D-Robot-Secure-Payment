<?php
global $dp_options, $usces;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( is_welcart_active() ) :
?>
	<div class="p-header-view-cart" id="js-header-view-cart">
<?php
	if ( usces_is_cart() ) :

		$cart = $usces->cart->get_cart();
		$usces_gp = 0;
		$res = '';

		for ( $i=0; $i < count( $cart ); $i++ ) :
			$cart_row = $cart[$i];
			$post_id = (int) $cart_row['post_id'];
			$sku = $cart_row['sku'];
			$sku_code = urldecode( $cart_row['sku'] );
			$itemCode = $usces->getItemCode( $post_id );
			$itemName = $usces->getItemName( $post_id );
			$pictid = (int) $usces->get_mainpictid( $itemCode );
			$args = compact( 'cart', 'i', 'cart_row', 'post_id', 'sku' );
?>

		<div class="p-header-view-cart__item">
			<div class="p-header-view-cart__item-thumbnail"><a href="<?php echo get_permalink( $post_id ); ?>"><?php
				if ( $pictid ) :
					echo wp_get_attachment_image( $pictid, array( 80, 80 ), true );
				else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
				endif;
			?></a></div>
			<div class="p-header-view-cart__item-info">
				<div class="p-header-view-cart__item-title"><?php echo esc_html( $itemName ); ?></div>
				<div class="p-header-view-cart__item-price"><span class="quantity"><?php echo esc_html( $cart_row['quantity'] ); ?><span class="times">&times;</span><span class="unitprice p-price"><?php usces_crform( $cart_row['price'], true, false, 'echo' ); ?></div>
			</div>
		</div>
<?php
		endfor;
?>
		<div class="p-header-view-cart__buttons">
			<a class="p-button p-button--gray" href="<?php echo esc_attr( USCES_CART_URL ); ?>"><?php _e( 'View cart', 'tcd-w' ); ?></a>
			<a class="p-button" href="<?php echo esc_attr( USCES_CUSTOMER_URL ); ?>"><?php _e( 'Checkout', 'tcd-w' ); ?></a>
		</div>
<?php
	else :
?>
		<p class="p-wc-empty_cart"><?php _e( 'There are no items in your cart.', 'tcd-w' ); ?></p>
<?php
	endif;
?>
	</div>
<?php
endif;
