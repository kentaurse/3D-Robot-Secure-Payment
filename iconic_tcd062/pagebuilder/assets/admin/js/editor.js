jQuery(document).ready(function($) {

	var $pb_metabox = $('#page_builder-metabox');
	if (!$pb_metabox.size()) return false;

	// ウィジェット追加モーダルのエディターありウィジェットクリック
	$('#pb-add-widget-modal .pb-select-widget a.pb-widget-editor, #pb-add-widget-modal .pb-select-widget a.pb-widget-has-editor').on('click', function(e){
		var $meta_wrap = $(this).closest('.postbox');
		var widget_index = $meta_wrap.find('.pb-rows-container').attr('data-widgets');
		var $widget = $meta_wrap.find('#widget-' + widget_index);
		var widget_id = $widget.attr('data-widget-id');

		// クローン元のリッチエディターをループ
		$meta_wrap.find('.pb-clone .'+widget_id+' .wp-editor-area').each(function(){
			var regexp = new RegExp('widgetindex_' + widget_id.replace(/-/g, '_'), 'g');

			// id
			var id_old = $(this).attr('id');
			var id_new = id_old.replace(regexp, widget_index);

			// クローン元のmceInitをコピー置換
			if (typeof tinyMCEPreInit.mceInit[id_old] != 'undefined') {
				// オブジェクトを=で代入すると参照渡しになるため$.extendを利用
				var mce_init_new = $.extend(true, {}, tinyMCEPreInit.mceInit[id_old]);
				mce_init_new.body_class = mce_init_new.body_class.replace(regexp, widget_index);
				mce_init_new.selector = mce_init_new.selector.replace(regexp, widget_index);
				tinyMCEPreInit.mceInit[id_new] = mce_init_new;

				// リッチエディター化
				tinymce.init(mce_init_new);
			}

			// クローン元のqtInitをコピー置換
			if (typeof tinyMCEPreInit.qtInit[id_old] != 'undefined') {
				// オブジェクトを=で代入すると参照渡しになるため$.extendを利用
				var qt_init_new = $.extend(true, {}, tinyMCEPreInit.qtInit[id_old]);
				qt_init_new.id = qt_init_new.id.replace(regexp, widget_index);
				tinyMCEPreInit.qtInit[id_new] = qt_init_new;

				// テキスト入力のタグボタン有効化
				quicktags(tinyMCEPreInit.qtInit[id_new]);
				try {
					if (QTags.instances['0'].theButtons) {
						QTags.instances[id_new].theButtons = QTags.instances['0'].theButtons;
					}
				} catch(err) {
				}
			}

			// ビジュアル/テキストを複製元に合わせる
			var $wp_editor_wrap = $widget.find('#wp-'+id_new+'-wrap').hide();
			setTimeout(function(){
				$wp_editor_wrap.show();
				if ($wp_editor_wrap.hasClass('tmce-active')) {
					switchEditors.go(id_new, 'toggle');
					switchEditors.go(id_new, 'tmce');
				} else {
					switchEditors.go(id_new, 'toggle');
					switchEditors.go(id_new, 'html');
				}
			}, 500);
		});
	});

	// ウィジェット複製イベント（ウィジェット複製・行複製で共通処理）
	$pb_metabox.on('page-builder-widget-cloned', function(event, $cloned_widget, $source_widget){
		// エディターウィジェット以外は終了
		if (!$cloned_widget.hasClass('pb-widget-editor') && !$cloned_widget.hasClass('pb-widget-has-editor')) return;

		// リピーターウィジェットはrepeater.jsで処理するため終了
		if ($cloned_widget.hasClass('pb-repeater-widget')) return;

		var source_widget_index = $source_widget.attr('data-widget-index');
		var cloned_widget_index = $cloned_widget.attr('data-widget-index');
		var widget_id = $cloned_widget.attr('data-widget-id');
		var regexp = new RegExp('widgetindex_' + widget_id.replace(/-/g, '_'), 'g');

		// クローン元のリッチエディターをループ（複製元ではなくページビルダーのクローン元）
		// 複製先のエディターをクローンしなおす
		$pb_metabox.find('.pb-clone .' + widget_id + ' .wp-editor-area').each(function(i){
			// id
			var id_old = $(this).attr('id');
			var id_new = id_old.replace(regexp, cloned_widget_index);

			// 複製先の現エディター
			var $current_editor_wrap = $cloned_widget.find('.wp-editor-wrap').eq(i);
			if (!$current_editor_wrap.length) return;

			// 現エディターの入力値
			var current_editor_val = $current_editor_wrap.find('.wp-editor-area').val();

			// クローンするエディターHTML
			var clone_editor_html = $(this).closest('.wp-editor-wrap').prop('outerHTML');

			// ウィジェットID置換してクローンエディターHTMLを挿入
			$current_editor_wrap.after(clone_editor_html.replace(regexp, cloned_widget_index));

			// 現エディター削除
			$current_editor_wrap.remove();

			// 挿入したクローンエディター
			var $new_editor_wrap = $cloned_widget.find('.wp-editor-wrap').eq(i);

			// テキストエリアに値代入
			$new_editor_wrap.find('.wp-editor-area').val(current_editor_val);

			// クローン元のmceInitをコピー置換
			if (typeof tinyMCEPreInit.mceInit[id_old] != 'undefined') {
				// オブジェクトを=で代入すると参照渡しになるため$.extendを利用
				var mce_init_new = $.extend(true, {}, tinyMCEPreInit.mceInit[id_old]);
				mce_init_new.body_class = mce_init_new.body_class.replace(regexp, cloned_widget_index);
				mce_init_new.selector = mce_init_new.selector.replace(regexp, cloned_widget_index);
				tinyMCEPreInit.mceInit[id_new] = mce_init_new;

				// リッチエディター化
				tinymce.init(mce_init_new);
			}

			// クローン元のqtInitをコピー置換
			if (typeof tinyMCEPreInit.qtInit[id_old] != 'undefined') {
				// オブジェクトを=で代入すると参照渡しになるため$.extendを利用
				var qt_init_new = $.extend(true, {}, tinyMCEPreInit.qtInit[id_old]);
				qt_init_new.id = qt_init_new.id.replace(regexp, cloned_widget_index);
				tinyMCEPreInit.qtInit[id_new] = qt_init_new;

				// テキスト入力のタグボタン有効化
				quicktags(tinyMCEPreInit.qtInit[id_new]);
				try {
					if (QTags.instances['0'].theButtons) {
						QTags.instances[id_new].theButtons = QTags.instances['0'].theButtons;
					}
				} catch(err) {
				}
			}

			// ビジュアル/テキストを複製元に合わせる
			setTimeout(function(){
				if ($source_widget.find('.wp-editor-wrap').eq(i).hasClass('tmce-active')) {
					switchEditors.go(id_new, 'toggle');
					switchEditors.go(id_new, 'tmce');
				} else {
					switchEditors.go(id_new, 'toggle');
					switchEditors.go(id_new, 'html');
				}
			}, 500);
		});
	});

	// ソータブルドラッグ後のリッチエディター不具合対策
	$(document).on('page-builder-widget-sortable-stop', function(e, item) {
		if (!$(item).hasClass('pb-widget-editor') && !$(item).hasClass('pb-widget-has-editor')) return;

		$(item).find('.wp-editor-area').each(function(){
			var id = $(this).attr('id');
			var $editor_wrap = $(this).closest('.wp-editor-wrap');

			if (!id) return;

			if (window.tinymce) {
				tinymce.execCommand('mceRemoveEditor', false, id);
				tinymce.execCommand('mceAddEditor', true, id);
			}

			setTimeout(function(){
				if ($editor_wrap.hasClass('tmce-active')) {
					switchEditors.go(id, 'toggle');
					switchEditors.go(id, 'tmce');
				} else {
					switchEditors.go(id, 'toggle');
					switchEditors.go(id, 'html');
				}
			}, 500);
		});
	});

});
