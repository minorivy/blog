<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

get_header(); ?>

		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">

				<aside class="free-area free-area_before-title">
				<?php if ( is_front_page() ) : ?>
					<?php dynamic_sidebar( 'free-before-top' ); ?>
				<?php else : ?>
					<?php dynamic_sidebar( 'free-before-single' ); ?>
				<?php endif ?>
				</aside><!-- #secondary -->

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

				<aside class="free-area free-area_after-cont">
				<?php if ( is_front_page() ) : ?>
					<?php dynamic_sidebar( 'free-after-top' ); ?>
				<?php else : ?>
					<?php dynamic_sidebar( 'free-after-single' ); ?>
				<?php endif ?>
				</aside><!-- #secondary -->

			</div><!-- .keni-main_inner -->
		</main><!-- .keni-main -->

<?php
get_sidebar();
get_footer();
