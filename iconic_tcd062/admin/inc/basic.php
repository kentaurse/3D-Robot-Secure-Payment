<?php
global $dp_options, $dp_default_options, $font_type_options, $headline_font_type_options, $sidebar_options, $load_icon_options, $load_time_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options, $gmap_marker_type_options, $gmap_custom_marker_type_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // 色の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Color setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set the colors used in your site in common. You can also set other colors for buttons and navigations with each theme option.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Primary color setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'This color is used for pager buttons of archive page, background of heading for related posts at single pages, background of heading for comments and background of heading for sidebar widgets.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[primary_color]" type="text" value="<?php echo esc_attr( $dp_options['primary_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['primary_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Secondary color setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'This color is used for hover of link exept for individual settings.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[secondary_color]" type="text" value="<?php echo esc_attr( $dp_options['secondary_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['secondary_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Link color of post contents', 'tcd-w' ); ?></h4>
    <p><?php _e( 'This color is used for link texts in single pages.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[content_link_color]" type="text" value="<?php echo esc_attr( $dp_options['content_link_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['content_link_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ファビコンの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Favicon setup', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Setting for the favicon displayed at browser address bar or tab.', 'tcd-w' ); ?></p>
	<p><?php _e( 'Favicon file', 'tcd-w' ); ?><?php _e( ' (Recommended size: width:16px, height:16px)', 'tcd-w' ); ?></p>
	<p><?php _e( 'You can use .ico, .png or .gif file, and we recommed you to use .ico file.', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js favicon">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['favicon'] ); ?>" name="dp_options[favicon]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['favicon'] ) { echo wp_get_attachment_image( $dp_options['favicon'], 'medium' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['favicon'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フォントタイプ ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Font type', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the font type of all text except for headline.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $font_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[font_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['font_type'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 大見出しのフォントタイプ ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Font type of headline', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please set the font type of headline.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $headline_font_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[headline_font_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['headline_font_type'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 絵文字の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Emoji setup', 'tcd-w' ); ?></h3>
	<p><?php _e( 'We recommend to checkoff this option if you dont use any Emoji in your post content.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[use_emoji]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_emoji'] ); ?>><?php _e( 'Use emoji', 'tcd-w' ); ?></label></p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // クイックタグの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Quicktags settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'If you don\'t want to use quicktags included in the theme, please uncheck the box below.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[use_quicktags]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_quicktags'] ); ?>><?php _e( 'Use quicktags', 'tcd-w' ); ?></label></p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // サイドバーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Sidebar setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set the position of sidebar.', 'tcd-w' ); ?></p>
	<fieldset class="cf radio_images">
		<?php foreach ( $sidebar_options as $option ) : ?>
		<label>
			<input type="radio" name="dp_options[sidebar]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['sidebar'] ); ?>>
			<?php echo $option['label']; ?>
			<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
		</label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ロード画面の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Loading screen setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set the load screen displayed during page transition.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[use_load_icon]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_load_icon'] ); ?>><?php _e( 'Use load icon.', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Type of loader', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please select load icon from 3 types.', 'tcd-w' ); ?></p>
	<select id="js-load_icon" name="dp_options[load_icon]">
		<?php foreach ( $load_icon_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['load_icon'] ); ?>><?php echo $option['label']; ?></option>
		<?php endforeach; ?>
	</select>
	<h4 class="theme_option_headline2"><?php _e( 'Maximum display time', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the maximum display time of the loading screen.<br />Even if all the content is not loaded, loading screen will disappear automatically after a lapse of time you have set at follwing.', 'tcd-w' ); ?></p>
	<select name="dp_options[load_time]">
		<?php foreach ( $load_time_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['load_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
		<?php endforeach; ?>
	</select>
	<h4 class="theme_option_headline2"><?php _e( 'Primary loader color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set the color of load icon.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[load_color1]" type="text" value="<?php echo esc_attr( $dp_options['load_color1'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['load_color1'] ); ?>">
	<div class="js-load_color2">
		<h4 class="theme_option_headline2"><?php _e( 'Secondary loader color', 'tcd-w' ); ?></h4>
		<input class="c-color-picker" name="dp_options[load_color2]" type="text" value="<?php echo esc_attr( $dp_options['load_color2'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['load_color2'] ); ?>">
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ホバーエフェクトの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Hover effect settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Hover effect type', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can select hover effect from 3 types and set options.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<p>Zoom:The thumbnail image is enlarged with the specified enlargement ratio.</p><p>FSlide:The thumbnail image moves horizontally in the direction specified to the left and right, and the set background color can be seen through.</p><p>Fade:The image is transmitted with the specified transmittance, and the set background color can be seen through.</p>', 'tcd-w' ); ?></div>
	<fieldset class="cf select_type2">
		<?php foreach ( $hover_type_options as $option ) : ?>
		<input type="radio" id="tab-<?php echo $option['value']; ?>" name="dp_options[hover_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['hover_type'] ); ?>><label for="tab-<?php echo $option['value']; ?>" class="description" style="display: inline;"><?php echo $option['label']; ?></label><br>
		<?php endforeach; ?>
		<div class="tab-box">
			<div id="tabView1">
				<h4 class="theme_option_headline2"><?php _e( 'Settings for Zoom effect', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set the rate of magnification.', 'tcd-w' ); ?></p>
				<input id="dp_options[hover1_zoom]" class="small-text" type="number" name="dp_options[hover1_zoom]" value="<?php echo esc_attr( $dp_options['hover1_zoom'] ); ?>" min="0" max="5" step="0.1">
				<p><label><input type="checkbox" name="dp_options[hover1_rotate]" value="1" <?php checked( 1, $dp_options['hover1_rotate'] ); ?>><?php _e( 'Rotate images on hover', 'tcd-w' ); ?></label></p>
				<p><?php _e( 'Please set the opacity. (0 - 1.0, e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[hover1_opacity]" value="<?php echo esc_attr( $dp_options['hover1_opacity'] ); ?>" min="0" max="1" step="0.1">
				<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
				<input class="c-color-picker" name="dp_options[hover1_bgcolor]" type="text" value="<?php echo esc_attr( $dp_options['hover1_bgcolor'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['hover1_bgcolor'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
			<div id="tabView2">
				<h4 class="theme_option_headline2"><?php _e( 'Settings for Slide effect', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set the direction of slide.', 'tcd-w' ); ?></p>
				<fieldset class="cf select_type2">
					<?php foreach ( $hover2_direct_options as $option ) : ?>
					<label class="description" style="display:inline-block;margin-right:15px;"><input type="radio" name="dp_options[hover2_direct]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['hover2_direct'] ); ?>><?php echo $option['label']; ?></label>
					<?php endforeach; ?>
				</fieldset>
				<p><?php _e( 'Please set the opacity. (0 - 1.0, e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[hover2_opacity]" value="<?php echo esc_attr( $dp_options['hover2_opacity'] ); ?>" min="0" max="1" step="0.1">
				<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
				<input class="c-color-picker" name="dp_options[hover2_bgcolor]" type="text" value="<?php echo esc_attr( $dp_options['hover2_bgcolor'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['hover2_bgcolor'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
			<div id="tabView3">
				<h4 class="theme_option_headline2"><?php _e( 'Settings for Fade effect', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set the opacity. (0 - 1.0, e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[hover3_opacity]" value="<?php echo esc_attr( $dp_options['hover3_opacity'] ); ?>" min="0" max="1" step="0.1">
				<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
				<input class="c-color-picker" name="dp_options[hover3_bgcolor]" type="text" value="<?php echo esc_attr( $dp_options['hover3_bgcolor'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['hover3_bgcolor'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</fieldset>
</div>
<?php // Use OGP tag ?>
<div class="theme_option_field cf">
<h3 class="theme_option_headline"><?php _e( 'Facebook OGP setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'OGP is a mechanism for correctly conveying page information.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[use_ogp]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_ogp'] ); ?>><?php _e( 'Use OGP', 'tcd-w' ); ?></label></p>
    <p><?php _e( 'To use Facebook OGP please set your app ID.', 'tcd-w' ); ?></p>
	<p><?php _e( 'Your app ID', 'tcd-w' ); ?> <input class="regular-text" type="text" name="dp_options[fb_app_id]" value="<?php echo esc_attr( $dp_options['fb_app_id'] ); ?>"></p>
	<h4 class="theme_option_headline2"><?php _e( 'OGP image', 'tcd-w' ); ?></h4>
	<p><?php _e( 'This image is displayed for OGP if the page does not have a thumbnail.', 'tcd-w' ); ?></p>
	<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1200, 630 ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['ogp_image'] ); ?>" name="dp_options[ogp_image]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['ogp_image'] ) { echo wp_get_attachment_image( $dp_options['ogp_image'], 'medium' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['ogp_image'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // Use twitter card ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Twitter Cards setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'This theme requires Facebook OGP settings to use Twitter cards.', 'tcd-w' ); ?></p>
	<div class="theme_option_input">
		<p><label><input name="dp_options[use_twitter_card]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_twitter_card'] ); ?>> <?php _e( 'Use Twitter Cards', 'tcd-w' ); ?></label></p>
		<p><?php _e( 'Your Twitter account name (exclude @ mark)', 'tcd-w' ); ?><input class="regular-text" type="text" name="dp_options[twitter_account_name]" value="<?php echo esc_attr( $dp_options['twitter_account_name'] ); ?>"></p>
		<p><a href="http://design-plus1.com/tcd-w/2016/11/twitter-cards.html" target="_blank"><?php _e( 'Information about Twitter Cards.', 'tcd-w' ); ?></a></p>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // SNSボタンの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'SNS button setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please input URL to display the SNS icon and check for RSS button.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'URL setting', 'tcd-w' ); ?></h4>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Your Instagram URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[instagram_url]" value="<?php echo esc_attr( $dp_options['instagram_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Twitter URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[twitter_url]" value="<?php echo esc_attr( $dp_options['twitter_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Pinterest URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[pinterest_url]" value="<?php echo esc_attr( $dp_options['pinterest_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Facebook URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[facebook_url]" value="<?php echo esc_attr( $dp_options['facebook_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Google+ URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[googleplus_url]" value="<?php echo esc_attr( $dp_options['googleplus_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Youtube URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[youtube_url]" value="<?php echo esc_attr( $dp_options['youtube_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Your Contact page URL (You can use contactto:)', 'tcd-w' ); ?></td>
			<td><input id="dp_options[contact_url]" class="large-text" type="text" name="dp_options[contact_url]" value="<?php echo esc_attr( $dp_options['contact_url'] ); ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><label><input name="dp_options[show_rss]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_rss'] ); ?>><?php _e( 'Display RSS button', 'tcd-w' ); ?></label></td>
		</tr>
	</table>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ソーシャルボタンの表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Social button Setup', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set share buttons at top and bottom of single page.', 'tcd-w' ); ?></p>
    <p><?php _e( 'You can select whether to show or hide buttons with the theme options of each post type.', 'tcd-w' ); ?></p>

    <div class="theme_option_message"><?php echo __( '<p>Facebook like button is displayed only when you select Button type 5 (Default button).</p><p>RSS button is not displayed if you select Button type 5 (Default button).</p><p>If you use Button type 5 (Default button) and Button types 1 to 4 together, button design will collapses.</p>', 'tcd-w' ); ?></div>
	<div class="theme_option_input">
		<h4 class="theme_option_headline2"><?php _e( 'Type of button on article top', 'tcd-w' ); ?></h4>
        <p><?php _e( 'Please select the button type to be displayed at the top of the article.', 'tcd-w' ); ?></p>
		<fieldset class="cf radio_images_2col">
		<?php foreach ( $sns_type_top_options as $option ) : ?>
			<label>
				<input type="radio" name="dp_options[sns_type_top]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['sns_type_top'] ); ?>>
				<?php echo $option['label']; ?>
				<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
			</label>
		<?php endforeach; ?>
		</fieldset>
		<h4 class="theme_option_headline2"><?php _e( 'Select the social button to show on article top', 'tcd-w' ); ?></h4>
        <p><?php _e( 'Please check the button to display at the top of the article.', 'tcd-w' ); ?></p>
		<ul>
			<li><label><input name="dp_options[show_twitter_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_twitter_top'] ); ?>><?php _e( 'Display twitter button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_fblike_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_fblike_top'] ); ?>><?php _e( 'Display facebook like button - Button type 5 (Default button) only', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_fbshare_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_fbshare_top'] ); ?>><?php _e( 'Display facebook share button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_hatena_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_hatena_top'] ); ?>><?php _e( 'Display hatena button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_pocket_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_pocket_top'] ); ?>><?php _e( 'Display pocket button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_feedly_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_feedly_top'] ); ?>><?php _e( 'Display feedly button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_rss_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_rss_top'] ); ?>><?php _e( 'Display rss button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_pinterest_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_pinterest_top'] ); ?>><?php _e( 'Display pinterest button', 'tcd-w' ); ?></label></li>
		</ul>
		<h4 class="theme_option_headline2"><?php _e( 'Type of button on article bottom', 'tcd-w' ); ?></h4>
        <p><?php _e( 'Please select the button type to be displayed at the bottom of the article.', 'tcd-w' ); ?></p>
		<fieldset class="cf radio_images_2col">
		<?php foreach ( $sns_type_top_options as $option ) : ?>
			<label>
				<input type="radio" name="dp_options[sns_type_btm]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['sns_type_top'] ); ?>>
				<?php echo $option['label']; ?>
				<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
			</label>
		<?php endforeach; ?>
		</fieldset>
		<h4 class="theme_option_headline2"><?php _e( 'Select the social button to show on article bottom', 'tcd-w' ); ?></h4>
        <p><?php _e( 'Please check the button to display at the bottom of the article.', 'tcd-w' ); ?></p>
		<ul>
			<li><label><input name="dp_options[show_twitter_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_twitter_btm'] ); ?>><?php _e( 'Display twitter button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_fblike_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_fblike_btm'] ); ?>><?php _e( 'Display facebook like button - Button type 5 (Default button) only', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_fbshare_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_fbshare_btm'] ); ?>><?php _e( 'Display facebook share button', 'tcd-w' ); ?></label></li>
					<li><label><input name="dp_options[show_hatena_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_hatena_btm'] ); ?>><?php _e( 'Display hatena button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_pocket_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_pocket_btm'] ); ?>><?php _e( 'Display pocket button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_feedly_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_feedly_btm'] ); ?>><?php _e( 'Display feedly button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_rss_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_rss_btm'] ); ?>><?php _e( 'Display rss button', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_pinterest_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_pinterest_btm'] ); ?>><?php _e( 'Display pinterest button', 'tcd-w' ); ?></label></li>
		</ul>
		<h4 class="theme_option_headline2"><?php _e( 'Setting for the twitter button', 'tcd-w' ); ?></h4>
		<label style="margin-top:20px;"><?php _e( 'Set of twitter account. (ex.designplus)', 'tcd-w' ); ?></label>
		<input style="display:block; margin:.6em 0 1em;" class="regular-text" type="text" name="dp_options[twitter_info]" value="<?php echo esc_attr( $dp_options['twitter_info'] ); ?>">
		<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div>
<?php // Google Map ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Google Maps settings', 'tcd-w' );?></h3>
    <p><?php _e( 'You can set styles of marker in Google maps, and select default marker or custom marker.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'API key', 'tcd-w' ); ?></h4>
	<input type="text" class="regular-text" name="dp_options[gmap_api_key]" value="<?php echo esc_attr( $dp_options['gmap_api_key'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Marker type', 'tcd-w' ); ?></h4>
	<fieldset class="cf radio_images">
	<?php foreach ( $gmap_marker_type_options as $option ) : ?>
		<label id="gmap_marker_type_button_<?php echo esc_attr( $option['value'] ); ?>">
			<input type="radio" name="dp_options[gmap_marker_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['gmap_marker_type'] ); ?>>
			<?php echo esc_html_e( $option['label'] ); ?>
			<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
		</label>
	<?php endforeach; ?>
	</fieldset>
	<div id="gmap_marker_type2_area" style="<?php if ( $dp_options['gmap_marker_type'] == 'type1' ) { echo 'display:none;'; } else { echo 'display:block;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Custom marker type', 'tcd-w' ); ?></h4>
		<?php foreach ( $gmap_custom_marker_type_options as $option ) : ?>
		<p><label id="gmap_custom_marker_type_button_<?php echo esc_attr( $option['value'] ); ?>"><input type="radio" name="dp_options[gmap_custom_marker_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['gmap_custom_marker_type'] ); ?>> <?php echo esc_html_e( $option['label'] ); ?></label></p>
		<?php endforeach; ?>
		<div id="gmap_custom_marker_type1_area" style="<?php if ( $dp_options['gmap_custom_marker_type'] == 'type1') { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Custom marker text', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[gmap_marker_text]" value="<?php echo esc_attr( $dp_options['gmap_marker_text'] ); ?>" class="regular-text">
			<p><label for="gmap_marker_color"><?php _e( 'Font color', 'tcd-w' ); ?></label> <input type="text" class="c-color-picker" name="dp_options[gmap_marker_color]" value="<?php echo esc_attr( $dp_options['gmap_marker_color'] ); ?>" id="gmap_marker_color" data-default-color="<?php echo esc_attr( $dp_default_options['gmap_marker_color'] ); ?>"></p>
		</div>
		<div id="gmap_custom_marker_type2_area" style="<?php if ( $dp_options['gmap_custom_marker_type'] == 'type1') { echo 'display:none;'; } else { echo 'display:block;'; } ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Custom marker image', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Recommended size: width:60px, height:20px', 'tcd-w' ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js gmap_marker_img">
					<input type="hidden" value="<?php echo esc_attr( $dp_options['gmap_marker_img'] ); ?>" id="gmap_marker_img" name="dp_options[gmap_marker_img]" class="cf_media_id">
					<div class="preview_field"><?php if ( $dp_options['gmap_marker_img'] ) { echo wp_get_attachment_image($dp_options['gmap_marker_img'], 'medium' ); } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['gmap_marker_img'] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Marker style', 'tcd-w' ); ?></h4>
	<p><label for=""> <?php _e( 'Background color', 'tcd-w' ); ?></label> <input type="text" class="c-color-picker" name="dp_options[gmap_marker_bg]" data-default-color="<?php echo esc_attr( $dp_default_options['gmap_marker_bg'] ); ?>" value="<?php echo esc_attr( $dp_options['gmap_marker_bg'] ); ?>"></p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // カスタムCSS ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Free input area for user definition CSS.', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Code example:<br /><strong>.example { font-size:12px; }</strong>', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="10" name="dp_options[css_code]"><?php echo esc_textarea( $dp_options['css_code'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // Custom head/script ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Free input area for user definition scripts.', 'tcd-w' ); ?></h3>
	<p><?php esc_html_e( 'Custom Script will output the end of the <head> tag. Please insert scripts (i.e. Google Analytics script), including <script>tag.', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="10" name="dp_options[custom_head]"><?php echo esc_textarea( $dp_options['custom_head'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>