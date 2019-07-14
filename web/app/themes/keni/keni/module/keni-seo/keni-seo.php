<?php
//-----------------------------------------------------
// 基本設定 - SEO
//-----------------------------------------------------

/**
 * add menu
 */
function keni_admin_seo () {
	add_submenu_page('keni_admin_menu', __( 'Keni Settings seo', 'keni' ), __( 'Keni Settings seo', 'keni' ), 'administrator', 'keni_admin_menu_seos', 'keni_setting_page_seos');
	add_action( 'admin_init', 'keni_register_seo','admin-head');
}
add_action( 'admin_menu', 'keni_admin_seo' );

/**
 * 初期値
 */
function keni_default_seo() {
	$flag_get_noindex_dates = get_option( 'keni_noindex_dates' );
	if ( empty( $flag_get_noindex_dates ) ) {
		add_option( 'keni_noindex_dates', '1' );
	}
	$flag_get_noindex_authors = get_option( 'keni_noindex_authors' );
	if ( empty( $flag_get_noindex_authors ) ) {
		add_option( 'keni_noindex_authors', '1' );
	}
	$flag_get_noindex_searchs = get_option( 'keni_noindex_searchs' );
	if ( empty( $flag_get_noindex_searchs ) ) {
		add_option( 'keni_noindex_searchs', '1' );
	}

}
add_action( 'init' , 'keni_default_seo' );

/**
 * Register SEO
 */
function keni_register_seo() {
	register_setting( 'keni-initialize-setting_page_seos', 'keni_disabled_canonical' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_disabled_description' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_home' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_categorys' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_tags' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_dates' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_authors' );
	register_setting( 'keni-initialize-setting_page_seos', 'keni_noindex_searchs' );
}

function keni_setting_page_seos() {

	$str_option_group = 'keni-initialize-setting_page_seos';

	/* set canonical */
	$arr_get_disabled_canonical = get_option( 'keni_disabled_canonical' );
	$arr_list_disabled_canonical = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_canonical = keni_format_checkbox( 'keni_disabled_canonical', $arr_get_disabled_canonical, $arr_list_disabled_canonical );

	/* set description */
	$arr_get_disabled_description = get_option( 'keni_disabled_description' );
	$arr_list_disabled_description = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_description = keni_format_checkbox( 'keni_disabled_description', $arr_get_disabled_description, $arr_list_disabled_description );

	/* set noindex */
	# radio list
	$arr_list_noindex_home = array(
		array( "index", __( 'Enable index', 'keni' ) ),
		array( "2", __( 'Enable noindex', 'keni' ) ), // 2ページ目以降はnoindexと同じ動きのため"2"を設定
	);
	$arr_list_noindex_common = array(
		array( "index", __( 'Enable index', 'keni' ) ),
		array( "1", __( 'Enable noindex', 'keni' ) ),
		array( "2", __( 'Enable noindex page 2 and after', 'keni' ) ), // 2ページ目以降はnoindex
	);

	# home
	$flag_get_noindex_home = get_option( 'keni_noindex_home', 'index' );
	$str_html_noindex_home = keni_format_radio( 'keni_noindex_home', $flag_get_noindex_home, $arr_list_noindex_home );

	# category
	$flag_get_noindex_categorys = get_option( 'keni_noindex_categorys', 'index' );
	$str_html_noindex_categorys = keni_format_radio( 'keni_noindex_categorys', $flag_get_noindex_categorys, $arr_list_noindex_common );

	# tag
	$flag_get_noindex_tags = get_option( 'keni_noindex_tags', 'index' );
	$str_html_noindex_tags = keni_format_radio( 'keni_noindex_tags', $flag_get_noindex_tags, $arr_list_noindex_common );

	# date
	$flag_get_noindex_dates = get_option( 'keni_noindex_dates' );
	$str_html_noindex_dates = keni_format_radio( 'keni_noindex_dates', $flag_get_noindex_dates, $arr_list_noindex_common );

	# author
	$flag_get_noindex_authors = get_option( 'keni_noindex_authors' );
	$str_html_noindex_authors = keni_format_radio( 'keni_noindex_authors', $flag_get_noindex_authors, $arr_list_noindex_common );

	# search
	$flag_get_noindex_searchs = get_option( 'keni_noindex_searchs' );
	$str_html_noindex_searchs = keni_format_radio( 'keni_noindex_searchs', $flag_get_noindex_searchs, $arr_list_noindex_common );



	// canonical
	$arr_metaboxs[] =  sprintf( keni_format_setting_canonical(), $str_html_disabled_canonical );
	// description
	$arr_metaboxs[] =  sprintf( keni_format_setting_description(), $str_html_disabled_description );
	// index
	$arr_metaboxs[] =  sprintf( keni_format_setting_index(),
								$str_html_noindex_home,
								$str_html_noindex_categorys,
								$str_html_noindex_tags,
								$str_html_noindex_dates,
								$str_html_noindex_authors,
								$str_html_noindex_searchs );

	keni_the_format_options_form( $str_option_group, $arr_metaboxs );
}

