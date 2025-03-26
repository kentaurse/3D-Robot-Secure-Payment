<?php
global $dp_options, $pw_align_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // 保護ページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Password protected pages settings', 'tcd-w' ); ?></h3>
    <p><?php _e( 'WordPress Default Function We have prepared a function to customize the protected page with "password protection" set. By default the password entry field and send button are only displayed, but you can display arbitrary guidance sentences and link buttons.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Password field and button align settings', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please select the arrangement of password field and confirm-button displayed on the protected page from "Left align" or "Align center".', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $pw_align_options as $option ) : ?>
		<label><input type="radio" name="dp_options[pw_align]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['pw_align'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Password field settings', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the label to be displayed before the password entry field.', 'tcd-w' ); ?></p>
	<p><label><?php _e( 'Label', 'tcd-w' ); ?> <input type="text" name="dp_options[pw_label]" value="<?php echo esc_attr( $dp_options['pw_label'] ); ?>"></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Contents to encourage member registration', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Create induced content for member registration. Please select the guide content you want to display from the post edit screen which set "password protection".', 'tcd-w' ); ?></p>
	<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
	<div class="sub_box">
		<h5 class="theme_option_subbox_headline"><?php echo __( 'Content', 'tcd-w' ) . $i; ?><span><?php if ( $dp_options['pw_name' . $i] ) { echo ' : ' . esc_html( $dp_options['pw_name' . $i] ); } ?></span></h5>
		<div class="sub_box_content">
			<p><label><?php _e( 'Name of contents', 'tcd-w' ); ?> <input type="text" class="theme_option_subbox_headline_label regular-text" name="dp_options[pw_name<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['pw_name' . $i] ); ?>"></label></p>
			<p><?php _e( '"Name of contents" is used in edit post page.', 'tcd-w' ); ?></p>
			<h6 class="theme_option_headline2"><?php _e( 'Button settings', 'tcd-w' ); ?></h6>
            <p><?php _e( 'Set the buttons displayed under the member registration.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" name="dp_options[pw_btn_display<?php echo $i; ?>]" value="1" <?php checked( 1, $dp_options['pw_btn_display' . $i] ); ?>> <?php _e( 'Display button', 'tcd-w' ); ?></label></p>
			<p><label><?php _e( 'Label', 'tcd-w' ); ?> <input type="text" class="regular-text" name="dp_options[pw_btn_label<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['pw_btn_label' . $i] ); ?>"></label></p>
			<p><label>URL <input type="text" class="regular-text" name="dp_options[pw_btn_url<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['pw_btn_url' . $i] ); ?>"></label></p>
			<p><label><input name="dp_options[pw_btn_target<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['pw_btn_target' . $i] ); ?>> <?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
			<h6 class="theme_option_headline2"><?php _e( 'Sentences to encourage member registration', 'tcd-w' ); ?></h6>
            <p><?php _e( 'You can display not only text but also images and Youtube videos as guided content, just like regular posts. "Sentences to encourage member registration" is displayed under excerpts.', 'tcd-w' ); ?></p>
			<?php wp_editor( $dp_options['pw_editor' . $i], 'pw_editor' . $i, array ( 'textarea_name' => 'dp_options[pw_editor' . $i . ']' ) ); ?>
		</div>
	</div>
	<?php endfor; ?>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
