<?php
/**
 * add menu
 */
function keni_admin_menu() {
	add_menu_page( '賢威 設定メニュー', __( 'Keni Settings', 'keni' ), 'administrator', 'keni_admin_menu', 'keni_setting_page', '', 3 );
	add_submenu_page( 'keni_admin_menu', __( 'Keni Settings code', 'keni' ), __( 'Keni Settings code', 'keni' ), 'administrator', 'keni_admin_menu_options', 'keni_setting_page_options' );
	add_action( 'admin_init', 'keni_register_setting', 'admin-head' );
}

add_action( 'admin_menu', 'keni_admin_menu' );

/**
 * 管理画面 メディアアップロード
 */
function keni_admin_media_upload() {
	// wp_enqueue_script('media-upload');
	// wp_enqueue_script('thickbox');
	// wp_enqueue_style('thickbox');
}

add_action( 'admin_enqueue_scripts', 'keni_admin_media_upload' );

/**
 * 初期値
 */
function keni_default_option() {
	$flag_title_blogname = get_option( 'title_blogname' );
	if ( empty( $flag_title_blogname ) ) {
		add_option( 'title_blogname', 1 );
	}
	$flag_login_analytics = get_option( 'keni_login_analytics' );
	if ( empty( $flag_login_analytics ) ) {
		add_option( 'keni_login_analytics', 1 );
	}
	$str_sp_footerpanel = get_option( 'keni_sp_footerpanel' );
	if ( empty( $flag_sp_footerpanel ) ) {
		add_option( 'keni_sp_footerpanel', 'show' );
	}
	$str_sp_footerpanel_content = get_option( 'keni_sp_footerpanel_content' );
	if ( $str_sp_footerpanel_content == false ) {
		add_option( 'keni_sp_footerpanel_content', keni_setting_sp_footerpanel_content_default() );
	}
}

add_action( 'init', 'keni_default_option' );

/**
 * Register Setting
 */
function keni_register_setting() {
	register_setting( 'keni-initialize-setting_page', 'blogname' );
	register_setting( 'keni-initialize-setting_page', 'blogdescription' );

	if ( isset( $_POST['option_page'] ) && $_POST['option_page'] == 'keni-initialize-setting_page' ) {

		if ( ! empty( $_POST ) ) {
			set_theme_mod( 'custom_logo', (int) $_POST["custom_logo_id"] );
		} else {
			set_theme_mod( 'custom_logo', '' );
		}
	}

	// 基本設定
	register_setting( 'keni-initialize-setting_page', 'keni_title_blogname' );
	register_setting( 'keni-initialize-setting_page', 'keni_front_title' );
	register_setting( 'keni-initialize-setting_page', 'keni_disp_front_page_title' );
	register_setting( 'keni-initialize-setting_page', 'site_icon' );
	register_setting( 'keni-initialize-setting_page', 'keni_google_analytics' );
	register_setting( 'keni-initialize-setting_page', 'keni_login_analytics' );
	register_setting( 'keni-initialize-setting_page', 'keni_sp_footerpanel' );
	register_setting( 'keni-initialize-setting_page', 'keni_sp_footerpanel_content' );
	register_setting( 'keni-initialize-setting_page', 'keni_header_content' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_type' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_image' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_image_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_image_wrap' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_background' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_background_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_background_wrap' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_movie_file' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_movie_type' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_movie_code' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_movie_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider_wrap' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider_link' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider_link_target' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_slider_link_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_wide' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_wide_sp' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_background_content_position' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_background_content' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_movie_content' );
	register_setting( 'keni-initialize-setting_page', 'keni_main_visual_wide_content' );
	register_setting( 'keni-initialize-setting_page', 'keni_remove_format' );
	register_setting( 'keni-initialize-setting_page', 'keni_disabled_customize_color_css' );
	register_setting( 'keni-initialize-setting_page', 'keni_minify_flg' );

	// 基本設定 - 詳細設定
	register_setting( 'keni-initialize-setting_page_options', 'keni_head_after' );
	register_setting( 'keni-initialize-setting_page_options', 'keni_body_before' );
	register_setting( 'keni-initialize-setting_page_options', 'keni_body_after' );

}

/**
 * 基本設定
 */
