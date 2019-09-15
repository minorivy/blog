<?php

/**
 * remove unneccesary styles and scripts
 */
function mnr_scripts() {
	is_admin() || wp_dequeue_style('wp-block-library');
	wp_dequeue_style('my-keni_base_default');
	wp_dequeue_style('keni-style');
}
add_action('wp_print_styles',  'mnr_scripts');
