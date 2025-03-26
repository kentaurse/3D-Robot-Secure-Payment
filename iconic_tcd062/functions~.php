<?php

function start_session()
{
    if (!session_id())
        session_start();
}
add_action("init", "start_session", 1);

/**
 * Translation
 */
load_theme_textdomain( 'tcd-w', get_template_directory() . '/languages' );

// style.cssのDescriptionをPoedit等に認識させる
__( '"ICONIC" is a WordPress theme for online stores that is compatible with Welcart. It builds a minimalistic e-commerce site that highlights your products. And some banner contents promote your products from any angles.', 'tcd-iconic' );

/**
 * Theme setup
 */
function iconic_setup() {
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Image sizes
	add_image_size( 'size1', 300, 300, true );
	add_image_size( 'size2', 500, 500, true );
	add_image_size( 'size3', 740, 460, true );
	add_image_size( 'size4', 740, 540, true );
	add_image_size( 'size5', 1200, 0, false );
	add_image_size( 'size-card', 300, 300, true ); // カードリンクパーツ用

	// imgタグのsrcsetを未使用に
	add_filter( 'wp_calculate_image_srcset', '__return_false' );

	// Menu
	register_nav_menus( array(
		'global' => __( 'Global menu', 'tcd-w' )
	) );
}
add_action( 'after_setup_theme', 'iconic_setup' );

/**
 * Theme init
 */
function iconic_init() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// Emoji
	if ( 0 == $dp_options['use_emoji'] ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	// カスタム投稿 お知らせ
	register_post_type( $dp_options['news_slug'], array(
		'label' => $dp_options['news_breadcrumb_label'],
		'labels' => array(
			'name' => $dp_options['news_breadcrumb_label'],
			'singular_name' => $dp_options['news_breadcrumb_label'],
			'add_new' => __( 'Add New', 'tcd-w' ),
			'add_new_item' => __( 'Add New Item', 'tcd-w' ),
			'edit_item' => __( 'Edit', 'tcd-w' ),
			'new_item' => __( 'New item', 'tcd-w' ),
			'view_item' => __( 'View Item', 'tcd-w' ),
			'search_items' => __( 'Search Items', 'tcd-w' ),
			'not_found' => __( 'Not Found', 'tcd-w' ),
			'not_found_in_trash' => __( 'Not found in trash', 'tcd-w' ),
			'parent_item_colon' => ''
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_position' => 5,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail' )
	) );
}
add_action( 'init', 'iconic_init' );

/**
 * Theme scripts and style
 */
function iconic_scripts() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// usces_cart.cssはwelcartから自動で読み込まれます
	// get_stylesheet_directory_uri() . '/usces_cart.css' のため子テーマ時はコピーや@import等が必要

	// slick読み込みフラグ
	$slick_load = false;

	if ( is_front_page() ) {
		$slick_load = true;
		wp_enqueue_script( 'iconic-front-page', get_template_directory_uri() . '/js/front-page.js', array( 'jquery' ), version_num(), true );
	}

	// 共通
	wp_enqueue_style( 'iconic-style', get_stylesheet_uri(), array(), version_num() );
	wp_enqueue_script( 'iconic-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), version_num(), true );

	// slick
	if ( $slick_load ) {
		wp_enqueue_script( 'iconic-slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), version_num(), true );
		wp_enqueue_style( 'iconic-slick', get_template_directory_uri() . '/css/slick.min.css' );

		// ページビルダーのslick.js,slick.cssを読み込まないように
		add_filter( 'page_builder_slick_enqueue_script', '__return_false' );
		add_filter( 'page_builder_slick_enqueue_style', '__return_false' );
	}

	// フッターバー
	if ( is_mobile() && 'type3' !== $dp_options['footer_bar_display'] ) {
		wp_enqueue_style( 'iconic-footer-bar', get_template_directory_uri() . '/css/footer-bar.css', false, version_num() );
		wp_enqueue_script( 'iconic-footer-bar', get_template_directory_uri() . '/js/footer-bar.js', array( 'jquery' ), version_num(), true );
	}

	// ヘッダースクロール
	if ( 'type2' == $dp_options['header_fix'] || 'type2' == $dp_options['mobile_header_fix'] ) {
		wp_enqueue_script( 'iconic-header-fix', get_template_directory_uri() . '/js/header-fix.js', array( 'jquery' ), version_num(), true );
	}

	// comment
	if ( is_single() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'iconic-comment', get_template_directory_uri() . '/js/comment.js', array(), version_num() );
	}

	// アドミンバーのインラインスタイルを出力しない
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'wp_enqueue_scripts', 'iconic_scripts' );

function iconic_admin_scripts() {
	// 管理画面共通
	wp_enqueue_style( 'tcd_admin_css', get_template_directory_uri() . '/admin/css/tcd_admin.css', array(), version_num() );
	wp_enqueue_script( 'tcd_script', get_template_directory_uri() . '/admin/js/tcd_script.js', array(), version_num() );
	wp_localize_script( 'tcd_script', 'TCD_MESSAGES', array(
		'ajaxSubmitSuccess' => __( 'Settings Saved Successfully', 'tcd-w' ),
		'ajaxSubmitError' => __( 'Can not save data. Please try again.', 'tcd-w' )
	) );

	// 画像アップロードで使用
	wp_enqueue_script( 'cf-media-field', get_template_directory_uri() . '/admin/js/cf-media-field.js', array( 'media-upload' ), version_num() );
	wp_localize_script( 'cf-media-field', 'cfmf_text', array(
		'image_title' => __( 'Please Select Image', 'tcd-w' ),
		'image_button' => __( 'Use this Image', 'tcd-w' ),
		'video_title' => __( 'Please Select Video', 'tcd-w' ),
		'video_button' => __( 'Use this Video', 'tcd-w' )
	) );

	// メディアアップローダーAPIを利用するための処理 Welcart商品ページは除外
    if ( ! isset( $_GET['page'] ) || ( $_GET['page'] != 'usces_itemedit' && $_GET['page'] != 'usces_itemnew' ) ) {
        wp_enqueue_media();
    }
    
	// ウィジェットで使用
	wp_enqueue_script( 'iconic-widget-script', get_template_directory_uri() . '/admin/js/widget.js', array( 'jquery' ), version_num() );

	// テーマオプションのタブで使用
	wp_enqueue_script( 'jquery.cookieTab', get_template_directory_uri() . '/admin/js/jquery.cookieTab.js', array(), version_num() );

	// テーマオプションのAJAX保存で使用
	wp_enqueue_script( 'jquery-form' );

	// フッターバー
	wp_enqueue_style( 'iconic-admin-footer-bar', get_template_directory_uri() . '/admin/css/footer-bar.css', array(), version_num() );
	wp_enqueue_script( 'iconic-admin-footer-bar', get_template_directory_uri() . '/admin/js/footer-bar.js', array(), version_num() );

	// WPカラーピッカー
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'iconic_admin_scripts' );

