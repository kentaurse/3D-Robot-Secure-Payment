<?php
global $dp_options, $dp_default_options, $header_fix_options, $megamenu_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーバーの表示位置 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header position', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please set the display position of the header bar.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<ul><li>Normal display position - When scrolling through the page, the header bar disappears.</li><li>Fixed display at the top - Following the page scroll, the header bar is fixedly displayed at the top of the page.</li></ul>', 'tcd-w' ); ?></div>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_fix_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_fix]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['header_fix'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーバーの表示位置（スマホ）?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header position for mobile device', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please set the display position of the header bar for mobile.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<ul><li>Normal display position - When scrolling through the page, the header bar disappears.</li><li>Fixed display at the top - Following the page scroll, the header bar is fixedly displayed at the top of the page.</li></ul>', 'tcd-w' ); ?></div>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_fix_options as $option ) : ?>
		<label><input type="radio" name="dp_options[mobile_header_fix]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['mobile_header_fix'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーバーの色の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Color of header', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Background color setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set the background color of header bar.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_bg]" type="text" value="<?php echo esc_attr( $dp_options['header_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_bg'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Opacity of background', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[header_opacity]" value="<?php echo esc_attr( $dp_options['header_opacity'] ); ?>" min="0" max="1" step="0.1">
	<h4 class="theme_option_headline2"><?php _e( 'Text color setting', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set the font color of header bar.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_font_color]" type="text" value="<?php echo esc_attr( $dp_options['header_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_font_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダー検索 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header/Footer search', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please check this to display the header search form.', 'tcd-w' ); ?></p>
    <div class="theme_option_message"><?php echo __( '<ul><li>PC - Display the search icon on the right side of the global menu. Click the icon to display the search form.</li><li>mobile - Display the search form at the bottom of the global menu (drawer menu).</li></ul>', 'tcd-w' ); ?></div>
	<p><label><input name="dp_options[show_header_search]" type="checkbox" value="1" <?php checked( $dp_options['show_header_search'], 1 ); ?>><?php _e( 'Display search form in header', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_header_search_mobile]" type="checkbox" value="1" <?php checked( $dp_options['show_header_search_mobile'], 1 ); ?>><?php _e( 'Display search form in global menu for mobile', 'tcd-w' ); ?></label></p>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // グローバルメニュー設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Global menu settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Hover underline color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the color of the underline when hovering over the menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[globalmenu_hover_underline_color]" type="text" value="<?php echo esc_attr( $dp_options['globalmenu_hover_underline_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['globalmenu_hover_underline_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Submenu link color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font color of sub menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[submenu_color]" type="text" value="<?php echo esc_attr( $dp_options['submenu_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['submenu_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Submenu link color on hover', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set hover font color of sub menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[submenu_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['submenu_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['submenu_color_hover'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Submenu background color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set background color of the submenu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[submenu_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['submenu_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['submenu_bg_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Submenu background color on hover', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set hover background color of sub menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[submenu_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['submenu_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['submenu_bg_color_hover'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // グローバルメニュー表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Global menu display settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Only the menu items for which "Category" is set in the submenu will be displayed in the mega menu style, and menu items other than "category" will be ignored.', 'tcd-w' ); ?></p>
	<p><?php printf( __( 'To use Mega menu A, please set category image on <a href="%s" target="_blank">Category edit screen</a>.', 'tcd-w' ), admin_url( 'edit-tags.php?taxonomy=category' ) ); ?></p>
<?php
$menu_locations = get_nav_menu_locations();
$nav_menus = wp_get_nav_menus();
if ( ! empty( $menu_locations['global'] ) && $nav_menus && ! is_wp_error( $nav_menus ) ) :
	foreach ( $nav_menus as $nav_menu ) :
		if ( $nav_menu->term_id == $menu_locations['global'] ) :
			$global_menu_items = wp_get_nav_menu_items( $nav_menu );
			break;
		endif;
	endforeach;
endif;
if ( ! empty( $global_menu_items ) && ! is_wp_error( $global_menu_items ) ) :
	echo "\t<table>\n";
	foreach ( $global_menu_items as $global_menu_item ) :
		if ( ! isset( $global_menu_item->menu_item_parent ) || 0 != $global_menu_item->menu_item_parent )
			continue;

		if ( ! empty( $dp_options['megamenu'][$global_menu_item->db_id] ) ) :
			$current_value = $dp_options['megamenu'][$global_menu_item->db_id];
		else :
			$current_value = '';
		endif;

		echo "\t\t<tr>";
		echo '<td>' . esc_html( $global_menu_item->title ) . '</td>';
		echo '<td><select class="js-megamenu" name="dp_options[megamenu][' . esc_attr( $global_menu_item->db_id ) . ']">';

		foreach ( $megamenu_options as $option ) :
			echo '<option value="' . esc_attr( $option['value'] ) . '" ' . selected( $option['value'], $current_value, false ) . '>' . $option['label'] . '</option>';
		endforeach;
		echo '</select>';
		echo '</td>';
		echo "</tr>\n";
	endforeach;
	echo "\t</table>\n";
?>
	<ul class="p-megamenu wp-clearfix">
		<?php foreach ( $megamenu_options as $option ) : ?>
		<li>
			<img src="<?php echo esc_attr( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
			<p><?php echo $option['label']; ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
<?php
else :
?>
	<p class="description"><?php printf( __( 'Please set it as a global menu by <a href="%s" target="_blank">menu setting.</a>', 'tcd-w' ), admin_url( 'nav-menus.php' ) ); ?></p>
<?php
endif;
?>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ページヘッダーの設定 ?>
<div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e( 'Color of lower page header', 'tcd-w' ); ?></h3>
    <h4 class="theme_option_headline2"><?php _e( 'Font color of title', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font color of the page header title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[page_header_headline_color]" type="text" value="<?php echo esc_attr( $dp_options['page_header_headline_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['page_header_headline_color'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Font color of description', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set font color of the page header description.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[page_header_desc_color]" type="text" value="<?php echo esc_attr( $dp_options['page_header_desc_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['page_header_desc_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set background color of the page header.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[page_header_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['page_header_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['page_header_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