/**
 * Format canonical
 * @return string html
 */
function keni_format_setting_canonical() {
	$title = __('Canonical Setting for Keni', 'keni');
	$main ='<p>%s</p>
			<p class="description">' . __('Notice: If disabled setting, disabled cannonical setting are set each post' , 'keni') . '</p>';
	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format canonical
 * @return string html
 */
function keni_format_setting_description() {
	$title = __('Meta Description Setting for Keni', 'keni');
	$main ='<p>%s</p>';
	return keni_format_metabox_holder( $title, $main );
}


/**
 * Format index
 * @return string html
 */
function keni_format_setting_index() {
	$title = __('Index settings' , 'keni');
	$main ='<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Archive Index Setting for Page 2 and after', 'keni') . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Category Page', 'keni') .'</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Tag Page', 'keni') .'</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Date Page', 'keni') .'</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Auther Page', 'keni') .'</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __('Search Result Page', 'keni') .'</label></p>
			%s';
	return keni_format_metabox_holder( $title, $main );
}



//-----------------------------------------------------
// title blogname
//-----------------------------------------------------
/**
 * post
 */
add_action('admin_menu', 'keni_add_meta_box_title_blogname_post');
add_action('save_post', 'keni_save_meta_box_title_blogname_post');

function keni_add_meta_box_title_blogname_post() {
	add_meta_box('title_blogname', __( 'Show Site Title in &lt;title&gt;', 'keni' ), 'keni_insert_meta_box_title_blogname_post', array( 'post', 'page' ) , 'side', 'default');
}

function keni_insert_meta_box_title_blogname_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_title_blogname_post_nonce' );

	// get setting
	$str_get_title_blogname_post = get_post_meta( $post->ID, 'keni_title_blogname_post', true );

	if ( empty( $str_get_title_blogname_post ) ) {
		$str_get_title_blogname_post = "";
	}

	$arr_list_title_blogname = array(
		array( "", __( 'Use Default Setting', 'keni' ) ),
		array( "show", __( 'Display', 'keni' ) ),
		array( "hide", __( 'Not Display', 'keni' ) ),
	);

	echo keni_format_radio( 'keni_title_blogname_post', $str_get_title_blogname_post, $arr_list_title_blogname );

}

function keni_save_meta_box_title_blogname_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_title_blogname_post_nonce']) ? $_POST['keni_meta_box_title_blogname_post_nonce'] : null;

	if( !wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$str_get_title_blogname_post = isset( $_POST['keni_title_blogname_post'] ) ? $_POST['keni_title_blogname_post']: '';
	if( !empty( $str_get_title_blogname_post ) ){
		update_post_meta( $post_id, 'keni_title_blogname_post', $str_get_title_blogname_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_title_blogname_post' );
	}
}


//-----------------------------------------------------
// noindex
//-----------------------------------------------------
/**
 * post 
 */
add_action('admin_menu', 'keni_add_meta_box_index_post');
add_action('save_post', 'keni_save_meta_box_index_post');

function keni_add_meta_box_index_post() {
	add_meta_box('noindex', __( 'index', 'keni' ), 'keni_insert_meta_box_index_post', array( 'post', 'page' ) , 'side', 'high');
}

function keni_insert_meta_box_index_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_index_post_nonce' );

	// get setting
	$arr_get_noindex_post = get_post_meta( $post->ID, 'keni_noindex_post', true );

	$arr_list_index = array(
		array( "1", __( 'Enable noindex', 'keni' ) ),
	);

	echo keni_format_checkbox( 'keni_noindex_post', $arr_get_noindex_post, $arr_list_index );

}

