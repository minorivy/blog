<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

get_header(); ?>
		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">
				<div class="archive_title_wrap">
					<?php the_archive_title( '<h1 class="archive_title">', '</h1>' ); ?>
				</div>

				<aside class="free-area free-area_before-title">
					<?php dynamic_sidebar( 'free-before-archive' ); ?>
				</aside><!-- #secondary -->

				<?php if( is_category() || is_tag() ): ?>
				<?php
					$term_id = get_queried_object();
					if ( is_object( $term_id ) ) {
						$term_id = $term_id->term_id;
					}
				?>
				<?php if( is_keni_disp_sns() ): ?>
				<aside class="sns-btn_wrap sns-btn_wrap_s">
                    <?php
                    keni_get_sns( esc_attr( get_term_link( $term_id ) ), get_the_archive_title(), true );
                    ?>
				</aside>
				<?php endif; ?>

				<?php

					if ( get_the_archive_description() && !is_paged() ) {
						echo '<div class="keni-section_wrap">';
						echo '<div class="keni-section entry">';
						echo '<div class="article-body">';
						echo get_the_archive_description();
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
				?>
				<?php endif; ?>
		<?php
		if ( have_posts() ) :

			echo '<div class="keni-section_wrap keni-section_wrap_style02">';
			echo '<div class="keni-section">';
			echo '<div class="entry-list ' . get_keni_layout_post_list_class() . '">';

			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'archive' );

			endwhile;

			echo '</div>';
			echo '</div>';
			echo '</div>';

			keni_pagenation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

			<aside class="free-area free-area_after-cont">
				<?php dynamic_sidebar( 'free-after-archive' ); ?>
			</aside><!-- #secondary -->
		</div><!--keni-main_inner-->
	</main><!--keni-main-->

<?php get_sidebar(); ?>

	<!--▲▲ メインコンテンツ ▲▲-->

<?php
get_footer();
