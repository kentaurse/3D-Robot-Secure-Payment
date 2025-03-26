<?php
global $dp_options, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

// 画像スライダー
$display_slides = 0;
for ( $i = 1; $i <= 5; $i++ ) :
	if ( is_mobile() && $dp_options['slider_image_sp' . $i] ) :
		$slider_image = wp_get_attachment_image_src( $dp_options['slider_image_sp' . $i], 'full' );
	else :
		$slider_image = wp_get_attachment_image_src( $dp_options['slider_image' . $i], 'full' );
	endif;
	if ( empty( $slider_image[0] ) ) continue;

	$display_slider_catch = ( $dp_options['display_slider_catch' . $i] && $dp_options['slider_catch' . $i] );
	$display_slider_headline = ( $dp_options['display_slider_headline' . $i] && $dp_options['slider_headline' . $i] );
	$display_slider_button = ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] );
	$display_slider_overlay = ( $dp_options['display_slider_overlay' . $i] && 0 < $dp_options['slider_overlay_opacity' . $i] );

	$display_slides++;
	if ( 1 == $display_slides ) :
?>
	<div id="js-index-slider" class="p-index-slider" data-slide-time="<?php echo esc_attr( $dp_options['slide_time'] ); ?>">
<?php
	endif;
?>
		<div class="p-index-slider__item p-index-slider__item--<?php echo $i; ?><?php if ( $display_slider_button ) echo ' has-button'; if ( $dp_options['slider_url' . $i] && $display_slider_button ) echo ' has-link-button'; ?>">
			<div class="p-index-slider__item__inner">
<?php
	if ( $display_slider_catch ) :
?>
				<div class="p-index-slider__item-content">
					<div class="p-index-slider__item-content__inner l-inner">
						<div class="p-index-slider__item-catch p-index-slider__item-catch--<?php echo esc_attr( $dp_options['slider_catch_align' . $i] ); ?>"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['slider_catch' . $i] ) ); ?></div>
					</div>
				</div>
<?php
	endif;

	if ( $dp_options['slider_url' . $i] ) :
?>
				<a class="p-index-slider__item-image" href="<?php echo esc_url( $dp_options['slider_url' . $i] ); ?>"<?php if ( $dp_options['slider_target' . $i] ) echo ' target="_blank"'; ?>><img <?php echo 1 == $display_slides ? 'src' : 'data-lazy'; ?>="<?php echo esc_attr( $slider_image[0] ); ?>" alt=""></a>
<?php
	else :
?>
				<div class="p-index-slider__item-image"><img <?php echo 1 == $display_slides ? 'src' : 'data-lazy'; ?>="<?php echo esc_attr( $slider_image[0] ); ?>" alt=""></div>
<?php
	endif;
?>
			</div>
<?php
	if ( $display_slider_headline || $display_slider_button ) :
?>
			<div class="p-index-slider__item-content-bottom">
				<div class="p-index-slider__item-content-bottom__inner l-inner">
<?php
		if ( $display_slider_headline ) :
?>
					<div class="p-index-slider__item-headline"><?php echo esc_html( $dp_options['slider_headline' . $i] ); ?></div>
<?php
		endif;

		if ( $display_slider_button ) :
			if ( $dp_options['slider_url' . $i] ) :
?>
					<a class="p-index-slider__item-button" href="<?php echo esc_url( $dp_options['slider_url' . $i] ); ?>"<?php if ( $dp_options['slider_target' . $i] ) echo ' target="_blank"'; ?>><span><?php echo esc_html( $dp_options['slider_button_label' . $i] ); ?></span></a>
<?php
			else :
?>
					<div class="p-index-slider__item-button"><span><?php echo esc_html( $dp_options['slider_button_label' . $i] ); ?></span></div>
<?php
			endif;
		endif;
?>
				</div>
			</div>
<?php
	endif;

	if ( $display_slider_overlay ) :
		if ( $dp_options['slider_url' . $i] ) :
?>
			<a class="p-index-slider__item-overlay" href="<?php echo esc_url( $dp_options['slider_url' . $i] ); ?>"<?php if ( $dp_options['slider_target' . $i] ) echo ' target="_blank"'; ?>></a>
<?php
		else :
?>
			<div class="p-index-slider__item-overlay"></div>
<?php
		endif;
	endif;
?>
		</div>
<?php
endfor;

if ( $display_slides ) :
?>
	</div>
<?php
endif;

// news ticker
if ( $dp_options['show_index_news'] && 0 < $dp_options['index_news_num'] ) :
	$args = array(
		'post_type' => $dp_options['news_slug'],
		'posts_per_page' => $dp_options['index_news_num'],
		'ignore_sticky_posts' => true,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>
	<div class="p-index-news">
		<div class="p-index-news__inner l-inner">
			<div id="js-index-newsticker" class="p-index-news__items" data-slide-time="<?php echo esc_attr( $dp_options['index_news_slide_time'] ); ?>">
<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
?>
				<article class="p-index-news__item">
					<a href="<?php the_permalink(); ?>">
<?php
			if ( $dp_options['show_index_news_date'] ) :
?>
						<p class="p-index-news__item-date"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
			endif;
?>
						<h3 class="p-index-news__item-title"><?php echo mb_strimwidth( get_the_title(), 0, is_mobile() ? 70 : 300, '...' ); ?></h3>
					</a>
				</article>
<?php
		endwhile;
?>
			</div>
<?php
		if ( $dp_options['index_news_archive_link_text'] ) :
?>
			<div class="p-index-news__archive-link">
				<a class="p-index-news__archive-link__button p-button" href="<?php echo esc_attr( get_post_type_archive_link( $dp_options['news_slug'] ) ); ?>"><span><?php echo esc_html( $dp_options['index_news_archive_link_text'] ); ?></span></a>
			</div>
<?php
		endif;
?>
		</div>
	</div>
<?php
	endif;
endif;
