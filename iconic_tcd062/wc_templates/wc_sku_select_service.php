<?php
/**
 * Template for WCEX SKU Select 1.1 and WCEX DLSeller3.0
 */

global $dp_options, $usces, $usces_item;

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
<?php
endif;
?>
		<article class="p-entry p-entry-item <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<h1 class="p-entry__title p-entry-item__title"><?php
				the_title();
				if ( ! usces_have_zaiko_anyone() ) :
					echo '<span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
				endif;
			?></h1>
<?php
if ( post_password_required() ) :
?>
			<div class="p-entry__body p-entry-item__body">
<?php
	the_content();
?>
			</div>
<?php
else :
	usces_remove_filter();
	usces_the_item();
	usces_have_skus();

	$images = array();
	if ( usces_the_itemImageURL( 0, 'return' ) ) :
		$images[0] = usces_the_itemImage( 0, 740, 540, $post, 'return' );
		$imageids = usces_get_itemSubImageNums();
		if ( $imageids ) :
			foreach ( $imageids as $imageid ) :
				$images[] = usces_the_itemImage( $imageid, 740, 540, $post, 'return' );
			endforeach;
		endif;
	elseif ( has_post_thumbnail() ) :
		$images[0] = get_the_post_thumbnail( null, 'size4' );
	endif;

	if ( $images ) :
?>
			<div class="p-entry-item__images" id="js-entry-item__images">
				<div class="p-entry-item__mainimage"><?php echo $images[0]; ?></div>
				<div class="p-entry-item__subimages">
<?php
		foreach ( $images as $key => $image ) :
?>
					<div class="p-entry-item__subimage<?php if ( 0 === $key ) echo ' is-active'; ?>"><?php echo $image; ?></div>
<?php
			if ( $key >= 4 ) break;
		endforeach;
?>
				</div>
			</div>
<?php
	endif;
?>
			<div class="p-entry-item__body-cart">
				<div class="p-entry__body p-entry-item__body">
<?php
	the_content();

	$dlseller_table = '';

	if ( 'continue' == dlseller_get_charging_type( $post->ID ) ) :
		$dlseller_table .= '<tr><th>' . __( 'First Withdrawal Date', 'dlseller' ) . '</th><td>' . date( 'Y/m/d', strtotime( dlseller_first_charging( $post->ID ) ) ) . '</td></tr>';

		if ( 0 < (int) $usces_item['dlseller_interval'] ) :
			$dlseller_table .= '<tr><th>' . __( 'Contract Period', 'dlseller' ) . '</th><td>' . esc_attr( $usces_item['dlseller_interval'] ) . __( 'Month(Automatic Renewal)', 'dlseller' ) . '</td></tr>';
		endif;
	endif;

	if ( $dlseller_table ) :
		echo "\t\t\t\t\t\t" . '<table class="p-entry-item__dlseller">' . $dlseller_table . '</table>' . "\n";
	endif;

	if ( $item_custom = usces_get_item_custom( $post->ID, 'list', 'return' ) ) :
		echo $item_custom;
	endif;
?>
				</div>
				<div class="p-entry-item__carts p-entry-item__body">
					<form action="<?php echo USCES_CART_URL; ?>" method="post">
						<div id="skuform" class="p-entry-item__cart">
							<div class="wcss_loading"></div>
<?php
		if ( usces_the_itemCprice( 'return' ) > 0 ) :
?>
							<p class="p-entry-item__cart-cprice"><?php _e( 'List price', 'tcd-w' ); ?>&nbsp;&nbsp;<?php if ( 'continue' == dlseller_get_charging_type( $post->ID ) ) : ?><span class="p-entry-item__cart-price-frequency"><?php dlseller_frequency_name( $post->ID, 'amount' ); ?></span>&nbsp;&nbsp;<?php endif; ?><span class="p-entry-item__cprice ss_cprice"><?php usces_the_itemCpriceCr(); ?></span><?php usces_guid_tax(); ?></p>
<?php
		endif;
?>
							<p class="p-entry-item__cart-price"><?php _e( 'Selling price', 'tcd-w' ); ?>&nbsp;&nbsp;<?php if ( 'continue' == dlseller_get_charging_type( $post->ID ) ) : ?><span class="p-entry-item__cart-price-frequency"><?php dlseller_frequency_name( $post->ID, 'amount' ); ?></span>&nbsp;&nbsp;<?php endif; ?><span class="p-entry-item__price p-price ss_price"><?php usces_the_itemPriceCr(); ?></span><?php usces_guid_tax(); ?></p>
<?php
		usces_the_itemGpExp();
?>
							<div class="p-entry-item__cart-item-sku">
<?php
		wcex_sku_select_form();
?>
							</div>
<?php
		if ( usces_is_options() ) :
			while ( usces_have_options() ) :
?>
								<p class="p-entry-item__cart-option"><?php usces_the_itemOptName(); ?>&nbsp;&nbsp;<?php usces_the_itemOption( usces_getItemOptName(),'' ); ?></p>
<?php
			endwhile;
		endif;
