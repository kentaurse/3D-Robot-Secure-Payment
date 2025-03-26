<?php
global $post, $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
$breadcrumb_position = 1;
?>
	<div class="p-breadcrumb c-breadcrumb">
		<ul class="p-breadcrumb__inner c-breadcrumb__inner l-inner" itemscope itemtype="http://schema.org/BreadcrumbList">
			<li class="p-breadcrumb__item c-breadcrumb__item p-breadcrumb__item--home c-breadcrumb__item--home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="item"><span itemprop="name">HOME</span></a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
if ( is_welcart_member_page() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_welcart_member_page_filterd_title() ); ?></span>
			</li>
<?php
elseif ( is_welcart_archive() ) :
	$ancestors = get_ancestors( get_query_var( 'cat' ), 'category' );
	if ( $ancestors ) :
		foreach( array_reverse( $ancestors ) as $category_id ) :
			$category = get_term_by( 'id', $category_id, 'category' );
			if ( empty( $category->name ) || 'itemgenre' == $category->slug ) continue;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
		endforeach;
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_welcart_single() ) :
	if ( defined( 'USCES_ITEM_CAT_PARENT_ID' ) ) :
		$category = get_category( (int) USCES_ITEM_CAT_PARENT_ID );
		if ( $category ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
		endif;
	endif;

	$category = get_welcart_category();
	if ( $category ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_post_type_archive( $dp_options['news_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( $dp_options['news_breadcrumb_label'] ); ?></span>
			</li>
<?php
elseif ( is_singular( $dp_options['news_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( $dp_options['news_slug'] ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['news_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_author() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ); ?></span>
			</li>
<?php
elseif ( is_category() ) :
	if ( ! is_welcart_archive() && $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;

	$ancestors = get_ancestors( get_query_var( 'cat' ), 'category' );
	if ( $ancestors ) :
		foreach( array_reverse( $ancestors ) as $category_id ) :
			$category = get_term_by( 'id', $category_id, 'category' );
			if ( empty( $category->name ) ) continue;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
		endforeach;
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_tag() ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_tag_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_search() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php _e( 'Search result', 'tcd-w' ); ?></span>
			</li>
<?php
elseif ( is_year() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_month() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F, Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_day() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F jS, Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_home() ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
			</li>
<?php
	endif;
elseif ( is_page() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_singular( 'post' ) ) :
	if ( ! is_welcart_single() && $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
	$categories = get_the_category();
	if ( $categories ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<?php
		foreach ( $categories as $key => $category ) :
			if ( 0 !== $key ) :
				echo ', ';
			endif;
?>
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
<?php
		endforeach;
?>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_404() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php _e( "Sorry, but you are looking for something that isn't here.", 'tcd-w' ); ?></span>
			</li>
<?php
endif;
?>
		</ul>
	</div>
