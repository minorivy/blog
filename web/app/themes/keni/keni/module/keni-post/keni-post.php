<?php
//-----------------------------------------------------
// 基本設定 - 投稿
//-----------------------------------------------------
/**
 * add menu
 */
function keni_admin_post () {
	add_submenu_page('keni_admin_menu', __( 'Keni Settings post', 'keni' ), __( 'Keni Settings post', 'keni' ), 'administrator', 'keni_admin_menu_posts', 'keni_setting_page_posts');
	add_action( 'admin_init', 'keni_register_post','admin-head');
}
add_action( 'admin_menu', 'keni_admin_post' );

/**
 * 初期値
 */
function keni_default_post() {
	$flag_get_relation_disp = get_option( 'keni_relation_disp' );
	if ( empty( $flag_get_relation_disp ) ) {
		add_option( 'keni_relation_disp', "show" );
	}
	$flag_category_relation = get_option( 'keni_category_relation' );
	if ( empty( $flag_category_relation ) ) {
		add_option( 'keni_category_relation', "1" );
	}
	$flag_get_relation_style = get_option( 'keni_relation_style' );
	if ( empty( $flag_get_relation_style ) ) {
		add_option( 'keni_relation_style', '1' );
	}
	$flag_get_thumbnail_disp = get_option( 'keni_thumbnail_disp' );
	if ( empty( $flag_get_thumbnail_disp ) ) {
		add_option( 'keni_thumbnail_disp', "show" );
	}

	$flag_get_thumbnail_disp = get_option( 'keni_toc_disp' );
	if ( empty( $flag_get_thumbnail_disp ) ) {
		add_option( 'keni_toc_disp', "hide" );
	}

}
add_action( 'init' , 'keni_default_post' );

add_filter( 'the_password_form', 'keni_password_form', 10, 1 );
add_filter( 'protected_title_format', 'keni_password_title_format', 10, 1 );




/**
 * Register
 */
function keni_register_post() {
	register_setting( 'keni-initialize-setting_page_post', 'keni_author_disp' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_time_disp' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_single_after_contents' );

	// Relation post Default
	if ( ! empty( $_POST['keni_relation_disp'] ) && $_POST['keni_relation_disp'] == '1' && empty( $_POST['keni_category_relation'] ) && empty( $_POST['keni_tag_relation'] ) ) {
		$_POST['keni_category_relation'] = '1';
	}
	register_setting( 'keni-initialize-setting_page_post', 'keni_relation_disp' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_relation_style' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_category_relation' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_tag_relation' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_thumbnail_disp' );
	register_setting( 'keni-initialize-setting_page_post', 'keni_toc_disp' );
}

function keni_setting_page_posts() {

	$str_option_group = 'keni-initialize-setting_page_post';

	/* set 共通設定 */
	# author disp
	$flag_get_author_disp = get_option( 'keni_author_disp', '' );
	$arr_list_author_disp = array(
		array( "", __( 'Not Display', 'keni' ) ),
		array( "1", __( 'Display', 'keni' ) ),
	);
	$str_html_author_disp = keni_format_radio( 'keni_author_disp', $flag_get_author_disp, $arr_list_author_disp );

	# time disp
	$flag_get_time_disp = get_option( 'keni_time_disp', 'show' );
	$arr_list_time_disp = array(
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display Post Date & Update Date', 'keni' ) ),
		array( "update", __( 'Display Update Date', 'keni' ) ),
		array( "post", __( 'Display Post Date', 'keni' ) ),
	);
	$str_html_time_disp = keni_format_radio( 'keni_time_disp', $flag_get_time_disp, $arr_list_time_disp );

	# Single after contents
	$str_get_single_after_contents = get_option( 'keni_single_after_contents' );
	$str_html_single_after_contents = keni_format_textarea( 'keni_single_after_contents', $str_get_single_after_contents, 'large-text' );


	# Relation 全体設定
	$flag_get_relation_disp = get_option( 'keni_relation_disp' );
	$arr_list_relation_disp = array(
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);
	$str_html_relation = keni_format_radio( 'keni_relation_disp', $flag_get_relation_disp, $arr_list_relation_disp );

	$flag_category_relation = get_option( 'keni_category_relation' );
	$arr_list_category_relation = array(
		array( "1", __( 'Category', 'keni' ) ),
	);
	$str_html_category_relation = keni_format_checkbox( 'keni_category_relation', $flag_category_relation, $arr_list_category_relation, true );

	$flag_tag_relation = get_option( 'keni_tag_relation' );
	$arr_list_tag_relation = array(
		array( "1", __( 'Tag', 'keni' ) ),
	);
	$str_html_tag_relation = keni_format_checkbox( 'keni_tag_relation', $flag_tag_relation, $arr_list_tag_relation, true );

	$flag_get_relation_style = get_option( 'keni_relation_style' );
	$arr_list_relation_style = array(
		array( "1", __( 'List Style', 'keni' ) ),
		array( "2", __( 'Card Style', 'keni' ) ),
	);
	$str_html_relation_style = keni_format_radio( 'keni_relation_style', $flag_get_relation_style, $arr_list_relation_style );

	# アイキャッチ画像設定
	$flag_get_thumbnail_disp = get_option( 'keni_thumbnail_disp' );
	$arr_list_thumbnail_disp = array(
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);
	$str_html_thumbnail_disp = keni_format_radio( 'keni_thumbnail_disp', $flag_get_thumbnail_disp, $arr_list_thumbnail_disp );

	# 全体の目次表示設定
	$flag_get_toc_disp = get_option( 'keni_toc_disp' );
	$arr_list_toc_disp = array(
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);
	$str_html_toc_disp = keni_format_radio( 'keni_toc_disp', $flag_get_toc_disp, $arr_list_toc_disp );


	$arr_metaboxs[] =  sprintf( keni_format_author_disp(), $str_html_author_disp );
	$arr_metaboxs[] =  sprintf( keni_format_time_disp(), $str_html_time_disp );
	$arr_metaboxs[] =  sprintf( keni_format_single_after_contents(), $str_html_single_after_contents );
	$arr_metaboxs[] =  sprintf( keni_format_relation(), $str_html_relation, $str_html_category_relation, $str_html_tag_relation, $str_html_relation_style );
	$arr_metaboxs[] =  sprintf( keni_format_thumbnail_disp(), $str_html_thumbnail_disp );
	$arr_metaboxs[] =  sprintf( keni_format_toc_disp(), $str_html_toc_disp );

	keni_the_format_options_form( $str_option_group, $arr_metaboxs );
}


