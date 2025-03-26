<?php

/**
 * ページビルダーウィジェット登録
 */
add_page_builder_widget(array(
	'id' => 'pb-widget-banner',
	'form' => 'form_page_builder_widget_banner',
	'form_rightbar' => 'form_rightbar_page_builder_widget', // 標準右サイドバー
	'display' => 'display_page_builder_widget_banner',
	'title' => __('Banner', 'tcd-w'),
	'priority' => 56
));

/**
 * フォーム
 */
function form_page_builder_widget_banner($values = array()) {
	$dp_options = get_design_plus_option();
	$primary_color = page_builder_get_primary_color('#000000');
	$secondary_color = page_builder_get_secondary_color('#000000');

	// デフォルト値
	$default_values = apply_filters('page_builder_widget_banner_default_values', array(
		'widget_index' => '',
		'image' => '',
		'link' => '',
		'target_blank' => '',
		'overlay_headline' => '',
		'overlay_headline_font_size' => '36',
		'overlay_headline_font_size_mobile' => '18',
		'overlay_headline_font_color' => '#000000',
		'overlay_headline_font_family' => isset($dp_options['headline_font_type']) ? $dp_options['headline_font_type'] : 'type3',
		'overlay_content' => '',
		'overlay_content_font_size' => '14',
		'overlay_content_font_size_mobile' => '12',
		'overlay_content_font_color' => '#000000',
		'overlay_content_font_family' => isset($dp_options['font_type']) ? $dp_options['font_type'] : 'type2',
		'overlay_button' => '',
		'overlay_button_font_color' => '#ffffff',
		'overlay_button_bg_color' => $primary_color,
		'overlay_button_font_color_hover' => '#ffffff',
		'overlay_button_bg_color_hover' => $secondary_color
	), 'form');

	// デフォルト値に入力値をマージ
	$values = array_merge($default_values, (array) $values);

	$font_family_options = array(
		'type1' => __('Meiryo', 'tcd-w'),
		'type2' => __('YuGothic', 'tcd-w'),
		'type3' => __('YuMincho', 'tcd-w')
	);
?>

<div class="form-field">
	<h4><?php _e('Image', 'tcd-w'); ?></h4>
	<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1200, 350 ); ?></p>
	<?php
		$input_name = 'pagebuilder[widget]['.$values['widget_index'].'][image]';
		$media_id = $values['image'];
		pb_media_form($input_name, $media_id);
	?>
</div>

<div class="form-field">
	<h4><?php _e('Headline', 'tcd-w'); ?></h4>
	<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline]" value="<?php echo esc_textarea($values['overlay_headline']); ?>" class="large-text" />
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
	</table>
</div>

<div class="form-field">
	<h4><?php _e('Description', 'tcd-w'); ?></h4>
	<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content]" value="<?php echo esc_textarea($values['overlay_content']); ?>" class="large-text" />
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
	</table>
</div>

<div class="form-field">
	<h4><?php _e('Button Settings', 'tcd-w'); ?></h4>
	<table style="width:100%;">
		<tr>
			<td><?php _e('Button text', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_button]" value="<?php echo esc_attr($values['overlay_button']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font color', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_button_font_color]" value="<?php echo esc_attr($values['overlay_button_font_color']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_button_font_color']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Background color', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_button_bg_color]" value="<?php echo esc_attr($values['overlay_button_bg_color']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_button_bg_color']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Font color (hover)', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_button_font_color_hover]" value="<?php echo esc_attr($values['overlay_button_font_color_hover']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_button_font_color_hover']); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e('Background color (hover)', 'tcd-w'); ?></td>
			<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_button_bg_color_hover]" value="<?php echo esc_attr($values['overlay_button_bg_color_hover']); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_button_bg_color_hover']); ?>" /></td>
		</tr>
	</table>
</div>

<div class="form-field">
	<h4><?php _e('Link URL', 'tcd-w'); ?></h4>
	<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][link]" value="<?php echo esc_attr($values['link']); ?>" />
	<p>
	<input type="hidden" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank]" value="0" />
	<label><input type="checkbox" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank]" value="1"<?php if ($values['target_blank']) echo ' checked="checked"'; ?> /> <?php _e('Use target blank for this link', 'tcd-w'); ?></label>
</div>
<?php
}

/**
 * フロント出力
 */
