<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

/**
 * カスタムカラムを追加する（ID、アイキャッチ画像）
 */
function manage_columns( $columns ) {

	// IDカラムとアイキャッチ画像カラムを加えた、新しいカラム配列を作成
	$new_columns = array();

	foreach ( $columns as $column_name => $column_display_name ) {
		// title カラムの前に post_id カラムを追加
		if ( isset( $columns['title'] ) && $column_name == 'title' ) {
			$new_columns['post_id'] = 'ID';
		}
		$new_columns[$column_name] = $column_display_name;
	}

	// アイキャッチ画像を追加
	$new_columns['new_post_thumb'] = __( 'Featured Image', 'tcd-w' );

	return $new_columns;
}
add_filter( 'manage_post_posts_columns', 'manage_columns', 5 ); // 投稿
add_filter( 'manage_page_posts_columns', 'manage_columns', 5 ); // 固定ページ
add_filter( 'manage_' . $dp_options['news_slug'] . '_posts_columns', 'manage_columns', 5 ); // ニュース

/**
 * カスタムカラムを追加する（おすすめ記事）
 */
function manage_post_posts_columns( $columns ) {
	$columns['recommend_post'] = __( 'Recommend post', 'tcd-w' );
	return $columns;
}
add_filter( 'manage_post_posts_columns', 'manage_post_posts_columns' ); // 投稿のみ

/**
 * カスタムカラムに内容を出力する（ID、アイキャッチ画像、おすすめ記事）
 */
function add_column( $column_name, $post_id ) {

	switch ( $column_name ) {

		// ID
		case 'post_id' :
			echo $post_id;
			break;

		// アイキャッチ画像
		case 'new_post_thumb' :
			$post_thumbnail_id = get_post_thumbnail_id( $post_id );
			if ( $post_thumbnail_id ) {
				$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
				echo '<img width="70" src="' . $post_thumbnail_img[0] . '">';
			}
			break;

		// おすすめ記事
		case 'recommend_post' :
			$a = array();
			if ( get_post_meta( $post_id, 'recommend_post', true ) ) {
				$a[] = __( 'Recommend post', 'tcd-w' );
			}
			if ( get_post_meta( $post_id, 'recommend_post2', true ) ) {
				$a[] = __( 'Recommend post2', 'tcd-w' );
			}
			if ( get_post_meta( $post_id, 'pickup_post', true ) ) {
				$a[] = __( 'Pickup post', 'tcd-w' );
			}
			if ( is_sticky( $post_id ) ) {
				$a[] = __( 'Sticky' );
			}
			echo implode( '<br>', $a );
			break;
	}
}
add_action( 'manage_posts_custom_column', 'add_column', 10, 2 ); // 投稿、ニュース
add_action( 'manage_pages_custom_column', 'add_column', 10, 2 ); // 固定ページ
