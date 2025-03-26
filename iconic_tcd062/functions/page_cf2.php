<?php

function tcd_page_meta_box2() {
	// Welcartのページの場合は表示しない
	global $post;
	$usces_cart_number = get_option( 'usces_cart_number' );
	$usces_member_number = get_option( 'usces_member_number' );
	if ( ! empty( $post->ID ) && ( $post->ID == $usces_cart_number || $post->ID == $usces_member_number ) ) {
		return;
	}

	add_meta_box(
		'tcd_page_meta_box2', // ID of meta box
		__( 'Header image for page', 'tcd-w' ), // label
		'show_tcd_page_meta_box2', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_meta_box2' );

function show_tcd_page_meta_box2( $post ) {

	$page_header_image = array(
		'name' => __( 'Header image', 'tcd-w' ),
		'desc' => sprintf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1450, 600 ),
		'id' => 'page_header_image',
		'type' => 'image',
		'std' => ''
	);

	// 画像の上に重ねる色
	$page_overlay = array(
		'name' => __( 'Color of overlay', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_overlay',
		'type' => 'input',
		'std' => '#000000'
	);
	$page_overlay_meta = $post->page_overlay;

	// 画像の上に重ねる色の透過率
	$page_overlay_opacity = array(
		'name' => __( 'Opacity of overlay', 'tcd-w' ),
		'desc' => __( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ),
		'id' => 'page_overlay_opacity',
		'type' => 'input',
		'std' => '0.5'
	);
	$page_overlay_opacity_meta = $post->page_overlay_opacity;

	// キャッチフレーズ
	$page_headline = array(
		'name' => __( 'Catchphrase', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline',
		'type' => 'input',
		'std' => ''
	);
	$page_headline_meta = $post->page_headline;

	// キャッチフレーズのフォントサイズ
	$page_headline_font_size = array(
		'name' => __( 'Font size', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_font_size',
		'type' => 'input',
		'std' => 30
	);
	$page_headline_font_size_meta = $post->page_headline_font_size;

	// 説明文
	$page_desc = array(
		'name' => __( 'Description', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_desc',
		'type' => 'textarea',
		'std' => ''
	);
	$page_desc_meta = $post->page_desc;

	// 説明文のフォントサイズ
	$page_desc_font_size = array(
		'name' => __( 'Font size', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_desc_font_size',
		'type' => 'input',
		'std' => 14
	);
	$page_desc_font_size_meta = $post->page_desc_font_size;

	// フォントの色
	$font_color = array(
		'name' => __( 'Font color', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_color',
		'type' => 'input',
		'std' => '#FFFFFF'
	);
	$font_color_meta = $post->page_headline_color;

	// ドロップシャドウ
	$shadow1 = array(
		'name' => __( 'Dropshadow position (left)', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_shadow1',
		'type' => 'input',
		'std' => 0
	);
	$shadow1_meta = $post->page_headline_shadow1;

	$shadow2 = array(
		'name' => __( 'Dropshadow position (top)', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_shadow2',
		'type' => 'input',
		'std' => 0
	);
	$shadow2_meta = $post->page_headline_shadow2;

	$shadow3 = array(
		'name' => __( 'Dropshadow size', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_shadow3',
		'type' => 'input',
		'std' => 0
	);
	$shadow3_meta = $post->page_headline_shadow3;

	$shadow4 = array(
		'name' => __( 'Dropshadow color', 'tcd-w' ),
		'desc' => '',
		'id' => 'page_headline_shadow4',
		'type' => 'input',
		'std' => '#999999'
	);
	$shadow4_meta = $post->page_headline_shadow4;

	echo '<input type="hidden" name="tcd_page_meta_box2_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">';

	echo '<dt class="label"><label>' . esc_html( $page_header_image['name'] ) ,'</label></dt>';
	echo '<dd class="content"><p class="desc">' . esc_html( $page_header_image['desc'] ) . '</p>';
	tcd_cf_media_form( 'page_header_image', __( 'Image', 'tcd-w' ) );
	echo '</dd>';

	// 画像の上に重ねる色
	echo '<dt class="label"><label for="' . esc_attr( $page_overlay['id'] ) . '">' . esc_html( $page_overlay['name'] ) . '</label></dt>';
	echo '<dd class="content">';
	echo '<input type="text" name="' . esc_attr( $page_overlay['id'] ) . '" value="' . esc_attr( $page_overlay_meta ? $page_overlay_meta : $page_overlay['std'] ) . '" data-default-color="' . esc_attr( $page_overlay['std'] ) . '" class="c-color-picker">';
	echo '</dd>';

	// 画像の上に重ねる色の透過率
	echo '<dt class="label"><label for="' . esc_attr( $page_overlay_opacity['id'] ) . '">' . esc_html( $page_overlay_opacity['name'] ) . '</label></dt>';
	echo '<dd class="content"><p class="desc">' . esc_html( $page_overlay_opacity['desc'] ) . '</p>';
	if(isset($page_overlay_opacity_meta)){ $page_overlay_opacity_meta=(float)$page_overlay_opacity_meta; }else{ $page_overlay_opacity_meta=$page_overlay_opacity['std']; }
	echo '<input type="number" class="small-text" name="' . esc_attr( $page_overlay_opacity['id'] ) . '" id="' . esc_attr( $page_overlay_opacity['id'] ) . '" value="' . esc_attr( $page_overlay_opacity_meta ) . '" min="0" max="1" step="0.1">';
	echo '</dd>';

	// キャッチフレーズ
	echo '<dt class="label"><label for="' . esc_attr( $page_headline['id'] ) . '">' . esc_html( $page_headline['name'] ) . '</label></dt>';
	echo '<dd class="content">';
	echo '<input type="text" class="large-text" name="' . esc_attr( $page_headline['id'] ) . '" id="' . esc_attr( $page_headline['id'] ) . '" value="' . esc_attr( $page_headline_meta ? $page_headline_meta : $page_headline['std'] ) . '">';
	echo '<p><label for="' . esc_attr( $page_headline_font_size['id'] ) . '">' . esc_html( $page_headline_font_size['name'] ) . '</label> <input type="number" name="' . esc_attr( $page_headline_font_size['id'] ) . '" id="' . esc_attr( $page_headline_font_size['id'] ) . '" value="' . esc_attr( $page_headline_font_size_meta ? $page_headline_font_size_meta : $page_headline_font_size['std'] ) . '" size="30" class="small-text" min="0"> px</p>';
	echo '</dd>';

	// 説明文
	echo '<dt class="label"><label for="' . esc_attr( $page_desc['id'] ) . '">' . esc_html( $page_desc['name'] ) . '</label></dt>';
	echo '<dd class="content">';
	echo '<textarea class="large-text" name="' . esc_attr( $page_desc['id'] ) . '" id="' . esc_attr( $page_desc['id'] ) . '" cols="60" rows="4">' . esc_textarea( $page_desc_meta ? $page_desc_meta : $page_desc['std'] ) . '</textarea>';
	echo '<p><label for="' . esc_attr( $page_desc_font_size['id'] ) . '">' . esc_html( $page_desc_font_size['name'] ) . '</label> <input type="number" name="' . esc_attr( $page_desc_font_size['id'] ) . '" id="' . esc_attr( $page_desc_font_size['id'] ) . '" value="' . esc_attr( $page_desc_font_size_meta ? $page_desc_font_size_meta : $page_desc_font_size['std'] ) . '" size="30" class="small-text" min="0">px';
	echo '</dd>';

	// フォントの色
	echo '<dt class="label"><label for="' . esc_attr( $font_color['id'] ) . '">' . esc_html( $font_color['name'] ) . '</label></dt>';
	echo '<dd class="content">';
	echo '<input type="text" name="' . esc_attr( $font_color['id'] ) . '" value="' . esc_attr( $font_color_meta ? $font_color_meta : $font_color['std'] ) . '" data-default-color="' . esc_attr( $font_color['std'] ) . '" class="c-color-picker">';
	echo '</dd>';

	// ドロップシャドウ
	echo '<dt class="label"><label for="' . esc_attr( $shadow1['id'] ) . '">' . esc_html( $shadow1['name'] ) . '</label></dt>';
	echo '<dd class="content"><input type="number" name="' . esc_attr( $shadow1['id'] ) . '" id="' . esc_attr( $shadow1['id'] ) . '" value="' . esc_attr( $shadow1_meta ? $shadow1_meta : $shadow1['std'] ) . '" size="30" class="small-text" min="0">px</dd>';
	echo '<dt class="label"><label for="' . esc_attr( $shadow2['id'] ) . '">' . esc_html( $shadow2['name'] ) . '</label></dt>';
	echo '<dd class="content"><input type="number" name="' . esc_attr( $shadow2['id'] ) . '" id="' . esc_attr( $shadow2['id'] ) . '" value="' . esc_attr( $shadow2_meta ? $shadow2_meta : $shadow2['std'] ) . '" size="30" class="small-text" min="0">px</dd>';
	echo '<dt class="label"><label for="' . esc_attr( $shadow3['id'] ) . '">' . esc_html( $shadow3['name'] ) . '</label></dt>';
	echo '<dd class="content"><input type="number" name="' . esc_attr( $shadow3['id'] ) . '" id="' . esc_attr( $shadow3['id'] ) . '" value="' . esc_attr( $shadow3_meta ? $shadow3_meta : $shadow3['std'] ) . '" size="30" class="small-text" min="0">px</dd>';
	echo '<dt class="label"><label for="' . esc_attr( $shadow4['id'] ) . '">' . esc_html( $shadow4['name'] ) . '</label></dt>';

	echo '<dd class="content">';
	echo '<input type="text" name="' . esc_attr( $shadow4['id'] ) . '" value="' . esc_attr( $shadow4_meta ? $shadow4_meta : $shadow4['std'] ) . '" data-default-color="' . esc_attr( $shadow4['std'] ) . '" class="c-color-picker">';
	echo '</dd>';

	echo '</dl>';
}

function save_tcd_page_meta_box2( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_meta_box2_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_meta_box2_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// save or delete
	$cf_keys = array(
		'page_header_image',
		'page_overlay',
		'page_overlay_opacity',
		'page_headline',
		'page_headline_font_size',
		'page_desc',
		'page_desc_font_size',
		'page_headline_color',
		'page_headline_shadow1',
		'page_headline_shadow2',
		'page_headline_shadow3',
		'page_headline_shadow4'
	);
	foreach ( $cf_keys as $cf_key ) {
		$old = get_post_meta( $post_id, $cf_key, true );
		$new = isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '';
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $cf_key, $new );
		} elseif ( ! $new && $old ) {
			delete_post_meta( $post_id, $cf_key, $old );
		}
	}
}
add_action( 'save_post', 'save_tcd_page_meta_box2' );

/* フォーム用 画像フィールド出力 */
function tcd_cf_media_form( $cf_key, $label ) {
	global $post;
	if ( empty( $cf_key ) ) return false;
	if ( empty( $label ) ) $label = $cf_key;
	$media_id = get_post_meta( $post->ID, $cf_key, true );
?>
<div class="cf cf_media_field hide-if-no-js <?php echo esc_attr( $cf_key ); ?>">
		<input type="hidden" class="cf_media_id" name="<?php echo esc_attr( $cf_key ); ?>" id="<?php echo esc_attr( $cf_key ); ?>" value="<?php echo esc_attr( $media_id ); ?>">
	<div class="preview_field"><?php if ( $media_id ) the_tcd_cf_image( $post->ID, $cf_key ); ?></div>
	<div class="button_area">
		<input type="button" class="cfmf-select-img button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>">
		<input type="button" class="cfmf-delete-img button<?php if ( ! $media_id ) echo ' hidden'; ?>" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>">
	</div>
</div>
<?php
}

/* 画像フィールドで選択された画像をimgタグで出力 */
function the_tcd_cf_image( $post_id, $cf_key, $image_size = 'medium' ) {
	echo get_tcd_cf_image( $post_id, $cf_key, $image_size );
}

/* 画像フィールドで選択された画像をimgタグで返す */
function get_tcd_cf_image( $post_id, $cf_key, $image_size = 'medium' ) {
	global $post;
	if ( empty( $cf_key ) ) return false;
	if ( empty( $post_id ) ) $post_id = $post->ID;

	$media_id = get_post_meta( $post_id, $cf_key, true );
	if ( $media_id ) {
		return wp_get_attachment_image( $media_id, $image_size, $image_size );
	}
	return false;
}

/* 画像フィールドで選択された画像urlを返す */
function get_tcd_cf_image_url( $post_id, $cf_key, $image_size = 'medium' ) {
	global $post;
	if ( empty( $cf_key ) ) return false;
	if ( empty( $post_id ) ) $post_id = $post->ID;

	$media_id = get_post_meta( $post_id, $cf_key, true );
	if ( $media_id ) {
		$img = wp_get_attachment_image_src( $media_id, $image_size );
		if ( ! empty( $img[0] ) ) {
			return $img[0];
		}
	}
	return false;
}

/* 画像フィールドで選択されたメディアのURLを出力 */
function the_tcd_cf_media_url( $post_id, $cf_key ) {
	echo get_tcd_cf_media_url( $post_id, $cf_key );
}

/* 画像フィールドで選択されたメディアのURLを返す */
function get_tcd_cf_media_url( $post_id, $cf_key ) {
	global $post;
	if ( empty( $cf_key ) ) return false;
	if ( empty( $post_id ) ) $post_id = $post->ID;

	$media_id = get_post_meta( $post_id, $cf_key, true );
	if ( $media_id ) {
		return wp_get_attachment_url( $media_id );
	}
	return false;
}
