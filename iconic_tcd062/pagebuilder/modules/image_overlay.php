<?php

/**
 * ページビルダーウィジェット登録
 */
add_page_builder_widget(array(
	'id' => 'pb-widget-image-overlay',
	'form' => 'form_page_builder_widget_image_overlay',
	'form_rightbar' => 'form_rightbar_page_builder_widget', // 標準右サイドバー
	'display' => 'display_page_builder_widget_image_overlay',
	'title' => __('Image with overlay text', 'tcd-w'),
	'priority' => 2
));

/**
 * 管理画面用js
 */
function page_builder_widget_image_overlay_admin_scripts() {
	wp_enqueue_script('page_builder-image_overlay-admin', get_template_directory_uri().'/pagebuilder/assets/admin/js/image_overlay.js', array('jquery'), PAGE_BUILDER_VERSION, true);
}
add_action('page_builder_admin_scripts', 'page_builder_widget_image_overlay_admin_scripts', 12);

/**
 * フォーム
 */
function form_page_builder_widget_image_overlay($values = array()) {
	// デフォルト値
	$default_values = apply_filters('page_builder_widget_image_overlay_default_values', array(
		'widget_index' => '',
		'image' => '',
		'size' => 'full',
		'link' => '',
		'target_blank' => '',
		'show_overlay' => 0,
		'overlay_layout' => 'type1',
		'overlay_layout_bottom_mobile' => 1,
		'overlay_bg_color' => page_builder_get_primary_color('#000000'),
		'overlay_bg_opacity' => '0.5',
		'overlay_bg_color_mobile' => page_builder_get_primary_color('#000000'),
		'overlay_bg_opacity_mobile' => '1',
		'overlay_headline' => '',
		'overlay_headline_font_size' => '34',
		'overlay_headline_font_size_mobile' => '20',
		'overlay_headline_font_color' => '#ffffff',
		'overlay_headline_font_color_mobile' => '#ffffff',
		'overlay_headline_font_family' => 'type1',
		'overlay_headline_text_align' => 'left',
		'overlay_headline_text_align_mobile' => 'left',
		'overlay_content' => '',
		'overlay_content_font_size' => '14',
		'overlay_content_font_size_mobile' => '14',
		'overlay_content_font_color' => '#ffffff',
		'overlay_content_font_color_mobile' => '#ffffff',
		'overlay_content_font_family' => 'type1',
		'overlay_content_text_align' => 'left',
		'overlay_content_text_align_mobile' => 'left'
	), 'form');

	// デフォルト値に入力値をマージ
	$values = array_merge($default_values, (array) $values);

	$overlay_layout_options = array(
		'type1' => __('Overlay on the entire image', 'tcd-w'),
		'type2' => __('Overlay on the top side of image', 'tcd-w'),
		'type3' => __('Overlay on the bottom side of image', 'tcd-w'),
		'type4' => __('Overlay on the left side of image', 'tcd-w'),
		'type5' => __('Overlay on the right side of image', 'tcd-w'),
	);

	$font_family_options = array(
		'type1' => __('Meiryo', 'tcd-w'),
		'type2' => __('YuGothic', 'tcd-w'),
		'type3' => __('YuMincho', 'tcd-w')
	);

	$text_align_options = array(
		'left' => __('Align left', 'tcd-w'),
		'center' => __('Align center', 'tcd-w'),
		'right' => __('Align right', 'tcd-w')
	);
?>

<div class="form-field">
	<h4><?php _e('Image', 'tcd-w'); ?></h4>
	<?php
		$input_name = 'pagebuilder[widget]['.$values['widget_index'].'][image]';
		$media_id = $values['image'];
		pb_media_form($input_name, $media_id);
	?>
</div>

<div class="form-field">
	<h4><?php _e('Image size', 'tcd-w'); ?></h4>
	<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][size]">
		<?php
			// This filter is documented in wp-admin/includes/media.php
			$select_options = apply_filters('image_size_names_choose', array(
				'thumbnail' => __('Thumbnail size', 'tcd-w'),
				'medium'    => __('Medium size', 'tcd-w'),
				'large'     => __('Large size', 'tcd-w'),
				'full'      => __('Full size', 'tcd-w')
			));
			foreach($select_options as $key => $value) {
				$attr = '';
				if ($values['size'] == $key) {
					$attr .= ' selected="selected"';
				}
				echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
			}
		?>
	</select>
