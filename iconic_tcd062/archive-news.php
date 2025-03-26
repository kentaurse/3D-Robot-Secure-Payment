<?php
$dp_options = get_design_plus_option();
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
			<div class="p-archive-news">
<?php
	while ( have_posts() ) :
		the_post();
?>
				<article class="p-archive-news__item p-archive-news__item-has_thumbnail">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-archive-news__item-thumbnail">
							<div class="p-archive-news__item-thumbnail__inner p-hover-effect__image">
<?php
	echo "\t\t\t\t\t\t\t\t";
	if ( has_post_thumbnail() ) :
		the_post_thumbnail( 'size1' );
	else :
		echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
	endif;
	echo "\n";
?>
							</div>
						</div>
						<div class="p-archive-news__item-info">
<?php
		if ( $dp_options['show_date_news'] ) :
?>
							<p class="p-archive-news__item-meta p-article__meta"><time class="p-archive-news__item-date p-article__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
		endif;
?>
							<h3 class="p-archive-news__item-title p-article-news__title p-article__title"><?php
		if ( is_mobile() ) :
			if ( $dp_options['show_thumbnail_news'] && has_post_thumbnail() ) :
				echo mb_strimwidth( strip_tags( get_the_title() ), 0, 50, '...' );
			else :
				echo mb_strimwidth( strip_tags( get_the_title() ), 0, 98, '...' );
			endif;
		else :
			the_title();
		endif;
							?></h3>
						</div>
					</a>
				</article>
<?php
	endwhile;
?>
			</div>
<?php
	$paginate_links = paginate_links( array(
		'current' => max( 1, get_query_var( 'paged' ) ),
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager p-pager-news">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item<?php if ( strpos( $paginate_link, 'current' ) ) echo ' p-pager__item--current'; ?>"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
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
