<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

?>
<article <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" />

<div class="keni-section_wrap article_wrap">
	<div class="keni-section">

		<header class="article-header">
			<h1 class="entry_title" itemprop="headline"><?php the_title(); ?></h1>
			<?php get_template_part( 'template-parts/part', 'entry_status' ); ?>
			<?php if ( is_keni_disp_sns() && is_keni_disp_sns_singler_up() ): ?>
			<?php get_template_part( 'template-parts/part', 'sns' ); ?>
			<?php endif; ?>
		</header><!-- .article-header -->

		<div class="article-body" itemprop="articleBody">
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

			<?php the_content();

			?>

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
<?php dynamic_sidebar('free-cta'); ?>

<?php if ( keni_author_disp() ) : ?>
<section class="profile-box">

<?php
	$author_id = get_the_author_meta('ID');
	$obj_author = get_userdata($author_id);

?>
<h2 class="profile-box-title"><?php _e( 'About Auther', 'keni' ); ?></h2>
<div class="profile-box_in">
	<figure class="profile-box-thumb">
		<?php echo keni_get_avatar(); ?>
		<div class="sns-follow-btn">
			<?php
           $author_meta_url =  get_the_author_meta( 'user_url', $author_id );
           $user_meta_tw = get_user_meta( $author_id, 'keni_twitter', true );
           $user_meta_fb = get_user_meta( $author_id, 'keni_facebook', true );
           $user_meta_ins = get_user_meta( $author_id, 'keni_instagram', true );
            if ( ! empty( $author_meta_url ) ) : ?>
			<div class="sns-follow-btn_ws"><a href="<?php echo $author_meta_url; ?>"><i class="fas fa-home" aria-hidden="true"></i></a></div>
			<?php endif; ?>
			<?php if ( ! empty( $user_meta_tw ) ) : ?>
			<div class="sns-follow-btn_tw"><a href="<?php echo $user_meta_tw; ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></div>
			<?php endif; ?>
			<?php if ( ! empty( $user_meta_fb ) ) : ?>
			<div class="sns-follow-btn_fb"><a href="<?php echo $user_meta_fb; ?>"><i class="fab fa-facebook" aria-hidden="true"></i></a></div>
			<?php endif; ?>
			<?php if ( ! empty( $user_meta_ins ) ) : ?>
			<div class="sns-follow-btn_insta"><a href="<?php echo $user_meta_ins; ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></div>
			<?php endif; ?>
		</div>
	</figure>
	<h3 class="profile-box-author" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php echo esc_html( $obj_author->display_name ); ?></span></h3>
	<?php if ( $obj_author->description ) : ?>
	<div class="profile-box-desc">
		<?php the_author_meta( 'description' ); ?>
		<p class="link-next link-author-list"><a href="<?php echo get_author_posts_url( $author_id ); ?>"><?php _e( 'Auther\'s Posts', 'keni' ); ?></a></p>
	</div>
	<?php endif; ?>
</div><!--profile-box_in-->

</section><!--profile-box-->
<?php endif; ?>

		<?php the_keni_relation(); ?>
		<?php the_post_navigation( array('in_same_term'=>'true', 'taxonomy'=>'category') ); ?>

	</div>
</div>
</div><!-- .behind-article-area -->

</article><!-- #post-## -->

<?php do_action( 'keni_post_after' ); ?>