function keni_setting_page() {

	$str_option_group = 'keni-initialize-setting_page';

	/* get custom_logo ----------*/
	$num_logo_id          = get_theme_mod( 'custom_logo' );
	$str_logo_preview_url = wp_get_attachment_image_src( $num_logo_id, 'medium' );
	$str_logo_url         = wp_get_attachment_url( $num_logo_id );
	$str_logo_img         = ( ! empty( $str_logo_url ) ) ? '<img src="' . $str_logo_preview_url[0] . '" alt="">' : '';


	/* get title_blogname ----------*/
	$flag_title_blogname         = (int) get_option( 'keni_title_blogname', 1);
	$str_title_blogname_checked1 = '';
	$str_title_blogname_checked2 = '';
	if ( $flag_title_blogname === 1 ) {
		$str_title_blogname_checked1 = ' checked="checked"';
	} else {
		$str_title_blogname_checked2 = ' checked="checked"';
	}

	/* set front title ----------*/
	$str_get_front_title  = get_option( 'keni_front_title' );
	$str_html_front_title = keni_format_text( 'keni_front_title', $str_get_front_title );

	/* front page title ----------*/
	$str_disp_front_page_title = get_option( 'keni_disp_front_page_title' );
	if ( empty( $str_disp_front_page_title ) ) {
		$str_disp_front_page_title = "hide";
	}
	$arr_list_disp_front_page_title = array(
		array( "show", __( '表示する', 'keni' ) ),
		array( "hide", __( '表示しない', 'keni' ) ),
	);
	$str_html_disp_front_page_title = keni_format_radio( 'keni_disp_front_page_title', $str_disp_front_page_title, $arr_list_disp_front_page_title );


	/* get site_icon ----------*/
	$num_site_icon_id          = get_option( 'site_icon' );
	$str_site_icon_preview_url = wp_get_attachment_image_src( $num_site_icon_id, 'medium' );
	$str_site_icon_url         = wp_get_attachment_url( $num_site_icon_id );
	$str_site_icon_img         = ( ! empty( $str_site_icon_url ) ) ? '<img src="' . $str_site_icon_preview_url[0] . '" alt="">' : '';

	/* get login_analytics ----------*/
	$flag_login_analytics         = (int) get_option( 'keni_login_analytics' );
	$str_login_analytics_checked1 = '';
	$str_login_analytics_checked2 = '';
	if ( $flag_login_analytics === 1 ) {
		$str_login_analytics_checked1 = ' checked="checked"';
	} else {
		$str_login_analytics_checked2 = ' checked="checked"';
	}

	/* get sp_footerpanel ----------*/
	$str_sp_footerpanel              = get_option( 'keni_sp_footerpanel' );
	$str_sp_footerpanel_content      = get_option( 'keni_sp_footerpanel_content' );
	$arr_list_sp_footerpanel         = array(
		array( "show", __( '表示する', 'keni' ) ),
		array( "hide", __( '表示しない', 'keni' ) ),
	);
	$str_html_sp_footerpanel         = keni_format_radio( 'keni_sp_footerpanel', $str_sp_footerpanel, $arr_list_sp_footerpanel );
	$str_html_sp_footerpanel_content = keni_format_editor( 'keni_sp_footerpanel_content', $str_sp_footerpanel_content );

	/* get header content ----------*/
	$str_get_header_content  = get_option( 'keni_header_content' );
	$str_html_header_content = keni_format_editor( 'keni_header_content', $str_get_header_content, array( 'textarea_rows' => 5 ) );

	/* get main visual ----------*/
	$str_get_main_visual_type                        = get_option( 'keni_main_visual_type' );
	$str_get_main_visual_image                       = get_option( 'keni_main_visual_image' );
	$str_get_main_visual_image_sp                    = get_option( 'keni_main_visual_image_sp' );
	$str_get_main_visual_image_wrap                  = get_option( 'keni_main_visual_image_wrap' );
	$str_get_main_visual_background                  = get_option( 'keni_main_visual_background' );
	$str_get_main_visual_background_sp               = get_option( 'keni_main_visual_background_sp' );
	$str_get_main_visual_background_wrap             = get_option( 'keni_main_visual_background_wrap' );
	$str_get_main_visual_movie_type                  = get_option( 'keni_main_visual_movie_type' );
	$str_get_main_visual_movie_file                  = get_option( 'keni_main_visual_movie_file' );
	$str_get_main_visual_movie_code                  = get_option( 'keni_main_visual_movie_code' );
	$str_get_main_visual_movie_sp                    = get_option( 'keni_main_visual_movie_sp' );
	$arr_get_main_visual_slider                      = get_option( 'keni_main_visual_slider' );
	$arr_get_main_visual_slider_sp                   = get_option( 'keni_main_visual_slider_sp' );
	$str_get_main_visual_slider_wrap                 = get_option( 'keni_main_visual_slider_wrap' );
	$arr_get_main_visual_slider_link                 = get_option( 'keni_main_visual_slider_link' );
	$arr_get_main_visual_slider_link_target          = get_option( 'keni_main_visual_slider_link_target' );
	$str_get_main_visual_wide                        = get_option( 'keni_main_visual_wide' );
	$str_get_main_visual_wide_sp                     = get_option( 'keni_main_visual_wide_sp' );
	$str_get_main_visual_background_content_position = get_option( 'keni_main_visual_background_content_position' );
	$str_get_main_visual_background_content          = get_option( 'keni_main_visual_background_content' );
	$str_get_main_visual_movie_content               = get_option( 'keni_main_visual_movie_content' );
	$str_get_main_visual_wide_content                = get_option( 'keni_main_visual_wide_content' );


	// default
	$str_get_main_visual_type                        = ( ! empty( $str_get_main_visual_type ) ) ? $str_get_main_visual_type : 'main-image';
	$str_get_main_visual_background_content_position = ( ! empty( $str_get_main_visual_background_content_position ) ) ? $str_get_main_visual_background_content_position : 'catch-area_l';
	$str_get_main_visual_movie_type                  = ( ! empty( $str_get_main_visual_movie_type ) ) ? $str_get_main_visual_movie_type : 'code';
	$str_get_main_visual_image_wrap                  = ( ! empty( $str_get_main_visual_image_wrap ) ) ? $str_get_main_visual_image_wrap : 'wrap';
	$str_get_main_visual_background_wrap             = ( ! empty( $str_get_main_visual_background_wrap ) ) ? $str_get_main_visual_background_wrap : 'wrap';
	$str_get_main_visual_slider_wrap                 = ( ! empty( $str_get_main_visual_slider_wrap ) ) ? $str_get_main_visual_slider_wrap : 'wrap';

	$arr_list_type = array(
		array( "main-image", __( 'Image', 'keni' ) ),
		array( "main-background", __( 'Background Image', 'keni' ) ),
		array( "main-movie", __( 'Movie', 'keni' ) ),
		array( "main-slider", __( 'Slider', 'keni' ) ),
		array( "main-wide", __( 'Full Screen', 'keni' ) ),
	);

	$arr_list_position = array(
		array( "catch-area_l", __( 'Left', 'keni' ) ),
		array( "catch-area_c", __( 'Center', 'keni' ) ),
		array( "catch-area_r", __( 'Right', 'keni' ) ),
	);

	$arr_list_movie_type = array(
		array( "code", __( 'Embed Code', 'keni' ) ),
		array( "file", __( 'Movie File', 'keni' ) ),
	);

	$arr_list_movie_wrap = array(
		array( "wrap", __( 'Template Width', 'keni' ) ),
		array( "wide", __( 'Browser Width', 'keni' ) ),
	);

	$str_html_main_visual_type                        = keni_format_radio( 'keni_main_visual_type', $str_get_main_visual_type, $arr_list_type );
	$str_html_main_visual_image                       = keni_format_upload( 'keni_main_visual_image', $str_get_main_visual_image, 'image' );
	$str_html_main_visual_image_sp                    = keni_format_upload( 'keni_main_visual_image_sp', $str_get_main_visual_image_sp, 'image' );
	$str_html_main_visual_image_wrap                  = keni_format_radio( 'keni_main_visual_image_wrap', $str_get_main_visual_image_wrap, $arr_list_movie_wrap );
	$str_html_main_visual_background                  = keni_format_upload( 'keni_main_visual_background', $str_get_main_visual_background, 'image' );
	$str_html_main_visual_background_sp               = keni_format_upload( 'keni_main_visual_background_sp', $str_get_main_visual_background_sp, 'image' );
	$str_html_main_visual_background_wrap             = keni_format_radio( 'keni_main_visual_background_wrap', $str_get_main_visual_background_wrap, $arr_list_movie_wrap );
	$str_html_main_visual_movie_file                  = keni_format_upload( 'keni_main_visual_movie_file', $str_get_main_visual_movie_file, 'video' );
	$str_html_main_visual_movie_type                  = keni_format_radio( 'keni_main_visual_movie_type', $str_get_main_visual_movie_type, $arr_list_movie_type );
	$str_html_main_visual_movie_code                  = keni_format_textarea( 'keni_main_visual_movie_code', $str_get_main_visual_movie_code );
	$str_html_main_visual_movie_sp                    = keni_format_upload( 'keni_main_visual_movie_sp', $str_get_main_visual_movie_sp, 'image' );
	$str_html_main_visual_wide                        = keni_format_upload( 'keni_main_visual_wide', $str_get_main_visual_wide, 'image' );
	$str_html_main_visual_wide_sp                     = keni_format_upload( 'keni_main_visual_wide_sp', $str_get_main_visual_wide_sp, 'image' );
	$str_html_main_visual_background_content_position = keni_format_radio( 'keni_main_visual_background_content_position', $str_get_main_visual_background_content_position, $arr_list_position );
	$str_html_main_visual_background_content          = keni_format_editor( 'keni_main_visual_background_content', $str_get_main_visual_background_content, array( 'textarea_rows' => 5 ) );
	$str_html_main_visual_movie_content               = keni_format_editor( 'keni_main_visual_movie_content', $str_get_main_visual_movie_content, array( 'textarea_rows' => 5 ) );
	$str_html_main_visual_wide_content                = keni_format_editor( 'keni_main_visual_wide_content', $str_get_main_visual_wide_content, array( 'textarea_rows' => 5 ) );
	$str_html_main_visual_slider_wrap                 = keni_format_radio( 'keni_main_visual_slider_wrap', $str_get_main_visual_slider_wrap, $arr_list_movie_wrap );
	$str_html_main_visual_slider_template             = sprintf( keni_slider_form_template(),
		keni_format_uploads( 'keni_main_visual_slider', '', 'image' ),
		keni_format_uploads( 'keni_main_visual_slider_sp', '', 'image' ),
		keni_format_texts( 'keni_main_visual_slider_link', '' ),
		keni_format_checkboxs( 'keni_main_visual_slider_link_target', '', array( '1' ), true )
	);
	$str_html_main_visual_slider                      = '';
	if ( ! empty( $arr_get_main_visual_slider ) || ! empty( $arr_get_main_visual_slider_sp ) || ! empty( $arr_get_main_visual_slider_link ) ) {

		$i = 0;
		foreach ( $arr_get_main_visual_slider as $key => $num_attachment_id ) {

			$str_main_visual_slider_sp   = ( ! empty( $arr_get_main_visual_slider_sp[ $key ] ) ) ? $arr_get_main_visual_slider_sp[ $key ] : '';
			$str_main_visual_slider_link = ( ! empty( $arr_get_main_visual_slider_link[ $key ] ) ) ? $arr_get_main_visual_slider_link[ $key ] : '';
			$str_main_visual_slider_link_target = ( ! empty( $arr_get_main_visual_slider_link_target[ $key ] ) ) ? $arr_get_main_visual_slider_link_target[ $key ] : '';

			$str_html_main_visual_slider .= '<div id="keni_slider_template_df' . $i . '" class="slider-image slider-image-default">
			                                <table class="keni-admin-table">
			                                <thead>
			                                <tr>
			                                <th></th>
			                                <th>' . __( '画像アップロード', 'keni' ) . '</th>
			                                <th>' . __( 'モバイル用画像アップロード', 'keni' ) . '</th>
			                                <th>' . __( 'リンクURL', 'keni' ) . '</th>
			                                <th>' . __( '外部表示', 'keni' ). '</th>
			                                <th></th>
			                                </tr>
			                                </thead>
			                                <tbody><tr>
			                                <td><label for="phones-#index#"><i class="dashicons dashicons-sort"></i></label></td>
			                                <td>' . str_replace( "#index#", 'df' . $i, keni_format_uploads( 'keni_main_visual_slider', $num_attachment_id, 'image' ) ) . '</td>
			                                <td>' . str_replace( "#index#", 'df' . $i, keni_format_uploads( 'keni_main_visual_slider_sp', $str_main_visual_slider_sp, 'image' ) ) . '</td>
			                                <td>' . str_replace( "#index#", 'df' . $i, keni_format_urls( 'keni_main_visual_slider_link', $str_main_visual_slider_link ) ) . '</td>
			                                <td>' . str_replace( '#index#', 'df' . $i, keni_format_checkboxs( 'keni_main_visual_slider_link_target['.$i.']', $str_main_visual_slider_link_target, array( '1' ), true ) ). '</td>
			                                <td>
			                                <a id="keni_slider_remove_current" class="slider-image-clear-button">
			                                	<i class="dashicons dashicons-dismiss"></i>
			                                </a>
			                                </td>
			                                </tbody></tr></table>
			                                </div>
			                                ';
			$i ++;
		}
	}

	$flag_keni_remove_format = (int) get_option( 'keni_remove_format', 0 );
	$str_keni_remove_format_checked = '';
	if ( $flag_keni_remove_format !== 0 ) {
	    $str_keni_remove_format_checked = ' checked="checked"';
    }

    $flag_keni_disabled_customize_color_css = (int) get_option( 'keni_disabled_customize_color_css', 0 );
	$str_keni_disabled_customize_color_css_checked = '';
	if ( $flag_keni_disabled_customize_color_css !== 0 ) {
	    $str_keni_disabled_customize_color_css_checked = ' checked="checked"';
    }

	$flag_keni_minify         = (int) get_option( 'keni_minify_flg', 0 );
	$str_keni_minify_checked1 = '';
	$str_keni_minify_checked2 = '';
	if ( $flag_keni_minify === 0 ) {
		$str_keni_minify_checked1 = ' checked="checked"';
	} else {
		$str_keni_minify_checked2 = ' checked="checked"';
	}

	$str_html_main_visual_type = "<div style='display:none'>".$str_html_main_visual_type."</div>";
	// Uploader script
	// keni_the_media_upload_script();

	$arr_metaboxs[] = sprintf( keni_setting_blogname(), get_option( 'blogname' ) );
	$arr_metaboxs[] = sprintf( keni_format_setting_front_title(), $str_html_front_title );
	$arr_metaboxs[] = sprintf( keni_format_disp_front_page_title(), $str_html_disp_front_page_title );
	$arr_metaboxs[] = sprintf( keni_setting_blogdescription(), get_option( 'blogdescription' ) );
	$arr_metaboxs[] = sprintf( keni_setting_custom_logo(), $str_logo_img, $num_logo_id, $str_logo_url );
	$arr_metaboxs[] = sprintf( keni_setting_title_blogname(), $str_title_blogname_checked1, $str_title_blogname_checked2 );
	$arr_metaboxs[] = sprintf( keni_setting_site_icon(), $str_site_icon_img, $num_site_icon_id, $str_site_icon_url );
	$arr_metaboxs[] = sprintf( keni_setting_analytics(), get_option( 'keni_google_analytics' ) );
	$arr_metaboxs[] = sprintf( keni_setting_login_analytics(), $str_login_analytics_checked1, $str_login_analytics_checked2 );
	$arr_metaboxs[] = sprintf( keni_setting_sp_footerpanel(), $str_html_sp_footerpanel, $str_html_sp_footerpanel_content );
	$arr_metaboxs[] = sprintf( keni_setting_header_content(), $str_html_header_content );
	$arr_metaboxs[] = sprintf( keni_setting_main_visual(),
		$str_html_main_visual_type,
		$str_html_main_visual_image_wrap,
		$str_html_main_visual_image,
		$str_html_main_visual_image_sp,
		$str_html_main_visual_background_wrap,
		$str_html_main_visual_background,
		$str_html_main_visual_background_sp,
		$str_html_main_visual_background_content,
		$str_html_main_visual_background_content_position,
		$str_html_main_visual_movie_type,
		$str_html_main_visual_movie_code,
		$str_html_main_visual_movie_file,
		$str_html_main_visual_movie_sp,
		$str_html_main_visual_movie_content,
		$str_html_main_visual_slider_template,
		$str_html_main_visual_slider_wrap,
		$str_html_main_visual_slider,
		$str_html_main_visual_wide,
		$str_html_main_visual_wide_sp,
		$str_html_main_visual_wide_content
	);
	$arr_metaboxs[] = sprintf( keni_setting_remove_format(), $str_keni_remove_format_checked );
	$arr_metaboxs[] = sprintf( keni_disabled_customize_color_css(), $str_keni_disabled_customize_color_css_checked );
	$arr_metaboxs[] = sprintf( keni_setting_minify_flg(), $str_keni_minify_checked1, $str_keni_minify_checked2 );
	keni_the_format_options_form( $str_option_group, $arr_metaboxs );

}

