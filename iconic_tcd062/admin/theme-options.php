<?php
// 設定項目と無害化用コールバックを登録
function theme_options_init() {
	register_setting(
		'design_plus_options',
		'dp_options',
		'theme_options_validate'
	);
}
add_action( 'admin_init', 'theme_options_init' );

// 親メニュー・サブメニューを登録
function theme_options_add_page() {
	add_menu_page(
		__( 'TCD Theme', 'tcd-w' ),
		__( 'TCD Theme', 'tcd-w' ),
		'edit_theme_options',
		'theme_options',
		'theme_options_do_page',
		'',
		'2.0000012'	// ダッシュボードの下
	);
}
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * オプション初期値
 * @var array
 */
global $dp_default_options;
$dp_default_options = array(

	/**
	 * 基本設定
	 */
	// 色の設定
	'primary_color' => '#0097cc',
	'secondary_color' => '#006689',
	'content_link_color' => '#0097cc',

	// ファビコンの設定
	'favicon' => '',

	// フォントタイプ
	'font_type' => 'type2',

	// 大見出しのフォントタイプ
	'headline_font_type' => 'type3',

	// 絵文字の設定
	'use_emoji' => 0,

	// クイックタグの設定
	'use_quicktags' => 1,

	// サイドバーの設定
	'sidebar' => 'type2',

	// ロード画面の設定
	'use_load_icon' => 0,
	'load_icon' => 'type1',
	'load_time' => 3,
	'load_color1' => '#000000',
	'load_color2' => '#999999',

	// ホバーエフェクトの設定
	'hover_type' => 'type1',
	'hover1_zoom' => 1.2,
	'hover1_rotate' => 1,
	'hover1_opacity' => 1,
	'hover1_bgcolor' => '#000000',
	'hover2_direct' => 'type1',
	'hover2_opacity' => 0.5,
	'hover2_bgcolor' => '#000000',
	'hover3_opacity' => 0.5,
	'hover3_bgcolor' => '#000000',

	// Facebook OGPの設定
	'use_ogp' => 0,
	'fb_app_id' => '',
	'ogp_image' => '',

	// Twitter Cardsの設定
	'use_twitter_card' => 0,
	'twitter_account_name' => '',

	// SNSボタンの設定
	'instagram_url' => '',
	'twitter_url' => '',
	'pinterest_url' => '',
	'facebook_url' => '',
	'googleplus_url' => '',
	'youtube_url' => '',
	'contact_url' => '',
	'show_rss' => 0,

	// ソーシャルボタンの表示設定
	'sns_type_top' => 'type1',
	'show_twitter_top' => 1,
	'show_fblike_top' => 1,
	'show_fbshare_top' => 1,
	'show_hatena_top' => 1,
	'show_pocket_top' => 1,
	'show_feedly_top' => 1,
	'show_rss_top' => 1,
	'show_pinterest_top' => 1,
	'sns_type_btm' => 'type1',
	'show_twitter_btm' => 1,
	'show_fblike_btm' => 1,
	'show_fbshare_btm' => 1,
	'show_hatena_btm' => 1,
	'show_pocket_btm' => 1,
	'show_feedly_btm' => 1,
	'show_rss_btm' => 1,
	'show_pinterest_btm' => 1,
	'twitter_info' => '',

	// Google Map
	'gmap_api_key' => '',
	'gmap_marker_type' => 'type1',
	'gmap_custom_marker_type' => 'type1',
	'gmap_marker_text' => '',
	'gmap_marker_color' => '#ffffff',
	'gmap_marker_img' => '',
	'gmap_marker_bg' => '#000000',

	// カスタムCSS
	'css_code' => '',

	// Custom head/script
	'custom_head' => '',

	/**
	 * ロゴ
	 */
	// ヘッダーのロゴ
	'use_header_logo_image' => 'no',
	'logo_font_size' => 36,
	'header_logo_image' => '',
	'header_logo_image_retina' => 0,

	// ヘッダーのロゴ（スマホ用）
	'use_header_logo_image_mobile' => 'no',
	'logo_font_size_mobile' => 26,
	'header_logo_image_mobile' => '',
	'header_logo_image_mobile_retina' => 0,

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	'slide_time' => '7000',

	// ニュースティッカーの設定
	'show_index_news' => 1,
	'index_news_num' => 5,
	'show_index_news_date' => 1,
	'index_news_date_bg_color' => '#000000',
	'index_news_archive_link_text' => __( 'News archive', 'tcd-w' ),
	'index_news_archive_link_font_color' => '#ffffff',
	'index_news_archive_link_bg_color' => '#0097cc',
	'index_news_archive_link_font_color_hover' => '#ffffff',
	'index_news_archive_link_bg_color_hover' => '#006689',
	'index_news_slide_time' => '7000',

	// コンテンツビルダー
	'contents_builder' => array(
		array(
			'cb_content_select' => 'three_boxes',
			'cb_display' => 1,
			'cb_image1' => 0,
			'cb_headline1' => sprintf( __( 'Box%d', 'tcd-w' ), 1 ),
			'cb_headline_color1' => '#000000',
			'cb_headline_font_size1' => 34,
			'cb_headline_font_size_mobile1' => 30,
			'cb_desc1' => __( 'Enter description here.', 'tcd-w' ),
			'cb_desc_color1' => '#000000',
			'cb_desc_font_size1' => 14,
			'cb_desc_font_size_mobile1' => 12,
			'cb_url1' => '#',
			'cb_target_blank1' => 0,
			'cb_image2' => 0,
			'cb_headline2' => sprintf( __( 'Box%d', 'tcd-w' ), 2 ),
			'cb_headline_color2' => '#000000',
			'cb_headline_font_size2' => 34,
			'cb_headline_font_size_mobile2' => 30,
			'cb_desc2' => __( 'Enter description here.', 'tcd-w' ),
			'cb_desc_color2' => '#000000',
			'cb_desc_font_size2' => 14,
			'cb_desc_font_size_mobile2' => 12,
			'cb_url2' => '#',
			'cb_target_blank2' => 0,
			'cb_image3' => 0,
			'cb_headline3' => sprintf( __( 'Box%d', 'tcd-w' ), 3 ),
			'cb_headline_color3' => '#000000',
			'cb_headline_font_size3' => 34,
			'cb_headline_font_size_mobile3' => 30,
			'cb_desc3' => __( 'Enter description here.', 'tcd-w' ),
			'cb_desc_color3' => '#000000',
			'cb_desc_font_size3' => 14,
			'cb_desc_font_size_mobile3' => 12,
			'cb_url3' => '#',
			'cb_target_blank3' => 0,
			'cb_background_color' => '#ffffff'
		),
		array(
			'cb_content_select' => 'carousel',
			'cb_display' => 1,
			'cb_headline' => __( 'Carousel slider', 'tcd-w' ),
			'cb_headline_color' => '#000000',
			'cb_headline_font_size' => 34,
			'cb_headline_font_size_mobile' => 26,
			'cb_category' => 0,
			'cb_order' => 'date',
			'cb_post_num' => 10,
			'cb_slide_time' => '7000',
			'cb_arrow_font_color' => '#ffffff',
			'cb_arrow_bg_color' => '#0097cc',
			'cb_arrow_font_color_hover' => '#ffffff',
			'cb_arrow_bg_color_hover' => '#006689',
			'cb_show_archive_link' => 0,
			'cb_archive_link_text' => '',
			'cb_archive_link_font_color' => '#ffffff',
			'cb_archive_link_bg_color' => '#000000',
			'cb_archive_link_font_color_hover' => '#ffffff',
			'cb_archive_link_bg_color_hover' => '#006689',
			'cb_background_color' => '#ffffff'
		),
		array(
			'cb_content_select' => 'blog',
			'cb_display' => 1,
			'cb_headline' => __( 'BLOG', 'tcd-w' ),
			'cb_headline_color' => '#000000',
			'cb_headline_font_size' => 34,
			'cb_headline_font_size_mobile' => 26,
			'cb_desc' => __( 'Enter description here. Enter description here.', 'tcd-w' ),
			'cb_desc_color' => '#000000',
			'cb_desc_font_size' => 14,
			'cb_desc_font_size_mobile' => 14,
			'cb_list_type' => 'all',
			'cb_category' => 1,
			'cb_order' => 'date',
			'cb_post_num' => 6,
			'cb_show_category' => 1,
			'cb_show_date' => 1,
			'cb_exclude_item' => 1,
			'cb_show_archive_link' => 1,
			'cb_archive_link_text' => __( 'Blog archive', 'tcd-w' ),
			'cb_archive_link_font_color' => '#ffffff',
			'cb_archive_link_bg_color' => '#0097cc',
			'cb_archive_link_font_color_hover' => '#ffffff',
			'cb_archive_link_bg_color_hover' => '#006689',
			'cb_background_color' => '#f7f7f7'
		),
		array(
			'cb_content_select' => 'banner',
			'cb_display' => 1,
			'cb_image' => 0,
			'cb_headline' => __( 'Banner', 'tcd-w' ),
			'cb_headline_color' => '#000000',
			'cb_headline_font_size' => 34,
			'cb_headline_font_size_mobile' => 18,
			'cb_desc' => __( 'Enter description here. Enter description here.', 'tcd-w' ),
			'cb_desc_color' => '#000000',
			'cb_desc_font_size' => 14,
			'cb_desc_font_size_mobile' => 12,
			'cb_button_label' => __( 'Sample button', 'tcd-w' ),
			'cb_button_font_color' => '#ffffff',
			'cb_button_bg_color' => '#0097cc',
			'cb_button_font_color_hover' => '#ffffff',
			'cb_button_bg_color_hover' => '#006689',
			'cb_url' => '#',
			'cb_target_blank' => 0,
			'cb_background_color' => '#ffffff'
		)
	),

	/**
	 * ブログ
	 */
	// ブログの設定
	'blog_breadcrumb_label' => __( 'BLOG', 'tcd-w' ),
	'blog_header_headline' => 'BLOG',
	'blog_header_desc' => __( 'Enter description here. Enter description here.', 'tcd-w' ),

	// 記事詳細ページの設定
	'title_font_size' => 32,
	'title_font_size_mobile' => 20,
	'title_color' => '#000000',
	'content_font_size' => 14,
	'content_font_size_mobile' => 14,
	'content_color' => '#000000',
	'page_link' => 'type1',

	// 表示設定
	'show_thumbnail' => 1,
	'show_date' => 1,
	'show_category' => 1,
	'show_tag' => 1,
	'show_author' => 1,
	'show_sns_top' => 1,
	'show_sns_btm' => 1,
	'show_next_post' => 1,
	'show_comment' => 1,
	'show_trackback' => 1,

	// 関連記事の設定
	'show_related_post' => 1,
	'related_post_headline' => __( 'Related posts', 'tcd-w' ),
	'related_post_num' => 6,

	// 記事詳細の広告設定1
	'single_ad_code1' => '',
	'single_ad_image1' => false,
	'single_ad_url1' => '',
	'single_ad_code2' => '',
	'single_ad_image2' => false,
	'single_ad_url2' => '',

	// 記事詳細の広告設定2
	'single_ad_code3' => '',
	'single_ad_image3' => false,
	'single_ad_url3' => '',
	'single_ad_code4' => '',
	'single_ad_image4' => false,
	'single_ad_url4' => '',

	// スマートフォン専用の広告
	'single_mobile_ad_code1' => '',
	'single_mobile_ad_image1' => false,
	'single_mobile_ad_url1' => '',

	/**
	 * News
	 */
	 // お知らせの設定
	'news_breadcrumb_label' => __( 'News', 'tcd-w' ),
	'news_slug' => 'news',
	'news_header_headline' => __( 'News', 'tcd-w' ),
	'news_header_desc' => __( 'Enter description here. Enter description here.', 'tcd-w' ),

	// お知らせページの設定
	'news_title_font_size' => 28,
	'news_title_font_size_mobile' => 20,
	'news_title_color' => '#000000',
	'news_content_font_size' => 14,
	'news_content_font_size_mobile' => 14,
	'news_content_color' => '#000000',

	// 表示設定
	'archive_news_num' => 10,
	'show_date_news' => 1,
	'show_thumbnail_news' => 1,
	'show_next_post_news' => 1,
	'show_sns_top_news' => 1,
	'show_sns_btm_news' => 1,

	// 最新のお知らせの設定
	'show_recent_news' => 1,
	'recent_news_headline' => __( 'Recent news', 'tcd-w' ),
	'recent_news_num' => 5,
	'recent_news_link_text' => __( 'News archive', 'tcd-w' ),

	/**
	 * welcart
	 */
	// ヘッダーの設定
	'header_welcart_bg_color' => '#0097cc',
	'header_welcart_bg_color_hover' => '#006689',

	// サイドバーの設定
	'sidebar_welcart' => 'type1',

	// 商品ページの設定
	'item_title_font_size' => 28,
	'item_title_font_size_mobile' => 20,
	'item_title_color' => '#000000',
	'item_content_font_size' => 14,
	'item_content_font_size_mobile' => 14,
	'item_content_color' => '#000000',
	'item_price_font_size' => 22,
	'item_price_font_size_mobile' => 20,
	'item_price_color' => '#d80000',

	// 表示設定
	'show_date_item' => 0,
	'show_category_item' => 0,
	'show_comment_item' => 0,
	'show_discount_rate' => 0,

	// 関連商品の設定
	'show_related_item' => 1,
	'related_item_headline' => __( 'Related item', 'tcd-w' ),
	'related_item_num' => 6,

	// レコメンド商品の設定
	'show_recommend_item' => 1,
	'recommend_item_headline' => __( 'Customers who bought this item also bought', 'tcd-w' ),
	'recommend_item_num' => 6,

	/**
	 * ヘッダー
	 */
	// ヘッダーバーの表示位置
	'header_fix' => 'type2',

	// ヘッダーバーの表示位置（スマホ）
	'mobile_header_fix' => 'type2',

	// ヘッダーバーの色の設定
	'header_bg' => '#ffffff',
	'header_opacity' => 0.8,
	'header_font_color' => '#000000',

	// ヘッダー検索
	'show_header_search' => 1,
	'show_header_search_mobile' => 0,

	// グローバルメニュー設定
	'globalmenu_hover_underline_color' => '#000000',
	'submenu_color' => '#000000',
	'submenu_color_hover' => '#ffffff',
	'submenu_bg_color' => '#f7f7f7',
	'submenu_bg_color_hover' => '#006689',

	// グローバルメニュー表示設定
	'megamenu' => array(),

	// ページヘッダーの設定
	'page_header_headline_color' => '#0097cc',
	'page_header_desc_color' => '#000000',
	'page_header_bg_color' => '#f7f7f7',

	/**
	 * フッター
	 */
	// フッター検索
	'show_footer_search_mobile' => 1,

	// フッターウィジェットの設定
	'footer_widget_title_color' => '#000000',
	'footer_widget_text_color' => '#000000',
	'footer_widget_link_color' => '#000000',
	'footer_widget_link_color_hover' => '#006689',
	'footer_widget_bg_color' => '#f7f7f7',

	// スマホ用固定フッターバーの設定
	'footer_bar_display' => 'type3',
	'footer_bar_tp' => 0.8,
	'footer_bar_bg' => '#ffffff',
	'footer_bar_border' => '#dddddd',
	'footer_bar_color' => '#000000',
	'footer_bar_btns' => array(
		array(
			'type' => 'type1',
			'label' => '',
			'url' => '',
			'number' => '',
			'target' => 0,
			'icon' => 'file-text'
		)
	),

	/**
	 * 404 ページ
	 */
	'image_404' => '',
	'overlay_404' => '#000000',
	'overlay_opacity_404' => 0.2,
	'catchphrase_404' => __( '404 Not Found', 'tcd-w' ),
'desc_404' => __( 'The page you were looking for could not be found', 'tcd-w' ),
	'catchphrase_font_size_404' => 30,
	'desc_font_size_404' => 14,
	'color_404' => '#ffffff',
	'shadow1_404' => 0,
	'shadow2_404' => 0,
	'shadow3_404' => 0,
	'shadow_color_404' => '#999999',

	/**
	 * ページ保護
	 */
	'pw_label' => '',
	'pw_align' => 'type1',
	'pw_name1' => '',
	'pw_name2' => '',
	'pw_name3' => '',
	'pw_name4' => '',
	'pw_name5' => '',
	'pw_btn_display1' => '',
	'pw_btn_display2' => '',
	'pw_btn_display3' => '',
	'pw_btn_display4' => '',
	'pw_btn_display5' => '',
	'pw_btn_label1' => '',
	'pw_btn_label2' => '',
	'pw_btn_label3' => '',
	'pw_btn_label4' => '',
	'pw_btn_label5' => '',
	'pw_btn_url1' => '',
	'pw_btn_url2' => '',
	'pw_btn_url3' => '',
	'pw_btn_url4' => '',
	'pw_btn_url5' => '',
	'pw_btn_target1' => 0,
	'pw_btn_target2' => 0,
	'pw_btn_target3' => 0,
	'pw_btn_target4' => 0,
	'pw_btn_target5' => 0,
	'pw_editor1' => '',
	'pw_editor2' => '',
	'pw_editor3' => '',
	'pw_editor4' => '',
	'pw_editor5' => ''
);

