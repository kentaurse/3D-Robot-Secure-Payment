<?php
global $dp_options, $dp_default_options, $sidebar_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Sets the color of the cart button displayed at the top right corner of the site.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Background color of header cart button', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the background color of header cart button.', 'tcd-w' ); ?></p>

	<input class="c-color-picker" name="dp_options[header_welcart_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['header_welcart_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_welcart_bg_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Background color of header cart section on hover', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the hover color of header cart button.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_welcart_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['header_welcart_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_welcart_bg_color_hover'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>

<p><?php _e( 'Set up product page. Please add products before doing the following settings. If the product is 0 case You can not check the display of the product page, so after adding more than one item please make the following settings.', 'tcd-w' ); ?></p>
<div class="theme_option_message"><?php echo __( '<p>Click the "Welcart Shop"> "<a href="admin.php?page=usces_itemnew" target="_blank">Add New</a>" button on the side menu and add a new item.</p><p>Items added can be checked and edited in the side menu "Welcart Shop" > "<a href="admin.php?page=usces_itemedit" target="_blank">Product Master</a>".</p><p>cf: Welcart manual "GET STARTED" - STEP 5 // product registration<br><a href="https://www.welcart.com/wc-flow/" target="_blank">https://www.welcart.com/wc-flow/</a></p>', 'tcd-w' ); ?></div>

<?php // サイドバーの設定 ?>
<div id="theme_option-welcart-sidebar" class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e( 'Setting the sidebar of item page', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Set the position of the sidebar of the item archive page and item single page.', 'tcd-w' ); ?></p>
	<fieldset class="cf radio_images">
		<?php foreach ( $sidebar_options as $option ) : ?>
		<label>
			<input type="radio" name="dp_options[sidebar_welcart]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['sidebar_welcart'] ); ?>>
			<?php echo $option['label']; ?>
			<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
		</label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 商品ページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Item title / contents setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item title', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page title.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_title_font_size]" value="<?php echo esc_attr( $dp_options['item_title_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item title for mobile', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page title for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_title_font_size_mobile]" value="<?php echo esc_attr( $dp_options['item_title_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Post title color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font color of the item single page title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[item_title_color]" type="text" value="<?php echo esc_attr( $dp_options['item_title_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['item_title_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item contents', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page contents.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_content_font_size]" value="<?php echo esc_attr( $dp_options['item_content_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item contents for mobile', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page contents for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_content_font_size_mobile]" value="<?php echo esc_attr( $dp_options['item_content_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Item contents color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font color of the item single page contents.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[item_content_color]" type="text" value="<?php echo esc_attr( $dp_options['item_content_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['item_content_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item price', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page price.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_price_font_size]" value="<?php echo esc_attr( $dp_options['item_price_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of item price for mobile', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the item single page price for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[item_price_font_size_mobile]" value="<?php echo esc_attr( $dp_options['item_price_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Item Price color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font color of the item single page price.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[item_price_color]" type="text" value="<?php echo esc_attr( $dp_options['item_price_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['item_price_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for archive page', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
	<ul>
		<li><label><input name="dp_options[show_date_item]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_date_item'] ); ?>> <?php _e( 'Display date', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_category_item]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_category_item'] ); ?>> <?php _e( 'Display category', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for single page', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please check if you want to display the comment.', 'tcd-w' ); ?></p>
	<ul>
		<li><label><input name="dp_options[show_comment_item]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_comment_item'] ); ?>> <?php _e( 'Display comment', 'tcd-w' ); ?></label></li>
	</ul>
    <p><?php _e( 'Please check if you want to display the discount rate.', 'tcd-w' ); ?></p>
	<ul>
		<li><label><input name="dp_options[show_discount_rate]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_discount_rate'] ); ?>> <?php _e( 'Display discount rate', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 関連商品の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Related item setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Related item will be displayed at the bottom of item page.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<p>In order to display related items, please enter the item code of the item you want to display on "Tag" on the item management screen.</p><p>cf: <a href="https://www.welcart.com/documents/manual-welcart/manual-2/welcart-shop/%E6%96%B0%E8%A6%8F%E5%95%86%E5%93%81%E8%BF%BD%E5%8A%A0/%E3%82%BF%E3%82%B0" target="_blank">Welcart manual "Tag"</a></p>', 'tcd-w' ); ?></div>
	<p><label><input name="dp_options[show_related_item]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_related_item'] ); ?>> <?php _e( 'Display related item', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Headline for related item', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set heading of Related items.', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[related_item_headline]" value="<?php echo esc_attr( $dp_options['related_item_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Number of item', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the number of posts of Related items.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[related_item_num]" value="<?php echo esc_attr( $dp_options['related_item_num'] ); ?>" min="1">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // レコメンド商品の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Recommend item setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Recommend item will be displayed at the bottom of item page.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<p>In the Recommendation Product List, "Items purchased together in the past year" are displayed.</p><p>ex. The recommended item list of the item A displays the item "purchased together with the item A in the past year"</p>', 'tcd-w' ); ?></div>
	<p><label><input name="dp_options[show_recommend_item]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_recommend_item'] ); ?>> <?php _e( 'Display recommend item list', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Headline for recommend item', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set heading of recommend items.', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[recommend_item_headline]" value="<?php echo esc_attr( $dp_options['recommend_item_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Number of item', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the number of posts of recommend items.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[recommend_item_num]" value="<?php echo esc_attr( $dp_options['recommend_item_num'] ); ?>" min="1">
</div>
