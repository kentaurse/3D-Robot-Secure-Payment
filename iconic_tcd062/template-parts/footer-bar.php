<?php
// テーマオプションを取得
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

// ページタイトルを取得
$title = wp_title( '|', false, 'right' );

// ページ URL を取得
$url = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$footer_bar_btn_classes = array();
$footer_bar_btn_target = '';
$footer_bar_btn_url = '';
?>
<ul id="js-footer-bar" class="c-footer-bar c-footer-bar--<?php echo esc_attr( $dp_options['footer_bar_display'] ); ?>">
	<?php
	// ボタンを表示
	foreach ( $dp_options['footer_bar_btns'] as $key => $value ) :
		switch ( $value['type'] ) {
			// ボタンタイプ：デフォルト
			case 'type1' :
				$footer_bar_btn_classes = array( 'c-footer-bar__item' );
				$footer_bar_btn_target = $value['target'];
				$footer_bar_btn_url = $value['url'];
				break;
			// ボタンタイプ：シェア
			case 'type2' :
				$footer_bar_btn_classes = array( 'c-footer-bar__item--share', 'c-footer-bar__item' );
				$footer_bar_btn_url = '#';
				break;
			// ボタンタイプ：電話番号
			case 'type3' :
				$footer_bar_btn_classes = array( 'c-footer-bar__item' );
				$footer_bar_btn_url = 'tel:' . $value['number'];
		}
	?>
	<li class="<?php echo esc_attr( implode( ' ', $footer_bar_btn_classes ) ); ?>">
		<a href="<?php echo esc_url( $footer_bar_btn_url ); ?>"<?php echo $footer_bar_btn_target ? ' target="_blank"' : ''; ?>>
			<span class="c-footer-bar__icon c-footer-bar__icon--<?php echo esc_attr( $value['icon'] ); ?>"><?php echo esc_html( $value['label'] ); ?></span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<div id="js-modal-overlay" class="c-footer-bar__modal-overlay u-hidden">
	<div class="c-footer-bar__modal-close"></div>
</div>
<div id="js-modal-content" class="c-footer-bar__modal-content u-hidden">
	<ul class="c-footer-bar__share u-clearfix">
		<li class="c-footer-bar__share-btn c-footer-bar__share-btn--rounded-square">
			<a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" onClick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=650, height=470, personalbar=0, toolbar=0, scrollbars=1, sizable=1'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png" alt=""></a>
		</li>
		<li class="c-footer-bar__share-btn">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $url ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/facebook.png" alt=""></a>
		</li>
		<li class="c-footer-bar__share-btn">
			<a href="http://line.me/R/msg/text/?<?php echo rawurlencode( $title ); ?><?php echo rawurlencode( $url ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/line.png" alt=""></a>
		</li>
		<li class="c-footer-bar__share-btn">
			<a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" data-hatena-bookmark-width="50" data-hatena-bookmark-height="50" title="このエントリーをはてなブックマークに追加"><img src="<?php echo get_template_directory_uri(); ?>/img/hatenabookmark-logomark.svg" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
		</li>
	</ul>
</div>
