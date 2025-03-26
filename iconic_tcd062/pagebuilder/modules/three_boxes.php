<?php

/**
 * ページビルダーウィジェット登録
 */
add_page_builder_widget(array(
	'id' => 'pb-widget-three-boxes',
	'form' => 'form_page_builder_widget_three_boxes',
	'form_rightbar' => 'form_rightbar_page_builder_widget', // 標準右サイドバー
	'display' => 'display_page_builder_widget_three_boxes',
	'title' => __('Three boxes', 'tcd-w'),
	'priority' => 56
));

/**
 * フォーム
 */
function form_page_builder_widget_three_boxes($values = array()) {
	$dp_options = get_design_plus_option();
	$primary_color = page_builder_get_primary_color('#000000');
	$secondary_color = page_builder_get_secondary_color('#000000');

	// デフォルト値
	$default_values = array(
		'widget_index' => '',
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$default_values['image'.$i] = '';
		$default_values['link'.$i] = '';
		$default_values['target_blank'.$i] = '';
		$default_values['overlay_headline'.$i] = '';
		$default_values['overlay_headline_font_size'.$i] = '32';
		$default_values['overlay_headline_font_size_mobile'.$i] = '30';
		$default_values['overlay_headline_font_color'.$i] = '#000000';
		$default_values['overlay_headline_font_family'.$i] = isset($dp_options['headline_font_type']) ? $dp_options['headline_font_type'] : 'type3';
		$default_values['overlay_content'.$i] = '';
		$default_values['overlay_content_font_size'.$i] = '14';
		$default_values['overlay_content_font_size_mobile'.$i] = '12';
		$default_values['overlay_content_font_color'.$i] = '#000000';
		$default_values['overlay_content_font_family'.$i] = isset($dp_options['font_type']) ? $dp_options['font_type'] : 'type2';
	}
	$default_values = apply_filters('page_builder_widget_three_boxes_default_values', $default_values, 'form');

	// デフォルト値に入力値をマージ
	$values = array_merge($default_values, (array) $values);

	$font_family_options = array(
		'type1' => __('Meiryo', 'tcd-w'),
		'type2' => __('YuGothic', 'tcd-w'),
		'type3' => __('YuMincho', 'tcd-w')
	);

	for($i = 1; $i <= 3; $i++) :
?>
<div class="pb_repeater">
	<h3 class="pb_repeater_headline"><span class="index_label"><?php echo esc_html($values['overlay_headline'.$i] ? $values['overlay_headline'.$i] : sprintf(__('Box%d', 'tcd-w'), $i)); ?></span><a href="#"><?php _e('Open', 'tcd-w'); ?></a></h3>
	<div class="pb_repeater_field">
		<div class="form-field">
			<h4><?php _e('Image', 'tcd-w'); ?></h4>
			<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 380, 240 ); ?></p>
			<?php
				$input_name = 'pagebuilder[widget]['.$values['widget_index'].'][image'.$i.']';
				$media_id = $values['image'.$i];
				pb_media_form($input_name, $media_id);
			?>
		</div>

		<div class="form-field">
			<h4><?php _e('Headline', 'tcd-w'); ?></h4>
			<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_headline'.$i]); ?>" class="index_label" />
			<table style="margin-top:5px;">
				<tr>
					<td><?php _e('Font size', 'tcd-w'); ?></td>
					<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_size<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_headline_font_size'.$i]); ?>" class="small-text" min="0" /> px</td>
				</tr>
				<tr>
					<td><?php _e('Font size for mobile', 'tcd-w'); ?></td>
					<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_headline_font_size_mobile'.$i]); ?>" class="small-text" min="0" /> px</td>
				</tr>
				<tr>
					<td><?php _e('Font color', 'tcd-w'); ?></td>
					<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_color<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_headline_font_color'.$i]); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_headline_font_color'.$i]); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e('Font family', 'tcd-w'); ?></td>
					<td>
						<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_headline_font_family<?php echo $i; ?>]">
							<?php
								foreach($font_family_options as $key => $value) {
									$attr = '';
									if ($values['overlay_headline_font_family'.$i] == $key) {
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
			<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_content'.$i]); ?>" />
			<table style="margin-top:5px;">
				<tr>
					<td><?php _e('Font size', 'tcd-w'); ?></td>
					<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_size<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_content_font_size'.$i]); ?>" class="small-text" min="0" /> px</td>
				</tr>
				<tr>
					<td><?php _e('Font size for mobile', 'tcd-w'); ?></td>
					<td><input type="number" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_content_font_size_mobile'.$i]); ?>" class="small-text" min="0" /> px</td>
				</tr>
				<tr>
					<td><?php _e('Font color', 'tcd-w'); ?></td>
					<td><input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_color<?php echo $i; ?>]" value="<?php echo esc_attr($values['overlay_content_font_color'.$i]); ?>" class="pb-wp-color-picker" data-default-color="<?php echo esc_attr($default_values['overlay_content_font_color'.$i]); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e('Font family', 'tcd-w'); ?></td>
					<td>
						<select name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][overlay_content_font_family<?php echo $i; ?>]">
							<?php
								foreach($font_family_options as $key => $value) {
									$attr = '';
									if ($values['overlay_content_font_family'.$i] == $key) {
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
			<h4><?php _e('Link URL', 'tcd-w'); ?></h4>
			<input type="text" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][link<?php echo $i; ?>]" value="<?php echo esc_attr($values['link'.$i]); ?>" />
			<p>
				<input type="hidden" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank<?php echo $i; ?>]" value="0" />
				<label><input type="checkbox" name="pagebuilder[widget][<?php echo esc_attr($values['widget_index']); ?>][target_blank<?php echo $i; ?>]" value="1"<?php if ($values['target_blank'.$i]) echo ' checked="checked"'; ?> /> <?php _e('Use target blank for this link', 'tcd-w'); ?></label>
			</p>
		</div>
	</div>