/**
 * Format canonical
 * @return string html
 */
function keni_format_setting_post_common() {
	$title = __( 'Common Settings', 'keni' );
	$main ='<p class="post-attributes-label-wrapper"><label class="post-attributes-label">投稿者情報の表示</label></p>
	        %s
	        <p class="post-attributes-label-wrapper"><label class="post-attributes-label">更新時間・投稿時間の表示</label></p>
	        %s
	        <p class="post-attributes-label-wrapper"><label class="post-attributes-label">記事下のコンテンツ</label></p>
	        %s
	        <p class="post-attributes-label-wrapper"><label class="post-attributes-label">全体の関連記事設定</label></p>
	        %s
	        <div style="padding-left: 2em;">
	        %s
	        %s
	        </div>
	        %s
	        ';
	return keni_format_metabox_holder( $title, $main );
}
/**
 * Format author_disp
 * @return string html
 */
function keni_format_author_disp() {
	$title = __( 'Display Auther information', 'keni' ); // 投稿者情報の表示
	$main ='%s';
	return keni_format_metabox_holder( $title, $main );
}
/**
 * Format time_disp
 * @return string html
 */
function keni_format_time_disp() {
	$title = __( 'Display Date', 'keni' ); // 更新時間・投稿時間の表示
	$main ='%s';
	return keni_format_metabox_holder( $title, $main );
}
/**
 * Format single_after_contents
 * @return string html
 */
function keni_format_single_after_contents() {
	$title = __( 'Contents after Post', 'keni' ); // 記事下のコンテンツ
	$main ='%s';
	return keni_format_metabox_holder( $title, $main );
}
/**
 * Format relation
 * @return string html
 */
function keni_format_relation() {
	$title = __( 'Setting Relation Post for Site', 'keni' ); // 全体の関連記事設定
	$main ='%s
	        <div style="padding-left: 2em;">
	        %s
	        %s
	        </div>
	        <p class="post-attributes-label-wrapper"><label class="post-attributes-label">関連記事のスタイルの選択</label></p>
	        %s';
	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format thumbnail_disp
 * @return string html
 */
function keni_format_thumbnail_disp() {
	$title = __( 'Thumbnail for Single Post', 'keni' ); // 個別ページのアイキャッチ画像
	$main ='%s';
	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format toc_disp
 * @return string html
 */
function keni_format_toc_disp() {
	$title = __( 'TOC Display Setting', 'keni' ); // 目次の表示
	$main ='%s';
	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format Facebook Page Plugin
 * @return string   form html
 */
function keni_format_facebook_page_plugin() {

	$html = '<div class="facebook-pageplugin-area">%s</div>';

	return $html;
}

/**
 * keni_post_after Single after
 */
add_filter( 'keni_post_after', 'keni_output_single_after_contents' );
function keni_output_single_after_contents() {
	global $post;

	$output = '';
	if ( $post->post_type == 'post' ) {
		// 記事の下コンテンツ
		$str_get_single_after_contents = get_option( 'keni_single_after_contents' );
		if ( $str_get_single_after_contents != '' ) {
			$output = sprintf( keni_format_facebook_page_plugin(), $str_get_single_after_contents );
		}
	}

	echo $output;

}

/**
 * Author display
 * @return bool
 */
function keni_author_disp() {

	$bool = false;
	$flag_get_author_disp = get_option( 'keni_author_disp' );
	if ( $flag_get_author_disp == '1' ) {
		$bool = true;
	}
	return $bool;

}

//-----------------------------------------------------
// 固定ページのページタイトル表示
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_page_title_disp_page');
add_action('save_post', 'keni_save_meta_box_page_title_disp_page');

function keni_add_meta_box_page_title_disp_page() {
	add_meta_box('page_title_disp', __( 'Display Page Title', 'keni' ), 'keni_insert_meta_box_page_title_disp_page', 'page', 'side', 'default'); // ページタイトルの表示
}

function keni_insert_meta_box_page_title_disp_page() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_page_title_disp_page_nonce' );

	// get setting
	$str_get_page_title_disp_page = get_post_meta( $post->ID, 'keni_page_title_disp_page', true );

	if ( empty( $str_get_page_title_disp_page ) ) {
		$str_get_page_title_disp_page = "";
	}

	$arr_list_page_title_disp = array(
		array( "", __( 'Display', 'keni' ) ),
		array( "1", __( 'Not Display', 'keni' ) ),
	);

	echo keni_format_radio( 'keni_page_title_disp_page', $str_get_page_title_disp_page, $arr_list_page_title_disp );

}

function keni_save_meta_box_page_title_disp_page( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_page_title_disp_page_nonce']) ? $_POST['keni_meta_box_page_title_disp_page_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$str_get_page_title_disp_page = isset( $_POST['keni_page_title_disp_page'] ) ? $_POST['keni_page_title_disp_page']: '';
	if( !empty( $str_get_page_title_disp_page ) ){
		update_post_meta( $post_id, 'keni_page_title_disp_page', $str_get_page_title_disp_page );
	}
	else {
		delete_post_meta( $post_id, 'keni_page_title_disp_page' );
	}
}

/**
 * 固定ページにタグを設定出来るようにする
 */
function add_tag_to_page() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
}
add_action('init', 'add_tag_to_page');

/**
 * タグのアーカイブに 固定ページを含める
 * @param $obj
 */
function add_page_to_tag_archive( $obj ) {
	if ( is_tag() && $obj->is_main_query() ) {
		$obj->query_vars['post_type'] = array( 'post', 'page' );
	}
}
add_action( 'pre_get_posts', 'add_page_to_tag_archive' );

//-----------------------------------------------------
// パンくず優先カテゴリ設定
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_primary_category_post');
add_action('save_post', 'keni_save_meta_box_primary_category_post');

function keni_add_meta_box_primary_category_post() {
	add_meta_box('primary_category_area', __( 'Setting of BreadcrumbList priority', 'keni' ), 'keni_insert_meta_box_primary_category_post', 'post', 'side', 'default'); // パンくず優先カテゴリ設定
}

function keni_insert_meta_box_primary_category_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_primary_category_post_nonce' );

	// get setting
	$str_get_primary_category_post = get_post_meta( $post->ID, 'keni_primary_category_post', true );
	// get my category
	$arr_my_category = get_the_category();

	if ( empty( $str_get_primary_category_post ) && ! empty( $arr_my_category[0] ) ) {
		$str_get_primary_category_post = $arr_my_category[0]->term_id;
	}

	$i = 0;
	$arr_list_primary_category = array();
	foreach ( $arr_my_category as $cat ) {
		$arr_list_primary_category[$i] = array( $cat->term_id, $cat->name );
		$i++;
	}

	echo keni_format_radio( 'keni_primary_category_post', $str_get_primary_category_post, $arr_list_primary_category );

}

