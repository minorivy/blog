<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

get_header(); ?>

		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">
				<?php if ( is_home() || ( is_front_page() && is_keni_disp_sns() ) ) : ?>
				<header>
					<?php if ( is_home() ): ?>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					<?php endif; ?>
					<?php if ( is_keni_disp_sns() ): ?>
					<aside class="sns-btn_wrap sns-btn_wrap_s">
                        <?php
                        keni_get_sns( '', '', true );
                        ?>
					</aside>
					<?php endif; ?>
				</header>
				<?php endif; ?>

				<?php if ( is_front_page() ) : ?>
				<aside class="free-area free-area_before-title">
					<?php dynamic_sidebar( 'free-before-top' ); ?>
				</aside><!-- #secondary -->
				<?php endif; ?>
		<?php if ( have_posts() ) :

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
				if ( is_archive() || is_home() ) {
					get_template_part( 'template-parts/content', 'archive' );
				} else {
					get_template_part( 'template-parts/content', get_post_format() );
				}

			endwhile;

			echo '</div>';
			echo '</div>';
			echo '</div>';

			keni_pagenation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
			<?php if ( is_front_page() ) : ?>
			<aside class="free-area free-area_after-cont">
				<?php dynamic_sidebar( 'free-after-top' ); ?>
			</aside><!-- #secondary -->
			<?php endif; ?>
		</div><!--keni-main_inner-->
	</main><!--keni-main-->

<?php get_sidebar(); ?>

	<!--▲▲ メインコンテンツ ▲▲-->

<?php

get_footer();
