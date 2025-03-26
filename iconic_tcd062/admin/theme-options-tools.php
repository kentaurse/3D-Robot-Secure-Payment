<?php

/**
 * オプションTools エクスポート・インポート・リセット 実行
 */
function theme_options_tools() {
	global $pagenow;

	// テーマオプションサブミット先はoptions.php
	if ( 'options.php' != $pagenow ) return;

	// TCDテーマオプションサブミットチェック
	if ( empty( $_POST['option_page'] ) || 'design_plus_options' !== $_POST['option_page'] || empty( $_POST['dp_options'] ) ) return;

	// エクスポート
	if ( ! empty( $_POST['tcd-tools-export'] ) ) {
		// 現設定取得
		if ( function_exists( 'get_design_plus_options' ) ) {
			$dp_options = get_design_plus_options();
		} elseif ( function_exists( 'get_design_plus_option' ) ) {
			$dp_options = get_design_plus_option();
		} elseif ( function_exists( 'get_desing_plus_options' ) ) {
			$dp_options = get_desing_plus_options();
		} elseif ( function_exists( 'get_desing_plus_option' ) ) {
			$dp_options = get_desing_plus_option();
		} else {
			$dp_options = array();
		}

		// postされた設定取得して現設定にマージ
		if ( ! empty( $_POST['dp_options'] ) ) {
			$dp_options_posted = wp_unslash( $_POST['dp_options'] );
			// バリデート
			$dp_options_posted = theme_options_validate( $dp_options_posted );
			// マージ
			$dp_options = array_merge( $dp_options, $dp_options_posted );
		}

		// エクスポート設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-export', $dp_options );

		// ファイル名
		$filename = implode( '-', array(
			'tcd_theme_options',
			'export',
			get_bloginfo( 'name' ),
			wp_get_theme()->get( 'Name' ),
			date( 'Ymd', current_time( 'timestamp' ) )
		) ) . '.json';

		// json出力
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . rawurlencode( $filename ) . '"');
		if ( defined('JSON_PRETTY_PRINT') ) {
			echo json_encode( $dp_options, JSON_PRETTY_PRINT );
		} else {
			echo json_encode( $dp_options );
		}
		exit();

	// インポート
	} elseif ( ! empty( $_POST['tcd-tools-import'] ) ) {
		$json = _theme_options_tools_get_import_json();
		if ( is_numeric( $json ) ) {
			$import_error = $json;
		} elseif ( ! is_array( $json ) ) {
			$import_error = 15;
		} else {
			// 現設定取得
			if ( function_exists( 'get_design_plus_options' ) ) {
				$dp_options = get_design_plus_options();
			} elseif ( function_exists( 'get_design_plus_option' ) ) {
				$dp_options = get_design_plus_option();
			} elseif ( function_exists( 'get_desing_plus_options' ) ) {
				$dp_options = get_desing_plus_options();
			} elseif ( function_exists( 'get_desing_plus_option' ) ) {
				$dp_options = get_desing_plus_option();
			} else {
				$dp_options = array();
			}

			// 現設定にインポート設定マージ
			// jsonファイルを任意編集・部分インポートの場合を考慮してここではバリデートは行わない
			$dp_options = array_merge( $dp_options, $json );

			// インポート設定フィルター
			$dp_options = apply_filters( 'tcd_theme_options_tools-import', $dp_options );

			// 保存
			update_option( 'dp_options', $dp_options );
		}

		// エラーリダイレクト先
		if ( ! empty( $import_error ) ) {
			$redirect = add_query_arg( 'tcd-tools-result', 'import-error' . $import_error, wp_get_referer() );

		// 成功リダイレクト先
		} else {
			$redirect = add_query_arg( 'tcd-tools-result', 'import-success', wp_get_referer() );
		}

	// リセット
	} elseif ( ! empty( $_POST['tcd-tools-reset'] ) ) {
		// デフォルト設定取得
		global $dp_default_options;
		if ( $dp_default_options && is_array( $dp_default_options ) ) {
			$dp_options = $dp_default_options;
		} else {
			$dp_options = array();
		}

		// リセットデフォルト設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-reset-default_options', $dp_options );

		// リセット設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-reset', $dp_options );

		// テーマ初期化があれば上書きモードで実行
		if ( function_exists( 'theme_options_tools_initialize' ) ) {
			theme_options_tools_initialize( $dp_options, true, true );
		} else {
			// 保存 ここでtheme_options_validateが実行されるので値には注意
			update_option( 'dp_options', $dp_options );
		}

		// リダイレクト先
		$redirect = add_query_arg( 'tcd-tools-result', 'reset-success', wp_get_referer() );
	}

	// リダイレクト
	if ( ! empty( $redirect ) ) {
		// 保存メッセージが残っている場合があるので削除
		wp_redirect( remove_query_arg( 'settings-updated', $redirect ) );
		exit();
	}
}
add_action( 'admin_init', 'theme_options_tools' );

