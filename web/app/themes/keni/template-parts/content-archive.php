<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>">
	<div class="entry">
		<figure class="entry_thumb">
			<a href="<?php the_permalink(); ?>">
				<?php if( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail(); ?>
				<?php else: ?>
				<img src="<?php echo get_template_directory_uri() . "/images/no-image.jpg"; ?>">
				<?php endif; ?>
				</a>
		</figure>
		<div class="entry_inner">
			<h2 class="entry_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php get_template_part( 'template-parts/part', 'entry_status' ); ?>

			<div class="entry_description">
			<?php echo strip_tags( get_the_excerpt() ); ?>
			</div>
			<div class="ently_read-more">
				<a href="<?php the_permalink(); ?>" class="btn dir-arw_r"><span class="icon_arrow_s_right"></span><?php _e( 'Read More', 'keni' ); ?></a>
			</div>
		</div>
		<?php if ( is_keni_disp_sns_posts_list() ): ?>
		<?php get_template_part( 'template-parts/part', 'sns' ); ?>
		<?php endif; ?>
	</div>
</article>
