<?php
global $dp_options, $dp_default_options, $text_align_options, $slide_time_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header slider setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set header slider as the first view of your site. You can set 5 slides or 1 image as fixed header.', 'tcd-w' ); ?></p>
	<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slider%s setting', 'tcd-w' ), $i ); ?></h3>

		<div class="sub_box_content">
			<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Image for PC and Tablet.', 'tcd-w' ); ?></p>
			<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 1450, 600 ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js slider_image<?php echo esc_attr( $i ); ?>">
					<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_image' . $i] ); ?>" name="dp_options[slider_image<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
					<div class="preview_field"><?php if ( $dp_options['slider_image' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_image' . $i], 'medium' ); } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_image' . $i] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Image for smartphone', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Image for mobile.', 'tcd-w' ); ?></p>
			<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 640, 480 ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js slider_image_sp<?php echo esc_attr( $i ); ?>">
					<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_image_sp' . $i] ); ?>" name="dp_options[slider_image_sp<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
					<div class="preview_field"><?php if ( $dp_options['slider_image_sp' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_image_sp' . $i], 'medium' ); } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_image_sp' . $i] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Overlay', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please check "use overlay", and set detail options.', 'tcd-w' ); ?></p>
			<p class="display_slider_overlay"><label><input type="checkbox" name="dp_options[display_slider_overlay<?php echo $i; ?>]" value="1" <?php checked( $dp_options['display_slider_overlay' . $i], 1 ); ?>><?php _e( 'Display overlay', 'tcd-w' ); ?></label></p>
			<div<?php if ( ! $dp_options['display_slider_overlay' . $i] ) echo ' style="display: none;"' ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
                <p><?php _e( 'Please set color and opacity of overlay.', 'tcd-w' ); ?></p>
				<input class="c-color-picker" name="dp_options[slider_overlay_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_overlay_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_overlay_color' . $i] ); ?>">
				<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[slider_overlay_opacity<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_overlay_opacity' . $i] ); ?>" min="0" max="1" step="0.1">
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Catchphrase setting', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the catchphrase on the image, and check "use catchphrase" to set detail options.', 'tcd-w' ); ?></p>
			<p class="display_slider_catch"><label><input type="checkbox" name="dp_options[display_slider_catch<?php echo $i; ?>]" value="1" <?php checked( $dp_options['display_slider_catch' . $i], 1 ); ?>><?php _e( 'Display catchphrase', 'tcd-w' ); ?></label></p>
			<div<?php if ( ! $dp_options['display_slider_catch' . $i] ) echo ' style="display: none;"' ?>>
                <p><?php _e( 'Plase set texts for catchphrase, font size, color and align.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<textarea rows="2" class="large-text" name="dp_options[slider_catch<?php echo $i; ?>]"><?php echo esc_textarea( $dp_options['slider_catch' . $i] ); ?></textarea>
				<table>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_catch_font_size' . $i] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_catch_align<?php echo $i; ?>]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_catch_align' . $i] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase setting for mobile', 'tcd-w' ); ?></h4>
                <p><?php _e( 'You can set font size, color, background color and opacity of catchphrase for mobile.', 'tcd-w' ); ?></p>
				<table>
					<tr>
						<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_catch_font_size_mobile' . $i] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color for mobile', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_color_mobile<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_color_mobile' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_color_mobile' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_bg_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_bg_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_bg_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Opacity of background', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_bg_opacity<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_catch_bg_opacity' . $i] ); ?>" min="0" max="1" step="0.1"></td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow1]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow1'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow2]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow2'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow3]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch<?php echo $i; ?>_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch' . $i . '_shadow_color'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Headline setting', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the caption displayed below the slider, and check "use caption" to set detail options.', 'tcd-w' ); ?></p>
			<p class="display_slider_headline"><label><input type="checkbox" name="dp_options[display_slider_headline<?php echo $i; ?>]" value="1" <?php checked( $dp_options['display_slider_headline' . $i], 1 ); ?>><?php _e( 'Display headline', 'tcd-w' ); ?></label></p>
			<div<?php if ( ! $dp_options['display_slider_headline' . $i] ) echo ' style="display: none;"' ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
                <p><?php _e( 'Plase set caption.', 'tcd-w' ); ?></p>
				<input class="large-text" type="text" name="dp_options[slider_headline<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $dp_options['slider_headline' . $i] ); ?>">
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Button setting', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the button displayed below the slider, and check "use caption" to set detail options.', 'tcd-w' ); ?></p>
			<p class="display_slider_button"><label><input type="checkbox" name="dp_options[display_slider_button<?php echo $i; ?>]" value="1" <?php checked( $dp_options['display_slider_button' . $i], 1 ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
			<div<?php if ( ! $dp_options['display_slider_button' . $i] ) echo ' style="display: none;"' ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label for="dp_options[slider_button_label<?php echo $i; ?>]"><?php _e( 'Button label', 'tcd-w' ); ?></label></td>
						<td><input type="text" id="dp_options[slider_button_label<?php echo $i; ?>]" name="dp_options[slider_button_label<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_button_label' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color_hover' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color_hover' . $i] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set destination url when clicking/tapping the button on PC and tablet and tapping button or background images on mobile device.', 'tcd-w' ); ?></p>
			<input class="large-text" type="text" name="dp_options[slider_url<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $dp_options['slider_url' . $i] ); ?>">
			<p><label><input name="dp_options[slider_target<?php echo esc_attr( $i ); ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['slider_target' . $i] ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
			<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
	<?php endfor; ?>
	<h4 class="theme_option_headline2"><?php _e( 'Slide speed', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set transition speed. (3 to 15 seconds)', 'tcd-w' ); ?></p>
	<select name="dp_options[slide_time]">
		<?php foreach ( $slide_time_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slide_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ニュースティッカーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'News ticker setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set news ticker below header slider.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_index_news]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_news'] ); ?>> <?php _e( 'Display news ticker', 'tcd-w'); ?></label></p>
	
	<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the number of news and display/non-display of date.', 'tcd-w' ); ?></p>
	<p><label><?php _e( 'Post number', 'tcd-w' ); ?><label> <input type="number" class="small-text" name="dp_options[index_news_num]" value="<?php echo esc_attr( $dp_options['index_news_num'] ); ?>" min="1"></p>
	<p><label><input name="dp_options[show_index_news_date]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_news_date'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the button to archive page displayed at right of ticker. If you set blank, button is not displayed.', 'tcd-w' ); ?></p>
	<table>
		<tr>
			<td><label><?php _e( 'Archive link text', 'tcd-w' ); ?></label></td>
			<td><input class="regular-text" type="text" name="dp_options[index_news_archive_link_text]" value="<?php echo esc_attr( $dp_options['index_news_archive_link_text'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_news_archive_link_font_color]" type="text" value="<?php echo esc_attr( $dp_options['index_news_archive_link_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_news_archive_link_font_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_news_archive_link_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['index_news_archive_link_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_news_archive_link_bg_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_news_archive_link_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['index_news_archive_link_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_news_archive_link_font_color_hover'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_news_archive_link_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['index_news_archive_link_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_news_archive_link_bg_color_hover'] ); ?>"></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'News ticker speed', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set transition speed of ticker. (3 - 15 seconds)', 'tcd-w' ); ?></p>
	<select name="dp_options[index_news_slide_time]">
		<?php foreach ( $slide_time_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['index_news_slide_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" class="button-ml ajax_button" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php
// コンテンツビルダー
cb_inputs();
?>