// Editor style
function iconic_add_editor_styles() {
	add_editor_style( 'admin/css/editor-style-02.css' );
}
add_action( 'admin_init', 'iconic_add_editor_styles' );

// 各サムネイル画像生成時の品質を82→90に
function iconic_wp_editor_set_quality( $quality, $mime_type ) {
	return 90;
}
add_filter( 'wp_editor_set_quality', 'iconic_wp_editor_set_quality', 10, 2 );

// Widget area
function iconic_widgets_init() {
	// Common side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Common side widget', 'tcd-w' ),
        'description' => __('Widgets set in this widget area are displayed as "basic widget" in the sidebar of all pages. If there are individual settings, the widget will be displayed.', 'tcd-w'),
		'id' => 'common_side_widget'
	) );

	// Post side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Post side widget', 'tcd-w' ),
		'id' => 'post_side_widget'
	) );

	// News side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'News side widget', 'tcd-w' ),
		'id' => 'news_side_widget'
	) );

	// Page side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Page side widget', 'tcd-w' ),
		'id' => 'page_side_widget'
	) );

	// Welcart side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Welcart side widget', 'tcd-w' ),
		'id' => 'welcart_side_widget'
	) );

	// Footer
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Footer widget', 'tcd-w' ),
		'id' => 'footer_widget'
	) );

	// Post side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Post side widget (mobile)', 'tcd-w' ),
		'id' => 'post_side_widget_mobile'
	) );

	// News side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'News side widget (mobile)', 'tcd-w' ),
		'id' => 'news_side_widget_mobile'
	) );

	// Page side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Page side widget (mobile)', 'tcd-w' ),
		'id' => 'page_side_widget_mobile'
	) );

	// Welcart side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Welcart side widget (mobile)', 'tcd-w' ),
		'id' => 'welcart_side_widget_mobile'
	) );

	// Footer (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Footer widget (mobile)', 'tcd-w' ),
		'id' => 'footer_widget_mobile'
	) );
}
add_action( 'widgets_init', 'iconic_widgets_init' );

/**
 * get active sidebar
 */
function get_active_sidebar() {
	global $post, $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$sidebars = array();

	if ( is_front_page() || is_home() ) {
		return false;

	} elseif ( is_welcart_archive() || is_welcart_single() || is_welcart_search_page() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'welcart_side_widget_mobile';
		} else {
			$sidebars[] = 'welcart_side_widget';
		}

	} elseif ( is_welcart_page() ) {
		return false;

	} elseif ( ( is_post_type_archive( $dp_options['news_slug'] ) || is_singular( $dp_options['news_slug'] ) ) ) {
		if ( is_mobile() ) {
			$sidebars[] = 'news_side_widget_mobile';
		} else {
			$sidebars[] = 'news_side_widget';
		}

	} elseif ( is_archive() ) {
		return false;

	} elseif ( is_page() ) {
		if ( 'show' == $post->display_side_content ) {
			if ( is_mobile() ) {
				$sidebars[] = 'page_side_widget_mobile';
			} else {
				$sidebars[] = 'page_side_widget';
			}
		}

	} elseif ( is_singular() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'post_side_widget_mobile';
		} else {
			$sidebars[] = 'post_side_widget';
		}
	}

	if ( ! empty( $sidebars ) ) {
		$sidebars[] = 'common_side_widget';

		foreach( $sidebars as $sidebar ) {
			if ( is_active_sidebar( $sidebar ) ) {
				return $sidebar;
			}
		}
	}

	return false;
}

/**
 * body class
 */
function iconic_body_classes( $classes ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( is_welcart_single() ) {
		$classes[] = 'single-item';
	}

	if ( get_active_sidebar() ) {
		if ( is_welcart_archive() || is_welcart_single() || is_welcart_page() ) {
			$classes[] = 'l-sidebar--' . $dp_options['sidebar_welcart'];
		} else {
			$classes[] = 'l-sidebar--' . $dp_options['sidebar'];
		}
	}

	if ( $dp_options['header_fix'] == 'type2' && !wp_is_mobile() ) {
		$classes[] = 'l-header__fix';
	}

	if ( $dp_options['mobile_header_fix'] == 'type2' && wp_is_mobile() ) {
		$classes[] = 'l-header__fix l-header__fix--mobile';
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'iconic_body_classes' );

/**
 * Excerpt
 */
function custom_excerpt_length( $length = null ) {
	return 64;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more( $more = null ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Remove wpautop from the excerpt
 */
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Customize archive title
 */
function iconic_archive_title( $title ) {
	global $author, $post;
	if ( is_author() ) {
		$title = get_the_author_meta( 'display_name', $author );
	} elseif ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_day() ) {
		$title = get_the_time( __( 'F jS, Y', 'tcd-w' ), $post );
	} elseif ( is_month() ) {
		$title = get_the_time( __( 'F, Y', 'tcd-w' ), $post );
	} elseif ( is_year() ) {
		$title = get_the_time( __( 'Y', 'tcd-w' ), $post );
	} elseif ( is_search() ) {
		$title = __( 'Search result', 'tcd-w' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'iconic_archive_title', 10 );

/**
 * ビジュアルエディタに表(テーブル)の機能を追加
 */
function mce_external_plugins_table( $plugins ) {
	$plugins['table'] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.4/plugins/table/plugin.min.js';
	return $plugins;
}
add_filter( 'mce_external_plugins', 'mce_external_plugins_table' );

/**
 * tinymceのtableボタンにclass属性プルダウンメニューを追加
 */
function mce_buttons_table( $buttons ) {
	$buttons[] = 'table';
	return $buttons;
}
add_filter( 'mce_buttons', 'mce_buttons_table' );

function table_classes_tinymce( $settings ) {
	$styles = array(
		array( 'title' => __( 'Default style', 'tcd-w' ), 'value' => '' ),
		array( 'title' => __( 'No border', 'tcd-w' ), 'value' => 'table_no_border' ),
		array( 'title' => __( 'Display only horizontal border', 'tcd-w' ), 'value' => 'table_border_horizontal' )
	);
	$settings['table_class_list'] = json_encode( $styles );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'table_classes_tinymce' );

/**
 * ビジュアルエディタにページ分割ボタンを追加
 */
function add_nextpage_buttons( $buttons ) {
	$buttons[] = 'wp_page';
	return $buttons;
}
add_filter( 'mce_buttons', 'add_nextpage_buttons' );

/**
 * Translate Hex to RGB
 */
function hex2rgb( $hex ) {
	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}

	return array( $r, $g, $b );
}

/**
 * ユーザーエージェントを判定するための関数
 */
function is_mobile() {
	static $is_mobile = null;

	if ( $is_mobile !== null ) {
		return $is_mobile;
	}

	// タブレットも含める場合は wp_is_mobile()
	$ua = array(
		'iPhone', // iPhone
		'iPod', // iPod touch
		'Android.*Mobile', // 1.5+ Android *** Only mobile
		'Windows.*Phone', // *** Windows Phone
		'dream', // Pre 1.5 Android
		'CUPCAKE', // 1.5+ Android
		'BlackBerry', // BlackBerry
		'BB10', // BlackBerry10
		'webOS', // Palm Pre Experimental
		'incognito', // Other iPhone browser
		'webmate' // Other iPhone browser
	);

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = false;
	} elseif ( preg_match( '/' . implode( '|', $ua ) . '/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

/**
 * レスポンシブOFF機能を判定するための関数
 */
function is_no_responsive() {
	return false;
}

/**
 * スクリプトのバージョン管理
 */
function version_num() {
	static $theme_version = null;

	if ( $theme_version !== null ) {
		return $theme_version;
	}

	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme();
	} else {
		$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	}

	if ( isset( $theme_data['Version'] ) ) {
		$theme_version = $theme_data['Version'];
	} else {
		$theme_version = '';
	}

	return $theme_version;
}


/**
 * カスタムコメント
 */
function custom_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if ( ! $commentcount ) {
		$commentcount = 0;
	}
?>
<li id="comment-<?php comment_ID(); ?>" class="c-comment__list-item comment">
  <div class="c-comment__item-header u-clearfix">
    <div class="c-comment__item-meta u-clearfix">
      <?php
	if ( function_exists( 'get_avatar' ) && get_option( 'show_avatars' ) ) {
		echo get_avatar( $comment, 35, '', false, array( 'class' => 'c-comment__item-avatar' ) );
	}
	if ( get_comment_author_url() ) {
		echo '<a id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author" rel="nofollow">' . get_comment_author() . '</a>' . "\n";
	} else {
		echo '<span id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author">' . get_comment_author() . '</span>' . "\n";
	}
?>
      <time class="c-comment__item-date"
        datetime="<?php comment_time( 'c' ); ?>"><?php comment_time( __( 'F jS, Y', 'tcd-w' ) ); ?></time>
    </div>
    <ul class="c-comment__item-act">
      <?php
	if ( 1 == get_option( 'thread_comments' ) ) :
?>
      <li>
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __( 'REPLY', 'tcd-w' ) . '' ) ) ); ?>
      </li>
      <?php
	else :
?>
      <li><a href="javascript:void(0);"
          onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID(); ?>', 'comment-<?php comment_ID(); ?>', 'js-comment__textarea');"><?php _e( 'REPLY', 'tcd-w' ); ?></a>
      </li>
      <?php
	endif;
?>
      <li><a href="javascript:void(0);"
          onclick="MGJS_CMT.quote('commentauthor-<?php comment_ID(); ?>', 'comment-<?php comment_ID(); ?>', 'comment-content-<?php comment_ID(); ?>', 'js-comment__textarea');"><?php _e( 'QUOTE', 'tcd-w' ); ?></a>
      </li>
      <?php edit_comment_link( __( 'EDIT', 'tcd-w' ), '<li>', '</li>'); ?>
    </ul>
  </div>
  <div id="comment-content-<?php comment_ID(); ?>" class="c-comment__item-body">
    <?php
	if ( 0 == $comment->comment_approved ) {
		echo '<span class="c-comment__item-note">' . __( 'Your comment is awaiting moderation.', 'tcd-w' ) . '</span>' . "\n";
	} else {
		comment_text();
	}
?>
  </div>
  <?php
}

