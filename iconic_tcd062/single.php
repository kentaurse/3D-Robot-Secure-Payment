<?php
$dp_options = get_design_plus_option();

if ( is_singular( $dp_options['news_slug'] ) ) :
	get_template_part( 'single-news' );
	return;
elseif ( is_welcart_single() ) :
	// if require password, load single.php
	get_template_part( 'wc_templates/wc_item_single' );
	return;
endif;

$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/page-header' );
get_template_part( 'template-parts/breadcrumb' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		if ( $post->page_link && in_array( $post->page_link, array( 'type1', 'type2' ) ) ) :
			$page_link = $post->page_link;
		else :
			$page_link = $dp_options['page_link'];
		endif;

		if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
<?php
		endif;
?>
		<article class="p-entry <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<div class="p-entry__inner">
<?php
		if ( $dp_options['show_thumbnail'] && has_post_thumbnail() ) :
?>
				<div class="p-entry__thumbnail">
					<?php the_post_thumbnail( 'size5' ); ?>
<?php
		endif;

		if ( $dp_options['show_date'] || $dp_options['show_category'] ) :
			echo "\t\t\t\t\t";
			echo '<ul class="p-entry__meta-top p-article__meta">';
			if ( $dp_options['show_date'] ) :
				echo '<li class="p-entry__meta-top--date"><time datetime="' . get_the_time( 'Y-m-d' ) . '">'. get_the_time( 'Y.m.d' ) . '</time></li>';
			endif;
			if ( $dp_options['show_category'] ) :
				$categories = get_the_category();
				if ( !empty( $categories[0]->term_id ) ) :
					echo '<li class="p-entry__meta-top--category"><a href="' . esc_attr( get_category_link( $categories[0] ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
				endif;
			endif;
			echo "</ul>\n";
		endif;

		if ( $dp_options['show_thumbnail'] && has_post_thumbnail() ) :
?>
				</div>
<?php
		endif;
?>
				<h1 class="p-entry__title"><?php the_title(); ?></h1>
<?php
		if ( $dp_options['show_sns_top'] ) :
			get_template_part( 'template-parts/sns-btn-top' );
		endif;
?>
				<div class="p-entry__body">
<?php
		the_content();

		if ( ! post_password_required() ) :
			if ( 'type2' === $page_link ):
				if ( $page < $numpages && preg_match( '/href="(.*?)"/', _wp_link_page( $page + 1 ), $matches ) ) :
?>
					<div class="p-entry__next-page">
						<a class="p-entry__next-page__link p-button" href="<?php echo esc_url( $matches[1] ); ?>"><?php _e( 'Read more', 'tcd-w' ); ?></a>
						<div class="p-entry__next-page__numbers"><?php echo $page . ' / ' . $numpages; ?></div>
					</div>
<?php
				endif;
			else:
				wp_link_pages( array(
					'before' => '<div class="p-page-links">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>'
				) );
			endif;
		endif;
?>
				</div>
<?php
		if ( $dp_options['show_sns_btm'] ) :
			get_template_part( 'template-parts/sns-btn-btm' );
		endif;

		if ( $dp_options['show_author'] || $dp_options['show_category'] || $dp_options['show_tag'] || $dp_options['show_comment'] ) :
?>
				<ul class="p-entry__meta c-meta-box u-clearfix">
					<?php if ( $dp_options['show_author'] ) : ?><li class="c-meta-box__item c-meta-box__item--author"><?php _e( 'Author: ', 'tcd-w' ); echo the_author_posts_link(); ?></li><?php endif; ?>
					<?php if ( $dp_options['show_category'] ) : ?><li class="c-meta-box__item c-meta-box__item--category"><?php the_category( ', ' ); ?></li><?php endif; ?>
					<?php if ( $dp_options['show_tag'] && get_the_tags() ) : ?><li class="c-meta-box__item c-meta-box__item--tag"><?php echo get_the_tag_list( '', ', ', '' ); ?></li><?php endif; ?>
					<?php if ( $dp_options['show_comment'] ) : ?><li class="c-meta-box__item c-meta-box__item--comment"><?php _e( 'Comments', 'tcd-w' ); ?>: <a href="#comment_headline"><?php echo get_comments_number( '0', '1', '%' ); ?></a></li><?php endif; ?>
				</ul>
<?php
		endif;

		get_template_part( 'template-parts/advertisement' );

		$previous_post = get_previous_post();
		$next_post = get_next_post();
		if ( $dp_options['show_next_post'] && ( $previous_post || $next_post ) ) :
?>
				<ul class="p-entry__nav c-entry-nav">
<?php
			if ( $previous_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--prev">
						<a href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>" data-prev="<?php _e( 'Previous post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( mb_strimwidth( strip_tags( $previous_post->post_title ), 0, 86, '...' ) ); ?></span></a>
					</li>
<?php
			else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
			endif;
			if ( $next_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--next">
						<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" data-next="<?php _e( 'Next post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( mb_strimwidth( strip_tags( $next_post->post_title ), 0, 86, '...' ) ); ?></span></a>
					</li>
<?php
			else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
			endif;
?>
				</ul>
<?php
		endif;
?>
			</div>
<?php

		if ( $dp_options['show_related_post'] ) :
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'post__not_in' => array( $post->ID ),
				'posts_per_page' => $dp_options['related_post_num'],
				'orderby' => 'rand'
			);
			$categories = get_the_category();
			if ( $categories ) :
				$category_ids = array();
				foreach ( $categories as $category ) :
					if ( !empty( $category->term_id ) ) :
						$category_ids[] = $category->term_id;
					endif;
				endforeach;
				if ( $category_ids ) :
					$args['tax_query'][] = array(
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => $category_ids,
						'operator' => 'IN'
					);
				endif;
			endif;
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
?>
			<section class="p-entry__related">
<?php
				if ( $dp_options['related_post_headline'] ) :
?>
				<h2 class="p-headline"><?php echo esc_html( $dp_options['related_post_headline'] ); ?></h2>
<?php
				endif;
?>
				<div class="p-entry__related-items">
<?php
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
?>
					<article class="p-entry__related-item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-entry__related-item__thumbnail p-hover-effect__image js-object-fit-cover">
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
							<h3 class="p-entry__related-item__title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 54, '...' ); ?></h3>
						</a>
					</article>
<?php
				endwhile;

				if ( $the_query->post_count % 3 > 0 ) :
					echo "\t\t\t\t\t" . str_repeat('<div class="p-entry__related-item u-hidden-sm"></div>', 3 - ( $the_query->post_count % 3 ) ) . "\n";
				endif;

				wp_reset_postdata();
?>
				</div>
			</section>
<?php
			endif;
		endif;

		if ( $dp_options['show_comment'] ) :
			comments_template( '', true );
		endif;
?>
		</article>
<?php
	endwhile;
endif;

if ( $active_sidebar ) :
	get_sidebar();
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>