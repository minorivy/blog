<?php
//-----------------------------------------------------
// admin 共通コンテンツ パーマリンク非表示
//-----------------------------------------------------
add_filter( 'get_sample_permalink_html' , 'keni_admin_permalink' );
function keni_admin_permalink( $permalink_html ){
	global $post;

	if( $post->post_type == 'keni_cc' || preg_match( '/post_type=keni_cc/', $permalink_html ) ){
		$permalink_html = false;
	}
	return $permalink_html;
}

//-----------------------------------------------------
// admin 共通コンテンツ一覧
//-----------------------------------------------------

function keni_add_posts_columns_common_contents( $columns ) {
	$columns['shortcode'] = __('Short Code', 'keni');
	$columns['shortcode_button'] = __('Show button on Visual Editor', 'keni');
	return $columns;
}
function keni_add_posts_columns_common_contents_list( $column_name, $post_id ) {
	$screen = get_current_screen();
	if ( $screen ->post_type == 'keni_cc' ) {
		if ( $column_name == 'shortcode' ) {
			echo ( ! empty( $post_id ) ) ? '<input type="text" value="[cc id=' . $post_id . ']" readonly="">' : '';
		}
		else if ( $column_name == 'shortcode_button' ) {
			$flag_get_common_contents_button = get_post_meta( $post_id, 'keni_common_contents_button', true );
			echo ( $flag_get_common_contents_button == '1' )? __('Display', 'keni') : __('Not Display', 'keni') ;
		}
	}
}
add_filter( 'manage_edit-keni_cc_columns', 'keni_add_posts_columns_common_contents' );
add_action( 'manage_keni_cc_posts_custom_column', 'keni_add_posts_columns_common_contents_list', 10, 2 );

function keni_posts_columns_common_contents( $ch ){
	$ch = array(
		'title' => __('Title', 'keni'),
		'shortcode' => __('Short Code', 'keni'),
		'shortcode_button' => __('Show button on Editor', 'keni'),
		'date' => __('Date', 'keni'),
	);
	return $ch;
}
add_filter( 'manage_keni_cc_posts_columns', 'keni_posts_columns_common_contents' );

// add sort set
function keni_column_orderby_common_contents_button( $vars ) {
	if ( isset( $vars['orderby'] ) && 'shortcode_button' == $vars['orderby'] ) { 
		$vars = array_merge( $vars, array(
		'meta_key' => 'keni_common_contents_button',
		'orderby' => 'meta_value'
		));
	}
	return $vars;
}
add_filter( 'request', 'keni_column_orderby_common_contents_button' );

// add sort
function keni_common_contents_button_register_sortable( $sortable_column ) {
	$sortable_column['shortcode_button'] = 'keni_common_contents_button';
	return $sortable_column;
}
add_filter( 'manage_edit-keni_cc_sortable_columns', 'keni_common_contents_button_register_sortable' );


//-----------------------------------------------------
// meta box 投稿用ページのボタン表示
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_common_contents_button');
add_action('save_post', 'keni_save_meta_box_common_contents_button');

function keni_add_meta_box_common_contents_button() {
	add_meta_box('common_contents_button', __('Show button on Editor', 'keni'), 'keni_insert_meta_box_common_contents_button', 'keni_cc', 'normal', 'high');
}

function keni_insert_meta_box_common_contents_button(){
	global $post;

	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_common_contents_button_nonce' );

	// set common contents
	$flag_get_common_contents_button = get_post_meta( $post->ID, 'keni_common_contents_button', true );

	if ( empty( $flag_get_common_contents_button ) ) {
		$flag_get_common_contents_button = "";
	}

	$arr_list_common_contents_button = array(
		array( "", __( 'Not Display', 'keni' ) ),
		array( "1", __( 'Display', 'keni' ) ),
	);

	echo keni_format_radio( 'keni_common_contents_button', $flag_get_common_contents_button, $arr_list_common_contents_button );

}

function keni_save_meta_box_common_contents_button( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_common_contents_button_nonce']) ? $_POST['keni_meta_box_common_contents_button_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$flag_get_common_contents_button = isset( $_POST['keni_common_contents_button'] ) ? $_POST['keni_common_contents_button']: '';
	if( !empty( $flag_get_common_contents_button ) ){
		update_post_meta( $post_id, 'keni_common_contents_button', $flag_get_common_contents_button );
	}
	else {
		delete_post_meta( $post_id, 'keni_common_contents_button' );
	}

}

//-----------------------------------------------------
// meta box ショートコード表示
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_common_contents_code');

function keni_add_meta_box_common_contents_code() {
	add_meta_box('common_contents_code', __( 'This Short Code', 'keni' ), 'keni_insert_meta_box_common_contents_code', 'keni_cc', 'side', 'default');
}

function keni_insert_meta_box_common_contents_code(){
	global $post;

	echo sprintf( keni_format_common_contents_code(), $post->ID );

}

function keni_format_common_contents_code() {
	return __('<p>Use This Short Code</p>' , 'keni') . //この内容を本文中などに表示をする場合には、下記のコードを記述して下さい。
	        '<input type="text" value="[cc id=%s]" readonly="">';
}