/**
 * オプションTools jsonインポート
 */
function _theme_options_tools_get_import_json() {
	if ( empty( $_FILES['tcd-tools-import-file'] ) ) {
		return 11;
	}

	$uploaded_file = $_FILES['tcd-tools-import-file'];

	if ( ! isset( $uploaded_file['tmp_name'], $uploaded_file['name'] ) ) {
		return 12;
	} elseif ( isset( $uploaded_file['error'] ) && 0 < $uploaded_file['error'] ) {
		return $uploaded_file['error'];
	}

	$wp_filetype = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'], array( 'json' => 'application/json' ) );
	if ( ! wp_match_mime_types( 'json', $wp_filetype['type'] ) ) {
		return 13;
	}

	$file_contents = file_get_contents( $uploaded_file['tmp_name'] );

	if ( ! $file_contents ) {
		return 14;
	}

	$json = json_decode( $file_contents, true );

	if ( ! $json ) {
		return 15;
	}

	return $json;
}

/**
 * オプションToolsメッセージ
 */
function theme_options_tools_notices() {
	// TCDテーマオプションページ以外なら終了
	if ( empty( $_GET['page'] ) || 'theme_options' !== $_GET['page'] ) return false;

	// メッセージクエリー文字列が無ければ終了
	if ( empty( $_GET['tcd-tools-result'] ) ) return false;

	// メッセージクエリー文字列を配列化
	$tools_result = explode( '-', $_GET['tcd-tools-result'] );

	// インポートエラーメッセージ
	if ( isset( $tools_result[0], $tools_result[1] ) && 'import' === $tools_result[0] && 'error' === $tools_result[1] ) {
		$message = '';

		if ( isset( $tools_result[2] ) ) {
			$int_import_error = intval( $tools_result[2] );
			switch( $int_import_error ) {
				// 1-4, 5-8はファイルアップロード時のエラーコード
				case 1:
					$message = $int_import_error . ' : ' . __( 'The uploaded file exceeds the upload_max_filesize directive in php.ini.' );
					break;
				case 2:
					$message = $int_import_error . ' : ' . __( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.' );
					break;
				case 3:
					$message = $int_import_error . ' : ' . __( 'The uploaded file was only partially uploaded.' );
					break;
				case 4:
					$message = $int_import_error . ' : ' . __( 'No file was uploaded.' );
					break;
				case 6:
					$message = $int_import_error . ' : ' . __( 'Missing a temporary folder.' );
					break;
				case 7:
					$message = $int_import_error . ' : ' . __( 'Failed to write file to disk.' );
					break;
				case 8:
					$message = $int_import_error . ' : ' . __( 'File upload stopped by extension.' );
					break;
				case 11:
					$message = $int_import_error . ' : ' . __( 'File has not been uploaded.', 'tcd-w' );
					break;
				case 12:
					$message = $int_import_error . ' : ' . __( 'There is no file', 'tcd-w' );
					break;
				case 13:
					$message = $int_import_error . ' : ' . __( 'The file extension is not .json', 'tcd-w' );
					break;
				case 14:
					$message = $int_import_error . ' : ' . __( 'Failed to read the file', 'tcd-w' );
					break;
				case 15:
					$message = $int_import_error . ' : ' . __( 'Json decoding failed', 'tcd-w' );
					break;
				default :
					$message = esc_html( $_GET['import-error'] );
					break;
			}
		}

		echo '<div class="update-message notice notice-error notice-alt"><p><strong>' . sprintf( __( 'Import error. %s', 'tcd-w' ), $message ) . '</strong></p></div>';

	// インポート成功メッセージ
	} elseif ( isset( $tools_result[0], $tools_result[1] ) && 'import' === $tools_result[0] && 'success' === $tools_result[1] ) {
		echo '<div class="updated"><p><strong>' . __( 'Settings imported', 'tcd-w' ) . '</strong></p></div>';

	// リセット成功メッセージ
	} elseif ( isset( $tools_result[0], $tools_result[1] ) && 'reset' === $tools_result[0] && 'success' === $tools_result[1] ) {
		echo '<div class="updated"><p><strong>' . __( 'Settings reset', 'tcd-w' ) . '</strong></p></div>';
	}
}

/**
 * オプションToolsメッセージのクエリー文字列自動削除
 */
function theme_options_tools_removable_query_args( $removable_query_args ) {
	$removable_query_args[] = 'tcd-tools-result';
	return $removable_query_args;
}
add_filter( 'removable_query_args', 'theme_options_tools_removable_query_args' );

/**
 * オプションTools デフォルト画像設定取得
 */
function theme_options_tools_get_default_images_settings() {
	// デフォルト画像設定
	$default_images_settings = array(
/*
		array(
			// 保存するファイル名 既存メディアの検索に使用するのでユニークなファイル名が望ましい
			// 未指定の場合はコピー元ファイル名が使用されます
			'media_filename' => 'op_1450x150.jpg',

			// コピー元のファイルパス
			'source_filepath' => get_template_directory() . '/admin/img/default/op_1450x150.jpg',

			// 適用するテーマオプションキー
			// リピーター等の配列の場合は"['repeater'][0]['image']"のように指定
			'theme_option_keys' => array( 'slider_image1', 'index_content01_image' )
*/
	);

	$default_images_settings = apply_filters( 'tcd_theme_options_tools-get_default_images_settings', $default_images_settings );

	if ( ! $default_images_settings )
		return false;

	return $default_images_settings;
}

/**
 * オプションTools デフォルト画像をメディアに登録した分のテーマオプション配列を返す
 */
function theme_options_tools_get_default_images_options( $a = array() ) {
	// デフォルト画像設定取得
	$default_images_settings = theme_options_tools_get_default_images_settings();

	if ( ! $default_images_settings )
		return $a;

	// 引数チェック
	if ( ! $a || ! is_array( $a ) )
		$a = array();

	// デフォルト画像設定をループ
	foreach ( $default_images_settings as $key => &$value ) {
		// 既存メディアを検索しメディアID取得
		// なければ挿入しメディアID取得
		$attachment_id = theme_options_tools_get_media_id( $value, true );
		if ( $attachment_id ) 
			$value['attachment_id'] = $attachment_id;

		// テーマオプションに代入
		if ( $attachment_id && ! empty( $value['theme_option_keys'] ) ) {
			foreach ( (array) $value['theme_option_keys'] as $theme_option_key ) {
				// []で囲まれている場合はevalで無理矢理代入
				if ( '[' === substr( $theme_option_key, 0, 1 ) && ']' === substr( $theme_option_key, -1 ) ) {
					eval( '$a' . $theme_option_key . ' = ' . $value['attachment_id'] . ';' );
				} elseif ( empty( $a[$theme_option_key] ) ) {
					$a[$theme_option_key] = $attachment_id;
				}
			}
		}
	}

	return apply_filters( 'tcd_theme_options_tools-get_default_images_array', $a );
}

/**
 * オプションTools メディアからファイル名で検索しメディアidを返す
 */
function theme_options_tools_get_media_id( $a = array(), $not_found_insert = false ) {
	// 文字列の場合はコピー元ファイル扱い
	if ( is_string( $a ) )
		$a = array( 'source_filepath' => $a );

	// 必要ファイルインクルード
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// アップロード用ディレクトリのパスを取得
	$wp_upload_dir = wp_upload_dir();

	// 既存メディア検索用SQL
	global $wpdb;
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid LIKE %s";

	// WPファイルシステム
	global $wp_filesystem;
	$can_wp_filesystem = WP_Filesystem();

	// コピー元ファイルが未設定もしくは存在しない場合は終了
	if ( empty( $a['source_filepath'] ) || ! file_exists( $a['source_filepath'] ) )
		return false;

	// 検索用ファイル名が未設定の場合はコピー元からファイル名取得
	if ( empty( $a['media_filename'] ) )
		$a['media_filename'] = basename( $a['source_filepath'] );

	// 既存メディアをファイル名で後方一致検索
	$attachment_id = $wpdb->get_var( $wpdb->prepare( $sql, '%/'.$wpdb->esc_like( $a['media_filename'] ) ) ) ;

	// 既存メディアあり
	if ( $attachment_id ) {
		return (int) $attachment_id;

	// 既存メディアなしでインサートフラグあり
	} elseif ( $not_found_insert ) {
		// メディアパス・URL
		$file_path = $wp_upload_dir['path'] . '/' . $a['media_filename'];
		$file_url = $wp_upload_dir['url'] . '/' . $a['media_filename'];

		if ( $can_wp_filesystem ) {
			// アップロード用ディレクトリに上書きコピー
			$wp_filesystem->copy( $a['source_filepath'], $file_path, true, FS_CHMOD_FILE);

			// コピー失敗等でファイルが無い場合は終了
			if ( ! $wp_filesystem->exists( $file_path ) )
				return false;

		} else {
			// アップロード用ディレクトリに上書きコピー
			@copy( $a['source_filepath'], $file_path );

			// コピー失敗等でファイルが無い場合は終了
			if ( ! file_exists( $file_path ) )
				return false;

			// パーミッション変更
			@chmod( $file_path, defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : 0644 );
		}

		// メディア追加
		// http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_insert_attachment
		$filetype = wp_check_filetype( basename( $file_path ), null );
		$attachment_id = wp_insert_attachment( array(
			'guid' => $file_url, 
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_path ) ),
			'post_content' => '',
			'post_status' => 'inherit'
		), $file_path, 0 );

		// メディア追加失敗時は終了
		if ( ! $attachment_id )
			return false;

		// 添付ファイルのメタデータを生成し、データベースを更新
		$attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
		wp_update_attachment_metadata( $attachment_id, $attach_data );

		return (int) $attachment_id;
	}

	return false;
}

