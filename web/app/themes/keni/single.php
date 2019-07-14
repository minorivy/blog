<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package keni
 */

get_header(); ?>

		<!--▼▼ メインコンテンツ ▼▼-->
		<main id="main" class="keni-main">
			<div class="keni-main_inner">

				<aside class="free-area free-area_before-title">
					<?php dynamic_sidebar( 'free-before-single' ); ?>
				</aside><!-- #secondary -->

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', keni_get_template_post_type() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

				<aside class="free-area free-area_after-cont">
					<?php dynamic_sidebar( 'free-after-single' ); ?>
				</aside><!-- #secondary -->

			</div><!-- .keni-main_inner -->
		</main><!-- .keni-main -->

<?php
get_sidebar();
get_footer();
