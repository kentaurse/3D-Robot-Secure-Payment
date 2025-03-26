<?php

/**
 * コンテンツビルダー コンテンツ一覧取得
 */
function cb_get_contents() {
	global $dp_options;		// $dp_optionsは保存時にWPが使用するため使えない
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	return array(
		'blog' => array(
			'name' => 'blog',
			'label' => __( 'Blog', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_headline' => __( 'Blog', 'tcd-w' ),
				'cb_headline_color' => '#000000',
				'cb_headline_font_size' => 34,
				'cb_headline_font_size_mobile' => 26,
				'cb_desc' => '',
				'cb_desc_color' => '#000000',
				'cb_desc_font_size' => 14,
				'cb_desc_font_size_mobile' => 14,
				'cb_list_type' => 'all',
				'cb_category' => 0,
				'cb_order' => 'date',
				'cb_post_num' => 6,
				'cb_show_category' => 1,
				'cb_show_date' => 1,
				'cb_exclude_item' => 1,
				'cb_show_archive_link' => 0,
				'cb_archive_link_text' => __( 'Blog archive', 'tcd-w' ),
				'cb_archive_link_font_color' => '#ffffff',
				'cb_archive_link_bg_color' => $dp_options['primary_color'],
				'cb_archive_link_font_color_hover' => '#ffffff',
				'cb_archive_link_bg_color_hover' => $dp_options['secondary_color'],
				'cb_background_color' => '#f7f7f7',
			),
			'cb_list_type_options' => array(
				'all' => __( 'All posts', 'tcd-w' ),
				'category' => __( 'Category', 'tcd-w' ),
				'recommend_post' => __( 'Recommend post', 'tcd-w' ),
				'recommend_post2' => __( 'Recommend post2', 'tcd-w' ),
				'pickup_post' => __( 'Pickup post', 'tcd-w' )
			),
			'cb_order_options' => array(
				'date' => __( 'Date (DESC)', 'tcd-w' ),
				'date2' => __( 'Date (ASC)', 'tcd-w' ),
				'random' => __( 'Random', 'tcd-w' )
			)
		),
		'banner' => array(
			'name' => 'banner',
			'label' => __( 'Banner', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_image' => '',
				'cb_headline' => '',
				'cb_headline_color' => '#000000',
				'cb_headline_font_size' => 34,
				'cb_headline_font_size_mobile' => 18,
				'cb_desc' => '',
				'cb_desc_color' => '#000000',
				'cb_desc_font_size' => 14,
				'cb_desc_font_size_mobile' => 12,
				'cb_button_label' => '',
				'cb_button_font_color' => '#ffffff',
				'cb_button_bg_color' => $dp_options['primary_color'],
				'cb_button_font_color_hover' => '#ffffff',
				'cb_button_bg_color_hover' => $dp_options['secondary_color'],
				'cb_url' => '',
				'cb_target_blank' => 0,
				'cb_background_color' => '#ffffff'
			)
		),
		'three_boxes' => array(
			'name' => 'three_boxes',
			'label' => __( 'Three boxes', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_image1' => '',
				'cb_headline1' => '',
				'cb_headline_color1' => '#000000',
				'cb_headline_font_size1' => 34,
				'cb_headline_font_size_mobile1' => 30,
				'cb_desc1' => '',
				'cb_desc_color1' => '#000000',
				'cb_desc_font_size1' => 14,
				'cb_desc_font_size_mobile1' => 12,
				'cb_url1' => '',
				'cb_target_blank1' => 0,
				'cb_image2' => '',
				'cb_headline2' => '',
				'cb_headline_color2' => '#000000',
				'cb_headline_font_size2' => 34,
				'cb_headline_font_size_mobile2' => 30,
				'cb_desc2' => '',
				'cb_desc_color2' => '#000000',
				'cb_desc_font_size2' => 14,
				'cb_desc_font_size_mobile2' => 12,
				'cb_url2' => '',
				'cb_target_blank2' => 0,
				'cb_image3' => '',
				'cb_headline3' => '',
				'cb_headline_color3' => '#000000',
				'cb_headline_font_size3' => 34,
				'cb_headline_font_size_mobile3' => 30,
				'cb_desc3' => '',
				'cb_desc_color3' => '#000000',
				'cb_desc_font_size3' => 14,
				'cb_desc_font_size_mobile3' => 12,
				'cb_url3' => '',
				'cb_target_blank3' => 0,
				'cb_background_color' => '#ffffff'
			)
		),
		'carousel' => array(
			'name' => 'carousel',
			'label' => __( 'Carousel slider', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_headline' => __( 'Products', 'tcd-w' ),
				'cb_headline_color' => '#000000',
				'cb_headline_font_size' => 34,
				'cb_headline_font_size_mobile' => 26,
				'cb_category' => defined('USCES_ITEM_CAT_PARENT_ID') ? USCES_ITEM_CAT_PARENT_ID : 0,
				'cb_order' => 'date',
				'cb_post_num' => 10,
				'cb_slide_time' => 7000,
				'cb_arrow_font_color' => '#ffffff',
				'cb_arrow_bg_color' => $dp_options['primary_color'],
				'cb_arrow_font_color_hover' => '#ffffff',
				'cb_arrow_bg_color_hover' => $dp_options['secondary_color'],
				'cb_show_archive_link' => 0,
				'cb_archive_link_text' => '',
				'cb_archive_link_font_color' => '#ffffff',
				'cb_archive_link_bg_color' => '#000000',
				'cb_archive_link_font_color_hover' => '#ffffff',
				'cb_archive_link_bg_color_hover' => $dp_options['secondary_color'],
				'cb_background_color' => '#ffffff'
			),
			'cb_order_options' => array(
				'date' => __( 'Date (DESC)', 'tcd-w' ),
				'date2' => __( 'Date (ASC)', 'tcd-w' ),
				'random' => __( 'Random', 'tcd-w' )
			),
			'cb_slide_time_options' => array(
				3000 => '3' . __( ' seconds', 'tcd-w' ),
				4000 => '4' . __( ' seconds', 'tcd-w' ),
				5000 => '5' . __( ' seconds', 'tcd-w' ),
				6000 => '6' . __( ' seconds', 'tcd-w' ),
				7000 => '7' . __( ' seconds', 'tcd-w' ),
				8000 => '8' . __( ' seconds', 'tcd-w' ),
				9000 => '9' . __( ' seconds', 'tcd-w' ),
				10000 => '10' . __( ' seconds', 'tcd-w' )
			)
		),
		'wysiwyg' => array(
			'name' => 'wysiwyg',
			'label' => __( 'Free space', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_wysiwyg_editor' => '',
				'cb_background_color' => '#ffffff'
			)
		)
	);
}

