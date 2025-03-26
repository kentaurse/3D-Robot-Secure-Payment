<?php
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
		<article class="p-entry p-entry-page <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
<?php
		if ( has_post_thumbnail() ) :
			echo "\t\t\t<div class=\"p-entry__thumbnail\">";
			the_post_thumbnail( 'size5' );
			echo "</div>\n";
		endif;
?>
			<div class="p-entry__body p-entry-page__body">
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
		</article>
<?php
	endwhile;

	if ( $active_sidebar ) :
		get_sidebar();
?>
	</div>
<?php
	endif;
endif;
?>
</main>
<?php get_footer(); ?>
