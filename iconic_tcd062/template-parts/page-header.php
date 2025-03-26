<?php
global $post, $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

$signage = $catchphrase = $desc = $overlay = $overlay_opacity = null;


if ( is_welcart_cart_page() ) :
	$catchphrase = __( 'In the cart', 'tcd-w' );

elseif ( is_welcart_member_page() ) :
	$catchphrase = get_welcart_member_page_filterd_title();

elseif ( is_404() ) :
	$signage = wp_get_attachment_url( $dp_options['image_404'] );
	$catchphrase = trim( $dp_options['catchphrase_404'] );
	$desc = trim( $dp_options['desc_404'] );
	$catchphrase_font_size = $dp_options['catchphrase_font_size_404'] ? $dp_options['catchphrase_font_size_404'] : 30;
	$desc_font_size = $dp_options['desc_font_size_404'] ? $dp_options['desc_font_size_404'] : 14;
	$color = $dp_options['color_404'] ? $dp_options['color_404'] : '#ffffff';
	$shadow1 = $dp_options['shadow1_404'] ? $dp_options['shadow1_404'] : 0;
	$shadow2 = $dp_options['shadow2_404'] ? $dp_options['shadow2_404'] : 0;
	$shadow3 = $dp_options['shadow3_404'] ? $dp_options['shadow3_404'] : 0;
	$shadow4 = $dp_options['shadow_color_404'] ? $dp_options['shadow_color_404'] : '#999999';
	$overlay = $dp_options['overlay_404'] ? $dp_options['overlay_404'] : '#000000';
	$overlay_opacity = $dp_options['overlay_opacity_404'] ? $dp_options['overlay_opacity_404'] : 0.5;

elseif ( is_post_type_archive( $dp_options['news_slug'] ) || is_singular( $dp_options['news_slug'] ) ) :
	$catchphrase = $dp_options['news_header_headline'] ? $dp_options['news_header_headline'] : $dp_options['news_breadcrumb_label'];
	$desc = $dp_options['news_header_desc'];

elseif ( is_category() || is_tag() ) :
	$queried_object = get_queried_object();
	if ( ! empty( $queried_object->term_id ) ) :
		$catchphrase = $queried_object->name;
		$desc = trim( $queried_object->description );
	endif;

elseif ( is_welcart_page() ) :
	$catchphrase = trim( get_the_title() );

elseif ( is_home() && $dp_options['blog_breadcrumb_label'] ) :
	$catchphrase = $dp_options['blog_header_headline'] ? $dp_options['blog_header_headline'] : $dp_options['blog_breadcrumb_label'];
	$desc = $dp_options['blog_header_desc'];

elseif ( is_page() ) :
	$signage = wp_get_attachment_url( $post->page_header_image );
	$catchphrase = trim( $post->page_headline ? $post->page_headline : $post->post_title );
	$catchphrase_font_size = $post->page_headline_font_size ? $post->page_headline_font_size : 30;
	$desc = trim( $post->page_desc );
	$desc_font_size = $post->page_desc_font_size ? $post->page_desc_font_size : 14;
	$color = $post->page_headline_color ? $post->page_headline_color : '#ffffff';
	$shadow1 = $post->page_headline_shadow1 ? $post->page_headline_shadow1 : 0;
	$shadow2 = $post->page_headline_shadow2 ? $post->page_headline_shadow2 : 0;
	$shadow3 = $post->page_headline_shadow3 ? $post->page_headline_shadow3 : 0;
	$shadow4 = $post->page_headline_shadow4 ? $post->page_headline_shadow4 : '#999999';
	$overlay = $post->page_overlay ? $post->page_overlay : '#000000';
	$overlay_opacity = $post->page_overlay_opacity ? $post->page_overlay_opacity : 0;

elseif ( is_search() ) :
	$catchphrase = sprintf( __( 'Search result for "%s"', 'tcd-w' ), esc_html( get_query_var( 's' ) ) );

elseif ( is_archive() ) :
	$catchphrase = get_the_archive_title();

elseif ( is_welcart_single() && $category = get_welcart_category() ) :
	$catchphrase = $category->name;
	$desc = trim( $category->description );

elseif ( is_singular() && has_category() ) :
	$categories = get_the_category();
	if ( $categories ) :
		foreach ( $categories as $key => $category ) :
			$catchphrase = $category->name;
			$desc = trim( $category->description );
			break;
		endforeach;
	endif;
endif;

if ( $signage ) :
?>
	<header id="js-page-header" class="p-page-header__image"<?php if ( !empty( $signage ) ) echo ' style="background-image: url(' . esc_attr( $signage ) . ');"'; ?>>
		<div style="display:flex;">
		<div class="p-page-header__overlay" style="background-color: rgba(<?php echo esc_attr( implode( ', ', hex2rgb( $overlay ) ) ); ?>, <?php echo esc_attr( $overlay_opacity ); ?>);">
			<div class="p-page-header__inner l-inner" style="text-shadow: <?php echo esc_attr( $shadow1 ); ?>px <?php echo esc_attr( $shadow2 ); ?>px <?php echo esc_attr( $shadow3 ); ?>px <?php echo esc_attr( $shadow4 ); ?>;">
<?php
	if ( $catchphrase ) :
?>
				<h1 class="p-page-header__title" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $catchphrase_font_size ); ?>px;"><?php echo esc_html( $catchphrase ); ?></h1>
<?php
	endif;
	if ( $desc ) :
?>
				<p class="p-page-header__desc" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $desc_font_size ); ?>px;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $desc ) ); ?></p>
<?php
	endif;
?>
			</div>
		</div>
		</div>
	</header>
<?php
elseif ( $catchphrase || $desc ) :
?>
	<header class="p-page-header<?php if ( $catchphrase && $desc ) echo ' p-page-header--2col' ?>">
		<div class="p-page-header__inner l-inner">
<?php
	if ( $catchphrase ) :
?>
			<h1 class="p-page-header__title"><?php echo esc_html( $catchphrase ); ?></h1>
<?php
	endif;
	if ( $desc ) :
?>
			<p class="p-page-header__desc"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $desc ) ); ?></p>
<?php
	endif;
?>
		</div>
	</header>
<?php
endif;