/**
 * コンテンツビルダー js/css
 */
function cb_admin_scripts() {
	wp_enqueue_style( 'tcd-cb', get_template_directory_uri() . '/admin/css/contents-builder.css', array(), version_num() );
	wp_enqueue_script( 'tcd-cb', get_template_directory_uri() . '/admin/js/contents-builder.js', array( 'jquery-ui-sortable' ), version_num(), true);
	wp_enqueue_style( 'editor-buttons' );
}
add_action( 'admin_print_scripts-appearance_page_theme_options', 'cb_admin_scripts' );
add_action( 'admin_print_scripts-toplevel_page_theme_options', 'cb_admin_scripts' );

/**
 * コンテンツビルダー入力設定
 */
function cb_inputs() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_desing_plus_option();
?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Contents Builder', 'tcd-w' ); ?></h3>
        <p><?php _e( 'Please set contents below third block of front page with contents builder.', 'tcd-w' ); ?></p>
		<div class="theme_option_message"><?php echo __( '<p>You can build contents freely with this function.</p><p>FIRST STEP: Click Add content button.<br>SECOND STEP: Select content from dropdown menu to show on each column.</p><p>You can change row by dragging MOVE button and you can delete row by clicking DELETE button.</p>', 'tcd-w' ); ?></div>

		<div id="contents_builder_wrap">
			<div id="contents_builder" data-delete-confirm="<?php _e( 'Are you sure you want to delete this content?', 'tcd-w' ); ?>">
<?php
	if ( ! empty( $dp_options['contents_builder'] ) ) :
		foreach ( $dp_options['contents_builder'] as $key => $content ) :
			$cb_index = 'cb_' . ( $key + 1 );
