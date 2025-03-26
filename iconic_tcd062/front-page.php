
<?php


$dp_options = get_design_plus_option();
$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/index-slider' );

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

// コンテンツビルダー
if ( ! empty( $dp_options['contents_builder'] ) ) :
	foreach ( $dp_options['contents_builder'] as $key => $cb_content ) :
		$cb_index = 'cb_' . $key;
		if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

		// 最新ブログ記事一覧
		if ( 'blog' == $cb_content['cb_content_select'] ) :
			$cb_color = null;
			$cb_category = null;
			$cb_archive_url = null;

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $cb_content['cb_post_num'],
				'ignore_sticky_posts' => true
			);

			if ( 'recommend_post' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'recommend_post';
				$args['meta_value'] = 'on';
			elseif ( 'recommend_post2' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'recommend_post2';
				$args['meta_value'] = 'on';
			elseif ( 'pickup_post' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'pickup_post';
				$args['meta_value'] = 'on';
			elseif ( 'category' == $cb_content['cb_list_type'] && $cb_content['cb_category'] ) :
				$cb_category = get_category( $cb_content['cb_category'] );
			endif;
			if ( $cb_category && ! is_wp_error( $cb_category ) ) :
				$args['cat'] = $cb_category->term_id;
			else :
				$cb_category = null;
			endif;

			if ( 'random' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'rand';
			elseif ( 'date2' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'date';
				$args['order'] = 'ASC';
			else :
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
			endif;

			if ( $cb_content['cb_exclude_item'] && is_welcart_active() ) :
				global $usces;
				$args['post__not_in'] = $usces->getItemIds( 'front' );
			endif;

			if ( $cb_content['cb_show_archive_link'] && $cb_content['cb_archive_link_text'] ) :
				if ( $cb_category ) :
					$cb_archive_url = get_category_link( $cb_category );
				elseif ( 'all' == $cb_content['cb_list_type'] ) :
					$cb_archive_url = get_post_type_archive_link( 'post' );
				endif;
			endif;

			$cb_query = new WP_Query( $args );
			if ( $cb_query->have_posts() ) :
?>
			<div id="cb_<?php echo esc_attr( $key + 1 ); ?>" class="p-cb__item p-cb__item--<?php
				echo esc_attr( $cb_content['cb_content_select'] );
				if ( $cb_content['cb_background_color'] && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) echo ' has-bg';
			?>">
<?php
				if ( $cb_content['cb_headline'] || $cb_content['cb_desc'] || $cb_archive_url ) :
?>
				<div class="p-cb__item-header p-cb__item-header--flex">
<?php
					if ( $cb_content['cb_headline'] ) :
?>
					<h2 class="p-cb__item-headline"><?php echo esc_html( $cb_content['cb_headline'] ); ?></h2>
<?php
					endif;
					if ( $cb_content['cb_desc'] ) :
?>
					<p class="p-cb__item-desc"><?php echo esc_html( $cb_content['cb_desc'] ); ?></p>
<?php
					endif;
					if ( $cb_archive_url ) :
?>
					<div class="p-cb__item-archive-link u-hidden-sm">
						<a class="p-cb__item-archive-link__button p-button" href="<?php echo esc_url( $cb_archive_url ); ?>"><span><?php echo esc_html( $cb_content['cb_archive_link_text'] ); ?></span></a>
					</div>
<?php
					endif;
?>
				</div>
<?php
				endif;
?>
				<div class="p-blog-archive">
<?php
				while ( $cb_query->have_posts() ) :
					$cb_query->the_post();
					$usces_is_item = false;
					if ( function_exists( 'usces_the_item' ) ) :
						usces_the_item();
						$usces_is_item = usces_is_item() && usces_have_skus();
					endif;
?>
					<article class="p-blog-archive__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
<?php
					echo "\t\t\t\t\t\t\t\t";
					if ( $usces_is_item && usces_the_itemImageURL( 0, 'return' ) ) :
						usces_the_itemImage( 0, 740, 460 );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size3' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-740x460.gif" alt="">';
					endif;
					if ( $usces_is_item && ! usces_have_zaiko_anyone() ) :
						echo '<div class="p-article__thumbnail-soldout u-visible-sm"><span class="p-article__soldout">'. __( 'Sold Out', 'tcd-w' ) . '</span></div>';
					endif;
					echo "\n";
?>
							</div>
							<h3 class="p-blog-archive__item-title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 82 : 108, '...' ); ?></h3>
<?php
					if ( $usces_is_item ) :
						echo "\t\t\t\t\t\t\t";
						echo '<p class="p-blog-archive__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
						if ( ! usces_have_zaiko_anyone() ) :
							echo '<span class="p-blog-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
						endif;
						echo '</p>';
					endif;

					if ( $dp_options['show_date'] || $cb_content['cb_show_category'] ) :
						echo "\t\t\t\t\t\t\t";
						echo '<p class="p-blog-archive__item-meta p-article__meta">';
						if ( ! $usces_is_item && $dp_options['show_date'] ) :
							echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
						endif;
						if ( $cb_content['cb_show_category'] ) :
							if ( $usces_is_item ) :
								$categories = array( get_welcart_category() );
							else :
								$categories = get_the_category();
							endif;
							if ( $categories && ! is_wp_error( $categories ) ) :
								echo '<span class="p-article__category" data-url="' . get_category_link( $categories[0] ) . '">' . esc_html( $categories[0]->name ) . '</span>';
							endif;
						endif;
						echo "</p>\n";
					endif;
?>
						</a>
					</article>
<?php
				endwhile;
?>
				</div>
<?php
				if ( $cb_archive_url ) :
?>
				<div class="p-cb__item-archive-link u-visible-sm">
					<a class="p-cb__item-archive-link__button p-button" href="<?php echo esc_url( $cb_archive_url ); ?>"><?php echo esc_html( $cb_content['cb_archive_link_text'] ); ?></a>
				</div>
<?php
				endif;
?>
			</div>
<?php
			endif;

		// バナー
		elseif ( 'banner' == $cb_content['cb_content_select'] ) :
			$image = wp_get_attachment_image_src( $cb_content['cb_image'], 'full' );

			if ( ! empty( $image[0] ) || $cb_content['cb_headline'] || $cb_content['cb_desc'] || $cb_content['cb_button_label'] ) :
?>
			<div id="cb_<?php echo esc_attr( $key + 1 ); ?>" class="p-cb__item p-cb__item--<?php
				echo esc_attr( $cb_content['cb_content_select'] );
				if ( $cb_content['cb_background_color'] && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) echo ' has-bg';
			?>">
<?php
				if ( $cb_content['cb_url'] && ! empty( $image[0] ) && ! $cb_content['cb_button_label'] ) :
?>
				<a class="p-index-banner p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?> has-image" href="<?php echo esc_attr( $cb_content['cb_url'] ); ?>"<?php if ( $cb_content['cb_target_blank'] ) echo ' target="_blank"'; ?>>
<?php
				else :
?>
				<div class="p-index-banner<?php if ( ! empty( $image[0] ) ) echo ' has-image'; ?>">
<?php
				endif;

				if ( ! empty( $image[0] ) ) :
?>
					<div class="p-index-banner__image p-hover-effect__image"><img src="<?php echo esc_attr( $image[0] ); ?>" alt=""></div>
<?php
				endif;

				if ( $cb_content['cb_desc'] || $cb_content['cb_headline'] || $cb_content['cb_button_label']) :
?>
					<div class="p-index-banner__content">
						<div class="p-index-banner__content__inner">
<?php
					if ( $cb_content['cb_desc'] ) :
?>
							<p class="p-index-banner__desc"><?php echo esc_html( $cb_content['cb_desc'] ); ?></p>
<?php
					endif;

					if ( $cb_content['cb_headline'] ) :
?>
							<h2 class="p-index-banner__headline"><?php echo esc_html( $cb_content['cb_headline'] ); ?></h2>
<?php
					endif;

					if ( $cb_content['cb_button_label'] && $cb_content['cb_url'] ) :
?>
							<a class="p-index-banner__button p-button" href="<?php echo esc_attr( $cb_content['cb_url'] ); ?>"<?php if ( $cb_content['cb_target_blank'] ) echo ' target="_blank"'; ?>><span><?php echo esc_html( $cb_content['cb_button_label'] ); ?></span></a>
<?php
					elseif ( $cb_content['cb_button_label'] ) :
?>
							<div class="p-index-banner__button p-button"><span><?php echo esc_html( $cb_content['cb_button_label'] ); ?></span></div>
<?php
					endif;
?>
						</div>
					</div>
<?php
				endif;

				if ( $cb_content['cb_url'] && ! empty( $image[0] ) && ! $cb_content['cb_button_label'] ) :
?>
				</a>
<?php
				else :
?>
				</div>
<?php
				endif;
?>
			</div>
<?php
			endif;

		// 3点ボックス
		elseif ( 'three_boxes' == $cb_content['cb_content_select'] ) :
			$three_boxes_images = array();

			for ( $i = 1; $i <=3; $i++ ) :
				$image = wp_get_attachment_image_src( $cb_content['cb_image' . $i], 'full' );

				if ( ! empty( $image[0] ) || $cb_content['cb_headline' . $i] || $cb_content['cb_desc' . $i] ) :
					$three_boxes_images[$i] = $image;
				endif;
			endfor;

			if ( $three_boxes_images ) :
?>
			<div id="cb_<?php echo esc_attr( $key + 1 ); ?>" class="p-cb__item p-cb__item--<?php
				echo esc_attr( $cb_content['cb_content_select'] );
				if ( $cb_content['cb_background_color'] && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) echo ' has-bg';
			?>">
				<div class="p-index-boxes p-index-boxes--<?php echo count( $three_boxes_images ); ?>">
<?php
				foreach ( $three_boxes_images as $i => $image ) :
?>
					<div class="p-index-boxes__item p-index-boxes__item--<?php echo $i; ?><?php if ( ! empty( $image[0] ) ) echo ' has-image'; ?>">
<?php
					if ( $cb_content['cb_url' . $i] ) :
?>
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $cb_content['cb_url' . $i] ); ?>"<?php if ( $cb_content['cb_target_blank' . $i] ) echo ' target="_blank"'; ?>>
<?php
					endif;

					if ( $cb_content['cb_desc' . $i] || $cb_content['cb_headline' . $i] ) :?>
							<div class="p-index-boxes__item-content">
<?php
						if ( $cb_content['cb_desc' . $i] ) :
?>
								<p class="p-index-boxes__item-desc"><?php echo esc_html( $cb_content['cb_desc' . $i] ); ?></p>
<?php
						endif;

						if ( $cb_content['cb_headline' . $i] ) :
?>
								<h2 class="p-index-boxes__item-headline"><?php echo esc_html( $cb_content['cb_headline' . $i] ); ?></h2>
<?php
						endif;
?>
							</div>
<?php
					endif;

					if ( ! empty( $image[0] ) ) :
?>
							<div class="p-index-boxes__item-image p-hover-effect__image js-object-fit-cover"><img src="<?php echo esc_attr( $image[0] ); ?>" alt=""></div>
<?php
					endif;
?>
<?php
					if ( $cb_content['cb_url' . $i] ) :
?>
						</a>
<?php
					endif;
?>
					</div>
<?php
				endforeach;
?>
				</div>
			</div>
<?php
			endif;

		// カルーセル
		elseif ( 'carousel' == $cb_content['cb_content_select'] ) :
			$cb_color = null;
			$cb_category = null;
			$cb_archive_url = null;
			$cb_archive_label = null;

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $cb_content['cb_post_num'],
				'ignore_sticky_posts' => true
			);

			if ( $cb_content['cb_category'] ) :
				$cb_category = get_category( $cb_content['cb_category'] );
			endif;
			if ( $cb_category && ! is_wp_error( $cb_category ) ) :
				$args['cat'] = $cb_category->term_id;
			else :
				$cb_category = null;
			endif;

			if ( 'random' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'rand';
			elseif ( 'date2' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'date';
				$args['order'] = 'ASC';
			else :
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
			endif;

			if ( $cb_content['cb_show_archive_link']) :
				if ( $cb_category ) :
					$cb_archive_url = get_category_link( $cb_category );
					if ( $cb_content['cb_archive_link_text'] ) :
						$cb_archive_label = $cb_content['cb_archive_link_text'];
					else :
						$cb_archive_label = $cb_category->name;
					endif;
				elseif ( $cb_content['cb_archive_link_text'] ) :
					$cb_archive_url = get_post_type_archive_link( 'post' );
					$cb_archive_label = $cb_content['cb_archive_link_text'];
				endif;
			endif;

			$cb_query = new WP_Query( $args );
			if ( $cb_query->have_posts() ) :
?>
			<div id="cb_<?php echo esc_attr( $key + 1 ); ?>" class="p-cb__item p-cb__item--<?php
				echo esc_attr( $cb_content['cb_content_select'] );
				if ( $cb_content['cb_background_color'] && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) echo ' has-bg';
			?>">
<?php
				if ( $cb_content['cb_headline'] || $cb_archive_url ) :
?>
				<div class="p-cb__item-header">
<?php
					if ( $cb_content['cb_headline'] ) :
?>
					<h2 class="p-cb__item-headline"><?php echo esc_html( $cb_content['cb_headline'] ); ?></h2>
<?php
					endif;
					if ( $cb_archive_url ) :
?>
					<a class="p-cb__item-archive-button" href="<?php echo esc_url( $cb_archive_url ); ?>"><?php echo esc_html( $cb_archive_label ); ?></a>
<?php
					endif;
?>
				</div>
<?php
				endif;
?>
				<div class="p-index-carousel" data-slide-time="<?php echo esc_attr( $cb_content['cb_slide_time'] ); ?>">
<?php
				while ( $cb_query->have_posts() ) :
					$cb_query->the_post();
					$usces_is_item = false;
					if ( function_exists( 'usces_the_item' ) ) :
						usces_the_item();
						$usces_is_item = usces_is_item() && usces_have_skus();
					endif;
?>
					<article class="p-index-carousel__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-index-carousel__item-thumbnail p-hover-effect__image js-object-fit-cover">
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
							<h3 class="p-index-carousel__item-title p-article__title"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, is_mobile() ? 34 : 62, '...' ); ?></h3>
<?php
					if ( $usces_is_item ) :
						echo "\t\t\t\t\t\t\t";
						echo '<p class="p-index-carousel__item-price p-article__price">' . usces_the_itemPriceCr( 'return' ) . usces_guid_tax( 'return' );
						if ( ! usces_have_zaiko_anyone() ) :
							echo '<span class="p-blog-archive__item-soldout p-article__soldout u-hidden-sm">'. __( 'Sold Out', 'tcd-w' ) . '</span>';
						endif;
						echo '</p>';
					endif;
?>
						</a>
					</article>
<?php
				endwhile;
?>
				</div>
			</div>
<?php
			endif;

		// フリースペース
		elseif ( 'wysiwyg' == $cb_content['cb_content_select'] ) :
			$cb_wysiwyg_editor = apply_filters( 'the_content', $cb_content['cb_wysiwyg_editor'] );
			if ( $cb_wysiwyg_editor ) :
?>
			<div id="cb_<?php echo esc_attr( $key + 1 ); ?>" class="p-cb__item p-cb__item--<?php
				echo esc_attr( $cb_content['cb_content_select'] );
				if ( $cb_content['cb_background_color'] && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) echo ' has-bg';
			?>">
				<div class="p-entry__body">
				
				
				
<div style="text-align:right;margin-left: auto;margin-right: auto;width: 80%;max-width: 1000px;">
<?php echo date('Y年m月d日', strtotime('-1day')); ?>の商談成立</div>

<div class="text-ani_sample">
    <p><span id="yesterdayresult"></span></p>
</div>

					<div id="parent">
					<div id="child1">
					<video src="movie2.mp4" autoplay="" loop="" muted="" playsinline="" __idm_id__="4308993"></video>
					</div>
					<div id="child2">
					<div class="topform">
					<form action="/pref" method="post">商談したい相手の役職<br>
					<select name="position" required=""><option>選択してください。</option><option value="1">代表取締役、代表者のみ</option><option value="2">取締役以上全て</option></select><br>
					×<br>
					商談したい相手のエリア<br>
					<select name="talkpref" required=""><option>選択してください。</option><option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option></select><input style="height: auto" class="submit" name="" type="submit" value="この条件で検索"><br>
					</form>
					</div>

					</div>
					
					
					</div>
									</div>
			</div>
<?php
			endif;
		endif;

	endforeach;

	wp_reset_postdata();
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