// News 表示件数
function pre_get_posts_news( $wp_query ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( ! is_admin() && $wp_query->is_main_query() && $wp_query->is_post_type_archive( $dp_options['news_slug'] ) && 0 < $dp_options['archive_news_num'] ) {
		$wp_query->set( 'posts_per_page', $dp_options['archive_news_num'] );
	}
}
add_filter( 'pre_get_posts', 'pre_get_posts_news' );

// Theme options
get_template_part( 'admin/theme-options' );
get_template_part( 'admin/theme-options-tools' );

// Contents Builder
get_template_part( 'admin/contents-builder' );

// Add custom columns
get_template_part( 'functions/admin_column' );

// Category custom fields
get_template_part( 'functions/category' );

// Custom CSS
get_template_part( 'functions/custom_css' );

// Add quicktags to the visual editor
get_template_part( 'functions/custom_editor' );

// hook wp_head
get_template_part( 'functions/head' );

// Mega menu
get_template_part( 'functions/megamenu' );

// OGP
get_template_part( 'functions/ogp' );

// Recommend post
get_template_part( 'functions/recommend' );

// Page builder
get_template_part( 'pagebuilder/pagebuilder' );

// Post custom fields
get_template_part( 'functions/post_cf' );

// Page custom fields
get_template_part( 'functions/page_cf' );
get_template_part( 'functions/page_cf2' );
// Password protected pages
get_template_part( 'functions/password_form' );

// Show custom fields in quick edit
get_template_part( 'functions/quick_edit' );

// Meta title and description
get_template_part( 'functions/seo' );

// Shortcode
get_template_part( 'functions/short_code' );

// Update notifier
get_template_part( 'functions/update_notifier' );

// Welcart
get_template_part( 'functions/welcart' );
get_template_part( 'functions/welcart_cf' );

// Widgets
get_template_part( 'widget/ad' );
get_template_part( 'widget/archive_list' );
get_template_part( 'widget/category_list' );
get_template_part( 'widget/google_search' );
get_template_part( 'widget/item_category' );
get_template_part( 'widget/site_info' );
get_template_part( 'widget/styled_post_list_tab' );

// Card link
get_template_part( 'functions/card-link' );


// ウィジェットブロックエディターを無効化 --------------------------------------------------------------------------------
function exclude_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'exclude_theme_support' );


// 月別アーカイブから商品記事のみ公開の月を除去
add_filter('getarchives_where', 'welcart_getarchives_where');
function welcart_getarchives_where( $r ){
	$where = "WHERE post_type = 'post' AND post_status = 'publish' AND post_mime_type <> 'item' ";
	return $where;
}

function connect_another_db() {
    global $seconddb;
    $seconddb = new wpdb('2m5l9_ecapo', 'sh0-s19y^1Sa', '2m5l9_ecapo', 'mysql14.onamae.ne.jp');
}
add_action('init', 'connect_another_db');


add_action( 'wp_ajax_custom_action', 'custom_action');
add_action( 'wp_ajax_nopriv_custom_action', 'custom_action');