// オプション初期値ループ項目
for ( $i = 1; $i <= 5; $i++ ) {
	$dp_default_options['slider_image' . $i] = '';
	$dp_default_options['slider_image_sp' . $i] = '';
	$dp_default_options['slider_url' . $i] = '';
	$dp_default_options['slider_target' . $i] = 0;
	$dp_default_options['display_slider_headline' . $i] = 0;
	$dp_default_options['slider_headline' . $i] = '';
	$dp_default_options['display_slider_button' . $i] = 0;
	$dp_default_options['slider_button_label' . $i] = '';
	$dp_default_options['slider_button_font_color' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color' . $i] = '#0097cc';
	$dp_default_options['slider_button_font_color_hover' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color_hover' . $i] = '#006689';
	$dp_default_options['display_slider_catch' . $i] = 0;
	$dp_default_options['slider_catch' . $i] = '';
	$dp_default_options['slider_catch_font_size' . $i] = 34;
	$dp_default_options['slider_catch_font_size_mobile' . $i] = 16;
	$dp_default_options['slider_catch_color' . $i] = '#000000';
	$dp_default_options['slider_catch_color_mobile' . $i] = '#000000';
	$dp_default_options['slider_catch_align' . $i] = 'type1';
	$dp_default_options['slider_catch' . $i . '_shadow1'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow2'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow3'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow_color'] = '#999999';
	$dp_default_options['slider_catch_bg_color' . $i] = '#ffffff';
	$dp_default_options['slider_catch_bg_opacity' . $i] = 0.5;
	$dp_default_options['display_slider_overlay' . $i] = 0;
	$dp_default_options['slider_overlay_color' . $i] = '#ffffff';
	$dp_default_options['slider_overlay_opacity' . $i] = 0.5;
}
for ( $i = 1; $i <= 3; $i++ ) {
	$dp_default_options['display_slider_catch' . $i] = 1;
	$dp_default_options['slider_catch' . $i] = sprintf( __( 'Catchphrase for slider %d', 'tcd-w' ), $i ) . "\n" . sprintf( __( 'Catchphrase for slider %d', 'tcd-w' ), $i );
	$dp_default_options['slider_url' . $i] = '#';
	$dp_default_options['slider_target' . $i] = 0;
	$dp_default_options['display_slider_headline' . $i] = 1;
	$dp_default_options['slider_headline' . $i] = sprintf( __( 'Headline for slider %d', 'tcd-w' ), $i );
	$dp_default_options['display_slider_button' . $i] = 1;
	$dp_default_options['slider_button_label' . $i] = __( 'Sample button', 'tcd-w' );
}

/**
 * Design Plus のオプションを返す
 *
 * @global array $dp_default_options
 * @return array
 */
function get_design_plus_option() {
	global $dp_default_options;
	return shortcode_atts( $dp_default_options, get_option( 'dp_options', array() ) );
}

// フォントタイプ
global $font_type_options;
$font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// 大見出しのフォントタイプ
global $headline_font_type_options;
$headline_font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// サイドバーの設定
global $sidebar_options;
$sidebar_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Display on left side', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/sidebar_type1.png'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Display on right side', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/sidebar_type2.png'
	)
);

// ローディングアイコンの種類の設定
global $load_icon_options;
$load_icon_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Circle', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Square', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Dot', 'tcd-w' )
	)
);

