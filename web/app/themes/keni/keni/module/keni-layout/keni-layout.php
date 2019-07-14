<?php

//-----------------------------------------------------
// Customizer
//-----------------------------------------------------

/**
 * Default
 */
function keni_customize_layout_default($id) {
	$default = array(
			'keni_layout_basic'                     => 'col2',
			'keni_layout_sidebar'                   => 'layout-sidebar-show',
			'keni_layout_front'                     => 'layout-basic',
			'keni_layout_front_sidebar'             => 'layout-sidebar-basic',
			'keni_layout_front_footer01'            => 'layout-footer-show',
			'keni_layout_front_footer02'            => 'layout-footer-show',
			'keni_layout_front_footer03'            => 'layout-footer-show',
			'keni_layout_front_navigation'          => 'layout-navigation-show',
			'keni_layout_front_breadcrumb'          => 'layout-breadcrumb-show',
			'keni_layout_archives_category'         => 'layout-basic',
			'keni_layout_archives_category_sidebar' => 'layout-sidebar-basic',
			'keni_layout_archives_tag'              => 'layout-basic',
			'keni_layout_archives_tag_sidebar'      => 'layout-sidebar-basic',
			'keni_layout_archives_date'             => 'layout-basic',
			'keni_layout_archives_date_sidebar'     => 'layout-sidebar-basic',
			'keni_layout_archives_author'           => 'layout-basic',
			'keni_layout_archives_author_sidebar'   => 'layout-sidebar-basic',
			'keni_layout_archives_search'           => 'layout-basic',
			'keni_layout_archives_search_sidebar'   => 'layout-sidebar-basic',
			'keni_layout_header'                    => 'keni-header_col1',
			'keni_layout_post_list'                 => 'entry-list_style01',
		);

	if ( !empty($id) ) {
		return $default[$id];
	}
}


/**
 * Layout
 */