function custom_action() {
    $response = array(
    	'error' => false,
    );


	if ($_POST['dis_reason'] == '') {
    	$response['error'] = true;
    	$response['error_message'] = 'Decline reason is required';
    	exit(json_encode($response));
    }else{
						global $seconddb;
						$ordr_id = $_POST['order'];
						$com = $_POST['com'];
						$create_at = date('Y-m-d H:i:s');
						$dicline_reason = $_POST['dis_reason'];
						$seller_mail = $seconddb->get_var("SELECT seller_id FROM orders WHERE id='$ordr_id'");
						$seller_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$seller_mail'");

						$initial_approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$ordr_id'");
						$decode_initial_approval = json_decode($initial_approval, true);

						foreach ($decode_initial_approval as $key => $entry) {
							if ($entry['company_id'] == $com) {
								$decode_initial_approval[$key]['status'] = "Rejected";
								$decode_initial_approval[$key]['comment'] = $dicline_reason;
								$decode_initial_approval[$key]['created_at'] = $create_at;
							}else{

							}
						}
						$updated_approval = json_encode($decode_initial_approval);

						$seconddb->update("orders", array(
							"vendor_approval" => $updated_approval,
						 ), array('id'=>$ordr_id));


						 $fetch_vendor_info = $seconddb->get_var("SELECT vendors_info FROM orders WHERE id='$ordr_id'");
						 $decode_fetch_vendor_info = json_decode($fetch_vendor_info, true);
 
						 $target_service_info = '';
						 foreach ($decode_fetch_vendor_info as $key => $entry) {
							 if ($entry['company_id'] == $com) {
								 $target_info_1 = $decode_fetch_vendor_info[$key]['charge'];
								 $target_info_2 = $decode_fetch_vendor_info[$key]['address'];
								 $target_info_3 = $decode_fetch_vendor_info[$key]['company_id'];
								 $target_info_4 = $decode_fetch_vendor_info[$key]['company_tel'];
								 $target_info_5 = $decode_fetch_vendor_info[$key]['company_mail'];
								 $target_info_6 = $decode_fetch_vendor_info[$key]['company_name'];
								 $target_info_7 = $decode_fetch_vendor_info[$key]['company_homepage'];
 
								 $target_service_info .= "- - - - - - - - - -<p> {$target_info_6} </p> <p>住所: {$target_info_2} </p><p>商談設定金額: ¥ {$target_info_1} </p>";
							 }
						 }
 
						 $fetch_vendor_hopes = $seconddb->get_var("SELECT hopes FROM orders WHERE id='$ordr_id'");
						 $decode_fetch_hopes_info = json_decode($fetch_vendor_hopes, true);
 
						 $target_hopes_info = '';
						 foreach ($decode_fetch_hopes_info as $key => $entry) {
							 if ($entry['company_id'] == $com) {
								 $hope_1 = $decode_fetch_hopes_info[$key]['hope1'];
								 $hope_2 = $decode_fetch_hopes_info[$key]['hope2'];
								 $hope_3 = $decode_fetch_hopes_info[$key]['hope3'];
								 $method = $decode_fetch_hopes_info[$key]['method'];
 
								 $target_hopes_info .=  "<p>希望商談日: {$hope_1}, {$hope_2}, {$hope_3} </p><br>{$method}<br>- - - - - - - - - - <br><br>";
							 }
						 }
					

						$from = "sales-offer@ec-apo.com";
                        $to = $seller_mail;
						$bcc = "sales-offer@ec-apo.com";
                        $subject = "【商談お断り】商談の依頼結果が届きました。";
                        $message = "
                            <p>$seller_name 様</p><br>
                            <h4>EC Apo運営事務局でございます。</h4>
                            <p>商談依頼の結果が届きましたのでお知らせいたします。</p>
							<br>
							<p>結果: 商談お断り</p>
							<p>理由: {$dicline_reason}</p>
							<br>
                            <hr>
                            
							{$target_service_info}
							{$target_hopes_info}

							<hr>
							<p>以上でございます。</p>
							<p>商談の実施ができないため、クレジットカードより課金はされませんのでご安心下さい。</p>
							<p>ぜひ、同じ会社に別方法や別日程、もしくは別会社へ商談をご依頼下さい。</p>
							<P><u>https://ec-apo.com/</u></P>
							<p>引き続き、よろしくお願い申し上げます。</p>
							<br>
							<div>
                            **************************** <br>
                            EC Apo 運営事務局 <br>
                            株式会社リアリディール <br>
                            東京都渋谷区恵比寿4-20-3 <br>
                            恵比寿ガーデンプレイスタワー18階 <br>
                            sales-offer@ec-apo.com <br>
                            ****************************
                            </div>
                        ";
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $headers .= "From:" . $from . "\r\n";
						$headers .= "Bcc:" . $bcc . "\r\n";
                        mail($to,$subject,$message, $headers);


    	$response['status'] = 'Success';
		exit(json_encode($response));
	}
}

add_action( 'wp_ajax_online_agreement_submit', 'online_agreement_submit');
add_action( 'wp_ajax_nopriv_online_agreement_submit', 'online_agreement_submit');