function keni_save_meta_box_index_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_index_post_nonce']) ? $_POST['keni_meta_box_index_post_nonce'] : null;

	if( !wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$arr_get_noindex_post = isset( $_POST['keni_noindex_post'] ) ? $_POST['keni_noindex_post']: '';
	if( !empty( $arr_get_noindex_post ) ){
		update_post_meta( $post_id, 'keni_noindex_post', $arr_get_noindex_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_noindex_post' );
	}
}

/**
 * category | tag
 */
function keni_term_edit_form_fields_noindex( $term ) {
	$num_term_id = $term->term_id;

	if ( function_exists( "get_term_meta" ) ) {
		// wordpress 4.4.0以降
		$flag_get_noindex_term = get_term_meta( $num_term_id, "keni_noindex_term", true );
	}
	else {
		$flag_get_noindex_term = get_option( "keni_noindex_term_" . $num_term_id );
	}

	$arr_list_noindex = array(
		array( "", __( 'Use Common Setting', 'keni' ) ),
		array( "index", __( 'Enable index', 'keni' ) ),
		array( "1", __( 'Enable noindex', 'keni' ) ),
		array( "2", __( 'Enable noindex page 2 and after', 'keni' ) ),
	);

	$str_html_noindex = keni_format_select( 'keni_term_meta[keni_noindex_term]', $flag_get_noindex_term, $arr_list_noindex );
?>
<tr>
	<th><label for="keni_noindex_term"><?php _e( "index", 'keni' ); ?></label></th>
	<td><?php echo $str_html_noindex ?></td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'keni_term_edit_form_fields_noindex' );
add_action( 'post_tag_edit_form_fields', 'keni_term_edit_form_fields_noindex' );


function keni_term_add_form_fields_noindex( $term ) {

	$arr_list_noindex = array(
		array( "", __( 'Use Common Setting', 'keni' ) ),
		array( "index", __( 'Enable index', 'keni' ) ),
		array( "1", __( 'Enable noindex', 'keni' ) ),
		array( "2", __( 'Enable noindex page 2 and after', 'keni' ) ),
	);

	$str_html_noindex = keni_format_select( 'keni_term_meta[keni_noindex_term]', '', $arr_list_noindex );

?>
<div class="form-field">
	<label for="keni_noindex_term"><?php _e( "Index Setting", 'keni' ); ?></label>
	<?php echo $str_html_noindex ?>
</div>
<?php
}
add_action( 'category_add_form_fields', 'keni_term_add_form_fields_noindex' );
add_action( 'post_tag_add_form_fields', 'keni_term_add_form_fields_noindex' );

/**
 * noindexの設定を取得する
 * @return bool   noindex = true
 */
function keni_is_noindex() {
	global $post;
	$flag_noindex = false;

	$keni_noindex_post_types = apply_filters( 'keni_noindex_post_types', array( 'keni_cc', 'keni_linkcard' ) );

	// 添付ファイルページ
	if ( is_attachment() ) {

		$flag_noindex = true;

	}
	// keni_cc, keni_linkcard
    elseif ( in_array( get_post_type(), $keni_noindex_post_types ) ) {
		$flag_noindex = true;
	}
	// 記事一覧
	elseif ( is_home() ) {
		$flag_get_noindex = get_option( 'keni_noindex_home' );
		if ( $flag_get_noindex == '2' &&  is_paged() ) {
			$flag_noindex = true;
		}
	}
	// post
	elseif ( is_page() || is_single() ) {
		if ( isset( $post->ID ) && !empty( $post->ID ) ) {
			$arr_get_noindex_post = get_post_meta( $post->ID, 'keni_noindex_post', true );

			if ( ! empty( $arr_get_noindex_post ) && in_array( '1', $arr_get_noindex_post ) ) {
				$flag_noindex = true;
			}
		}
	}
	elseif ( is_category() || is_tag() || is_date() || is_author() || is_search() ) {

		if ( keni_get_archive_noindex_setting() == '1' ) {
			$flag_noindex = true;
		}
		elseif ( keni_get_archive_noindex_setting() == '2' && is_paged() ) {
			$flag_noindex = true;
		}

	}


	return apply_filters( 'keni_is_noindex', ( $flag_noindex )? true : false );
}

/**
 * wp_head noindex meta
 */
add_action( 'wp_head', 'keni_output_meta_noindex' );
function keni_output_meta_noindex() {

	if ( keni_is_noindex() ) {
		echo '<meta name="robots" content="noindex">' . "\r\n";
	}

}

/**
 * 一覧ページのnoindex設定を取得する
 * @return string   index = index
 *                  1 = noindex
 *                  2 = 2ページ目以降はnoindex
 */
function keni_get_archive_noindex_setting() {
	global $post;

	$flag_get_noindex = '';

	if ( is_home() ) {

		$flag_get_noindex = get_option( 'keni_noindex_home' );
		if ( empty( $flag_get_noindex ) ) {
			$flag_get_noindex = "index";
		}
	}
	// カテゴリーページ
	elseif ( is_category() ) {

		$num_term_id = get_queried_object_id();
		if ( function_exists( "get_term_meta" ) ) {
			$flag_get_term_noindex = get_term_meta( $num_term_id, "keni_noindex_term", true );
		}
		else {
			$flag_get_term_noindex = get_option( "keni_noindex_term_" . $num_term_id );
		}

		if ( $flag_get_term_noindex != "" ) {
			$flag_get_noindex = $flag_get_term_noindex;
		}
		else {
			$flag_get_noindex = get_option( 'keni_noindex_categorys' );
		}

	}
	// タグページ
	elseif ( is_tag() ) {
		$num_term_id = get_queried_object_id();
		if ( function_exists( "get_term_meta" ) ) {
			$flag_get_term_noindex = get_term_meta( $num_term_id, "keni_noindex_term", true );
		}
		else {
			$flag_get_term_noindex = get_option( "keni_noindex_term_" . $num_term_id );
		}

		if ( $flag_get_term_noindex != "" ) {
			$flag_get_noindex = $flag_get_term_noindex;
		}
		else {
			$flag_get_noindex = get_option( 'keni_noindex_tags' );
		}
	}
	// 年月日ページ
	elseif ( is_date() ) {

		$flag_get_noindex = get_option( 'keni_noindex_dates' ) ;

	}
	// 投稿者ページ
	elseif ( is_author() ) {

		$flag_get_noindex = get_option( 'keni_noindex_authors' ) ;

	}
	// 検索結果ページ
	elseif ( is_search() ) {

		$flag_get_noindex = get_option( 'keni_noindex_searchs' ) ;

	} 
	// その他
	else {

	}

	return $flag_get_noindex;
}

//-----------------------------------------------------
// post メタデータ（keyword / description）
//-----------------------------------------------------
add_action( 'admin_menu', 'keni_add_meta_box_meta_data_post' );
add_action( 'save_post', 'keni_save_meta_box_meta_data_post' );

function keni_add_meta_box_meta_data_post() {
	add_meta_box( 'meta_data', __( 'Meta Data (meta description)', 'keni' ), 'keni_insert_meta_box_meta_data_post', array( 'post', 'page' ), 'normal', 'high' );
}

function keni_insert_meta_box_meta_data_post(){
	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_meta_data_post_nonce' );

	$str_meta_description_post = get_post_meta( $post->ID, 'keni_meta_description_post', true );

	$str_html_meta_description_post = keni_format_textarea( 'keni_meta_description_post', $str_meta_description_post, 'keni_meta_description' );

	echo $str_html_meta_description_post;
}

function keni_save_meta_box_meta_data_post( $post_id ){
	$str_nonce = isset($_POST['keni_meta_box_meta_data_post_nonce']) ? $_POST['keni_meta_box_meta_data_post_nonce'] : null;

	if ( ! wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	$str_meta_description_post = isset( $_POST['keni_meta_description_post'] ) ? $_POST['keni_meta_description_post']: '';
	if ( ! empty( $str_meta_description_post ) ) {
		update_post_meta( $post_id, 'keni_meta_description_post', $str_meta_description_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_meta_description_post' );
	}

}


/**
 * wp_head meta data
 */
add_action( 'wp_head', 'keni_output_meta_data' );
/**
 * 賢威のヘッダーに吐き出すメタデータを生成する
 * @return [type] [description]
 */
function keni_output_meta_data() {

	$arr_get_disabled_description = get_option( 'keni_disabled_description' );
	if ( ! empty( $arr_get_disabled_description[0] ) && $arr_get_disabled_description[0] ) {

		return;

	}

	global $post;
	global $wp_query;
	$output = "";

	$str_meta_description = keni_get_meta_description();

	if ( ! empty( $str_meta_description ) ) {

		$str_meta_description = trim( strip_tags( str_replace(array("\r\n", "\r", "\n"), '', $str_meta_description ) ) );
		$output .= '<meta name="description" content="' .trim( strip_tags( str_replace(array("\r\n", "\r", "\n"), '', $str_meta_description ) ) ). '">' . "\r\n";

	}

	echo $output;
}

/**
 * description　文字列生成
 *
 * @return string|void description文字列
 */
function keni_get_meta_description() {
	$str_site_name        = get_bloginfo( 'name' );
	$str_site_description = get_bloginfo( 'description' );

	if ( is_front_page() ) {

		$str_meta_description = get_bloginfo( 'description' );

	} elseif ( is_home() || is_archive() ) {

		if ( is_home() ) {

			if ( is_paged() ) {
				$str_meta_description = sprintf( __( 'Archive List for %s %s %s', 'keni' ), $str_site_name, show_page_number(), $str_site_description );
			}
			else {
				$str_meta_description = get_bloginfo( 'description' );
			}

		}
		elseif ( is_category() || is_tag() ) {
			$str_category_description = category_description();

			if ( empty( $str_category_description ) ) {

				$str_cat_tag = '';
				$str_get_archive_title = keni_get_archive_title();
				if ( empty( $str_get_archive_title  ) ) {
					if ( is_category() ) {
						$str_cat_tag = single_cat_title( '', false );
					}
					elseif ( is_tag() ) {
						$str_cat_tag = single_tag_title( '', false );
					}
				}
				else {
					$str_cat_tag = $str_get_archive_title;
				}

				$str_meta_description = sprintf( __( '%s Archive List for %s %s %s', 'keni' ), $str_site_name, $str_cat_tag, show_page_number(), $str_site_description );

			}
			else {
				$str_meta_description = sprintf( __( '%s%s', 'keni' ), $str_category_description, show_page_number() );
			}

		}
		elseif ( is_day() ) {

			$str_meta_description = sprintf( __( 'Archive List for %s %s %s', 'keni' ), get_the_time( __( 'Y-n-j', 'keni' ) ), show_page_number(), $str_site_description );

		}
		elseif ( is_month() ) {

			$str_meta_description = sprintf( __( 'Archive List for %s %s %s', 'keni' ), get_the_time( __( 'Y-n', 'keni' ) ), show_page_number(), $str_site_description );

		}
		elseif ( is_year() ) {

			$str_meta_description = sprintf( __( 'Archive List for %s %s %s', 'keni' ), get_the_time( __( 'Y', 'keni' ) ), show_page_number(), $str_site_description );

		}
		elseif ( is_author() ) {

			$str_meta_description = sprintf( __( 'Archive List for %s %s %s', 'keni' ), get_the_author(), show_page_number(), $str_site_description );

		}

	}
	elseif ( is_search() ) {

		$str_meta_description = sprintf( __( 'Search Result for %s %s %s﻿', 'keni' ), get_search_query(), show_page_number(), $str_site_description );

	}
	elseif ( is_singular() )
	{
		$str_meta_description = keni_get_meta_description_for_singular();
	}
	elseif ( is_404() ) {

		$str_meta_description = __( "Sorry, but you are looking for something that isn't here.", 'keni' );

	}
    return $str_meta_description;
}

/**
 * 投稿ページ用
 * @return [type] [description]
 */
function keni_get_meta_description_for_singular () {
	global $post;

	$str_meta_description = get_post_meta( $post->ID, 'keni_meta_description_post', true );

	if ( empty( $str_meta_description ) ) {

		$arr_content = get_extended( $post->post_content );

		setup_postdata($post) ;

		$excerpt = get_the_excerpt();
		if ( ! empty( $excerpt ) ) {
			$str_meta_description = str_replace( "[&hellip;]", "…", $excerpt );
		}
		// elseif ( ! empty( $arr_content['extended'] ) ) {
		// 	$str_meta_description = $arr_content['main'];
		// }
		else {
			$str_meta_description = get_bloginfo( 'description' );
		}

		wp_reset_query();

	}
	return $str_meta_description;
}



//-----------------------------------------------------
// post canonical URL
//-----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_canonical_post');
add_action('save_post', 'keni_save_meta_box_canonical_post');

function keni_add_meta_box_canonical_post() {
	add_meta_box('canonical_url', __( 'canonical URL', 'keni' ), 'keni_insert_meta_box_canonical_post', array( 'post', 'page' ) , 'normal', 'high');
}

function keni_insert_meta_box_canonical_post() {

	global $post;
	wp_nonce_field( wp_create_nonce(__FILE__), 'keni_meta_box_canonical_post_nonce' );

	// get setting
	$str_get_canonical_post = get_post_meta( $post->ID, 'keni_canonical_post', true );

	echo keni_format_text( 'keni_canonical_post', $str_get_canonical_post, 'keni_canonical_post' );

}

function keni_save_meta_box_canonical_post( $post_id ) {
	$str_nonce = isset($_POST['keni_meta_box_canonical_post_nonce']) ? $_POST['keni_meta_box_canonical_post_nonce'] : null;

	if( !wp_verify_nonce( $str_nonce, wp_create_nonce(__FILE__) ) ) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// save
	$str_get_canonical_post = isset( $_POST['keni_canonical_post'] ) ? $_POST['keni_canonical_post']: '';
	if( !empty( $str_get_canonical_post ) ){
		update_post_meta( $post_id, 'keni_canonical_post', $str_get_canonical_post );
	}
	else {
		delete_post_meta( $post_id, 'keni_canonical_post' );
	}
}

/**
 * wp_head canonical url
 */
add_action( 'wp_head', 'keni_output_canonical_url', 9 );
function keni_output_canonical_url() {
	global $post;
	echo get_keni_canonical();
}

//-----------------------------------------------------
// canonical 表示
//-----------------------------------------------------

if ( ! function_exists( 'the_keni_canonical' ) ) {
	function the_keni_canonical() {
		echo get_keni_canonical();
	}
}


if ( ! function_exists( 'get_keni_canonical' ) ) {

	/**
	 * 賢威独自のカノニカルを設定する
	 * @param  boolean $tag  [description]
	 * @param  boolean $pass [description]
	 * @return string        カノニカルHTMLタグ
	 */
	function get_keni_canonical( $tag = true, $pass = false ) {
		global $post;

		$canonical = $url = "";

		$flag_disabled_canonical = (int)get_option( 'keni_disabled_canonical' );

		if ( $flag_disabled_canonical !== 1 || empty( $flag_disabled_canonical ) ) {

			remove_action( 'wp_head', 'rel_canonical' );

			if ( get_option( 'blog_public' ) == false && $tag == true ) return "";

			$page_canonical = "n";


			$permalink_structure = get_option( 'permalink_structure' );
			if ( $permalink_structure == "" ) {
				$perm_slash = "q";
			} elseif ( preg_match( "/\/$/u", $permalink_structure ) ) {
				$perm_slash = "y";
			} else {
				$perm_slash = "n";
			}

			$the_page = keni_page_number();

			if ( $pass == true || ! keni_is_noindex() ) {

				if ( is_front_page() ) {
					if ( isset( $_GET['post_type'] ) && $_GET['post_type'] != "" ) {
						$uri_parth = parse_url($_SERVER['REQUEST_URI']);
						if ( isset( $uri_parth['query'] ) && ! empty( $uri_parth['query'] ) ) $url = get_home_url()."/?".$uri_parth['query'];

					} elseif ( get_query_var( 'paged' ) > 0 ) {
						if ( $perm_slash == "y" ) {
							$url = get_home_url()."/page/".get_query_var( 'paged' )."/";
						} elseif ( $perm_slash == "n" ) {
							$url = get_home_url()."/page/".get_query_var( 'paged' );
						} else {
							$url = get_home_url()."/?page=".get_query_var( 'paged' );
						}

					} elseif ( is_front_page() && get_option('page_on_front' ) > 0 && get_post_meta( get_the_ID(), 'keni_canonical_post', true ) != "" ) {
						$url = get_post_meta( get_the_ID(), 'keni_canonical_post', true );
						$page_canonical = "y";

					} elseif ( $the_page['now_page'] > 1 ) {
						if ( $perm_slash == "y" ) {
							$url = get_home_url()."/page/".$the_page['now_page']."/";
						} elseif ($perm_slash == "n") {
							$url = get_home_url()."/page/".$the_page['now_page'];
						} else {
							$url = get_home_url()."/?page=".$the_page['now_page'];
						}

					} else {
						$url = get_home_url().'/';	// urlの最後が // と、スラッシュが2つになった場合は、.'/' を削除し、$url = get_home_url(); として下さい。
					}

				} elseif ( is_home() ) {

					$post_canonical = get_post_meta( get_option( 'page_for_posts' ), 'keni_canonical_post', true );
					if ( isset( $post_canonical ) && ( $post_canonical != "" ) ) {
						$url = $post_canonical;
						$page_canonical = "y";
					} else {
						$url = get_page_link( get_option( 'page_for_posts' ) );
					}

				} elseif ( is_singular() ) {

					$post_canonical = get_post_meta( get_the_ID(), 'keni_canonical_post', true );
					if ( isset( $post_canonical ) && ( $post_canonical != "" ) ) {
						$url = $post_canonical;
						$page_canonical = "y";

					} else {
						$flag_get_noindex_post = (int)get_post_meta( $post->ID, 'keni_noindex_post', true );

						if ( $flag_get_noindex_post !== 1 || empty( $flag_get_noindex_post ) ) $url = get_permalink( get_the_ID() );
						$this_page = keni_page_number();

						if ( $this_page['now_page'] > 1 ) {
							if ( $perm_slash == "y" ) {
								$url .= $this_page['now_page']."/";
							} elseif ( $perm_slash == "n" ) {
								$url .= "/". $this_page['now_page'];
							} else {
								$url .= "&page=". $this_page['now_page'];
							}
						}
					}

				} elseif ( is_category() ) {
					$num_term_id = get_queried_object_id();
					$url = get_category_link( $num_term_id );

				} elseif ( is_tag() ) {
					$num_term_id = get_queried_object_id();
					$url = get_tag_link( $num_term_id );

				} elseif ( is_date() ) {

					preg_match( "/(\/\?m=[0-9]{4,8})/", $_SERVER['REQUEST_URI'], $url_param );
					$date = "";
					if ( !isset( $url_param[1] ) ) {
						if ( is_year() ) {
							preg_match( "/(\/[0-9]{4}\/*)/", $_SERVER['REQUEST_URI'], $url_param );
						} elseif ( is_month() ) {
							preg_match( "/(\/[0-9]{4}\/[0-9]{2}\/*)/", $_SERVER['REQUEST_URI'], $url_param );
						} elseif ( is_day() ) {
							preg_match( "/(\/[0-9]{4}\/[0-9]{2}\/[0-9]{2}\/*)/", $_SERVER['REQUEST_URI'], $url_param );
						}

						preg_match( "/\/archives\/date/", $_SERVER['REQUEST_URI'], $date_param );
						if ( isset( $date_param[0] ) ) {
							$date = "/archives/date";
						} else {
							preg_match( "/date/", $_SERVER['REQUEST_URI'], $date_param );
							if ( isset( $date_param[0] ) ) $date = "/date";
						}
					}

					if ( isset( $url_param[1] ) ) $url = get_home_url(). $date. $url_param[1];

				} elseif ( is_author() ) {
					$url = get_author_posts_url( get_the_author_meta('ID') );

				} elseif ( is_search() ) {

					$now_page = get_query_var( 'paged' );
					if ( $now_page > 1 ) {
						if ( $perm_slash == "q" ) {
							$url = get_home_url() ."?s=" . urlencode( get_search_query() ) . "&paged=" . $now_page;
						} elseif ( $perm_slash == "y" ) {
							$url = get_home_url() . "/page/" . $now_page."/?s=" . urlencode( get_search_query() );
						} else {
							$url = get_home_url() . "/page/" . $now_page . "?s=" . urlencode( get_search_query() );
						}
					} else {
						$url = get_home_url() . "/?s=" . urlencode( get_search_query() );
					}
				}

				if ( isset($url) && $url != "" ) {
					if ( $page_canonical == "n" ) {
						if ( ! is_front_page() && ! is_search() ) {
							$now_page = get_query_var( 'paged' );
							if ( $now_page > 0 ) {
								if ( $perm_slash == "q" ) {
									$url .= "&paged=" . $now_page;
								} elseif ( $perm_slash == "y" ) {
									$url .= "page/" . $now_page . "/";
								} else {
									if ( preg_match( "/\/$/", $url ) ) $url = substr( $url, 0, -1 );
									$url .= "/page/" . $now_page;
								}
							}
						}

						if ( preg_match( '/^https/', get_option( 'home' ) ) ) {
							$protocol = "https";
							$replace_protocol = "http";
						} else {
							$protocol = "http";
							$replace_protocol = "https";
						}
						$url =  ( ! preg_match( "/^" . $protocol . ":/", $url ) ) ? preg_replace( "/^" . $replace_protocol . "/", $protocol, str_replace( "&#038;", "&", $url ) ) : str_replace( "&#038;", "&", $url );
					}

					$canonical = ( $tag == true ) ? '<link rel="canonical" href="' . $url . '" />' . "\n" : $url;

				}
			}
		}

		return $canonical;
	}
}

// ----------------------------------------------------
// 別タイトル
// ----------------------------------------------------
add_action('admin_menu', 'keni_add_meta_box_another_post_title');
add_action('save_post', 'keni_save_meta_box_another_post_title');
if ( ! function_exists( 'keni_add_meta_box_another_post_title' ) ) {
    function keni_add_meta_box_another_post_title() {
	    add_meta_box( 'another_title', __( 'Another Title', 'keni' ), 'keni_insert_meta_box_another_post_title', array(
		    'post',
		    'page'
	    ), 'normal', 'high' );
    }
}

if ( ! function_exists( 'keni_insert_meta_box_another_post_title' ) ) {
	function keni_insert_meta_box_another_post_title() {

		global $post;
		wp_nonce_field( wp_create_nonce( __FILE__ ), 'keni_meta_box_another_post_title_nonce' );

		// get setting
		$str_get_another_post_title = get_post_meta( $post->ID, 'keni_another_post_title', true );

		echo keni_format_text( 'keni_another_post_title', $str_get_another_post_title, 'large-text' );

	}
}

if ( ! function_exists( 'keni_save_meta_box_another_post_title' ) ) {
	function keni_save_meta_box_another_post_title( $post_id ) {
		$str_nonce = isset( $_POST['keni_meta_box_another_post_title_nonce'] ) ? $_POST['keni_meta_box_another_post_title_nonce'] : null;

		if ( ! wp_verify_nonce( $str_nonce, wp_create_nonce( __FILE__ ) ) ) {
			return $post_id;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// save
		$str_get_another_post_title = isset( $_POST['keni_another_post_title'] ) ? $_POST['keni_another_post_title'] : '';
		if ( ! empty( $str_get_another_post_title ) ) {
			update_post_meta( $post_id, 'keni_another_post_title', $str_get_another_post_title );
		} else {
			delete_post_meta( $post_id, 'keni_another_post_title' );
		}
	}
}

/**
 * wp_head keni_output_another_post_title
 */
//add_action( 'wp_head', 'keni_output_another_post_title', 9 );
//function keni_output_another_post_title() {
//	global $post;
//	echo get_keni_another_post_title();
//}

if ( ! function_exists( 'get_keni_another_post_title' ) ) {

	/**
	 * 	■記事毎にタイトルを自由に書き換えられる機能
     * 	何も入力されていなければ今までどおりの表示
     * 	入力されている場合は「入力されているとおりに表示」されるようになる
     * 	「titleタグの中身を書き換えたい記事だけ、タイトルを全文入力する」がユーザーの作業
	 *
	 * @return string        タイトル
	 */
	function get_keni_another_post_title() {

		$keni_another_post_title = get_post_meta( get_the_ID(), 'keni_another_post_title', true );

		return $keni_another_post_title;

	}
}

function keni_title( $title ){
    if ( is_singular() ) {
	    $another_title = get_keni_another_post_title();
	    if ( $another_title && ! empty( $another_title ) ) {
		    $title['title'] = $another_title;
	    }
    }

	return $title;
}
add_filter( 'document_title_parts', 'keni_title', 10, 1 );

//-----------------------------------------------------
// コンテンツの品質チェックシート
//-----------------------------------------------------
function keni_admin_seo_check_script() {

	$screen = get_current_screen();
	if ( $screen->post_type == 'post' || $screen->post_type == 'page' ) {
		$str_template_directory_uri = get_template_directory_uri();
		$str_text_checksheet_contents_quality = __('Check Sheet for Contents Quality', 'keni');
		$script = <<< EOM
		<script type="text/javascript">
		jQuery(function($){

			$(function() {
				var ww = Number(window.parent.screen.width * 0.4);
				var wh = Number(window.parent.screen.height * 0.65);
				var wl= Number((screen.width-ww)/2);
				var wt= 45;
				$('#timestampdiv').after('<div id="keni_seo_link">&nbsp;<a href="{$str_template_directory_uri}/keni/module/keni-seo/keni-seo-check-view.php" class="popup"><span class="dashicons dashicons-yes" style="text-decoration: none;"></span> {$str_text_checksheet_contents_quality}</a></div>');
				$(".popup").click(function(){
					window.open(this.href,"seocheck","width="+ww+",height="+wh+",left="+wl+",top="+wt+",resizable=yes,scrollbars=yes");
					return false;
				});
			});
		});
		</script>
EOM;

		echo $script;

	}
}
add_action('admin_print_scripts', 'keni_admin_seo_check_script', 999);


//-----------------------------------------------------
// Next/Prev link
//-----------------------------------------------------
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

function keni_next_prev_link() {
	global $wp_query;

	$flg_noindex = keni_is_noindex();

	if ( is_singular() ) {
		//global $multipage;
		global $more;

		$multipage = keni_check_multi_page();

		if ( $multipage && ! $flg_noindex ) {

			$prev = keni_multipage_url('prev');
			$next = keni_multipage_url('next');

			if ( $prev ) {
				echo '<link rel="prev" href="' . $prev . '" />'.PHP_EOL;
			}
			if ( $next ) {
				echo '<link rel="next" href="' . $next . '" />'.PHP_EOL;
			}
		}
	} elseif ( is_home() ) {
		$flag_get_noindex_home = get_option( 'keni_noindex_home' );
		if ( $flag_get_noindex_home != "2" ) {
			global $paged;
			if ( get_previous_posts_link() ) {
				echo '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ) . '" />'.PHP_EOL;
			}
			if ( get_next_posts_link() ){
				echo '<link rel="next" href="' . get_pagenum_link( $paged + 1 ) . '" />'.PHP_EOL;
			}
		}
	} else {
		global $paged;
		// noindexが設定されておらず、2ページ目以降がnoindexの設定でもない場合
		if ( ! $flg_noindex && ( keni_get_archive_noindex_setting() != '2' ) ) {

			if ( get_previous_posts_link() ) {
				echo '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ) . '" />'.PHP_EOL;
			}
			if ( get_next_posts_link() ){
				echo '<link rel="next" href="' . get_pagenum_link( $paged + 1 ) . '" />'.PHP_EOL;
			}
		}
	}
}

function keni_check_multi_page() {
	$num_pages	= substr_count(
		$GLOBALS['post']->post_content,
		'<!--nextpage-->'
	) + 1;
	$current_page = get_query_var( 'page' );
	return array ( $num_pages, $current_page );
}

function keni_multipage_url( $rel='prev' ) {
	global $post;
	$url = '';
	$multipage = keni_check_multi_page();
	if($multipage[0] > 1) {
		$numpages = $multipage[0];
		$page = $multipage[1] == 0 ? 1 : $multipage[1];
		$i = 'prev' == $rel? $page - 1: $page + 1;
		if($i && $i > 0 && $i <= $numpages) {
			if(1 == $i) {
				$url = get_permalink();
			} else {
				if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending'))) {
					$url = add_query_arg('page', $i, get_permalink());
				} else {
					$url = trailingslashit(get_permalink()).user_trailingslashit($i, 'single_paged');
				}
			}
		}
	}
	return $url;
}

add_action( 'wp_head', 'keni_next_prev_link', 20 );

function keni_rm_rel_prev_next($tag) {
  $tag = str_replace(' rel="prev"', '', $tag);
  $tag = str_replace(' rel="next"', '', $tag);
  return $tag;
}
add_filter('previous_post_link', 'keni_rm_rel_prev_next');
add_filter('next_post_link', 'keni_rm_rel_prev_next');