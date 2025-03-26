<?php
global $dp_options, $dp_default_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Settings for 404 page', 'tcd-w' ); ?></h3>
    <p><?php _e( 'The 404 page is displayed when accessing the page with the browser, but the page does not exist on the website.Please set the header image, catch phrase, explanation to be displayed on page 404.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Header image', 'tcd-w' ); ?></h4>
	<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1450, 600 ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js image_404">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['image_404'] ); ?>" name="dp_options[image_404]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['image_404'] ) { echo wp_get_attachment_image( $dp_options['image_404'], 'medium' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['image_404'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please set the overlay color.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[overlay_404]" type="text" value="<?php echo esc_attr( $dp_options['overlay_404'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['overlay_404'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.2)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[overlay_opacity_404]" value="<?php echo esc_attr( $dp_options['overlay_opacity_404'] ); ?>" min="0" max="1" step="0.1">
	<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set a catchphrase to be displayed on the header image.', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[catchphrase_404]" value="<?php echo esc_attr( $dp_options['catchphrase_404'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font size of catchphrase.', 'tcd-w' ); ?></p>
    <p><input type="number" class="small-text" name="dp_options[catchphrase_font_size_404]" value="<?php echo esc_attr( $dp_options['catchphrase_font_size_404'] ); ?>" min="0"><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set a description to be displayed on the header image.', 'tcd-w' ); ?></p>
	<textarea cols="50" rows="4" name="dp_options[desc_404]"><?php echo esc_textarea( $dp_options['desc_404'] ); ?></textarea>

	<h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font size of cdescription.', 'tcd-w' ); ?></p>
	<p><input type="number" class="small-text" name="dp_options[desc_font_size_404]" value="<?php echo esc_attr( $dp_options['desc_font_size_404'] ); ?>" min="0"><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font color of catch phrase and description.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[color_404]" type="text" value="<?php echo esc_attr( $dp_options['color_404'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['color_404'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set up a drop shadow to be added to the catchphrase and description.', 'tcd-w' ); ?></p>
	<table class="theme_option_table">
		<tr>
			<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[shadow1_404]" value="<?php echo esc_attr( $dp_options['shadow1_404'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[shadow2_404]" value="<?php echo esc_attr( $dp_options['shadow2_404'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[shadow3_404]" value="<?php echo esc_attr( $dp_options['shadow3_404'] ); ?>" min="0"><span>px</span></li></td>
		</tr>
		<tr>
			<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[shadow_color_404]" type="text" value="<?php echo esc_attr( $dp_options['shadow_color_404'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['shadow_color_404'] ); ?>"></td>
		</tr>
	</table>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