// ロード画面の設定
global $load_time_options;
for ( $i = 3; $i <= 10; $i++ ) {
	$load_time_options[$i * 1000] = array( 'value' => $i * 1000, 'label' => $i );
}

// ホバーエフェクトの設定
global $hover_type_options;
$hover_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Zoom', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Slide', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Fade', 'tcd-w' )
	)
);
global $hover2_direct_options;
$hover2_direct_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Left to Right', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Right to Left', 'tcd-w' )
	)
);

// ロゴに画像を使うか否か
global $logo_type_options;
$logo_type_options = array(
	'no' => array(
		'value' => 'no',
		'label' => __( 'Use text for logo', 'tcd-w' )
	),
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Use image for logo', 'tcd-w' )
	)
);

// Google Maps
global $gmap_marker_type_options;
$gmap_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Use default marker', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/gmap_marker_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Use custom marker', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/gmap_marker_type2.jpg'
	)
);
global $gmap_custom_marker_type_options;
$gmap_custom_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Text', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Image', 'tcd-w' )
	)
);

// ヘッダーバーの表示位置
global $header_fix_options;
$header_fix_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Normal header', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Fix at top after page scroll', 'tcd-w' )
	)
);

// 記事タイプ
global $list_type_options;
$list_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Category', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Recommend post', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Recommend post2', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Pickup post', 'tcd-w' )
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'All posts', 'tcd-w' )
	)
);