function display_page_builder_widget_banner($values = array()) {
	$dp_options = get_design_plus_option();

	$image = wp_get_attachment_image_src( $values['image'], 'full' );

	if ( ! empty( $image[0] ) || $values['overlay_headline'] || $values['overlay_content'] || $values['overlay_button'] ) :
?>
<?php
		if ( $values['link'] && ! empty( $image[0] ) && ! $values['overlay_button'] ) :
?>
<a class="pb_banner p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?> has-image" href="<?php echo esc_attr( $values['link'] ); ?>"<?php if (!empty($values['target_blank'])) echo ' target="_blank"'; ?>>
<?php
		else :
?>
<div class="pb_banner<?php if ( ! empty( $image[0] ) ) echo ' has-image'; ?>">
<?php
		endif;

		if ( ! empty( $image[0] ) ) :
?>
	<div class="pb_banner_image p-hover-effect__image"><img src="<?php echo esc_attr( $image[0] ); ?>" alt=""></div>
<?php
		endif;

		if ( $values['overlay_content'] || $values['overlay_headline'] || $values['overlay_button']) :
?>
		<div class="pb_banner_content">
			<div class="pb_banner_content_inner">
<?php
			if ( $values['overlay_content'] ) :
?>
			<p class="pb_banner_desc pb_font_family_<?php echo esc_attr( $values['overlay_content_font_family'] ); ?>"><?php echo esc_html( $values['overlay_content'] ); ?></p>
<?php
			endif;

			if ( $values['overlay_headline'] ) :
?>
			<h2 class="pb_banner_headline pb_font_family_<?php echo esc_attr( $values['overlay_headline_font_family'] ); ?>"><?php echo esc_html( $values['overlay_headline'] ); ?></h2>
<?php
			endif;

			if ( $values['overlay_button'] && $values['link'] ) :
?>
			<a class="pb_banner_button p-button" href="<?php echo esc_attr( $values['link'] ); ?>"<?php if ( $values['target_blank'] ) echo ' target="_blank"'; ?>><span><?php echo esc_html( $values['overlay_button'] ); ?></span></a>
<?php
			elseif ( $values['overlay_button'] ) :
?>
			<div class="pb_banner_button p-button"><span><?php echo esc_html( $values['overlay_button'] ); ?></span></div>
<?php
			endif;
?>
		</div>
	</div>
<?php
		endif;

		if ( $values['link'] && ! empty( $image[0] ) && ! $values['overlay_button'] ) :
?>
</a>
<?php
		else :
?>
</div>
<?php
		endif;
	endif;
}

/**
 * フロント用css
 */
function page_builder_widget_banner_styles() {
	wp_enqueue_style('page_builder-banner', get_template_directory_uri().'/pagebuilder/assets/css/banner.css', false, PAGE_BUILDER_VERSION);
}

function page_builder_widget_banner_sctipts_styles() {
	if (is_singular() && is_page_builder() && page_builder_has_widget('pb-widget-banner')) {
		add_action('wp_enqueue_scripts', 'page_builder_widget_banner_styles', 11);
		add_action('page_builder_css', 'page_builder_widget_banner_css');
	}
}
add_action('wp', 'page_builder_widget_banner_sctipts_styles');

function page_builder_widget_banner_css() {
	// 現記事で使用しているbannerコンテンツデータを取得
	$post_widgets = get_page_builder_post_widgets(get_the_ID(), 'pb-widget-banner');
	if ($post_widgets) {
		$css = array();
		$css_mobile = array();

		foreach($post_widgets as $post_widget) {
			$values = $post_widget['widget_value'];

			if (!empty($values['overlay_headline'])) {
				$css[] = $post_widget['css_class'].' .pb_banner_headline { color: '.esc_attr($values['overlay_headline_font_color']).'; font-size: '.esc_attr($values['overlay_headline_font_size']).'px; }';
			}
			if (!empty($values['overlay_content'])) {
				$css[] = $post_widget['css_class'].' .pb_banner_desc { color: '.esc_attr($values['overlay_content_font_color']).'; font-size: '.esc_attr($values['overlay_content_font_size']).'px; }';
			}
			if (!empty($values['overlay_button'])) {
				$css[] = $post_widget['css_class'].' .pb_banner_button { background-color: '.esc_attr($values['overlay_button_bg_color']).'; color: '.esc_attr($values['overlay_button_font_color']).'; }';
				$css[] = $post_widget['css_class'].' a.pb_banner_button:hover, '.$post_widget['css_class'].' a.pb_banner:hover .pb_banner_button { background-color: '.esc_attr($values['overlay_button_bg_color_hover']).'; color: '.esc_attr($values['overlay_button_font_color_hover']).' !important; }';
			}

			if (!empty($values['overlay_headline']) || !empty($values['overlay_content'])) {
				if (!empty($values['overlay_headline'])) {
					$css_mobile[] = $post_widget['css_class'].' .pb_banner_headline { font-size: '.esc_attr($values['overlay_headline_font_size_mobile']).'px; }';
				}
				if (!empty($values['overlay_content'])) {
					$css_mobile[] = $post_widget['css_class'].' .pb_banner_desc { font-size: '.esc_attr($values['overlay_content_font_size_mobile']).'px; }';
				}
			}
		}

		if ($css) {
			echo implode("\n", $css) . "\n";
		}
		if ($css_mobile) {
			echo "@media only screen and (max-width: 991px) {\n";
			echo "\t" . implode("\n\t", $css_mobile) . "\n";
			echo "}\n";
		}
	}
}
