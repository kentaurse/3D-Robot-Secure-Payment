<?php
global $dp_options, $logo_type_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーのロゴ ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header logo', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Logo type', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2" id="header_logo_type_select">
		<?php foreach ( $logo_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[use_header_logo_image]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['use_header_logo_image'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<div class="header_logo_text_area" style="<?php if ( $dp_options['use_header_logo_image'] != 'yes' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Font size for text logo', 'tcd-w' ); ?></h4>
		<input type="number" class="small-text" name="dp_options[logo_font_size]" value="<?php echo esc_attr( $dp_options['logo_font_size'] ); ?>" min="0"><span>px</span>
	</div>
	<div class="header_logo_image_area" style="<?php if ( $dp_options['use_header_logo_image'] == 'yes' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Image for logo', 'tcd-w' ); ?></h4>
		<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 150, 30 ); ?></p>
		<p><?php _e( 'If the image is not registered, text will be displayed instead.', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js header_logo_image">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['header_logo_image'] ); ?>" name="dp_options[header_logo_image]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['header_logo_image'] ) { echo wp_get_attachment_image( $dp_options['header_logo_image'], 'full' ); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_logo_image'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
		<p><label><input name="dp_options[header_logo_image_retina]" type="checkbox" value="1" <?php checked( 1, $dp_options['header_logo_image_retina'] ); ?>><?php _e( 'Use retina display logo image', 'tcd-w' ); ?></label></p>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーのロゴ（モバイル） ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header logo for mobile device', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Logo type', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2" id="header_logo_type_select_mobile">
		<?php foreach ( $logo_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[use_header_logo_image_mobile]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['use_header_logo_image_mobile'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<div class="header_logo_text_area_mobile" style="<?php if ( $dp_options['use_header_logo_image_mobile'] != 'yes' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Font size for text logo', 'tcd-w' ); ?></h4>
		<input type="number" class="small-text" name="dp_options[logo_font_size_mobile]" value="<?php echo esc_attr( $dp_options['logo_font_size_mobile'] ); ?>" min="0"><span>px</span>
	</div>
	<div class="header_logo_image_area_mobile" style="<?php if ( $dp_options['use_header_logo_image_mobile'] == 'yes' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Image for logo', 'tcd-w' ); ?></h4>
		<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 100, 20 ); ?></p>
		<p><?php _e( 'If the image is not registered, text will be displayed instead.', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js header_logo_image_mobile">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['header_logo_image_mobile'] ); ?>" name="dp_options[header_logo_image_mobile]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['header_logo_image_mobile'] ) { echo wp_get_attachment_image( $dp_options['header_logo_image_mobile'], 'full' ); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_logo_image_mobile'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
		<p><label><input name="dp_options[header_logo_image_mobile_retina]" type="checkbox" value="1" <?php checked( 1, $dp_options['header_logo_image_mobile_retina'] ); ?>><?php _e( 'Use retina display logo image', 'tcd-w' ); ?></label></p>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