/**
 * オプションTools 現在のテーマオプション設定にデフォルト画像をセットして返す
 */
function theme_options_tools_set_default_images( $dp_options = array(), $is_reset = false ) {
	$dp_options = (array) $dp_options;

	// 引数$is_resetが空でテーマオプションが保存されている場合は終了
	if ( ! $is_reset && get_option( 'dp_options', false ) !== false ) 
		return $dp_options;

	// デフォルト画像をセットした配列取得
	$default_images_options = theme_options_tools_get_default_images_options();
	if ( ! $default_images_options )
		return $dp_options;

	// 現設定にデフォルト画像をマージ
	$dp_options = array_replace_recursive( $dp_options, $default_images_options );

	return apply_filters( 'tcd_theme_options_tools-set_default_images', $dp_options, $default_images_options );
}

/**
 * オプションTools テーマ初期化 デフォルト・サンプル処理
 */
function theme_options_tools_initialize( $dp_options = array(), $is_reset = false, $update_option = true ) {
	// 念のため管理画面限定
	if ( ! is_admin() )
		return;

	// 引数$dp_optionsが空の場合は現設定取得
	if ( ! $dp_options || ! is_array( $dp_options ) ) {
		global $dp_default_options;
		if ( function_exists( 'get_design_plus_options' ) ) {
			$dp_options = get_design_plus_options();
		} elseif ( function_exists( 'get_design_plus_option' ) ) {
			$dp_options = get_design_plus_option();
		} elseif ( function_exists( 'get_desing_plus_options' ) ) {
			$dp_options = get_desing_plus_options();
		} elseif ( function_exists( 'get_desing_plus_option' ) ) {
			$dp_options = get_desing_plus_option();
		} elseif ( $dp_default_options && is_array( $dp_default_options ) ) {
			$dp_options = $dp_default_options;
		} else {
			$dp_options = array();
		}
	}

	// テーマオプションフィルター
	$dp_options_filterd = apply_filters( 'tcd_theme_options_tools-initialize', $dp_options, $is_reset, $update_option );

	// テーマオプション保存
	if ( $dp_options_filterd && is_array( $dp_options_filterd ) && $update_option ) {
		// テーマ変更時はフィルターで値が変更になった場合のみ保存する
		if ( $is_reset || $dp_options_filterd !== $dp_options ) {
			update_option( 'dp_options', $dp_options_filterd );
		}
	}

	if ( ! $update_option ) {
		return $dp_options;
	}
}

