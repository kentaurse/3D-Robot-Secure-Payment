<?php
/**
 * Custom CSS
 */
function add_css_to_post_custom_css_input() {
	global $post;
	echo '<p>' . __( 'You don\'t need to enter &lt;style&gt; tag.', 'tcd-w' ) . '</p>';
	echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">' . get_post_meta( $post->ID, '_custom_css', true ) . '</textarea>';
	wp_nonce_field( 'custom-css', 'custom_css_noncename' );
}

function add_css_to_post_custom_css_hooks() {
	add_meta_box( 'custom_css', __( 'Custom CSS for this post', 'tcd-w' ), 'add_css_to_post_custom_css_input', array( 'post', 'page' ), 'normal', 'high' );
}

function add_css_to_post_save_custom_css( $post_id ) {

	// nonce の値を比較し、両者が異なれば処理をしない
	if ( ! isset ( $_POST['custom_css_noncename'] ) || ! wp_verify_nonce ( $_POST['custom_css_noncename'], 'custom-css' ) ) {
		return $post_id;
	}

	// 自動保存の場合は処理をしない
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// ユーザー権限を調べ、権限がなければ処理をしない
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$custom_css = $_POST['custom_css'];
	update_post_meta( $post_id, '_custom_css', $custom_css );
}

function add_css_to_post_insert_custom_css() {

	if ( is_page() || is_single() ) {
		while ( have_posts() ) {
			the_post();
			echo '<style type="text/css">' . "\n" . get_post_meta( get_the_ID(), '_custom_css', true ) . "\n" . '</style>' . "\n";
		}
		rewind_posts();
	}
}

function add_css_to_post_init() {
	add_action( 'add_meta_boxes', 'add_css_to_post_custom_css_hooks' );
	add_action( 'save_post', 'add_css_to_post_save_custom_css' );
	add_action( 'wp_head','add_css_to_post_insert_custom_css' );
}
add_action( 'init', 'add_css_to_post_init' );
