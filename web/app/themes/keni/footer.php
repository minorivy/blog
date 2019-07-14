<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package keni
 */

?>

	</div><!--keni-main_outer-->
</div><!--keni-main_wrap-->

<?php if ( is_keni_layout_breadcrumb() ) {
	get_template_part( 'template-parts/part', 'breadcrumbs' );
} ?>


<!--▼▼ footer ▼▼-->
<div class="keni-footer_wrap">
	<div class="keni-footer_outer">
		<footer class="keni-footer">

			<div class="keni-footer_inner">
				<div class="keni-footer-cont_wrap<?php keni_the_class_footer_widget(); ?>">
					<?php if ( is_active_sidebar( 'footer-01' ) && is_keni_layout_footer01()  ) { ?>
					<div class="keni-footer-cont">
						<?php dynamic_sidebar( 'footer-01' ); ?>
					</div>
					<?php } ?>
					<?php if( is_active_sidebar( 'footer-02' ) && is_keni_layout_footer02() ) { ?>
					<div class="keni-footer-cont">
						<?php dynamic_sidebar( 'footer-02' ); ?>
					</div>
					<?php } ?>
					<?php if ( is_active_sidebar( 'footer-03' ) && is_keni_layout_footer03() ) { ?>
					<div class="keni-footer-cont">
						<?php dynamic_sidebar( 'footer-03' ); ?>
					</div>
					<?php } ?>

				</div><!--keni-section_wrap-->
			</div><!--keni-footer_inner-->
		</footer><!--keni-footer-->

		<div class="keni-copyright_wrap">
			<div class="keni-copyright">

				<small>&copy; <?php echo get_installed_year() . ' ' . get_bloginfo( 'name' ); ?></small>

			</div><!--keni-copyright_wrap-->
		</div><!--keni-copyright_wrap-->
	</div><!--keni-footer_outer-->
</div><!--keni-footer_wrap-->
<!--▲▲ footer ▲▲-->

<?php keni_sp_footerpanel() ?>

</div><!--keni-container-->

<!--▼ページトップ-->
<p class="page-top"><a href="#top"></a></p>
<!--▲ページトップ-->

<?php wp_footer(); ?>

</body>
</html>