function keni_customize_layout( $wp_customize ) {
	$wp_customize->add_section( 'keni_layout' , array(
		'title'       => __( 'Layout', 'keni' ),
		'priority'    => 20,
		'description' => '',
	) );

	$wp_customize->add_setting('keni_layout_basic', array(
		'default' => keni_customize_layout_default("keni_layout_basic"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_basic', array(
		'settings' => 'keni_layout_basic',
		'label' => __( 'Layout', 'keni' ),
		'section' => 'keni_layout',
		'type' => 'radio',
		'choices' => array(
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_sidebar', array(
		'settings' => 'keni_layout_sidebar',
		'label' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));
}
add_action('customize_register', 'keni_customize_layout');


/**
 * TopPage Layout
 */
function keni_customize_layout_front( $wp_customize ) {
	$wp_customize->add_section( 'keni_layout_front' , array(
		'title'       => __( 'TopPage Layout', 'keni' ),
		'priority'    => 21,
		'description' => '',
	) );

	$wp_customize->add_setting('keni_layout_front', array(
		'default' => keni_customize_layout_default("keni_layout_front"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front', array(
		'settings' => 'keni_layout_front',
		'label' => __( 'Layout', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ), // 基本Layoutを適用
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_front_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_front_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front_sidebar', array(
		'settings' => 'keni_layout_front_sidebar',
		'label' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_front_footer01', array(
		'default' => keni_customize_layout_default("keni_layout_front_footer01"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front_footer01', array(
		'settings' => 'keni_layout_front_footer01',
		'label' => __( 'Footer 01', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-footer-show' => __( 'Display', 'keni' ),
			'layout-footer-hide' => __( 'Not Display', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_front_footer02', array(
		'default' => keni_customize_layout_default("keni_layout_front_footer02"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front_footer02', array(
		'settings' => 'keni_layout_front_footer02',
		'label' => __( 'Footer 02', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-footer-show' => __( 'Display', 'keni' ),
			'layout-footer-hide' => __( 'Not Display', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_front_footer03', array(
		'default' => keni_customize_layout_default("keni_layout_front_footer03"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front_footer03', array(
		'settings' => 'keni_layout_front_footer03',
		'label' => __( 'Footer 03', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-footer-show' => __( 'Display', 'keni' ),
			'layout-footer-hide' => __( 'Not Display', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_front_navigation', array(
		'default' => keni_customize_layout_default("keni_layout_front_navigation"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_front_navigation', array(
		'settings' => 'keni_layout_front_navigation',
		'label' => __( 'Global Menu', 'keni' ),
		'section' => 'keni_layout_front',
		'type' => 'radio',
		'choices' => array(
			'layout-navigation-show' => __( 'Display', 'keni' ),
			'layout-navigation-hide' => __( 'Not Display', 'keni' ),
		),
	));

//	$wp_customize->add_setting('keni_layout_front_breadcrumb', array(
//		'default' => keni_customize_layout_default("keni_layout_front_breadcrumb"),
//		'sanitize_callback' => "alphanumeric_symbol",
//	));
//	$wp_customize->add_control( 'keni_layout_front_breadcrumb', array(
//		'settings' => 'keni_layout_front_breadcrumb',
//		'label' => __( 'Breadcrumb', 'keni' ),
//		'section' => 'keni_layout_front',
//		'type' => 'radio',
//		'choices' => array(
//			'layout-breadcrumb-show' => __( 'Display', 'keni' ),
//			'layout-breadcrumb-hide' => __( 'Not Display', 'keni' ),
//		),
//	));

}
add_action('customize_register', 'keni_customize_layout_front');


/**
 * Archives Layout
 */
function keni_customize_layout_archives( $wp_customize ) {
	$wp_customize->add_section( 'keni_layout_archives' , array(
		'title'       => __( 'Archives Layout', 'keni' ),
		'priority'    => 21,
		'description' => '',
	) );

	// category
	$wp_customize->add_setting('keni_layout_archives_category', array(
		'default' => keni_customize_layout_default("keni_layout_archives_category"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_category', array(
		'settings' => 'keni_layout_archives_category',
		'label' => __( 'Category Page', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ),
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_archives_category_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_archives_category_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_category_sidebar', array(
		'settings' => 'keni_layout_archives_category_sidebar',
		'description' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

	// tag
	$wp_customize->add_setting('keni_layout_archives_tag', array(
		'default' => keni_customize_layout_default("keni_layout_archives_tag"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_tag', array(
		'settings' => 'keni_layout_archives_tag',
		'label' => __( 'Tag Page', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ),
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_archives_tag_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_archives_tag_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_tag_sidebar', array(
		'settings' => 'keni_layout_archives_tag_sidebar',
		'description' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

	// date
	$wp_customize->add_setting('keni_layout_archives_date', array(
		'default' => keni_customize_layout_default("keni_layout_archives_date"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_date', array(
		'settings' => 'keni_layout_archives_date',
		'label' => __( '年月日ページ', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ),
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_archives_date_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_archives_date_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_date_sidebar', array(
		'settings' => 'keni_layout_archives_date_sidebar',
		'description' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

	// author
	$wp_customize->add_setting('keni_layout_archives_author', array(
		'default' => keni_customize_layout_default("keni_layout_archives_author"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_author', array(
		'settings' => 'keni_layout_archives_author',
		'label' => __( '投稿者ページ', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ),
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_archives_author_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_archives_author_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_author_sidebar', array(
		'settings' => 'keni_layout_archives_author_sidebar',
		'description' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

	// search
	$wp_customize->add_setting('keni_layout_archives_search', array(
		'default' => keni_customize_layout_default("keni_layout_archives_search"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_search', array(
		'settings' => 'keni_layout_archives_search',
		'label' => __( 'Archives Search', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-basic' => __( 'Use Default Layout', 'keni' ),
			'col1' => __( '1 Column', 'keni' ),
			'col2' => __( '2 Column', 'keni' ),
			'col2r' => __( '2 Column Reverse', 'keni' ),
		),
	));

	$wp_customize->add_setting('keni_layout_archives_search_sidebar', array(
		'default' => keni_customize_layout_default("keni_layout_archives_search_sidebar"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_archives_search_sidebar', array(
		'settings' => 'keni_layout_archives_search_sidebar',
		'description' => __( 'Side Bar for 1 Column', 'keni' ),
		'section' => 'keni_layout_archives',
		'type' => 'radio',
		'choices' => array(
			'layout-sidebar-basic' => __( 'Use Default Layout', 'keni' ),
			'layout-sidebar-show' => __( 'Display', 'keni' ),
			'layout-sidebar-hide' => __( 'Not Display', 'keni' ),
		),
	));

}
add_action('customize_register', 'keni_customize_layout_archives');

/**
 * Header Layout
 */
function keni_customize_layout_header( $wp_customize ) {
	$wp_customize->add_section( 'keni_layout_header' , array(
		'title'       => __( 'Header Layout', 'keni' ),
		'priority'    => 21,
		'description' => '',
	) );

	$wp_customize->add_setting('keni_layout_header', array(
		'default' => keni_customize_layout_default("keni_layout_header"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_header', array(
		'settings' => 'keni_layout_header',
		'label' => __( 'Layout (Mobile Only)', 'keni' ),
		'section' => 'keni_layout_header',
		'type' => 'radio',
		'choices' => array(
			'keni-header_col1' => __( '1 Column', 'keni' ),
			'keni-header_col2' => __( '2 Column', 'keni' ),
		),
	));

}
add_action('customize_register', 'keni_customize_layout_header');

/**
 * Post list Layout
 */
function keni_customize_layout_post_list( $wp_customize ) {
	$wp_customize->add_section( 'keni_layout_post_list' , array(
		'title'       => __( 'Post List Layout', 'keni' ),
		'priority'    => 21,
		'description' => '',
	) );

	$wp_customize->add_setting('keni_layout_post_list', array(
		'default' => keni_customize_layout_default("keni_layout_post_list"),
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_layout_post_list', array(
		'settings' => 'keni_layout_post_list',
		'label' => __( 'Layout', 'keni' ),
		'section' => 'keni_layout_post_list',
		'type' => 'radio',
		'choices' => array(
			'entry-list_style01' => __( 'Default', 'keni' ),
			'entry-list_style02' => __( 'Card', 'keni' ),
		),
	));

}
add_action('customize_register', 'keni_customize_layout_post_list');


/**
 * Sanitize callback
 */
function alphanumeric_symbol($_inputData) {
	$_inputData = preg_replace('/[^a-zA-Z0-9_-]/','',$_inputData);
	return $_inputData;
}



//-----------------------------------------------------
// Post
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_layout_post');
add_action('save_post', 'keni_save_meta_box_layout_post');
function keni_add_meta_box_layout_post() {
	add_meta_box('layout', __( 'Setting Layout and Disp Menu', 'keni' ), 'keni_insert_meta_box_layout_post', array( 'post', 'page' ) , 'side', 'default');
}
function keni_insert_meta_box_layout_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_layout_post_nonce' );

	// get settingSetting 
	if ( get_option( 'page_on_front' ) == $post->ID ) {
		// TopPage Layout
		$str_get_layout_post_column = get_theme_mod( 'keni_layout_front' );
		$str_get_layout_post_sidebar = get_theme_mod( 'keni_layout_front_sidebar' );
		$str_get_layout_post_footer01 = get_theme_mod( 'keni_layout_front_footer01' );
		$str_get_layout_post_footer02 = get_theme_mod( 'keni_layout_front_footer02' );
		$str_get_layout_post_footer03 = get_theme_mod( 'keni_layout_front_footer03' );
		$str_get_layout_post_navigation = get_theme_mod( 'keni_layout_front_navigation' );
		$str_get_layout_post_breadcrumb = get_theme_mod( 'keni_layout_front_breadcrumb' );
	}
	else {
		// post meta
		$str_get_layout_post_column = get_post_meta( $post->ID, 'keni_layout_post', true );
		$str_get_layout_post_sidebar = get_post_meta( $post->ID, 'keni_layout_post_sidebar', true );
		$str_get_layout_post_footer01 = get_post_meta( $post->ID, 'keni_layout_post_footer01', true );
		$str_get_layout_post_footer02 = get_post_meta( $post->ID, 'keni_layout_post_footer02', true );
		$str_get_layout_post_footer03 = get_post_meta( $post->ID, 'keni_layout_post_footer03', true );
		$str_get_layout_post_navigation = get_post_meta( $post->ID, 'keni_layout_post_navigation', true );
		$str_get_layout_post_breadcrumb = get_post_meta( $post->ID, 'keni_layout_post_breadcrumb', true );
	}

	$str_layout_post_column = ( !empty($str_get_layout_post_column) )? $str_get_layout_post_column : 'layout-basic' ;
	$str_layout_post_sidebar = ( !empty($str_get_layout_post_sidebar) )? $str_get_layout_post_sidebar : 'layout-sidebar-basic' ;
	$str_layout_post_footer01 = ( !empty($str_get_layout_post_footer01) )? $str_get_layout_post_footer01 : 'layout-footer-show' ;
	$str_layout_post_footer02 = ( !empty($str_get_layout_post_footer02) )? $str_get_layout_post_footer02 : 'layout-footer-show' ;
	$str_layout_post_footer03 = ( !empty($str_get_layout_post_footer03) )? $str_get_layout_post_footer03 : 'layout-footer-show' ;
	$str_layout_post_navigation = ( !empty($str_get_layout_post_navigation) )? $str_get_layout_post_navigation : 'layout-navigation-show' ;
	$str_layout_post_breadcrumb = ( !empty($str_get_layout_post_breadcrumb) )? $str_get_layout_post_breadcrumb : 'layout-breadcrumb-show' ;

	$arr_list_column = array(
		array( "layout-basic", __( 'Use Default Layout', 'keni' ) ),
		array( "col1", __( '1 Column', 'keni' ) ),
		array( "col2", __( '2 Column', 'keni' ) ),
		array( "col2r", __( '2 Column Reverse', 'keni' ) ),
	);
	$arr_list_sidebar = array(
		array( "layout-sidebar-basic", __( 'Use Default Layout', 'keni' ) ),
		array( "layout-sidebar-show", __( 'Display', 'keni' ) ),
		array( "layout-sidebar-hide", __( 'Not Display', 'keni' ) ),
	);
	$arr_list_footer = array(
		array( "layout-footer-show", __( 'Display', 'keni' ) ),
		array( "layout-footer-hide", __( 'Not Display', 'keni' ) ),
	);
	$arr_list_navigation = array(
		array( "layout-navigation-show", __( 'Display', 'keni' ) ),
		array( "layout-navigation-hide", __( 'Not Display', 'keni' ) ),
	);
	$arr_list_breadcrumb = array(
		array( "layout-breadcrumb-show", __( 'Display', 'keni' ) ),
		array( "layout-breadcrumb-hide", __( 'Not Display', 'keni' ) ),
	);

	$str_html_layout_column = keni_format_select( 'keni_layout_post', $str_layout_post_column, $arr_list_column );
	$str_html_layout_sidebar = keni_format_radio( 'keni_layout_post_sidebar', $str_layout_post_sidebar, $arr_list_sidebar );
	$str_html_layout_footer01 = keni_format_radio( 'keni_layout_post_footer01', $str_layout_post_footer01, $arr_list_footer );
	$str_html_layout_footer02 = keni_format_radio( 'keni_layout_post_footer02', $str_layout_post_footer02, $arr_list_footer );
	$str_html_layout_footer03 = keni_format_radio( 'keni_layout_post_footer03', $str_layout_post_footer03, $arr_list_footer );
	$str_html_layout_navigation = keni_format_radio( 'keni_layout_post_navigation', $str_layout_post_navigation, $arr_list_navigation );
	$str_html_layout_breadcrumb = keni_format_radio( 'keni_layout_post_breadcrumb', $str_layout_post_breadcrumb, $arr_list_breadcrumb );

	$str_label_layout_column = __( 'Number of Column', 'keni' );
	$str_label_layout_sidebar = __( 'Side Bar', 'keni' );
	$str_label_layout_footer01 = __( 'Footer 01', 'keni' );
	$str_label_layout_footer02 = __( 'Footer 02', 'keni' );
	$str_label_layout_footer03 = __( 'Footer 03', 'keni' );
	$str_label_layout_navigation = __( 'Menu', 'keni' );
	$str_label_layout_breadcrumb = __( 'Breadcrumb', 'keni' );

	$str_text_howto = __( 'Valid for 1 Column', 'keni' );

	echo <<< EOM
		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_column}</label></p>
		{$str_html_layout_column}

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_sidebar}</label></p>
		{$str_html_layout_sidebar}
		<p class="howto">{$str_text_howto}</p>

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_footer01}</label></p>
		{$str_html_layout_footer01}
		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_footer02}</label></p>
		{$str_html_layout_footer02}
		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_footer03}</label></p>
		{$str_html_layout_footer03}

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_navigation}</label></p>
		{$str_html_layout_navigation}

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label">{$str_label_layout_breadcrumb}</label></p>
		{$str_html_layout_breadcrumb}

EOM;

}
function keni_save_meta_box_layout_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_layout_post_nonce']) ? $_POST['keni_meta_box_layout_post_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save layout
	$str_layout_post_column = isset( $_POST['keni_layout_post'] ) ? $_POST['keni_layout_post']: '';
	if( !empty( $str_layout_post_column ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front', $str_layout_post_column );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post', $str_layout_post_column );
		}
	}

	// save sidebar
	$str_layout_post_sidebar = isset( $_POST['keni_layout_post_sidebar'] ) ? $_POST['keni_layout_post_sidebar']: '';
	if( !empty( $str_layout_post_sidebar ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_sidebar', $str_layout_post_sidebar );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_sidebar', $str_layout_post_sidebar );
		}
	}

	// save footer01
	$str_layout_post_footer01 = isset( $_POST['keni_layout_post_footer01'] ) ? $_POST['keni_layout_post_footer01']: '';
	if( !empty( $str_layout_post_footer01 ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_footer01', $str_layout_post_footer01 );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_footer01', $str_layout_post_footer01 );
		}
	}

	// save footer02
	$str_layout_post_footer02 = isset( $_POST['keni_layout_post_footer02'] ) ? $_POST['keni_layout_post_footer02']: '';
	if( !empty( $str_layout_post_footer02 ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_footer02', $str_layout_post_footer02 );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_footer02', $str_layout_post_footer02 );
		}
	}

	// save footer03
	$str_layout_post_footer03 = isset( $_POST['keni_layout_post_footer03'] ) ? $_POST['keni_layout_post_footer03']: '';
	if( !empty( $str_layout_post_footer03 ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_footer03', $str_layout_post_footer03 );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_footer03', $str_layout_post_footer03 );
		}
	}

	// save navigation
	$str_layout_post_navigation = isset( $_POST['keni_layout_post_navigation'] ) ? $_POST['keni_layout_post_navigation']: '';
	if( !empty( $str_layout_post_navigation ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_navigation', $str_layout_post_navigation );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_navigation', $str_layout_post_navigation );
		}
	}

	// save breadcrumb
	$str_layout_post_breadcrumb = isset( $_POST['keni_layout_post_breadcrumb'] ) ? $_POST['keni_layout_post_breadcrumb']: '';
	if( !empty( $str_layout_post_breadcrumb ) ){

		if ( get_option( 'page_on_front' ) == $post_id ) {
			// TopPage Layout
			set_theme_mod( 'keni_layout_front_breadcrumb', $str_layout_post_breadcrumb );
		}
		else {
			update_post_meta( $post_id, 'keni_layout_post_breadcrumb', $str_layout_post_breadcrumb );
		}
	}
}

//-----------------------------------------------------
// category | tag
//-----------------------------------------------------
function keni_term_edit_form_fields_layout( $term ) {
	$num_term_id = $term->term_id;

	if ( function_exists( "get_term_meta" ) ) {
		// wordpress 4.4.0以降
		$str_get_layout_term = get_term_meta( $num_term_id, "keni_layout_term", true );
	}
	else {
		$str_get_layout_term = get_option( "keni_layout_term_" . $num_term_id );
	}

	$arr_list_column = array(
		array( "layout-basic", __( 'Use Default Layout', 'keni' ) ),
		array( "col1", __( '1 Column', 'keni' ) ),
		array( "col2", __( '2 Column', 'keni' ) ),
		array( "col2r", __( '2 Column Reverse', 'keni' ) ),
	);

	$str_html_layout = keni_format_select( 'keni_term_meta[keni_layout_term]', $str_get_layout_term, $arr_list_column );

?>
<tr>
	<th><label for="keni_layout_term"><?php _e( "Layout", 'keni' ); ?></label></th>
	<td>
		<?php echo $str_html_layout ?>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'keni_term_edit_form_fields_layout' );
add_action( 'post_tag_edit_form_fields', 'keni_term_edit_form_fields_layout' );

function keni_term_add_form_fields_layout( $term ) {

	$arr_list_column = array(
		array( "layout-basic", __( 'Use Default Layout', 'keni' ) ),
		array( "col1", __( '1 Column', 'keni' ) ),
		array( "col2", __( '2 Column', 'keni' ) ),
		array( "col2r", __( '2 Column Reverse', 'keni' ) ),
	);
	$default_layout = "layout-basic";
	$str_html_layout = keni_format_select( 'keni_term_meta[keni_layout_term]', $default_layout, $arr_list_column );


?>
<div class="form-field">
	<label for="keni_layout_term"><?php _e( "Layout", 'keni' ); ?></label>
	<?php echo $str_html_layout ?>
</div>
<?php
}
add_action( 'category_add_form_fields', 'keni_term_add_form_fields_layout' );
add_action( 'post_tag_add_form_fields', 'keni_term_add_form_fields_layout' );


//-----------------------------------------------------
// Layout html class
//-----------------------------------------------------
function keni_layout_class( $arr_classes = array() ) {
	global $post;

	// layout
	$str_keni_layout_class = get_keni_layout_column_class();

	// sidebar
	$str_keni_layout_sidebar_class = get_keni_layout_sidebar_class();

	// footer01
    $str_keni_layout_footer01_class = get_keni_layout_footer01_class();

    // footer02
    $str_keni_layout_footer02_class = get_keni_layout_footer02_class();

    // footer03
    $str_keni_layout_footer03_class = get_keni_layout_footer03_class();

	// front navigation
	$str_keni_layout_front_navigation_class = get_keni_layout_front_navigation_class();

	// front breadcrumb
	$str_keni_layout_breadcrumb_class = get_keni_layout_breadcrumb_class();

	if ( ! empty( $str_keni_layout_class ) ) $arr_classes[] = $str_keni_layout_class;
	if ( ! empty( $str_keni_layout_sidebar_class ) ) $arr_classes[] = $str_keni_layout_sidebar_class;
	if ( ! empty( $str_keni_layout_footer01_class ) ) $arr_classes[] = $str_keni_layout_footer01_class;
	if ( ! empty( $str_keni_layout_footer02_class ) ) $arr_classes[] = $str_keni_layout_footer02_class;
	if ( ! empty( $str_keni_layout_footer03_class ) ) $arr_classes[] = $str_keni_layout_footer03_class;
	if ( ! empty( $str_keni_layout_front_navigation_class ) ) $arr_classes[] = $str_keni_layout_front_navigation_class;
	if ( ! empty( $str_keni_layout_front_breadcrumb_class ) ) $arr_classes[] = $str_keni_layout_breadcrumb_class;

	return $arr_classes;

}
add_filter('html_class', 'keni_layout_class', 99);


//-----------------------------------------------------
// Layout body class
//-----------------------------------------------------
function keni_layout_body_classes( $arr_classes = array() ) {

	// front navigation
	if( ! has_nav_menu( 'gnav' ) || ! is_keni_layout_front_navigation() ) {
		$arr_classes[] = 'no-gn';
	}

	return $arr_classes;
}
add_filter( 'body_class', 'keni_layout_body_classes' );
