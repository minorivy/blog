<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package keni
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || ! is_keni_layout_sidebar() ) {
	return;
}
?>

<aside id="secondary" class="keni-sub">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