/**
 * テーマ変更後の最初の読み込みで実行されるアクションでテーマ初期化
 */
add_action( 'after_switch_theme', 'theme_options_tools_initialize' );

/**
 * テーマ初期化にテーマデフォルト画像フィルター追加
 */
add_filter( 'tcd_theme_options_tools-initialize', 'theme_options_tools_set_default_images', 10, 2 );

/**
 * オプションTools 新規サイトチェック
 */
function theme_options_tools_is_new_site() {
	static $is_new_site;

	if ( is_bool( $is_new_site ) )
		return $is_new_site;

	// 全投稿取得
	$posts = get_posts( array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 2
	) );

	// 全カテゴリー取得
	$categories = get_categories( array(
		'hide_empty' => false
	) );

	// 投稿数が1以下、カテゴリー数が1以下、テーマオプションが保存されていない場合は新規サイト扱い
	if ( count( $posts ) <= 1 && count( $categories ) <= 1 && get_option( 'dp_options', false ) === false ) {
		$is_new_site = true;
	} else {
		$is_new_site = false;
	}

	return $is_new_site;
}


/************************************************/
/* ここからICONIC用設定 */
/************************************************/

/**
 * ICONIC オプションTools デフォルト画像設定フィルター
 */
function iconic_theme_options_tools_get_default_images_settings( $default_images_settings ) {
	// デフォルト画像設定
	return array(
/*
		array(
			// 保存するファイル名 既存メディアの検索に使用するのでユニークなファイル名が望ましい
			// 未指定の場合はコピー元ファイル名が使用されます
			'media_filename' => 'op_1450x150.jpg',

			// コピー元のファイルパス
			'source_filepath' => get_template_directory() . '/admin/img/default/op_1450x150.jpg',

			// 適用するテーマオプションキー
			// リピーター等の配列の場合は"['repeater'][0]['image']"のように指定
			'theme_option_keys' => array( 'slider_image1', 'index_content01_image' )
*/
		array(
			'media_filename' => 'iconic-op_top-slider.gif',
			'source_filepath' => get_template_directory() . '/admin/img/default/op_top-slider.gif',
			'theme_option_keys' => array( 'slider_image1', 'slider_image2', 'slider_image3', 'image_404' )
		),
		array(
			'media_filename' => 'iconic-op_top-slider_sp.gif',
			'source_filepath' => get_template_directory() . '/admin/img/default/op_top-slider_sp.gif',
			'theme_option_keys' => array( 'slider_image_sp1', 'slider_image_sp2', 'slider_image_sp3' )
		),		array(
			'media_filename' => 'iconic-image_380x240.gif',
			'source_filepath' => get_template_directory() . '/admin/img/default/image_380x240.gif',
			'theme_option_keys' => array( "['contents_builder'][0]['cb_image1']", "['contents_builder'][0]['cb_image2']", "['contents_builder'][0]['cb_image3']" )
		),
		array(
			'media_filename' => 'iconic-image_1200x350.gif',
			'source_filepath' => get_template_directory() . '/admin/img/default/image_1200x350.gif',
			'theme_option_keys' => array( "['contents_builder'][3]['cb_image']" )
		)
	);
}