// ページナビ
global $page_link_options;
$page_link_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Page numbers', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/page_link_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Read more button', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/page_link_type2.jpg'
	)
);


// ブログ表示順
global $post_order_options;
$post_order_options = array(
	'date1' => array(
		'value' => 'date1',
		'label' => __( 'Date (DESC)', 'tcd-w' )
	),
	'date2' => array(
		'value' => 'date2',
		'label' => __( 'Date (ASC)', 'tcd-w' )
	),
	'rand' => array(
		'value' => 'rand',
		'label' => __( 'Random', 'tcd-w' )
	)
);

// text align
global $text_align_options;
$text_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Align right', 'tcd-w' )
	)
);

// スライダーが切り替わるスピード
global $slide_time_options;
for ( $i = 3; $i <= 15; $i++ ) {
	$slide_time_options[$i * 1000] = array( 'value' => $i * 1000, 'label' => $i );
}

// 記事上ボタンタイプ
global $sns_type_top_options;
$sns_type_top_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'style1', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'style2', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type2.jpg'
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'style3', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type3.jpg'
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'style4', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type4.jpg'
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'style5', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type5.jpg'
	)
);

// 記事下ボタンタイプ
global $sns_type_btm_options;
$sns_type_btm_options = $sns_type_top_options;

// フッターの固定メニュー 表示タイプ
global $footer_bar_display_options;
$footer_bar_display_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Hide', 'tcd-w' ) )
);

// フッターバーボタンのタイプ
global $footer_bar_button_options;
$footer_bar_button_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Default', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Share', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Telephone', 'tcd-w' ) )
);

// フッターバーボタンのアイコン
global $footer_bar_icon_options;
$footer_bar_icon_options = array(
	'file-text' => array(
		'value' => 'file-text',
		'label' => __( 'Document', 'tcd-w' )
	),
	'share-alt' => array(
		'value' => 'share-alt',
		'label' => __( 'Share', 'tcd-w' )
	),
	'phone' => array(
		'value' => 'phone',
		'label' => __( 'Telephone', 'tcd-w' )
	),
	'envelope' => array(
		'value' => 'envelope',
		'label' => __( 'Envelope', 'tcd-w' )
	),
	'tag' => array(
		'value' => 'tag',
		'label' => __( 'Tag', 'tcd-w' )
	),
	'pencil' => array(
		'value' => 'pencil',
		'label' => __( 'Pencil', 'tcd-w' )
	)
);

// 保護ページalign
global $pw_align_options;
$pw_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	)
);

// メガメニュー
global $megamenu_options;
$megamenu_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Dropdown menu', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Mega menu A', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu2.jpg'
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Mega menu B', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu3.jpg'
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Mega menu C', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu4.jpg'
	)
);

// テーマオプション画面の作成
function theme_options_do_page() {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$tabs = array(
		// 基本設定
		array(
			'label' => __( 'Basic', 'tcd-w' ),
			'template_part' => 'admin/inc/basic',
		),
		// ロゴの設定
		array(
			'label' => __( 'Logo', 'tcd-w' ),
			'template_part' => 'admin/inc/logo',
		),
		// トップページ
		array(
			'label' => __( 'Index', 'tcd-w' ),
			'template_part' => 'admin/inc/top',
		),
		// ブログ
		array(
			'label' => __( 'Blog', 'tcd-w' ),
			'template_part' => 'admin/inc/blog',
		),
		// News
		array(
			'label' => __( 'News', 'tcd-w' ),
			'template_part' => 'admin/inc/news',
		),
		// Welcart
		array(
			'label' => __( 'Welcart', 'tcd-w' ),
			'template_part' => 'admin/inc/welcart',
		),
		// ヘッダー
		array(
			'label' => __( 'Header', 'tcd-w' ),
			'template_part' => 'admin/inc/header',
		),
		// フッター
		array(
			'label' => __( 'Footer', 'tcd-w' ),
			'template_part' => 'admin/inc/footer',
		),
		// 404 ページ
		array(
			'label' => __( '404 page', 'tcd-w' ),
			'template_part' => 'admin/inc/404',
		),
		// ページ保護
		array(
			'label' => __( 'Password protected pages', 'tcd-w' ),
			'template_part' => 'admin/inc/password',
		),
		// Tools
		array(
			'label' => __( 'Tools', 'tcd-w' ),
			'template_part' => 'admin/inc/tools',
		)
	);

?>
<div class="wrap">
	<h2><?php _e( 'TCD Theme Options', 'tcd-w' ); ?></h2>
<?php
	// 更新時のメッセージ
	if ( ! empty( $_REQUEST['settings-updated'] ) ) :
?>
	<div class="updated fade">
		<p><strong><?php _e( 'Updated', 'tcd-w' ); ?></strong></p>
	</div>
<?php
	endif;

	// Toolsメッセージ
	theme_options_tools_notices();
?>
	<div id="tcd_theme_option" class="cf">
		<div id="tcd_theme_left">
			<ul id="theme_tab" class="cf">
<?php
	foreach ( $tabs as $key => $tab ):
?>
				<li><a href="#tab-content<?php echo esc_attr( $key + 1 ); ?>"><?php echo esc_html( $tab['label'] ); ?></a></li>
<?php
	endforeach;
?>
			</ul>
		</div>
		<div id="tcd_theme_right">
			<form method="post" action="options.php" enctype="multipart/form-data">
<?php
	settings_fields( 'design_plus_options' );
?>
				<div id="tab-panel">
<?php
	foreach ( $tabs as $key => $tab ):
?>
					<div id="#tab-content<?php echo esc_attr( $key + 1 ); ?>">
<?php
		if ( !empty( $tab['template_part'] ) ) :
			get_template_part( $tab['template_part'] );
		endif;
?>
					</div>
<?php
	endforeach;
?>
				</div><!-- END #tab-panel -->
			</form>
			<div id="saved_data"></div>
			<div id="saving_data" style="display:none;"><p><?php _e('Now saving...', 'tcd-w'); ?></p></div>
		</div><!-- END #tcd_theme_right -->
	</div><!-- END #tcd_theme_option -->
</div><!-- END #wrap -->
<?php
}

/**
 * チェック
 */
