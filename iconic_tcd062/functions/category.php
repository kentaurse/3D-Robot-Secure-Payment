<?php

// カテゴリー追加用入力欄を出力 -------------------------------------------------------
function category_add_extra_category_fields() {
?>
<div class="form-field category-image_megamenu-wrap">
	<label for="category-image_megamenu"><?php _e( 'Category image for Mega menu A', 'tcd-w' ); ?></label>
	<p class="description"><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 210, 130 ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js">
			<input type="hidden" value="" id="category-image_megamenu" name="term_meta[image_megamenu]" class="cf_media_id">
			<div class="preview_field"></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button hidden">
			</div>
		</div>
	</div>
</div>
<?php
}
add_action( 'category_add_form_fields', 'category_add_extra_category_fields' );

// カテゴリー編集用入力欄を出力 -------------------------------------------------------
function category_edit_extra_category_fields( $term ) {
	$term_meta = get_option( 'taxonomy_' . $term->term_id, array() );
	$term_meta = array_merge( array(
		'image_megamenu' => null
	), $term_meta );
?>
<tr class="form-field">
	<th><label for="category-image_megamenu"><?php _e( 'Category image for Mega menu A', 'tcd-w' ); ?></label></th>
	<td>
		<p class="description"><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 210, 130 ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js">
				<input type="hidden" value="<?php if ( $term_meta['image_megamenu'] ) echo esc_attr( $term_meta['image_megamenu'] ); ?>" id="category_image_megamenu" name="term_meta[image_megamenu]" class="cf_media_id">
				<div class="preview_field"><?php if ( $term_meta['image_megamenu'] ) echo wp_get_attachment_image( $term_meta['image_megamenu'], 'medium'); ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $term_meta['image_megamenu'] ) echo 'hidden'; ?>">
				</div>
			</div>
		</div>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'category_edit_extra_category_fields' );

// データを保存 -------------------------------------------------------
function category_save_extra_category_fileds( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = get_option( "taxonomy_{$term_id}", array() );
		$meta_keys = array(
			'image_megamenu'
		);
		foreach ( $meta_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}

		update_option( "taxonomy_{$term_id}", $term_meta );
	}
}
add_action( 'created_category', 'category_save_extra_category_fileds' );
add_action( 'edited_category', 'category_save_extra_category_fileds' );
