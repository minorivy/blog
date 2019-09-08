<?php

function aytc_scripts() {
	wp_dequeue_style('my-keni_base_default');
	wp_dequeue_style('keni-style-css');
}
add_action('wp_print_styles', 'aytc_scripts');
