<?php

function tcd_welcart_meta_box() {
	// Welcart商品の場合のみ
	if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'usces_itemedit' || $_GET['page'] == 'usces_itemnew' ) ){
		add_meta_box(
			'tcd_welcart_meta_box' ,// ID of meta box
			__( 'Tabbed product details', 'tcd-w' ), // label
			'show_tcd_welcart_meta_box', // callback function
			'post', // post type
			'normal', // context
			'high' // priority
		);

		// remove page builder meta box
        remove_meta_box( 'page_builder-metabox', 'post', 'advanced' );
        remove_meta_box( 'page_builder-metabox', 'post', 'normal' );
	}
}
add_action( 'add_meta_boxes', 'tcd_welcart_meta_box', 10 );

function show_tcd_welcart_meta_box() {
	global $post;

	echo '<input type="hidden" name="tcd_welcart_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
?>
<div class="theme_option_field" style="border: none; margin: 20px 0 0 0; padding: 0;">
<?php
	for ( $i = 1; $i <= 5; $i++ ) :
		$show_tab = get_post_meta( $post->ID, 'show_tab' . $i, true);
		$tab_label = get_post_meta( $post->ID, 'tab_label' . $i, true);
		$tab_content = get_post_meta( $post->ID, 'tab_content' . $i, true);
		$tab_spec = get_post_meta( $post->ID, 'tab_spec' . $i, true);
?>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline" style="margin: 0 -20px;"><?php printf( __( 'Tab%d setting', 'tcd-w' ), $i ); ?></h3>
		<div class="sub_box_content cf_simple_repeater_container">
			<p><label><input name="show_tab<?php echo $i; ?>" type="checkbox" value="1" <?php checked( $show_tab, 1 ); ?>><?php _e( 'Display this tab', 'tcd-w' ); ?></label></p>

			<h4 class="theme_option_headline2"><?php _e( 'Tab label', 'tcd-w'); ?></h4>
			<input class="large-text" name="tab_label<?php echo $i; ?>" type="text" value="<?php echo esc_attr( $tab_label ); ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w'); ?></h4>
<?php
		wp_editor(
			$tab_content,
			'tab_content' . $i,
			array(
				'textarea_name' => 'tab_content' . $i,
				'textarea_rows' => 10
			 )
		);
?>
			<h4 class="theme_option_headline2"><?php _e( 'Spec table', 'tcd-w'); ?></h4>
			<p class="description"><?php _e( 'Please add the item from "Add row" and set display contents.', 'tcd-w' ); ?></p>
<?php
		// 行テンプレート
		$clone = '<tr>';
		$clone .= '<td><textarea name="tab_spec' . $i . '[headline][]" cols="10" rows="2" class="large-text"></textarea></td>';
		$clone .= '<td><textarea name="tab_spec' . $i . '[desc][]" cols="30" rows="2" class="large-text"></textarea></td>';
		$clone .= '<td class="col-delete"><a href="#" class="button button-secondary button-delete-row">' . __( 'Delete', 'tcd-w' ) . '</a></td>';
		$clone .= '</tr>';

		echo '<table class="cf_simple_repeater cf_simple_repeater-sortable" data-delete-confirm="' . __( 'Delete?', 'tcd-w') . '">' . "\n";
		echo '<thead>' . "\n";
		echo '<tr>';
		echo '<th class="col-headline">' . __( 'Headline', 'tcd-w' ) . '</th>';
		echo '<th class="col-desc">' . __( 'Description', 'tcd-w' ) . '</th>';
		echo '<th class="col-delete"></th>';
		echo '</tr>' . "\n";
		echo '</thead>' . "\n";
		echo '<tbody>' . "\n";

		if ( ! empty( $tab_spec['headline'] ) && is_array( $tab_spec['headline'] ) ) {
			foreach( array_keys( $tab_spec['headline'] ) as $repeater_index ) {
				if ( isset( $tab_spec['headline'][$repeater_index] ) ) {
					$row_headline = $tab_spec['headline'][$repeater_index];
				} else {
					$row_headline = '';
				}
				if ( isset( $tab_spec['desc'][$repeater_index] ) ) {
					$row_desc = $tab_spec['desc'][$repeater_index];
				} else {
					$row_desc = '';
				}

				echo '<tr>';
				echo '<td><textarea name="tab_spec' . $i . '[headline][]" cols="10" rows="2" class="large-text">' . esc_textarea( $row_headline ) . '</textarea></td>';
				echo '<td><textarea name="tab_spec' . $i . '[desc][]" cols="30" rows="2" class="large-text">' . esc_textarea( $row_desc ) . '</textarea></td>';
				echo '<td class="col-delete"><a href="#" class="button button-secondary button-delete-row">' . __( 'Delete', 'tcd-w' ) . '</a></td>';
				echo '</tr>' . "\n";
			}
		} else {
			echo $clone."\n";
		}

		echo '</tbody>' . "\n";
		echo '</table>' . "\n";

		echo '<a href="#" class="button button-secondary button-add-row" data-clone="' . esc_attr( $clone ) . '">' . __( 'Add row', 'tcd-w' ) . '</a>' . "\n";
?>
		</div>
	</div>
<?php
	endfor;
?>
</div>
<?php
}

function save_tcd_welcart_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_welcart_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_welcart_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
	}

	// save or delete
	$cf_keys = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$cf_keys[] = 'show_tab' . $i;
		$cf_keys[] = 'tab_label' . $i;
		$cf_keys[] = 'tab_content' . $i;
		$cf_keys[] = 'tab_spec' . $i;
	}
	foreach ( $cf_keys as $cf_key ) {
		$old = get_post_meta( $post_id, $cf_key, true );
		$new = isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '';

		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $cf_key, $new );
		} elseif ( ! $new && $old ) {
			delete_post_meta( $post_id, $cf_key, $old );
		}
	}
}
add_action( 'save_post', 'save_tcd_welcart_meta_box' );
