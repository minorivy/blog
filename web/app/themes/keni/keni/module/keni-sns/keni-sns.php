<?php
//-----------------------------------------------------
// 基本設定 - SNS
//-----------------------------------------------------

/**
 * Ajax カウント
 */
add_action( 'wp_ajax_keni_sns_fb', 'keni_sns_fb' );
add_action( 'wp_ajax_nopriv_keni_sns_fb', 'keni_sns_fb' );

/**
 * add menu
 */
function keni_admin_sns() {
	add_submenu_page( 'keni_admin_menu', __( 'Keni Settings sns', 'keni' ), __( 'Keni Settings sns', 'keni' ), 'administrator', 'keni_admin_menu_snss', 'keni_setting_page_snss' );
	add_action( 'admin_init', 'keni_register_sns', 'admin-head' );
}

add_action( 'admin_menu', 'keni_admin_sns' );

/**
 * 初期値
 */
function keni_default_sns() {
	$flag_get_disabled_disp_ogp_facebook = get_option( 'keni_disabled_disp_ogp_facebook' );
	if ( empty( $flag_get_disabled_disp_ogp_facebook ) ) {
		add_option( 'keni_disabled_disp_ogp_facebook', "1" );
	}

	$flag_get_disabled_disp_ogp_twitter = get_option( 'keni_disabled_disp_ogp_twitter' );
	if ( empty( $flag_get_disabled_disp_ogp_twitter ) ) {
		add_option( 'keni_disabled_disp_ogp_twitter', "1" );
	}
}

add_action( 'init', 'keni_default_sns' );


/**
 * Register
 */
function keni_register_sns() {
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_sns_count' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_top' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_home' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_category_tag' );
	// register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_archive' );
	// register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_search' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_posts_list' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_post' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_post_position' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_page' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_sns_page_position' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_common_image' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_ogp_facebook' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_facebook_app_id' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_facebook_app_secret' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_facebook_admins' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_facebook_default_image' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_type' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_locale' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_disabled_disp_ogp_twitter' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_twitter_card' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_twitter_site' );
	register_setting( 'keni-initialize-setting_page_sns', 'keni_ogp_twitter_default_image' );
}

