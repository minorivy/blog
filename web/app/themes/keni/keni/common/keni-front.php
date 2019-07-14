<?php

// post_class
add_filter( 'post_class', 'keni_post_class');
function keni_post_class( $classes ) {
	global $post;

	$classes = array_diff( $classes, array( 'hentry' ) );

	// single
	if ( is_single() && ! is_archive() ) {
		$classes[] = 'keni-section';
	}

	// archive
	if ( is_archive() || is_home() || is_search() ) {
		$classes[] = 'entry-list_item';
	}

	// 出力
	return $classes;
}


// サムネイルのURLを表示する
function keni_the_post_thumbnail_url ( $size = 'large' ) {
	echo keni_get_the_post_thumbnail_url($size);
}

// サムネイルのURLを取得する
function keni_get_the_post_thumbnail_url ( $size = 'large' ) {
	$url_return = '';
	if ( has_post_thumbnail() ) {
		$url_return = get_the_post_thumbnail_url( get_the_ID(), $size );
	} else {
		$url_return = get_stylesheet_directory_uri() . '/images/no-image.jpg';
	}
	return $url_return;
}


// ローカルに保存されている画像のサイズをURLから取得する
function keni_get_image_size ( $image_url ) {
	$arr_image_size = null;

	$wp_content_dir = WP_CONTENT_DIR;
	$wp_content_url = content_url();

	//URLをローカルパスに置換
	$path_image_file = str_replace($wp_content_url, $wp_content_dir, $image_url);
	//画像サイズを取得
	$arr_data_getimagesize = @getimagesize($path_image_file);
	if ( $arr_data_getimagesize ) {
		$arr_image_size = array();
		$arr_image_size['width'] = $arr_data_getimagesize[0];
		$arr_image_size['height'] = $arr_data_getimagesize[1];
	}
	return $arr_image_size;
}

// URLから画像の幅を取得する
function keni_get_image_width ( $image_url ) {
	$image_width = null;

	$arr_image_size = keni_get_image_size($image_url);
	if ($arr_image_size) {
		$image_width = $arr_image_size['width'];
	}

	return $image_width;
}

// URLから画像の高さを取得する
function keni_get_image_height ( $image_url ) {
	$image_height = null;

	$arr_image_size = keni_get_image_size($image_url);
	if ($arr_image_size) {
		$image_height = $arr_image_size['height'];
	}

	return $image_height;
}

// footer のクラス名を表示する
function keni_the_class_footer_widget () {
	echo keni_get_the_class_footer_widget();
}

// footer のクラス名を取得する
function keni_get_the_class_footer_widget () {
	// 空でないフッターウィジェットの数をカウントする
	$num_active_footer_widget = 0;
	$name_class = '';

	if ( is_active_sidebar( 'footer-01' ) ) $num_active_footer_widget++;
	if ( is_active_sidebar( 'footer-02' ) ) $num_active_footer_widget++;
	if ( is_active_sidebar( 'footer-03' ) ) $num_active_footer_widget++;

	switch ($num_active_footer_widget) {
		case 1:
			$name_class = ' keni-footer_col1';
			break;

		case 2:
			$name_class = ' keni-footer_col2';
			break;

		default:
			break;
	}

	return $name_class;
}


// コメントフォーム

function keni_comment_form_order( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}
add_filter( 'comment_form_fields', 'keni_comment_form_order' );

// ページネーション

if (!function_exists('keni_pagenation')) {
	function keni_pagenation(){
		global $paged;
		global $wp_query;

		$pages = $wp_query->max_num_pages;
		$range = 4;

		$showitems = ($range * 2)+1;
		if( empty($paged) ){
			$paged = 1;
		}

		if(!$pages){
			$pages = 1;
		}

		if(1 != $pages){
			echo '<nav class="page-nav">';
			echo '<ol>';

			if( $paged > 1 ){
				echo '<li class="page-nav_prev"><a href="' . get_pagenum_link($paged - 1) . '">' . __('prev', 'keni') . '</a></li>';
			}
			for ( $i=1; $i <= $pages; $i++ ){
				if ( 1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ) ){
					if ( $paged == $i ) {
						echo '<li class="current">' . $i . '</li>';
					} else {
						echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
					}
				}
			}

			if ( $paged < $pages ){
				echo '<li class="page-nav_next"><a href="' . get_pagenum_link($paged + 1) . '">' . __('next', 'keni') . '</a></li>';
			}

			echo '</ol>';
			echo '</nav>';
		}
	}
}

function my_tiny_mce_before_init( $init_array ) {
	$init_array['valid_elements']          = '*[*]';
	$init_array['extended_valid_elements'] = '*[*]';
	return $init_array;
}
add_filter( 'tiny_mce_before_init' , 'my_tiny_mce_before_init' );


// Title sep
add_filter( 'document_title_separator', 'keni_document_title_separator' );
function keni_document_title_separator( $sep ) {
  $sep = '｜';
  return $sep;
}

// フロント
function keni_remove_post_count_parentheses( $output ) {
	$output = preg_replace('/<\/a>.*\((\d+)\)/',' ($1)</a>',$output);
	return $output;
}
add_filter( 'wp_list_categories', 'keni_remove_post_count_parentheses' );
add_filter( 'get_archives_link',  'keni_remove_post_count_parentheses' );


// JSをfooterで読み込む
function keni_scripts_head_to_footer(){
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);

	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
}
add_action( 'wp_enqueue_scripts', 'keni_scripts_head_to_footer' );

function keni_thumbnail_setup() {
	// 画像サイズ
	$keni_thumbnail_size_x    = 600;
	$keni_thumbnail_size_y    = 400;
	$keni_thumbnail_size_crop = true;

	// 画像サイズ追加
	$thum_size                = apply_filters( "keni_thumbnail_size", array(
		$keni_thumbnail_size_x,
		$keni_thumbnail_size_y,
		$keni_thumbnail_size_crop
	) );
	if ( count( $thum_size ) == 2 ) {
		array_push( $thum_size, true );
	}
	// 画像サイズ（小）
	$keni_thumbnail_s_size_x    = 300;
	$keni_thumbnail_s_size_y    = 300;
	$keni_thumbnail_s_size_crop = true;

	// 画像サイズ追加
	$thum_s_size                = apply_filters( "keni_thumbnail_s_size", array(
		$keni_thumbnail_s_size_x,
		$keni_thumbnail_s_size_y,
		$keni_thumbnail_s_size_crop
	) );
	if ( count( $thum_s_size ) == 2 ) {
		array_push( $thum_s_size, true );
	}

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'keni_thumbnail', $thum_size[0], $thum_size[1], (bool) $thum_size[2] );
	add_image_size( 'keni_thumbnail_s', $thum_s_size[0], $thum_s_size[1], (bool) $thum_s_size[2] );
	do_action( "keni_setup_after" );
}
add_action( 'after_setup_theme', 'keni_thumbnail_setup' );