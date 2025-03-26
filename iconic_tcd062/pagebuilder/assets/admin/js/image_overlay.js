jQuery(document).ready(function($){

	// overlay
	$(document).on('change', '.pb-widget-image-overlay .form-field-show_overlay :checkbox', function(){
		if (this.checked) {
			$(this).closest('.pb-content').find('.form-field-overlay').show();
		} else {
			$(this).closest('.pb-content').find('.form-field-overlay').hide();
		}
	});
	$('.pb-widget-image-overlay .form-field-show_overlay :checkbox').trigger('change');

});