function online_agreement_submit() {
	$payment_captured = false;

	global $seconddb;
	$response = array(
    	'error' => false,
    );

	$order_id = $_POST['order'];
	$company_id = $_POST['com'];
	$comfirm_date = $_POST['hope'];
	$contact_url = $_POST['contact_url'];
	$contact_tel = $_POST['contact_tel'];
	$contact_name = $_POST['contact_name'];
	$contact_per_position = $_POST['c_person_position'];
	$seller_mail = $seconddb->get_var("SELECT seller_id FROM orders WHERE id='$order_id'");
	$company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
	$seller_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$seller_mail'");
	$create_at = $curr_date = date('Y-m-d H:i:s', time());

	

	//capture payment first then handle rest
	$paypal_id = $seconddb->get_var("SELECT order_id FROM orders WHERE id='$order_id'");
	$com_charge_ = $seconddb->get_var("SELECT paycost FROM userlist WHERE userid='$company_id'");
	$com_charge = str_replace( ',', '', $com_charge_);
	$fee = $com_charge*0.3;
	$receipt_fee = $com_charge*0.7;

	$payment_info = $seconddb->get_var("SELECT payments_info FROM billing WHERE billing_order_id='$paypal_id'");
	$payment_info_json = json_decode($payment_info, true);
	$payment_id = $payment_info_json[0]['id'];
	$__key = openssl_random_pseudo_bytes(32);
	$PayPalRequestId = bin2hex($_token);

	$uri = 'https://api-m.paypal.com/v1/oauth2/token';
	$clientId = 'AR5jRe8vQwJcDR721nns0Rzbj3H5KuCXXqWGtm1FVypr0nCAyB3UDsxD5Nou8ffiP3WhwiczM6f_cWU-';
	$secret = 'EGvhXf4L4MndWSPqtVW2cKcWiIuL-5QyTRpm44Lj2rfFP3ZHxZMNqz1v2t_4eQP-AHQXoGgHpc9UyfK3';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSLVERSION , 6);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

	$result = curl_exec($ch);
	$access_token = '';
	if(empty($result))die("Error: No response.");
	else
	{
		$json = json_decode($result);
		$access_token = $json->access_token;
	}
	curl_close($ch);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v2/payments/authorizations/{$payment_id}/capture");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

	$headers = array();
	$headers[] = 'Content-Type: application/json';
	$headers[] = "Authorization: Bearer $access_token";
	$headers[] = "PayPal-Request-Id: $PayPalRequestId";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$com_charge = str_replace(",", "", $com_charge);
	$com_charge = (string) $com_charge;
	$postfiend = [
		"amount" => [
			"currency_code" => "JPY",
			"value" => $com_charge
		]
	];

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfiend));

	
	$capture_result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	$capture_response = json_decode($capture_result, true);



	if($capture_response['status'] == "COMPLETED"){
		$payment_captured = true;
	}


	if($payment_captured){
		$initial_contact_way = $seconddb->get_var("SELECT contact_way FROM orders WHERE id='$order_id'");
		$decode_contact_way = json_decode($initial_contact_way, true);

		foreach ($decode_contact_way as $key => $entry) {
			if ($entry['company_id'] == $company_id) {
				$decode_contact_way[$key]['contact_tel'] = $contact_tel;
				$decode_contact_way[$key]['contact_url'] = $contact_url;
				$decode_contact_way[$key]['contact_name'] = $contact_name;
				$decode_contact_way[$key]['date_confirm'] = $comfirm_date;
				$decode_contact_way[$key]['contact_address'] = "";
			}else{

			}
		}
		$updated_contact_way = json_encode($decode_contact_way);

		$seconddb->update("orders", array(
			"contact_way" => $updated_contact_way,
		 ), array('id'=>$order_id));	


		 $initial_approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$order_id'");
		 $decode_initial_approval = json_decode($initial_approval, true);

		 foreach ($decode_initial_approval as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $decode_initial_approval[$key]['status'] = "Approved";
				 $decode_initial_approval[$key]['comment'] = 'Approved by company';
				 $decode_initial_approval[$key]['created_at'] = $create_at;
			 }else{

			 }
		 }
		 $updated_approval = json_encode($decode_initial_approval);

		 $seconddb->update("orders", array(
			 "vendor_approval" => $updated_approval,
		  ), array('id'=>$order_id));


		 $fetch_vendor_info = $seconddb->get_var("SELECT vendors_info FROM orders WHERE id='$order_id'");
		 $decode_fetch_vendor_info = json_decode($fetch_vendor_info, true);

		 $target_service_info = '';
		 foreach ($decode_fetch_vendor_info as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $target_info_1 = $decode_fetch_vendor_info[$key]['charge'];
				 $target_info_2 = $decode_fetch_vendor_info[$key]['address'];
				 $target_info_3 = $decode_fetch_vendor_info[$key]['company_id'];
				 $target_info_4 = $decode_fetch_vendor_info[$key]['company_tel'];
				 $target_info_5 = $decode_fetch_vendor_info[$key]['company_mail'];
				 $target_info_6 = $decode_fetch_vendor_info[$key]['company_name'];
				 $target_info_7 = $decode_fetch_vendor_info[$key]['company_homepage'];

				 $target_service_info .= "- - - - - - - - - -<p> {$target_info_6} </p> <p>住所: {$target_info_2} </p><p>商談設定金額: ¥ {$target_info_1} </p>";
			 }
		 }

		 $fetch_vendor_hopes = $seconddb->get_var("SELECT hopes FROM orders WHERE id='$order_id'");
		 $decode_fetch_hopes_info = json_decode($fetch_vendor_hopes, true);

		 $target_hopes_info = '';
		 foreach ($decode_fetch_hopes_info as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $hope_1 = $decode_fetch_hopes_info[$key]['hope1'];
				 $hope_2 = $decode_fetch_hopes_info[$key]['hope2'];
				 $hope_3 = $decode_fetch_hopes_info[$key]['hope3'];
				 $method = $decode_fetch_hopes_info[$key]['method'];

				 $target_hopes_info .=  "<p>希望商談日: {$hope_1}, {$hope_2}, {$hope_3} </p><br>{$method}<br>- - - - - - - - - - <br><br>";
			 }
		 }

		 	//sending confirmation email to client user
			$from = "sales-offer@ec-apo.com";
			$to = $seller_mail;
			$bcc = "sales-offer@ec-apo.com";
			$subject = "【商談成立】商談の依頼結果が届きました。";
			$message = "
				<p>$seller_name 様</p><br><br>
				<h4>EC Apo運営事務局でございます。</h4>
				<p>商談依頼の結果が届きましたのでお知らせいたします。</p>
				
				<hr>
				<p>結果: アポイント確定</p>
				<p>確定商談日時: {$comfirm_date}</p>
				<br>
				<br>
				<p>WEB商談URL受取用メールアドレス：</p>
					<a href='{$contact_url}'>{$contact_url}</a>
				<br>
				<p>ご挨拶、当日のご連絡先番号: {$contact_tel }</p>
				<P>お名前: {$contact_name}</P>
				<p>役職: {$contact_per_position}</p>
				<hr>
				<br><br><br>
				
				{$target_service_info}
				{$target_hopes_info}
				
				<p>お客様へご挨拶の連絡を入れて、商談をご実施ください。</p>
				<p>商談設定金額をご登録のクレジットカードより課金致しました。</p>
				<p>本メール受信以降、依頼主様からの商談キャンセルや、依頼主様からの日程変更希望によるキャンセルとなった場合は、課金取り消しは出来かねますのでご了承下さい</p>
				<div>
				**************************** <br>
				EC Apo 運営事務局 <br>
				株式会社リアリディール <br>
				東京都渋谷区恵比寿4-20-3 <br>
				恵比寿ガーデンプレイスタワー18階 <br>
				sales-offer@ec-apo.com <br>
				****************************
				</div>
			";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From:" . $from . "\r\n";
			$headers .= "Bcc:" . $bcc . "\r\n";
			mail($to,$subject,$message, $headers);



		 	//sending confirm to company
			$from = "sales-offer@ec-apo.com";
			$to = $company_mail;
			$bcc = "sales-offer@ec-apo.com";
			$subject = "【商談成立】ご回答有難うございました。";
			$message = "
				<p>$contact_name 様</p><br><br>
				<h4>EC Apo運営事務局でございます。</h4><br>
				<p>この度は商談依頼を受けて頂いて有難うございました。</p>
				<p>下記内容を先方に回答しております。</p>
				<hr>
				
				<p>確定商談日時: {$comfirm_date}</p>
				<br>
				<br>
				<p>WEB商談URL受取用メールアドレス：</p>
				<a href='{$contact_url}'>{$contact_url}</a>
				<br>
				<p>ご挨拶、当日のご連絡先番号: {$contact_tel }</p>
				<P>お名前: {$contact_name}</P>
				<p>役職: {$contact_per_position}</p>

				<hr>
				<br>
				<p>先方から直接ご連絡が入りますので、ご対応のほどよろしくお願いいたします。</p>

				<P>商談設定金額：¥{$com_charge} </P>
				<P>弊社手数料：¥{$fee} </P>
				<P>受取報酬額：¥{$receipt_fee} </P>
				<br>
				<P>※報酬の受け取りは商談実施の翌月末になります。</P>


				<P>下記に該当した場合、報酬対象外となりますのでご注意ください。</P>

				<ul>
		 			<li>1.WEB商談をパソコンではなくスマートフォンで対応した場合</li>
					<li>2.カメラをOFFにしたままで、先方が本人と確認できなかった場合</li>
					<li>3.ご本人様以外が商談に応じた場合(例外なく)</li>
					<li>4.役職が虚偽であった場合</li>
					<li>5.商談を45分以内で終えた場合(商談を実施しなかった場合含む)</li>
					<li>6.サービスに全く興味がなく報酬目的のみと先方に伝えた場合</li>
					<li>7.営業を受けるのではなく、自社サービスの営業提案を行った場合</li>
					<li>8.その他、サイト掲載規約、サイト利用規約内で報酬対象外と定められている行為を行った場合</li>
					<li>9.上記内容で、営業会社から申告が入った場合は、報酬は一旦保留となります</li>
				</ul>
		 		<br><br><br>
				<div>
				**************************** <br>
				EC Apo 運営事務局 <br>
				株式会社リアリディール <br>
				東京都渋谷区恵比寿4-20-3 <br>
				恵比寿ガーデンプレイスタワー18階 <br>
				sales-offer@ec-apo.com <br>
				****************************
				</div>
			";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From:" . $from . "\r\n";
			$headers .= "Bcc:" . $bcc . "\r\n";
			mail($to,$subject,$message, $headers);

			$response['status'] = 'Success';
			exit(json_encode($response));

	}


}

