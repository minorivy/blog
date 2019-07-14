<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package keni
 */

get_header(); ?>

		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">

				<div class="keni-section_wrap">
					<div class="keni-section">
						<header class="article-header">
							<h1 class="entry_title">お探しのページは見つかりませんでした。</h1>
						</header>

						<div class="article-body">
							<p class="m10-b">お探しのページはアドレスが変更になったか、削除された可能性があります。<br>お手数をおかけしますが、以下の検索フォームからサイト内を検索するか、トップページからお探しのページへアクセスいただきますよう、お願いいたします。</p>
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>


				<div class="keni-section_wrap keni-section_wrap_style02">
					<div class="keni-section">
						<div class="article-body">
							<h2 class="m10-b">最近の記事</h2>
							<?php

							// The Query
							$args = array(
								'post_type' => 'post',
								'posts_per_page' => 5
							);
							$the_query = new WP_Query( $args );

							// The Loop
							if ( $the_query->have_posts() ) {
								echo '<ul class="related-entry-list related-entry-list_style01">';
								while ( $the_query->have_posts() ) {
									$the_query->the_post();
								?>
									<li class="related-entry-list_item">
										<figure class="related-entry_thumb">
											<a href="<?php the_permalink(); ?>"><img src="<?php keni_the_post_thumbnail_url(); ?>" width="150" alt="<?php echo strip_tags( get_the_title() ); ?>" /></a>
										</figure>
										<p class="related-entry_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
									</li>
								<?php
								}
								echo '</ul>';
							} else {
								// no posts found
							}
							/* Restore original Post Data */
							wp_reset_postdata();
							?>
						</div>
					</div>
				</div>
			</div>
		</main><!-- #main -->

<?php
get_sidebar();
get_footer();