function theme_options_validate( $input ) {
	global $dp_default_options, $font_type_options, $headline_font_type_options, $sidebar_options, $load_icon_options, $load_time_options, $logo_type_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options, $gmap_marker_type_options, $gmap_custom_marker_type_options, $header_fix_options, $list_type_options, $post_order_options, $page_link_options, $text_align_options, $slide_time_options, $footer_bar_display_options, $footer_bar_icon_options, $footer_bar_button_options, $pw_align_options, $megamenu_options;

	// 色の設定
	$input['primary_color'] = wp_filter_nohtml_kses( $input['primary_color'] );
	$input['secondary_color'] = wp_filter_nohtml_kses( $input['secondary_color'] );
	$input['content_link_color'] = wp_filter_nohtml_kses( $input['content_link_color'] );

	// ファビコン
	$input['favicon'] = wp_filter_nohtml_kses( $input['favicon'] );

	// フォントの種類
	if ( ! isset( $input['font_type'] ) || ! array_key_exists( $input['font_type'], $font_type_options ) )
		$input['font_type'] = $dp_default_options['font_type'];

	// 大見出しのフォントタイプ
	if ( ! isset( $input['headline_font_type'] ) || ! array_key_exists( $input['headline_font_type'], $headline_font_type_options ) )
		$input['headline_font_type'] = $dp_default_options['headline_font_type'];

	// 絵文字の設定
	$input['use_emoji'] = ! empty( $input['use_emoji'] ) ? 1 : 0;

	// クイックタグの設定
	$input['use_quicktags'] = ! empty( $input['use_quicktags'] ) ? 1 : 0;

	// サイドバーの設定
	if ( ! isset( $input['sidebar'] ) || ! array_key_exists( $input['sidebar'], $sidebar_options ) )
		$input['sidebar'] = $dp_default_options['sidebar'];

	// ロード画面の設定
	$input['use_load_icon'] = ! empty( $input['use_load_icon'] ) ? 1 : 0;
	if ( ! isset( $input['load_icon'] ) || ! array_key_exists( $input['load_icon'], $load_icon_options ) )
		$input['load_icon'] = $dp_default_options['load_icon'];
	if ( ! isset( $input['load_time'] ) || ! array_key_exists( $input['load_time'], $load_time_options ) )
		$input['load_time'] = $dp_default_options['load_time'];
	$input['load_color1'] = wp_filter_nohtml_kses( $input['load_color1'] );
	$input['load_color2'] = wp_filter_nohtml_kses( $input['load_color2'] );

	// ホバーエフェクトの設定
	if ( ! isset( $input['hover_type'] ) || ! array_key_exists( $input['hover_type'], $hover_type_options ) )
		$input['hover_type'] = $dp_default_options['hover_type'];
	$input['hover1_zoom'] = wp_filter_nohtml_kses( $input['hover1_zoom'] );
	$input['hover1_rotate'] = ! empty( $input['hover1_rotate'] ) ? 1 : 0;
	$input['hover1_opacity'] = wp_filter_nohtml_kses( $input['hover1_opacity'] );
	$input['hover1_bgcolor'] = wp_filter_nohtml_kses( $input['hover1_bgcolor'] );
	if ( ! isset( $input['hover2_direct'] ) || ! array_key_exists( $input['hover2_direct'], $hover2_direct_options ) )
		$input['hover2_direct'] = $dp_default_options['hover2_direct'];
	$input['hover2_opacity'] = wp_filter_nohtml_kses( $input['hover2_opacity'] );
	$input['hover2_bgcolor'] = wp_filter_nohtml_kses( $input['hover2_bgcolor'] );
	$input['hover3_opacity'] = wp_filter_nohtml_kses( $input['hover3_opacity'] );
	$input['hover3_bgcolor'] = wp_filter_nohtml_kses( $input['hover3_bgcolor'] );

	// Facebook OGPの設定
	$input['use_ogp'] = ! empty( $input['use_ogp'] ) ? 1 : 0;
	$input['fb_app_id'] = wp_filter_nohtml_kses( $input['fb_app_id'] );
	$input['ogp_image'] = wp_filter_nohtml_kses( $input['ogp_image'] );

	// Twitter Cardsの設定
	$input['use_twitter_card'] = ! empty( $input['use_twitter_card'] ) ? 1 : 0;
	$input['twitter_account_name'] = wp_filter_nohtml_kses( $input['twitter_account_name'] );

	// SNSボタンの設定
	$input['instagram_url'] = wp_filter_nohtml_kses( $input['instagram_url'] );
	$input['twitter_url'] = wp_filter_nohtml_kses( $input['twitter_url'] );
	$input['pinterest_url'] = wp_filter_nohtml_kses( $input['pinterest_url'] );
	$input['facebook_url'] = wp_filter_nohtml_kses( $input['facebook_url'] );
	$input['googleplus_url'] = wp_filter_nohtml_kses( $input['googleplus_url'] );
	$input['youtube_url'] = wp_filter_nohtml_kses( $input['youtube_url'] );
	$input['contact_url'] = wp_filter_nohtml_kses( $input['contact_url'] );
	$input['show_rss'] = ! empty( $input['show_rss'] ) ? 1 : 0;

	// ソーシャルボタンの表示設定
	if ( ! isset( $input['sns_type_top'] ) || ! array_key_exists( $input['sns_type_top'], $sns_type_top_options ) )
		$input['sns_type_top'] = $dp_default_options['sns_type_top'];
	$input['show_sns_top'] = ! empty( $input['show_sns_top'] ) ? 1 : 0;
	$input['show_twitter_top'] = ! empty( $input['show_twitter_top'] ) ? 1 : 0;
	$input['show_fblike_top'] = ! empty( $input['show_fblike_top'] ) ? 1 : 0;
	$input['show_fbshare_top'] = ! empty( $input['show_fbshare_top'] ) ? 1 : 0;
	$input['show_hatena_top'] = ! empty( $input['show_hatena_top'] ) ? 1 : 0;
	$input['show_pocket_top'] = ! empty( $input['show_pocket_top'] ) ? 1 : 0;
	$input['show_feedly_top'] = ! empty( $input['show_feedly_top'] ) ? 1 : 0;
	$input['show_rss_top'] = ! empty( $input['show_rss_top'] ) ? 1 : 0;
	$input['show_pinterest_top'] = ! empty( $input['show_pinterest_top'] ) ? 1 : 0;

	if ( ! isset( $input['sns_type_btm'] ) || ! array_key_exists( $input['sns_type_btm'], $sns_type_btm_options ) )
		$input['sns_type_btm'] = $dp_default_options['sns_type_btm'];
	$input['show_sns_btm'] = ! empty( $input['show_sns_btm'] ) ? 1 : 0;
	$input['show_twitter_btm'] = ! empty( $input['show_twitter_btm'] ) ? 1 : 0;
	$input['show_fblike_btm'] = ! empty( $input['show_fblike_btm'] ) ? 1 : 0;
	$input['show_fbshare_btm'] = ! empty( $input['show_fbshare_btm'] ) ? 1 : 0;
	$input['show_hatena_btm'] = ! empty( $input['show_hatena_btm'] ) ? 1 : 0;
	$input['show_pocket_btm'] = ! empty( $input['show_pocket_btm'] ) ? 1 : 0;
	$input['show_feedly_btm'] = ! empty( $input['show_feedly_btm'] ) ? 1 : 0;
	$input['show_rss_btm'] = ! empty( $input['show_rss_btm'] ) ? 1 : 0;
	$input['show_pinterest_btm'] = ! empty( $input['show_pinterest_btm'] ) ? 1 : 0;

	// Google Maps 
	$input['gmap_api_key'] = wp_filter_nohtml_kses( $input['gmap_api_key'] );
	if ( ! isset( $input['gmap_marker_type'] ) || ! array_key_exists( $input['gmap_marker_type'], $gmap_marker_type_options ) )
		$input['gmap_marker_type'] = $dp_default_options['gmap_marker_type'];
	if ( ! isset( $input['gmap_custom_marker_type'] ) || ! array_key_exists( $input['gmap_custom_marker_type'], $gmap_custom_marker_type_options ) )
		$input['gmap_custom_marker_type'] = $dp_default_options['gmap_custom_marker_type'];
	$input['gmap_marker_text'] = wp_filter_nohtml_kses( $input['gmap_marker_text'] );
	$input['gmap_marker_color'] = wp_filter_nohtml_kses( $input['gmap_marker_color'] );
	$input['gmap_marker_img'] = wp_filter_nohtml_kses( $input['gmap_marker_img'] );
	$input['gmap_marker_bg'] = wp_filter_nohtml_kses( $input['gmap_marker_bg'] );

	// オリジナルスタイルの設定
	$input['css_code'] = $input['css_code'];

	// Custom head/script
	$input['custom_head'] = $input['custom_head'];

	// ロゴのタイプ

	// ヘッダーのロゴ
	if ( ! isset( $input['use_header_logo_image'] ) || ! array_key_exists( $input['use_header_logo_image'], $logo_type_options ) )
		$input['use_header_logo_image'] = $dp_default_options['use_header_logo_image'];
	$input['logo_font_size'] = wp_filter_nohtml_kses( $input['logo_font_size'] );
	$input['header_logo_image'] = wp_filter_nohtml_kses( $input['header_logo_image'] );
	$input['header_logo_image_retina'] = ! empty( $input['header_logo_image_retina'] ) ? 1 : 0;

	// ヘッダーのロゴ（スマホ用）
	if ( ! isset( $input['use_header_logo_image_mobile'] ) || ! array_key_exists( $input['use_header_logo_image_mobile'], $logo_type_options ) )
		$input['use_header_logo_image_mobile'] = $dp_default_options['use_header_logo_image_mobile'];
	$input['logo_font_size_mobile'] = wp_filter_nohtml_kses( $input['logo_font_size_mobile'] );
	$input['header_logo_image_mobile'] = wp_filter_nohtml_kses( $input['header_logo_image_mobile'] );
	$input['header_logo_image_mobile_retina'] = ! empty( $input['header_logo_image_mobile_retina'] ) ? 1 : 0;

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	for ( $i = 1; $i <= 5; $i++ ) {
		$input['slider_image' . $i] = wp_filter_nohtml_kses( $input['slider_image' . $i] );
		$input['slider_image_sp' . $i] = wp_filter_nohtml_kses( $input['slider_image_sp' . $i] );
		$input['slider_url' . $i] = wp_filter_nohtml_kses( $input['slider_url' . $i] );
		$input['slider_target' . $i] = ! empty( $input['slider_target' . $i] ) ? 1 : 0;
		$input['display_slider_headline' . $i] = ! empty( $input['display_slider_headline' . $i] ) ? 1 : 0;
		$input['slider_headline' . $i] = wp_filter_nohtml_kses( $input['slider_headline' . $i] );
		$input['display_slider_button' . $i] = ! empty( $input['display_slider_button' . $i] ) ? 1 : 0;
		$input['slider_button_label' . $i] = wp_filter_nohtml_kses( $input['slider_button_label' . $i] );
		$input['slider_button_font_color' . $i] = wp_filter_nohtml_kses( $input['slider_button_font_color' . $i] );
		$input['slider_button_bg_color' . $i] = wp_filter_nohtml_kses( $input['slider_button_bg_color' . $i] );
		$input['slider_button_font_color_hover' . $i] = wp_filter_nohtml_kses( $input['slider_button_font_color_hover' . $i] );
		$input['slider_button_bg_color_hover' . $i] = wp_filter_nohtml_kses( $input['slider_button_bg_color_hover' . $i] );
		$input['display_slider_catch' . $i] = ! empty( $input['display_slider_catch' . $i] ) ? 1 : 0;
		$input['slider_catch_font_size' . $i] = intval( $input['slider_catch_font_size' . $i] );
		$input['slider_catch_font_size_mobile' . $i] = intval( $input['slider_catch_font_size_mobile' . $i] );
		$input['slider_catch_color' . $i] = wp_filter_nohtml_kses( $input['slider_catch_color' . $i] );
		$input['slider_catch_color_mobile' . $i] = wp_filter_nohtml_kses( $input['slider_catch_color_mobile' . $i] );
		if ( ! isset( $input['slider_catch_align' . $i] ) || ! array_key_exists( $input['slider_catch_align' . $i], $text_align_options ) )
			$input['slider_catch_align' . $i] = $dp_default_options['slider_catch_align' . $i];
		$input['slider_catch' . $i . '_shadow1'] = intval( $input['slider_catch' . $i . '_shadow1'] );
		$input['slider_catch' . $i . '_shadow2'] = intval( $input['slider_catch' . $i . '_shadow2'] );
		$input['slider_catch' . $i . '_shadow3'] = intval( $input['slider_catch' . $i . '_shadow3'] );
		$input['slider_catch' . $i . '_shadow_color'] = wp_filter_nohtml_kses( $input['slider_catch' . $i . '_shadow_color'] );
		$input['slider_catch_bg_color' . $i] = wp_filter_nohtml_kses( $input['slider_catch_bg_color' . $i] );
		$input['slider_catch_bg_opacity' . $i] = wp_filter_nohtml_kses( $input['slider_catch_bg_opacity' . $i] );
		$input['display_slider_overlay' . $i] = ! empty( $input['display_slider_overlay' . $i] ) ? 1 : 0;
		$input['slider_overlay_color' . $i] = wp_filter_nohtml_kses( $input['slider_overlay_color' . $i] );
		$input['slider_overlay_opacity' . $i] = wp_filter_nohtml_kses( $input['slider_overlay_opacity' . $i] );
	}

	if ( ! isset( $input['slide_time'] ) || ! array_key_exists( $input['slide_time'], $slide_time_options ) )
		$input['slide_time'] = $dp_default_options['slide_time'];

	// ニュースティッカーの設定
	$input['show_index_news'] = ! empty( $input['show_index_news'] ) ? 1 : 0;
	$input['index_news_num'] = intval( $input['index_news_num'] );
	$input['show_index_news_date'] = ! empty( $input['show_index_news_date'] ) ? 1 : 0;
	$input['index_news_archive_link_text'] = wp_filter_nohtml_kses( $input['index_news_archive_link_text'] );
	$input['index_news_archive_link_font_color'] = wp_filter_nohtml_kses( $input['index_news_archive_link_font_color'] );
	$input['index_news_archive_link_bg_color'] = wp_filter_nohtml_kses( $input['index_news_archive_link_bg_color'] );
	$input['index_news_archive_link_font_color_hover'] = wp_filter_nohtml_kses( $input['index_news_archive_link_font_color_hover'] );
	$input['index_news_archive_link_bg_color_hover'] = wp_filter_nohtml_kses( $input['index_news_archive_link_bg_color_hover'] );
	if ( ! isset( $input['index_news_slide_time'] ) || ! array_key_exists( $input['index_news_slide_time'], $slide_time_options ) )
		$input['index_news_slide_time'] = $dp_default_options['index_news_slide_time'];

	/**
	 * ブログ
	 */
	 // ブログの設定
	$input['blog_breadcrumb_label'] = wp_filter_nohtml_kses( $input['blog_breadcrumb_label'] );
	$input['blog_header_headline'] = wp_filter_nohtml_kses( $input['blog_header_headline'] );
	$input['blog_header_desc'] = wp_filter_nohtml_kses( $input['blog_header_desc'] );

	// 記事詳細ページの設定
	$input['title_font_size'] = intval( $input['title_font_size'] );
	$input['title_font_size_mobile'] = intval( $input['title_font_size_mobile'] );
	$input['title_color'] = wp_filter_nohtml_kses( $input['title_color'] );
	$input['content_font_size'] = intval( $input['content_font_size'] );
	$input['content_font_size_mobile'] = intval( $input['content_font_size_mobile'] );
	$input['content_color'] = wp_filter_nohtml_kses( $input['content_color'] );

	if ( ! isset( $input['page_link'] ) || ! array_key_exists( $input['page_link'], $page_link_options ) )
		$input['page_link'] = $dp_default_options['page_link'];

	// 表示設定
	$input['show_thumbnail'] = ! empty( $input['show_thumbnail'] ) ? 1 : 0;
	$input['show_date'] = ! empty( $input['show_date'] ) ? 1 : 0;
	$input['show_category'] = ! empty( $input['show_category'] ) ? 1 : 0;
	$input['show_tag'] = ! empty( $input['show_tag'] ) ? 1 : 0;
	$input['show_author'] = ! empty( $input['show_author'] ) ? 1 : 0;
	$input['show_next_post'] = ! empty( $input['show_next_post'] ) ? 1 : 0;
	$input['show_comment'] = ! empty( $input['show_comment'] ) ? 1 : 0;
	$input['show_trackback'] = ! empty( $input['show_trackback'] ) ? 1 : 0;

	// 関連記事の設定
	$input['show_related_post'] = ! empty( $input['show_related_post'] ) ? 1 : 0;
	$input['related_post_headline'] = wp_filter_nohtml_kses( $input['related_post_headline'] );
	$input['related_post_num'] = intval( $input['related_post_num'] );

	// 記事ページの広告設定1, 2
	for ( $i = 1; $i <= 4; $i++ ) {
		$input['single_ad_code' . $i] = $input['single_ad_code' . $i];
		$input['single_ad_image' . $i] = wp_filter_nohtml_kses( $input['single_ad_image' . $i] );
		$input['single_ad_url' . $i] = wp_filter_nohtml_kses( $input['single_ad_url' . $i] );
	}

	// スマートフォン専用の広告
	$input['single_mobile_ad_code1'] = $input['single_mobile_ad_code1'];
	$input['single_mobile_ad_image1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_image1'] );
	$input['single_mobile_ad_url1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_url1'] );

	 // お知らせの設定
	$input['news_breadcrumb_label'] = wp_filter_nohtml_kses( $input['news_breadcrumb_label'] );
	if ( ! $input['news_breadcrumb_label'] )
		$input['news_breadcrumb_label'] = $dp_default_options['news_breadcrumb_label'];
	if ( $input['news_slug'] )
		$input['news_slug'] = trim( $input['news_slug'] );
	if ( ! $input['news_slug'] )
		$input['news_slug'] = $dp_default_options['news_slug'];
	$input['news_slug'] = sanitize_title( $input['news_slug'] );
	$input['news_header_headline'] = wp_filter_nohtml_kses( $input['news_header_headline'] );
	$input['news_header_desc'] = wp_filter_nohtml_kses( $input['news_header_desc'] );

	// お知らせページの設定
	$input['news_title_font_size'] = intval( $input['news_title_font_size'] );
	$input['news_title_font_size_mobile'] = intval( $input['news_title_font_size_mobile'] );
	$input['news_title_color'] = wp_filter_nohtml_kses( $input['news_title_color'] );
	$input['news_content_font_size'] = intval( $input['news_content_font_size'] );
	$input['news_content_font_size_mobile'] = intval( $input['news_content_font_size_mobile'] );
	$input['news_content_color'] = wp_filter_nohtml_kses( $input['news_content_color'] );

	// 表示設定
	$input['archive_news_num'] = intval( $input['archive_news_num'] );
	$input['show_date_news'] = ! empty( $input['show_date_news'] ) ? 1 : 0;
	$input['show_thumbnail_news'] = ! empty( $input['show_thumbnail_news'] ) ? 1 : 0;
	$input['show_next_post_news'] = ! empty( $input['show_next_post_news'] ) ? 1 : 0;
	$input['show_sns_top_news'] = ! empty( $input['show_sns_top_news'] ) ? 1 : 0;
	$input['show_sns_btm_news'] = ! empty( $input['show_sns_btm_news'] ) ? 1 : 0;

	// 最新のお知らせの設定
	$input['show_recent_news'] = ! empty( $input['show_recent_news'] ) ? 1 : 0;
	$input['recent_news_headline'] = wp_filter_nohtml_kses( $input['recent_news_headline'] );
	$input['recent_news_num'] = intval( $input['recent_news_num'] );

	$input['recent_news_link_text'] = wp_filter_nohtml_kses( $input['recent_news_link_text'] );

	// Welcart ヘッダーの設定
	$input['header_welcart_bg_color'] = wp_filter_nohtml_kses( $input['header_welcart_bg_color'] );
	$input['header_welcart_bg_color_hover'] = wp_filter_nohtml_kses( $input['header_welcart_bg_color_hover'] );

	// Welcart サイドバーの設定
	if ( ! isset( $input['sidebar_welcart'] ) || ! array_key_exists( $input['sidebar_welcart'], $sidebar_options ) )
		$input['sidebar_welcart'] = $dp_default_options['sidebar_welcart'];

	// 商品ページの設定
	$input['item_title_font_size'] = intval( $input['item_title_font_size'] );
	$input['item_title_font_size_mobile'] = intval( $input['item_title_font_size_mobile'] );
	$input['item_title_color'] = wp_filter_nohtml_kses( $input['item_title_color'] );
	$input['item_content_font_size'] = intval( $input['item_content_font_size'] );
	$input['item_content_font_size_mobile'] = intval( $input['item_content_font_size_mobile'] );
	$input['item_content_color'] = wp_filter_nohtml_kses( $input['item_content_color'] );
	$input['item_price_font_size'] = intval( $input['item_price_font_size'] );
	$input['item_price_font_size_mobile'] = intval( $input['item_price_font_size_mobile'] );
	$input['item_price_color'] = wp_filter_nohtml_kses( $input['item_price_color'] );

	// 表示設定
	$input['show_date_item'] = ! empty( $input['show_date_item'] ) ? 1 : 0;
	$input['show_category_item'] = ! empty( $input['show_category_item'] ) ? 1 : 0;
	$input['show_comment_item'] = ! empty( $input['show_comment_item'] ) ? 1 : 0;
	$input['show_discount_rate'] = ! empty( $input['show_discount_rate'] ) ? 1 : 0;

	// 関連商品の設定
	$input['show_related_item'] = ! empty( $input['show_related_item'] ) ? 1 : 0;
	$input['related_item_headline'] = wp_filter_nohtml_kses( $input['related_item_headline'] );
	$input['related_item_num'] = intval( $input['related_item_num'] );

	// レコメンド商品の設定
	$input['show_recommend_item'] = ! empty( $input['show_recommend_item'] ) ? 1 : 0;
	$input['recommend_item_headline'] = wp_filter_nohtml_kses( $input['recommend_item_headline'] );
	$input['recommend_item_num'] = intval( $input['recommend_item_num'] );

	// ヘッダーバーの表示位置
	if ( ! isset( $input['header_fix'] ) || ! array_key_exists( $input['header_fix'], $header_fix_options ) )
		$input['header_fix'] = $dp_default_options['header_fix'];

	// ヘッダーバーの表示位置（スマホ）
	if ( ! isset( $input['mobile_header_fix'] ) || ! array_key_exists( $input['mobile_header_fix'], $header_fix_options ) )
		$input['mobile_header_fix'] = $dp_default_options['mobile_header_fix'];

	// ヘッダーバーの色の設定
	$input['header_bg'] = wp_filter_nohtml_kses( $input['header_bg'] );
	$input['header_opacity'] = wp_filter_nohtml_kses( $input['header_opacity'] );
	$input['header_font_color'] = wp_filter_nohtml_kses( $input['header_font_color'] );

	// ヘッダー検索
	$input['show_header_search'] = wp_filter_nohtml_kses( $input['show_header_search'] );
	$input['show_header_search_mobile'] = wp_filter_nohtml_kses( $input['show_header_search_mobile'] );
	$input['show_footer_search_mobile'] = wp_filter_nohtml_kses( $input['show_footer_search_mobile'] );

	// グローバルメニュー設定
	$input['globalmenu_hover_underline_color'] = wp_filter_nohtml_kses( $input['globalmenu_hover_underline_color'] );
	$input['submenu_color'] = wp_filter_nohtml_kses( $input['submenu_color'] );
	$input['submenu_color_hover'] = wp_filter_nohtml_kses( $input['submenu_color_hover'] );
	$input['submenu_bg_color'] = wp_filter_nohtml_kses( $input['submenu_bg_color'] );
	$input['submenu_bg_color_hover'] = wp_filter_nohtml_kses( $input['submenu_bg_color_hover'] );

	// ページヘッダーの設定
	$input['page_header_headline_color'] = wp_filter_nohtml_kses( $input['page_header_headline_color'] );
	$input['page_header_desc_color'] = wp_filter_nohtml_kses( $input['page_header_desc_color'] );
	$input['page_header_bg_color'] = wp_filter_nohtml_kses( $input['page_header_bg_color'] );

	// フッター検索
	$input['show_footer_search_mobile'] = wp_filter_nohtml_kses( $input['show_footer_search_mobile'] );

	// フッターウィジェットの設定
	$input['footer_widget_title_color'] = wp_filter_nohtml_kses( $input['footer_widget_title_color'] );
	$input['footer_widget_text_color'] = wp_filter_nohtml_kses( $input['footer_widget_text_color'] );
	$input['footer_widget_link_color'] = wp_filter_nohtml_kses( $input['footer_widget_link_color'] );
	$input['footer_widget_link_color_hover'] = wp_filter_nohtml_kses( $input['footer_widget_link_color_hover'] );
	$input['footer_widget_bg_color'] = wp_filter_nohtml_kses( $input['footer_widget_bg_color'] );

	// スマホ用固定フッターバーの設定
	if ( ! array_key_exists( $input['footer_bar_display'], $footer_bar_display_options ) ) $input['footer_bar_display'] = 'type3';
	$input['footer_bar_bg'] = wp_filter_nohtml_kses( $input['footer_bar_bg'] );
	$input['footer_bar_border'] = wp_filter_nohtml_kses( $input['footer_bar_border'] );
	$input['footer_bar_color'] = wp_filter_nohtml_kses( $input['footer_bar_color'] );
	$input['footer_bar_tp'] = wp_filter_nohtml_kses( $input['footer_bar_tp'] );
	$footer_bar_btns = array();
	if ( empty( $input['repeater_footer_bar_btns'] ) && ! empty( $input['footer_bar_btns'] ) && is_array( $input['footer_bar_btns'] ) ) {
		$input['repeater_footer_bar_btns'] = $input['footer_bar_btns'];
	}
	if ( isset( $input['repeater_footer_bar_btns'] ) ) {
		foreach ( $input['repeater_footer_bar_btns'] as $key => $value ) {
			$footer_bar_btns[] = array(
				'type' => ( isset( $input['repeater_footer_bar_btns'][$key]['type'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['type'], $footer_bar_button_options ) ) ? $input['repeater_footer_bar_btns'][$key]['type'] : 'type1',
				'label' => isset( $input['repeater_footer_bar_btns'][$key]['label'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['label'] ) : '',
				'url' => isset( $input['repeater_footer_bar_btns'][$key]['url'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['url'] ) : '',
				'number' => isset( $input['repeater_footer_bar_btns'][$key]['number'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['number'] ) : '',
				'target' => ! empty( $input['repeater_footer_bar_btns'][$key]['target'] ) ? 1 : 0,
				'icon' => ( isset( $input['repeater_footer_bar_btns'][$key]['icon'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['icon'], $footer_bar_icon_options ) ) ? $input['repeater_footer_bar_btns'][$key]['icon'] : 'file-text'
			);
		}
		unset( $input['repeater_footer_bar_btns'] );
	}
	$input['footer_bar_btns'] = $footer_bar_btns;

	// 404 ページ
	$input['image_404'] = wp_filter_nohtml_kses( $input['image_404'] );
	$input['overlay_404'] = wp_filter_nohtml_kses( $input['overlay_404'] );
	$input['overlay_opacity_404'] = wp_filter_nohtml_kses( $input['overlay_opacity_404'] );
	$input['catchphrase_404'] = wp_filter_nohtml_kses( $input['catchphrase_404'] );
	$input['desc_404'] = wp_filter_nohtml_kses( $input['desc_404'] );
	$input['catchphrase_font_size_404'] = wp_filter_nohtml_kses( $input['catchphrase_font_size_404'] );
	$input['desc_font_size_404'] = wp_filter_nohtml_kses( $input['desc_font_size_404'] );
	$input['color_404'] = wp_filter_nohtml_kses( $input['color_404'] );
	$input['shadow1_404'] = wp_filter_nohtml_kses( $input['shadow1_404'] );
	$input['shadow2_404'] = wp_filter_nohtml_kses( $input['shadow2_404'] );
	$input['shadow3_404'] = wp_filter_nohtml_kses( $input['shadow3_404'] );
	$input['shadow_color_404'] = wp_filter_nohtml_kses( $input['shadow_color_404'] );

	// 保護ページ
	$input['pw_label'] = wp_filter_nohtml_kses( $input['pw_label'] );
	if ( ! isset( $input['pw_align'] ) || ! array_key_exists( $input['pw_align'], $pw_align_options ) )
		$input['pw_align'] = $dp_default_options['pw_align'];
	for ( $i = 1; $i <= 5; $i++ ) {
		$input['pw_name' . $i] = wp_filter_nohtml_kses( $input['pw_name' . $i] );
		$input['pw_btn_display' . $i] = ! empty( $input['pw_btn_display' . $i] ) ? 1 : 0;
		$input['pw_btn_label' . $i] = wp_filter_nohtml_kses( $input['pw_btn_label' . $i] );
		$input['pw_btn_url' . $i] = wp_filter_nohtml_kses( $input['pw_btn_url' . $i] );
		$input['pw_btn_target' . $i] = ! empty( $input['pw_btn_target' . $i] ) ? 1 : 0;
		$input['pw_editor' . $i] = $input['pw_editor' . $i];
	}

	// コンテンツビルダー
	$input = cb_validate( $input );

	// スラッグ変更チェック
	$dp_options = get_design_plus_option();
	$is_slug_change = false;

	// news
	if ( $dp_options['news_slug'] !== $input['news_slug'] ) {
		register_post_type( $input['news_slug'], array(
			'label' => $input['news_slug'],
			'public' => true,
			'has_archive' => true,
			'hierarchical' => false
		) );
		$is_slug_change = true;
	}

	if ( $is_slug_change ) {
		flush_rewrite_rules( false );
	}

	return $input;
}
