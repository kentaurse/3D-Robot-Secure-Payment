<?php
/**
 * Recommend post
 */
add_action( 'add_meta_boxes', 'add_custom_meta_boxes' );
add_action( 'save_post', 'save_recommend_post_meta_box' );

function add_custom_meta_boxes() {
	add_meta_box( 'wp_recommend_post', __( 'Recommend post', 'tcd-w' ), 'recommend_post', 'post', 'side' );
}

function recommend_post( $post ) {
	$recommend_post = get_post_meta( $post->ID, 'recommend_post', true );
	$recommend_post2 = get_post_meta( $post->ID, 'recommend_post2', true );
	$pickup_post = get_post_meta( $post->ID, 'pickup_post', true );
	wp_nonce_field( basename( __FILE__ ), 'recommend_post_meta_box_nonce' );
?>
<p><?php _e( 'Check if you want to show this post for recommend post.', 'tcd-w' ); ?></p>
<ul>
	<li>
		<label><input type="checkbox" name="recommend_post" value="on" <?php checked( $recommend_post, 'on', true ); ?>><?php _e( 'Show this post for recommend post.', 'tcd-w' ); ?></label>
	</li>
	<li>
		<label><input type="checkbox" name="recommend_post2" value="on" <?php checked( $recommend_post2, 'on', true ); ?>><?php _e( 'Show this post for recommend post2.', 'tcd-w' ); ?></label>
	</li>
	<li>
		<label><input type="checkbox" name="pickup_post" value="on" <?php checked( $pickup_post, 'on', true ); ?>><?php _e( 'Show this post for pickup post.', 'tcd-w' ); ?></label>
	</li>
</ul>
<?php
}

function save_recommend_post_meta_box( $post_id ) {

	// nonce の値を比較し、両者が異なれば処理をしない
	if ( ! isset( $_POST['recommend_post_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['recommend_post_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// 自動保存の場合は処理をしない
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// ユーザー権限を調べ、権限がなければ処理をしない
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$cf_keys = array( 'recommend_post', 'recommend_post2', 'pickup_post' );
	foreach ( $cf_keys as $cf_key ) {
		if ( isset( $_POST[$cf_key] ) ) {
			update_post_meta( $post_id, $cf_key, $_POST[$cf_key] );
		} else {
			delete_post_meta( $post_id, $cf_key );
		}
	}
}
