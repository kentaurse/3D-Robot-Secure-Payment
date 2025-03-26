jQuery(document).ready(function($){

	var $pb_metabox = $('#page_builder-metabox');
	if (!$pb_metabox.size()) return false;

	// footer type 選択
	$pb_metabox.on('change', '.pb-widget-slider .form-field-footer_type :radio', function(){
		if (this.checked) {
			var $cl = $(this).closest('.pb-content');
			$cl.find('[class*="form-field-footer_type-type"]').hide();
			$cl.find('.form-field-footer_type-' + this.value).show();
		}
	});
	$('.pb-widget-slider .form-field-footer_type :radio:checked').trigger('change');

	// ウィジェット複製イベント（ウィジェット複製・行複製で共通処理）
	$pb_metabox.on('page-builder-widget-cloned', function(event, $cloned_widget, $source_widget){
		// スライダーウィジェット以外は終了
		if (!$cloned_widget.hasClass('pb-widget-slider')) return;

		// footer typeをトリガーして追加用アイテムに反映させる
		$cloned_widget.find('.form-field-footer_type :radio:checked').trigger('change');
	});

});
