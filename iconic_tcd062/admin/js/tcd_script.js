jQuery(function($){

	// ローカライズメッセージ未設定時
	if (!window.TCD_MESSAGES) {
		TCD_MESSAGES = {
			ajaxSubmitSuccess: 'Settings Saved Successfully',
			ajaxSubmitError: 'Can not save data. Please try again.'
		};
	}

	// テーマオプション AJAX保存
	$('#tcd_theme_option').on('click', '.ajax_button', function() {
		var $button = $('.button-ml');
		$('#saveMessage').hide();
		$('#saving_data').show();
		if (window.tinyMCE) {
			tinyMCE.triggerSave(); // tinymceを利用しているフィールドのデータを保存
		}
		$('#tcd_theme_option form').ajaxSubmit({
			beforeSend: function() {
				$button.attr('disabled', true); // ボタンを無効化し、二重送信を防止
			},
			complete: function() {
				$button.attr('disabled', false);; // ボタンを有効化し、再送信を許可
			},
			success: function(){
				$('#saving_data').hide();
				$('#saved_data').html('<div id="saveMessage" class="successModal"></div>');
				$('#saveMessage').append('<p>' + TCD_MESSAGES.ajaxSubmitSuccess + '</p>').show();
				setTimeout(function() {
					$('#saveMessage:not(:hidden, :animated)').fadeOut();
				}, 3000);
			},
			error: function() {
				$('#saving_data').hide();
				alert(TCD_MESSAGES.ajaxSubmitError);
			},
			timeout: 10000
		});
		return false;
	});
	$('#tcd_theme_option').on('click', '#saveMessage', function(){
		$('#saveMessage:not(:hidden, :animated)').fadeOut(300);
	});

	// アコーディオンの開閉
	$('.theme_option_field').on('click', '.theme_option_subbox_headline', function(){
		$(this).closest('.sub_box').toggleClass('active');
		return false;
	});

	// theme option tab
	$('#tcd_theme_option').cookieTab({
		tabMenuElm: '#theme_tab',
		tabPanelElm: '#tab-panel'
	});

	// WordPress Color Picker
	$('.c-color-picker').wpColorPicker();

	// ロゴに画像を使うかテキストを使うか選択
	$('#header_logo_type_select :radio, #header_logo_type_select_mobile :radio').change(function(){
		var mobile = '';
		if ($(this).closest('#header_logo_type_select_mobile').length) {
			mobile = '_mobile';
		}
		if (this.checked) {
			if (this.value == 'yes') {
				$('.header_logo_text_area'+mobile).hide();
				$('.header_logo_image_area'+mobile).show();
			} else {
				$('.header_logo_text_area'+mobile).show();
				$('.header_logo_image_area'+mobile).hide();
			}
		}
	});

	// load color 2
	$('#js-load_icon').change(function() {
		if ('type2' === this.value) {
			$('.js-load_color2').show();
		} else {
			$('.js-load_color2').hide();
		}
	}).trigger('change');

	// Googleマップ
	$('#gmap_marker_type_button_type2').click(function () {
		$('#gmap_marker_type2_area').show();
	});
	$('#gmap_marker_type_button_type1').click(function () {
		$('#gmap_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type1').click(function () {
		$('#gmap_custom_marker_type1_area').show();
		$('#gmap_custom_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type2').click(function () {
		$('#gmap_custom_marker_type1_area').hide();
		$('#gmap_custom_marker_type2_area').show();
	});

	// 画像スライダー 見出し表示
	$('.display_slider_headline input:checkbox').change(function(event) {
		if (this.checked) {
			$(this).closest('.display_slider_headline').next().show();
		} else {
			$(this).closest('.display_slider_headline').next().hide();
		}
	}).trigger('change');

	// 画像スライダー ボタン表示
	$('.display_slider_button input:checkbox').change(function(event) {
		if (this.checked) {
			$(this).closest('.display_slider_button').next().show();
		} else {
			$(this).closest('.display_slider_button').next().hide();
		}
	}).trigger('change');

	// 画像スライダー キャッチフレーズ表示
	$('.display_slider_catch input:checkbox').change(function(event) {
		if (this.checked) {
			$(this).closest('.display_slider_catch').next().show();
		} else {
			$(this).closest('.display_slider_catch').next().hide();
		}
	}).trigger('change');

	// 画像スライダー オーバーレイ表示
	$('.display_slider_overlay input:checkbox').change(function(event) {
		if (this.checked) {
			$(this).closest('.display_slider_overlay').next().show();
		} else {
			$(this).closest('.display_slider_overlay').next().hide();
		}
	}).trigger('change');

	// メガメニューBの場合のみネイティブ広告表示設定
	$('.js-megamenu').change(function() {
		if ('type3' === $(this).val()) {
			$(this).siblings('label').show();
		} else {
			$(this).siblings('label').hide();
		}
	}).trigger('change');

	// テーマオプション タブ越えリンク
	$('.js-tabchange-link').click(function() {
		var $target = $($(this).attr('href'));
		if (!$target.length) return;
		var tabId = $target.parent().attr('id');
		if (!tabId) return;
		var $tabElem = $('#theme_tab a[href="' + tabId + '"]');
		if (!$tabElem.length) return;
		if (!$tabElem.parent().hasClass('current')) {
			$tabElem.trigger('click');
		}
		$(window).scrollTop($target.offset().top - 50);
		return false;
	});

	// custom field simple repeater add row
	$('.cf_simple_repeater_container a.button-add-row').click(function(){
		var clone = $(this).attr('data-clone');
		var $parent = $(this).closest('.cf_simple_repeater_container');
		if (clone && $parent.length) {
			$parent.find('table.cf_simple_repeater tbody').append(clone);
		}
		return false;
	});

	// custom field simple repeater delete row
	$('table.cf_simple_repeater').on('click', '.button-delete-row', function(){
		var del = true;
		var confirm_message = $(this).closest('table.cf_simple_repeater').attr('data-delete-confirm');
		if (confirm_message) {
			del = confirm(confirm_message);
		}
		if (del) {
			$(this).closest('tr').remove();
		}
		return false;
	});

	// custom field simple repeater sortable
	$('table.cf_simple_repeater-sortable tbody').sortable({
		helper: 'clone',
		forceHelperSize: true,
		forcePlaceholderSize: true,
		distance: 10,
		start: function(event, ui) {
			$(ui.placeholder).height($(ui.helper).height());
		}
	});

});