add_action('wp_ajax_offline_agreement_submit', 'offline_agreement_submit');
add_action('wp_ajax_nopriv_offline_agreement_submit', 'offline_agreement_submit');

function offline_agreement_submit() {
	$payment_captured = false;

	global $seconddb;
	$response = array(
    	'error' => false,
    );

	$order_id = $_POST['order'];
	$company_id = $_POST['com'];
	$comfirm_date = $_POST['hope'];
	$meeting_address = $_POST['f2fAddr'];
	$contact_url = $_POST['place_url'];
	$contact_tel = $_POST['tel'];
	$contact_name = $_POST['contact_name'];
	$contact_per_position = $_POST['c_person_position'];
	$seller_mail = $seconddb->get_var("SELECT seller_id FROM orders WHERE id='$order_id'");
	$company_mail = $seconddb->get_var("SELECT mail FROM userlist WHERE userid='$company_id'");
	$seller_name = $seconddb->get_var("SELECT title_name FROM vendor WHERE email='$seller_mail'");


	//capture payment first then handle rest
	$paypal_id = $seconddb->get_var("SELECT order_id FROM orders WHERE id='$order_id'");
	$com_charge_ = $seconddb->get_var("SELECT paycost FROM userlist WHERE userid='$company_id'");
	$com_charge = str_replace( ',', '', $com_charge_);
	$fee = $com_charge*0.3;
	$receipt_fee = $com_charge*0.7;

	$payment_info = $seconddb->get_var("SELECT payments_info FROM billing WHERE billing_order_id='$paypal_id'");
	$payment_info_json = json_decode($payment_info, true);
	$payment_id = $payment_info_json[0]['id'];
	$__key = openssl_random_pseudo_bytes(32);
	$PayPalRequestId = bin2hex($_token);

	$uri = 'https://api-m.paypal.com/v1/oauth2/token';
	$clientId = 'AR5jRe8vQwJcDR721nns0Rzbj3H5KuCXXqWGtm1FVypr0nCAyB3UDsxD5Nou8ffiP3WhwiczM6f_cWU-';
	$secret = 'EGvhXf4L4MndWSPqtVW2cKcWiIuL-5QyTRpm44Lj2rfFP3ZHxZMNqz1v2t_4eQP-AHQXoGgHpc9UyfK3';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSLVERSION , 6);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

	$result = curl_exec($ch);
	$access_token = '';
	if(empty($result))die("Error: No response.");
	else
	{
		$json = json_decode($result);
		$access_token = $json->access_token;
	}
	curl_close($ch);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v2/payments/authorizations/{$payment_id}/capture");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

	$headers = array();
	$headers[] = 'Content-Type: application/json';
	$headers[] = "Authorization: Bearer $access_token";
	$headers[] = "PayPal-Request-Id: $PayPalRequestId";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$com_charge = str_replace(",", "", $com_charge);
	$com_charge = (string) $com_charge;
	$postfiend = [
		"amount" => [
			"currency_code" => "JPY",
			"value" => $com_charge
		]
	];

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfiend));

	
	$capture_result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	$capture_response = json_decode($capture_result, true);



	if($capture_response['status'] == "COMPLETED"){
		$payment_captured = true;
	}


	if($payment_captured){
		$initial_contact_way = $seconddb->get_var("SELECT contact_way FROM orders WHERE id='$order_id'");
		$decode_contact_way = json_decode($initial_contact_way, true);

		foreach ($decode_contact_way as $key => $entry) {
			if ($entry['company_id'] == $company_id) {
				$decode_contact_way[$key]['contact_tel'] = $contact_tel;
				$decode_contact_way[$key]['contact_url'] = $contact_url;
				$decode_contact_way[$key]['contact_name'] = $contact_name;
				$decode_contact_way[$key]['date_confirm'] = $comfirm_date;
				$decode_contact_way[$key]['contact_address'] = $meeting_address;
			}else{

			}
		}
		$updated_contact_way = json_encode($decode_contact_way);

		$seconddb->update("orders", array(
			"contact_way" => $updated_contact_way,
		 ), array('id'=>$order_id));


		 $initial_approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE id='$order_id'");
		 $decode_initial_approval = json_decode($initial_approval, true);

		 foreach ($decode_initial_approval as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $decode_initial_approval[$key]['status'] = "Approved";
				 $decode_initial_approval[$key]['comment'] = 'Approved by company';
				 $decode_initial_approval[$key]['created_at'] = $create_at;
			 }else{

			 }
		 }
		 $updated_approval = json_encode($decode_initial_approval);

		 $seconddb->update("orders", array(
			 "vendor_approval" => $updated_approval,
		  ), array('id'=>$order_id));


		$fetch_vendor_info = $seconddb->get_var("SELECT vendors_info FROM orders WHERE id='$order_id'");
		$decode_fetch_vendor_info = json_decode($fetch_vendor_info, true);

		 $target_service_info = '';
		 foreach ($decode_fetch_vendor_info as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $target_info_1 = $decode_fetch_vendor_info[$key]['charge'];
				 $target_info_2 = $decode_fetch_vendor_info[$key]['address'];
				 $target_info_3 = $decode_fetch_vendor_info[$key]['company_id'];
				 $target_info_4 = $decode_fetch_vendor_info[$key]['company_tel'];
				 $target_info_5 = $decode_fetch_vendor_info[$key]['company_mail'];
				 $target_info_6 = $decode_fetch_vendor_info[$key]['company_name'];
				 $target_info_7 = $decode_fetch_vendor_info[$key]['company_homepage'];

				 $target_service_info .= "- - - - - - - - - -<p> {$target_info_6} </p> <p>住所: {$target_info_2} </p><p>商談設定金額: ¥ {$target_info_1} </p>";
			 }
		 }
		 

		 $fetch_vendor_hopes = $seconddb->get_var("SELECT hopes FROM orders WHERE id='$order_id'");
		 $decode_fetch_hopes_info = json_decode($fetch_vendor_hopes, true);

		 $target_hopes_info = '';
		 foreach ($decode_fetch_hopes_info as $key => $entry) {
			 if ($entry['company_id'] == $company_id) {
				 $hope_1 = $decode_fetch_hopes_info[$key]['hope1'];
				 $hope_2 = $decode_fetch_hopes_info[$key]['hope2'];
				 $hope_3 = $decode_fetch_hopes_info[$key]['hope3'];
				 $method = $decode_fetch_hopes_info[$key]['method'];

				 $target_hopes_info .=  "<p>希望商談日: {$hope_1}, {$hope_2}, {$hope_3} </p><p>{$method}<p>- - - - - - - - - - <br><br>";
			 }
		 }



		 //sending confirmation email to client user
		 $from = "sales-offer@ec-apo.com";
		 $to = $seller_mail;
		 $bcc = "sales-offer@ec-apo.com";
		 $subject = "【商談成立】商談の依頼結果が届きました。";
		 $message = "
			 <p>$seller_name 様</p><br><br>
			 <h4>EC Apo運営事務局でございます。</h4>
			 <p>商談依頼の結果が届きましたのでお知らせいたします。</p>
			 
			 <hr>
			 <p>結果: アポイント確定</p>
			 <p>確定商談日時: {$comfirm_date}</p>
			 <br>
			 <br>
			 <p>対面商談のご住所： {$meeting_address}</p>
			 <p>対面商談場所のURLがある場合： {$contact_url }</p>
			 <p>ご挨拶、当日のご連絡先番号： {$contact_tel }</p>
			 <P>お名前: {$contact_name}</P>
			 <p>役職: {$contact_per_position}</p>
			 <hr>
			 <br><br><br>
			 
			 {$target_service_info}
			 {$target_hopes_info}
			 
			 <p>お客様へご挨拶の連絡を入れて、商談をご実施ください。</p>
			 <p>商談日が近づいてきましたら、ご自身でご挨拶のご連絡を入れて下さい。</p>
			 <p>商談設定金額をご登録のクレジットカードより課金致しました。</p>
			 <P>本メール受信以降、依頼主様からの商談キャンセルや、依頼主様からの日程変更希望によるキャンセルとなった場合は、課金取り消しは出来かねますのでご了承下さい。</P>
			 <div>
			 **************************** <br>
			 EC Apo 運営事務局 <br>
			 株式会社リアリディール <br>
			 東京都渋谷区恵比寿4-20-3 <br>
			 恵比寿ガーデンプレイスタワー18階 <br>
			 sales-offer@ec-apo.com <br>
			 ****************************
			 </div>
		 ";
		 $headers = "MIME-Version: 1.0\r\n";
		 $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		 $headers .= "From:" . $from . "\r\n";
		 $headers .= "Bcc:" . $bcc . "\r\n";
		 mail($to,$subject,$message, $headers);


		 //sending confirm to company
		 $from = "sales-offer@ec-apo.com";
		 $to = $company_mail;
		 $bcc = "sales-offer@ec-apo.com";
		 $subject = "【商談成立】ご回答有難うございました。";
		 $message = "
			 <p>$contact_name 様</p><br><br>
			 <h4>EC Apo運営事務局でございます。</h4><br>
			 <p>この度は商談依頼を受けて頂いて有難うございました。</p>
			 <p>下記内容を先方に回答しております。</p>
			 <hr>
			 
			 <p>確定商談日時: {$comfirm_date}</p>
			 <br>
			 <br>
			 <p>対面商談のご住所： {$meeting_address}</p>
			 <p>対面商談場所のURLがある場合： {$contact_url }</p>
			 <p>ご挨拶、当日のご連絡先番号： {$contact_tel }</p>
			 <P>お名前: {$contact_name}</P>
			 <p>役職: {$contact_per_position}</p>
			 <hr>
			 <p>先方から直接ご連絡が入りますので、ご対応のほどよろしくお願いいたします。</p>

			 <P>商談設定金額：¥{$com_charge} </P>
				<P>弊社手数料：¥{$fee} </P>
				<P>受取報酬額：¥{$receipt_fee} </P>
				<br>
			<P>※報酬の受け取りは商談実施の翌月末になります。</P>

			 <br>
		 	 <p>下記に該当した場合、報酬対象外となりますのでご注意ください。</p>
			 <ul>
				 <li>1. 名刺交換を行わなかった場合</li>
				 <li>2. ご本人様以外が商談に応じた場合(例外なく)</li>
				 <li>3. 役職が虚偽であった場合</li>
				 <li>4. 商談を45分以内で終えた場合(商談を実施しなかった場合含む)</li>
				 <li>5. 営業を受けるのではなく、自社サービスの営業提案を行った場合</li>
				 <li>6. サービスに全く興味がなく報酬目的のみと先方に伝えた場合</li>
				 <li>7. その他、サイト掲載規約、サイト利用規約内で報酬対象外と定められている行為を行った場合</li>
				 <li>8. 上記内容で、営業会社から申告が入った場合は、報酬は一旦保留となります。</li>
			 </ul>
			  <br><br><br>
			 <div>
			 **************************** <br>
			 EC Apo 運営事務局 <br>
			 株式会社リアリディール <br>
			 東京都渋谷区恵比寿4-20-3 <br>
			 恵比寿ガーデンプレイスタワー18階 <br>
			 sales-offer@ec-apo.com <br>
			 ****************************
			 </div>
		 ";
		 $headers = "MIME-Version: 1.0\r\n";
		 $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		 $headers .= "From:" . $from . "\r\n";
		 $headers .= "Bcc:" . $bcc . "\r\n";
		 mail($to,$subject,$message, $headers);

		$response['status'] = 'Success';
		exit(json_encode($response));
	}


}

