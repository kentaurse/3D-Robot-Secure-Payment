<?php
$dp_options = get_design_plus_option();
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

		if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
<?php
		endif;
?>
		<article class="p-entry p-entry-news <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<div class="p-entry__inner">
<?php
		if ( $dp_options['show_thumbnail_news'] && has_post_thumbnail() ) :
?>
				<div class="p-entry__thumbnail">
					<?php the_post_thumbnail( 'size5' ); ?>
<?php
		endif;
		if ( $dp_options['show_date_news'] ) :
			echo "\t\t\t\t\t";
			echo '<ul class="p-entry__meta-top p-article__meta">';
			echo '<li class="p-entry__meta-top--date"><time datetime="' . get_the_time( 'Y-m-d' ) . '">'. get_the_time( 'Y.m.d' ) . '</time></li>';
			echo "</ul>\n";
		endif;

		if ( $dp_options['show_thumbnail_news'] && has_post_thumbnail() ) :
?>
				</div>
<?php
		endif;
?>
				<h1 class="p-entry__title p-entry-news__title"><?php the_title(); ?></h1>
<?php
		if ( $dp_options['show_sns_top_news'] ) :
			get_template_part( 'template-parts/sns-btn-top' );
		endif;
?>
				<div class="p-entry__body p-entry-news__body">
<?php
		the_content();

		if ( ! post_password_required() ) :
			wp_link_pages( array(
				'before' => '<div class="p-page-links">',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>'
			) );
		endif;
?>
				</div>
<?php
		if ( $dp_options['show_sns_btm_news'] ) :
			get_template_part( 'template-parts/sns-btn-btm' );
		endif;

		$previous_post = get_previous_post();
		$next_post = get_next_post();
		if ( $dp_options['show_next_post_news'] && ( $previous_post || $next_post ) ) :
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
		if ( $dp_options['show_recent_news'] ) :
			$args = array(
				'post_type' => $dp_options['news_slug'],
				'post_status' => 'publish',
				'post__not_in' => array( $post->ID ),
				'posts_per_page' => $dp_options['recent_news_num']
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
?>
			<section class="p-entry__recent-news p-archive-news">
<?php
				if ( $dp_options['recent_news_headline'] ) :
?>
				<h2 class="p-headline"><?php
					echo esc_html( $dp_options['recent_news_headline'] );
					if ( $dp_options['recent_news_link_text'] ) :
						echo '<a class="p-headline__link" href="' . esc_attr( get_post_type_archive_link( $dp_options['news_slug'] ) ) . '">' . esc_html( $dp_options['recent_news_link_text'] ) . '</a>';
					endif;
				?></h2>
<?php
				endif;

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
?>
				<article class="p-archive-news__item<?php if ( $dp_options['show_thumbnail_news'] && has_post_thumbnail() ) echo ' p-archive-news__item-has_thumbnail'; ?>">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
<?php
					if ( $dp_options['show_thumbnail_news'] && has_post_thumbnail() ) :
?>
						<div class="p-archive-news__item-thumbnail">
							<div class="p-archive-news__item-thumbnail__inner p-hover-effect__image">
								<?php the_post_thumbnail( 'size1' ); ?>
							</div>
						</div>
<?php
					endif;
?>
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
				wp_reset_postdata();
?>
			</section>
<?php
			endif;
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