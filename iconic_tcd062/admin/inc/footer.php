<?php
global $dp_options, $dp_default_options, $footer_bar_display_options, $footer_bar_button_options, $footer_bar_icon_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // フッター検索 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Footer search', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please check this to display the footer search form for mobile.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_footer_search_mobile]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_search_mobile'], 1 ); ?>><?php _e( 'Display search form above the footer for mobile', 'tcd-w' ); ?></label></p>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターウィジェットの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Footer widget setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Widget title color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set text color of the title when the widget is set in the footer.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_title_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_title_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_title_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Text color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set text color when the widget is set in the footer.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_text_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_text_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_text_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Link color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set Link text color when the widget is set in the footer.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_link_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_link_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_link_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Link hover color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set hover text color when the widget is set in the footer.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_link_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_link_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_link_color_hover'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set background color when the widget is set in the footer.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターバーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Setting of the footer bar for smart phone', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the footer bar which is displayed with smart phone.', 'tcd-w' ); ?>
	<h4 class="theme_option_headline2"><?php _e( 'Display type of the footer bar', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please select how to display the footer bar. When you scroll a page by a certain amount, the footer bar is displayed with the selected animation. If you do not use the footer bar, please check "Hide".', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $footer_bar_display_options as $option ) : ?>
		<label><input type="radio" name="dp_options[footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['footer_bar_display'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the appearance of the footer bar', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set the color and transparency of the footer bar.', 'tcd-w' ); ?></p>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_bg]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_bg'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Border color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_border]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_border'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_border'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Opacity of background', 'tcd-w' ); ?></td>
			<td><input type="number" class="small-text" name="dp_options[footer_bar_tp]" value="<?php echo esc_attr( $dp_options['footer_bar_tp'] ); ?>" min="0" max="1" step="0.1"></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the contents of the footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can display the button with icon in footer bar. (We recommend you to set max 4 buttons.)', 'tcd-w' ); ?><br><?php _e( 'You can select button types below.', 'tcd-w' ); ?></p>
	<table class="table-border">
		<tr>
			<th><?php _e( 'Default', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can set link URL.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Share', 'tcd-w' ); ?></th>
			<td><?php _e( 'Share buttons are displayed if you tap this button.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Telephone', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can call this number.', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<p><?php _e( 'Click "Add item", and set the button for footer bar. You can drag the item to change their order.', 'tcd-w' ); ?></p>
	<div class="repeater-wrapper">
		<div class="repeater sortable" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
			<?php
			if ( $dp_options['footer_bar_btns'] ) :
				foreach ( $dp_options['footer_bar_btns'] as $key => $value ) :
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo esc_attr( $key ); ?>">
				<h4 class="theme_option_subbox_headline"><?php echo esc_attr( $value['label'] ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1" <?php checked( $value['target'], 1 ); ?>><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
							<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
							<td>
								<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
									<?php foreach ( $footer_bar_button_options as $option ) : ?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value['type'], $option['value'] ); ?>><?php echo $option['label']; ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="large-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-url" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $value['url'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-number" style="<?php if ( $value['type'] !== 'type3' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value="<?php echo esc_attr( $value['number'] ); ?>"></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach ( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $value['icon'] ); ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php
				endforeach;
			endif;
			?>
			<?php
				$key = 'addindex';
				ob_start();
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo $key; ?>">
			<h4 class="theme_option_subbox_headline"><?php _e( 'New item', 'tcd-w' ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1"><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
								<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
								<td>
									<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
										<?php foreach ( $footer_bar_button_options as $option ) : ?>
										<option value="<?php echo esc_attr( $option['value'] ); ?>"><?php echo $option['label']; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="large-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value=""></td>
						</tr>
						<tr class="footer-bar-url">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value=""></td>
						</tr>
						<tr class="footer-bar-number" style="display: none;">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value=""></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach ( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>"<?php if ( 'file-text' == $option['value'] ) { echo ' checked="checked"'; } ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php $clone = ob_get_clean(); ?>
		</div>
		<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
