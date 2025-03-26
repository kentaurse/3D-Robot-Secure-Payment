<?php

if ( ! is_admin() && ! is_mobile() ) {
	add_action( 'wp', 'tcd_megamenu_init' );
	add_filter( 'nav_menu_css_class', 'tcd_megamenu_nav_menu_css_class', 10, 4 );
}

/**
 * メガメニュー初期化
 */
function tcd_megamenu_init() {
	global $tcd_megamenu, $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$tcd_megamenu = array();

	if ( empty( $dp_options['megamenu'] ) ) return false;

	// グローバルメニューアイテムを取得
	$menu_locations = get_nav_menu_locations();
	$nav_menus = wp_get_nav_menus();
	if ( ! empty( $menu_locations['global'] ) && $nav_menus && ! is_wp_error( $nav_menus ) ) {
		foreach ( $nav_menus as $nav_menu ) {
			if ( $nav_menu->term_id == $menu_locations['global'] ) {
				$global_menu_items = wp_get_nav_menu_items( $nav_menu );
				break;
			}
		}
	}

	// グローバルメニューアイテム
	if ( ! empty( $global_menu_items ) && ! is_wp_error( $global_menu_items ) ) {
		// メニューアイテムをループ
		foreach ( $global_menu_items as $global_menu_item ) {
			if ( ! isset( $global_menu_item->menu_item_parent ) ) continue;

			// 親メニュー
			if ( 0 == $global_menu_item->menu_item_parent ) {
				// メガメニュー設定あり
				if ( ! empty( $dp_options['megamenu'][$global_menu_item->db_id] ) && in_array( $dp_options['megamenu'][$global_menu_item->db_id], array( 'type2', 'type3', 'type4' ) ) ) {
					$tcd_megamenu[$global_menu_item->db_id]['type'] = $dp_options['megamenu'][$global_menu_item->db_id];
					$tcd_megamenu[$global_menu_item->db_id]['item'] = $global_menu_item;
				}

				// メガメニューの直下カテゴリー
			} elseif ( isset( $tcd_megamenu[$global_menu_item->menu_item_parent] ) && 'taxonomy' === $global_menu_item->type && 'category' === $global_menu_item->object ) {
				$tcd_megamenu[$global_menu_item->menu_item_parent]['categories'][] = $global_menu_item;
			}
		}

		// 直下カテゴリーが無いメガメニューをメガメニューから削除
		foreach ( $tcd_megamenu as $key => $value ) {
			if ( empty( $value['categories'] ) ) {
				unset( $tcd_megamenu[$key] );
			}
		}
	}

	return ! empty( $tcd_megamenu );
}

/**
 * wp_nav_menu用 メニュー表示のcssフィルター
 */
function tcd_megamenu_nav_menu_css_class( $classes, $item, $args, $depth ) {
	global $tcd_megamenu;

	// メガメニューの場合にmenu-megamenuクラス追加
	if ( isset( $item->db_id ) && isset( $tcd_megamenu[$item->db_id] ) ) {
		$classes[] = 'menu-megamenu';
	}

	return $classes;
}

