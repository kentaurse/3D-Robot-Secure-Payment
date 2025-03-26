<?php

function tcd_page_meta_box() {
	// Welcartのページの場合は表示しない
	global $post;
	$usces_cart_number = get_option( 'usces_cart_number' );
	$usces_member_number = get_option( 'usces_member_number' );
	if ( ! empty( $post->ID ) && ( $post->ID == $usces_cart_number || $post->ID == $usces_member_number ) ) {
		return;
	}

	add_meta_box(
		'tcd_page_meta_box' ,// ID of meta box
		__( 'Page setting', 'tcd-w' ), // label
		'show_tcd_page_meta_box', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_meta_box' );

function show_tcd_page_meta_box() {
	global $post;

	// サイドコンテンツの設定
	$display_side_content = array(
		'name' => __( 'Sidebar setting', 'tcd-w' ),
		'id' => 'display_side_content',
		'type' => 'radio',
		'std' => 'hide',
		'options' => array(
			array(
				'name' => __( 'Display sidebar', 'tcd-w' ),
				'value' => 'show'
			),
			array(
				'name' => __( 'Hide sidebar', 'tcd-w' ),
				'value' => 'hide'
			)
		)
	);
	$display_side_content_meta = $post->display_side_content;
	if ( ! $display_side_content_meta ) {
		$display_side_content_meta = $display_side_content['std'];
	}

	echo '<input type="hidden" name="tcd_page_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">';

	// サイドコンテンツの選択
	echo '<dt class="label"><label for="' . esc_attr( $display_side_content['id'] ) . '">' . esc_html( $display_side_content['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio side_content cf">';
	foreach ( $display_side_content['options'] as $display_side_content_option ) {
		echo '<li><label><input type="radio" id ="side_content-' . esc_attr( $display_side_content_option['value'] ) . '" name="' . $display_side_content['id'] . '" value="' . esc_attr( $display_side_content_option['value'] ) . '"' . checked( $display_side_content_meta, $display_side_content_option['value'] , false ) . ' />' . esc_html( $display_side_content_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	$cf_key = 'content_font_size';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = 14;
	echo '<dt class="label"><label>' . __( 'Font size of page contents', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1"> px';
	echo '</dd>' . "\n";

	$cf_key = 'content_font_size_mobile';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = 14;
	echo '<dt class="label"><label>' . __( 'Font size of page contents for mobile', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1"> px';
	echo '</dd>' . "\n";

	echo '</dl>'."\n";
}

function save_tcd_page_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
	}

	// save or delete
	$cf_keys = array(
		'display_title',
		'display_side_content',
		'content_font_size',
		'content_font_size_mobile'
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
add_action( 'save_post', 'save_tcd_page_meta_box' );