</div>

<div class="form-field">
	<h4><?php _e('Link URL for image', 'tcd-w'); ?></h4>
	<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][link]" value="<?php echo esc_attr($values['link']); ?>" />
</div>

<div class="form-field">
	<h4><?php _e('Link target', 'tcd-w'); ?></h4>
	<input type="hidden" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank]" value="0" />
	<label><input type="checkbox" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank]" value="1"<?php if ($values['target_blank']) echo ' checked="checked"'; ?> /> <?php _e('Use target blank for this link', 'tcd-w'); ?></label>
</div>

<div class="form-field form-field-show_overlay">
	<h4><?php _e('Overlay text setting', 'tcd-w'); ?></h4>
	<p>
		<input type="hidden" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][show_overlay]" value="0" />
		<label><input type="checkbox" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][show_overlay]" value="1"<?php if ($values['show_overlay']) echo ' checked="checked"'; ?> /><?php _e('Display overlay text', 'tcd-w'); ?></label>
	</p>
</div>

<div class="form-field form-field-radio form-field-overlay hidden">
	<h4><?php _e('Overlay text layout', 'tcd-w'); ?></h4>
	<?php
		$radio_html = array();
		foreach($overlay_layout_options as $key => $value) {
			$attr = '';
			if ($values['overlay_layout'] == $key) {
				$attr .= ' checked="checked"';
			}
			$radio_html[] = '<label><input type="radio" name="pagebuilder[widget]['.esc_attr($values['widget_index']).'][overlay_layout]" value="'.esc_attr($key).'"'.$attr.' />'.esc_html($value).'</label>';
		}
		echo implode("<br>\n\t", $radio_html);
	?>
	<br><label><input type="checkbox" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_layout_bottom_mobile]" value="1"<?php if ($values['overlay_layout_bottom_mobile']) echo ' checked="checked"'; ?> /><?php _e('If mobile, display text below the image', 'tcd-w'); ?></label>
</div>

<div class="form-field form-field-overlay hidden">
	<h4><?php _e('Overlay background color', 'tcd-w'); ?></h4>
	<table>
		<tr>
			<td><?php _e('Background color', 'tcd-w'); ?></td>
			<td>
				<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_bg_color]" value="<?php echo esc_attr($values['overlay_bg_color']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_bg_color']); ?>" />
			</td>
		</tr>
		<tr>
			<td><?php _e('Transparency', 'tcd-w'); ?></td>
			<td>
				<input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_bg_opacity]" value="<?php echo esc_attr($values['overlay_bg_opacity']); ?>" class="small-text" min="0" max="1" step="0.1" />
				<span class="pb-description" style="margin-left: 5px;"><?php _e('Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w'); ?></span>
			</td>
		</tr>
		<tr>
			<td><?php _e('Background color for mobile', 'tcd-w'); ?></td>
			<td>
				<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_bg_color_mobile]" value="<?php echo esc_attr($values['overlay_bg_color_mobile']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_bg_color_mobile']); ?>" />
			</td>
		</tr>
		<tr>
			<td><?php _e('Transparency for mobile', 'tcd-w'); ?></td>
			<td>
				<input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_bg_opacity_mobile]" value="<?php echo esc_attr($values['overlay_bg_opacity_mobile']); ?>" class="small-text" min="0" max="1" step="0.1" />
				<span class="pb-description" style="margin-left: 5px;"><?php _e('Please enter the number 0 - 1.0. (e.g. 1.0)', 'tcd-w'); ?></span>
			</td>
		</tr>
	</table>
</div>