/**
 * Logo
 * @return [type] [description]
 */
function keni_logo() {
	if ( has_custom_logo() ) {
		$logo       = get_theme_mod( 'custom_logo' );
		$str_return = '<img src="' . wp_get_attachment_url( $logo ) . '" alt="' . get_bloginfo( 'name' ) . '">';
	} else {
		$str_return = get_bloginfo( 'name' );
	}
    $str_return = apply_filters( 'keni_logo', $str_return );
	return $str_return;
}


/**
 * Setting body class
 * @return array
 */
function keni_setting_body_classes( $arr_classes = array() ) {

	// main visual
	$str_get_main_visual_type = get_option( 'keni_main_visual_type' );

	if ( $str_get_main_visual_type == 'main-movie' || $str_get_main_visual_type == 'main-wide' ) {
		$arr_classes[] = 'keni-lp';
	}

	return $arr_classes;
}

add_filter( 'body_class', 'keni_setting_body_classes' );


/**
 * 基本設定 - 詳細設定
 */
function keni_setting_page_options() {

	$str_option_group = 'keni-initialize-setting_page_options';

	$arr_metaboxs[] = sprintf( keni_setting_head_after(), get_option( 'keni_head_after' ) );
	$arr_metaboxs[] = sprintf( keni_setting_body_before(), get_option( 'keni_body_before' ) );
	$arr_metaboxs[] = sprintf( keni_setting_body_after(), get_option( 'keni_body_after' ) );

	keni_the_format_options_form( $str_option_group, $arr_metaboxs );

}