function keni_save_meta_box_primary_category_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_primary_category_post_nonce']) ? $_POST['keni_meta_box_primary_category_post_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$str_get_primary_category_post = isset( $_POST['keni_primary_category_post'] ) ? $_POST['keni_primary_category_post']: '';
	if( !empty( $str_get_primary_category_post ) ){
		update_post_meta( $post_id, 'keni_primary_category_post', $str_get_primary_category_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_primary_category_post' );
	}
}

//-----------------------------------------------------
// 関連記事設定
//-----------------------------------------------------
add_action( 'admin_menu', 'keni_add_meta_box_relation_post' );
add_action( 'save_post', 'keni_save_meta_box_relation_post' );

function keni_add_meta_box_relation_post() {
	add_meta_box( 'relation', __( 'Setting of Relation Post', 'keni' ), 'keni_insert_meta_box_relation_post', array( 'post', 'page' ), 'normal', 'high' ); // 関連記事設定
}

function keni_insert_meta_box_relation_post(){
	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_relation_post_nonce' );


	# set relation display
	$flag_get_relation_disp_post = get_post_meta( $post->ID, 'keni_relation_disp_post', true );
	$arr_list_relation_disp = array(
		array( "", __( 'Use Default Setting', 'keni' ) ), // 全体の設定を適用する
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);

	// set category relation
	$flag_category_relation = get_post_meta( $post->ID, 'keni_category_relation_post', true );
	$flag_category_relation = apply_filters( 'keni_category_relation', $flag_category_relation );
	// 賢威 functions.php カスタマイズ
	if ( $flag_category_relation == 'y' ) $flag_category_relation = "1";
	$arr_list_category_relation = array(
		array( "1", __( 'Category', 'keni' ) ),
	);

	// set tag relation
	$flag_tag_relation = get_post_meta( $post->ID, 'keni_tag_relation_post', true );
	$flag_tag_relation = apply_filters( 'keni_tag_relation', $flag_tag_relation );
	// 賢威 functions.php カスタマイズ
	if ( $flag_tag_relation == 'y' ) $flag_tag_relation = "1";
	$arr_list_tag_relation = array(
		array( "1", __( 'Tag', 'keni' ) ),
	);

	// set relation lists
	$keni_related_post_count = apply_filters( 'keni_related_post_count', 6 );

	for ( $i = 0; $i < $keni_related_post_count; $i++ ) {
		$arr_set_relation[$i]['title'] = "";
		$arr_set_relation[$i]['url'] = "";
		$arr_set_relation[$i]['blank'] = "";
	}

	if ( isset( $_GET['post'] ) ) {
		$arr_relation_post = get_post_meta( $post->ID, 'keni_relation_post', true);
		if ( ! empty( $arr_relation_post ) && is_array( $arr_relation_post ) ) {
			foreach ( $arr_relation_post as $key => $value ) {
				if ( ! empty($value) ) {
					$arr_set_relation[$key] = $value;
				}
			}
		}
	}

	// display relation
	$str_html_relation_disp_post = keni_format_radio( 'keni_relation_disp_post', $flag_get_relation_disp_post, $arr_list_relation_disp );
	$str_html_category_relation_post = keni_format_checkbox( 'keni_category_relation_post', $flag_category_relation, $arr_list_category_relation, true );
	$str_html_tag_relation_post = keni_format_checkbox( 'keni_tag_relation_post', $flag_tag_relation, $arr_list_tag_relation, true );
	$str_html_relation_lists = keni_format_relation_lists( $arr_set_relation );

	if ( $post->post_type == 'post' ) {
		echo sprintf( keni_format_relation_post(), $str_html_relation_disp_post, $str_html_category_relation_post, $str_html_tag_relation_post, $str_html_relation_lists );
	}
	else if ( $post->post_type == 'page' ) {
		echo sprintf( keni_format_relation_page(), $str_html_relation_disp_post, $str_html_tag_relation_post, $str_html_relation_lists );
	}
}