?>
				<div class="cb_row">
					<ul class="cb_button cf">
						<li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
						<li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
					</ul>
					<div class="cb_column_area cf">
						<div class="cb_column">
							<input type="hidden" value="<?php echo $cb_index; ?>" class="cb_index">
							<?php the_cb_content_select( $cb_index, $content['cb_content_select'] ); ?>
							<?php if ( ! empty( $content['cb_content_select'] ) ) the_cb_content_setting( $cb_index, $content['cb_content_select'], $content ); ?>
						</div>
					</div><!-- END .cb_column_area -->
				</div><!-- END .cb_row -->
<?php
		endforeach;
	endif;
?>
			</div><!-- END #contents_builder -->
			<div id="cb_add_row_buttton_area">
				<input type="button" value="<?php echo __( 'Add content', 'tcd-w' ); ?>" class="button-secondary add_row">
			</div>
			<p><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></p>
		</div><!-- END #contents_builder_wrap -->

<?php
	// コンテンツビルダー追加用 非表示
	$cb_index = 'cb_cloneindex';
?>
		<div id="contents_builder-clone" class="hidden">
			<div class="cb_row">
				<ul class="cb_button cf">
					<li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
					<li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
				</ul>
				<div class="cb_column_area cf">
					<div class="cb_column">
						<input type="hidden" class="cb_index" value="cb_cloneindex">
						<?php the_cb_content_select( $cb_index ); ?>
					</div>
				</div><!-- END .cb_column_area -->
			</div><!-- END .cb_row -->
<?php
	foreach ( cb_get_contents() as $key => $value ) :
		the_cb_content_setting( 'cb_cloneindex', $key );
	endforeach;
?>
		</div><!-- END #contents_builder-clone.hidden -->
	</div>
<?php
}

/**
 * コンテンツビルダー用 コンテンツ選択プルダウン
 */
function the_cb_content_select( $cb_index = 'cb_cloneindex', $selected = null ) {
	$cb_contents = cb_get_contents();

	if ( $selected && isset( $cb_contents[$selected] ) ) {
		$add_class = ' hidden';
	} else {
		$add_class = '';
	}

	$out = '<select name="dp_options[contents_builder][' . esc_attr( $cb_index ) . '][cb_content_select]" class="cb_content_select' . $add_class . '">';
	$out .= '<option value="">' . __( 'Choose the content', 'tcd-w' ) . '</option>';

	foreach ( $cb_contents as $key => $value ) {
		$out .= '<option value="' . esc_attr( $key ) . '"' . selected( $key, $selected, false ) . '>' . esc_html( $value['label'] ) . '</option>';
	}

	$out .= '</select>';

	echo $out;
}

/**
 * コンテンツビルダー用 コンテンツ設定
 */
