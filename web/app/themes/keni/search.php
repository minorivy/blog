<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package keni
 */

get_header(); ?>
		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">
				<div class="archive_title_wrap">
					<h1 class="archive_title"><?php printf( esc_html__( 'Search Results for: %s', 'keni' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</div>

				<aside class="free-area free-area_before-title">
					<?php dynamic_sidebar( 'free-before-archive' ); ?>
				</aside><!-- #secondary -->

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
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			echo '</div>';
			echo '</div>';
			echo '</div>';

			keni_pagenation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</div><!--keni-main_inner-->
	</main><!--keni-main-->

<?php get_sidebar(); ?>

	<!--▲▲ メインコンテンツ ▲▲-->

<?php
get_footer();