?>
							<p class="p-entry-item__cart-button c-box"><?php usces_the_itemSkuButton( __( 'Add to Cart', 'tcd-w' ), 0 ); ?></p>
							<p class="p-entry-item__cart-soldout itemsoldout"><?php _e( 'SOLD OUT', 'tcd-w' ); ?></p>
							<p class="p-entry-item__cart-error_message p-wc-error_message"><?php usces_singleitem_error_message( $post->ID, usces_the_itemSku( 'return' ) ); ?></p>
<?php
		if ( usces_sku_num() === 1 ) :
			echo apply_filters( 'single_item_single_sku_after_field', NULL );
		elseif ( usces_sku_num() > 1 ) :
			echo apply_filters( 'single_item_multi_sku_after_field', NULL );
		endif;
?>
						</div>
<?php
	do_action( 'usces_action_single_item_inform' );
?>
					</form>
				</div>
			</div>
<?php
	do_action( 'usces_action_single_item_outform' );

	$tab_count = 0;
	$tab_radios = '';
	for ( $i = 1; $i <= 5; $i++ ) :
		if ( empty( $post->{'show_tab' . $i} ) ) continue;
		$tab_count++;
		$tab_radios .= '<input type="radio" id="item-tab--' . esc_attr( $i ) . '" name="item-tab" class="tab-radio tab-radio--' . esc_attr( $i ) . '"' . checked( $tab_radios, '', false ) . '>';
	endfor;
	if ( $tab_count ) :
		echo "\t\t\t";
		echo '<div class="p-entry-item__tabs-container">' . "\n";

		echo $tab_radios . "\n";

		echo "\t\t\t\t";
		echo '<ul class="p-entry-item__tabs p-entry-item__body">' . "\n";
		for ( $i = 1; $i <= 5; $i++ ) :
			if ( empty( $post->{'show_tab' . $i} ) ) continue;

			echo "\t\t\t\t\t";
			echo '<li class="tab-label--' . esc_attr( $i ) . '"><label for="item-tab--' . esc_attr( $i ) . '">' . esc_html( $post->{'tab_label' . $i} ) . '</label></li>'."\n";
		endfor;
		echo "\t\t\t\t";
		echo '</ul>'."\n";

		for ( $i = 1; $i <= 5; $i++ ) :
			if ( empty( $post->{'show_tab' . $i} ) ) continue;

			echo "\t\t\t\t";
			echo '<div class="p-entry-item__tab-content p-entry-item__tab-content--' . esc_attr( $i ) . ' p-entry__body p-entry-item__body">' . "\n";

			if ( $post->{'tab_content' . $i} ) :
				echo apply_filters( 'the_content', $post->{'tab_content' . $i} );
			endif;

			$tab_spec = $post->{'tab_spec' . $i};
			if ( ! empty( $tab_spec['headline'] ) && is_array( $tab_spec['headline'] ) ) :
				$_spec_table = '';

				foreach( array_keys( $tab_spec['headline'] ) as $repeater_index ) :
					if ( isset( $tab_spec['headline'][$repeater_index] ) ) :
						$row_headline = $tab_spec['headline'][$repeater_index];
					else :
						$row_headline = '';
					endif;
					if ( isset( $tab_spec['desc'][$repeater_index] ) ) :
						$row_desc = $tab_spec['desc'][$repeater_index];
						// URL自動リンク
						if ( strpos( $row_desc, 'http' ) !== false ) :
							$pattern = '/(=[\"\'])?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
							$row_desc = preg_replace_callback( $pattern, function( $matches ) {
								// 既にリンク等の場合はそのまま
								if ( isset( $matches[1] ) ) return $matches[0];
								return "<a href=\"{$matches[0]}\" target=\"_blank\">{$matches[0]}</a>";
							}, $row_desc );
						endif;
					else :
						$row_desc = '';
					endif;
					if ( $row_headline && $row_desc ) :
						$_spec_table .= '<tr><th>' . wpautop( $row_headline ) . '</th><td>' . wpautop( $row_desc ) . '</td></tr>';
					elseif ( $row_headline ) :
						$_spec_table .= '<tr><th colspan="2">' . wpautop( $row_headline ) . '</th></tr>';
					elseif ( $row_desc ) :
						$_spec_table .= '<tr><td colspan="2">' . wpautop( $row_desc ) . '</td></tr>';
					endif;
				endforeach;

				if ( $_spec_table ) :
					echo "\t\t\t\t\t";
					echo '<table class="p-entry-item__spec-table">' . $_spec_table . '</table>' . "\n";
				endif;
			endif;

			echo "\t\t\t\t";
			echo '</div>' . "\n";
		endfor;

		echo "\t\t\t";
		echo '</div>' . "\n";
	endif;

	get_template_part( 'template-parts/related-recommend-item' );

	usces_reset_filter();

	if ( $dp_options['show_comment_item'] ) :
		comments_template( '', true );
	endif;

endif;
?>
		</article>
<?php
if ( $active_sidebar ) :
	get_sidebar();
?>
	</div>
<?php
endif;
?>
</main>
<?php
get_footer();