function the_cb_content_setting( $cb_index = 'cb_cloneindex', $cb_content_select = null, $value = array() ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_desing_plus_option();

	$cb_contents = cb_get_contents();

	// 不明なコンテンツの場合は終了
	if ( ! $cb_content_select || ! isset( $cb_contents[$cb_content_select] ) ) return false;

	// コンテンツデフォルト値に入力値をマージ
	if ( isset( $cb_contents[$cb_content_select]['default'] ) ) {
		$value = array_merge( (array) $cb_contents[$cb_content_select]['default'], $value );
	}
?>
	<div class="cb_content_wrap cf cb_content-<?php echo esc_attr( $cb_content_select ); ?>">

<?php
	// 最新ブログ記事一覧
	if ( 'blog' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
            <p><?php _e( 'This is posts list of blog.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set the heading.', 'tcd-w' ); ?></p>

			<input type="text" class="large-text change_content_headline" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline]" value="<?php echo esc_attr( $value['cb_headline'] ); ?>">
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color]" value="<?php echo esc_attr( $value['cb_headline_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_headline_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size]" value="<?php echo esc_attr( $value['cb_headline_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set a description. It is displayed to the right of the heading.', 'tcd-w' ); ?></p>

			<input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc]" value="<?php echo esc_attr( $value['cb_desc'] ); ?>">
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_color]" value="<?php echo esc_attr( $value['cb_desc_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_desc_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size]" value="<?php echo esc_attr( $value['cb_desc_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size_mobile]" value="<?php echo esc_attr( $value['cb_desc_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
<?php
		if ( ! empty( $cb_contents[$cb_content_select]['cb_list_type_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post type', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Select the type of post you want to display.', 'tcd-w' ); ?></p>
            <p class="description"><?php _e( 'Recommended posts and Pickup posts can be set from post edit screen / quick edit.', 'tcd-w' ); ?></p>
			<ul class="cb_list_type-radios">
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_list_type_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_list_type]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_list_type'], $k, false ) . '> '. esc_html( $v ) . '</label>';
				if ( 'category' == $k ) :
					echo '&nbsp;&nbsp;';
					wp_dropdown_categories( array(
						'class' => '',
						'echo' => 1,
						'hide_empty' => 0,
						'hierarchical' => 1,
						'id' => '',
						'name' => 'dp_options[contents_builder][' . $cb_index . '][cb_category]',
						'selected' => $value['cb_category'],
						'show_count' => 0,
						'value_field' => 'term_id'
					) );
				endif;
				echo '</li>';
			endforeach;
?>
			</ul>
<?php
		endif;

		if ( ! empty( $cb_contents[$cb_content_select]['cb_order_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Display order', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Select the order of the post from date (DESC) or date (ASC) or random.', 'tcd-w' ); ?></p>
			<ul>
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_order_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_order]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_order'], $k, false ) . '> '. esc_html( $v ) . '</label></li>';
			endforeach;
?>
			</ul>
<?php
		endif;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post number', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set the number of displayed articles', 'tcd-w' ); ?></p>
			<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_post_num]" value="<?php echo esc_attr( $value['cb_post_num'] ); ?>" min="1">
			<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set the display of each item.', 'tcd-w' ); ?></p>
			<ul>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="checkbox" value="1" <?php checked( $value['cb_show_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="checkbox" value="1" <?php checked( $value['cb_show_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_exclude_item]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_exclude_item]" type="checkbox" value="1" <?php checked( $value['cb_exclude_item'], 1 ); ?>><?php _e( 'Exclude welcart items', 'tcd-w' ); ?></label>
				</li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the button to archive page displayed at upper right corner of the post list. ', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_archive_link]" type="checkbox" value="1" <?php checked( $value['cb_show_archive_link'], 1 ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
			<table>
				<tr>
					<td><label><?php _e( 'Archive link label', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_text]" value="<?php echo esc_attr( $value['cb_archive_link_text'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color]" value="<?php echo esc_attr( $value['cb_archive_link_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_font_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_font_color_hover']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color_hover']); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set the background color of the contents.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_background_color']); ?>">

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// バナー
	elseif ( 'banner' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
            <p><?php _e( 'This shows the banner that consists of full width image, text and button. ', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
			<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1200, 350 ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js cb_image">
					<input type="hidden" value="<?php echo esc_attr( $value['cb_image'] ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_image]" class="cf_media_id">
					<div class="preview_field"><?php if ( $value['cb_image'] ) { echo wp_get_attachment_image( $value['cb_image'], 'medium' ); } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_image'] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the headline on the left side of the image.', 'tcd-w' ); ?></p>
			<input type="text" class="large-text change_content_headline" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline]" value="<?php echo esc_attr( $value['cb_headline'] ); ?>">
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color]" value="<?php echo esc_attr( $value['cb_headline_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_headline_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size]" value="<?php echo esc_attr( $value['cb_headline_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the description above the heading on the left side of the image.', 'tcd-w' ); ?></p>
			<input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc]" value="<?php echo esc_attr( $value['cb_desc'] ); ?>">
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_color]" value="<?php echo esc_attr( $value['cb_desc_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_desc_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size]" value="<?php echo esc_attr( $value['cb_desc_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size_mobile]" value="<?php echo esc_attr( $value['cb_desc_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the button below the heading on the left side of the image.', 'tcd-w' ); ?></p>
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Button label', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_button_label]" value="<?php echo esc_attr( $value['cb_button_label'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_button_font_color]" value="<?php echo esc_attr( $value['cb_button_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_button_font_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_button_bg_color]" value="<?php echo esc_attr( $value['cb_button_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_button_bg_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_button_font_color_hover]" value="<?php echo esc_attr( $value['cb_button_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_button_font_color_hover']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_button_bg_color_hover]" value="<?php echo esc_attr( $value['cb_button_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_button_bg_color_hover']); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set destination url.', 'tcd-w' ); ?></p>
			<input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_url]" value="<?php echo esc_attr( $value['cb_url'] ); ?>">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_target_blank]" type="checkbox" value="1" <?php checked( $value['cb_target_blank'], 1 ); ?>> <?php _e('Use target blank for this link', 'tcd-w'); ?></label></p>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set the background color of the contents.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_background_color']); ?>">

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// 3点ボックス
	elseif ( 'three_boxes' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
            <p><?php _e( 'Display three content boxes horizontally.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

<?php
		for ( $i = 1; $i <= 3; $i++ ) :
?>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php printf( __( 'Box%d setting', 'tcd-w' ), $i ); ?></h3>
				<div class="sub_box_content">
					<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
					<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 380, 240 ); ?></p>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js cb_image<?php echo $i; ?>">
							<input type="hidden" value="<?php echo esc_attr( $value['cb_image' . $i] ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_image<?php echo $i; ?>]" class="cf_media_id">
							<div class="preview_field"><?php if ( $value['cb_image' . $i] ) { echo wp_get_attachment_image( $value['cb_image' . $i], 'medium' ); } ?></div>
							<div class="button_area">
								<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_image' . $i] ) { echo 'hidden'; } ?>">
							</div>
						</div>
					</div>
					<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
                    <p><?php _e( 'Settings for heading at left top of image', 'tcd-w' ); ?></p>
					<input type="text" class="large-text change_content_headline" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_headline' . $i] ); ?>">
					<table style="margin-top: 5px;">
						<tr>
							<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
							<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_headline_color' . $i] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_headline_color' . $i]); ?>"></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
							<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_headline_font_size' . $i] ); ?>" min="1"><span>px</span></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
							<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile' . $i] ); ?>" min="1"><span>px</span></td>
						</tr>
					</table>
					<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
                    <p><?php _e( 'Settings for description at left top of image, above heading', 'tcd-w' ); ?></p>
					<input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_desc' . $i] ); ?>">
					<table style="margin-top: 5px;">
						<tr>
							<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
							<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_color<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_desc_color' . $i] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_desc_color' . $i]); ?>"></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
							<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_desc_font_size' . $i] ); ?>" min="1"><span>px</span></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
							<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_desc_font_size_mobile' . $i] ); ?>" min="1"><span>px</span></td>
						</tr>
					</table>
					<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
                    <p><?php _e( 'You can set destination url.', 'tcd-w' ); ?></p>
                  
					<input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_url<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_url' . $i] ); ?>">
					<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_target_blank<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( $value['cb_target_blank' . $i], 1 ); ?>> <?php _e('Use target blank for this link', 'tcd-w'); ?></label></p>
				</div>
			</div>
<?php
		endfor;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set the background color of the contents.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_background_color']); ?>">

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// カルーセル
	elseif ( 'carousel' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
            <p><?php _e( 'This slider shows posts list or items list.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set the heading.', 'tcd-w' ); ?></p>
			<input type="text" class="large-text change_content_headline" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline]" value="<?php echo esc_attr( $value['cb_headline'] ); ?>">
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color]" value="<?php echo esc_attr( $value['cb_headline_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_headline_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size]" value="<?php echo esc_attr( $value['cb_headline_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Category', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Select the category to display.', 'tcd-w' ); ?></p>
			<p>
<?php
		wp_dropdown_categories( array(
			'class' => '',
			'echo' => 1,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'id' => '',
			'name' => 'dp_options[contents_builder][' . $cb_index . '][cb_category]',
			'selected' => $value['cb_category'],
			'show_count' => 0,
			'show_option_all' => __( 'All categories', 'tcd-w' ),
			'value_field' => 'term_id'
		) );
?>
			</p>
<?php
		if ( ! empty( $cb_contents[$cb_content_select]['cb_order_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Display order', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Select the order of the post from date (DESC) or date (ASC) or random.', 'tcd-w' ); ?></p>
			<ul>
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_order_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_order]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_order'], $k, false ) . '> '. esc_html( $v ) . '</label></li>';
			endforeach;
?>
			</ul>
<?php
		endif;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post number', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Set the number of displayed articles', 'tcd-w' ); ?></p>
			<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_post_num]" value="<?php echo esc_attr( $value['cb_post_num'] ); ?>" min="1">
<?php
		if ( ! empty( $cb_contents[$cb_content_select]['cb_slide_time_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Slide speed', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set transition speed. (3 to 10 seconds)', 'tcd-w' ); ?></p>
			<select name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_slide_time]">
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_slide_time_options'] as $k => $v ) :
				echo '<option value="' . esc_attr( $k ) . '" ' . selected( $value['cb_slide_time'], $k, false ) . '> '. esc_html( $v ) . '</option>';
			endforeach;
?>
			</select>
<?php
		endif;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Arrow setting', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set arrow button on slider.', 'tcd-w' ); ?></p>
			<table>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_arrow_font_color]" value="<?php echo esc_attr( $value['cb_arrow_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_arrow_font_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_arrow_bg_color]" value="<?php echo esc_attr( $value['cb_arrow_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_arrow_bg_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_arrow_font_color_hover]" value="<?php echo esc_attr( $value['cb_arrow_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_arrow_font_color_hover']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_arrow_bg_color_hover]" value="<?php echo esc_attr( $value['cb_arrow_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_arrow_bg_color_hover']); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
            <p><?php _e( 'You can set the button to recommended product page displayed at right of headline. Link to the category archive page selected in category selection.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_archive_link]" type="checkbox" value="1" <?php checked( $value['cb_show_archive_link'], 1 ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
			<table>
				<tr>
					<td><label><?php _e( 'Archive link label', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_text]" value="<?php echo esc_attr( $value['cb_archive_link_text'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color]" value="<?php echo esc_attr( $value['cb_archive_link_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_font_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_font_color_hover']); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color_hover']); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set the background color of the contents.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_background_color']); ?>">

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// フリーススペース
	elseif ( 'wysiwyg' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php _e( 'WYSIWYG editor', 'tcd-w' ); ?><span></span></h3>
		<div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<?php
				wp_editor(
					$value['cb_wysiwyg_editor'],
					'cb_wysiwyg_editor-' . $cb_index,
					array(
						'textarea_name' => 'dp_options[contents_builder][' . $cb_index . '][cb_wysiwyg_editor]',
						'textarea_rows' => 10,
						'editor_class' => 'change_content_headline'
					)
				);
			?>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
            <p><?php _e( 'Please set the background color of the contents.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr($cb_contents[$cb_content_select]['default']['cb_background_color']); ?>">

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>
<?php
	else :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_content_select ); ?></h3>
		<div class="cb_content">
			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>
<?php
	endif;
?>
	</div><!-- END .cb_content_wrap -->
<?php
}

/**
 * コンテンツビルダー用 保存整形
 */
function cb_validate( $input = array() ) {
	if ( ! empty( $input['contents_builder'] ) ) {
		$cb_contents = cb_get_contents();
		$cb_data = array();

		foreach ( $input['contents_builder'] as $key => $value ) {
			// クローン用はスルー
			if ( in_array( $key, array( 'cb_cloneindex', 'cb_cloneindex2' ), true ) ) continue;

			// コンテンツデフォルト値に入力値をマージ
			if ( ! empty( $value['cb_content_select'] ) && isset( $cb_contents[$value['cb_content_select']]['default'] ) ) {
				$value = array_merge( (array) $cb_contents[$value['cb_content_select']]['default'], $value );
			}

			// 最新ブログ記事一覧
			if ( 'blog' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_headline'] = wp_filter_nohtml_kses( $value['cb_headline'] );
				$value['cb_headline_color'] = wp_filter_nohtml_kses( $value['cb_headline_color'] );
				$value['cb_headline_font_size'] = intval( $value['cb_headline_font_size'] );
				$value['cb_headline_font_size_mobile'] = intval( $value['cb_headline_font_size_mobile'] );
				$value['cb_desc'] = wp_filter_nohtml_kses( $value['cb_desc'] );
				$value['cb_desc_color'] = wp_filter_nohtml_kses( $value['cb_desc_color'] );
				$value['cb_desc_font_size'] = intval( $value['cb_desc_font_size'] );
				$value['cb_desc_font_size_mobile'] = intval( $value['cb_desc_font_size_mobile'] );
				$value['cb_category'] = intval( $value['cb_category'] );
				$value['cb_post_num'] = intval( $value['cb_post_num'] );
				$value['cb_show_category'] = ! empty( $value['cb_show_category'] ) ? 1 : 0;
				$value['cb_show_date'] = ! empty( $value['cb_show_date'] ) ? 1 : 0;
				$value['cb_exclude_item'] = ! empty( $value['cb_exclude_item'] ) ? 1 : 0;
				$value['cb_show_archive_link'] = ! empty( $value['cb_show_archive_link'] ) ? 1 : 0;
				$value['cb_archive_link_text'] = wp_filter_nohtml_kses( $value['cb_archive_link_text'] );
				$value['cb_archive_link_font_color'] = wp_filter_nohtml_kses( $value['cb_archive_link_font_color'] );
				$value['cb_archive_link_bg_color'] = wp_filter_nohtml_kses( $value['cb_archive_link_bg_color'] );
				$value['cb_archive_link_font_color_hover'] = wp_filter_nohtml_kses( $value['cb_archive_link_font_color_hover'] );
				$value['cb_archive_link_bg_color_hover'] = wp_filter_nohtml_kses( $value['cb_archive_link_bg_color_hover'] );
				$value['cb_background_color'] = wp_filter_nohtml_kses( $value['cb_background_color'] );

				if ( ! empty( $value['cb_list_type'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_list_type_options'][$value['cb_list_type']] ) ) {
					$value['cb_list_type'] = null;
				}
				if ( empty( $value['cb_list_type'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_list_type'] ) ) {
					$value['cb_list_type'] = $cb_contents[$value['cb_content_select']]['default']['cb_list_type'];
				}

				if ( ! empty( $value['cb_order'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_order_options'][$value['cb_order']] ) ) {
					$value['cb_order'] = null;
				}
				if ( empty( $value['cb_order'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_order'] ) ) {
					$value['cb_order'] = $cb_contents[$value['cb_content_select']]['default']['cb_order'];
				}

			// バナー
			} elseif ( 'banner' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty($value['cb_display'] ) ? 1 : 0;
				$value['cb_image'] = intval( $value['cb_image'] );
				$value['cb_headline'] = wp_filter_nohtml_kses( $value['cb_headline'] );
				$value['cb_headline_color'] = wp_filter_nohtml_kses( $value['cb_headline_color'] );
				$value['cb_headline_font_size'] = intval( $value['cb_headline_font_size'] );
				$value['cb_headline_font_size_mobile'] = intval( $value['cb_headline_font_size_mobile'] );
				$value['cb_desc'] = wp_filter_nohtml_kses( $value['cb_desc'] );
				$value['cb_desc_color'] = wp_filter_nohtml_kses( $value['cb_desc_color'] );
				$value['cb_desc_font_size'] = intval( $value['cb_desc_font_size'] );
				$value['cb_desc_font_size_mobile'] = intval( $value['cb_desc_font_size_mobile'] );
				$value['cb_button_label'] = wp_filter_nohtml_kses( $value['cb_button_label'] );
				$value['cb_button_font_color'] = wp_filter_nohtml_kses( $value['cb_button_font_color'] );
				$value['cb_button_bg_color'] = wp_filter_nohtml_kses( $value['cb_button_bg_color'] );
				$value['cb_button_font_color_hover'] = wp_filter_nohtml_kses( $value['cb_button_font_color_hover'] );
				$value['cb_button_bg_color_hover'] = wp_filter_nohtml_kses( $value['cb_button_bg_color_hover'] );
				$value['cb_url'] = wp_filter_nohtml_kses( $value['cb_url'] );
				$value['cb_target_blank'] = ! empty( $value['cb_target_blank'] ) ? 1 : 0;
				$value['cb_background_color'] = wp_filter_nohtml_kses( $value['cb_background_color'] );

			// 3点ボックス
			} elseif ( 'three_boxes' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_background_color'] = wp_filter_nohtml_kses( $value['cb_background_color'] );
				for ( $i = 1; $i <=3; $i++ ) {
					$value['cb_image' . $i] = intval( $value['cb_image' . $i] );
					$value['cb_headline' . $i] = wp_filter_nohtml_kses( $value['cb_headline' . $i] );
					$value['cb_headline_color' . $i] = wp_filter_nohtml_kses( $value['cb_headline_color' . $i] );
					$value['cb_headline_font_size' . $i] = intval( $value['cb_headline_font_size' . $i] );
					$value['cb_headline_font_size_mobile' . $i] = intval( $value['cb_headline_font_size_mobile' . $i] );
					$value['cb_desc' . $i] = wp_filter_nohtml_kses( $value['cb_desc' . $i] );
					$value['cb_desc_color' . $i] = wp_filter_nohtml_kses( $value['cb_desc_color' . $i] );
					$value['cb_desc_font_size' . $i] = intval( $value['cb_desc_font_size' . $i] );
					$value['cb_desc_font_size_mobile' . $i] = intval( $value['cb_desc_font_size_mobile' . $i] );
					$value['cb_url' . $i] = wp_filter_nohtml_kses( $value['cb_url' . $i] );
					$value['cb_target_blank' . $i] = ! empty( $value['cb_target_blank' . $i] ) ? 1 : 0;
				}

			// カルーセル
			} elseif ( 'carousel' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_headline'] = wp_filter_nohtml_kses( $value['cb_headline'] );
				$value['cb_headline_color'] = wp_filter_nohtml_kses( $value['cb_headline_color'] );
				$value['cb_headline_font_size'] = intval( $value['cb_headline_font_size'] );
				$value['cb_headline_font_size_mobile'] = intval( $value['cb_headline_font_size_mobile'] );
				$value['cb_category'] = intval( $value['cb_category'] );
				$value['cb_post_num'] = intval( $value['cb_post_num'] );
				$value['cb_arrow_font_color'] = wp_filter_nohtml_kses( $value['cb_arrow_font_color'] );
				$value['cb_arrow_bg_color'] = wp_filter_nohtml_kses( $value['cb_arrow_bg_color'] );
				$value['cb_arrow_font_color_hover'] = wp_filter_nohtml_kses( $value['cb_arrow_font_color_hover'] );
				$value['cb_arrow_bg_color_hover'] = wp_filter_nohtml_kses( $value['cb_arrow_bg_color_hover'] );
				$value['cb_show_archive_link'] = ! empty( $value['cb_show_archive_link'] ) ? 1 : 0;
				$value['cb_archive_link_text'] = wp_filter_nohtml_kses( $value['cb_archive_link_text'] );
				$value['cb_archive_link_font_color'] = wp_filter_nohtml_kses( $value['cb_archive_link_font_color'] );
				$value['cb_archive_link_bg_color'] = wp_filter_nohtml_kses( $value['cb_archive_link_bg_color'] );
				$value['cb_archive_link_font_color_hover'] = wp_filter_nohtml_kses( $value['cb_archive_link_font_color_hover'] );
				$value['cb_archive_link_bg_color_hover'] = wp_filter_nohtml_kses( $value['cb_archive_link_bg_color_hover'] );
				$value['cb_background_color'] = wp_filter_nohtml_kses( $value['cb_background_color'] );

				if ( ! empty( $value['cb_order'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_order_options'][$value['cb_order']] ) ) {
					$value['cb_order'] = null;
				}
				if ( empty( $value['cb_order'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_order'] ) ) {
					$value['cb_order'] = $cb_contents[$value['cb_content_select']]['default']['cb_order'];
				}

				if ( ! empty( $value['cb_slide_time'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_slide_time_options'][$value['cb_slide_time']] ) ) {
					$value['cb_slide_time'] = null;
				}
				if ( empty( $value['cb_slide_time'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_slide_time'] ) ) {
					$value['cb_slide_time'] = $cb_contents[$value['cb_content_select']]['default']['cb_slide_time'];
				}

			// フリースペース
			} elseif ( 'wysiwyg' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_background_color'] = wp_filter_nohtml_kses( $value['cb_background_color'] );
			}

			$cb_data[] = $value;
		}

		$input['contents_builder'] = $cb_data;
	}

	return $input;
}

/**
 * クローン用のリッチエディター化処理をしないようにする
 * クローン後のリッチエディター化はjsで行う
 */
function cb_tiny_mce_before_init( $mceInit, $editor_id ) {
	if ( strpos( $editor_id, 'cb_cloneindex' ) !== false ) {
		$mceInit['wp_skip_init'] = true;
	}
	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'cb_tiny_mce_before_init', 10, 2 );