function keni_setting_blogname() {
	$title = __( 'サイトのタイトル', 'keni' );
	$main  = '<p><input type="text" id="blogname" class="regular-text" name="blogname" value="%s"></p>';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format time_disp
 * @return string html
 */
function keni_format_disp_front_page_title() {
	$title = __( 'Display Front Page Title', 'keni' );
	$main  = '%s';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_blogdescription() {
	$title = __( 'サイトの簡単な説明', 'keni' );
	$main  = '<p><input type="text" id="blogdescription" class="regular-text" name="blogdescription" value="%s"></p>
	         <p class="description">このサイトの簡単な説明。メタディスクリプションなどに使用します</p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_custom_logo() {
	$title = __( 'ロゴ画像', 'keni' );
	$main  = '<p id="custom-logo-view">%s</p>
	         <p><input type="hidden" id="custom-logo" name="custom_logo_id" class="regular-text" value="%s" />
	         <button type="button" class="media-upload cmb_upload_button button" data-rel="custom-logo" data-type="image">' . __( 'Upload Image', 'keni' ) . '</button>
	         <button type="button" class="media-clear button" name="custom_logo-clear" data-rel="custom-logo" />' . __( 'Clear', 'keni' ) . '</button>
	         </p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_title_blogname() {
	$title = __( '下層ページの&lt;title&gt;にサイト名を表示', 'keni' );
	$main  = '<ul>
	         <li><input type="radio" id="title-blogname1" name="keni_title_blogname" value="1"%s /><label for="title-blogname1">表示する</label></li>
	         <li><input type="radio" id="title-blogname2" name="keni_title_blogname" value="0"%s /><label for="title-blogname2">表示しない</label></li>
	         </ul>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_site_icon() {
	$title = __( 'Site Icon', 'keni' );
	$main  = '<p id="site-icon-view">%s</p>
	         <p><input type="hidden" id="site-icon" name="site_icon" class="regular-text" value="%s" />
	         <button type="button" class="media-upload cmb_upload_button button" data-rel="site-icon" data-type="image">' . __( 'Upload Image', 'keni' ) . '</button>
	         <button type="button" class="media-clear button" name="custom_logo-clear" data-rel="site-icon" />' . __( 'Clear', 'keni' ) . '</button>

	         <p class="description">サイトアイコンはブラウザーのタブやブックマークバー、WordPress モバイルアプリで表示されます。ぜひアップロードしましょう。<br />
	         サイトアイコンは512 × 512ピクセル以上の正方形にしてください。</p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_analytics() {
	$title = __( 'Googleアナリティクスタグ', 'keni' );
	$main  = '<p><textarea name="keni_google_analytics" cols="70" rows="5">%s</textarea></p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_login_analytics() {
	$title = __( 'ログイン中のGoogleアナリティクスタグ', 'keni' );
	$main  = '<ul>
	         <li><input type="radio" id="login-analytics1" name="keni_login_analytics" value="1"%s /><label for="login-analytics1">外す</label></li>
	         <li><input type="radio" id="login-analytics2" name="keni_login_analytics" value="0"%s /><label for="login-analytics2">外さない</label></li>
	         </ul>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_sp_footerpanel() {
	$title = __( 'スマートフォン向けフッターパネル', 'keni' );
	$main  = '%s
	         <p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'コンテンツ', 'keni' ) . '</label></p>
	         %s';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_sp_footerpanel_content_default() {
	$html = '<ul class="utility-menu">
<li class="btn_share utility-menu_item"><span class="icon_share"></span>シェア</li>
<li class="utility-menu_item"><a href="#top"><span class="icon_arrow_s_up"></span>TOPへ</a></li>
</ul>
<div class="keni-footer-panel_sns">
<div class="sns-btn_wrap sns-btn_wrap_s">
';
	$html .= keni_get_sns( '', '', false);
	$html .= '
</div>
</div>';

	return $html;
}

function keni_setting_header_content() {
	$title = __( 'ヘッダーコンテンツ', 'keni' );
	$main  = '<p class="description">ヘッダーレイアウト設定で2カラムを選択時に有効</p>
	         %s';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_head_after() {
	$title = __( '&lt;/head&gt; 直前に挿入するコード記入欄', 'keni' );
	$main  = '<p><textarea name="keni_head_after" cols="70" rows="5">%s</textarea></p>
	         <p class="description">（例）SearchCosoleの確認タグなど</p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_body_before() {
	$title = __( '&lt;body&gt; 直後に挿入するコード記入欄', 'keni' );
	$main  = '<p><textarea name="keni_body_before" cols="70" rows="5">%s</textarea></p>
	         <p class="description">（例）Facebookのウィジェット関連のタグなど</p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_body_after() {
	$title = __( '&lt;/body&gt; 直前に挿入するコード記入欄', 'keni' );
	$main  = '<p><textarea name="keni_body_after" cols="70" rows="5">%s</textarea></p>
	         <p class="description">（例）各種JavaScriptのスクリプトやアクセス解析タグなど</p>';

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_main_visual() {
	$title = __( 'メインビジュアル', 'keni' );
	$main  = keni_format_main_visual_metabox();

	return keni_format_metabox_holder( $title, $main );
}

function keni_setting_remove_format() {
    // WordPressによる自動整形を無効にする
    $title = __( 'Disable WordPress automatic formatting.', 'keni' );
    $main  = '<input type="checkbox" id="title-remove_format" name="keni_remove_format" value="1"%s /><label for="title-remove_format">' . __( 'Disable automatic formatting.', 'keni' ) . '</label>';

    return keni_format_metabox_holder( $title, $main );
}

function keni_disabled_customize_color_css() {
    // カスタマイザーによる色設定を無効にする
    $title = __( 'Disable Keni Color Setting', 'keni' );
    $main  = '<input type="checkbox" id="title-disabled_customize_color_css" name="keni_disabled_customize_color_css" value="1"%s /><label for="title-disabled_customize_color_css">' . __( 'Disable Keni Color CSS', 'keni' ) . '</label>';
    $main .= '<p class="description">カスタマイズで設定した色のCSSの吐き出しを無効化します。<br>CSSファイル側で色を調整したい場合には無効にしてください。</p>';

    return keni_format_metabox_holder( $title, $main );
}

function keni_setting_minify_flg() {
	$title = __( 'CSS Read Setting', 'keni' );
	$main  = '<ul>
	         <li><input type="radio" id="title-minify1" name="keni_minify_flg" value="0"%s /><label for="title-minify1">' . __('External Read CSS', 'keni') .'</label></li>
	         <li><input type="radio" id="title-minify2" name="keni_minify_flg" value="1"%s /><label for="title-minify2">' . __('Minify CSS', 'keni') .'</label></li>
	         </ul>';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * Format top title
 * @return string html
 */
function keni_format_setting_front_title() {
	$title = __( 'トップページのタイトル', 'keni' );
	$main  = '<p>%s</p>
			<p class="description">※ トップページだけに他のページと異なるタイトルを付けたい場合に設定します。</p>';

	return keni_format_metabox_holder( $title, $main );
}

/**
 * Get main visual
 * @return [type] [description]
 */
function keni_get_main_visual_data() {
	$str_get_main_visual_type                        = get_option( 'keni_main_visual_type' );
	$str_get_main_visual_image                       = get_option( 'keni_main_visual_image' );
	$str_get_main_visual_image_sp                    = get_option( 'keni_main_visual_image_sp' );
	$str_get_main_visual_image_wrap                  = get_option( 'keni_main_visual_image_wrap' );
	$str_get_main_visual_background                  = get_option( 'keni_main_visual_background' );
	$str_get_main_visual_background_sp               = get_option( 'keni_main_visual_background_sp' );
	$str_get_main_visual_background_wrap             = get_option( 'keni_main_visual_background_wrap' );
	$str_get_main_visual_movie_type                  = get_option( 'keni_main_visual_movie_type' );
	$str_get_main_visual_movie_file                  = get_option( 'keni_main_visual_movie_file' );
	$str_get_main_visual_movie_code                  = get_option( 'keni_main_visual_movie_code' );
	$str_get_main_visual_movie_sp                    = get_option( 'keni_main_visual_movie_sp' );
	$arr_get_main_visual_slider                      = get_option( 'keni_main_visual_slider' );
	$arr_get_main_visual_slider_sp                   = get_option( 'keni_main_visual_slider_sp' );
	$str_get_main_visual_slider_wrap                 = get_option( 'keni_main_visual_slider_wrap' );
	$arr_get_main_visual_slider_link                 = get_option( 'keni_main_visual_slider_link' );
	$arr_get_main_visual_slider_link_target          = get_option( 'keni_main_visual_slider_link_target' );
	$str_get_main_visual_wide                        = get_option( 'keni_main_visual_wide' );
	$str_get_main_visual_wide_sp                     = get_option( 'keni_main_visual_wide_sp' );
	$str_get_main_visual_background_content_position = get_option( 'keni_main_visual_background_content_position' );
	$str_get_main_visual_background_content          = get_option( 'keni_main_visual_background_content' );
	$str_get_main_visual_movie_content               = get_option( 'keni_main_visual_movie_content' );
	$str_get_main_visual_wide_content                = get_option( 'keni_main_visual_wide_content' );

	$arr_mv_data = array();
	// Type main-image
	if ( $str_get_main_visual_type == 'main-image' ) {
		$str_mv_url    = wp_get_attachment_image_src( $str_get_main_visual_image, 'full' );
		$str_mv_url_sp = wp_get_attachment_image_src( $str_get_main_visual_image_sp, 'full' );
		$str_mv_alt    = get_post_meta( $str_get_main_visual_image, '_wp_attachment_image_alt', true );
		$str_mv_alt_sp = get_post_meta( $str_get_main_visual_image_sp, '_wp_attachment_image_alt', true );

		if ( ! empty( $str_mv_url ) && ! empty( $str_mv_url_sp ) ) {
			$arr_mv_data['image_html'] = '
			                      <img class="keni-mv show-pc" src="' . $str_mv_url[0] . '" alt="' . $str_mv_alt . '">
			                      <img class="keni-mv show-sp" src="' . $str_mv_url_sp[0] . '" alt="' . $str_mv_alt_sp . '">';
		} elseif ( ! empty( $str_mv_url ) ) {
			$arr_mv_data['image_html'] = '
			                      <img class="keni-mv" src="' . $str_mv_url[0] . '" alt="' . $str_mv_alt . '">';
		} elseif ( ! empty( $str_mv_url_sp ) ) {
			$arr_mv_data['image_html'] = '
			                      <img class="keni-mv show-sp" src="' . $str_mv_url_sp[0] . '" alt="' . $str_mv_alt_sp . '">';
        }
		$arr_mv_data['image_class'] = ( $str_get_main_visual_image_wrap == 'wide' ) ? ' keni-mv_wide' : '';


		// Type main-background
	} elseif ( $str_get_main_visual_type == 'main-background' ) {
		$arr_mv_data['background_class'] = ( $str_get_main_visual_background_wrap == 'wide' ) ? ' keni-mv_wide' : '';
		$arr_mv_data['content_position'] = $str_get_main_visual_background_content_position;
		$arr_mv_data['content']          = $str_get_main_visual_background_content;

		// Type main-movie
	} elseif ( $str_get_main_visual_type == 'main-movie' ) {
		$str_mv_url    = wp_get_attachment_url( $str_get_main_visual_movie_file );
		$str_mv_url_sp = wp_get_attachment_url( $str_get_main_visual_movie_sp );

		if ( $str_get_main_visual_movie_type == "code" ) {
			$arr_mv_data['movie_html'] = $str_get_main_visual_movie_code;
		} elseif ( $str_get_main_visual_movie_type == "file" ) {
			$arr_mv_data['movie_html'] = '<video src="' . $str_mv_url . '" autoplay loop muted></video>';
		}
		$arr_mv_data['content'] = $str_get_main_visual_movie_content;

		// Type main-slider
	} elseif ( $str_get_main_visual_type == 'main-slider' ) {
		$str_mv_url                = '';
		$str_mv_url_sp             = '';
		$str_mv_alt                = '';
		$str_mv_alt_sp             = '';
		$str_mv_main_img           = '';
		$arr_mv_data['slide_html'] = '';
		if ( ! empty( $arr_get_main_visual_slider ) ) {
			$i = 0;
			foreach ( $arr_get_main_visual_slider as $key => $num_attachment_id ) {

				if ( ! empty( $num_attachment_id ) ) {
					$str_mv_url    = wp_get_attachment_image_src( $num_attachment_id, 'full' );
					$str_mv_url_sp = wp_get_attachment_image_src( $arr_get_main_visual_slider_sp[ $key ], 'full' );
					$str_mv_alt    = get_post_meta( $num_attachment_id, '_wp_attachment_image_alt', true );
					$str_mv_alt_sp = get_post_meta( $arr_get_main_visual_slider[ $key ], '_wp_attachment_image_alt', true );

					if ( ! empty( $str_mv_url ) && ! empty( $str_mv_url_sp ) ) {
						$str_mv_main_img = '
						                      <img class="keni-mv show-pc" src="' . $str_mv_url[0] . '" alt="' . $str_mv_alt . '">
						                      <img class="keni-mv show-sp" src="' . $str_mv_url_sp[0] . '" alt="' . $str_mv_alt_sp . '">';
					} elseif ( ! empty( $str_mv_url ) ) {
						$str_mv_main_img = '
						                      <img class="keni-mv" src="' . $str_mv_url[0] . '" alt="' . $str_mv_alt . '">';
					}
					$link_target = ( @$arr_get_main_visual_slider_link_target[ $key ] ? ' target="_blank"' : '' );
					$arr_mv_data['slide_html'] .= ( ! empty( $arr_get_main_visual_slider_link[ $key ] ) ) ? '<a href="' . $arr_get_main_visual_slider_link[ $key ] . '"'.$link_target.'>' . $str_mv_main_img . '</a>' : $str_mv_main_img;

				}
			}
		}
		$arr_mv_data['slider_class'] = ( $str_get_main_visual_slider_wrap == 'wide' ) ? ' keni-mv_wide' : '';

		// Type main-wide
	} elseif ( $str_get_main_visual_type == 'main-wide' ) {
		$arr_mv_data['content'] = $str_get_main_visual_wide_content;
	}

	return $arr_mv_data;
}

/**
 * <head> 直後に挿入
 */
function keni_head_prepend_set() {

	$flag_login_analytics = (int) get_option( 'keni_login_analytics' );
	$flag_analytics       = true;
	if ( is_user_logged_in() && $flag_login_analytics === 1 ) {

		$flag_analytics = false;

	}
	if ( $flag_analytics ) {
		echo get_option( 'keni_google_analytics' );
	}
}

add_action( 'keni_head_prepend', 'keni_head_prepend_set', 0 );

/**
 * </head> 直前に挿入
 */
function keni_head_after_set() {

	echo get_option( 'keni_head_after' );

}

add_action( 'wp_head', 'keni_head_after_set', 100 );

/**
 * <body> 直後に挿入
 */
function keni_body_before_set() {
	echo get_option( 'keni_body_before' );
}

add_action( 'keni_body_before', 'keni_body_before_set' );

/**
 * </body> 直前に挿入
 */
function keni_body_after_set() {
	echo get_option( 'keni_body_after' );
}

add_action( 'wp_footer', 'keni_body_after_set', 100 );

/**
 * wp_head noindex meta
 */
function keni_setting_style() {

	if ( is_front_page() && is_home() || is_front_page() ) {

		$str_get_main_visual_type          = get_option( 'keni_main_visual_type' );
		$str_get_main_visual_background    = get_option( 'keni_main_visual_background' );
		$str_get_main_visual_background_sp = get_option( 'keni_main_visual_background_sp' );
		$str_get_main_visual_movie_sp      = get_option( 'keni_main_visual_movie_sp' );
		$str_get_main_visual_wide          = get_option( 'keni_main_visual_wide' );
		$str_get_main_visual_wide_sp       = get_option( 'keni_main_visual_wide_sp' );
		$style                             = '';
		// Type main-background
		if ( $str_get_main_visual_type == 'main-background' ) {
			$str_mv_url    = wp_get_attachment_image_src( $str_get_main_visual_background, 'full' );
			$str_mv_url_sp = wp_get_attachment_image_src( $str_get_main_visual_background_sp, 'full' );
			if ( ! empty( $str_mv_url ) && ! empty( $str_mv_url_sp ) ) {
				$style = '.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url_sp[0] . '); }
				          @media (min-width : 768px) {
				          	.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url[0] . '); }
				          }';
			} elseif ( ! empty( $str_mv_url ) ) {
				$style = '.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url[0] . '); }';
			}

			// Type main-movie
		} elseif ( $str_get_main_visual_type == 'main-movie' ) {
			$str_mv_url_sp = wp_get_attachment_image_src( $str_get_main_visual_movie_sp, 'full' );
			if ( ! empty( $str_mv_url_sp ) ) {
				$style = '.keni-lp .bg-video{ background-image: url(' . $str_mv_url_sp[0] . '); }';
			}

			// Type main-wide
		} elseif ( $str_get_main_visual_type == 'main-wide' ) {
			$str_mv_url    = wp_get_attachment_image_src( $str_get_main_visual_wide, 'full' );
			$str_mv_url_sp = wp_get_attachment_image_src( $str_get_main_visual_wide_sp, 'full' );

			if ( ! empty( $str_mv_url ) && ! empty( $str_mv_url_sp ) ) {
				$style = '.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url_sp[0] . '); }
				          @media (min-width : 768px) {
				          	.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url[0] . '); }
				          }';
			} elseif ( ! empty( $str_mv_url ) ) {
				$style = '.keni-mv_bg .keni-mv_outer{ background-image: url(' . $str_mv_url[0] . '); }';
			}
		}

		echo '<style>' . $style . '</style>';
	}

}

add_action( 'wp_head', 'keni_setting_style', 9999 );


/**
 * Footer panel view
 */
function keni_sp_footerpanel() {
	$str_sp_footerpanel         = get_option( 'keni_sp_footerpanel' );
	$str_sp_footerpanel_content = get_option( 'keni_sp_footerpanel_content' );

	if ( $str_sp_footerpanel == 'show' && ! empty( $str_sp_footerpanel_content ) ) {
		echo sprintf( keni_sp_footerpanel_format(), $str_sp_footerpanel_content );
	}
}

function keni_sp_footerpanel_format() {
	$html = '<div class="keni-footer-panel_wrap">
<div class="keni-footer-panel_outer">
<aside class="keni-footer-panel">
%s
</aside>
</div><!--keni-footer-panel_outer-->
</div><!--keni-footer-panel_wrap-->';

	return $html;
}

//-----------------------------------------------------
// title タグ
//-----------------------------------------------------
/**
 * Edit title
 *
 * @param  array $title
 *
 * @return array
 */
function keni_edit_title( $title ) {
	global $post;

	$str_title         = '';
	$flag_site_show    = true;
	$flag_tagline_show = true;

	$str_front_title    = get_option( 'keni_front_title' );
	$num_title_blogname = get_option( 'keni_title_blogname' );

	// フロントページ titleタグ
	if ( is_front_page() && ! empty( $str_front_title ) ) {
		$str_title         = $str_front_title;
		$flag_site_show    = false;
		$flag_tagline_show = false;
	}

	// サイト名 下層ページ
	if ( ( ! is_home() || ! is_front_page() ) && $num_title_blogname == 0 ) {
		$flag_site_show = false;
	}

	// サイト名 個別設定
	if ( is_single() || is_page() ) {
		$str_get_title_blogname_post = get_post_meta( $post->ID, 'keni_title_blogname_post', true );
		if ( ! empty( $str_get_title_blogname_post ) ) {
			if ( $str_get_title_blogname_post == 'hide' ) {
				$flag_site_show = false;
			} elseif ( $str_get_title_blogname_post == 'show' ) {
				$flag_site_show = true;
			}
		}
	}

	// カテゴリー | タグ
	if ( is_category() || is_tag() ) {

		$str_title = keni_get_archive_title();

	}
	// アーカイブ
	if ( is_archive() ) {

		$str_title = keni_edit_archive_title( $title );

	}

	if ( ! empty( $str_title ) ) {
		$title['title'] = $str_title;
	}

	if ( ! $flag_site_show ) {
		unset( $title['site'] );
	}

	if ( ! $flag_tagline_show ) {
		unset( $title['tagline'] );
	}

	return $title;
}

add_filter( 'document_title_parts', 'keni_edit_title', 10, 1 );

/**
 * 賢威サポートチームからのお知らせ表示
 *
 * @param $screen_id
 */
function add_keni_support_message( $screen_id ) {
	if ( $screen_id == 'dashboard' ) {
		wp_add_dashboard_widget( 'view_message', '賢威サポートチームからのおしらせ', 'view_message' );
	}
}

add_action( 'do_meta_boxes', 'add_keni_support_message' );

/**
 * メッセージ表示
 */
function view_message() {
	$mon = array(
		"Jan" => "1",
		"Feb" => "2",
		"Mar" => "3",
		"Apr" => "4",
		"May" => "5",
		"Jun" => "6",
		"Jul" => "7",
		"Aug" => "8",
		"Sep" => "9",
		"Oct" => "10",
		"Nov" => "11",
		"Dec" => "12"
	);
	$xml = file_get_contents( "http://www.keni.jp/news.php" );
	$xml = utf8_for_xml( $xml );
	$rss = simplexml_load_string( $xml );

	$no = 0;
	echo "<ul>\n";
	foreach ( $rss->channel->item as $item ) {
		if ( $no < 5 ) {
			$time      = preg_match( '/([0-9]{2}) ([A-Z]{1}[a-z]{2}) ([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $item->pubDate, $date );
			$view_date = date( "Y年n月j日 H時i分", mktime( ( $date[4] + 9 ), $date[5], $date[6], $mon[ $date[2] ], $date[1], $date[3] ) );
			echo "<li>" . $view_date . "&nbsp;<a href=\"" . $item->link . "\" target=\"_blank\">" . $item->title . "</a></li>\n";
		}
		$no ++;
	}
	echo "</ul>\n";
}

/**
 * 賢威サポートチームからのお知らせ表示
 *
 * @param $screen_id
 */
function add_keni_env_view( $screen_id ) {
	if ( $screen_id == 'dashboard' ) {
		wp_add_dashboard_widget( 'view_env', '賢威環境情報', 'view_env' );
	}
}

add_action( 'do_meta_boxes', 'add_keni_env_view' );

function view_env() {
	?>
<!-- テーマ情報 -->

<div class="inside">

<p>賢威 <?php _e( '環境に関する情報です。', 'keni' ) ?></p>
<?php
$separator = '----------------------------------------------'.PHP_EOL;
$html_str = $separator;

//サイト情報
$html_str .= __( 'サイト名：', 'keni' ).get_bloginfo('name').PHP_EOL;
$html_str .= __( 'サイトURL：', 'keni' ).site_url().PHP_EOL;
$html_str .= __( 'ホームURL：', 'keni' ).home_url().PHP_EOL;
$html_str .= __( 'コンテンツURL：', 'keni' ).str_replace(home_url(), '', content_url()).PHP_EOL;
$html_str .= __( 'インクルードURL：', 'keni' ).str_replace(home_url(), '', includes_url()).PHP_EOL;
$html_str .= __( 'テンプレートURL：', 'keni' ).str_replace(home_url(), '', get_template_directory_uri()).PHP_EOL;
$html_str .= __( 'スタイルシートURL：', 'keni' ).str_replace(home_url(), '', get_stylesheet_directory_uri()).PHP_EOL;
$ip = @$_SERVER['REMOTE_ADDR'];
if ($ip) {
  //IP形式の場合は表示しない
  if (!preg_match('{^[0-9\.]+$}i', $ip)) {
    $host = gethostbyaddr($ip);
    $html_str .= __( 'サーバー：', 'keni' ).$host.PHP_EOL;
  }
}
$html_str .= __( 'WordPress バージョン：', 'keni' ).get_bloginfo('version').PHP_EOL;
$html_str .= __( 'PHP バージョン：', 'keni' ).phpversion().PHP_EOL;
if (isset($_SERVER['HTTP_USER_AGENT']))
  $html_str .= __( 'ブラウザ：', 'keni' ).$_SERVER['HTTP_USER_AGENT'].PHP_EOL;
if (isset($_SERVER['SERVER_SOFTWARE']))
  $html_str .= __( 'サーバーソフト：', 'keni' ).$_SERVER['SERVER_SOFTWARE'].PHP_EOL;
if (isset($_SERVER['SERVER_PROTOCOL']))
  $html_str .= __( 'サーバープロトコル：', 'keni' ).$_SERVER['SERVER_PROTOCOL'].PHP_EOL;
if (isset($_SERVER['HTTP_ACCEPT_CHARSET']))
  $html_str .= __( '文字セット：', 'keni' ).$_SERVER['HTTP_ACCEPT_CHARSET'].PHP_EOL;
if (isset($_SERVER['HTTP_ACCEPT_ENCODING']))
  $html_str .= __( 'エンコーディング：', 'keni' ).$_SERVER['HTTP_ACCEPT_ENCODING'].PHP_EOL;
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
  $html_str .= __( '言語：', 'keni' ).$_SERVER['HTTP_ACCEPT_LANGUAGE'].PHP_EOL;

$html_str .= $separator;

//親テーマ
$file = get_template_directory();
$info = get_theme_info($file);
if ($info) {
  if (isset($info['theme_name'])) {
    $html_str .= __( 'テーマ名：', 'keni' ).$info['theme_name'].PHP_EOL;
  }
  if (isset($info['version'])) {
    $html_str .= __( 'バージョン：', 'keni' ).$info['version'].PHP_EOL;
  }
  //カテゴリ数
  $args = array(
    'get' => 'all',
    'hide_empty' => 0
  );
  $categories = get_categories( $args );
  $html_str .= __( 'カテゴリ数：', 'keni' ).count($categories).PHP_EOL;

  $tags = get_tags( $args );
  $html_str .= __( 'タグ数：', 'keni' ).count($tags).PHP_EOL;

  $html_str .= __( 'ユーザー数：', 'keni' ).count(get_users()).PHP_EOL;

  $html_str .= $separator;
}

//子テーマ
if (is_child_theme()) {
  $file = get_stylesheet_directory();
  $info = get_theme_info($file);
  if ($info) {
    if (isset($info['theme_name'])) {
      $html_str .= __( '子テーマ名：', 'keni' ).$info['theme_name'].PHP_EOL;
    }
    if (isset($info['version'])) {
      $html_str .= __( 'バージョン：', 'keni' ).$info['version'].PHP_EOL;
    }
    $html_str .= $separator;
  }
}

  //plugin.phpを読み込む
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  $plugins = get_plugins();
  if (!empty($plugins)) {
    $html_str .= __('利用中のプラグイン：').PHP_EOL;
    foreach ($plugins as $path => $plugin) {
      if (is_plugin_active( $path )) {
        $html_str .= $plugin['Name'];
        $html_str .= ' '.$plugin['Version'].PHP_EOL;
      }
    }
  $html_str .= $separator;
}

//var_dump($all);
 ?>
<!--    <pre>--><?php //echo $all; ?><!--</pre>-->
<p><?php _e( '不具合報告の際には以下の情報を添えてもらうと助かります。', 'keni' ) ?></p>
<textarea style="width: 100%;height: 400px"><?php echo $html_str; ?></textarea>


</div>
<?php
}

// 親テーマ取得
function get_theme_info( $tm_dir ) {

	$theme_tmp = get_template();
	if ( $tm_dir == get_stylesheet_directory() ) {
		$theme_tmp = '';
	}
	$theme_data        = wp_get_theme( $theme_tmp );

	return array(
		'theme_name'        => $theme_data->Name, // @phpcs:ignore
		'version'     => $theme_data->Version, // @phpcs:ignore
	);
}

/**
 * XML で利用できない文字を削除する
 *
 * @param $string
 *
 * @return null|string|string[]
 */
function utf8_for_xml( $string ) {
	return preg_replace( '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string );
}