</div>
<?php
	endfor;
}

/**
 * フロント出力
 */
function display_page_builder_widget_three_boxes($values = array()) {
	$dp_options = get_design_plus_option();

	$three_boxes_images = array();

	for ( $i = 1; $i <=3; $i++ ) :
		$image = wp_get_attachment_image_src( $values['image' . $i], 'full' );

		if ( ! empty( $image[0] ) || $values['overlay_headline' . $i] || $values['overlay_content' . $i] ) :
			$three_boxes_images[$i] = $image;
		endif;
	endfor;

	if ( $three_boxes_images ) :
?>
<div class="pb_boxes pb_boxes--<?php echo count( $three_boxes_images ); ?>">
<?php
		foreach ( $three_boxes_images as $i => $image ) :
?>
	<div class="pb_boxes_item pb_boxes_item--<?php echo $i; ?><?php if ( ! empty( $image[0] ) ) echo ' has-image'; ?>">
<?php
			if ( $values['link' . $i] ) :
?>
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $values['link' . $i] ); ?>"<?php if (!empty($values['target_blank' . $i])) echo ' target="_blank"'; ?>>
<?php
			endif;

			if ( $values['overlay_content' . $i] || $values['overlay_headline' . $i] ) :?>
			<div class="pb_boxes_item-content">
<?php
				if ( $values['overlay_content' . $i] ) :
?>
				<p class="pb_boxes_item-desc pb_font_family_<?php echo esc_attr( $values['overlay_content_font_family' . $i] ); ?>"><?php echo esc_html( $values['overlay_content' . $i] ); ?></p>
<?php
				endif;

				if ( $values['overlay_headline' . $i] ) :
?>
				<h2 class="pb_boxes_item-headline pb_font_family_<?php echo esc_attr( $values['overlay_headline_font_family' . $i] ); ?>"><?php echo esc_html( $values['overlay_headline' . $i] ); ?></h2>
<?php
				endif;
?>
			</div>
<?php
			endif;

			if ( ! empty( $image[0] ) ) :
?>
			<div class="pb_boxes_item-image p-hover-effect__image js-object-fit-cover"><img src="<?php echo esc_attr( $image[0] ); ?>" alt=""></div>
<?php
			endif;
?>
<?php
			if ( $values['link' . $i] ) :
?>
		</a>
<?php
			endif;
?>
	</div>
<?php
		endforeach;
?>
</div>
<?php
	endif;
}

/**
 * フロント用css
 */
function page_builder_widget_three_boxes_styles() {
	wp_enqueue_style('page_builder-three-boxes', get_template_directory_uri().'/pagebuilder/assets/css/three_boxes.css', false, PAGE_BUILDER_VERSION);
}

function page_builder_widget_three_boxes_sctipts_styles() {
	if (is_singular() && is_page_builder() && page_builder_has_widget('pb-widget-three-boxes')) {
		add_action('wp_enqueue_scripts', 'page_builder_widget_three_boxes_styles', 11);
		add_action('page_builder_css', 'page_builder_widget_three_boxes_css');
	}
}
add_action('wp', 'page_builder_widget_three_boxes_sctipts_styles');

function page_builder_widget_three_boxes_css() {
	// 現記事で使用しているthree_boxesコンテンツデータを取得
	$post_widgets = get_page_builder_post_widgets(get_the_ID(), 'pb-widget-three-boxes');
	if ($post_widgets) {
		$css = array();
		$css_mobile = array();

		foreach($post_widgets as $post_widget) {
			$values = $post_widget['widget_value'];

			for($i = 1; $i <=3; $i++) {
				if (!empty($values['overlay_headline'.$i])) {
					$css[] = $post_widget['css_class'].' .pb_boxes_item--'.$i.' .pb_boxes_item-headline { color: '.esc_attr($values['overlay_headline_font_color'.$i]).'; font-size: '.esc_attr($values['overlay_headline_font_size'.$i]).'px; }';
				}
				if (!empty($values['overlay_content'.$i])) {
					$css[] = $post_widget['css_class'].' .pb_boxes_item--'.$i.' .pb_boxes_item-desc { color: '.esc_attr($values['overlay_content_font_color'.$i]).'; font-size: '.esc_attr($values['overlay_content_font_size'.$i]).'px; }';
				}

				if (!empty($values['overlay_headline'.$i]) || !empty($values['overlay_content'.$i])) {
					if (!empty($values['overlay_headline'.$i])) {
						$css_mobile[] = $post_widget['css_class'].' .pb_boxes_item--'.$i.' .pb_boxes_item-headline { font-size: '.esc_attr($values['overlay_headline_font_size_mobile'.$i]).'px; }';
					}
					if (!empty($values['overlay_content'.$i])) {
						$css_mobile[] = $post_widget['css_class'].' .pb_boxes_item--'.$i.' .pb_boxes_item-desc { font-size: '.esc_attr($values['overlay_content_font_size_mobile'.$i]).'px; }';
					}
				}
			}
		}

		if ($css) {
			echo implode("\n", $css) . "\n";
		}
		if ($css_mobile) {
			echo "@media only screen and (max-width: 991px) {\n";
			echo "  " . implode("\n  ", $css_mobile) . "\n";
			echo "}\n";
		}
	}
}