/**
 * ICONIC オプションTools サンプルカテゴリー
 */
function iconic_theme_options_tools_set_sample_categories( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-categories'] ) )
		return $dp_options;

	// メガメニュー画像 メディアID
	$media_id_image_megamenu = theme_options_tools_get_media_id( array(
		'media_filename' => 'iconic-image_210x130.gif',
		'source_filepath' => get_template_directory() . '/admin/img/default/image_210x130.gif'
	), true );

	// サンプルカテゴリー設定配列
	$sample_categories = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$sample_categories[] = array(
			'name' => 'Category' . $i,
			'slug' => 'category' . $i,
			// オプション保存のカスタムフィールド meta_key => meta_value
			'metas' => array(
				'image_megamenu' => $media_id_image_megamenu
			)
		);
	}

	// サンプルカテゴリー設定ループ
	foreach ( $sample_categories as $sample_category ) {
		if ( empty( $sample_category['name'] ) )
			continue;

		if ( empty( $sample_category['taxonomy'] ) )
			$sample_category['taxonomy'] = 'category';

		if ( empty( $sample_category['slug'] ) )
			$sample_category['slug'] = sanitize_title( $sample_category['name'] );

		// 同スラッグカテゴリーがある場合は追加しない
		$term = get_term_by( 'slug', $sample_category['slug'], $sample_category['taxonomy'] );
		if ( ! empty( $term->term_id ) )
			continue;

		// タイムアウト対策
		set_time_limit( 15 );

		// カテゴリー追加
		$result = wp_insert_term(
			$sample_category['name'],
			$sample_category['taxonomy'],
			array(
				'description'=> isset( $sample_category['description'] ) ? $sample_category['description'] : '',
				'slug' => $sample_category['slug'],
				'parent'=> isset( $sample_category['parent'] ) ? absint( $sample_category['parent'] ) : 0
			)
		);

		// カテゴリー追加成功時、カテゴリーメタ保存
		if ( ! is_wp_error( $result ) && ! empty( $result['term_id'] ) && ! empty( $sample_category['metas'] ) ) {
			$term_meta = array();

			foreach ( $sample_category['metas'] as $meta_key => $meta_value ) {
				if ( ! is_int( $meta_key ) && $meta_value )
					$term_meta[$meta_key] = $meta_value;
			}

			if ( $term_meta )
				update_option( 'taxonomy_' . $result['term_id'], $term_meta );
		}
	}

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * ICONIC オプションTools サンプル記事
 */
