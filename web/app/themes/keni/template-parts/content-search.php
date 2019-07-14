<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>">
	<div class="entry">
		<?php if( has_post_thumbnail() ) { ?>
		<figure class="entry_thumb">
			<a href="<?php the_permalink(); ?>"><img src="<?php keni_the_post_thumbnail_url(); ?>" alt="<?php echo strip_tags( get_the_title() ); ?>" /></a>
		</figure>
		<?php } ?>
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

