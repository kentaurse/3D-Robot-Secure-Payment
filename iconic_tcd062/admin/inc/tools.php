<?php // Import, Export, Reset ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'TCD theme options tools', 'tcd-w' ); ?></h3>
    <p><?php _e( 'You can do TCD theme options "export" "import" "reset".', 'tcd-w' ); ?></p>
    <p><?php _e( 'For "import" and "reset", theme option setting may be overwritten. Be sure to read the following note before using.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Export', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can export TCD theme options settings.', 'tcd-w' ); ?></p>
	<div class="theme_option_message">
        <p><?php _e( 'By pressing the "export" button, you can download TCD theme options setting file as json file. Example of setting file name: tcd_theme_options-export-WordPress theme "ICONIC_tcd 062" - ICONIC - 20180827.json "', 'tcd-w' ); ?></p>
        <p><?php _e( 'You can prepare for unforeseen circumstances by exporting it before making a large setting change.', 'tcd-w' ); ?></p>
	</div>
	<p><input class="button-ml" type="submit" name="tcd-tools-export" value="<?php _e( 'Export', 'tcd-w' ); ?>"></p>
	<h4 class="theme_option_headline2"><?php _e( 'Import', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can import TCD theme options settings.', 'tcd-w' ); ?></p>
    <p><?php _e( 'The subject option contents are overwritten with the contents of the imported configuration file, so be careful when executing it.', 'tcd-w' ); ?></p>
	<div class="theme_option_message">
        <p><?php _e( 'Please select the JSON file (. Json) exported from the TCD theme when you want to restore the setting contents at the time of backup and press the "import" button.', 'tcd-w' ); ?></p>
        <p><?php _e( 'You can restore TCD theme option setting when exporting.', 'tcd-w' ); ?></p>
	</div>
	<p class="cf">
		<input type="file" name="tcd-tools-import-file" value="">
		<input class="button-ml" name="tcd-tools-import" type="submit" value="<?php _e( 'Import', 'tcd-w' ); ?>">
	</p>
	<h4 class="theme_option_headline2"><?php _e( 'Reset', 'tcd-w' ); ?></h4>
    <p><?php _e( 'You can initialize the TCD theme option.', 'tcd-w' ); ?></p>
    <p><?php _e( 'Please note that all currently set contents will be deleted. Be sure to check the following PDF manual before executing.', 'tcd-w' ); ?></p>
	<div class="theme_option_message">
        <p><?php _e( 'About checkboxes for additional sample elements.', 'tcd-w' ); ?></p>
        <p><?php _e( 'By adding a check at reset time, we add samples of main contents (articles, images, categories, menus) that make up the site. By doing this, you can replace images and insert texts while checking the actual layout.', 'tcd-w' ); ?></p>
	</div>
    <p><?php _e( 'Please check the items you want to add samples for.', 'tcd-w' ); ?></p>
	<ul>
		<li><label style="vertical-align: baseline;"><input name="tcd-tools-reset-sample-posts" type="checkbox" value="1"><?php _e( 'Add sample posts', 'tcd-w' ); ?></label> <small class="description"><?php _e( 'Note: sample posts will not be added if they already exist.', 'tcd-w' ); ?></small></li>
		<li><label style="vertical-align: baseline;"><input name="tcd-tools-reset-sample-categories" type="checkbox" value="1"><?php _e( 'Add sample Categories', 'tcd-w' ); ?></label> <small class="description"><?php _e( 'Note: sample categories will not be added if they already exist.', 'tcd-w' ); ?></small></li>
		<li><label style="vertical-align: baseline;"><input name="tcd-tools-reset-sample-menus" type="checkbox" value="1"><?php _e( 'Add an sample global menu and megamenu setting', 'tcd-w' ); ?></label> <small class="description"><?php _e( 'Note: an sample global menu will not be added if the global menu or \"Sample menu\" already exist, only the mega menu setting will be reset.', 'tcd-w' ); ?></small></li>
		<li><label style="vertical-align: baseline;"><input name="tcd-tools-reset-sample-widgets" type="checkbox" value="1"><?php _e( 'Initialize the common widget area', 'tcd-w' ); ?></label> <small class="description"><?php _e( 'Note: current widgets in the common widget area will be initialized.', 'tcd-w' ); ?></small></li>
	</ul>
    <p><input class="button-ml" name="tcd-tools-reset" type="submit" value="<?php _e( 'Reset', 'tcd-w' ); ?>"></p>
</div>
<script>
jQuery(function($){
	// インポート
	$(':submit[name="tcd-tools-import"]').click(function(){
		if (!$(':file[name="tcd-tools-import-file"]').val()) return false;
	});
	// リセット
	$(':submit[name="tcd-tools-reset"]').click(function(){
		return confirm('<?php echo esc_attr( __( 'Are you sure you want to reset?', 'tcd-w' ) ); ?>');
	});
	// _wp_http_refererにインポートメッセージ用クエリー文字列が残る対策
	var $_wp_http_referer = $(':submit[name="tcd-tools-import"]').closest('form').find('input[name="_wp_http_referer"]');
	$_wp_http_referer.val($_wp_http_referer.val().replace(/&(amp;)?tcd-tools-result=.*&?/, ''));
});
</script>
