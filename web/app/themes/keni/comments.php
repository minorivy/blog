<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package keni
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>


<div class="keni-section_wrap keni-section_wrap_style02">
	<section id="comments" class="comments-area keni-section">

<?php if ( have_comments() ) : ?>

<?php
	$comment_count = get_comments_number();
?>

<h2 id="comments" class="comment-form-title">&#8220;<?php the_title(); ?>&#8221; への<?php echo $comment_count; ?>件のフィードバック</h2>
<ol class="commentlist">
	<?php
		wp_list_comments( array(
			'style'      => 'ol',
			'short_ping' => true,
		) );
	?>
</ol><!-- .comment-list -->
<?php if (get_previous_comments_link() != "" || get_next_comments_link() != ""): ?>
<nav class="page-nav">
	<ol>
	<?php if ( get_previous_comments_link() != "" ) : ?>
		<li class="page-nav_prev"><?php echo get_previous_comments_link( __('Previous Comments', 'keni') ) ; ?></li>
	<?php endif; ?>
	<?php if ( get_next_comments_link() != "" ) : ?>
		<li class="page-nav_next"><?php echo get_next_comments_link( __('Next Comments', 'keni') ); ?></li>
	<?php endif; ?>
	</ol>
</nav>
<?php endif; ?>
<?php endif; ?>

<?php
	if ( $req ) {
		$aria_req = 'aria-required="true" required="required"';
	} else {
		$aria_req = '';
	}
	$comment_args = array(
		'fields' => array(
			'author' => '<div class="comment-form-author"><p class="comment-form_item_title"><label for="author"><small>' . __( 'Name' ) . ( $req ? ' <span class="required">必須</span>' : '' ) . '</small></label></p><p class="comment-form_item_input"><input id="author" class="w60" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></p></div>',
			'email'  => '<div class="comment-form-email comment-form-mail"><p class="comment-form_item_title"><label for="email"><small>' . __( 'Email' ) . '（公開されません）' . ( $req ? ' <span class="required">必須</span>' : '' ) . '</small></label></p><p class="comment-form_item_input"><input id="email" class="w60" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></p></div>',
			'url'    => '<div class="comment-form-url"><p class="comment-form_item_title"><label for="url"><small>' . __( 'Website' ) . '</small></label></p><p class="comment-form_item_input"><input id="url" class="w60" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div>',
		),
		'comment_field' => '<p class="comment-form-comment comment-form_item_title"><label for="comment"><small>' . _x( 'Comment', 'noun' ) . '</small></label></p><p class="comment-form_item_textarea"><textarea id="comment" name="comment" class="w100" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
		'comment_notes_before' => '',
		'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h2>',
		'class_submit'         => 'submit btn btn-form01 dir-arw_r btn_style03',
		'submit_field'         => '<div class="form-submit al-c m20-t"><p>%1$s %2$s</p></div>',
	);
	comment_form( $comment_args );
?>
	
</section>
</div>