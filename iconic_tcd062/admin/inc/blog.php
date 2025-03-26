<?php
global $dp_options, $dp_default_options, $post_order_options, $page_link_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ブログの設定 ?>
<div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e( 'Blog page basic settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Breadcrumb label', 'tcd-w' ); ?></h4>
    <p><?php _e( 'The breadcrumb is displayed at archive and single page. You can change name of page as you like.(default: Blog)', 'tcd-w' ); ?></p>
	<input class="regular-text" name="dp_options[blog_breadcrumb_label]" type="text" value="<?php echo esc_attr( $dp_options['blog_breadcrumb_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Headline for page header', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the title of page header in archive and single page.', 'tcd-w' ); ?></p>
	<input class="regular-text" name="dp_options[blog_header_headline]" type="text" value="<?php echo esc_attr( $dp_options['blog_header_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Description for page header', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the description of page header in archive and single page.', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="2" name="dp_options[blog_header_desc]"><?php echo esc_textarea( $dp_options['blog_header_desc'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 記事詳細ページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Blog title / contents setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post title', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the single page title.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[title_font_size]" value="<?php echo esc_attr( $dp_options['title_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post title for mobile', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the single page title for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[title_font_size_mobile]" value="<?php echo esc_attr( $dp_options['title_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Post title color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font color of the single page title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[title_color]" type="text" value="<?php echo esc_attr( $dp_options['title_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['title_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post contents', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the single page contents.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[content_font_size]" value="<?php echo esc_attr( $dp_options['content_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post contents for mobile', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font size of the single page contents for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[content_font_size_mobile]" value="<?php echo esc_attr( $dp_options['content_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Post contents color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can set the font color of the single page contents.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[content_color]" type="text" value="<?php echo esc_attr( $dp_options['content_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['content_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Pages link setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'By inserting the tag <! - nextpage -> in the article body, you can split an article into multiple pages. You can select pagenation, "Pager" or "Read more button".', 'tcd-w' ); ?></p>
	<fieldset class="cf radio_images">
		<?php foreach ( $page_link_options as $option ) : ?>
		<label>
			<input type="radio" name="dp_options[page_link]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['page_link'] ); ?>>
			<?php echo $option['label']; ?>
			<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
		</label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
    <h4 class="theme_option_headline2"><?php _e( 'Settings for archive page and single page', 'tcd-w' ); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_date]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_date'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_category]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_category'] ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></li>
    </ul>
    <h4 class="theme_option_headline2"><?php _e( 'Settings for single page', 'tcd-w' ); ?></h4>
    <ul>
        <li><label><input name="dp_options[show_thumbnail]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_thumbnail'] ); ?>><?php _e( 'Display thumbnail', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_tag]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_tag'] ); ?>><?php _e( 'Display tags', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_author]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_author'] ); ?>><?php _e( 'Display author', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sns_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_sns_top'] ); ?>><?php _e( 'Buttons to the article top', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sns_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_sns_btm'] ); ?>><?php _e( 'Buttons to the article bottom', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_next_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_next_post'] ); ?>><?php _e( 'Display next previous post link', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_comment]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_comment'] ); ?>><?php _e( 'Display comment', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_trackback]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_trackback'] ); ?>><?php _e( 'Display trackbacks', 'tcd-w' ); ?></label></li>
	</ul>


	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 関連記事の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Related posts setting', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can set related posts list displayed at bottom of single page.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_related_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_related_post'] ); ?>> <?php _e( 'Display related post', 'tcd-w'); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Headline of related posts', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set heading of related post list.', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[related_post_headline]" value="<?php echo esc_attr( $dp_options['related_post_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Number of related posts', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the number of posts of related post list.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[related_post_num]" value="<?php echo esc_attr( $dp_options['related_post_num'] ); ?>" min="1">
	<input type="submit" class="button-ml ajax_button" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 広告の登録1 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>1</h3>
	<p><?php _e( 'This banner will be displayed under contents.', 'tcd-w' ); ?></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code1]"><?php echo esc_textarea( $dp_options['single_ad_code1'] ); ?></textarea>
			</div>
            <p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually. If an advertisement code is entered in the above setting field, the following setting will be invalid.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image1'] ); ?>" name="dp_options[single_ad_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image1'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url1]" value="<?php echo esc_attr( $dp_options['single_ad_url1'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code2]"><?php echo esc_textarea( $dp_options['single_ad_code2'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image2">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image2'] ); ?>" name="dp_options[single_ad_image2]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image2'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image2'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image2'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url2]" value="<?php echo esc_attr( $dp_options['single_ad_url2'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
</div><!-- END .theme_option_field -->
<?php // 記事詳細の広告設定2 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>2</h3>
	<p><?php _e( 'Please copy and paste the short code inside the content to show this banner.', 'tcd-w' ); ?></p>
	<p><?php _e( 'Short code', 'tcd-w' ); ?> : <input type="text" readonly="readonly" value="[s_ad]"></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code3]"><?php echo esc_textarea( $dp_options['single_ad_code3'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image3">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image3'] ); ?>" name="dp_options[single_ad_image3]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image3'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image3'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image3'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url3]" value="<?php echo esc_attr( $dp_options['single_ad_url3'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code4]"><?php echo esc_textarea( $dp_options['single_ad_code4'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image4">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image4'] ); ?>" name="dp_options[single_ad_image4]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image4'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image4'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image4'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url4]" value="<?php echo esc_attr( $dp_options['single_ad_url4'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
</div><!-- END .theme_option_field -->
<?php // スマホ専用広告の登録 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mobile device banner setup', 'tcd-w' ); ?></h3>
	<p><?php _e( 'This banner will be displayed on mobile device.', 'tcd-w' ); ?></p>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
		<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
		<textarea class="large-text" cols="50" rows="10" name="dp_options[single_mobile_ad_code1]"><?php echo esc_textarea( $dp_options['single_mobile_ad_code1'] ); ?></textarea>
	</div>
	<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' );?></p>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js single_mobile_ad_image1">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['single_mobile_ad_image1'] ); ?>" name="dp_options[single_mobile_ad_image1]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['single_mobile_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['single_mobile_ad_image1'], 'medium' ); } ?></div>
				<div class="buttton_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_mobile_ad_image1'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
		<input class="regular-text" type="text" name="dp_options[single_mobile_ad_url1]" value="<?php echo esc_attr( $dp_options['single_mobile_ad_url1'] ); ?>">
		<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div>