add_action('wp_ajax_advance_search', 'advance_search');
add_action('wp_ajax_nopriv_advance_search', 'advance_search');

function advance_search() {
	global $seconddb;

	$data = $_POST['datas'];

	$company = $data['company'];
	$city = $data['city'];
	$position = $data['position'];
	$co_type = $data['co_type'];
	$co_title =  $data['co_title'];
	$co_capital = $data['co_capital'];
	$employees = $data['employees'];
	$workers = $data['workers'];
	$talkpref = $data['talkpref'];

	$co_type_arr = '"'.implode('","', array_map('strval', explode(',', $co_type))).'"';
	$co_title_arr = '"'.implode('","', array_map('strval', explode(',', $co_title))).'"';
	$co_capital_arr = '"'.implode('","', array_map('strval', explode(',', $co_capital))).'"';
	$employees_arr = '"'.implode('","', array_map('strval', explode(',', $employees))).'"';
	$workers_arr = '"'.implode('","', array_map('strval', explode(',', $workers))).'"';



	$where = "WHERE listflag = 'on' ";

	if(!empty($talkpref)){
		$where .= "AND talkpref = '$talkpref'";
	}

	if(!empty($position)){
		if ($position == '2'){
		 '';
		}else{
			$where .= "AND position <> '取締役(法人格)'";
		}
	}

	if(!empty($company)){
		$where .= "AND company LIKE '%$company%'";
	}
	
	if(!empty($co_type)){
		$where .= "AND type IN ($co_type_arr)";
	}
	if(!empty($co_title)){
		$where .= "AND position IN ($co_title_arr)";
	}
	if(!empty($co_capital)){
		$where .= "AND money IN ($co_capital_arr)";
	}
	if(!empty($employees)){
		$where .= "AND staff IN ($employees_arr)";
	}
	if(!empty($workers)){
		$where .= "AND baito IN ($workers_arr)";
	}

	$query = $seconddb->prepare("SELECT * FROM userlist $where ORDER BY rand()");
	//$query = $seconddb->prepare("SELECT * FROM userlist WHERE talkpref = '$city'");
	$result = $seconddb->get_results($query, ARRAY_A);

	$data_return = '';
	$data_return_1 = '';
	$data_return_2 = '';
	$data_return_3 = '';
	foreach((array)$result as $row){

		if($row['urlimgcheck'] == '3'){
			$img_url = htmlspecialchars($row["homepage"],ENT_QUOTES,"UTF-8");
			$img_src_c = '<img
            src="https://s.wordpress.com/mshots/v1/'.$img_url.'"
            alt="" width="740" height="460" class="attachment-size3 size-size3 wp-post-image" />';

			$data_return_1 .= 
			'
			<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
			<article class="p-blog-archive__item" style="width: 100%">
			<a class="p-hover-effect--type1" href="/company?userid='
			. htmlspecialchars($row['userid'],ENT_QUOTES,'UTF-8') .
			'" target="_blank">
			<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">'.
			$img_src_c .'
			</div>
			<div class="linktext">
			'.htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8').'<br>'.htmlspecialchars($row['pref'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['city'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['addr'],ENT_QUOTES,'UTF-8').
			'<br>'.'商談相手：'.htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8').
			'<br>'.'項目充実度：<span class="star">'.htmlspecialchars($row['star'],ENT_QUOTES,'UTF-8').'</span>
			<br>'.'業種：'.htmlspecialchars($row['jobs'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs2'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs3'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs4'],ENT_QUOTES,'UTF-8').'
			<br>商談設定金額：<span class="red">¥ '.htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8').'</span><br>
			</div>
			</a>
			</article>
			</div>
			';

		}elseif($row['urlimgcheck'] == '1'){
			$img_url = htmlspecialchars($row["userid"],ENT_QUOTES,"UTF-8");
			$img_src_c = '<img src="https://ec-apo.com/url/'.$img_url.'.png" width="740" height="460"
            class="attachment-size3 size-size3 wp-post-image" />';

			$data_return_2 .= 
			'
			<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
			<article class="p-blog-archive__item" style="width: 100%">
			<a class="p-hover-effect--type1" href="/company?userid='
			. htmlspecialchars($row['userid'],ENT_QUOTES,'UTF-8') .
			'" target="_blank">
			<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">'.
			$img_src_c .'
			</div>
			<div class="linktext">
			'.htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8').'<br>'.htmlspecialchars($row['pref'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['city'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['addr'],ENT_QUOTES,'UTF-8').
			'<br>'.'商談相手：'.htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8').
			'<br>'.'項目充実度：<span class="star">'.htmlspecialchars($row['star'],ENT_QUOTES,'UTF-8').'</span>
			<br>'.'業種：'.htmlspecialchars($row['jobs'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs2'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs3'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs4'],ENT_QUOTES,'UTF-8').'
			<br>商談設定金額：<span class="red">¥ '.htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8').'</span><br>
			</div>
			</a>
			</article>
			</div>
			';

		}else{
			$img_src_c = '<img src="https://ec-apo.com/img/nowprinting.png" width="740" height="460"
            class="attachment-size3 size-size3 wp-post-image" />';

			$data_return_3 .= 
			'
			<div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px">
			<article class="p-blog-archive__item" style="width: 100%">
			<a class="p-hover-effect--type1" href="/company?userid='
			. htmlspecialchars($row['userid'],ENT_QUOTES,'UTF-8') .
			'" target="_blank">
			<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">'.
			$img_src_c .'
			</div>
			<div class="linktext">
			'.htmlspecialchars($row['company'],ENT_QUOTES,'UTF-8').'<br>'.htmlspecialchars($row['pref'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['city'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['addr'],ENT_QUOTES,'UTF-8').
			'<br>'.'商談相手：'.htmlspecialchars($row['position'],ENT_QUOTES,'UTF-8').
			'<br>'.'項目充実度：<span class="star">'.htmlspecialchars($row['star'],ENT_QUOTES,'UTF-8').'</span>
			<br>'.'業種：'.htmlspecialchars($row['jobs'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs2'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs3'],ENT_QUOTES,'UTF-8').htmlspecialchars($row['jobs4'],ENT_QUOTES,'UTF-8').'
			<br>商談設定金額：<span class="red">¥ '.htmlspecialchars($row['paycost'],ENT_QUOTES,'UTF-8').'</span><br>
			</div>
			</a>
			</article>
			</div>
			';

		}
		
		
	}

	$data_return .= $data_return_1 . $data_return_2 . $data_return_3;


	exit($data_return);
	
}