function keni_save_meta_box_relation_post( $post_id ){
	$str_nonce = isset($_POST['keni_meta_box_relation_post_nonce']) ? $_POST['keni_meta_box_relation_post_nonce'] : null;

	if ( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// get post
	$flag_get_relation_disp_post = isset( $_POST['keni_relation_disp_post'] ) ? $_POST['keni_relation_disp_post']: '';
	$flag_category_relation_post = isset( $_POST['keni_category_relation_post'] ) ? $_POST['keni_category_relation_post']: '';
	$flag_tag_relation_post = isset( $_POST['keni_tag_relation_post'] ) ? $_POST['keni_tag_relation_post']: '';
	$arr_relation_post = isset( $_POST['keni_relation_post'] ) ? $_POST['keni_relation_post']: '';

	// save relation display
	update_post_meta( $post_id, 'keni_relation_disp_post', $flag_get_relation_disp_post );

	// save category relation
	if ( $flag_get_relation_disp_post == '1' && empty( $flag_category_relation_post ) && empty( $flag_tag_relation_post ) && empty( $arr_relation_post ) ) {
		$flag_category_relation_post = '1';
	}
	if ( ! empty( $flag_category_relation_post ) ) {
		update_post_meta( $post_id, 'keni_category_relation_post', $flag_category_relation_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_category_relation_post' );
	}

	// save tag relation
	if ( ! empty( $flag_tag_relation_post ) ) {
		update_post_meta( $post_id, 'keni_tag_relation_post', $flag_tag_relation_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_tag_relation_post' );
	}

	// save relation lists
	if ( ! empty( $arr_relation_post ) && is_array( $arr_relation_post ) ) {
		$update_relation_data = array();
		foreach ( $arr_relation_post as $no => $val ) {
			if ( ! isset( $val['title'] ) ) $val['title'] = "";
			if ( ! isset( $val['blank'] ) ) $val['blank'] = "";
			if ( ! isset( $val['image'] ) ) $val['image'] = "";
			if ( $val['url'] != "" && ( ! isset( $arr_relation_post[$no]['image'] ) || ( $arr_relation_post[$no]['image'] == "" ) ) ) {
				$site_data = wp_remote_get( $val['url'] );

				if ( ! is_wp_error( $site_data ) && $site_data['response']['code'] === 200 && $site_data['body'] != "" ) {
					$content =  $site_data['body'];

					preg_match_all( '/og:image.*?content="(http.*?[gif|jpg|jpeg|png])"/u', $content, $images );
					if ( ! isset( $images[1][0] ) ) preg_match_all( '/itemprop.*?image.+?content="(http.+?[gif|jpg|jpeg|png])" \/>/u', $content, $images );
					$val['image'] = ( isset( $images[1][0]) && !empty( $images[1][0] ) ) ? $images[1][0] : "";
				}
			}

			if ( $val['url'] != "" ) $update_relation_data[] = $val;
		}

		update_post_meta( $post_id, 'keni_relation_post', $update_relation_data );
	}
	else {
		delete_post_meta( $post_id, 'keni_relation_post' );
	}

}

/**
 * Format relation post form
 * @return string   form html
 */
function keni_format_relation_post() {
	$html = '
			%s
			<div style="padding-left: 2em;">
			<p>既に公開されている記事から、記事と同一の「カテゴリー」と「タグ」に含まれているものをランダムに表示する事が出来ます。<br />
			両方にチェックが入っている場合には、カテゴリが優先されます。</p>
			%s
			%s
			<p>「カテゴリー」「タグ」以外の任意のURLを設定することも可能です。（その場合、以下で設定したURLが優先的に表示されます。）<br />
			左から「記事タイトル」「記事URL」を入力して下さい。<br />リンクを新ウィンドウで開きたい場合は、右のチェックボックスにチェックを入れて下さい。</p>
			<p class="keni_note">ベーシック認証がされているURLは入力ができません</p>
			%s
			</div>';

	return $html;
}

/**
 * Format relation page form
 * @return string   form html
 */
function keni_format_relation_page() {
	$html = '
			%s
			<div style="padding-left: 2em;">
			<p>既に公開されている記事から、記事と同一の「タグ」に含まれているものをランダムに表示する事が出来ます。</p>
			%s
			<p>「タグ」以外の任意のURLを設定することも可能です。（その場合、以下で設定したURLが優先的に表示されます。）<br />
			左から「記事タイトル」「記事URL」を入力して下さい。<br />リンクを新ウィンドウで開きたい場合は、右のチェックボックスにチェックを入れて下さい。</p>
			%s
			</div>';

	return $html;
}


/**
 * Format relation lists
 * @return string   html
 */
function keni_format_relation_lists( $relation ) {
	$html = '<ol class="keni_relation_lists">' . "\n";

	foreach ( $relation as $no => $val ) {

		$str_html_relation_title_post = keni_format_text( 'keni_relation_post[' . $no . '][title]', $val["title"], 'keni_relation_title', __( 'Post Title', 'keni' ) ); // 記事タイトル
		$str_html_relation_url_post = keni_format_text( 'keni_relation_post[' . $no . '][url]', $val["url"], 'keni_relation_url', __( 'Post URL', 'keni' ) ); // 記事URL
		$str_checked = ( $val['blank'] == "1" )? ' checked="checked"' : '' ;
		$str_html_relation_blank_post = '<input type="checkbox" name="keni_relation_post[' . $no . '][blank]" value="1"' . $str_checked . ' />';

		$html .= '<li>
				<span class="keni_relation_title">' . $str_html_relation_title_post . '</span>
				<span class="keni_relation_url">' . $str_html_relation_url_post . '</span>
				<span class="keni_relation_blank">' . $str_html_relation_blank_post . '</span>
				</li>';
	}

	$html .= "</ol>\n";
	return $html;
}


/**
 * 関連記事を表示する関数
 * @return string   html
 */
if ( ! function_exists( 'the_keni_relation' ) ) {
	function the_keni_relation() {
		echo get_keni_relation();
	}
}

if ( ! function_exists( 'get_keni_relation' ) ) {
	function get_keni_relation() {
		$relation = array();
		$str_li_list = "";
		global $post;
		$post_id = get_the_ID();

        // 関連記事数
        $keni_related_post_count = apply_filters( 'keni_related_post_count', 6 );
        $keni_related_post_count = apply_filters( 'keni_relation_link_count', $keni_related_post_count );   // 賢威7.1対応

        // 関連記事ソート
        $keni_related_post_orderby = apply_filters( 'keni_relation_link_orderby', 'rand' );
        // ソート順
        $keni_relation_link_order = apply_filters( 'keni_relation_link_order', 'DESC' );

        // 含める投稿タイプ（タグ）
		$keni_relation_link_post_type = apply_filters( 'keni_relation_link_post_type', array('post', 'page') );
        // 表示設定
		$flag_get_relation_disp = get_option( 'keni_relation_disp' );
		$flag_get_relation_style = get_option( 'keni_relation_style' );
		$flag_get_relation_disp_post = get_post_meta( get_the_ID(), 'keni_relation_disp_post', true );

		$category_relation = "";
		$tag_relation = "";
		if ( $flag_get_relation_disp_post == "" ) {
			// 全体設定
			if ( $flag_get_relation_disp == "show" ) {
				$category_relation = get_option( 'keni_category_relation' );
				$tag_relation = get_option( 'keni_tag_relation' );
			}
			else if ( $flag_get_relation_disp == "hide" ) {
				return;
			}
		}
		else if ( $flag_get_relation_disp_post == "show" ) {
			$category_relation = get_post_meta( get_the_ID(), 'keni_category_relation_post', true );
			$tag_relation = get_post_meta( get_the_ID(), 'keni_tag_relation_post', true );
		}
		else if ( $flag_get_relation_disp_post == "hide" ) {
			return;
		}

		if( ! is_home() && ! is_front_page() ) {
			$arr_relation_post = get_post_meta(get_the_ID(),'keni_relation_post', true);
			if ( ! empty( $arr_relation_post ) && is_array( $arr_relation_post ) ) {
				foreach ( $arr_relation_post as $key => $relation_post ) {
					$url  = rawurldecode( $relation_post['url'] );

					$relation[ $url ]['title'] = $relation_post['title'];
					$relation[ $url ]['target'] = $relation_post['blank'];

					// 入力されたURLから記事IDが取得できる場合は、その投稿のアイキャッチ画像を設定する
					$this_post_id = url_to_postid( $relation_post['url'] );
					if ( ! empty( $this_post_id ) ) {
						if ( $relation_post['title'] == "" ) {
							// 記事情報取得
							$this_post_obj             = get_post( $this_post_id );
							$relation[ $url ]['title'] = $this_post_obj->post_title;
						}
						// アイキャッチ取得
						$image_id = get_post_thumbnail_id( $this_post_id );
						$image_url_data = wp_get_attachment_image_src( $image_id, 'large_thumb' );
						$relation[$url]['image'] = (isset($image_url_data[0])) ? $image_url_data[0] : '';

					} else {
						$relation[$url]['image'] = $relation_post['image'];
					}
				}
			}
		}


        if ( count( $relation ) < $keni_related_post_count) {

			// カテゴリから取得する
			if ( $category_relation == "1" ) {

				// 優先カテゴリを取得し、その情報を取得
				$primary_cat_id = get_post_meta( get_the_ID(), 'keni_primary_category_post', true );
				if ( ! empty( $primary_cat_id ) ) {
					$tag_query = array(
						'showposts' => $keni_related_post_count,
						'cat' => $primary_cat_id,
						'orderby' => $keni_related_post_orderby,
						'order' => $keni_relation_link_order,
						'post__not_in' => array( $post_id )
					);
					$tag_query = apply_filters( 'keni_related_post_cat_query', $tag_query, $post_id );
					$rand_posts = new WP_Query( $tag_query );
					if ( $rand_posts->have_posts() ) {
						if ( $rand_posts->have_posts()) {
							while( $rand_posts->have_posts() ) {
								$rand_posts->the_post();
								if ( count( $relation ) < $keni_related_post_count ) {
									$url                        = rawurldecode( get_permalink( $post->ID ) );
									$relation[ $url ]['title']  = $post->post_title;
									$relation[ $url ]['target'] = '';

									$thumbnail_id              = get_post_thumbnail_id( $post->ID );
									$thumbnail                 = wp_get_attachment_image_src( $thumbnail_id, 'large_thumb' );
									$relation[ $url ]['image'] = isset( $thumbnail[0] ) ? $thumbnail[0] : '';
								}
							}
						}
					}
					wp_reset_query();
				}

                if (count($relation) < $keni_related_post_count) {
					$target_category = get_the_category(get_the_ID());
					if (isset($target_category) && is_array($target_category)  && count($target_category) > 0) {
						foreach ($target_category as $cat_val) {
							if ($cat_val->cat_ID != $primary_cat_id) $cat_list[] = $cat_val->cat_ID;
						}
					}

					if (isset($cat_list) && count($cat_list) > 0) {
						$tag_query = array(
							'showposts' => $keni_related_post_count,
							'cat' => implode(",", $cat_list),
							'orderby' => $keni_related_post_orderby,
							'order' => $keni_relation_link_order,
							'post__not_in' => array( $post_id )
						);
						$tag_query = apply_filters( 'keni_related_post_cat_second_query', $tag_query, $post_id );
						$rand_posts = new WP_Query( $tag_query );
						if ( $rand_posts->have_posts() ) {
							if ( $rand_posts->have_posts()) {
								while ( $rand_posts->have_posts() ) {
									$rand_posts->the_post();
									$url                        = rawurldecode( get_permalink( $post->ID ) );
									$relation[ $url ]['title']  = $post->post_title;
									$relation[ $url ]['target'] = '';

									$thumbnail_id              = get_post_thumbnail_id( $post->ID );
									$thumbnail                 = wp_get_attachment_image_src( $thumbnail_id, 'large_thumb' );
									$relation[ $url ]['image'] = isset( $thumbnail[0] ) ? $thumbnail[0] : '';

									$relation[ $url ] = apply_filters( 'keni_relation_cat_data', $relation[ $url ], get_the_ID() );
								}
							}
						}
						wp_reset_query();
					}
				}
			}
		}

        if ( count( $relation ) < $keni_related_post_count ) {

			// タグから取得する
			if ( $tag_relation == "1" ) {
				$target_tags= get_the_tags();
				if (isset($target_tags) && is_array($target_tags) && count($target_tags) > 0) {
					foreach ($target_tags as $tag_val) {
						$tag_list[] = $tag_val->term_id;
					}
				}

				if (isset($tag_list) && count($tag_list) > 0) {
					$tag_query = array(
						'post_type' => $keni_relation_link_post_type,
						'tag__in' => $tag_list,
						'showposts' => $keni_related_post_count,
						'orderby' => $keni_related_post_orderby,
						'order' => $keni_relation_link_order,
						'post__not_in' => array( $post_id )
					);
					$tag_query = apply_filters( 'keni_related_post_tag_query', $tag_query );
					$query = new WP_Query( $tag_query );
					if ( $query->have_posts()) : while( $query->have_posts() ) : $query->the_post();
                        if (count($relation) < $keni_related_post_count) {
							$url = rawurldecode(get_permalink( $post->ID ));
							$relation[$url]['title'] = get_the_title();
							$relation[$url]['target'] = '';

							$thumbnail_id = get_post_thumbnail_id(get_the_ID());
							$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'large_thumb');
							$relation[$url]['image'] = isset($thumbnail[0]) ? $thumbnail[0] : '';
						}
						endwhile;
					endif;
					wp_reset_query();
				}
			}
		}

		$str_relation_style = '';
		$str_img_width = '';
		if ( $flag_get_relation_style == '1' ) {
			$str_relation_style = 'related-entry-list_style01';
			$str_img_width = ' width="150"';
		}
		else if ( $flag_get_relation_style == '2' ) {
			$str_relation_style = 'related-entry-list_style02';
		}

		if ( count( $relation ) > 0 ) {
			foreach ($relation as $url => $val) {

				$str_target = ($val['target'] == "1")? ' target="_blank"' : '' ;

				$str_image_url = ( $val['image'] != "" ) ? $val['image'] : get_stylesheet_directory_uri() . '/images/no-image.jpg';
				$str_html = '<li class="related-entry-list_item"><figure class="related-entry_thumb"><a href="' . $url . '" title="' . esc_attr($val['title']) . '"' . $str_target . '><img src="' . $str_image_url . '" class="relation-image"' . $str_img_width . '></a></figure><p class="related-entry_title"><a href="' . $url . '" title="' . esc_attr($val['title']) . '"' . $str_target . '>' . esc_attr($val['title']) . '</a></p></li>';
				$str_li_list .= apply_filters( 'keni_relation_li_list', $str_html, $url, $val, $str_image_url );

			}
		}

		if ( ! empty( $str_li_list ) ) {

			return sprintf( keni_format_related_template(), $str_relation_style, $str_li_list );

		}

	}
}

/**
 * format related template
 * @return string
 */
function keni_format_related_template() {

	return '<div class="keni-related-area keni-section_wrap keni-section_wrap_style02">
			<section class="keni-section">

			<h2 class="keni-related-title">' . __('Related Posts','keni') . '</h2>

			<ul class="related-entry-list %s">
			%s
			</ul>


			</section><!--keni-section-->
		</div>';
}

//-----------------------------------------------------
// この投稿だけの個別CSS／JS記述欄
//-----------------------------------------------------
add_action( 'admin_menu', 'keni_add_meta_box_add_script_post' );
add_action( 'save_post', 'keni_save_meta_box_add_script_post' );

function keni_add_meta_box_add_script_post() {
	add_meta_box( 'add_script', __( 'CSS/JS for this post', 'keni' ), 'keni_insert_meta_box_add_script_post', array( 'post', 'page' ), 'normal', 'low' ); // この投稿だけの個別CSS／JS記述欄
}

function keni_insert_meta_box_add_script_post(){
	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_add_script_post_nonce' );

	// set add script
	$str_add_script_post = get_post_meta( $post->ID, 'keni_add_script_post', true );

	// display add script
	echo keni_format_textarea( 'keni_add_script_post', $str_add_script_post, 'large-text' );
}

function keni_save_meta_box_add_script_post( $post_id ){
	$str_nonce = isset($_POST['keni_meta_box_add_script_post_nonce']) ? $_POST['keni_meta_box_add_script_post_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$str_get_add_script_post = isset( $_POST['keni_add_script_post'] ) ? $_POST['keni_add_script_post']: '';
	if( !empty( $str_get_add_script_post ) ){
		update_post_meta( $post_id, 'keni_add_script_post', $str_get_add_script_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_add_script_post' );
	}

}

/**
 * 個別のCSS/JS 追加
 * 最後に追加 999
 */
add_action( 'wp_footer', 'keni_output_add_script_post', 999 );
function keni_output_add_script_post() {
	remove_action('wp_head', 'wp_custom_css_cb', 101);  // 追加CSSを最後に追加するため削除
	add_action( 'wp_enqueue_scripts', 'wp_custom_css_cb', 101 );    // WordPressの「追加CSS」をここで呼び出し


	$script_str = "";

	if ( is_singular() ) {
		global $post;
		$str_add_script_post = get_post_meta( $post->ID, 'keni_add_script_post', true );

		if ( ! empty( $str_add_script_post ) ) {
			$script_str .= $str_add_script_post . "\r\n";
		}

	}
	echo $script_str;
}

//-----------------------------------------------------
// アイキャッチ画像 個別設定
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_thumbnail_disp_post');
add_action('save_post', 'keni_save_meta_box_thumbnail_disp_post');

function keni_add_meta_box_thumbnail_disp_post() {
	add_meta_box('thumbnail_disp', __( 'Thumbnail for Single', 'keni' ), 'keni_insert_meta_box_thumbnail_disp_post', array( 'post', 'page' ), 'side', 'default');
}

function keni_insert_meta_box_thumbnail_disp_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_thumbnail_disp_post_nonce' );

	// get setting
	$flag_get_thumbnail_disp_post = get_post_meta( $post->ID, 'keni_thumbnail_disp_post', true );

	if ( empty( $flag_get_thumbnail_disp_post ) ) {
		$flag_get_thumbnail_disp_post = "";
	}

	$arr_list_thumbnail_disp_post = array(
		array( "", __( 'Use Default Setting', 'keni' ) ),
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);

	echo keni_format_radio( 'keni_thumbnail_disp_post', $flag_get_thumbnail_disp_post, $arr_list_thumbnail_disp_post );

}

function keni_save_meta_box_thumbnail_disp_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_thumbnail_disp_post_nonce']) ? $_POST['keni_meta_box_thumbnail_disp_post_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$flag_get_thumbnail_disp_post = isset( $_POST['keni_thumbnail_disp_post'] ) ? $_POST['keni_thumbnail_disp_post']: '';
	if( !empty( $flag_get_thumbnail_disp_post ) ){
		update_post_meta( $post_id, 'keni_thumbnail_disp_post', $flag_get_thumbnail_disp_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_thumbnail_disp_post' );
	}
}


/**
 * 個別ページのアイキャッチ画像表示設定取得
 * @return bool
 */
if ( ! function_exists( 'keni_is_thumbnail' ) ) {

	function keni_is_thumbnail() {
		global $post;

		$bool = true;

		$flag_get_thumbnail_disp_post = get_post_meta( $post->ID, 'keni_thumbnail_disp_post', true );

		if ( $flag_get_thumbnail_disp_post == "hide" ) {

			$bool = false;

		}
		else if ( empty( $flag_get_thumbnail_disp_post ) ) {

			$flag_get_thumbnail_disp = get_option( 'keni_thumbnail_disp' );

			if ( $flag_get_thumbnail_disp == "hide" ) {

				$bool = false;

			}
		}

		return $bool;

	}
}


//-----------------------------------------------------
// 目次 個別設定
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_toc_disp_post');
add_action('save_post', 'keni_save_meta_box_toc_disp_post');

function keni_add_meta_box_toc_disp_post() {
	add_meta_box('toc_disp', __( 'TOC Display Setting', 'keni' ), 'keni_insert_meta_box_toc_disp_post', array( 'post', 'page' ), 'side', 'default');
}

function keni_insert_meta_box_toc_disp_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_toc_disp_post_nonce' );

	// get setting
	$flag_get_toc_disp_post = get_post_meta( $post->ID, 'keni_toc_disp_post', true );

	if ( empty( $flag_get_toc_disp_post ) ) {
		$flag_get_toc_disp_post = "";
	}

	$arr_list_toc_disp_post = array(
		array( "", __( 'Use Default Setting', 'keni' ) ),
		array( "hide", __( 'Not Display', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
	);

	echo keni_format_radio( 'keni_toc_disp_post', $flag_get_toc_disp_post, $arr_list_toc_disp_post );

}

function keni_save_meta_box_toc_disp_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_toc_disp_post_nonce']) ? $_POST['keni_meta_box_toc_disp_post_nonce'] : null;

	if( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$flag_get_toc_disp_post = isset( $_POST['keni_toc_disp_post'] ) ? $_POST['keni_toc_disp_post']: '';
	if( !empty( $flag_get_toc_disp_post ) ){
		update_post_meta( $post_id, 'keni_toc_disp_post', $flag_get_toc_disp_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_toc_disp_post' );
	}
}


/**
 * 個別ページのアイキャッチ画像表示設定取得
 * 初期設定は非表示
 * @return bool
 */
if ( ! function_exists( 'keni_is_toc' ) ) {

	function keni_is_toc() {
		global $post;

		$bool = false;
		if ( !is_singular() ) {
			return $bool;
		}

		$flag_get_toc_disp_post = get_post_meta( $post->ID, 'keni_toc_disp_post', true );

		if ( $flag_get_toc_disp_post == "show" ) {

			$bool = true;

		}
		else if ( empty( $flag_get_toc_disp_post ) ) {

			$flag_get_toc_disp = get_option( 'keni_toc_disp' );
			if ( $flag_get_toc_disp == "show" ) {
				$bool = true;
			}
		}
		return $bool;
	}
}

/**
 * 保護中記事のパスワードフォーム前にコンテンツを表示
 * <!--more--> まで
 * @param $content_str
 *
 * @return string
 */
if ( ! function_exists( 'keni_password_form' ) ) {
	function keni_password_form( $content_str = "" ) {
		global $post;
		if ( ! strpos( $post->post_content, '<!--more-->' ) ) {
			return $content_str;
		}

		$content = explode( '<!--more-->', $post->post_content );
		return $content[0] . $content_str;
	}

}

/**
 * パスワード保護記事のタイトルで <!--more--> がある場合は 保護中: を付けない
 * @param $title
 * @return string
 */
if ( ! function_exists( 'keni_password_title_format' ) ) {
	function keni_password_title_format( $title ) {
		global $post;

		if ( ! strpos( $post->post_content, '<!--more-->' ) ) {
			return $title;
		}

		return '%s';
	}
}


/**
 * テキスト整形を無効化
 * 利用時は functions.php 等に
 * add_filter( 'init', 'keni_remove_format' );
 * を記述する
 * keni_remove_format
 */
if ( ! function_exists( 'keni_remove_format' ) ) {
	function keni_remove_format() {
		$wpautop_flg = apply_filters( 'keni_remove_wpautop', true );
		if ( $wpautop_flg === true ) {
			remove_filter( 'the_content', 'wpautop', 10 );
		}
		$wptexturize_flg = apply_filters( 'keni_remove_wptexturize', true );
		if ( $wptexturize_flg === true ) {
			remove_filter( 'the_content', 'wptexturize', 10 );
		}
		$widget_wpautop_flg = apply_filters( 'keni_remove_widget_wpautop', true );
		if ( $widget_wpautop_flg === true ) {
			remove_filter( 'widget_text_content', 'wpautop', 10 );
		}
		$widget_wptexturize_flg = apply_filters( 'keni_remove_widget_wptexturize', true );
		if ( $widget_wptexturize_flg === true ) {
			remove_filter( 'widget_text_content', 'wptexturize', 10 );
		}

		$mce_options_flg = apply_filters( 'keni_mce_options', true );
		if ( $mce_options_flg === true ) {
			add_filter( 'tiny_mce_before_init', 'keni_override_mce_options' );
		}
	}
}

/**
 * keni_override_mce_options
 * @param $init_array
 *
 * @return mixed
 */
if ( ! function_exists( 'keni_override_mce_options' ) ) {
	function keni_override_mce_options( $init_array ) {
		global $allowedposttags;
//		$init_array['valid_elements']          = '*[*]';
//		$init_array['extended_valid_elements'] = '*[*]';
//		$init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
		$init_array['indent']                  = true;
		$init_array['wpautop']                 = false;
		$init_array['force_p_newlines']        = false;
		$init_array = apply_filters( 'keni_override_mce_options', $init_array );
		return $init_array;
	}
}

/**
 * 投稿タイプに応じたテンプレートファイルを取得する
 *
 * @return false|string
 */
if ( ! function_exists( 'keni_get_template_post_type' ) ) {
	function keni_get_template_post_type() {
		$template_post_type = "post";
		if ( locate_template( 'template-parts/content-' . get_post_type() . '.php' ) ) {
			$template_post_type = get_post_type();
		}
		$template_post_type = apply_filters( 'keni_get_template_post_type', $template_post_type );

		return $template_post_type;
	}
}


/**
 * 最新情報リスト
 *
 * @param string $target
 * @param int $num_of_posts
 * @param int $excerpt
 * @param string $show_date
 * @param int $catid
 * @param string $show_cat
 *
 * @return string
 */
if ( ! function_exists( 'newposts_keni' ) ) {
	function newposts_keni( $target = "new", $num_of_posts = 5, $excerpt = 1, $show_date = "default", $catid = 0, $show_cat = "true" ) {

		$res_data = posts_list_keni( $target, $num_of_posts, $excerpt, $show_date, "category", $catid, $show_cat, "" );

		return $res_data;
	}
}

/**
 * 記事一覧表示
 * @param string $target
 * @param int $num_of_posts
 * @param int $excerpt
 * @param string $show_date
 * @param string $kind
 * @param int $var_id
 * @param string $show_tag
 * @param string $title_str
 *
 * @return string
 */
if ( ! function_exists( 'posts_list_keni' ) ) {
	function posts_list_keni( $target = "new", $num_of_posts = 5, $excerpt = 1, $show_date = "default", $kind = "category", $var_id = 0, $show_tag = "true", $title_str = "", $ex_cat = "" ) {

		$show_pv = apply_filters( 'keni_posts_list_show_pv', '' );

		wp_reset_query();

		// HTML格納変数
		$res_data = "\n\n";

		// カテゴリー除外IDを取得
		$ex       = apply_filters( 'posts_list_keni_ex_cat', $ex_cat );    // ver.7 では the_keni('new_info_ex_cat') で除外していた
		$ex_array = explode( ",", $ex );
		foreach ( $ex_array as $ex_id ) {
			if ( is_numeric( $ex_id ) ) {
				$ex_ids[] = $ex_id;
			}
		}

		// 検索条件
		$cond_array                        = array();
		$cond_array['posts_per_page']      = $num_of_posts;
		$cond_array['nopaging']            = 0;
		$cond_array['post_status']         = 'publish';
		$cond_array['ignore_sticky_posts'] = 1;

		// targetにより切り分け
		if ( $target == "new" ) {
			$res_data .= "<h2>" . ( $title_str != "" ? $title_str : __( 'Latest Info', 'keni' ) ) . "</h2>\n";
		} else {
			$res_data                          .= "<h2>" . ( $title_str != "" ? $title_str : __( 'Your blog&#8217;s WordPress Pages', 'keni' ) ) . "</h2>\n";
			$sticky                            = get_option( 'sticky_posts' );
			$cond_array['ignore_sticky_posts'] = 1;
			$cond_array['post__in']            = $sticky;
		}
		if ( ! is_array( $var_id ) && strpos( $var_id, "," ) > 0 ) {
			$var_id = explode( ",", $var_id );
		}
		switch ( $kind ) {
			case "tag":
				if ( ! is_array( $var_id ) ) {
					if ( is_numeric( $var_id ) ) {
						$cond_array['tag_id'] = $var_id;
					} else {
						$cond_array['tag'] = $var_id;
					}
				} else {
					if ( is_numeric( $var_id[0] ) ) {
						$cond_array['tag__in'] = $var_id;
					} else {
						$cond_array['tag_slug__in'] = $var_id;
					}
				}
				break;
			case "author":
				if ( ! is_array( $var_id ) ) {
					$cond_array['author'] = $var_id;
				} else {
					$cond_array['author__in'] = $var_id;
				}
				break;
			case "category":
			default:
				$cond_array['cat'] = $var_id;
				if ( isset( $ex_ids ) && is_array( $ex_ids ) && count( $ex_ids ) > 0 ) {
					$cond_array['category__not_in'] = $ex_ids;
				}
		}

		ob_start();

		if ( ! empty( $cond_array ) && count( $cond_array ) > 0 ) {
			$r = new WP_Query( $cond_array );
			if ( $r->have_posts() ) {
//				echo '<div class="keni-section_wrap keni-section_wrap_style02">';
//				echo '<div class="keni-section">';
//				echo '<div class="entry-list ' . get_keni_layout_post_list_class() . '">';
				while ( $r->have_posts() ) {
					$r->the_post();
					get_template_part( 'template-parts/content', 'archive' );
				}
//				echo '</div></div></div>';
			}
		}
		$post_list_echo = ob_get_contents();
		ob_end_clean();

		$post_list_echo = str_replace("<h2 ", "<h3 ", $post_list_echo );
		$post_list_echo = str_replace( "/h2>", "/h3>", $post_list_echo );

		$res_data .= $post_list_echo;

		wp_reset_query();

		return $res_data;
	}
}