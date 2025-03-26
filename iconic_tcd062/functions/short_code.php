<?php
/**
 * 記事ページの広告用ショートコード
 */
function theme_option_single_banner() {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	$html = '';

	if ( $dp_options['single_ad_code3'] || $dp_options['single_ad_image3'] || $dp_options['single_ad_code4'] || $dp_options['single_ad_image4'] ) {
		$html .= '<div class="p-entry__ad p-ad">' . "\n";

		if ( $dp_options['single_ad_code3'] ) {
			$html .= '<div class="p-entry__ad-item p-ad__item">' . "\n";
			$html .= $dp_options['single_ad_code3'] . "\n";
			$html .= '</div>' . "\n";
		} elseif ( $dp_options['single_ad_image3'] ) {
			$single_image3 = wp_get_attachment_image_src( $dp_options['single_ad_image3'], 'full' );
			if ( $single_image3 ) {
				$html .= '<div class="p-entry__ad-item p-ad__item">' . "\n";
				$html .= '<a href="' . esc_url( $dp_options['single_ad_url3'] ) . '" target="_blank"><img src="' . esc_attr( $single_image3[0] ) . '" alt=""></a>' . "\n";
				$html .= '</div>' . "\n";
			}
		}

		if ( $dp_options['single_ad_code4'] ) {
			$html .= '<div class="p-entry__ad-item p-ad__item">' . "\n";
			$html .= $dp_options['single_ad_code4'] . "\n";
			$html .= '</div>' . "\n";
		} elseif ( $dp_options['single_ad_image4'] ) {
			$single_image4 = wp_get_attachment_image_src( $dp_options['single_ad_image4'], 'full' );
			if ( $single_image4 ) {
				$html .= '<div class="p-entry__ad-item p-ad__item">' . "\n";
				$html .= '<a href="' . esc_url( $dp_options['single_ad_url4'] ) . '" target="_blank"><img src="' . esc_attr( $single_image4[0] ) . '" alt=""></a>' . "\n";
				$html .= '</div>' . "\n";
			}
		}

		$html .= '</div>' . "\n";
	}

	return $html;
}
add_shortcode( 's_ad', 'theme_option_single_banner' );