function check_company_response() {
	global $seconddb;
	$curr_date = date('Y-m-d H:i:s', time());

	$fetch_company_no_response = $seconddb->get_results("SELECT * FROM remainder_mail WHERE scheduled <= '$curr_date' AND status = '0' ");

	

	foreach($fetch_company_no_response as $each_company){
		$order__id = $each_company->order_id;
		$company__id = $each_company->company_id;
		$initial_approval = $seconddb->get_var("SELECT vendor_approval FROM orders WHERE order_id='$order__id'");
    	$decode_initial_approval = json_decode($initial_approval, true);

		foreach ($decode_initial_approval as $key => $entry) {
            if ($entry['company_id'] == $company__id && $entry['status'] == "Pending") {

				$update_status = $seconddb->update("remainder_mail", array(
					"status" => '1',
				 ), array('id'=> $each_company->id));
		
		
				if($update_status){
					$from = "sales-offer@ec-apo.com";
					$to = $each_company->company_mail;
					$bcc = "sales-offer@ec-apo.com";
					$subject = $each_company->mail_subject;
					$message = $each_company->mail_body;
			
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= "From:" . $from . "\r\n";
					$headers .= "Bcc:" . $bcc . "\r\n";
					mail($to,$subject,$message, $headers);
				}

            }
        }
	}

}
add_action( 'check_company_response', 'check_company_response' );