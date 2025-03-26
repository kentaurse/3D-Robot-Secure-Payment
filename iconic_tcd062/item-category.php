<?php
$dp_options = get_design_plus_option();

if ( is_post_type_archive( $dp_options['news_slug'] ) ) :
	get_template_part( 'archive-news' );
	return;
endif;

$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/page-header' );
get_template_part( 'template-parts/breadcrumb' );

if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
		<div class="l-primary">
<?php
else :
?>
	<div class="l-inner">
<?php
endif;

if ( have_posts() ) :
?>
			<div class="p-item-archive">
<?php
	while ( have_posts() ) :
		the_post();
		$usces_is_item = false;
		if ( function_exists( 'usces_the_item' ) ) :
			usces_the_item();
			$usces_is_item = usces_is_item() && usces_have_skus();
		endif;
?>
				<article class="p-item-archive__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-item-archive__item-thumbnail p-hover-effect__image">
							<div class="p-item-archive__item-thumbnail__inner js-object-fit-cover">
<?php
		echo "\t\t\t\t\t\t\t\t";
		if ( $usces_is_item && usces_the_itemImageURL( 0, 'return' ) ) :
			usces_the_itemImage( 0, 500, 500 );
		elseif ( has_post_thumbnail() ) :
			the_post_thumbnail( 'size2' );
		else :
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-500x500.gif" alt="">';
		endif;
		if ( $usces_is_item && ! usces_have_zaiko_anyone() ) :
			echo '<div class="p-article__thumbnail-soldout u-visible-sm"><span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span></div>';
		endif;
		echo "\n";
?>
							</div>
						</div>
						<div class="p-item-archive__item-info">
							<h2 class="p-item-archive__item-title p-article-item__title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h2>
<?php
		if ( $usces_is_item ) :
			echo "\t\t\t\t\t\t\t";
			echo '<p class="p-item-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
			if ( ! usces_have_zaiko_anyone() ) :
				echo '<span class="p-item-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
			endif;
			echo '</p>';

			if ( $dp_options['show_date_item'] || $dp_options['show_category_item'] ) :
				echo "\t\t\t\t\t\t\t";
				echo '<p class="p-item-archive__item-meta p-article__meta">';
				if ( $dp_options['show_date_item'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $dp_options['show_category_item'] ) :
					$categories = array( get_welcart_category() );
					if ( $categories && ! is_wp_error( $categories ) ) :
						echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
					endif;
				endif;
				echo "</p>\n";
			endif;
		else :
			if ( $dp_options['show_date'] || ( ! is_category() && $dp_options['show_category'] && has_category() ) ) :
				echo "\t\t\t\t\t\t\t";
				echo '<p class="p-item-archive__item-meta p-article__meta">';
				if ( $dp_options['show_date'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( ! is_category() && $dp_options['show_category'] && has_category() ) :
					$categories = get_the_category();
					if ( $categories && ! is_wp_error( $categories ) ) :
						echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
					endif;
				endif;
				echo "</p>\n";
			endif;
		endif;
?>
						</div>
					</a>
				</article>
<?php
	endwhile;
?>
			</div>
<?php
	$paginate_current = max( 1, get_query_var( 'paged' ) );
	$paginate_links = paginate_links( array(
		'current' => $paginate_current,
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager">
				<li class="p-pager__item p-pager__num u-hidden-xs"><span><?php echo max( 1, get_query_var( 'paged' ) ) . ' / ' . $wp_query->max_num_pages; ?></span></li>

<?php
		if ( 1 < $paginate_current ):
?>
				<li class="p-pager__item"><a class="first page-numbers" href="<?php echo esc_attr( get_pagenum_link( 1 ) ); ?>">First</a></li>
<?php
		endif;
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item<?php if ( strpos( $paginate_link, 'current' ) ) echo ' p-pager__item--current'; ?>"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
		if ( $paginate_current < $wp_query->max_num_pages ):
?>
				<li class="p-pager__item"><a class="last page-numbers" href="<?php echo esc_attr( get_pagenum_link( $wp_query->max_num_pages ) ); ?>">Last</a></li>
<?php
		endif;
?>
			</ul>
<?php
	endif;
else :
?>
			<p class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
<?php
endif;

if ( $active_sidebar ) :
?>
		</div>
<?php
	get_sidebar();
?>
	</div>
<?php
else :
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
