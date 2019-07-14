<?php
/**
 * On-the-fly CSS Compression
 * Copyright (c) 2009 and onwards, Manas Tungare.
 * Creative Commons Attribution, Share-Alike.
 *
 * In order to minimize the number and size of HTTP requests for CSS content,
 * this script combines multiple CSS files into a single file and compresses
 * it on-the-fly.
 *
 * To use this in your HTML, link to it in the usual way:
 * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
 */
/* Add your CSS files to this array (THESE ARE ONLY EXAMPLES) */



function keni_minify_css() {
    echo '<style>';
    echo keni_get_minify_css();
    echo '</style>';
}

function keni_get_minify_css() {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	WP_Filesystem();

	global $wp_filesystem;

	$path_template_directory = get_template_directory();
	$path_stylesheet_directory = get_stylesheet_directory();

	$cssFiles = array();
	$cssFiles[] = $path_template_directory . "/base.css";
	$cssFiles[] = $path_template_directory . "/advanced.css";

	if ( $path_template_directory != $path_stylesheet_directory ) {
		$cssFiles[] = $path_stylesheet_directory . "/base.css";
		$cssFiles[] = $path_stylesheet_directory . "/advanced.css";
	}

	/**
	 * Ideally, you wouldn't need to change any code beyond this point.
	 */
	$buffer = "";
	foreach ($cssFiles as $cssFile) {
		$buffer .= $wp_filesystem->get_contents( $cssFile );
	}

	// Change url for images
	$buffer = preg_replace('/\.\//', get_template_directory_uri() . '/' , $buffer);
	// Remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// Remove space after colons
	$buffer = str_replace(': ', ':', $buffer);
	// Remove whitespace
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	return $buffer;
}