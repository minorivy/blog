<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package keni
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php html_class(); ?>>
<head>
<?php do_action( 'keni_head_prepend' ); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>><!--ページの属性-->
<?php do_action( 'keni_body_before' ); ?>

<div id="top" class="keni-container">

<!--▼▼ ヘッダー ▼▼-->
<div class="keni-header_wrap">
	<div class="keni-header_outer">
		<?php
		$str_layout_header_name = get_keni_layout_header_name();
		get_template_part( 'keni-html-parts/keni', $str_layout_header_name );
		?>
	</div><!--keni-header_outer-->
</div><!--keni-header_wrap-->
<!--▲▲ ヘッダー ▲▲-->

<div id="click-space"></div>

<?php if( has_nav_menu( 'gnav' ) && is_keni_layout_front_navigation() ) { ?>
<!--▼▼ グローバルナビ ▼▼-->
<div class="keni-gnav_wrap">
	<div class="keni-gnav_outer">
		<nav class="keni-gnav">
			<div class="keni-gnav_inner">

				<ul id="menu" class="keni-gnav_cont">
				<?php
					wp_nav_menu( array( 
						'theme_location'	=> 'gnav',
						'menu_id'			=> 'gnav',
						'menu_class'		=> 'gnav',
						'container'			=> '',
						'items_wrap'		=> '%3$s',
					) );
				?>
				<li class="menu-search"><?php get_search_form(); ?></li>
				</ul>
			</div>
			<div class="keni-gnav_btn_wrap">
				<div class="keni-gnav_btn"><span class="keni-gnav_btn_icon-open"></span></div>
			</div>
		</nav>
	</div>
</div>
<?php } ?>

<?php
	// Main visual
	if( is_front_page() && is_home() || is_front_page() ) {
		get_template_part( 'keni-html-parts/keni', 'main_visual' );
	}
?>


<div class="keni-main_wrap">
	<div class="keni-main_outer">
