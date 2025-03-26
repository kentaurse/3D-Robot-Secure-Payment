<?php
function tcd_head() {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	$primary_color_hex = esc_html( implode( ', ', hex2rgb( $dp_options['primary_color'] ) ) );
	$load_color1_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color1'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
	$load_color2_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color2'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
?>
<?php if ( $dp_options['favicon'] && $url = wp_get_attachment_url( $dp_options['favicon'] ) ) : ?>
<link rel="shortcut icon" href="<?php echo esc_attr( $url ); ?>">
<?php endif; ?>
<style>
<?php /* Primary color */ ?>
.p-article-news__date, .p-wc-headline, #wdgctToCart a { color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-button, .p-global-nav .sub-menu .current-menu-item > a, .p-page-links > span, .p-pager__item .current, .p-headline, .p-widget-sidebar .p-widget__title, .c-comment__form-submit:hover, c-comment__password-protected, .c-pw__btn--register, .c-pw__btn, .slick-arrow, .slick-dots li.slick-active button, .widget_welcart_login input#member_loginw, .widget_welcart_login input#member_login, #wdgctToCheckout a { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-page-links > span, .p-pager__item .current, .slick-dots li.slick-active button, .p-cb__item-header, .p-entry-item__cart dl.item-sku dd input[type="radio"]:checked + label, .p-entry-item__cart dl.item-sku dd label:hover { border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.c-comment__tab-item.is-active a, .c-comment__tab-item a:hover, .c-comment__tab-item.is-active p { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.c-comment__tab-item.is-active a:after, .c-comment__tab-item.is-active p:after { border-top-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-widget-categories .current-cat-item > a { background-color: rgba(<?php echo $primary_color_hex; ?>, 0.15); }
<?php /* Secondary color */ ?>
a:hover, .p-header__welcart-nav li a:hover, .p-widget-categories .toggle-children:hover, #wdgctToCart a:hover { color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-button:hover, .p-page-links a:hover, .p-pager__item a:hover, .p-search-button:hover, .p-pagetop a:hover, .p-footer-search__submit:hover, .p-widget .searchform #searchsubmit:hover, .p-widget-search .p-widget-search__submit:hover, a.p-cb__item-archive-button:hover, .slick-arrow:hover, .slick-dots li:hover button, .widget_welcart_search #searchsubmit:hover, .widget_welcart_login input#member_loginw:hover, .widget_welcart_login input#member_login:hover, #wdgctToCheckout a:hover { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-page-links a:hover, .p-pager__item a:hover, .slick-dots li:hover button { border-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
<?php /* Link color of post contents */ ?>
.p-entry__body a, .custom-html-widget a { color: <?php echo esc_html( $dp_options['content_link_color'] ); ?>; }
.p-entry__body a:hover, .custom-html-widget a:hover { color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
<?php /* font type */ ?>
<?php if ( 'type1' == $dp_options['font_type'] ) : ?>
body, input, textarea, .p-entry-item__title .p-article__soldout { font-family: Verdana, "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", "メイリオ", Meiryo, sans-serif; }
<?php elseif ( 'type2' == $dp_options['font_type'] ) : ?>
body, input, textarea, .p-entry-item__title .p-article__soldout { font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif; }
<?php else : ?>
body, input, textarea, .p-entry-item__title .p-article__soldout { font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif; }
<?php endif; ?>
<?php /* headline font type */ ?>
.p-logo, .p-entry__title, .p-page-header__title, .p-index-slider__item-catch, .p-cb__item-headline, .p-index-banner__headline, .p-index-boxes__item-headline {
<?php if ( 'type1' == $dp_options['headline_font_type'] ) : ?>
font-family: Segoe UI, "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", "メイリオ", Meiryo, sans-serif;
<?php elseif ( 'type2' == $dp_options['headline_font_type'] ) : ?>
font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
<?php else : ?>
font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif;
font-weight: 500;
<?php endif; ?>
}
<?php /* load */ ?>
<?php if ( 'type1' == $dp_options['load_icon'] ) : ?>
.c-load--type1 { border: 3px solid rgba(<?php echo esc_html( $load_color2_hex ); ?>, 0.2); border-top-color: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php elseif ( 'type2' == $dp_options['load_icon'] ) : ?>
@-webkit-keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
@keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
.c-load--type2:before { box-shadow: 16px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 0); }
.c-load--type2:after { background-color: rgba(<?php echo $load_color1_hex; ?>, 1); }
<?php elseif ( 'type3' == $dp_options['load_icon'] ) : ?>
.c-load--type3 i { background: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php endif; ?>
<?php /* hover effect */ ?>
<?php if ( $dp_options['hover1_rotate'] ) : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); }
<?php else : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); }
<?php endif; ?>
<?php if ( 'type1' == $dp_options['hover2_direct'] ) : ?>
.p-hover-effect--type2 img { margin-left: -8px; }
.p-hover-effect--type2:hover img { margin-left: 8px; }
<?php else : ?>
.p-hover-effect--type2 img { margin-left: 8px; }
.p-hover-effect--type2:hover img { margin-left: -8px; }
<?php endif; ?>
<?php if ( 1 > $dp_options['hover1_opacity'] ) : ?>
.p-hover-effect--type1:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover1_bgcolor'] ); ?>; }
.p-hover-effect--type1:hover img { opacity: <?php echo esc_html( $dp_options['hover1_opacity'] ); ?>; }
<?php endif; ?>
.p-hover-effect--type2:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover2_bgcolor'] ); ?>; }
.p-hover-effect--type2:hover img { opacity: <?php echo esc_html( $dp_options['hover2_opacity'] ); ?> }
.p-hover-effect--type3:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover3_bgcolor'] ); ?>; }
.p-hover-effect--type3:hover img { opacity: <?php echo esc_html( $dp_options['hover3_opacity'] ); ?>; }
<?php /* Entry */ ?>
.p-entry__title { font-size: <?php echo esc_html( $dp_options['title_font_size'] ); ?>px; }
.p-entry__title, .p-article__title { color: <?php echo esc_html( $dp_options['title_color'] ); ?> }
.p-entry__body { font-size: <?php echo esc_html( $dp_options['content_font_size'] ); ?>px; }
.p-entry__body { color: <?php echo esc_html( $dp_options['content_color'] ); ?>; }
<?php if ( is_page() && $post->content_font_size ) { ?>
body.page .p-entry__body { font-size: <?php echo esc_html( $post->content_font_size ); ?>px; }
<?php } ?>
<?php /* News */ ?>
.p-entry-news__title { font-size: <?php echo esc_html( $dp_options['news_title_font_size'] ); ?>px; }
.p-entry-news__title, .p-article-news__title { color: <?php echo esc_html( $dp_options['news_title_color'] ); ?> }
.p-entry-news__body { color: <?php echo esc_html( $dp_options['news_content_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['news_content_font_size'] ); ?>px; }
<?php /* Item */ ?>
.p-entry-item__title { font-size: <?php echo esc_html( $dp_options['item_title_font_size'] ); ?>px; }
.p-entry-item__title, .p-article-item__title, .p-article__price { color: <?php echo esc_html( $dp_options['item_title_color'] ); ?>; }
.p-entry-item__body, p-wc__body { color: <?php echo esc_html( $dp_options['item_content_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['item_content_font_size'] ); ?>px; }
.p-price { color: <?php echo esc_html( $dp_options['item_price_color'] ); ?>; }
.p-entry-item__price { font-size: <?php echo esc_html( $dp_options['item_price_font_size'] ); ?>px; }
<?php /* Header */ ?>
body.l-header__fix .is-header-fixed .l-header__bar { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
.l-header { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
.l-header a, .p-global-nav a { color: <?php echo esc_html( $dp_options['header_font_color'] ); ?>; }
<?php /* logo */ ?>
.p-header__logo--text { font-size: <?php echo esc_html( $dp_options['logo_font_size'] ); ?>px; }
<?php /* header welcart */ ?>
.p-header__welcart-nav__member a, .p-header__welcart-nav__cart a, .p-cart-button .p-header__welcart-nav__badge { background-color: <?php echo esc_html( $dp_options['header_welcart_bg_color'] ); ?>; }
.p-header__welcart-nav__member a:hover, .p-header__welcart-nav__cart a:hover, .p-cart-button:hover .p-header__welcart-nav__badge { background-color: <?php echo esc_html( $dp_options['header_welcart_bg_color_hover'] ); ?>; }
<?php /* Global menu */ ?>
.p-global-nav > li > a::after, .p-global-nav > li.current-menu-item > a::after { background-color: <?php echo esc_html( $dp_options['globalmenu_hover_underline_color'] ); ?>; }
.p-megamenu__bg, .p-global-nav .sub-menu { background-color: <?php echo esc_html( $dp_options['submenu_bg_color'] ); ?>; }
.p-megamenu a, .p-global-nav .sub-menu a { color: <?php echo esc_html( $dp_options['submenu_color'] ); ?>; }
.p-megamenu a:hover, .p-megamenu li.is-active > a, .p-global-nav .sub-menu a:hover { background-color: <?php echo esc_html( $dp_options['submenu_bg_color_hover'] ); ?>; color: <?php echo esc_html( $dp_options['submenu_color_hover'] ); ?>; }
<?php /* Page header */ ?>
.p-page-header { background-color: <?php echo esc_html( $dp_options['page_header_bg_color'] ); ?>; }
.p-page-header__title { color: <?php echo esc_html( $dp_options['page_header_headline_color'] ); ?>; }
.p-page-header__desc { color: <?php echo esc_html( $dp_options['page_header_desc_color'] ); ?>; }
<?php /* Footer widget */ ?>
.p-footer-widget-area { background-color: <?php echo esc_html( $dp_options['footer_widget_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['footer_widget_text_color'] ); ?>; }
.p-footer-widget-area .p-widget__title { color: <?php echo esc_html( $dp_options['footer_widget_title_color'] ); ?>; }
.p-footer-widget-area a, .p-footer-widget-area .toggle-children { color: <?php echo esc_html( $dp_options['footer_widget_link_color'] ); ?>; }
.p-footer-widget-area a:hover { color: <?php echo esc_html( $dp_options['footer_widget_link_color_hover'] ); ?>; }
<?php /* Footer bar */ ?>
<?php if ( is_mobile() && ( 'type1' === $dp_options['footer_bar_display'] || 'type2' === $dp_options['footer_bar_display'] ) ) : ?>
.c-footer-bar { background: rgba(<?php echo implode( ',', hex2rgb( $dp_options['footer_bar_bg'] ) ) . ', ' . esc_html( $dp_options['footer_bar_tp'] ); ?>); border-top: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; color:<?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar a { color: <?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar__item + .c-footer-bar__item { border-left: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; }
<?php endif; ?>
<?php /* Responsive */ ?>
@media only screen and (max-width: 991px) {
	.l-header__bar { background-color: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
	.p-header__logo--text { font-size: <?php echo esc_html( $dp_options['logo_font_size_mobile'] ); ?>px; }
	.p-global-nav { background-color: rgba(<?php echo implode( ',', hex2rgb( $dp_options['submenu_bg_color'] ) ) . ', ' . esc_html( $dp_options['header_opacity'] ); ?>); }
	.p-global-nav a { color: <?php echo esc_html( $dp_options['submenu_color'] ); ?>; }
	.p-global-nav a:hover { background-color: rgba(<?php echo implode( ',', hex2rgb( $dp_options['submenu_bg_color_hover'] ) ) . ', ' . esc_html( $dp_options['header_opacity'] ); ?>); color: <?php echo esc_html( $dp_options['submenu_color_hover'] ); ?>; }
	.p-header-view-cart { background-color: rgba(255, 255, 255, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
	.p-entry__title { font-size: <?php echo esc_html( $dp_options['title_font_size_mobile'] ); ?>px; }
	.p-entry__body { font-size: <?php echo esc_html( $dp_options['content_font_size_mobile'] ); ?>px; }
	.p-entry-news__title { font-size: <?php echo esc_html( $dp_options['news_title_font_size_mobile'] ); ?>px; }
	.p-entry-news__body { font-size: <?php echo esc_html( $dp_options['news_content_font_size_mobile'] ); ?>px; }
<?php	if ( is_page() && $post->content_font_size_mobile ) { ?>
	body.page .p-entry__body { font-size: <?php echo esc_html( $post->content_font_size_mobile ); ?>px; }
<?php	} ?>
	.p-entry-item__title { font-size: <?php echo esc_html( $dp_options['item_title_font_size_mobile'] ); ?>px; }
	.p-entry-item__body, p-wc__body { font-size: <?php echo esc_html( $dp_options['item_content_font_size_mobile'] ); ?>px; }
	.p-entry-item__price { font-size: <?php echo esc_html( $dp_options['item_price_font_size_mobile'] ); ?>px; }
}
<?php if ( 'type2' == $dp_options['load_icon'] ) : ?>
@media only screen and (max-width: 767px) {
	@-webkit-keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	@keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	.c-load--type2:before { box-shadow: 10px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
<?php endif; ?>
<?php
if ( is_front_page() ) {
	$css = array();
	$css_mobile = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		if ( ( is_mobile() && ! $dp_options['slider_image_sp' . $i] ) || ! $dp_options['slider_image' . $i] ) {
			continue;
		}

		if ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] ) {
			$css[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-button { background-color: ' . esc_attr( $dp_options['slider_button_bg_color' . $i] ) . '; color: ' . esc_attr( $dp_options['slider_button_font_color' . $i] ) . '; }';
			$css[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-button:hover { background-color: ' . esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ) . '; color: ' . esc_attr( $dp_options['slider_button_font_color_hover' . $i] ) . '; }';
		}

		if ( $dp_options['display_slider_catch' . $i] && $dp_options['slider_catch' . $i] ) {
				$css[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-catch { color: ' . esc_attr( $dp_options['slider_catch_color' . $i] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size' . $i] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow1'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow2'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow3'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow_color'] ) . '; }';
				$css_mobile[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-content { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['slider_catch_bg_color' . $i] ) ) . ', ' . $dp_options['slider_catch_bg_opacity' . $i] ) . '); }';
				$css_mobile[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-catch { color: ' . esc_attr( $dp_options['slider_catch_color_mobile' . $i] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size_mobile' . $i] ) . 'px; }';
		}

		if ( $dp_options['display_slider_overlay' . $i] && 0 < $dp_options['slider_overlay_opacity' . $i] ) {
				$css[] = '.p-index-slider__item--' . $i .' .p-index-slider__item-overlay { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['slider_overlay_color' . $i] ) ) . ', ' . $dp_options['slider_overlay_opacity' . $i] ) . '); }';
		}
	}

	// ニュースティッカー
	if ( $dp_options['show_index_news'] && $dp_options['index_news_archive_link_text'] ) {
		$css[] = '.p-index-news__archive-link .p-button { background-color: ' . esc_attr( $dp_options['index_news_archive_link_bg_color'] ) . '; color: ' . esc_attr( $dp_options['index_news_archive_link_font_color'] ) . ' !important; }';
		$css[] = '.p-index-news__archive-link .p-button:hover { background-color: ' . esc_attr( $dp_options['index_news_archive_link_bg_color_hover'] ) . '; color: ' . esc_attr( $dp_options['index_news_archive_link_font_color_hover'] ) . ' !important; }';
	}

	// コンテンツビルダー
	if ( ! empty( $dp_options['contents_builder'] ) ) {
		foreach ( $dp_options['contents_builder'] as $key => $cb_content ) {
			$cb_index = 'cb_' . ( $key + 1 );
			if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

			if ( ! empty( $cb_content['cb_background_color'] ) && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) {
				$css[] = '#' . $cb_index . '::before { background-color: ' . esc_attr( $cb_content['cb_background_color'] ) . '; }';
			}

			// 最新ブログ記事一覧・カルーセル
			if ( 'blog' == $cb_content['cb_content_select'] ) {
				if ( $cb_content['cb_headline'] ) {
					$css[] = '#' . $cb_index . ' .p-cb__item-headline { color: ' . esc_attr( $cb_content['cb_headline_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_headline_font_size'] ) . 'px; }';
					$css_mobile[] = '#' . $cb_index . ' .p-cb__item-headline { font-size: ' . esc_attr( $cb_content['cb_headline_font_size_mobile'] ) . 'px; }';
				}
				if ( $cb_content['cb_desc'] ) {
					$css[] = '#' . $cb_index . ' .p-cb__item-desc { color: ' . esc_attr( $cb_content['cb_desc_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_desc_font_size'] ) . 'px; }';
					$css_mobile[] = '#' . $cb_index . ' .p-cb__item-desc { font-size: ' . esc_attr( $cb_content['cb_desc_font_size_mobile'] ) . 'px; }';
				}
				if ( $cb_content['cb_show_archive_link'] && $cb_content['cb_archive_link_text'] ) {
					$css[] = '#' . $cb_index . ' .p-cb__item-archive-link__button { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color'] ) . ' !important; }';
					$css[] = '#' . $cb_index . ' .p-cb__item-archive-link__button:hover { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color_hover'] ) . ' !important; }';
				}

			// バナー
			} elseif ( 'banner' == $cb_content['cb_content_select'] ) {
				if ( $cb_content['cb_headline'] ) {
					$css[] = '#' . $cb_index . ' .p-index-banner__headline { color: ' . esc_attr( $cb_content['cb_headline_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_headline_font_size'] ) . 'px; }';
					$css_mobile[] = '#' . $cb_index . ' .p-index-banner__headline { font-size: ' . esc_attr( $cb_content['cb_headline_font_size_mobile'] ) . 'px; }';
				}
				if ( $cb_content['cb_desc'] ) {
					$css[] = '#' . $cb_index . ' .p-index-banner__desc { color: ' . esc_attr( $cb_content['cb_desc_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_desc_font_size'] ) . 'px; }';
					$css_mobile[] = '#' . $cb_index . ' .p-index-banner__desc { font-size: ' . esc_attr( $cb_content['cb_desc_font_size_mobile'] ) . 'px; }';
				}
				if ( $cb_content['cb_button_label'] ) {
					$css[] = '#' . $cb_index . ' .p-index-banner__button { background-color: ' . esc_attr( $cb_content['cb_button_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_button_font_color'] ) . ' !important; }';
					$css[] = '#' . $cb_index . ' a.p-index-banner__button:hover, #' . $cb_index . ' a.p-index-banner:hover .p-index-banner__button { background-color: ' . esc_attr( $cb_content['cb_button_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_button_font_color_hover'] ) . ' !important; }';
				}

			// 3点ボックス
			} elseif ( 'three_boxes' == $cb_content['cb_content_select'] ) {
				for ( $i = 1; $i <=3; $i++ ) {
					if ( $cb_content['cb_headline' . $i] ) {
						$css[] = '#' . $cb_index . ' .p-index-boxes__item--' . $i . ' .p-index-boxes__item-headline { color: ' . esc_attr( $cb_content['cb_headline_color' . $i] ) . '; font-size: ' . esc_attr( $cb_content['cb_headline_font_size' . $i] ) . 'px; }';
						$css_mobile[] = '#' . $cb_index . ' .p-index-boxes__item--' . $i . ' .p-index-boxes__item-headline { font-size: ' . esc_attr( $cb_content['cb_headline_font_size_mobile' . $i] ) . 'px; }';
					}
					if ( $cb_content['cb_desc' . $i] ) {
						$css[] = '#' . $cb_index . ' .p-index-boxes__item--' . $i . ' .p-index-boxes__item-desc { color: ' . esc_attr( $cb_content['cb_desc_color' . $i] ) . '; font-size: ' . esc_attr( $cb_content['cb_desc_font_size' . $i] ) . 'px; }';
						$css_mobile[] = '#' . $cb_index . ' .p-index-boxes__item--' . $i . ' .p-index-boxes__item-desc { font-size: ' . esc_attr( $cb_content['cb_desc_font_size_mobile' . $i] ) . 'px; }';
					}
				}

			// カルーセル
			} elseif ( 'carousel' == $cb_content['cb_content_select'] ) {
				if ( $cb_content['cb_headline'] ) {
					$css[] = '#' . $cb_index . ' .p-cb__item-headline { color: ' . esc_attr( $cb_content['cb_headline_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_headline_font_size'] ) . 'px; }';
					$css_mobile[] = '#' . $cb_index . ' .p-cb__item-headline { font-size: ' . esc_attr( $cb_content['cb_headline_font_size_mobile'] ) . 'px; }';
				}
				$css[] = '#' . $cb_index . ' .slick-arrow { background-color: ' . esc_attr( $cb_content['cb_arrow_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_arrow_font_color'] ) . '; }';
				$css[] = '#' . $cb_index . ' .slick-arrow:hover { background-color: ' . esc_attr( $cb_content['cb_arrow_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_arrow_font_color_hover'] ) . '; }';
				if ( $cb_content['cb_show_archive_link'] && $cb_content['cb_archive_link_text'] ) {
					$css[] = '#' . $cb_index . ' .p-cb__item-archive-button { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color'] ) . '; }';
					$css[] = '#' . $cb_index . ' .p-cb__item-archive-button:hover { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color_hover'] ) . '; }';
				}
			}
		}
	}

	if ( $css ) {
		echo implode( "\n", $css ) . "\n";
	}
	if ( $css_mobile ) {
		echo "@media only screen and (max-width: 991px) {\n";
		echo "\t" . implode( "\n\t", $css_mobile ) . "\n";
		echo "}\n";
	}
}

/* Site info widget */
$css = array();
$css_mobile = array();
foreach( get_option( 'widget_site_info_widget', array() ) as $key => $value ) {
	if ( is_int( $key ) && ! empty( $value['title'] ) && ! empty( $value['title_font_size'] ) ) {
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__title { font-size: ' . esc_html( $value['title_font_size'] ) . 'px; }';
		if ( ! empty( $value['title_font_size_mobile'] ) ) {
			$css_mobile[] = '#site_info_widget-' . $key . ' .p-siteinfo__title { font-size: ' . esc_html( $value['title_font_size_mobile'] ) . 'px; }';
		}
	}
	if ( is_int( $key ) && ! empty( $value['button'] ) ) {
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__button { background: ' . esc_html( $value['button_bg_color'] ) . '; color: ' . esc_html( $value['button_font_color'] ) . '; }';
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__button:hover { background: ' . esc_html( $value['button_bg_color_hover'] ) . '; color: ' . esc_html( $value['button_font_color_hover'] ) . '; }';
	}
}
if ( $css ) {
	echo implode( "\n", $css ) . "\n";
}
if ( $css_mobile ) {
	echo "@media only screen and (max-width: 991px) {\n";
	echo "\t" . implode( "\n\t", $css_mobile ) . "\n";
	echo "}\n";
}
?>
<?php /* Custom CSS */ ?>
<?php if ( $dp_options['css_code'] ) { echo $dp_options['css_code']; } ?>
</style>
<?php
}
add_action( 'wp_head', 'tcd_head' );
// Custom head/script
function tcd_custom_head() {
  $dp_options = get_design_plus_option();

  if ( $dp_options['custom_head'] ) {
    echo $dp_options['custom_head'] . "\n";
  }
}
add_action( 'wp_head', 'tcd_custom_head', 9999 );