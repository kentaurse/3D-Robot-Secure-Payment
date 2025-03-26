jQuery(function($){
	if(!$('body').hasClass('widgets-php')) return

	// 広告用
	var current_item;
	var target_id;

	$(document).on('click', '.tcd_toggle_widget_headline', function(){
		$(this).toggleClass('active');
		$(this).next('.tcd_toggle_widget_box').toggleClass('open');
	});

	$(document).on('click', 'input.select-img', function(evt){
		window.tcdw_ad_original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html) {
			if(current_item && target_id) {
				var imgurl = $(html).attr('src') || $('img',html).attr('src');
				current_item.siblings('.img').val(imgurl);
				$('#preview_'+target_id).html('<img src="'+imgurl+'" />');
				current_item = null;
				target_id = null;
			}
			window.send_to_editor = window.tcdw_ad_original_send_to_editor;
			tb_remove();
		}

		current_item = $(this);
		target_id = current_item.prev('input').attr('id');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	$(document).on('click', '.delete-img', function(e) {
		$(this).prev('input').val(0);
		$(this).prev().prev('.preview_field').hide();
		$(this).closest('form').find('[name=savewidget]').trigger('click');
	});

	// カラーピッカー 読み込み時
	$('#widgets-right .c-color-picker-widget').wpColorPicker();

	// カラーピッカー ウィジェット追加時
	$(document).on('widget-added', function(e, widget){
		$(widget).find('.c-color-picker-widget').wpColorPicker();
	});

	// カラーピッカー ウィジェット保存時
	$(document).on('widget-updated', function(e, widget){
		$(widget).find('.c-color-picker-widget').wpColorPicker();
	});

	// site infoのSNSチェックボックス
	$(document).on('change', '.use_sns_theme_options:checkbox', function(){
		if (this.checked) {
			$(this).closest('.widget-content').find('.widget-sns-fields').hide();
		} else {
			$(this).closest('.widget-content').find('.widget-sns-fields').show();
		}
	});

	// デザインされた記事一覧
	$('#widgets-right').on('change', '.tcd_toggle_widget_box .js-styled_post_list_tab-list_type', function(){
		var $widget_box = $(this).closest('.tcd_toggle_widget_box');
		var list_type = $(this).val();
		$widget_box.find('[class*=styled_post_list_tab-list_type-]').hide();
		$widget_box.find('.styled_post_list_tab-list_type-' + list_type).show();
	});
});