function iconic_theme_options_tools_set_sample_posts( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-posts'] ) )
		return $dp_options;

	// アイキャッチ メディアID
	$media_id = (int) theme_options_tools_get_media_id( array(
		'media_filename' => 'iconic-image_850x515.gif',
		'source_filepath' => get_template_directory() . '/admin/img/default/image_850x515.gif'
	), true );

	// 高速化
	wp_suspend_cache_invalidation( true );
	wp_defer_term_counting( true );
	wp_defer_comment_counting( true );

	// 投稿日時ベース
	$post_date_base = date( 'Y-m-d H:i:', current_time( 'timestamp' ) );

	// サンプル記事設定配列
	$sample_posts = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$sample_posts[] = array(
			'post_title' => __( 'Sample post', 'tcd-w' ) . $i,
			'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-post' . $i,
			'post_status' => 'publish',
			'post_type' => 'post',
			'post_date' => $post_date_base . sprintf( '%02d', $i ),
			// アイキャッチ メディアIDもしくはtheme_options_tools_get_media_id()用の配列もしくはコピー元ファイルパス
			'thumbnail' => $media_id,
			// タクソノミー タクソノミースラッグ => タームスラッグ（配列指定可）
			'taxonomies' => array(
				'category' => 'category' . ( $i % 4 )
			),
			// カスタムフィールド meta_key => meta_value
			'metas' => array()
		);
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		$sample_posts[] = array(
			'post_title' => __( 'Sample news', 'tcd-w' ) . $i,
			'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-news' . $i,
			'post_status' => 'publish',
			'post_type' => 'news',
			'post_date' => $post_date_base . sprintf( '%02d', $i ),
			// アイキャッチ メディアIDもしくはtheme_options_tools_get_media_id()用の配列もしくはコピー元ファイルパス
			'thumbnail' => $media_id,
			// タクソノミー タクソノミースラッグ => タームスラッグ（配列指定可）
			'taxonomies' => array(),
			// カスタムフィールド meta_key => meta_value
			'metas' => array()
		);
	}

	// サンプル記事設定ループ
	foreach ( $sample_posts as $i => $sample_post ) {
		if ( empty( $sample_post['post_title'] ) )
			continue;

		// タイムアウト対策
		set_time_limit( 15 );

		// 同スラッグ記事がある場合は追加しない
		$find_posts = get_posts( array(
			'name' => ! empty( $sample_post['post_name'] ) ? $sample_post['post_name'] : sanitize_title( $sample_post['post_title'] ),
			'post_type' => ! empty( $sample_post['post_type'] ) ? $sample_post['post_type'] : 'post',
			'post_status' => 'any',
			'posts_per_page' => 1
		) );
		if ( $find_posts )
			continue;

		// アイキャッチ・タクソノミー・カスタムフィールド指定を抜き出し
		if ( isset( $sample_post['thumbnail'] ) ) {
			$thumbnail = $sample_post['thumbnail'];
			unset( $sample_post['thumbnail'] );
		} else {
			$thumbnail = null;
		}
		if ( isset( $sample_post['taxonomies'] ) ) {
			$taxonomies = $sample_post['taxonomies'];
			unset( $sample_post['taxonomies'] );
		} else {
			$taxonomies = null;
		}
		if ( isset( $sample_post['metas'] ) ) {
			$metas = $sample_post['metas'];
			unset( $sample_post['metas'] );
		} else {
			$metas = null;
		}

		// 記事追加
		$post_id = wp_insert_post( $sample_post );

		// 記事追加成功時
		if ( $post_id ) {
			// アイキャッチ
			if ( $thumbnail ) {
				// int以外の場合はメディアID取得を試みる
				if ( ! is_int( $thumbnail ) )
					$thumbnail = theme_options_tools_get_media_id( $thumbnail, true );

				if ( is_int( $thumbnail ) )
					set_post_thumbnail( $post_id, $thumbnail );
			}

			// タクソノミー
			if ( $taxonomies && is_array( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy => $terms ) {
					$set_terms = array();

					foreach ( (array) $terms as $term ) {
						if ( is_int( $term ) ) {
							$set_terms[] = $term;
						} else {
							$term_exists = term_exists( $term, $taxonomy );
							if ( ! empty( $term_exists['term_id'] ) )
								$set_terms[] = (int) $term_exists['term_id'];
						}
					}

					if ( $set_terms )
						wp_set_object_terms( $post_id, $set_terms, $taxonomy, false );
				}
			}

			// カスタムフィールド
			if ( $metas && is_array( $metas ) ) {
				foreach ( $metas as $meta_key => $meta_value ) {
					if ( ! is_int( $meta_key ) && $meta_value )
						update_post_meta( $post_id, $meta_key, $meta_value);
				}
			}
		}
	}

	// 高速化で外したものを戻す
	wp_suspend_cache_invalidation( false );
	wp_defer_term_counting( false );
	wp_defer_comment_counting( false );

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * ICONIC オプションTools サンプルメニュー
 */
