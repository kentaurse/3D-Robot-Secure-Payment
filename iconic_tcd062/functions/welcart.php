<?php

/**
 * Welcart用init
 */
function tcd_welcart_init() {
	global $usces;

	if ( is_welcart_active() ) {
		// Welcart用initテーマバージョン定数
		if ( ! defined( 'USCES_THEME_VERSION' ) ) {
			define( 'USCES_THEME_VERSION', version_num() );
		}

		if ( ! is_admin() ) {
			// no_cart_css設定を強制的に無効化
			$usces->options['system']['no_cart_css'] = 1;

			// divide_item設定を強制的に有効化
			$usces->options['divide_item'] = 1;
		}
	}
}
add_action( 'init', 'tcd_welcart_init' );

/**
 * Welcartがインストール・有効化されているか
 */
if ( ! function_exists( 'is_welcart_active' ) ) {
	function is_welcart_active() {
		global $usces;

		if ( defined( 'USCES_VERSION' ) && $usces ) {
			return true;
		}

		return false;
	}
}

/**
 * Welcartの商品カテゴリーアーカイブか
 */
if ( ! function_exists( 'is_welcart_archive' ) ) {
	function is_welcart_archive() {
		if ( is_welcart_active() && is_category() ) {
			global $usces;
			$ids = $usces->get_item_cat_ids();
			$ids[] = USCES_ITEM_CAT_PARENT_ID;

			if ( in_array( get_query_var( 'cat' ), $ids ) ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Welcartの商品か
 */
if ( ! function_exists( 'is_welcart_single' ) ) {
	function is_welcart_single( $post_id = null ) {
		if ( is_single() && function_exists( 'usces_is_item' ) ) {
			return usces_is_item( $post_id );
		}

		return false;
	}
}

/**
 * Welcartページか
 */
if ( ! function_exists( 'is_welcart_page' ) ) {
	function is_welcart_page() {
		if ( function_exists( 'usces_page_name' ) ) {
			$page = usces_page_name( 'return' );
			if ( $page ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Welcartカートページか
 */
if ( ! function_exists( 'is_welcart_cart_page' ) ) {
	function is_welcart_cart_page() {
		if ( function_exists( 'usces_page_name' ) ) {
			$page = usces_page_name( 'return' );
			if ( $page && in_array( $page, array( 'cart', 'customer', 'delivery', 'confirm', 'ordercompletion' ) ) ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Welcartメンバーページか
 */
if ( ! function_exists( 'is_welcart_member_page' ) ) {
	function is_welcart_member_page() {
		if ( function_exists( 'usces_page_name' ) ) {
			$page = usces_page_name( 'return' );
			if ( $page && in_array( $page, array( 'login', 'newmemberform', 'lostmemberpassword', 'changepassword', 'newcompletion', 'editcompletion', 'lostcompletion', 'changepasscompletion' ) ) ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Welcart検索ページか
 */
if ( ! function_exists( 'is_welcart_search_page' ) ) {
	function is_welcart_search_page() {
		if ( function_exists( 'usces_page_name' ) ) {
			$page = usces_page_name( 'return' );
			if ( 'search_item' === $page ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Welcartメンバーページの固定ページタイトルを返す
 */
function get_welcart_member_page_original_title() {
	if ( defined( 'USCES_MEMBER_NUMBER' ) && USCES_MEMBER_NUMBER > 0 ) {
		$member_page = get_post( USCES_MEMBER_NUMBER );
		if ( !empty( $member_page->post_title ) ) {
			return strip_tags( $member_page->post_title );
		}
	}
	return __( 'Mypage', 'tcd-w' );
}

/**
 * Welcartメンバーページの置換後タイトルを返す
 */
function get_welcart_member_page_filterd_title() {
	global $usces;

	if ( $usces && isset( $usces->page ) ) {
		$title = $usces->filter_memberTitle( 'Member' );
		if ( 'Member' != $title ) {
			return $title;
		}
	}

	return get_welcart_member_page_original_title();
}

/**
 * Welcart商品の最適なカテゴリーを1つ返す
 */
function get_welcart_category( $post_id = null ) {
	global $usces, $post;

	$post_id = intval( $post_id );
	if ( $post_id < 0 ) {
		$post_id = $post->ID;
	}
	if ( $post_id < 0 ) {
		return false;
	}

	if ( function_exists( 'usces_is_item' ) && usces_is_item( $post_id ) ) {
		$categories = get_the_category( $post_id );

		// 商品ジャンル下のカテゴリーを探す
		$genre = get_category_by_slug( 'itemgenre' );
		if ( $categories && $genre ) {
			$genre_categories = get_categories( array(
				'child_of' => $genre->term_id,
				'hide_empty' => 0,
				'hierarchical' => 0
			) );

			// 商品ジャンル直下のカテゴリーを探す
			foreach( $genre_categories as $genre_category ) {
				if ( $genre_category->parent == $genre->term_id ) {
					foreach( $categories as $category ) {
						if ( $genre_category->term_id == $category->term_id ) {
							return $category;
						}
					}
				}
			}

			// 商品ジャンル下のカテゴリーを探す
			foreach( $genre_categories as $genre_category ) {
				foreach( $categories as $category ) {
					if ( $genre_category->term_id == $category->term_id ) {
						return $category;
					}
				}
			}
		}

		if ( defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) {
			foreach( $categories as $category ) {
				if ( $category->term_id != USCES_ITEM_CAT_PARENT_ID && $category->parent != USCES_ITEM_CAT_PARENT_ID ) {
					return $category;
				}
			}
			foreach( $categories as $category ) {
				if ( $category->term_id != USCES_ITEM_CAT_PARENT_ID ) {
					return $category;
				}
			}
		}

		foreach( $categories as $category ) {
			return $category;
		}
	}

	return false;
}

/**
 * Welcart レコメンド商品（この商品を買った人はこんな商品も買っています）の記事ID配列を返す
 */
function get_recommend_item_ids( $post_id = null, $limit = 6, $from_date = 'year' ) {
	if ( ! is_welcart_active() ) return false;

	global $usces, $post, $wpdb;

	$post_id = intval( $post_id );
	if ( $post_id < 0 ) {
		$post_id = $post->ID;
	}
	if ( $post_id < 0 ) {
		return false;
	}

	$limit = intval( $limit );
	if ( $limit < 1 ) {
		$limit = 6;
	}

	$order_table_name = $wpdb->prefix . "usces_order";
	$ordercart_table_name = $wpdb->prefix . "usces_ordercart";

	// usces_ordercartから$post_idが含まれるオーダー番号を取得するサブクエリー
	$subquery = "SELECT DISTINCT order_id FROM {$ordercart_table_name} "
		 . $wpdb->prepare( "WHERE post_id = %d ", $post_id )
		 . "ORDER BY order_id ASC";

	$sql = "SELECT oc.post_id FROM {$ordercart_table_name} AS oc "
		 . "INNER JOIN {$order_table_name} AS o ON o.ID = oc.order_id "
		 . $wpdb->prepare( "WHERE oc.post_id <> %d ", $post_id ). " "
		 . "AND FIND_IN_SET('completion', o.order_status) "
		 . "AND oc.order_id IN ( $subquery ) ";

	if ( $from_date ) {
		$from_date_sql = null;

		if ( 'year' === $from_date ) {
			$from_date_sql = date( 'Y-m-d 00:00:00', current_time( 'timestamp' ) - YEAR_IN_SECONDS );
		} elseif ( 'month' === $from_date ) {
			$from_date_sql = date( 'Y-m-d 00:00:00', current_time( 'timestamp' ) - MONTH_IN_SECONDS );
		} elseif ( 'week' === $from_date ) {
			$from_date_sql = date( 'Y-m-d 00:00:00', current_time( 'timestamp' ) - WEEK_IN_SECONDS );
		} elseif ( 'day' === $from_date ) {
			$from_date_sql = date( 'Y-m-d H:i:s', current_time( 'timestamp' ) - DAY_IN_SECONDS );
		} elseif ( is_int( $from_date ) && $from_date > YEAR_IN_SECONDS * 2000 ) {
			$from_date_sql = date( 'Y-m-d H:i:s', $from_date );
		} elseif ( preg_match( '#^\d{4}[\-\/]\d{1,2}[\-\/]\d{1,2}#', $from_date ) ) {
			$from_date_sql = $from_date;
		}

		if ( $from_date_sql ) {
			$sql .= $wpdb->prepare( "AND o.order_date >= %s ", $from_date_sql );
		}
	}
	
	$sql .= "GROUP BY oc.post_id ORDER BY COUNT(oc.cart_id) DESC ";
	$sql .= "LIMIT " . $limit;

	return $wpdb->get_col( $sql );
}

/**
 * ブログの前後記事でWelcart商品を除外するフィルター
 */
function tcd_usces_get_previous_next_post_where( $where, $in_same_term, $excluded_terms, $taxonomy, $post ) {
	if ( ! $in_same_term && is_welcart_active() ) {
		global $usces;
		$itemIds = $usces->getItemIds( 'front' );
		if ( $itemIds ) {
			$where .= ' AND p.ID NOT IN (' . implode( ',', $itemIds ). ')';
		}
	}
	return $where;
}
add_filter( 'get_previous_post_where', 'tcd_usces_get_previous_next_post_where', 10, 5 );
add_filter( 'get_next_post_where', 'tcd_usces_get_previous_next_post_where', 10, 5 );

/**
 * Welcart ログインタイトルフィルター
 */
function tcd_usces_filter_title_login( $title ) {
	return __( 'Log-in for members', 'tcd-w' );
}
add_filter( 'usces_filter_title_login', 'tcd_usces_filter_title_login', 10 );

/**
 * Welcart 会員登録タイトルフィルター
 */
function tcd_usces_filter_title_newmemberform( $title ) {
	return __( 'New enrollment form', 'tcd-w' );
}
add_filter( 'usces_filter_title_newmemberform', 'tcd_usces_filter_title_newmemberform', 10 );

/**
 * Welcart カートの中タイトルフィルター
 */
function tcd_usces_filter_title_cart( $title ) {
	return __( 'In the cart', 'tcd-w' );
}
add_filter( 'usces_filter_title_cart', 'tcd_usces_filter_title_cart', 10 );

/**
 * Welcart カートに入れるボタンhtmlフィルター
 */
function tcd_usces_filter_item_sku_button( $html, $value, $type ) {
	return str_replace( ' class="skubutton"', ' class="skubutton p-wc-button-sku p-button"', $html );
}
add_filter( 'usces_filter_item_sku_button', 'tcd_usces_filter_item_sku_button', 10, 3 );

/**
 * Welcart カートに入れる数量htmlフィルター
 */
function tcd_usces_filter_the_itemQuant( $html, $post ) {
	return str_replace( ' type="text"', ' type="number" min="1"', $html );
}
add_filter( 'usces_filter_the_itemQuant', 'tcd_usces_filter_the_itemQuant', 10, 2 );

/**
 * Welcart ログインボタンhtmlフィルター
 */
function tcd_usces_filter_login_button( $html ) {
	return str_replace( 'class="member_login_button"', 'class="p-wc-login-button p-button p-button--xl"', $html );
}
add_filter( 'usces_filter_login_button', 'tcd_usces_filter_login_button' );

/**
 * Welcart 会員登録ボタンhtmlフィルター
 */
function tcd_usces_filter_newmember_button( $html ) {
	return str_replace( ' type="submit" value=', ' type="submit"class="p-wc-newmember-button p-button p-button--xl" value=', $html );
}
add_filter( 'usces_filter_newmember_button', 'tcd_usces_filter_newmember_button' );

/**
 * Welcart カートページボタンhtmlフィルター
 */
function tcd_usces_filter_get_cart_button( $html ) {
	$html = str_replace( ' class="continue_shopping_button"', ' class="continue_shopping_button p-button p-button--lg"', $html );
	$html = str_replace( ' class="to_customerinfo_button"', ' class="to_customerinfo_button p-button p-button--lg"', $html );
	$html = str_replace( '>&nbsp;&nbsp;<', '> <', $html );
	return $html;
}
add_filter( 'usces_filter_get_cart_button', 'tcd_usces_filter_get_cart_button' );

/**
 * Welcart カートカスタマーページボタンhtmlフィルター
 */
function tcd_usces_filter_get_customer_button( $html ) {
	$html = str_replace( ' class="back_cart_button"', ' class="back_cart_button p-button-back p-button--white p-button--lg"', $html );
	$html = str_replace( ' value="' . __( 'Back', 'usces' ) . '"', ' value="' . __( '&lt; Back', 'tcd-w' ) . '"', $html );
	$html = str_replace( ' class="to_deliveryinfo_button"', ' class="to_deliveryinfo_button p-button p-button--lg"', $html );
	$html = str_replace( ' class="to_reganddeliveryinfo_button"', ' class="to_reganddeliveryinfo_button p-button p-button--lg"', $html );
	if ( usces_is_membersystem_state() ){
		$html = str_replace( ' value="' . __( ' Next ', 'usces' ).'"', ' value="' . __( 'To the next without member enrollment', 'tcd-w' ) . '"', $html );
	}
	$html = str_replace( '&nbsp;&nbsp;', '', $html );
	return $html;
}
add_filter( 'usces_filter_get_customer_button', 'tcd_usces_filter_get_customer_button' );

/**
 * Welcart カート確認ページボタンhtmlフィルター
 */
function tcd_usces_filter_confirm_inform( $html ) {
	$html = str_replace( ' class="back_to_delivery_button"', ' class="back_to_delivery_button p-button-back p-button--white p-button--lg"', $html );
	$html = str_replace( array( ' value="' . __( 'Back to payment method page.', 'usces' ) . '"', ' value="' . __( 'Back', 'usces' ) . '"' ), ' value="' . __( '&lt; Back', 'tcd-w' ) . '"', $html );
	$html = str_replace( ' type="submit" id="back_button" value="', ' class="p-button-back p-button--white p-button--lg" type="submit" id="back_button" value="', $html );
	$html = str_replace( ' class="checkout_button"', ' class="checkout_button p-button p-button--lg"', $html );
	return $html;
}
add_filter( 'usces_filter_confirm_inform', 'tcd_usces_filter_confirm_inform' );

/**
 * Welcart カート内容画像htmlフィルター
 */
function tcd_usces_filter_cart_thumbnail( $html, $post_id, $pictid, $i, $cart_row ) {
	if ( $pictid ) {
		return '<a href="' . get_permalink( $post_id ) . '">' . wp_get_attachment_image( $pictid, array( 80, 80 ), true ) . '</a>';
	} else {
		return '<a href="' . get_permalink( $post_id ) . '"><img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt=""></a>';
	}
}
add_filter( 'usces_filter_cart_thumbnail', 'tcd_usces_filter_cart_thumbnail', 10, 5 );

/**
 * Welcart カート内容htmlフィルター
 */
function tcd_usces_filter_cart_rows( $html ) {
	$html = str_replace( ' class="quantity" type="text" value="', ' class="quantity" type="number" min="0" value="', $html );
	$html = str_replace( '<td class="num">', '<td class="num" data-label="No.">', $html );
	$html = str_replace( '<td class="aright unitprice">', '<td class="aright unitprice" data-label="' . esc_attr__( 'Unit price', 'tcd-w' ) .'">', $html );
	$html = str_replace( '<td class="quantity">', '<td class="quantity" data-label="' . esc_attr__( 'Quantity', 'tcd-w' ) .'">', $html );
	$html = str_replace( '<td class="aright subtotal">', '<td class="aright subtotal" data-label="' . esc_attr__( 'Amount', 'tcd-w' ) .'">', $html );
	$html = str_replace( '<td class="stock">', '<td class="stock" data-label="' . esc_attr__( 'Stock status', 'tcd-w' ) .'">', $html );
	return $html;
}
add_filter( 'usces_filter_cart_rows', 'tcd_usces_filter_cart_rows' );

/**
 * Welcart 購入履歴htmlフィルター
 */
function tcd_usces_filter_member_history( $html ) {
	$html = str_replace( ' id="history_head"', ' class="history_head"', $html );
	$html = str_replace( ' class="retail"', ' class="retail p-wc-cart_table"', $html );
	$html = str_replace( '<td class="cartrownum">', '<td class="cartrownum" data-label="No.">', $html );
	$html = str_replace( '<td class="rightnum price">', '<td class="rightnum price" data-label="' . esc_attr__( 'Unit price', 'tcd-w' ) .'">', $html );
	$html = str_replace( '<td class="rightnum quantity">', '<td class="rightnum quantity" data-label="' . esc_attr__( 'Quantity', 'tcd-w' ) .'">', $html );
	$html = str_replace( '<td class="rightnum subtotal">', '<td class="arightnumright subtotal" data-label="' . esc_attr__( 'Amount', 'tcd-w' ) .'">', $html );
	return $html;
}
add_filter( 'usces_filter_member_history', 'tcd_usces_filter_member_history', 20 );

/**
 * Welcart 会員フォームフィルター
 */
function tcd_usces_filter_apply_addressform( $formtag, $type = null, $data = null ) {
	// 'building name'が使われるのは日本語のみ
	$formtag = str_replace( '<th scope="row">' . __( 'building name', 'usces' ) . '</th>', '<th scope="row">' . __( 'building name', 'tcd-w' ) . '</th>', $formtag );
	$formtag = str_replace( '<th>' . __( 'building name', 'usces' ) . '</th>', '<th>' . __( 'building name', 'tcd-w' ) . '</th>', $formtag );
	return $formtag;
}
add_filter( 'usces_filter_apply_addressform', 'tcd_usces_filter_apply_addressform', 10, 3 );
add_filter( 'usces_filter_apply_addressform_confirm', 'tcd_usces_filter_apply_addressform', 10, 3 );
add_filter( 'usces_filter_shipping_address_info', 'tcd_usces_filter_apply_addressform', 10, 1 );

/**
 * Welcart 会員フォーム 郵便番号 例フィルター
 */
function tcd_usces_filter_after_zipcode( $text, $applyform ) {
	if ( 'JP' == $applyform ) {
		return __( '123-4567', 'tcd-w' );
	}
	return $text;
}
add_filter( 'usces_filter_after_zipcode', 'tcd_usces_filter_after_zipcode', 10, 2 );

/**
 * Welcart 会員フォーム 市区町村 例フィルター
 */
function tcd_usces_filter_after_address1( $text, $applyform ) {
	if ( 'JP' == $applyform ) {
		return __( 'Chuo-ku, Osaka', 'tcd-w' );
	}
	return $text;
}
add_filter( 'usces_filter_after_address1', 'tcd_usces_filter_after_address1', 10, 2 );

/**
 * Welcart 会員フォーム ビル名 例フィルター
 */
function tcd_usces_filter_after_address3( $text, $applyform ) {
	return __( 'tuhanbuild 12F 1234', 'tcd-w' );
}
add_filter( 'usces_filter_after_address3', 'tcd_usces_filter_after_address3', 10, 2 );


/**
 * Welcart 会員フォーム 電話番号・FAX番号 例フィルター
 */
function tcd_usces_filter_after_tel( $text, $applyform ) {
	if ( 'JP' == $applyform ) {
		return __( '06-0000-0000', 'tcd-w' );
	}
	return $text;
}
add_filter( 'usces_filter_after_tel', 'tcd_usces_filter_after_tel', 10, 2 );
add_filter( 'usces_filter_after_fax', 'tcd_usces_filter_after_tel', 10, 2 );

/**
 * Welcart 会員フォーム 共通 例フィルター
 */
function tcd_usces_filter_after_memberform_input( $text, $applyform ) {
	if ( $text ) {
		$text = __( 'Ex. ', 'tcd-w' ) . $text;
	}
	return $text;
}
add_filter( 'usces_filter_after_zipcode', 'tcd_usces_filter_after_memberform_input', 10, 2 );
add_filter( 'usces_filter_after_address1', 'tcd_usces_filter_after_memberform_input', 10, 2 );
add_filter( 'usces_filter_after_address2', 'tcd_usces_filter_after_memberform_input', 10, 2 );
add_filter( 'usces_filter_after_address3', 'tcd_usces_filter_after_memberform_input', 10, 2 );
add_filter( 'usces_filter_after_tel', 'tcd_usces_filter_after_memberform_input', 10, 2 );
add_filter( 'usces_filter_after_fax', 'tcd_usces_filter_after_memberform_input', 10, 2 );

/**
 * Welcartプラグイン用init
 */
function tcd_welcart_plugin_init() {
	global $usces;

	if ( is_admin() || ! is_welcart_active() ) return;

	// WCEX Auto Delivery
	if ( defined( 'WCEX_AUTO_DELIVERY' ) && WCEX_AUTO_DELIVERY ) {
		// 商品ページでの定期購入htmlフィルター
		add_filter( 'wcad_filter_item_single_regular', 'tcd_wcad_filter_item_single_regular' );
		// 商品ページでの定期購入htmlフィルター SKUセレクト併用時
		add_filter( 'wcex_sku_select_filter_single_item_autodelivery', 'tcd_wcad_filter_item_single_regular' );
		// 購入回数無制限の定期購入で商品ページのの購入回数行が空になる対策フィルター
		add_filter( 'wcad_filter_item_single_label_frequency_free', 'wcad_filter_item_single_label_frequency_free' );
		add_filter( 'wcad_filter_item_single_value_frequency_free', 'tcd_wcad_filter_item_single_value_frequency_free' );

		// マイページの「定期購入情報はこちら」のリンク位置を会員情報上（.p-wc-header_explanation）から会員情報下（.p-wc-member_submenu）に変更
		remove_action( 'usces_action_memberinfo_page_header', 'wcad_action_memberinfo_page_header' );
		add_filter( 'usces_filter_member_submenu_list', 'tcd_wcad_filter_member_submenu_list', 9 );
	}

	// WCEX Coupon
	if ( defined( 'WCEX_COUPON' ) && WCEX_COUPON ) {
		// フロントエンド用css削除
		remove_action( 'wp_enqueue_scripts', 'wccp_front_enqueue_style' );

		// カート確認ページでのクーポン入力フォームHTML差し替え
		remove_action( 'usces_action_confirm_after_form', 'wccp_action_confirm_after_form' );
		remove_filter( 'usces_filter_confirm_after_form', 'wccp_filter_confirm_after_form' );
		add_action( 'usces_action_confirm_after_form', 'tcd_wccp_action_confirm_after_form' );
		add_filter( 'usces_filter_confirm_after_form', 'tcd_wccp_filter_confirm_after_form' );
	}

	// WCEX Multiple Shipping
	if ( defined( 'WCEX_MSA' ) && WCEX_MSA ) {
		// カート発送ページでのギフト配送先HTML差し替え
		remove_action( 'usces_action_delivery_flag', 'msa_delivery_flag' );
		remove_filter( 'usces_filter_delivery_flag', 'msa_delivery_flag_filter' );
		add_action( 'usces_action_delivery_flag', 'tcd_msa_delivery_flag' );
		add_filter( 'usces_filter_delivery_flag', 'tcd_msa_delivery_flag_filter' );
	}
}
add_action( 'init', 'tcd_welcart_plugin_init' );

/**
 * Welcartプラグイン WCEX Auto Delivery・WCEX DL Seller カートお客様情報ページでログインのみ有効にする関数
 * Welcart Basicテーマ welcart_basic_have_ex_order()をコピー
 */
function tcd_welcart_have_ex_order() {
	$ex_order = false;
	if( defined( 'WCEX_DLSELLER' ) ) {
		$ex_order = ( ! dlseller_have_dlseller_content() && ! dlseller_have_continue_charge() ) ? false : true;
	} elseif( defined( 'WCEX_AUTO_DELIVERY' ) ) {
		$ex_order = wcad_have_regular_order();
	}
	return $ex_order;
}

/**
 * Welcart マイページでの会員サブメニューフィルター
 */
function tcd_usces_filter_member_submenu_list( $html ) {

	// 改行削除
	$html = str_replace( array( "\r\n", "\r", "\n" ), '', $html );

	// div.gotoeditをliに変更
	if ( preg_match_all( '#(\s*<div class="gotoedit">(.*?)</div>\s*)(<li|$)#i', $html, $matches ) ) {
		foreach( array_keys( $matches[1] ) as $key ) {
			$html = str_replace( $matches[1][$key], '<li>' . trim( $matches[2][$key] ) . '</li>', $html );
		}
	}

	// aタグにp-buttonクラス追加
	if ( preg_match_all( '#<a .*?>.*?</a>#i', $html, $matches ) ) {
		foreach( $matches[0] as $match ) {
			if ( preg_match( '#<a .*?(class=(["\'])([^"\']*)(["\']))#i', $match, $matches2 ) ) {
				$replace = str_replace( $matches2[1], 'class=' . $matches2[2] . $matches2[3] . ' p-button' . $matches2[4], $match );
			} else {
				$replace = str_replace( '<a ', '<a class="p-button" ', $match );
			}
			$html = str_replace( $match, $replace, $html );
		}
	}

	return $html;
}
add_filter( 'usces_filter_member_submenu_list', 'tcd_usces_filter_member_submenu_list', 99 );

/**
 * Welcartプラグイン WCEX Auto Delivery 商品ページでの定期購入htmlフィルター
 */
function tcd_wcad_filter_item_single_regular( $html ) {
	$html = str_replace( ' class="wcr_tlt"', ' class="p-headline"', $html );
	$html = str_replace( ' class="inside"', ' class="inside p-entry__body p-wc__body"', $html );
	$html = str_replace( ' class="skubutton"', ' class="skubutton p-button"', $html );
	$html = str_replace( ' align="right"', '', $html );
	$html = str_replace( ' class="field_price"', ' class="field_price p-price p-entry-item__price"', $html );
	$html = preg_replace( '#<input name="([^"]+)" type="text" id="([^"]+)" class="skuquantity"#', '<input name="$1" type="number" id="$2" class="skuquantity"', $html );
	return $html;
}

/**
 * Welcartプラグイン WCEX Auto Delivery 購入回数無制限の定期購入で商品ページのの購入回数行が空になる対策フィルター
 */
function wcad_filter_item_single_label_frequency_free( $text ) {
	return __( 'Frequency', 'autodelivery' );
}
function tcd_wcad_filter_item_single_value_frequency_free( $text ) {
	return __( 'Free cycle', 'autodelivery' );
}

/**
 * Welcartプラグイン WCEX Auto Delivery マイページの「定期購入情報はこちら」のリンクを会員サブメニューに表示
 */
function tcd_wcad_filter_member_submenu_list( $html ) {
	global $usces;

	$member = $usces->get_member();
	if ( $member && wcad_have_member_regular_order( $member['ID'] ) ) {
		$member_url = add_query_arg( 'page', 'autodelivery_history', USCES_MEMBER_URL );
		$html .= '<li><a href="' . $member_url . '">' . __( "Regular purchase information is here >>", 'autodelivery' ) . '</a></li>';
	}

	return $html;
}

/**
 * Welcartプラグイン WCEX Coupon カート確認ページでのクーポン入力フォーム出力アクション・フィルター
 * v1.0.11のHTML構造を変更
 */
function tcd_wccp_action_confirm_after_form( $html = null ) {
	$html = tcd_wccp_filter_confirm_after_form( $html );
	echo $html;
}
function tcd_wccp_filter_confirm_after_form( $html = null ) {
	global $usces_entries;

	$wccp = get_option( 'wccp' );
	$html = '';
	if( $wccp['front_display'] === '0' || ( $wccp['front_display'] === '1' && usces_is_login() ) ) {
		$usedcoupon = ( isset( $usces_entries['order']['usedcoupon'] ) ) ? $usces_entries['order']['usedcoupon'] : '';
		$class = ' class="p-wc-coupon_table"';
		$html .= '<form action="' . usces_url( 'cart', 'return' ) . '" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">';
		$html .= apply_filters( 'wccp_filter_coupon_inform', '', $usces_entries );
		$html .= '<table cellspacing="0" id="coupon_table"' . $class . '>
					<tr>
						<th>' . esc_html__( 'Coupon Code', 'coupon' ) . '</th>
						<td><input name="offer[usedcoupon]" class="used_coupon" type="text" value="' . esc_attr( $usedcoupon ) . '" /></td>
					</tr>
				</table>
				<div class="send send_use_coupon">
					<input name="use_coupon" type="submit" class="use_coupon_button p-button" value="' . esc_attr__( 'Use a coupon', 'coupon' ) . '"><input type="submit" name="reset_coupon" class="reset_coupon_button p-button" value="' . esc_attr__( 'Cancel', 'coupon' ) . '">
				</div>
				</form>';
	}
	return $html;
}

/**
 * Welcartプラグイン WCEX Multiple Shipping カート発送ページでのtable出力アクション・フィルター
 * v1.1.12のtableクラス名を変更
 */
function tcd_msa_delivery_flag(){
	echo tcd_msa_delivery_flag_filter();
}
function tcd_msa_delivery_flag_filter( $thml = null ){
	global $usces, $usces_entries;
	$usces->get_current_member();
	if( !$usces->current_member['id'] || have_unavailable_item() )
		return $thml;

	$gift_label = apply_filters( 'msa_filter_gift_label', 'ギフト用' );
	$thml .= '
	<table class="p-wc-customer_form p-wc-customer_form--shipping-msa">
		<tr>
			<th scope="row">'.esc_html($gift_label).'複数配送先</th>
			<td class="msa_row"><input name="delivery[delivery_flag]" id="delivery_flag3" onclick="document.getElementById(\'delivery_table\').style.display = \'none\'" type="radio" value="2"' . (( isset($usces_entries['delivery']['delivery_flag']) && $usces_entries['delivery']['delivery_flag'] == 2) ? ' checked' : '') . ' onKeyDown="if (event.keyCode == 13) {return false;}" /> <label for="delivery_flag3"><span id="open_allocation"><span class="open_allocation_bt">複数配送を選択、編集する</span></span></label></td>
		</tr>
	</table>';
	return $thml;
}

/**
 *  v1.9.20以下のWelcart + 新しいバージョンのWelcartプラグインでCall to undefined function usces_get_order_condition() が起こる対策
 */
if ( is_welcart_active() && ! function_exists( 'usces_get_order_condition' ) ) {
	function usces_get_order_condition( $order_id ) {
		global $wpdb;
		$order_condition = $wpdb->get_var( $wpdb->prepare( "SELECT order_condition FROM {$wpdb->prefix}usces_order WHERE ID = %d", $order_id ) );
		return maybe_unserialize( $order_condition );
	}
}

/**
 * Welcart 商品保存アクションフック _tcd_stock及び価格範囲表示用カスタムフィールドを更新する
 */
function tcd_usces_action_save_product( $post_id, $post ) {
	update_item_meta_tcd_stock( $post_id );
	update_item_meta_tcd_min_max_price( $post_id );
}
add_action( 'usces_action_save_product', 'tcd_usces_action_save_product', 10, 2 );

/**
 * Welcart フロントエンド・管理画面共通 受注作成後アクションフック _tcd_stockカスタムフィールドを更新する
 * 参考 plugins/usc-e-shop/functions/filters.php usces_action_reg_orderdata_stocks()
 */
function tcd_usces_action_reg_orderdata_update_tcd_stock( $args ) {
	extract( $args );

	if ( empty( $cart ) ) return;

	$post_ids = array();

	foreach( $cart as $cartrow ) {
		if ( ! empty( $cartrow['post_id'] ) ) {
			$post_ids[] = $cartrow['post_id'];
		}
	}

	if ( $post_ids ) {
		foreach( array_unique( $post_ids ) as $post_id ) {
			update_item_meta_tcd_stock( $post_id );
		}
	}
}
add_action( 'usces_action_reg_orderdata', 'tcd_usces_action_reg_orderdata_update_tcd_stock', 20 );

/**
 * Welcart 管理画面での受注データ更新後アクションフック _tcd_stockカスタムフィールドを更新する
 */
function tcd_usces_action_update_orderdata_update_tcd_stock( $new_orderdata, $old_status, $old_orderdata, $new_cart, $old_cart ) {
	$post_ids = array();

	foreach( $new_cart as $cartrow ) {
		if ( ! empty( $cartrow['post_id'] ) ) {
			$post_ids[] = $cartrow['post_id'];
		}
	}

	foreach( $old_cart as $cartrow ) {
		if ( ! empty( $cartrow['post_id'] ) ) {
			$post_ids[] = $cartrow['post_id'];
		}
	}

	if ( $post_ids ) {
		foreach( array_unique( $post_ids ) as $post_id ) {
			update_item_meta_tcd_stock( $post_id );
		}
	}
}
add_action( 'usces_action_update_orderdata', 'tcd_usces_action_update_orderdata_update_tcd_stock', 20, 5 );

/**
 * Welcart 管理画面での受注データ単体削除アクションフック _tcd_stockカスタムフィールドを更新する
 * 参考 plugins/usc-e-shop/extensions\OrderStockLinkage/order_stock_linkage.php USCES_STOCK_LINKAGE::del_order()
 */
function tcd_usces_action_del_orderdata_update_tcd_stock( $orderdata, $args ) {
	global $usces;

	if ( empty( $args['ID'] ) ) return;

	$carts = usces_get_ordercartdata( $args['ID'] );
	if ( ! $carts ) return;

	$post_ids = array();

	foreach( $carts as $cartrow ){
		if ( ! empty( $cartrow['post_id'] ) ) {
			$post_ids[] = $cartrow['post_id'];
		}
	}

	if ( $post_ids ) {
		foreach( array_unique( $post_ids ) as $post_id ) {
			update_item_meta_tcd_stock( $post_id );
		}
	}
}
add_action( 'usces_action_del_orderdata', 'tcd_usces_action_del_orderdata_update_tcd_stock', 20, 2 );

/**
 * Welcart 管理画面での受注データ一括削除アクションフック _tcd_stockカスタムフィールドを更新する
 * 参考 plugins/usc-e-shop/extensions\OrderStockLinkage/order_stock_linkage.php USCES_STOCK_LINKAGE::collective_del_order()
 */
function tcd_usces_action_collective_order_delete_each_update_tcd_stock( $id, $order_res ) {
	if ( ! $id ) return;

	$carts = usces_get_ordercartdata( $id );
	if ( ! $carts ) return;

	$post_ids = array();

	foreach( $carts as $cartrow ){
		if ( ! empty( $cartrow['post_id'] ) ) {
			$post_ids[] = $cartrow['post_id'];
		}
	}

	if ( $post_ids ) {
		foreach( array_unique( $post_ids ) as $post_id ) {
			update_item_meta_tcd_stock( $post_id );
		}
	}
}
add_action( 'usces_action_collective_order_delete_each', 'tcd_usces_action_collective_order_delete_each_update_tcd_stock', 20, 2 );

/**
 * Welcart 商品編集画面でSKUの追加・更新・削除時フィルターフック _tcd_stock及び価格範囲表示用カスタムフィールドを更新する
 * メッセージ変更用のフィルターのため$msgをそのまま返す
 */
function tcd_usces_filter_item_sku_message_update_item_meta( $msg, $id, $post_id ) {
	update_item_meta_tcd_stock( $post_id );
	update_item_meta_tcd_min_max_price( $post_id );

	return $msg;
}
add_filter( 'usces_filter_item_sku_message', 'tcd_usces_filter_item_sku_message_update_item_meta', 20, 3 );

/**
 * Welcart 引数商品IDの在庫状況に応じて_tcd_stockカスタムフィールドを更新する
 */
function update_item_meta_tcd_stock( $post_id ) {
	$post_id = intval( $post_id );
	if ( 0 >= $post_id ) return;

	$tcd_stock = usces_have_zaiko_anyone( $post_id ) ? 1 : 0;

	update_post_meta( $post_id, '_tcd_stock', $tcd_stock );
}

/**
 * Welcart 引数商品IDの在庫状況に応じて価格範囲表示用カスタムフィールドを更新する
 */
function update_item_meta_tcd_min_max_price( $post_id ) {
	global $usces;

	$post_id = intval( $post_id );
	if ( ! $usces || 0 >= $post_id ) return;

	$min_price = 0;
	$max_price = 0;
	$skus = $usces->get_skus( $post_id );

	if ( $skus ) {
		foreach( $skus as $sku ) {
			if ( isset( $sku['price'] ) ) {
				$sku['price'] = intval( $sku['price'] );
				if ( 0 >= $min_price ) {
					$min_price = $sku['price'];
				} else {
					$min_price = min( $min_price, $sku['price'] );
				}
				if ( 0 >= $max_price ) {
					$max_price = $sku['price'];
				} else {
					$max_price = max( $max_price, $sku['price'] );
				}
			}
		}

		if ( $min_price && $max_price ) {
			update_post_meta( $post_id, '_tcd_min_price', $min_price );
			update_post_meta( $post_id, '_tcd_max_price', $max_price );
		} else {
			delete_post_meta( $post_id, '_tcd_min_price' );
			delete_post_meta( $post_id, '_tcd_max_price' );
		}

	} else {
		delete_post_meta( $post_id, '_tcd_min_price' );
		delete_post_meta( $post_id, '_tcd_max_price' );
	}
}
