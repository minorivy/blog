<?php

$str_get_main_visual_type = get_option( 'keni_main_visual_type' );
if ( ! empty( $str_get_main_visual_type ) ) :

	$arr_mv_data = keni_get_main_visual_data();
?>
<?php if ( $str_get_main_visual_type == 'main-image' && ! empty( $arr_mv_data['image_html'] ) ) : ?>
<!--▼▼ メインビジュアル ▼▼-->
<div class="keni-mv_wrap<?php echo $arr_mv_data['image_class']; ?>">
	<div class="keni-mv_outer">
	<?php echo $arr_mv_data['image_html']; ?>
	</div>
</div>
<!--▲▲ メインビジュアル ▲▲-->

<?php elseif ( $str_get_main_visual_type == 'main-background' ) : ?>

<!--▼▼ メインビジュアル ▼▼-->
<div class="keni-mv_wrap keni-mv_bg<?php echo $arr_mv_data['background_class']; ?>">
	<div class="keni-mv_outer">

	<?php if ( ! empty( $arr_mv_data['content'] ) ) : ?>
	<div class="catch-area <?php echo $arr_mv_data['content_position']; ?>">
	<div class="catch-area_inner">
	<?php echo $arr_mv_data['content']; ?>
	</div>
	</div>
	<?php endif; ?>

	</div>
</div>
<!--▲▲ メインビジュアル ▲▲-->

<?php elseif ( $str_get_main_visual_type == 'main-movie' ) : ?>

<!--▼▼ メインビジュアル ▼▼-->
<div class="keni-mv_wrap keni-mv_wide">
	<div class="keni-mv_outer bg-video">
	<?php echo $arr_mv_data['movie_html']; ?>

	<?php if ( ! empty( $arr_mv_data['content'] ) ) : ?>
	<div class="catch-area">
	<div class="catch-area_inner">
	<?php echo $arr_mv_data['content']; ?>
	</div>
	</div>
	<?php endif; ?>

	</div>
</div>
<!--▲▲ メインビジュアル ▲▲-->

<?php elseif ( $str_get_main_visual_type == 'main-slider' ) : ?>

<!--▼▼ メインビジュアル ▼▼-->
<div class="keni-slider_wrap<?php echo $arr_mv_data['slider_class']; ?>"><!--wrap-->
	<div class="keni-slider_outer"><!--slides-->
		<div class="keni-slider"><!--inner-->
			<?php echo $arr_mv_data['slide_html']; ?>
		</div>
	</div>
</div>
<!--▲▲ メインビジュアル ▲▲-->

<?php elseif ( $str_get_main_visual_type == 'main-wide' ) : ?>

<!--▼▼ メインビジュアル ▼▼-->
<div class="keni-mv_wrap keni-mv_bg keni-mv_wide">
	<div class="keni-mv_outer">

	<?php if ( ! empty( $arr_mv_data['content'] ) ) : ?>
	<div class="catch-area">
	<div class="catch-area_inner">
	<?php echo $arr_mv_data['content']; ?>
	</div>
	</div>
	<?php endif; ?>

	</div>
</div>
<!--▲▲ メインビジュアル ▲▲-->

<?php endif; ?>
<?php endif; ?>