<div class="form-field form-field-overlay hidden">
	<h4><?php _e('Headline', 'tcd-w'); ?></h4>
	<textarea name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline]" rows="2"><?php echo esc_textarea($values['overlay_headline']); ?></textarea>
	<table style="margin-top:5px;">
		<tr>
			<td><?php _e('Font size', 'tcd-w'); ?></td>
			<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_size]" value="<?php echo esc_attr($values['overlay_headline_font_size']); ?>" class="small-text" min="0" /> px</td>
		</tr>
		<tr>
			<td><?php _e('Font size for mobile', 'tcd-w'); ?></td>
			<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_size_mobile]" value="<?php echo esc_attr($values['overlay_headline_font_size_mobile']); ?>" class="small-text" min="0" /> px</td>
		</tr>
		<tr>
			<td><?php _e('Font color', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_color]" value="<?php echo esc_attr($values['overlay_headline_font_color']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_headline_font_color']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font color for mobile', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_color_mobile]" value="<?php echo esc_attr($values['overlay_headline_font_color_mobile']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_headline_font_color_mobile']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font family', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_family]">
					<?php
						foreach($font_family_options as $key => $value) {
							$attr = '';
							if ($values['overlay_headline_font_family'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Text align', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_text_align]">
					<?php
						foreach($text_align_options as $key => $value) {
							$attr = '';
							if ($values['overlay_headline_text_align'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Text align for mobile', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_text_align_mobile]">
					<?php
						foreach($text_align_options as $key => $value) {
							$attr = '';
							if ($values['overlay_headline_text_align_mobile'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="form-field form-field-overlay hidden">
	<h4><?php _e('Description', 'tcd-w'); ?></h4>
	<textarea name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content]" rows="4"><?php echo esc_textarea($values['overlay_content']); ?></textarea>
	<table style="margin-top:5px;">
		<tr>
			<td><?php _e('Font size', 'tcd-w'); ?></td>
			<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_size]" value="<?php echo esc_attr($values['overlay_content_font_size']); ?>" class="small-text" min="0" /> px</td>
		</tr>
		<tr>
			<td><?php _e('Font size for mobile', 'tcd-w'); ?></td>
			<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_size_mobile]" value="<?php echo esc_attr($values['overlay_content_font_size_mobile']); ?>" class="small-text" min="0" /> px</td>
		</tr>
		<tr>
			<td><?php _e('Font color', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_color]" value="<?php echo esc_attr($values['overlay_content_font_color']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_content_font_color']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font color for mobile', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_color_mobile]" value="<?php echo esc_attr($values['overlay_content_font_color_mobile']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_content_font_color_mobile']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font family', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_family]">
					<?php
						foreach($font_family_options as $key => $value) {
							$attr = '';
							if ($values['overlay_content_font_family'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Text align', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_text_align]">
					<?php
						foreach($text_align_options as $key => $value) {
							$attr = '';
							if ($values['overlay_content_text_align'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Text align for mobile', 'tcd-w'); ?></td>
			<td>
				<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_text_align_mobile]">
					<?php
						foreach($text_align_options as $key => $value) {
							$attr = '';
							if ($values['overlay_content_text_align_mobile'] == $key) {
								$attr .= ' selected="selected"';
							}
							echo '<option value="'.esc_attr($key).'"'.$attr.'>'.esc_html($value).'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>
<?php
}

/**
 * フロント出力
 */
function display_page_builder_widget_image_overlay($values = array()) {
	if (!empty($values['image'])) {
		if (!empty($values['size'])) {
			$image_size = $values['size'];
		} else {
			$image_size = 'full';
		}
		$image = wp_get_attachment_image($values['image'], $image_size);
	}
	if (empty($image)) return;

	// オーバーレイあり
	if (!empty($values['show_overlay'])) {
		echo '<div class="pb_image_overlay-container pb_image_overlay-layout-'.esc_attr($values['overlay_layout']).(!empty($values['overlay_layout']) ? ' pb_image_overlay-layout-mobile-bottom' : '').'">'."\n";

		echo "\t";

		if (!empty($values['link'])) {
			echo '<a href="'.esc_attr($values['link']).'"';
			if (!empty($values['target_blank'])) {
				echo ' target="_blank"';
			}
			echo '>';
		}

		echo $image;

		if (!empty($values['link'])) {
			echo '</a>';
		}

		echo "\n";

		echo "\t".'<div class="pb_image_overlay">'."\n";

		if (!empty($values['overlay_headline']) || !empty($values['overlay_content'])) {
			echo "\t\t".'<div class="pb_image_overlay-inner">'."\n";

			if (!empty($values['overlay_headline'])) {
				echo "\t\t\t".'<h3 class="pb_image_overlay_headline pb_font_family_'.esc_attr($values['overlay_headline_font_family']).'">'.str_replace(array("\r\n", "\r", "\n"), '<br>', esc_html($values['overlay_headline'])).'</h3>'."\n";
			}

			if (!empty($values['overlay_content'])) {
				echo "\t\t\t".'<div class="pb_image_overlay_content pb_font_family_'.esc_attr($values['overlay_content_font_family']).'">'.str_replace(array("\r\n", "\r", "\n"), '<br>', esc_html($values['overlay_content'])).'</div>'."\n";
			}

			echo "\t\t</div>\n";
		}

		echo "\t</div>\n";

		echo "</div>\n";

	// オーバーレイなし
	} else {
		if (!empty($values['link'])) {
			echo '<a href="'.esc_attr($values['link']).'"';
			if (!empty($values['target_blank'])) {
				echo ' target="_blank"';
			}
			echo '>';
		}

		echo $image;

		if (!empty($values['link'])) {
			echo '</a>';
		}
	}
}

/**
 * フロント用css
 */
function page_builder_widget_image_overlay_styles() {
	wp_enqueue_style('page_builder-image-overlay', get_template_directory_uri().'/pagebuilder/assets/css/image_overlay.css', false, PAGE_BUILDER_VERSION);
}

function page_builder_widget_image_overlay_sctipts_styles() {
	if (is_singular() && is_page_builder() && page_builder_has_widget('pb-widget-image-overlay')) {
		add_action('wp_enqueue_scripts', 'page_builder_widget_image_overlay_styles', 11);
		add_action('page_builder_css', 'page_builder_widget_image_overlay_css');
	}
}
add_action('wp', 'page_builder_widget_image_overlay_sctipts_styles');

function page_builder_widget_image_overlay_css() {
	// 現記事で使用しているimage-overlayコンテンツデータを取得
	$post_widgets = get_page_builder_post_widgets(get_the_ID(), 'pb-widget-image-overlay');
	if ($post_widgets) {
		foreach($post_widgets as $post_widget) {
			$values = $post_widget['widget_value'];

			// オーバーレイあり
			if (!empty($values['show_overlay'])) {
				echo $post_widget['css_class'].' .pb_image_overlay { background-color: rgba('.esc_attr(implode(',', page_builder_hex2rgb($values['overlay_bg_color'])).','.$values['overlay_bg_opacity']).'); }'."\n";
				if (!empty($values['overlay_headline'])) {
					echo $post_widget['css_class'].' .pb_image_overlay_headline { color: '.esc_attr($values['overlay_headline_font_color']).'; font-size: '.esc_attr($values['overlay_headline_font_size']).'px; text-align: '.esc_attr($values['overlay_headline_text_align']).'; }'."\n";
				}
				if (!empty($values['overlay_content'])) {
					echo $post_widget['css_class'].' .pb_image_overlay_content { color: '.esc_attr($values['overlay_content_font_color']).'; font-size: '.esc_attr($values['overlay_content_font_size']).'px; text-align: '.esc_attr($values['overlay_content_text_align']).'; }'."\n";
				}

				echo "@media only screen and (max-width: 767px) {\n";
				echo $post_widget['css_class'].' .pb_image_overlay { background-color: rgba('.esc_attr(implode(',', page_builder_hex2rgb($values['overlay_bg_color_mobile'])).','.$values['overlay_bg_opacity_mobile']).'); }'."\n";
				if (!empty($values['overlay_headline'])) {
					echo '  '.$post_widget['css_class'].' .pb_image_overlay_headline { color: '.esc_attr($values['overlay_headline_font_color_mobile']).'; font-size: '.esc_attr($values['overlay_headline_font_size_mobile']).'px; text-align: '.esc_attr($values['overlay_headline_text_align_mobile']).'; }'."\n";
				}
				if (!empty($values['overlay_content'])) {
					echo '  '.$post_widget['css_class'].' .pb_image_overlay_content { color: '.esc_attr($values['overlay_content_font_color_mobile']).'; font-size: '.esc_attr($values['overlay_content_font_size_mobile']).'px; text-align: '.esc_attr($values['overlay_content_text_align_mobile']).'; }'."\n";
				}
				echo "}\n";
			}
		}
	}
}