function iconic_theme_options_tools_set_sample_menus( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-menus'] ) )
		return $dp_options;

	// グローバルメニュー設定済みの場合は終了
	$menu_locations = get_nav_menu_locations();
	$nav_menus = wp_get_nav_menus();
	if ( ! empty( $menu_locations['global'] ) && $nav_menus && ! is_wp_error( $nav_menus ) ) {
		foreach ( $nav_menus as $nav_menu ) {
			if ( $nav_menu->term_id == $menu_locations['global'] )
				return $dp_options;
		}
	}

	// サンプルメニュー設定済みの場合は終了
	if ( $nav_menus && ! is_wp_error( $nav_menus ) ) {
		foreach ( $nav_menus as $nav_menu ) {
			if ( $nav_menu->name == __( 'Sample menu', 'tcd-w' ) )
				return $dp_options;
		}
	}

	// サンプルメニュー作成
	$menu_id = wp_create_nav_menu( __( 'Sample menu', 'tcd-w' ) );
	if ( is_wp_error( $menu_id ) )
		return $dp_options;

	// 高速化
	wp_suspend_cache_invalidation( true );
	wp_defer_term_counting( true );
	wp_defer_comment_counting( true );

	// 親メニューアイテム
	$menu_items = array(
		array(
			'name' => 'HOME',
			'url' => home_url( '/' )
		),
		array(
			'name' => __( 'Dropdown menu', 'tcd-w' ),
			'url' => '#'
		),
		array(
			'name' => __( 'Mega menu A', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type2'
		),
		array(
			'name' => __( 'Mega menu B', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type3'
		),
		array(
			'name' => __( 'Mega menu C', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type4'
		)
	);

	// 子メニューアイテム用カテゴリースラッグ サンプルカテゴリー・未分類
	$category_slugs = array(
		'category1',
		'category2',
		'category3',
		'category4'
	);

	// 親メニューアイテム作成
	foreach ( $menu_items as $menu_item ) {
		if ( empty( $menu_item['name'] ) || empty( $menu_item['url'] ) )
			continue;

		// タイムアウト対策
		set_time_limit( 30 );

		$menu_item_db_id = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-type' => 'custom',
			'menu-item-title' => $menu_item['name'],
			'menu-item-url' => $menu_item['url'],
			'menu-item-status' => 'publish'
		) );

		if ( $menu_item_db_id && ! is_wp_error( $menu_item_db_id ) ) {
			// メガメニュー テーマオプション設定 
			if ( ! empty( $menu_item['megamenu'] ) )
				$dp_options['megamenu'][$menu_item_db_id] = $menu_item['megamenu'];

			// 子メニューアイテム（カテゴリー）作成
			foreach ( $category_slugs as $category_slug ) {
				$term = get_term_by( 'slug', $category_slug, 'category' );
				if ( ! empty( $term->term_id ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-type' => 'taxonomy',
						'menu-item-title' => $term->name,
						'menu-item-object' => $term->taxonomy,
						'menu-item-object-id' => $term->term_id,
						'menu-item-parent-id' => $menu_item_db_id,
						'menu-item-status' => 'publish'
					) );
				}
			}
		}
	}

	// 高速化で外したものを戻す
	wp_suspend_cache_invalidation( false );
	wp_defer_term_counting( false );
	wp_defer_comment_counting( false );

	// グローバルメニューにセット
	$menu_locations = (array) $menu_locations;
	$menu_locations['global'] = (int) $menu_id;
	set_theme_mod( 'nav_menu_locations', $menu_locations );

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * ICONIC オプションTools サンプルウィジェット
 */
function iconic_theme_options_tools_set_sample_widgets( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-widgets'] ) )
		return $dp_options;

	// next_widget_id_number用にインクルード
	require_once ABSPATH . '/wp-admin/includes/widgets.php';

	// ウィジェットエリア設定取得
	$sidebars_widgets = wp_get_sidebars_widgets();

	// サンプルウィジェット設定
	$sample_widgets = array(
		// 広告
		array(
			'class_name' => 'tcdw_ad_widget',
			'params' => array(
				'banner_code1' => '',
				'banner_image1' => (int) theme_options_tools_get_media_id( array(
					'media_filename' => 'iconic-image_300x250.gif',
					'source_filepath' => get_template_directory() . '/admin/img/default/image_300x250.gif'
				), true ),
				'banner_url1' => '#',
				'banner_code2' => '',
				'banner_image2' => '',
				'banner_url2' => '',
				'banner_code3' => '',
				'banner_image3' => '',
				'banner_url3' => '',
			)
		),
		// 最新記事
		array(
			'class_name' => 'Styled_Post_List_Tab_widget',
			'params' => array(
				'title' => '',
				'hide_one_tab' => 1,
				'tab1' => array(
					'show_tab' => 1,
					'title' => __( 'Recent post', 'tcd-w' ),
					'list_type' => 'recent_post',
					'category' => 0,
					'post_num' => 5,
					'post_order' => 'date1',
					'show_date' => 1,
					'show_category' => 1,
					'exclude_item' => 1
				),
				'tab2' => array(
					'show_tab' => 0,
					'title' => __( 'Recommend post', 'tcd-w' ),
					'list_type' => 'recommend_post',
					'category' => 0,
					'post_num' => 5,
					'post_order' => 'date1',
					'show_date' => 1,
					'show_category' => 1,
					'exclude_item' => 1
				)
			)
		),
		// カテゴリー
		array(
			'class_name' => 'Tcdw_Category_List_Widget',
			'params' => array(
				'title' => __( 'Category', 'tcd-w' ),
				'exclude_cat_num' => '',
				'exclude_welcart_cat' => 1
			)
		),
		// アーカイブ
		array(
			'class_name' => 'Tcdw_Archive_List_Widget',
			'params' => array(
				'title' => ''
			)
		)
	);

	// PC・モバイル基本ウィジェットエリア
	foreach ( array( 'common_side_widget' ) as $sidebar ) {
		// 現ウィジェットを設定を削除
		if ( ! empty( $sidebars_widgets[$sidebar] ) ) {
			foreach ( $sidebars_widgets[$sidebar] as $widget_id ) {
				$pieces = explode( '-', $widget_id );
				$multi_number = array_pop( $pieces );
				$id_base = implode( '-', $pieces );
				$widget_db = get_option( 'widget_' . $id_base );
				if ( isset( $widget_db[$multi_number] ) ) {
					unset( $widget_db[$multi_number] );
					update_option( 'widget_' . $id_base, $widget_db );
				}
			}
		}

		// ウィジェットエリアを空に
		$sidebars_widgets[$sidebar] = array();

		// ウィジェットループしてウィジェット追加
		foreach ( $sample_widgets as $sample_widget ) {
			$widget_class = null;

			if ( isset( $sample_widget['class_name'] ) && class_exists( $sample_widget['class_name'] ) ) {
				$widget_class = new $sample_widget['class_name'];
				$widget_id_base = $widget_class->id_base;
			} elseif ( ! empty( $sample_widget['id'] ) ) {
				$widget_id_base = $sample_widget['id'];
			} else {
				continue;
			}

			// タイムアウト対策
			set_time_limit( 15 );

			// WP_Widget::update_callback()等を使う方法もあるがPOST前提で扱いずらいためDBのオプション値を直接変更
			$widget_db = get_option( 'widget_' . $widget_id_base, array() );

			// ウィジェットID番号
			$widget_id_number = next_widget_id_number( $widget_id_base );
			$widget_db_keys = array_filter( array_keys( $widget_db ), 'is_int' );
			if ( $widget_db_keys )
				$widget_id_number = max( $widget_id_number, max( $widget_db_keys ) + 1 );

			// ウィジェット値
			if ( isset( $sample_widget['params'] ) ) {
				if ( $widget_class ) {
					$widget_db[$widget_id_number] = $widget_class->update( $sample_widget['params'], array() );
				} else {
					$widget_db[$widget_id_number] = $sample_widget['params'];
				}
			} else {
				$widget_db[$widget_id_number] = array();
			}

			// ウィジェットDB保存
			if ( ! isset( $widget_db['_multiwidget'] ) )
				$widget_db['_multiwidget'] = 1;

			update_option( 'widget_' . $widget_id_base, $widget_db );

			// ウィジェットエリアに追加
			$sidebars_widgets[$sidebar][] = $widget_id_base . '-' . $widget_id_number;
		}
	}

	// ウィジェットエリア保存
	wp_set_sidebars_widgets( $sidebars_widgets );

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * ICONIC テーマ初期化フィルター
 */
add_filter( 'tcd_theme_options_tools-get_default_images_settings', 'iconic_theme_options_tools_get_default_images_settings', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'iconic_theme_options_tools_set_sample_categories', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'iconic_theme_options_tools_set_sample_posts', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'iconic_theme_options_tools_set_sample_menus', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'iconic_theme_options_tools_set_sample_widgets', 10, 1 );
