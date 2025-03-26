<?php
/**
 * カードリンクパーツ
 */
function get_the_custom_excerpt( $content, $length = 70 ) {
	$content = preg_replace( '/<!--more-->.+/is', '', $content ); // moreタグ以降削除
	$content = strip_shortcodes( $content ); // ショートコード削除
	$content = strip_tags( $content ); // タグの除去
	$content = str_replace( '&nbsp;', '', $content ); // 特殊文字の削除（今回はスペースのみ）
	if ( 0 < $length) {
		$content = mb_strimwidth( $content, 0, $length, '...' ); // 文字列を指定した長さで切り取る
	}
	return $content;
}

/**
 * カードリンクショートコード
 *
 * @param array $atts ユーザーがショートコードタグに指定した属性
 * @return string カードリンクの HTML
 */
function clink_scode( $atts ) {

	// ユーザーがショートコードに指定した属性を、あらかじめ定義した属性と結合
	$atts = shortcode_atts(
		array(
			'url' => '',
			'title' => '',
			'excerpt' => ''
		),
		$atts
	);

	if ( ! $atts['url'] ) return;

	// URL から投稿 ID を取得
	$id = url_to_postid( $atts['url'] );

	if ( $id ) {
		return get_internal_clink_html( $id, $atts );
	} else {
		return get_external_clink_html( $atts );
	}
}

/**
 * 内部リンクのカードリンクの HTML を作成
 *
 * @param int $id 投稿 ID
 * @param array $atts ユーザーがショートコードタグに指定した属性
 * @return string カードリンクの HTML
 */
function get_internal_clink_html( $id, $atts ) {

	// ID から投稿情報を取得
	$post = get_post( $id );

	// 投稿日を取得
	$date = mysql2date( 'Y.m.d', $post->post_date );

	// タイトルを取得
	$title = $atts['title'] ? $atts['title'] : get_the_title( $id );
	$title = is_mobile() ? wp_trim_words( $title, 42, '...' ) : $title;

	// 抜粋を取得
	$excerpt = $atts['excerpt'];

	if ( ! $excerpt ) {
		if ( $post->post_excerpt ) {
			$excerpt = get_the_custom_excerpt( $post->post_excerpt, false );
		} else {
			$excerpt = get_the_custom_excerpt( $post->post_content, false );
		}
	}

	$excerpt = mb_strimwidth( $excerpt, 0, 200, '...' );

	// アイキャッチ画像を取得
	if ( has_post_thumbnail( $id ) ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'size-card' );
		if ( $img ) {
			$img = $img[0];
		}
	}
	if ( empty( $img ) ) {
		$img = get_template_directory_uri() . '/img/common/no-image-300x300.gif';
	}

	$clink = '<div class="cardlink">
	<a href=' . esc_url( $atts['url'] ) . '">
		<div class="cardlink_thumbnail">
			<img src="' . esc_attr( $img ) . '">
		</div>
	</a>
	<div class="cardlink_content">
	<span class="cardlink_timestamp">' . esc_html( $date ) . '</span>
		<div class="cardlink_title">
			<a href="' . esc_url( $atts['url'] ) . '">' . esc_html( $title ) . '</a>
		</div>
		<div class="cardlink_excerpt js-multiline-ellipsis">' . esc_html( $excerpt ) . '</div>
	</div>
	<div class="cardlink_footer"></div>
</div>' . "\n";

	return $clink;
}

/**
 * 外部リンクのカードリンクの HTML を作成
 *
 * @see OpenGraph::fetch()
 *
 * @param array $atts ユーザーがショートコードタグに指定した属性
 * @return string カードリンクの HTML
 */
function get_external_clink_html( $atts ) {

	if ( ! class_exists( 'OpenGraph' ) ) {
		get_template_part( 'functions/class-open-graph' );
	}

	$graph = OpenGraph::fetch( $atts['url'] );

	// タイトルを取得
	$title = $atts['title'] ? $atts['title'] : $graph->title;

	// 抜粋を取得
	$excerpt = $atts['excerpt'] ? $atts['excerpt'] : $graph->description;
	$excerpt = mb_strimwidth( $excerpt, 0, 200, '...' );

	// 画像を取得
	$img = $graph->image ? $graph->image : get_template_directory_uri() . '/img/common/no-image-300x300.gif';

	$clink = '<div class="cardlink">
	<a href=' . esc_url( $atts['url'] ) . '">
		<div class="cardlink_thumbnail">
			<img src="' . esc_attr( $img ) . '">
		</div>
	</a>
	<div class="cardlink_content">
		<div class="cardlink_title">
			<a href="' . esc_url( $atts['url'] ) . '">' . esc_html( $title ) . '</a>
		</div>
		<div class="cardlink_excerpt js-multiline-ellipsis">' . esc_html( $excerpt ) . '</div>
	</div>
	<div class="cardlink_footer"></div>
</div>' . "\n";

	return $clink;
}

add_shortcode( 'clink', 'clink_scode' );
