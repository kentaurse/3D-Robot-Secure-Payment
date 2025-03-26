<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<footer class="l-footer">
<?php
// フッター検索
if ( $dp_options['show_footer_search_mobile'] ) :
?>
	<div class="p-footer-search--mobile l-inner">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<input type="text" name="s" value="<?php echo esc_attr( get_query_var( 's' ) ); ?>" class="p-footer-search__input" placeholder="SEARCH">
			<input type="submit" value="&#xe915;" class="p-footer-search__submit">
		</form>
	</div>
<?php
endif;

// フッターウィジェット
$footer_widget_area_class = 'p-footer-widget-area';
if ( is_mobile() ) :
	$footer_widget = 'footer_widget_mobile';
else :
	$footer_widget = 'footer_widget';
endif;
if ( is_active_sidebar( $footer_widget ) ) :
	ob_start();
	dynamic_sidebar( $footer_widget );
	$footer_widget_html = ob_get_clean();
else :
	$footer_widget_area_class .= ' p-footer-widget-area__default';
	ob_start();
	the_widget(
		'Site_Info_Widget',
		array(
			'title' => get_bloginfo( 'name' ),
			'image' => 0,
			'image_retina' => 0,
			'image_url' => home_url( '/' ),
			'image_target_blank' => 0,
			'description' => get_bloginfo( 'description' ),
			'use_sns_theme_options' => 1
		),
		array(
			'id' => $footer_widget,
			'before_widget' => '<div class="p-widget p-widget-footer site_info_widget">' . "\n",
			'after_widget' => "</div>\n",
			'before_title' => '<h2 class="p-widget__title">',
			'after_title' => '</h2>' . "\n"
		)
	);
	$footer_widget_html = ob_get_clean();
endif;

// モバイル用に最初のSNSボタンにクラス追加
$preg_replaced = 0;
$footer_widget_html = preg_replace( '/<ul class="p-social-nav/', '<ul class="p-social-nav p-social-nav__mobile', $footer_widget_html, 1, $preg_replaced );
// SNSボタン有クラス
if ( $preg_replaced ) :
	$footer_widget_area_class .= ' p-footer-widget-area__has-social-nav';
endif;

// justify-content: space-betweenの最終行調整
if ( preg_match_all( '/<div class="(p-widget .*?)"/', $footer_widget_html, $matches ) ) {
	// 半分に表示するウィジェットcssクラス
	$footer_widget_half_classes = array( 'widget_nav_menu', 'widget_categories', 'widget_recent_entries', 'widget_pages', 'widget_meta' );
	$footer_widget_rows = 1;
	$footer_widget_cols = 0;
	foreach( $matches[1] as $match ) {
		$footer_widget_is_half = false;
		foreach( $footer_widget_half_classes as $footer_widget_half_class ) {
			if ( strpos( $match, $footer_widget_half_class ) !== false ) {
				$footer_widget_is_half = true;
				break;
			}
		}
		if ( $footer_widget_is_half ) {
			$footer_widget_col = 1;
			if ( $footer_widget_cols <= 5 ) {
				$footer_widget_cols += 1;
			} else {
				$footer_widget_cols = 1;
				$footer_widget_rows++;
			}
		} else {
			if ( $footer_widget_cols <= 4 ) {
				$footer_widget_cols += 2;
			} else {
				$footer_widget_cols = 2;
				$footer_widget_rows++;
			}
		}
	}

	// 不足分を挿入
	if ( $footer_widget_rows > 1 && $footer_widget_cols < 6 ) {
		$footer_widget_html .= str_repeat( '<div class="p-widget p-widget-footer u-hidden-sm"></div>', floor( ( 6 - $footer_widget_cols ) / 2 ) );
		$footer_widget_html .= str_repeat( '<div class="p-widget p-widget-footer u-hidden-sm widget_nav_menu"></div>', ( 6 - $footer_widget_cols ) % 2 );
		$footer_widget_html .= "\n";
	}
}
?>
		<center>
	<div id="js-footer-widget" class="<?php echo esc_attr( $footer_widget_area_class ); ?>">
		<div class="footertext l-inner">
		<a href="/privacy.php" target="_blank">個人情報保護方針</a>　　　<a href="/rule.php" target="_blank">サイト利用規約</a><br class="br-sp">　　　<a href="/publish.php" target="_blank">サイト掲載規約</a>　　　<a href="/dsct.php" target="_blank">特商法表示</a>　　　<br class="br-sp"><a href="https://www.realideal.jp/" target="_blank">運営会社</a>　　　<a href="want.php" target="_blank">掲載希望の方</a>　　　<a href="link.php" target="_blank">リンク</a>
		</div>
	</div>
	<div class="p-copyright">
		<div class="l-inner">
			<p>Copyright &copy;Realideal. All Rights Reserved.</p>
		</div>
	</div>
		</center>
<?php
if ( is_mobile() && 'type3' !== $dp_options['footer_bar_display'] ) :
	get_template_part( 'template-parts/footer-bar' );
endif;
?>
	<div id="js-pagetop" class="p-pagetop"><a href="#"></a></div>
</footer>
<?php wp_footer(); ?>
<script>
jQuery(function($){
	var initialized = false;
	var initialize = function(){
		if (initialized) return;
		initialized = true;

		$(document).trigger('js-initialized');
		$(window).trigger('resize').trigger('scroll');
	};

<?php
if ( $dp_options['use_load_icon'] ) :
?>
	$(window).load(function() {
		setTimeout(initialize, 800);
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800);
	});
	setTimeout(function(){
		setTimeout(initialize, 800);
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800);
	}, <?php echo esc_html( $dp_options['load_time'] ? $dp_options['load_time'] : 5000 ); ?>);
<?php
else : // ロード画面を表示しない
?>
	initialize();
<?php
endif;
?>

});
</script>
<?php
if ( is_singular() && ! is_page() ) :
	if ( 'type5' == $dp_options['sns_type_top'] || 'type5' == $dp_options['sns_type_btm'] ) :
		if ( $dp_options['show_twitter_top'] || $dp_options['show_twitter_btm'] ) :
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
		endif;
		if ( $dp_options['show_fblike_top'] || $dp_options['show_fbshare_top'] || $dp_options['show_fblike_btm'] || $dp_options['show_fbshare_btm'] ) :
?>
<!-- facebook share button code -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
		endif;
		if ( $dp_options['show_google_top'] || $dp_options['show_google_btm'] ) :
?>
<script type="text/javascript">window.___gcfg = {lang: 'ja'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
</script>
<?php
		endif;
		if ( $dp_options['show_hatena_top'] || $dp_options['show_hatena_btm'] ) :
?>
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<?php
		endif;
		if ( $dp_options['show_pocket_top'] || $dp_options['show_pocket_btm'] ) :
?>
<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
<?php
		endif;
		if ( $dp_options['show_pinterest_top'] || $dp_options['show_pinterest_btm'] ) :
?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
		endif;
	endif;
endif;
?>
</body>
</html>