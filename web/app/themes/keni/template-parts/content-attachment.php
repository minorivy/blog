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
			<?php get_template_part( 'template-parts/part', 'sns' ); ?>
		</header><!-- .article-header -->

		<div class="article-body" itemprop="articleBody">
			<?php

			if ( has_post_thumbnail() && keni_is_thumbnail() ) {
			?>

			<div class="article-visual" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo strip_tags( get_the_title() ); ?>" />
				<meta itemprop="url" content="<?php the_post_thumbnail_url(); ?>">
				<meta itemprop="width" content="1200">
				<meta itemprop="height" content="630">
			</div>
			<?php } ?>

			<?php the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'samplename_themename' ),
				'after'  => '</div>',
			) );

			?>


		</div><!-- .article-body -->
	</div><!-- .keni-section -->
</div><!-- .keni-section_wrap -->

<div class="behind-article-area">

<div class="keni-section_wrap keni-section_wrap_style02">
	<div class="keni-section">

<?php get_template_part( 'template-parts/part', 'sns' ); ?>


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
		<p class="link-next link-author-list"><a href="<?php echo get_author_posts_url( $author_id ); ?>">執筆記事一覧</a></p>
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