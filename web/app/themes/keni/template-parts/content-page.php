<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

?>
<?php if (! is_front_page ()): ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="" />
<?php else: ?>
<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> page type-page status-publish">
<?php endif; ?>
<div class="keni-section_wrap article_wrap">
	<div class="keni-section">

		<?php if ( is_keni_page_title() || ( is_keni_disp_sns() && is_keni_disp_sns_singler_up() ) ) : ?>
		<header class="article-header">
			<?php if ( is_keni_page_title() ): ?>
			<h1 class="entry_title" itemprop="headline"><?php the_title(); ?></h1>
			<?php endif; ?>
			<?php if ( is_keni_disp_sns() && is_keni_disp_sns_singler_up() ): ?>
			<?php get_template_part( 'template-parts/part', 'sns' ); ?>
			<?php endif; ?>
		</header><!-- .article-header -->
		<?php endif; ?>

		<div class="article-body">
			<?php

			if ( has_post_thumbnail() && keni_is_thumbnail() ) {
				$url_thumbnail = keni_get_the_post_thumbnail_url();
				$arr_image_size = keni_get_image_size ($url_thumbnail);
				?>

                <div class="article-visual" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                    <img src="<?php echo $url_thumbnail; ?>" alt="<?php echo strip_tags( get_the_title() ); ?>" />
                    <meta itemprop="url" content="<?php echo $url_thumbnail; ?>">
                    <meta itemprop="width" content="<?php echo $arr_image_size['width']; ?>">
                    <meta itemprop="height" content="<?php echo $arr_image_size['height']; ?>">
                </div>
			<?php } ?>
            <?php the_content();?>
		</div><!-- .article-body -->
		<?php
		$tags_list = get_the_tags();
		if ( is_array( $tags_list ) && count( $tags_list ) > 0 ) : ?>
            <div class="post-tag">
                <dl>
                    <dt><?php _e('Tags', 'keni'); ?></dt>
                    <dd>
                        <ul>
							<?php
							$tags = get_the_tags();
							foreach ( (array)$tags as $tag ) {
								$style_a = '';
								$style_li = '';
								// category | tag Color
								if ( function_exists( "get_term_meta" ) ) {
									// wordpress 4.4.0以降
									$str_get_text_color_term = get_term_meta( $tag->term_id, "keni_text_color_term", true );
									$str_get_background_color_term = get_term_meta( $tag->term_id, "keni_background_color_term", true );
								}
								else {
									$str_get_text_color_term = get_option( "keni_text_color_term_" . $tag->term_id );
									$str_get_background_color_term = get_option( "keni_background_color_term_" . $tag->term_id );
								}

								if ( ! empty( $str_get_text_color_term ) ) {
									$style_a = ' style="color: ' . $str_get_text_color_term . ';"';
								}
								if ( ! empty( $str_get_background_color_term ) ) {
									$style_li = ' style="background-color: ' . $str_get_background_color_term . ';"';
								}
								?>
                                <li <?php echo $style_li; ?>>
                                    <a href="<?php echo get_tag_link( $tag->term_id ); ?>" <?php echo $style_a; ?> rel="tag"><?php echo $tag->name; ?></a>
                                </li>
								<?php
							}
							?>
                        </ul>
                    </dd>
                </dl>
            </div>
		<?php endif; ?>

		<?php the_keni_relation(); ?>

    </div><!-- .keni-section -->
</div><!-- .keni-section_wrap -->

<?php
	wp_link_pages( array(
		'before' => '<div class="page-nav"><ol><li>',
		'after'  => '</li></ol></div>',
		'separator' => '</li><li>'
	) );
?>


<div class="behind-article-area">
	<div class="keni-section_wrap keni-section_wrap_style02">
		<div class="keni-section">
		<?php if ( is_keni_disp_sns() && is_keni_disp_sns_singler_down() ): ?>
		<?php get_template_part( 'template-parts/part', 'sns' ); ?>
		<?php endif; ?>
		</div>
	</div>
</div><!-- .behind-article-area -->

</article><!-- #post-## -->