function keni_setting_page_snss() {

	$str_option_group = 'keni-initialize-setting_page_sns';

	/* set 共通設定 */

    /* SNSカウント非表示設定 */
	$flag_keni_disabled_sns_count = (int) get_option( 'keni_disabled_sns_count', 0 );
	$str_keni_disabled_sns_count_checked = '';
	if ( $flag_keni_disabled_sns_count !== 0 ) {
		$str_keni_disabled_sns_count_checked = ' checked="checked"';
	}

	/* SNSの非表示設定 */
	# toppage sns
	$flg_get_disabled_disp_sns_top  = get_option( 'keni_disabled_disp_sns_top' );
	$arr_list_disabled_disp_sns_top = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_top = keni_format_checkbox( 'keni_disabled_disp_sns_top', $flg_get_disabled_disp_sns_top, $arr_list_disabled_disp_sns_top, true );

	# front page sns
	$flg_get_disabled_disp_sns_home  = get_option( 'keni_disabled_disp_sns_home' );
	$arr_list_disabled_disp_sns_home = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_home = keni_format_checkbox( 'keni_disabled_disp_sns_home', $flg_get_disabled_disp_sns_home, $arr_list_disabled_disp_sns_home, true );

	# category tag page sns
	$flg_get_disabled_disp_sns_category_tag  = get_option( 'keni_disabled_disp_sns_category_tag' );
	$arr_list_disabled_disp_sns_category_tag = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_category_tag = keni_format_checkbox( 'keni_disabled_disp_sns_category_tag', $flg_get_disabled_disp_sns_category_tag, $arr_list_disabled_disp_sns_category_tag, true );


	# archive page sns (no active)
	$flg_get_disabled_disp_sns_archive  = get_option( 'keni_disabled_disp_sns_archive' );
	$arr_list_disabled_disp_sns_archive = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_archive = keni_format_checkbox( 'keni_disabled_disp_sns_archive', $flg_get_disabled_disp_sns_archive, $arr_list_disabled_disp_sns_archive, true );

	# archive page posts list
	$flg_get_disabled_disp_sns_posts_list  = get_option( 'keni_disabled_disp_sns_posts_list' );
	$arr_list_disabled_disp_sns_posts_list = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_posts_list = keni_format_checkbox( 'keni_disabled_disp_sns_posts_list', $flg_get_disabled_disp_sns_posts_list, $arr_list_disabled_disp_sns_posts_list, true );

	# search page sns (no active)
	$flg_get_disabled_disp_sns_search  = get_option( 'keni_disabled_disp_sns_search' );
	$arr_list_disabled_disp_sns_search = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_search = keni_format_checkbox( 'keni_disabled_disp_sns_search', $flg_get_disabled_disp_sns_search, $arr_list_disabled_disp_sns_search, true );

	# post sns
	$flg_get_disabled_disp_sns_post  = get_option( 'keni_disabled_disp_sns_post' );
	$arr_list_disabled_disp_sns_post = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_post = keni_format_checkbox( 'keni_disabled_disp_sns_post', $flg_get_disabled_disp_sns_post, $arr_list_disabled_disp_sns_post, true );

	## post sns position
	$str_disabled_disp_sns_post_position      = get_option( 'keni_disabled_disp_sns_post_position', 'both' );
	$arr_list_disabled_disp_sns_post_position = array(
		array( "both", __( 'Disp Both', 'keni' ) ),
		array( "up", __( 'Disp Up Only', 'keni' ) ),
		array( "down", __( 'Disp Down Only', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_post_position = keni_format_radio( 'keni_disabled_disp_sns_post_position', $str_disabled_disp_sns_post_position, $arr_list_disabled_disp_sns_post_position );

	# page sns
	$flg_get_disabled_disp_sns_page  = get_option( 'keni_disabled_disp_sns_page' );
	$arr_list_disabled_disp_sns_page = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_page = keni_format_checkbox( 'keni_disabled_disp_sns_page', $flg_get_disabled_disp_sns_page, $arr_list_disabled_disp_sns_page, true );

	## page sns position
	$str_disabled_disp_sns_page_position      = get_option( 'keni_disabled_disp_sns_page_position', 'both' );
	$arr_list_disabled_disp_sns_page_position = array(
		array( "both", __( 'Disp Both', 'keni' ) ),
		array( "up", __( 'Disp Up Only', 'keni' ) ),
		array( "down", __( 'Disp Down Only', 'keni' ) ),
	);
	$str_html_disabled_disp_sns_page_position = keni_format_radio( 'keni_disabled_disp_sns_page_position', $str_disabled_disp_sns_page_position, $arr_list_disabled_disp_sns_page_position );

	/* 共通画像の設定 */
	# sns common image
	$str_get_ogp_common_image  = get_option( 'keni_ogp_common_image', '' );
	$str_html_ogp_common_image = keni_format_upload( 'keni_ogp_common_image', $str_get_ogp_common_image, 'image' );

	/* FacebookのOGP設定 */
	#disabled ogp facebook
	$flg_get_disabled_disp_ogp_facebook  = get_option( 'keni_disabled_disp_ogp_facebook' );
	$arr_list_disabled_disp_ogp_facebook = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_ogp_facebook = keni_format_checkbox( 'keni_disabled_disp_ogp_facebook', $flg_get_disabled_disp_ogp_facebook, $arr_list_disabled_disp_ogp_facebook, true );

	# fb app id
	$str_get_ogp_facebook_app_id  = get_option( 'keni_ogp_facebook_app_id', '' );
	$str_html_ogp_facebook_app_id = keni_format_text( 'keni_ogp_facebook_app_id', $str_get_ogp_facebook_app_id );

	# fb app secret
	$str_get_keni_facebook_app_secret = get_option( 'keni_facebook_app_secret', '' );
	$str_html_facebook_app_secret = keni_format_text( 'keni_facebook_app_secret', $str_get_keni_facebook_app_secret );

	# fb admins 管理者ID
	$str_get_ogp_facebook_admins  = get_option( 'keni_ogp_facebook_admins', '' );
	$str_html_ogp_facebook_admins = keni_format_text( 'keni_ogp_facebook_admins', $str_get_ogp_facebook_admins );

	# fb OGP 初期画像
	$str_get_ogp_facebook_default_image  = get_option( 'keni_ogp_facebook_default_image', '' );
	$str_html_ogp_facebook_default_image = keni_format_upload( 'keni_ogp_facebook_default_image', $str_get_ogp_facebook_default_image, 'image' );

	# ogp type
	$str_get_ogp_type  = get_option( 'keni_ogp_type', 'website' );
	$str_html_ogp_type = keni_format_text( 'keni_ogp_type', $str_get_ogp_type );

	# ogp locale
	$str_get_ogp_locale  = get_option( 'keni_ogp_locale', 'ja_JP' );
	$str_html_ogp_locale = keni_format_text( 'keni_ogp_locale', $str_get_ogp_locale );

	/* TwitterのOGP設定 */
	#disabled ogp twitter

	$flg_get_disabled_disp_ogp_twitter  = get_option( 'keni_disabled_disp_ogp_twitter' );
	$arr_list_disabled_disp_ogp_twitter = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_ogp_twitter = keni_format_checkbox( 'keni_disabled_disp_ogp_twitter', $flg_get_disabled_disp_ogp_twitter, $arr_list_disabled_disp_ogp_twitter, true );

	# twitter site
	$str_get_ogp_twitter_site  = get_option( 'keni_ogp_twitter_site', '' );
	$str_html_ogp_twitter_site = keni_format_text( 'keni_ogp_twitter_site', $str_get_ogp_twitter_site );

	# twitter card
	$flag_get_ogp_twitter_card = get_option( 'keni_ogp_twitter_card', 'summary_large_image' );
	$arr_list_ogp_twitter_card = array(
		array( "summary", __( 'summary', 'keni' ) ),
		array( "summary_large_image", __( 'summary_large_image', 'keni' ) ),
		array( "photo", __( 'photo', 'keni' ) ),
	);
	$str_html_ogp_twitter_card = keni_format_radio( 'keni_ogp_twitter_card', $flag_get_ogp_twitter_card, $arr_list_ogp_twitter_card );

	# twitter OGP 初期画像
	$str_get_ogp_twitter_default_image  = get_option( 'keni_ogp_twitter_default_image', '' );
	$str_html_ogp_twitter_default_image = keni_format_upload( 'keni_ogp_twitter_default_image', $str_get_ogp_twitter_default_image, 'image' );

	/*GoogleのOGP設定 */
	#disabled ogp google+
	$flg_get_disabled_disp_ogp_google_plus  = get_option( 'keni_disabled_disp_ogp_google_plus', '1' );
	$arr_list_disabled_disp_ogp_google_plus = array(
		array( "1", __( 'Disable', 'keni' ) ),
	);
	$str_html_disabled_disp_ogp_google_plus = keni_format_checkbox( 'keni_disabled_disp_ogp_google_plus', $flg_get_disabled_disp_ogp_google_plus, $arr_list_disabled_disp_ogp_google_plus );

	# google+ OGP 初期画像
	$str_get_ogp_google_plus_default_image  = get_option( 'keni_ogp_google_plus_default_image', '' );
	$str_html_ogp_google_plus_default_image = keni_format_upload( 'keni_ogp_google_plus_default_image', $str_get_ogp_google_plus_default_image, 'image' );

    $arr_metaboxs[] = sprintf( keni_disabled_sns_count(), $str_keni_disabled_sns_count_checked );
	$arr_metaboxs[] = sprintf( keni_format_setting_disp_sns(), $str_html_disabled_disp_sns_top, $str_html_disabled_disp_sns_home, $str_html_disabled_disp_sns_category_tag, $str_html_disabled_disp_sns_posts_list, $str_html_disabled_disp_sns_post, $str_html_disabled_disp_sns_post_position, $str_html_disabled_disp_sns_page, $str_html_disabled_disp_sns_page_position );
	$arr_metaboxs[] = sprintf( keni_format_ogp_common_image(), $str_html_ogp_common_image );
	$arr_metaboxs[] = sprintf( keni_format_ogp_facebook(), $str_html_disabled_disp_ogp_facebook, $str_html_ogp_facebook_app_id, $str_html_facebook_app_secret, $str_html_ogp_facebook_admins, $str_html_ogp_type, $str_html_ogp_locale, $str_html_ogp_facebook_default_image );

	$arr_metaboxs[] = sprintf( keni_format_ogp_twitter(), $str_html_disabled_disp_ogp_twitter, $str_html_ogp_twitter_card, $str_html_ogp_twitter_site, $str_html_ogp_twitter_default_image );


	keni_the_format_options_form( $str_option_group, $arr_metaboxs );
}


/**
 * Format ogp_common_image
 * @return string html
 */
function keni_format_ogp_common_image() {
	$title = __( 'OGP Common Image', 'keni' );
	$main  = '%s';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * @return string
 */
function keni_disabled_sns_count() {
	// SNS表示を無効にする
	$title = __( 'Disable Keni SNS Count Setting', 'keni' );
	$main  = '<input type="checkbox" id="title-disabled_sns_count" name="keni_disabled_sns_count" value="1"%s /><label for="title-disabled_sns_count">' . __( 'Disable Keni SNS Count', 'keni' ) . '</label>';
	$main .= '<p class="description">SNSカウントを表示しない場合はチェック</p>';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format index
 * @return string html
 */
function keni_format_setting_disp_sns() {
	$title = __( 'Display SNS Setting', 'keni' );
	$main  = '<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Top Page', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Home Page', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Category and Tag Page', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Posts List Page', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Post', 'keni' ) . '</label></p>
			%s
			<div style="padding-left: 2em;">
	        %s
	        </div>
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Page', 'keni' ) . '</label></p>
			%s
			<div style="padding-left: 2em;">
	        %s
	        </div>';

	return keni_format_metabox_holder( $title, $main );
}


/**
 * Format relation
 * @return string html
 */
function keni_format_ogp_facebook() {
	$title = __( 'Setting OGP Facebook for Site', 'keni' ); // 全体のOGP記事設定
	$main  = '<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Disp OGP Facebook', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Facebook App ID', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Facebook App Secret', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Facebook Admins', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'OGP Type', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'OGP Locale', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Facebook OGP Common Image', 'keni' ) . '</label></p>
			%s';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format relation
 * @return string html
 */
function keni_format_ogp_twitter() {
	$title = __( 'Setting OGP Twitter for Site', 'keni' ); // 全体のOGP記事設定
	$main  = '<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Disp OGP Twitter', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Twitter Card', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Twitter Site', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Twitter OGP Common Image', 'keni' ) . '</label></p>
			%s';

	return keni_format_metabox_holder( $title, $main );
}


/**
 * 賢威のOPGヘッダーを表示する
 * @return [type] [description]
 */
function keni_header_ogp() {
	$ogp_default_image          = get_stylesheet_directory_uri() . '/images/ogp-default.jpg';
	$ogp_common_image           = get_option( 'keni_ogp_common_image' );
	$disabled_disp_ogp_facebook = get_option( 'keni_disabled_disp_ogp_facebook' );

	$ogp_facebook_app_id = get_option( 'keni_ogp_facebook_app_id' );
	$ogp_facebook_admins = get_option( 'keni_ogp_facebook_admins' );
	$ogp_type            = get_option( 'keni_ogp_type', 'website' );
	$ogp_locale          = get_option( 'keni_ogp_locale' );

	$ogp_thumbnail_size = 'large';


	if ( ! empty( $ogp_common_image ) ) {
		$str_file_preview_url = wp_get_attachment_image_src( $ogp_common_image, $ogp_thumbnail_size );
		$str_file_url         = wp_get_attachment_url( $ogp_common_image );
		$ogp_common_image     = ( ! empty( $str_file_url ) ) ? $str_file_preview_url[0] : '';
	}
	// functions.php 等から共通イメージ設定
	$ogp_common_image = apply_filters( 'keni_ogp_common_image', $ogp_common_image );

	if ( empty( $ogp_locale ) ) {
		$ogp_locale = 'ja_JP';
	}

	$disabled_disp_ogp_twitter = get_option( 'keni_disabled_disp_ogp_twitter' );
	$ogp_twitter_card          = get_option( 'keni_ogp_twitter_card' );
	$ogp_twitter_site          = get_option( 'keni_ogp_twitter_site' );

	if ( have_posts() ) {

		$protocol = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://';
		$ogp_url = get_keni_canonical( false );
		if ( is_home() || is_front_page() ) {
			$ogp_url = get_bloginfo('url');
		} elseif ( empty( $ogp_url ) ) {
			$ogp_url = get_the_permalink();
		}

		ob_start();
		?>
        <!--OGP-->
		<?php
		echo ( ( is_home() || is_front_page() ) && ! get_query_var( 'paged' ) ) ? "<meta property=\"og:type\" content=\"" . $ogp_type . "\" />\n" : "<meta property=\"og:type\" content=\"article\" />\n";
		echo "<meta property=\"og:url\" content=\"" . $ogp_url . "\" />\n";

		$title       = get_the_title();
		$description = keni_get_meta_description_for_singular();
		$site_title  = get_bloginfo( 'name' );
		$image       = apply_filters( 'keni_home_image', $ogp_common_image );

		if ( is_home() || is_front_page() ) {
			$title       = get_bloginfo( 'name' );
			$str_get_front_title  = get_option( 'keni_front_title' );
			if ( ! empty( $str_get_front_title ) && strlen( trim( $str_get_front_title ) ) > 0 ) {
				$title = $str_get_front_title;
			}
			$title       = apply_filters( 'keni_home_title', $title );
			$image       = apply_filters( 'keni_home_image', $ogp_common_image );
			$description = apply_filters( 'keni_home_description', get_bloginfo( 'description' ) );
		} elseif ( is_archive() ) {
			global $wp_query;

			$keni_term_title = "";
			$term =	$wp_query->queried_object;
			$term_id = $term->term_id;
			if ( is_category() ) {
				if ( function_exists( "get_term_meta" ) ) {
					// wordpress 4.4.0以降
					$keni_term_title = get_term_meta( $term_id, "keni_page_title_term", true );
				}
				else {
					$keni_term_title = get_option( "keni_page_title_term_" . $term_id );
				}
				$keni_term_title = ( $keni_term_title != "" ? $keni_term_title : single_cat_title('', false ) );
				$image       = apply_filters( 'keni_category_page_image', $ogp_common_image, $term_id );
			} elseif ( is_tag() ) {
				if ( function_exists( "get_term_meta" ) ) {
					// wordpress 4.4.0以降
					$keni_term_title = get_term_meta( $term_id, "keni_page_title_term", true );
				}
				$keni_term_title = ( $keni_term_title != "" ? $keni_term_title : single_tag_title('', false ) );
				$image       = apply_filters( 'keni_tag_page_image', $ogp_common_image, $term_id );
			}
		} elseif ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), $ogp_thumbnail_size );
		} elseif ( ! empty( $ogp_common_image ) ) {
			$image = $ogp_common_image;
		} else {
			$image = $ogp_default_image;
		}

		if ( is_singular() ) {
			$str_title = wp_get_document_title();
			$title       = ( get_post_meta( get_the_ID(), 'page_ogp_title', true ) != "" ) ? get_post_meta( get_the_ID(), 'page_ogp_title', true ) : $str_title;
			$description = ( get_post_meta( get_the_ID(), 'page_ogp_description', true ) != "" ) ? get_post_meta( get_the_ID(), 'page_ogp_description', true ) : $description;
			/** 優先順: 個別の画像設定　→　アイキャッチ画像　→　（Facebook 又は Twitterで設定した「共通画像」）　→　SNS全体の共通画像 **/

			// 個別画像
			$image_id  = get_post_meta( get_the_ID(), 'page_ogp_img', true );
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
			// OGP title
			$og_title = get_post_meta( get_the_ID(), 'page_ogp_title', true );
			if ( ! empty( $og_title ) ) {
				$title = $og_title;
			}
			// OGP description
			$og_description = get_post_meta( get_the_ID(), 'page_ogp_description', true );
			if ( ! empty( $og_description ) ) {
				$description = $og_description;
			}

			if ( $image_src !== false ) {
				$image = $image_src[0];
			} else {
				// アイキャッチ画像
				$thumbnail_id  = get_post_thumbnail_id();
				$thumbnail_img = wp_get_attachment_image_src( $thumbnail_id, 'full' );
				if ( $thumbnail_img !== false ) {
					$image = $thumbnail_img[0];
				} else {
					// （Facebook 又は Twitterで設定した「共通画像」）
					$str_get_ogp_facebook_default_image = get_option( 'keni_ogp_facebook_default_image', '' );
					$str_file_preview_url               = wp_get_attachment_image_src( $str_get_ogp_facebook_default_image, 'full' );
					$str_file_url                       = wp_get_attachment_url( $str_get_ogp_facebook_default_image );
					$image                              = ( ! empty( $str_file_url ) ) ? $str_file_preview_url[0] : '';
				}
			}

		} elseif ( is_archive() ) {
			$title = keni_get_archive_title();
			$description = "";
			if ( is_category() ) {
				$category = get_category( get_query_var( "cat" ) );
				$num_term_id = @$category->term_id;
				$title = ( $keni_term_title != "" ? $keni_term_title : $title );
				$title = keni_edit_archive_title( $title );
				$description = strip_tags( trim( category_description( $num_term_id ) ) );
			} elseif ( is_tag() ) {
				$tag = get_tag( get_query_var( "tag" ) );
				$num_term_id = @$tag->term_id;
				$title = ( $keni_term_title != "" ? $keni_term_title : $title );
				$title = keni_edit_archive_title( $title );
				$description = strip_tags( trim( tag_description( $num_term_id ) ) );
			}
			if ( $description == "" ) {
				// 設定なき場合はメタディスクリプションと同値を設定
				$description = keni_get_meta_description();
			}
		}

		// イメージサイズ取得
		$imagesize = @getimagesize( $image );
		// og:image:width
		// og:image:height
		$og_img_width = 0;
		$og_img_height = 0;
		$og_img_type_int = "";
		$og_img_attr = "";
		if ( FALSE !== $imagesize ) {
			list($og_img_width, $og_img_height, $og_img_type_int, $og_img_attr) = $imagesize;
		}
		?><meta property="og:title" content="<?php echo esc_html( $title ); ?>"/>
        <meta property="og:description" content="<?php echo esc_html( $description ); ?>">
        <meta property="og:site_name" content="<?php echo esc_html( $site_title ); ?>">
        <meta property="og:image" content="<?php echo esc_html( $image ); ?>">
		<?php
		if ( $og_img_type_int !== "" ) {
			$og_img_type = image_type_to_mime_type( $og_img_type_int );
			?><meta property="og:image:type" content="<?php echo esc_html( $og_img_type ); ?>">
			<?php
		}
		if ( $og_img_width > 0 && $og_img_height > 0 ) {
			?><meta property="og:image:width" content="<?php echo esc_html( $og_img_width ); ?>">
            <meta property="og:image:height" content="<?php echo esc_html( $og_img_height ); ?>">
			<?php
		}
		?><meta property="og:locale" content="<?php echo esc_html( $ogp_locale ); ?>">
		<?php
		if ( $disabled_disp_ogp_facebook !== '1' ) {
			if ( ! empty( $ogp_facebook_app_id ) ) {
				?><meta property="fb:app_id" content="<?php echo esc_html( $ogp_facebook_app_id ); ?>">
				<?php
			}
			if ( ! empty( $ogp_facebook_admins ) ) {
				?><meta property="fb:admins" content="<?php echo esc_html( $ogp_facebook_admins ); ?>">
				<?php
			}
		}
		?>
        <!--OGP-->
		<?php
		if ( $disabled_disp_ogp_twitter != '1' ) {

			$twitter = array();
			$image_src = apply_filters( 'keni_ogp_common_image', $ogp_common_image );

			$twc_list = twCardsKey();

			// 対象の投稿の種類を取得
			$tw_card = get_post_meta( get_the_ID(), 'tw_card', true );

			if ( empty( $tw_card ) ) {
				$tw_card = key( $twc_list );
			}
			// card 設定
			$twitter['card'] = $ogp_twitter_card;
			// site 設定
			if ( ! empty( $ogp_twitter_site ) ) {
				$twitter['site'] = $ogp_twitter_site;
			}

			if ( isset( $twc_list[ $tw_card ] ) ) {

				foreach ( $twc_list[ $tw_card ] as $key => $val ) {
					if ( $key != "*info*" ) {
						$twitter[ $key ] = get_post_meta( get_the_ID(), $key, true );

						if ( $key == 'site' ) {
							if ( ! empty( $ogp_twitter_site ) ) {
								$twitter[ $key ] = ( ! empty( $twitter[ $key ] ) ? $twitter[ $key ] : $ogp_twitter_site );
							}
						}

						if ( empty( $twitter[ $key ] ) || $key == 'image' ) {
							switch ( $key ) {
								case "site":
									$twitter[ $key ] = $ogp_twitter_site;
									if ( is_singular() ) {
										switch ( $tw_card ) {
											case "summary":
												$page_site = get_post_meta( get_the_ID(), "summary_site", true );
												break;
											case "summary_large_image":
												$page_site = get_post_meta( get_the_ID(), "summary_large_image_site", true );
												break;
											case "photo":
												$page_site = get_post_meta( get_the_ID(), "photo_site", true );
												break;
										}
										if ( ! empty( $page_site ) ) {
											$twitter[ $key ] = $page_site;
										}
									}
									break;

								case "title":
									$twitter[ $key ] = ( get_post_meta( get_the_ID(), $key, true ) != "" ) ? get_post_meta( get_the_ID(), $key, true ) : get_the_title();
									if ( is_singular() ) {
										switch ( $tw_card ) {
											case "summary":
												$page_title = get_post_meta( get_the_ID(), "summary_title", true );
												break;
											case "summary_large_image":
												$page_title = get_post_meta( get_the_ID(), "summary_large_image_title", true );
												break;
											case "photo":
												$page_title = get_post_meta( get_the_ID(), "photo_title", true );
												break;

										}
										if ( ! empty( $page_site ) ) {
											$twitter[ $key ] = $page_title;
										}
									}
									break;

								case "description":
									$twitter[ $key ] = ( get_post_meta( get_the_ID(), $key, true ) != "" ) ? get_post_meta( get_the_ID(), $key, true ) : "";
									if ( is_singular() ) {
										switch ( $tw_card ) {
											case "summary":
												$page_description = get_post_meta( get_the_ID(), "summary_description", true );
												break;
											case "summary_large_image":
												$page_description = get_post_meta( get_the_ID(), "summary_large_image_description", true );
												break;
											case "photo":
												$page_description = get_post_meta( get_the_ID(), "photo_title", true );
												break;

										}
										if ( ! empty( $page_description ) ) {
											$twitter[ $key ] = $page_description;
										}
									}
									break;

								case "image":
									$image_id = get_post_meta( get_the_ID(), 'image', true );
									$image_tw = wp_get_attachment_image_src( $image_id, 'full' );
									/** 優先順: 個別の画像設定　→　アイキャッチ画像　→　（Facebook 又は Twitterで設定した「共通画像」）　→　SNS全体の共通画像 **/
									if ( $image_tw !== false ) {
										$image_src = $image_tw[0];
									} else {
										// アイキャッチ画像
										$thumbnail_id  = get_post_thumbnail_id();
										$thumbnail_img = wp_get_attachment_image_src( $thumbnail_id, 'full' );
										if ( $thumbnail_img !== false ) {
											$image_src = $thumbnail_img[0];
										} else {
											// （Facebook 又は Twitterで設定した「共通画像」）
											$str_get_ogp_twitter_default_image = get_option( 'keni_ogp_twitter_default_image', '' );
											$str_file_preview_url              = wp_get_attachment_image_src( $str_get_ogp_twitter_default_image, 'full' );
											$str_file_url                      = wp_get_attachment_url( $str_get_ogp_twitter_default_image );
											$image_src                         = ( ! empty( $str_file_url ) ) ? $str_file_preview_url[0] : '';
										}
									}

									$twitter[ $key ] = $image_src;
									break;
							}
						}
					}
				}
			}
			?>
            <!-- Twitter Cards -->
			<?php
			foreach ( $twitter as $key => $val ) {
				if ( $val != "" ) {
					?><meta name="twitter:<?php echo $key; ?>" content="<?php echo esc_html( $val ); ?>"/>
					<?php
				}
			}
			?>
            <!--/Twitter Cards-->
			<?php
		}

		$print_str = ob_get_contents();
		ob_end_clean();
		echo $print_str;
	}

}

add_action( 'wp_head', 'keni_header_ogp' );


//---------------------------------------------------------------------------
//	管理画面上での個別title/descriptionの指定
//---------------------------------------------------------------------------
if ( get_option( 'keni_disabled_disp_ogp_facebook', '1' ) != "1" ) {
	add_action( 'save_post', 'save_ogp_string' );
	add_action( 'add_meta_boxes', 'add_ogp_box' );
}

if ( ! function_exists( 'add_ogp_box' ) ) {
	function add_ogp_box() {
//		// ランディングページのディレクトリ名を取得
//		if ( ! defined( 'LP_DIR' ) ) {
//			define( 'LP_DIR', the_keni( 'lp_dir' ) );
//		}

		add_meta_box( 'ogp', 'OGP・Microdata・Twitterカードの個別設定', 'ogp_setting', 'post', 'normal' );
		add_meta_box( 'ogp', 'OGP・Microdata・Twitterカードの個別設定', 'ogp_setting', 'page', 'normal' );
		// add_meta_box( 'ogp', 'OGP・Microdata・Twitterカードの個別設定', 'ogp_setting', LP_DIR, 'normal' );
		// LP、その他用フック
		do_action( 'keni_sns_ogp_setting' );
	}
}

if ( ! function_exists( 'ogp_setting' ) ) {
	function ogp_setting() {
		$image_src = "";
		if ( isset( $_GET['post'] ) ) {
			$page_ogp_title       = get_post_meta( $_GET['post'], 'page_ogp_title', true );
			$page_ogp_description = get_post_meta( $_GET['post'], 'page_ogp_description', true );
			$page_ogp_img         = get_post_meta( $_GET['post'], 'page_ogp_img', true );

			$image_id  = get_post_meta( get_the_ID(), 'page_ogp_img', true );
			$image_src = wp_get_attachment_image_src( $image_id, 'medium' );
			if ( $image_src !== false ) {
				$image_src = "<img src='" . $image_src[0] . "'>";
			} else {
				$image_src = "";
			}
		} else {
			$page_ogp_title       = "";
			$page_ogp_description = "";
			$page_ogp_img         = "";
		}
		$page_ogp_title       = esc_html( $page_ogp_title );
		$page_ogp_description = esc_html( $page_ogp_description );
		$page_ogp_img         = esc_html( $page_ogp_img );
		$button_str           = __( 'Upload Image', 'keni' );
		$clear_button_str     = __( 'Clear', 'keni' );

		keni_the_media_upload_script();
		echo <<<EOL
		<ul>
			<li>
					<p class="post-attributes-label-wrapper">タイトル</p>
					<input type="text" name="page_ogp_title" value="{$page_ogp_title}" size="64" maxlength="64" />
			</li>
			<li>
					<p class="post-attributes-label-wrapper">ディスクリプション</p>
					<input type="text" name="page_ogp_description" value="{$page_ogp_description}" size="64" maxlength="64" />
			</li>
			<li>
					<p class="post-attributes-label-wrapper">FBのOGP画像</p>
					<p id="keni_upload_image_1000-view">{$image_src}</p>
					 <p><input type="hidden" id="keni_upload_image_1000" name="page_ogp_img" class="regular-text" value="{$page_ogp_img}" />
					<button type="button" class="media-upload cmb_upload_button button" data-rel="keni_upload_image_1000" data-type="image">{$button_str}</button>
					<button type="button" class="media-clear button" name="fb_ogp_img-clear" data-rel="keni_upload_image_1000" />{$clear_button_str}</button>
					</p>
			</li>
		</ul>
EOL;
	}
}

if ( ! function_exists( 'save_ogp_string' ) ) {
	function save_ogp_string( $post_id ) {
		if ( isset( $_POST['page_ogp_title'] ) ) {
			update_post_meta( $post_id, 'page_ogp_title', $_POST['page_ogp_title'] );
		}

		if ( isset( $_POST['page_ogp_description'] ) ) {
			update_post_meta( $post_id, 'page_ogp_description', $_POST['page_ogp_description'] );
		}

		if ( isset( $_POST['page_ogp_img'] ) ) {
			update_post_meta( $post_id, 'page_ogp_img', $_POST['page_ogp_img'] );
		}
	}
}

if ( ! function_exists( 'keni_get_sns' ) ) {
	function keni_get_sns( $link_str = "", $title_str = "", $disp = false ) {
		$link = "";
		$title = "";
		if ( $link_str != "" ) $link = ' data-url="' . esc_attr( $link_str ) . '"';
		if ( $title_str != "" ) $title_str = urlencode( $title_str );
		if ( $title_str != "" ) $title = ' data-title="' . esc_attr( $title_str ) . '"';
		ob_start();
		?>
        <div class="sns-btn_tw"<?php echo $link; ?><?php echo $title; ?>></div>
        <div class="sns-btn_fb"<?php echo $link; ?><?php echo $title; ?>></div>
        <div class="sns-btn_hatena"<?php echo $link; ?><?php echo $title; ?>></div>
		<?php
		$ret = ob_get_contents();
		ob_end_clean();

		// keni_get_sns_html フックで拡張する
		$ret = apply_filters( 'keni_get_sns_html', $ret, $link_str, $title_str );

		if ( $disp == false ) {
			return $ret;
		}
		echo $ret;
	}
}

//---------------------------------------------------------------------------
//	管理画面上でのTwitterCards個別情報の指定
//---------------------------------------------------------------------------
if ( get_option( 'keni_disabled_disp_ogp_twitter', '1' ) != "1" ) {
	add_action( 'save_post', 'save_tw_string' );
	add_action( 'add_meta_boxes', 'add_tw_box' );
}

if ( ! function_exists( 'add_tw_box' ) ) {
	function add_tw_box() {
//		// ランディングページのディレクトリ名を取得
//		if ( ! defined( 'LP_DIR' ) ) {
//			define( 'LP_DIR', the_keni( 'lp_dir' ) );
//		}

		add_meta_box( 'twc', 'Twitter Cards の個別設定', "twc_setting", 'post', 'normal' );
		add_meta_box( 'twc', 'Twitter Cards の個別設定', 'twc_setting', 'page', 'normal' );
		// add_meta_box( 'twc', 'Twitter Cards の個別設定', 'twc_setting', LP_DIR, 'normal' );
		do_action( 'keni_sns_twc_setting' );

	}
}

if ( ! function_exists( 'twc_setting' ) ) {
	/**
	 *
	 */
	function twc_setting() {

		$twc_list = twCardsKey();

		$images_no = 10;

		// 初期化
		$tw_data = array();

		$button_str       = __( 'Upload Image', 'keni' );
		$clear_button_str = __( 'Clear', 'keni' );

		if ( isset( $_GET['post'] ) ) {
			$tw_card = get_post_meta( get_the_ID(), 'tw_card', true );
			if ( empty( $tw_card ) ) {
				$tw_card = key( $twc_list );
			}
			if ( $tw_card == "gallery" ) {
				$tw_card = "summary_large_image";
			}
		} else {
			$tw_card = key( $twc_list );
		}

		foreach ( $twc_list[ $tw_card ] as $key => $val ) {
			if ( $key != "*info*" ) {
				$tw_data[ $key ] = get_post_meta( get_the_ID(), $key, true );
			}
		}

		echo "<ul>";
		foreach ( $twc_list as $key => $twc_val ) {
			$label = ( $key == "def" ) ? "共通設定を適用" : $key;
			if ( isset( $tw_card ) && ( $tw_card == $key ) ) {
				echo "<li><input type=\"radio\" name=\"tw_card\" value=\"" . $key . "\" id=\"" . $key . "\" onclick=\"ChangeTwCards('" . $key . "')\" checked=\"checked\"><label for=\"" . $key . "\">" . $label . "</label></th><td><label for=\"" . $key . "\">" . $twc_val['*info*'] . "</label></li>";
			} else {
				echo "<li><input type=\"radio\" name=\"tw_card\" value=\"" . $key . "\" id=\"" . $key . "\" onclick=\"ChangeTwCards('" . $key . "')\"><label for=\"" . $key . "\">" . $label . "</label></th><td><label for=\"" . $key . "\">" . $twc_val['*info*'] . "</label></li>";
			}
		}
		echo "</ul><ul>";
		foreach ( $twc_list as $key => $twc_val ) {
			echo "<li id=\"tw_" . $key . "\">";
			echo "<ul>";
			foreach ( $twc_val as $twc_line_key => $twc_line_val ) {
				if ( $twc_line_key != '*info*' ) {
					echo "<li><p class=\"post-attributes-label-wrapper\">" . $twc_line_key . "</p></li>";
				}

				if ( is_array( $twc_line_val ) ) {
					switch ( $twc_line_val['type'] ) {
						case "text":
							echo "<li><input type=\"text\" name=\"" . $key . "_" . $twc_line_key . "\" value=\"" . array_get_value( $tw_data, $twc_line_key, '' ) . "\" size=\"60\" /></li>";
							break;
						case "image":
							$images_no ++;

							$image_id  = get_post_meta( get_the_ID(), "image", true );
							$image_src = wp_get_attachment_image_src( $image_id, 'medium' );
							if ( $image_src !== false ) {
								$image_src = "<img src='" . $image_src[0] . "'>";
							} else {
								$image_src = "";
							}

							echo <<< EOL
							<li>
					<p class="post-attributes-label-wrapper">ツイート画像</p>
					<p id="keni_img_{$images_no}-view">{$image_src}</p>
					 <p><input type="hidden" id="keni_img_{$images_no}" name="{$key}_{$twc_line_key}" class="regular-text" value="{$image_id}" />
					<button type="button" class="media-upload cmb_upload_button button" data-rel="keni_img_{$images_no}" data-type="image">{$button_str}</button>
					<button type="button" class="media-clear button" name="fb_ogp_img-clear" data-rel="keni_img_{$images_no}" />{$clear_button_str}</button>
					</p>
							</li>
EOL;
							break;
					}
					if ( $twc_line_val['nec'] == "y" ) {
						echo "<span class=\"keni_note\">※ 必須</span>";
					}
					if ( $twc_line_key != '*info*' && isset( $twc_line_val['info'] ) ) {
						echo "<br />" . $twc_line_val['info'];
					}
				}
			}
			echo "</ul></li>";
		}
		echo "</ul>";

		echo "<script>function ChangeTwCards(sel) {\n";
		echo "(function($) {\n";

		foreach ( $twc_list as $key => $twc_val ) {
			echo <<<EOF

	if (sel == '{$key}') {
		$("#tw_{$key}").show();
	} else {
		$("#tw_{$key}").hide();
	}
	
EOF;
		}

		echo "})(jQuery);\n";
		echo "}\n";

		echo "jQuery.noConflict();\n";
		echo "(function($) {\n";
		echo "$(function() {\n";
		echo "var tw_sel = $(\"input[name='tw_card']:checked\").val();\n";
		foreach ( $twc_list as $key => $twc_val ) {
			echo <<<EOF

	if (tw_sel == '{$key}') {
		$("#tw_{$key}").show();
	} else {
		$("#tw_{$key}").hide();
	}
	
EOF;
		}
		echo "})\n";
		echo "})(jQuery);\n";
		echo "</script>\n";
	}
}

if ( ! function_exists( 'save_tw_string' ) ) {
	function save_tw_string( $post_id ) {
		if ( isset( $_POST['tw_card'] ) ) {
			update_post_meta( $post_id, 'tw_card', $_POST['tw_card'] );
			$twc_list = twCardsKey();
			if ( isset( $twc_list[ $_POST['tw_card'] ] ) ) {
				foreach ( $twc_list[ $_POST['tw_card'] ] as $key => $val ) {
					if ( $key != "*info*" ) {
						$post_key = $_POST['tw_card'] . "_" . $key;
						if ( isset( $_POST[ $post_key ] ) ) {
							update_post_meta( $post_id, $key, $_POST[ $post_key ] );
						}
					}
				}
			}
		}
	}
}

function array_get_value( $array, $key, $default = null ) {
	return isset( $array[ $key ] ) ? $array[ $key ] : $default;
}


//---------------------------------------------------------------------------
//	TwitterCardsの種類と設定内容
//---------------------------------------------------------------------------
if ( ! function_exists( 'twCardsKey' ) ) {
	function twCardsKey() {
		$twitter_name = get_option( 'keni_ogp_twitter_site', '' );
		$site         = ( $twitter_name != "" ) ? "空白の場合の初期値：" . $twitter_name : "例） seokyoto";

		$tw_type = array(
			"def" => array( "*info*" => "「賢威の設定」→「SNSの設定」→「twitter」→「標準のツイート形式」の設定に従う" ),

			"summary"             => array(
				"*info*"      => "通常のツイートに利用します。140文字のテキストの下に画像とテキストを入力する ",
				"site"        => array(
					"info" => "Twitterのアカウント名を入力します。" . $site,
					"type" => "text",
					"nec"  => "y"
				),
				"title"       => array(
					"info" => "Twitter Cardsのタイトルにしたい文字を入力します。空白の場合の初期値は「投稿タイトル」になります。",
					"type" => "text",
					"nec"  => "y"
				),
				"description" => array(
					"info" => "投稿内容の抜粋などを入力します。空白の場合の初期値は「抜粋」になります。",
					"type" => "text",
					"nec"  => "y"
				),
				"image"       => array(
					"info" => "Tweetに付ける画像を指定します",
					"type" => "image",
					"nec"  => "n"
				)
			),
			"summary_large_image" => array(
				"*info*"      => "大きな画像を付けてツイートしたい場合に利用します",
				"site"        => array(
					"info" => "Twitterのアカウント名を入力します。" . $site,
					"type" => "text",
					"nec"  => "y"
				),
				"title"       => array(
					"info" => "Twitter Cardsのタイトルにしたい文字を入力します。空白の場合の初期値は「投稿タイトル」になります。",
					"type" => "text",
					"nec"  => "y"
				),
				"description" => array(
					"info" => "投稿内容の抜粋などを入力します。空白の場合の初期値は「抜粋」になります。",
					"type" => "text",
					"nec"  => "y"
				),
				"image"       => array(
					"info" => "Tweetに付ける画像を指定します",
					"type" => "image",
					"nec"  => "n"
				)
			),
			"photo"               => array(
				"*info*" => "画像をメインにしたツイートをしたい場合に利用します",
				"site"   => array(
					"info" => "Twitterのアカウント名を入力します。@" . $site,
					"type" => "text",
					"nec"  => "y"
				),
				"title"  => array(
					"info" => "Twitter Cardsのタイトルにしたい文字を入力します。空白の場合の初期値は「投稿タイトル」になります。",
					"type" => "text",
					"nec"  => "n"
				),
				"image"  => array(
					"info" => "Tweetに付ける画像を指定します",
					"type" => "image",
					"nec"  => "y"
				)
			)
		);

		return $tw_type;
	}
}

/**
 * Facebook いいね数
 */
function keni_sns_fb() {
	if ( is_404() ) {
		echo "";
		die();
	}
	$target_url   = esc_attr( $_REQUEST['id'] );
	$app_id       = get_option( 'keni_ogp_facebook_app_id' );
	$app_secret   = get_option( 'keni_facebook_app_secret' );
	$facebook_cnt = 0;

	$facebook_like_interval = apply_filters( 'keni_facebook_like_interval', 20 );

	$is_archive = false;

	if ( empty( $target_url ) ) {
		echo "0";
		die();
	}
	$cache_flg = false;
	if ( filter_input(INPUT_POST, 'cache') === '1' ) {
		$cache_flg = true;
	}
	$cache_flg = apply_filters( 'keni_facebook_cache_flg', $cache_flg );

	$post_id = url_to_postid( $target_url );
	if ( $post_id === 0 ) $post_id = get_the_ID();
	if ( empty( $post_id ) ) {
		// POST_ID が取れない場合は一覧ページの場合があるため theme_mod に投入
		$is_archive = true;
	}

	// キャッシュフラグがリクエストに存在する場合はキャッシュフラグに従う
	if ( ! $cache_flg ) {
		// キャッシュフラグに関わらず keni_post_fb_time から一定時間経過していない場合は回避
		$keni_post_fb_time = intval( get_post_meta( $post_id, 'keni_post_fb_time', true ) );
		if ( $is_archive ) {
			$keni_post_fb_time = intval( get_theme_mod( 'fb_time-'.$target_url, 0 ) );
		}
		$past_time         = time() - $keni_post_fb_time;

		$past_min         = intval( $past_time / 60  );

		if ( $keni_post_fb_time === 0 || $past_min >= $facebook_like_interval ) {
			$access_token_query = "";
			if ( ! empty( $app_id ) && ! empty( $app_secret ) ) {
				$access_token_query = "&access_token=" . $app_id . "|" . $app_secret;
			}
			// いいね数を取得したいページのURL
			$url = "https://graph.facebook.com/?id=" . rawurlencode( $target_url ) . "&fields=og_object{engagement},engagement" . $access_token_query;

			$option = [
				CURLOPT_RETURNTRANSFER => true, //文字列として返す
				CURLOPT_TIMEOUT        => 1, // タイムアウト時間
			];

			$ch = curl_init( $url );
			curl_setopt_array( $ch, $option );

			$json    = curl_exec( $ch );
			$info    = curl_getinfo( $ch );
			$errorNo = curl_errno( $ch );

			// OK以外はエラーなので空白配列を返す
			if ( $errorNo !== CURLE_OK ) {
				// 詳しくエラーハンドリングしたい場合はerrorNoで確認
				// タイムアウトの場合はCURLE_OPERATION_TIMEDOUT
				error_log( '[KENI] keni-sns.php: facebook operation timeout' );
				$facebook_cnt = 0;
			} // 200以外のステータスコードは失敗とみなし空配列を返す
            elseif ( $info['http_code'] !== 200 ) {
				error_log( '[KENI] keni-sns.php: facebook return code=' . $info['http_code'] );
				$facebook_cnt = 0;
			} else {
				// 連想配列形式に変換
				$arr = json_decode( $json, true );

				// いいね数が存在する場合
				if ( isset( $arr['og_object']['engagement']['count'] ) ) {
					$facebook_cnt = $arr['og_object']['engagement']['count'];
					if ( $facebook_cnt > 0 ) {
						if ( $is_archive ) {
							set_theme_mod( 'fb_count-'.$target_url, $facebook_cnt );
						} else {
							update_post_meta( $post_id, 'keni_post_fb_cnt', $facebook_cnt );
						}
					}
				} // いいね数が存在しない場合
				else {
					$facebook_cnt = 0;
				}
				error_log( '[KENI] keni-sns.php: facebook return code=200 POST_ID: '.$post_id.' count: '.$facebook_cnt );
			}

			// 取得数に関わらずアクセス記録を残す
			if ( $is_archive ) {
				set_theme_mod( 'fb_time-'.$target_url, time() );
			} else {
				update_post_meta( $post_id, 'keni_post_fb_time', time() );
			}
		}
		// いいね数が 0 の場合 post_meta から取得を試みる
		if ( $facebook_cnt == 0 ) {

			if ( $is_archive ) {
				$fb_cnt = get_theme_mod( 'fb_count-' . $target_url, 0 );
			} else {
				$fb_cnt = get_post_meta( $post_id, 'keni_post_fb_cnt', true );
			}
			if ( $fb_cnt > 0 ) {
				$facebook_cnt = (int) $fb_cnt;
				$facebook_cnt = apply_filters( 'keni_sns_fb_cnt', $facebook_cnt );
			}
		}
	}
	$facebook_cnt = apply_filters( 'keni_sns_fb_cnt', $facebook_cnt );

	echo (string)$facebook_cnt;
	die();
}

