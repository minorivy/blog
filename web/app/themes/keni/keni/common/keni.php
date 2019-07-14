<?php
//-----------------------------------------------------
// 賢威functions
//-----------------------------------------------------

/**
 * media upload script
 * @return string   script html
 */
function keni_the_media_upload_script() {
	?>
    <script type="text/javascript">
        jQuery(function ($) {
            var custom_uploader;
            var rel;
            var type;
            $(document).on('click', '.media-upload', function (e) {
                rel = $(this).attr("data-rel");
                type = $(this).attr("data-type");
                custom_uploader = "";
                e.preventDefault();
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                custom_uploader = wp.media({
                    title: "<?php _e( "Please select", 'keni' ) ?>",

                    library: {
                        type: type
                    },
                    button: {
                        text: "<?php _e( "Select", 'keni' ) ?>"
                    },

                    multiple: false
                });

                custom_uploader.on("select", function () {
                    var files = custom_uploader.state().get("selection");

                    files.each(function (file) {
                        if (type == 'image') {

                            data_url = file.attributes.sizes.full.url;
                            try {
                                data_view = '<img src="' + file.attributes.sizes.medium.url + '" alt="">';
                            } catch (e) {
                                data_view = '<img src="' + file.attributes.sizes.full.url + '" alt="">';
                            }
                        } else if (type == 'video') {
                            data_url = file.attributes.url;
                            data_view = '<a href="' + data_url + '" target="_blank"><img src="' + file.attributes.icon + '" alt="">　' + file.attributes.filename + '</a>';
                        } else {
                            data_url = '';
                            data_view = '';
                        }
                        $('#' + rel + '-url').val(data_url);
                        $('#' + rel + '-view').html(data_view);
                        $('#' + rel).val(file.attributes.id);
                    });
                });
                custom_uploader.open();
            });

            /* clear button */
            $(document).on('click', '.media-clear', function () {
                var rel = $(this).attr("data-rel");
                $('#' + rel + '-url').val("");
                $('#' + rel + '-view').empty();
                $('#' + rel).val("");
            });

            /* clear button sheepIt jQuery*/
            $(document).on('click', '.slider-image-clear-button', function () {
                $(this).parents('.slider-image-default').remove();
            });
        });
    </script>

	<?php
}

/**
 * format options form
 *
 * @param  string $str_option_group グループ名
 * @param  array $arr_metaboxs メタボックス
 *
 * @return string                   form html
 */
function keni_the_format_options_form( $str_option_group = '', $arr_metaboxs = array() ) {

	if ( empty( $str_option_group ) || ! is_array( $arr_metaboxs ) || empty( $arr_metaboxs ) ) {
		return;
	}

	?>
<div class="wrap">
    <h2 id=""option_setting"><?php _e( 'Keni Settings', 'keni' ); ?></h2>
    <form method="post" action="options.php" enctype="multipart/form-data" encoding="multipart/form-data">
		<?php
		keni_the_media_upload_script();

		settings_fields( $str_option_group );
		do_settings_sections( $str_option_group );

		foreach ( $arr_metaboxs as $key => $value ) {
			echo $value;
		}

		submit_button();
		?>
    </form>
</div><?php
}


/**
 * format metabox
 *
 * @param  string $title [description]
 * @param  string $main [description]
 *
 * @return string        [description]
 */
function keni_format_metabox_holder( $title = '', $main = '' ) {
	return <<< EOM
		<div class="metabox-holder">
		<div id="toppage_meta_setting" class="postbox" >
		<h3 class="hndle"><span>$title</span></h3>
			<div class="inside">
				<div class="main">
					{$main}
				</div>
			</div>
		</div>
		</div>
EOM;
}

/**
 * Format radio
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  array $arr_list 選択項目
 * @param  array $return 返り値方法
 *
 * @return array | string       form html
 */
function keni_format_radio( $str_name = "", $str_value = "", $arr_list = array(), $return = "" ) {

	$html     = '';
	$arr_html = array();

	if ( is_array( $arr_list ) ):
		$checked = '';
		$html    = '<ul>';
		foreach ( $arr_list as $d ) {
			$checked = ( (string) $d[0] === $str_value ) ? "checked" : "";

			$arr_html[] = '<input type="radio" name="' . $str_name . '" value="' . $d[0] . '" ' . $checked . '> ' . $d[1] . '</label>';
			$html       .= <<< EOM
			<li><label><input type="radio" name="{$str_name}" value="{$d[0]}" {$checked}> {$d[1]}</label></li>
EOM;
		}
		$html .= '</ul>';
	endif;

	return ( $return == 'array' ) ? $arr_html : $html;
}

/**
 * Format checkbox
 *
 * @param  string $str_name name属性
 * @param  string|array $value 設定値
 * @param  array $arr_list 選択項目
 *
 * @return string                      form html
 */
function keni_format_checkbox( $str_name = "", $value = array(), $arr_list = array(), $bool_single = false ) {
	$html = '';
	if ( is_array( $arr_list ) ):
		$checked       = '';
		$str_name_edit = ( $bool_single ) ? $str_name : $str_name . '[]';
		$html          = '<ul>';
		foreach ( $arr_list as $d ) {
			if ( is_array( $value ) ) {
				$checked = ( in_array( $d[0], $value ) ) ? "checked" : "";
			} else {
				$checked = ( $d[0] == $value ) ? "checked" : "";
			}
			$d_str = "";
			if ( is_array( $d ) ) ( count( $d ) > 1 ? $d_str = $d[1] : $d_str = "" );
			$html .= <<< EOM
			<li><label><input type="checkbox" name="{$str_name_edit}" value="{$d[0]}" {$checked}> {$d_str}</label></li>
EOM;
		}
		$html .= '</ul>';
	endif;

	return $html;
}

/**
 * Format checkboxs
 *
 * @param  string $str_name name属性
 * @param  string|array $value 設定値
 * @param  array $arr_list 選択項目
 *
 * @return string                      form html
 */
function keni_format_checkboxs( $str_name = "", $value = array(), $arr_list = array(), $bool_single = false ) {
	$html = '';
	if ( is_array( $arr_list ) ):
		$checked       = '';
		$str_name_edit = ( $bool_single ) ? $str_name : $str_name . '[]';
		$html          = '<ul>';
		foreach ( $arr_list as $d ) {
			if ( is_array( $value ) ) {
				$checked = ( in_array( $d[0], $value ) ) ? "checked" : "";
			} else {
				$checked = ( $d[0] == $value ) ? "checked" : "";
			}
			$d_str = "";
			if ( is_array( $d ) ) ( count( $d ) > 1 ? $d_str = $d[1] : $d_str = "" );
			$html .= <<< EOM
			<li><label><input type="checkbox" id="{$str_name}-#index#" name="{$str_name_edit}" value="{$d[0]}" {$checked}> {$d_str}</label></li>
EOM;
		}
		$html .= '</ul>';
	endif;

	return $html;
}

/**
 * Format select
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  array $arr_list 選択項目
 *
 * @return string               form html
 */
function keni_format_select( $str_name = "", $str_value = "", $arr_list = array() ) {
	$html = '';
	if ( is_array( $arr_list ) ):
		$selected = '';
		$html     = '<select name="' . $str_name . '">';
		foreach ( $arr_list as $d ) {
			$selected = ( $d[0] === $str_value ) ? "selected" : "";
			$html     .= <<< EOM
			<option value="{$d[0]}" {$selected}>{$d[1]}</option>
EOM;
		}
		$html .= '</select>';

	endif;

	return $html;
}

/**
 * Format input text
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  string $str_class class属性
 *
 * @return string            form html
 */
function keni_format_text( $str_name = "", $str_value = "", $str_class = 'regular-text', $str_placeholder = '' ) {
	$str_value_esc             = esc_html( $str_value );
	$str_placeholder_attribute = ( ! empty( $str_placeholder ) ) ? ' placeholder="' . $str_placeholder . '"' : '';

	return <<< EOM
	<input type="text" name="{$str_name}" class="{$str_class}" value="{$str_value}"{$str_placeholder_attribute} />
EOM;
}

/**
 * Format input texts
 * sheepIt jQuery
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  string $str_class class属性
 *
 * @return string            form html
 */
function keni_format_texts( $str_name = "", $str_value = "", $str_class = 'regular-text', $str_placeholder = '' ) {
	$str_value_esc             = esc_html( $str_value );
	$str_placeholder_attribute = ( ! empty( $str_placeholder ) ) ? ' placeholder="' . $str_placeholder . '"' : '';

	return <<< EOM
	<input type="text" id="{$str_name}-#index#" name="{$str_name}[]"  class="{$str_class}" value="{$str_value}"{$str_placeholder_attribute} />
EOM;
}

/**
 * Format input urls
 * sheepIt jQuery
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  string $str_class class属性
 *
 * @return string            form html
 */
function keni_format_urls( $str_name = "", $str_value = "", $str_class = 'regular-text', $str_placeholder = '' ) {
	$str_value_esc             = esc_html( $str_value );
	$str_placeholder_attribute = ( ! empty( $str_placeholder ) ) ? ' placeholder="' . $str_placeholder . '"' : '';

	return <<< EOM
	<input type="url" id="{$str_name}-#index#" name="{$str_name}[]"  class="{$str_class}" value="{$str_value}"{$str_placeholder_attribute} />
EOM;
}

/**
 * Format textarea
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  string $str_class class属性
 *
 * @return string            form html
 */
function keni_format_textarea( $str_name = "", $str_value = "", $str_class = 'regular-text' ) {
	$str_value = esc_html( $str_value );

	return <<< EOM
	<textarea name="{$str_name}" class="{$str_class}" rows="10">{$str_value}</textarea>
EOM;
}

/**
 * Format editor
 *
 * @param  string $str_name name属性
 * @param  string $str_value 設定値
 * @param  array $arr_settings 引数の配列
 *
 * @return string                form html
 */
function keni_format_editor( $str_name = "", $str_value = "", $arr_settings = array() ) {
	// $str_value = esc_html( $str_value );

	ob_start();
	wp_editor( $str_value, $str_name, $arr_settings );

	return ob_get_clean();

}

/**
 * Format file upload
 *
 * @param  string $str_name name属性
 * @param  string $num_value 画像ID
 * @param  string $type image, audio, video
 *
 * @return string             form html
 */
function keni_format_upload( $str_name = "", $num_value = "", $type = '' ) {
	$str_file_img = '';
	if ( ! empty( $num_value ) ) {
		if ( $type == "image" ) {
			$str_file_preview_url = wp_get_attachment_image_src( $num_value, 'medium' );
			$str_file_url         = wp_get_attachment_url( $num_value );
			$str_file_img         = ( ! empty( $str_file_url ) ) ? '<img src="' . $str_file_preview_url[0] . '" alt="">' : '';
		} elseif ( $type == "video" ) {
			$str_file_preview_url = includes_url() . '/images/media/video.png';
			$thumb_post           = get_post( $num_value );
			$str_file_name        = $thumb_post->post_name;
			$str_file_url         = wp_get_attachment_url( $num_value );
			$str_file_img         = ( ! empty( $str_file_url ) ) ? '<a href="' . $str_file_url . '" terget="_blank"><img src="' . $str_file_preview_url . '" alt="">　' . $str_file_name . '</a>' : '';
		}
	}

	return '
		<p id="' . $str_name . '-view">' . $str_file_img . '</p>
		<p>
		<button type="button" class="media-upload cmb_upload_button button" data-rel="' . $str_name . '" data-type="' . $type . '">' . __( 'Upload Image', 'keni' ) . '</button>
		<button type="button" class="media-clear button" data-rel="' . $str_name . '">' . __( 'Clear', 'keni' ) . '</button>
		<input type="hidden" id="' . $str_name . '" name="' . $str_name . '" value="' . $num_value . '" />
		</p>
		';
}

/**
 * Format file uploads
 * sheepIt jQuery
 *
 * @param  string $str_name name属性
 * @param  string $num_value 画像ID
 * @param  string $type image, audio, video
 *
 * @return string             form html
 */
function keni_format_uploads( $str_name = "", $num_value = "", $type = '' ) {
	$str_file_img = '';
	if ( ! empty( $num_value ) ) {
		if ( $type == "image" ) {
			$str_file_preview_url = wp_get_attachment_image_src( $num_value, 'medium' );
			$str_file_url         = wp_get_attachment_url( $num_value );
			$str_file_img         = ( ! empty( $str_file_url ) ) ? '<img src="' . $str_file_preview_url[0] . '" alt="">' : '';
		} elseif ( $type == "video" ) {
			$str_file_preview_url = includes_url() . '/images/media/video.png';
			$thumb_post           = get_post( $num_value );
			$str_file_name        = $thumb_post->post_name;
			$str_file_url         = wp_get_attachment_url( $num_value );
			$str_file_img         = ( ! empty( $str_file_url ) ) ? '<a href="' . $str_file_url . '" terget="_blank"><img src="' . $str_file_preview_url . '" alt="">　' . $str_file_name . '</a>' : '';
		}
	}

	return '
		<span id="' . $str_name . '-#index#-view">' . $str_file_img . '</span>
		<button type="button" class="media-upload cmb_upload_button button" data-rel="' . $str_name . '-#index#" data-type="' . $type . '">' . __( 'Upload Image', 'keni' ) . '</button>
		<input type="hidden" id="' . $str_name . '-#index#" name="' . $str_name . '[]" value="' . $num_value . '" /></td>
		';
}

/**
 * メインビジュアル 設定 html format
 * @return string    form html
 */
function keni_format_main_visual_metabox() {
	return '
	%s

	<div id="keni-tabs">
		<ul class="category-tabs">
			<li class="tabs"><a href="#tabs-1">' . __( 'Image', 'keni' ) . '</a></li>
			<li><a href="#tabs-2">' . __( 'Background Image', 'keni' ) . '</a></li>
			<li><a href="#tabs-3">' . __( 'Movie', 'keni' ) . '</a></li>
			<li><a href="#tabs-4">' . __( 'Slider', 'keni' ) . '</a></li>
			<li><a href="#tabs-5">' . __( 'Full Screen', 'keni' ) . '</a></li>
		</ul>
		<div class="postbox">
		<div id="tabs-1" class="inside">
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Display width', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image for mobile', 'keni' ) . '</label></p>
			%s
		</div>
		<div id="tabs-2" class="inside">
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Display width', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image for mobile', 'keni' ) . '</label></p>
			%s

			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Text', 'keni' ) . '</label></p>
			%s

			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Text position', 'keni' ) . '</label></p>
			%s
		</div>
		<div id="tabs-3" class="inside">
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Embed code', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'mp4', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image for mobile', 'keni' ) . '</label></p>
			%s

			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Text', 'keni' ) . '</label></p>
			%s
		</div>
		<div id="tabs-4" class="inside">
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Display width', 'keni' ) . '</label></p>
			%s

			<div id="keni_slider">
				<!-- Form template-->
					%s
				<!-- /Form template-->

				<div class="sortable">
				<!-- No forms template -->
				%s
				<div id="keni_slider_noforms_template"></div>
				<!-- /No forms template-->
				</div>

				<!-- Controls -->
				<div id="keni_slider_controls">
					<p id="keni_slider_add"><button type="button" class="button">' . __( 'Add image', 'keni' ) . '</button></a></p>
				</div>
				<!-- /Controls -->
			</div>

			<script type="text/javascript">
				jQuery(function($){
				
					$(document).ready(function() {
						 
						var sheepItForm = $("#keni_slider").sheepIt({
							separator: "",
							allowRemoveLast: true,
							allowRemoveCurrent: true,
							allowRemoveAll: true,
							allowAdd: true,
							allowAddN: true,
							maxFormsCount: 40,
							minFormsCount: 0,
							iniFormsCount: 0,
						});
					});

					$( function() {
						$( ".sortable" ).sortable();
						$( ".sortable" ).disableSelection();
					} );
				});
			</script>

		</div>
		<div id="tabs-5" class="inside">
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image', 'keni' ) . '</label></p>
			%s
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Image for mobile', 'keni' ) . '</label></p>
			%s

			<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . __( 'Text', 'keni' ) . '</label></p>
			%s

		</div>
		</div>
	</div>';
}

/**
 * slider form template
 * @return [type] [description]
 */
function keni_slider_form_template() {
	return '<div id="keni_slider_template" class="slider-image">
			<table class="keni-admin-table">
			<thead>
			<tr>
				<th></th>
				<th>' . __( 'Image ', 'keni' ) . '</th>
				<th>' . __( 'Image for mobile', 'keni' ) . '</th>
				<th>' . __( 'Link URL', 'keni' ) . '</th>
				<th>' . __( 'Link Target', 'keni' ) . '</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><label for="phones-#index#"><i class="dashicons dashicons-sort"></i></label></td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>
				<a id="keni_slider_remove_current" class="slider-image-clear-button">
					<i class="dashicons dashicons-dismiss"></i>
				</a>
				</td>
			</tr>
			</tbody>
			</table>
			</div>
			';
}

/**
 * ul post list format
 * @return string
 */
function keni_format_thumb_li( $target = "" ) {
	return '<li>
	        <figure class="widget_recent_entries_thumb">
	        <a href="%s"'.$target.'><img src="%s" alt="%s" width="150"></a>
	        </figure>
	        <p class="widget_recent_entries_img_entry_title"><a href="%s"'.$target.'>%s</a></p>
	        </li>
	';
}

function keni_format_thumb_background_li( $target = "" ) {
	return '<li style="background-image: url(%s);">
	        <p class="widget_recent_entries_img_entry_title"><a href="%s"'.$target.'>%s</a></p>
	        </li>
	';
}

/*
 * save category custom fields
 */
function keni_save_term_fileds( $term_id ) {
	// Check capabilities
	if ( ! current_user_can( 'manage_categories', $term_id ) ) {
		return $term_id;
	}

	// Save data
	if ( isset( $_POST['keni_term_meta'] ) ) {
		if ( function_exists( "get_term_meta" ) ) {
			foreach ( $_POST['keni_term_meta'] as $key => $val ) {
				if ( $val != "" ) {
					$default = get_term_meta( $term_id, $key, true );
					update_term_meta( $term_id, $key, $val, $default );
				} else {
					delete_term_meta( $term_id, $key );
				}
			}
		} else {
			$term_keys = array_keys( $_POST['keni_term_meta'] );
			foreach ( $_POST['keni_term_meta'] as $key => $val ) {
				if ( $val != "" ) {
					update_option( $key . "_" . $term_id, $val, 'no' );
				} else {
					delete_option( $key . "_" . $term_id );
				}
			}
		}
	}
}

add_action( 'created_term', 'keni_save_term_fileds' );
add_action( 'edited_term', 'keni_save_term_fileds' );


/**
 * 表示をしているページやアーカイブ等の、現在のページ数と、最大ページ数を取得する
 * @return array|bool
 */
if ( ! function_exists( 'keni_page_number' ) ) {
	function keni_page_number() {

		$permalink = get_permalink();

		if ( is_singular() ) {
			$content           = get_post();
			$page['max_pages'] = count( explode( '<!--nextpage-->', $content->post_content ) );

			$permalink_structure = get_option( 'permalink_structure' );

			if ( $permalink_structure == "" ) {
				$perm_slash = "q";
			} elseif ( preg_match( "/\/$/u", $permalink_structure ) ) {
				$perm_slash = "y";
			} else {
				$perm_slash = "n";
			}

			if ( $page['max_pages'] > 1 ) {
				if ( preg_match( "/\?p=" . get_the_ID() . "/", $permalink ) || preg_match( "/\?page_id=" . get_the_ID() . "/", $permalink ) ) {    // デフォルト
					$page['now_page']  = isset( $_GET['page'] ) && preg_match( "/^[0-9]+$/", $_GET['page'] ) ? $_GET['page'] : 1;
					$page['permalink'] = "default";

				} elseif ( preg_match( "/\/%post_id%\/*$/", $permalink_structure ) && preg_match( "/" . get_the_ID() . "/", $permalink ) ) {    // 数字ベース
					preg_match( "/" . get_the_ID() . "\/([0-9]+)/", $_SERVER['REQUEST_URI'], $pages );
					$page['now_page']  = isset( $pages[1] ) ? $pages[1] : 1;
					$page['permalink'] = "number";

				} elseif ( $perm_slash == "y" ) {    // その他で、最後にスラッシュが入っている場合
					preg_match( "/(.+)\/([0-9]+)\/$/", $_SERVER['REQUEST_URI'], $this_page );
					$page['now_page']  = ( isset( $this_page[2] ) ) ? $this_page[2] : 1;
					$page['permalink'] = "other";

					/*				} elseif (is_singular(LP_DIR)) {
										$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
										$page_data = str_ireplace(get_permalink(),"",$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
										if (preg_match("/([0-9]+)/", $page_data, $pageno)) {
											$page['now_page'] = (isset($pageno[1])) ? $pageno[1] : 1;
										} else {
											$page['now_page'] = 1;
										}

					*/
				} elseif ( is_front_page() ) {

					$protocol  = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) ? "https://" : "http://";
					$page_data = str_ireplace( get_home_url(), "", $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
					preg_match( "/\/.*?([0-9]+)\/*$/", $page_data, $this_page );
					$page['now_page'] = ( isset( $this_page[1] ) ) ? $this_page[1] : 1;
					if ( $permalink_structure == "" ) {
						$page['permalink'] = "default";
					} elseif ( preg_match( "/%post_id%\/*$/", $permalink_structure ) ) {
						$page['permalink'] = "number";
					} else {
						$page['permalink'] = "other";
					}

				} else {
					preg_match( "/(.+)\/([0-9]+)$/", $_SERVER['REQUEST_URI'], $this_page );
					$page['now_page']  = ( isset( $this_page[2] ) ) ? $this_page[2] : 1;
					$page['permalink'] = "other";
				}
			} else {
				$page['now_page'] = 0;
			}

		} elseif ( is_search() ) {
			$page['now_page'] = get_query_var( 'paged' );

			global $wp_query;
			$rows              = $wp_query->found_posts;
			$page['max_pages'] = ceil( $rows / get_option( 'posts_per_page' ) );

		} elseif ( is_archive() || is_front_page() || is_home() ) {

			global $wp_query;
			$page['max_pages'] = $wp_query->max_num_pages;
			$page['now_page']  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			if ( $page['max_pages'] > 1 ) {
				if ( is_category() || is_date() || is_tag() ) {
					$page['permalink'] = ( preg_match( "/\?(cat|m|tag|author)=.+/", $_SERVER['REQUEST_URI'] ) ) ? "default" : "other";
				} elseif ( is_author() ) {
					$page['permalink'] = ( preg_match( "/\?(p|m|cat|tag)=.+/", $permalink ) ) ? "default" : "other";
				}
			}
		}

		return ( isset( $page ) ) ? $page : false;
	}
}

//-----------------------------------------------------
// パンくず表示
//-----------------------------------------------------
if ( ! function_exists( 'the_keni_breadcrumbs' ) ) {
	function the_keni_breadcrumbs( $separator = '', $multiple_separator = ' | ' ) {

		if ( is_front_page() && ! is_paged() && ! isset( $_GET['post_type'] ) ) {
			return true;
		}

		global $wp_query;
		global $tree;
		$tree = array();

		// TOP
		setTree( home_url(), get_bloginfo( 'name' ) );

		$queried_object = $wp_query->get_queried_object();

		$paged    = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$max_page = get_max_page();

		if ( is_front_page() && isset( $_GET['post_type'] ) && $_GET['post_type'] != "" ) {
			$taxonomy = get_post_type_object( $_GET['post_type'] );
			if ( isset( $taxonomy->labels->singular_name ) ) {
				setTree( '', $taxonomy->labels->singular_name );
			}

		} elseif ( is_home() ) {

			$post_page = get_option( 'page_for_posts' );
			if ( ! empty( $post_page ) && $post_page > 0 ) {
				$top_page_data = get_post( $post_page );
				if ( is_object( $top_page_data ) && ( $top_page_data->post_parent ) > 0 ) {
					get_page_parents_keni( $top_page_data->post_parent );
				}
			}

			if ( $paged > 1 ) {
				if ( ! is_front_page() ) {
					if ( ! empty( $post_page ) && $post_page > 0 ) {
						setTree( get_page_link( $post_page ), get_the_title( get_option( 'page_for_posts' ) ) );
					} else {
						setTree( home_url(), get_the_title( get_option( 'page_for_posts' ) ) );
					}
				}

				$title = ( isset( $top_page_data->post_title ) && ( $top_page_data->post_title != "" ) ) ? $top_page_data->post_title : get_bloginfo( 'name' );
				setTree( '', sprintf( __( 'View all posts in %s', 'keni' ), $title ) . show_page_number() );

			} else {
				$post_type = get_query_var( 'post_type' );
				if ( ! empty( $post_type ) ) {
					setTree( get_page_link( $post_page ), get_the_title( get_option( 'page_for_posts' ) ) );
				} else {
					setTree( '', get_the_title( get_option( 'page_for_posts' ) ) );
				}
			}

		} else {
			if ( is_page() ) {
				$post_page = get_post( get_the_ID() );
				if ( is_object( $post_page ) && $post_page->post_parent > 0 ) {
					get_page_parents_keni( $post_page->post_parent );
				}
				global $page;
				if ( $page > 1 ) {
					setTree( get_page_link( $post_page ), get_the_title( $post_page ) );
				}
			} else {
				$post_page = get_option( 'page_for_posts' );
				if ( ! empty( $post_page ) && $post_page > 0 ) {
					$top_page_data = get_post( $post_page );
					if ( is_object( $top_page_data ) && ( $top_page_data->post_parent ) > 0 ) {
						get_page_parents_keni( $top_page_data->post_parent );
					}
					setTree( get_page_link( $post_page ), get_the_title( $post_page ) );
				}
			}
		}

		if ( is_attachment() ) {

			setTree( '', get_the_title() );

		} elseif ( is_page() ) {
			( $page > 1 ) ? setTree( '', $page . __( 'page', 'keni' ) ) : setTree( '', get_the_title() );

		} elseif ( is_single() ) {

			if ( is_singular( 'post' ) ) {

				$primary_category = get_post_meta( get_the_ID(), 'keni_primary_category_post', true );

				if ( $primary_category > 0 && $primary_category != null ) {
					$categories[0] = get_category( $primary_category );
				} else {
					$categories = get_the_category();
				}

				foreach ( $categories as $category ) {
					if ( $category->parent ) {
						$parent = get_category_parents( $category->parent, true, "" );
						preg_match_all( '/href="(.+?)">(.+?)<\/a>/', $parent, $cat_dirs, PREG_SET_ORDER );
						if ( is_array( $cat_dirs ) && count( $cat_dirs ) > 0 ) {
							foreach ( $cat_dirs as $links ) {
								setTree( $links[1], $links[2] );
							}
						}
					}

					setTree( get_category_link( $category->term_id ), $category->name );

					global $page, $paged, $numpages;
					if ( $page > 1 ) {
						setTree( get_permalink(), get_the_title() .'（'.$page .' / '.$numpages. __( 'page', 'keni' ).'）' );
					} else {
						setTree( '', get_the_title() );
					}
					// メイン設定時には1つだけに。されていない場合にも1つだけ表示するため
					break;
				}
			} else {
				$taxonomy = $wp_query->get_queried_object();
				if ( isset( $taxonomy->post_type ) ) {
					$taxonomy_category = get_post_type_object( get_post_type() );
					if ( isset( $taxonomy_category->label ) ) {
						$taxonomy_category_url = ( get_post_type_archive_link( $taxonomy_category->name ) != "" ) ? get_post_type_archive_link( $taxonomy_category->name ) : site_url() . '/?post_type=' . $taxonomy_category->name;
						setTree( $taxonomy_category_url, $taxonomy_category->label );
					}
					setTree( '', $taxonomy->post_title );
				}
			}

		} elseif ( is_search() ) {

			setTree( '', sprintf( __( 'Search Result for %s', 'keni' ), esc_html( get_search_query() ) ) . show_page_number() );

		} elseif ( is_404() ) {

			setTree( '', __( 'Sorry, but you are looking for something that isn&#8217;t here.', 'keni' ) );

		} elseif ( is_category() ) {
			if ( $queried_object->category_parent ) {
				$parent = get_category_parents( $queried_object->category_parent, true, "" );
				preg_match_all( '/href="(.+?)">(.+?)<\/a>/', $parent, $cat_dirs, PREG_SET_ORDER );
				if ( is_array( $cat_dirs ) && count( $cat_dirs ) > 0 ) {
					foreach ( $cat_dirs as $links ) {
						setTree( $links[1], $links[2] );
					}
				}
			}
			if ( $paged > 1 ) {
				setTree( get_category_link( $queried_object->cat_ID ), single_cat_title( "", false ) );
				setTree( '', sprintf( __( 'Archive List for %s', 'keni' ), single_cat_title( "", false ) ) . show_page_number() );
			} else {
				setTree( '', single_cat_title( "", false ) );
			}

		} elseif ( is_year() ) {
			if ( $paged > 1 ) {
				setTree( get_year_link( date( "Y", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'Y', 'keni' ) ) ) );
				setTree( '', keni_get_archive_title() );
			} else {
				setTree( '', sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'Y', 'keni' ) ) ) );
			}

		} elseif ( is_month() ) {

			setTree( get_year_link( date( "Y", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'Y', 'keni' ) ) ) );

			if ( $paged > 1 ) {
				setTree( get_year_link( date( "Y/m", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'F Y', 'keni' ) ) ) );
				setTree( '', keni_get_archive_title() );
			} else {
				setTree( '', sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'F Y', 'keni' ) ) ) );
			}

		} elseif ( is_day() ) {

			setTree( get_year_link( date( "Y", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'Y', 'keni' ) ) ) );
			setTree( get_year_link( date( "Y/m", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'F Y', 'keni' ) ) ) );

			if ( $paged > 1 ) {
				setTree( get_year_link( date( "Y/m/d", get_post_time() ) ), sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'F j, Y', 'keni' ) ) ) );
				setTree( '', keni_get_archive_title() );
			} else {
				setTree( '', sprintf( __( 'Archive List for %s', 'keni' ), get_the_time( __( 'F j, Y', 'keni' ) ) ) );
			}

		} elseif ( is_author() ) {
			setTree( '', get_the_author() . sprintf( __( 'Archive List for authors', 'keni' ) ) . show_page_number() );

		} elseif ( is_tag() ) {
			if ( $paged > 1 ) {
				setTree( get_tag_link( $queried_object->term_id ), single_cat_title( "", false ) );
				setTree( '', sprintf( __( 'Archive List for %s', 'keni' ), single_cat_title( "", false ) ) . show_page_number() );
			} else {
				setTree( '', single_cat_title( "", false ) );
			}

		} else {
			$term = single_term_title( '', false );
			if ( ! empty( $term ) ) {
				setTree( '', $term );
			} else {
				$post_type = get_query_var( 'post_type' );
				if ( ! empty( $post_type ) ) {
					$object = get_post_type_object( $post_type );
					if ( isset( $object->labels->name ) && ! empty( $object->labels->name ) ) {
						setTree( '', $object->labels->name );
					}
				}
			}
		}
		wp_reset_query();

		// 生成された配列から、microdataを生成
		$breadcrumbs = "";
		global $tree;
		
		$home_name_str_mv = "";
		foreach ( $tree as $position => $val ) {
			if ( $val['href'] != "" ) {
				if ( $position === 1 ) {
					/**
					 * TOP のみの表示にする場合
					 * add_filter('keni_breadcrumbs_top_name', 'set_keni_breadcrumbs_top_name', 10, 1);
					 * function set_keni_breadcrumbs_top_name() { return "TOP"; }
					 */
					$home_name_str_mv = apply_filters( 'keni_breadcrumbs_top_name', "" );
					$home_name_str    = "<span itemprop=\"name\">" . esc_html( $val['name'] ) . "</span> TOP";
					if ( ! empty( $home_name_str_mv ) ) {
						$home_name_str = "<span itemprop=\"name\">" . $home_name_str_mv . "</span>";
					}
					$breadcrumbs .= "				<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">\n";
					$breadcrumbs .= "					<a itemprop=\"item\" href=\"" . $val['href'] . "\">" . $home_name_str . "</a>\n";
				} else {
					$breadcrumbs .= "				<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">\n";
					$breadcrumbs .= "					<a itemprop=\"item\" href=\"" . $val['href'] . "\"><span itemprop=\"name\">" . esc_html( $val['name'] ) . "</span></a>\n";
				}
				$breadcrumbs .= "					<meta itemprop=\"position\" content=\"" . $position . "\" />\n";
				$breadcrumbs .= "				</li>\n";
			} else {
				$breadcrumbs .= "				<li>" . esc_html( $val['name'] ) . "</li>\n";
			}
		}
		$breadcrumbs = apply_filters( 'keni_breadcrumbs_li', $breadcrumbs, $tree, $home_name_str_mv );

		echo "		<nav class=\"keni-breadcrumb-list\">\n";
		echo "			<ol class=\"keni-breadcrumb-list_inner\" itemscope itemtype=\"http://schema.org/BreadcrumbList\">\n";
		echo $breadcrumbs;
		echo "			</ol>\n";
		echo "		</nav>\n";
	}
}


/* ページの上位の取得 */
if ( ! function_exists( 'get_page_parents_keni' ) ) {
	function get_page_parents_keni( $page, $reg = "y" ) {
		$page_data = get_post( $page );
		if ( is_object( $page_data ) && ( $page_data->post_parent ) > 0 ) {
			get_page_parents_keni( $page_data->post_parent );
		}
		if ( $reg == "y" ) {
			setTree( get_page_link( $page ), get_the_title( $page ) );
		}
	}
}


/* URLの配列を生成する関数 */
if ( ! function_exists( 'setTree' ) ) {
	function setTree( $href = "", $name = "" ) {

		global $tree;
		if ( ! is_array( $tree ) ) {
			$tree = array();
		}
		$position = count( $tree ) + 1;
		if ( preg_match( "/^[0-9]+$/", $position ) && $position > 0 && $name != "" ) {
			$tree[ $position ]['href'] = $href;
			$tree[ $position ]['name'] = $name;
		}

		return $tree;
	}
}


//---------------------------------------------------------------------------
//	ページの番号関連
//---------------------------------------------------------------------------
if ( ! function_exists( 'meta_page_number' ) ) {
	function meta_page_number() {
		global $wp_query;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( $paged > 1 ) {
			return "（" . $paged . __( 'page', 'keni' ) . "）";
		}
	}
}

if ( ! function_exists( 'get_page_number' ) ) {
	function get_page_number() {
		global $wp_query;
		$paged    = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$max_page = get_max_page();
		if ( $max_page > 1 ) {
			return $paged . __( 'page', 'keni' );
		}
	}
}

if ( ! function_exists( 'show_page_number' ) ) {
	function show_page_number() {
		global $wp_query;
		$paged    = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$max_page = get_max_page();

		return ( $max_page > 1 && $paged > 1 ) ? "（" . $paged . ' / ' . $max_page . __( 'page', 'keni' ) . "）" : "";
	}
}

if ( ! function_exists( 'get_max_page' ) ) {
	function get_max_page() {
		global $wp_query;

		return $wp_query->max_num_pages;
	}
}


//-----------------------------------------------------
// 管理画面 js用テンプレートディレクトリーURL取得input
//-----------------------------------------------------
function keni_admin_input_template_directory() {
	$path = get_bloginfo( 'template_directory' );
	echo '<input type="hidden" id="keni_input_template_directory" value="' . $path . '" />';
}

add_action( 'admin_footer', 'keni_admin_input_template_directory' );

//-----------------------------------------------------
// エディタにボタンを追加
//-----------------------------------------------------
function keni_add_quicktags() {
	if ( wp_script_is( 'quicktags' ) ) {

		$button = '';

		// 共通コンテンツ用ボタン表示
		$args      = array(
			'post_type'      => "keni_cc",
			'posts_per_page' => - 1,
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				// set common contents
				$flag_get_common_contents_button = get_post_meta( get_the_ID(), 'keni_common_contents_button', true );

				if ( $flag_get_common_contents_button == "1" ) {
					$button .= "QTags.addButton( 'cc_" . get_the_ID() . "','&#xf499;" . get_the_title() . "','[cc id=" . get_the_ID() . " title=\"" . get_the_title() . "\"]', '', '','" . get_the_title() . "', " . ( 300 + get_the_ID() ) . ")\n";
				}

			endwhile;
		endif;
		wp_reset_postdata();


		if ( $button != "" ) {
			echo <<< EOM
			<script type="text/javascript">
			{$button}
			</script>
EOM;
		}
	}
}

add_action( 'admin_print_footer_scripts', 'keni_add_quicktags' );

// Quicktags dashicons
function keni_admin_quicktags_style() {
	echo '<style>
		input[id*="qt_content_cc_"] {
			font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif,"dashicons";
		}
	</style>' . PHP_EOL;
}

add_action( 'admin_print_styles', 'keni_admin_quicktags_style' );


/* ビジュアルエディタ */
function keni_register_button( $buttons ) {
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'icon';
	$buttons[] = 'line';
	// $buttons[] = 'text_size';
	$buttons[] = 'text_color';
	$buttons[] = 'note';
	$buttons[] = 'column';
	$buttons[] = 'column_ns';
	$buttons[] = 'box_style';

	return $buttons;
}

add_filter( 'mce_buttons', 'keni_register_button' );

function keni_mce_plugin( $plugin_array ) {
	$plugin_array['custom_button_script'] = get_theme_file_uri( 'js/keni-editor-button.js' );

	return $plugin_array;
}

add_filter( 'mce_external_plugins', 'keni_mce_plugin' );

// tinymceのエディター設定を変更
function customize_tinymce_settings( $mceInit ) {
	// font size
	$mceInit['fontsize_formats'] = '8px=8px 10px=10px 12px=12px 14px=14px 16px=16px 20px=20px 24px=24px 28px=28px 32px=32px 36px=36px 48px=48px 60px=60px';

	if ( isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] .= ' ';
		$mceInit['content_style'] .= keni_get_customize_color_css( 'tinymce' );
	} else {
		$mceInit['content_style'] = keni_get_customize_color_css( 'tinymce' );
	}

	return $mceInit;
}

add_filter( 'tiny_mce_before_init', 'customize_tinymce_settings' );

//-----------------------------------------------------
// wordpress 関数カスタマイズ
//-----------------------------------------------------

/**
 * class Walker_Category_Checklist customize
 *
 * @since 2.5.1
 *
 * @see Walker
 * @see wp_category_checklist()
 * @see wp_terms_checklist()
 */
class Keni_Walker_Category_Checklist_Input_Name extends Walker {
	public $tree_type = 'category';
	public $db_fields = array( 'parent' => 'parent', 'id' => 'term_id' ); //TODO: decouple this

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker:start_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $category The current term object.
	 * @param int $depth Depth of the term in reference to parents. Default 0.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 * @param int $id ID of the current term.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		if ( empty( $args['taxonomy'] ) ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = $args['taxonomy'];
		}

		if ( $taxonomy == 'category' ) {
			// customize
			$name = $args['input_name'];
		} else {
			$name = 'tax_input[' . $taxonomy . ']';
		}

		$args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
		$class                = in_array( $category->term_id, $args['popular_cats'] ) ? ' class="popular-category"' : '';

		$args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

		if ( ! empty( $args['list_only'] ) ) {
			$aria_checked = 'false';
			$inner_class  = 'category';

			if ( in_array( $category->term_id, $args['selected_cats'] ) ) {
				$inner_class  .= ' selected';
				$aria_checked = 'true';
			}

			/** This filter is documented in wp-includes/category-template.php */
			$output .= "\n" . '<li' . $class . '>' .
			           '<div class="' . $inner_class . '" data-term-id=' . $category->term_id .
			           ' tabindex="0" role="checkbox" aria-checked="' . $aria_checked . '">' .
			           esc_html( apply_filters( 'the_category', $category->name, '', '' ) ) . '</div>';
		} else {
			/** This filter is documented in wp-includes/category-template.php */
			$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" .
			           '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' .
			           checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) .
			           disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
			           esc_html( apply_filters( 'the_category', $category->name, '', '' ) ) . '</label>';
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $category The current term object.
	 * @param int $depth Depth of the term in reference to parents. Default 0.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	public function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}


/**
 * wp_terms_checklist() customize
 *
 * @since 2.5.1
 *
 * @see keni_wp_terms_checklist_input_name()
 *
 * @param int $post_id Optional. Post to generate a categories checklist for. Default 0.
 *                                     $selected_cats must not be an array. Default 0.
 * @param int $descendants_and_self Optional. ID of the category to output along with its descendants.
 *                                     Default 0.
 * @param array $selected_cats Optional. List of categories to mark as checked. Default false.
 * @param array $popular_cats Optional. List of categories to receive the "popular-category" class.
 *                                     Default false.
 * @param object $walker Optional. Walker object to use to build the output.
 *                                     Default is a Walker_Category_Checklist instance.
 * @param bool $checked_ontop Optional. Whether to move checked items out of the hierarchy and to
 *                                     the top of the list. Default true.
 * @param string $input_name input name
 */
function keni_wp_terms_checklist_input_name( $post_id = 0, $args = array() ) {
	$defaults = array(
		'descendants_and_self' => 0,
		'selected_cats'        => false,
		'popular_cats'         => false,
		'walker'               => null,
		'taxonomy'             => 'category',
		'checked_ontop'        => true,
		'echo'                 => true,
		'input_name'           => 'post_category',
	);

	if ( ! empty( $args ) ) {
		foreach ( $args as $key => $value ) {
			if ( array_key_exists( $key, $defaults ) ) {
				$defaults[ $key ] = $args[ $key ];
			}
		}
	}

	/**
	 * Filters the taxonomy terms checklist arguments.
	 *
	 * @since 3.4.0
	 *
	 * @see wp_terms_checklist()
	 *
	 * @param array $args An array of arguments.
	 * @param int $post_id The post ID.
	 */
	$params = apply_filters( 'wp_terms_checklist_args', $args, $post_id );

	$r = wp_parse_args( $params, $defaults );

	if ( empty( $r['walker'] ) || ! ( $r['walker'] instanceof Walker ) ) {
		$walker = new Keni_Walker_Category_Checklist_Input_Name;
	} else {
		$walker = $r['walker'];
	}

	$taxonomy             = $r['taxonomy'];
	$descendants_and_self = (int) $r['descendants_and_self'];

	$args = array( 'taxonomy' => $taxonomy );

	$tax              = get_taxonomy( $taxonomy );
	$args['disabled'] = ! current_user_can( $tax->cap->assign_terms );

	$args['list_only'] = ! empty( $r['list_only'] );

	if ( is_array( $r['selected_cats'] ) ) {
		$args['selected_cats'] = $r['selected_cats'];
	} elseif ( $post_id ) {
		$args['selected_cats'] = wp_get_object_terms( $post_id, $taxonomy, array_merge( $args, array( 'fields' => 'ids' ) ) );
	} else {
		$args['selected_cats'] = array();
	}
	if ( is_array( $r['popular_cats'] ) ) {
		$args['popular_cats'] = $r['popular_cats'];
	} else {
		$args['popular_cats'] = get_terms( $taxonomy, array(
			'fields'       => 'ids',
			'orderby'      => 'count',
			'order'        => 'DESC',
			'number'       => 10,
			'hierarchical' => false
		) );
	}
	if ( $descendants_and_self ) {
		$categories = (array) get_terms( $taxonomy, array(
			'child_of'     => $descendants_and_self,
			'hierarchical' => 0,
			'hide_empty'   => 0
		) );
		$self       = get_term( $descendants_and_self, $taxonomy );
		array_unshift( $categories, $self );
	} else {
		$categories = (array) get_terms( $taxonomy, array( 'get' => 'all' ) );
	}

	$output = '';

	// $walkerの$argsに input_name オプションを追加
	$args = array_merge( $args, array( 'input_name' => $defaults["input_name"] ) );

	if ( $r['checked_ontop'] ) {
		// Post process $categories rather than adding an exclude to the get_terms() query to keep the query the same across all posts (for any query cache)
		$checked_categories = array();
		$keys               = array_keys( $categories );

		foreach ( $keys as $k ) {
			if ( in_array( $categories[ $k ]->term_id, $args['selected_cats'] ) ) {
				$checked_categories[] = $categories[ $k ];
				unset( $categories[ $k ] );
			}
		}


		// Put checked cats on top
		$output .= call_user_func_array( array( $walker, 'walk' ), array( $checked_categories, 0, $args ) );
	}
	// Then the rest of them
	$output .= call_user_func_array( array( $walker, 'walk' ), array( $categories, 0, $args ) );

	if ( $r['echo'] ) {
		echo $output;
	}

	return $output;
}

/**
 * html classes.
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function html_class( $class = '' ) {
	echo 'class="' . join( ' ', get_html_class( $class ) ) . '"';
}

/**
 * html classes array.
 *
 * @param string|array $class One or more classes to add to the class list.
 *
 * @return array Array of classes.
 */
function get_html_class( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	} else {
		$class = array();
	}
	$classes = array_map( 'esc_attr', $classes );
	/**
	 * Filters the list of CSS html classes for the current post or page.
	 *
	 * @param array $classes An array of html classes.
	 * @param array $class An array of additional classes added to the html.
	 */
	$classes = apply_filters( 'html_class', $classes, $class );

	return array_unique( $classes );
}

/**
 * Layout column
 * @return string   Class name.
 */
function get_keni_layout_column_class() {
	global $post;

	// layout
	$str_keni_layout_class             = '';
	$str_keni_layout                   = get_theme_mod( 'keni_layout_basic' );
	$str_keni_layout_front             = get_theme_mod( 'keni_layout_front' );
	$str_keni_layout_archives_category = get_theme_mod( 'keni_layout_archives_category' );
	$str_keni_layout_archives_tag      = get_theme_mod( 'keni_layout_archives_tag' );
	$str_keni_layout_archives_date     = get_theme_mod( 'keni_layout_archives_date' );
	$str_keni_layout_archives_author   = get_theme_mod( 'keni_layout_archives_author' );
	$str_keni_layout_archives_search   = get_theme_mod( 'keni_layout_archives_search' );
	$str_keni_layout_post              = '';
	if ( is_single() || is_page() ) {
		$str_keni_layout_post = get_post_meta( $post->ID, 'keni_layout_post', true );
	}

	$num_term_id = get_queried_object_id();
	if ( function_exists( "get_term_meta" ) && ! empty( $num_term_id ) ) {
		// wordpress 4.4.0以降
		$str_keni_layout_term = get_term_meta( $num_term_id, "keni_layout_term", true );
	} elseif ( ! empty( $num_term_id ) ) {
		$str_keni_layout_term = get_option( "keni_layout_term_" . $num_term_id );
	}

	// layout set class
	if ( ( is_front_page() || is_home() ) && $str_keni_layout_front != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_front;
	} elseif ( ( is_category() || is_tag() ) && ( ! empty( $str_keni_layout_term ) && $str_keni_layout_term != 'layout-basic' ) ) {
		$str_keni_layout_class = $str_keni_layout_term;
	} elseif ( is_category() && $str_keni_layout_archives_category != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_archives_category;
	} elseif ( is_tag() && $str_keni_layout_archives_tag != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_archives_tag;
	} elseif ( is_date() && $str_keni_layout_archives_date != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_archives_date;
	} elseif ( is_author() && $str_keni_layout_archives_author != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_archives_author;
	} elseif ( is_search() && $str_keni_layout_archives_search != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_archives_search;
	} elseif ( ( is_single() || is_page() ) && $str_keni_layout_post != 'layout-basic' ) {
		$str_keni_layout_class = $str_keni_layout_post;
	}

	if ( empty( $str_keni_layout_class ) || ! $str_keni_layout_class ) {
		$str_keni_layout_class = ( ! empty( $str_keni_layout ) ) ? $str_keni_layout : keni_customize_layout_default( "keni_layout_basic" );
	}

	return $str_keni_layout_class;

}

/**
 * Layout sidebar
 * @return string   Class name.
 */
function get_keni_layout_sidebar_class() {
	global $post;

	$str_keni_layout_class = get_keni_layout_column_class();

	// sidebar
	$str_keni_layout_sidebar_class             = '';
	$str_keni_layout_sidebar                   = get_theme_mod( 'keni_layout_sidebar' );
	$str_keni_layout_front_sidebar             = get_theme_mod( 'keni_layout_front_sidebar' );
	$str_keni_layout_archives_category_sidebar = get_theme_mod( 'keni_layout_archives_category_sidebar' );
	$str_keni_layout_archives_tag_sidebar      = get_theme_mod( 'keni_layout_archives_tag_sidebar' );
	$str_keni_layout_archives_date_sidebar     = get_theme_mod( 'keni_layout_archives_date_sidebar' );
	$str_keni_layout_archives_author_sidebar   = get_theme_mod( 'keni_layout_archives_author_sidebar' );
	$str_keni_layout_archives_search_sidebar   = get_theme_mod( 'keni_layout_archives_search_sidebar' );
	$str_keni_layout_post_sidebar              = '';
	if ( is_single() || is_page() ) {
		$str_keni_layout_post_sidebar = get_post_meta( $post->ID, 'keni_layout_post_sidebar', true );
	}

	// sidebar set class
	if ( $str_keni_layout_class == 'col1' ) {
	    // トップページ & (トップページレイアウトが「デフォルト」or 空) & レイアウトが「表示する」ではないとき
		if ( ( is_front_page() || is_home() ) && ( $str_keni_layout_front_sidebar === "layout-sidebar-basic" || empty( $str_keni_layout_front_sidebar ) ) && $str_keni_layout_sidebar !== 'layout-sidebar-show' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_sidebar : '';
		} elseif ( ( is_front_page() || is_home() ) && $str_keni_layout_front_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_front_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_front_sidebar : '';
		} elseif ( is_category() && $str_keni_layout_archives_category_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_archives_category_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_archives_category_sidebar : '';
		} elseif ( is_tag() && $str_keni_layout_archives_tag_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_archives_tag_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_archives_tag_sidebar : '';
		} elseif ( is_date() && $str_keni_layout_archives_date_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_archives_date_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_archives_date_sidebar : '';
		} elseif ( is_author() && $str_keni_layout_archives_author_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_archives_author_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_archives_author_sidebar : '';
		} elseif ( is_search() && $str_keni_layout_archives_search_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_archives_search_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_archives_search_sidebar : '';
		} elseif ( ( is_single() || is_page() && ! is_front_page() ) && $str_keni_layout_post_sidebar != 'layout-sidebar-basic' ) {
			$str_keni_layout_sidebar_class = ( $str_keni_layout_post_sidebar === 'layout-sidebar-hide' ) ? $str_keni_layout_post_sidebar : '';
		} elseif ( $str_keni_layout_sidebar === 'layout-sidebar-hide' ) {
			$str_keni_layout_sidebar_class = $str_keni_layout_sidebar;
		}
	}
	return $str_keni_layout_sidebar_class;

}

/**
 * Layout Footer01
 * @return string   Class name.
 */
function get_keni_layout_footer01_class() {
	global $post;

	$str_keni_layout_front_footer01_class = '';
	$str_keni_layout_front_footer01       = get_theme_mod( 'keni_layout_front_footer01' );
	$str_keni_layout_post_footer01        = '';
	if ( is_singular() ) {
		$str_keni_layout_post_footer01 = get_post_meta( $post->ID, 'keni_layout_post_footer01', true );
	}
	$str_keni_layout_post_footer01 = ( ! empty($str_keni_layout_post_footer01) )? $str_keni_layout_post_footer01 : 'layout-footer-show' ;

	if ( is_front_page() || is_home() ) {
		$str_keni_layout_front_footer01_class = $str_keni_layout_front_footer01;
	} elseif ( ( is_single() || is_page() ) && ! is_front_page() ) {
		$str_keni_layout_front_footer01_class = $str_keni_layout_post_footer01;
	}

	return $str_keni_layout_front_footer01_class;
}

/**
 * Layout Footer02
 * @return string   Class name.
 */
function get_keni_layout_footer02_class() {
	global $post;

	$str_keni_layout_front_footer02_class = '';
	$str_keni_layout_front_footer02       = get_theme_mod( 'keni_layout_front_footer02' );
	$str_keni_layout_post_footer02        = '';
	if ( is_singular() ) {
		$str_keni_layout_post_footer02 = get_post_meta( $post->ID, 'keni_layout_post_footer02', true );
	}
	$str_keni_layout_post_footer02 = ( ! empty($str_keni_layout_post_footer02) )? $str_keni_layout_post_footer02 : 'layout-footer-show' ;
	if ( is_front_page() || is_home() ) {
		$str_keni_layout_front_footer02_class = $str_keni_layout_front_footer02;
	} elseif ( ( is_single() || is_page() ) && ! is_front_page() ) {
		$str_keni_layout_front_footer02_class = $str_keni_layout_post_footer02;
	}

	return $str_keni_layout_front_footer02_class;
}

/**
 * Layout Footer03
 * @return string   Class name.
 */
function get_keni_layout_footer03_class() {
	global $post;

	$str_keni_layout_front_footer03_class = '';
	$str_keni_layout_front_footer03       = get_theme_mod( 'keni_layout_front_footer03' );
	$str_keni_layout_post_footer03        = '';
	if ( is_singular() ) {
		$str_keni_layout_post_footer03 = get_post_meta( $post->ID, 'keni_layout_post_footer03', true );
	}
	$str_keni_layout_post_footer03 = ( ! empty($str_keni_layout_post_footer03) )? $str_keni_layout_post_footer03 : 'layout-footer-show' ;
	if ( is_front_page() || is_home() ) {
		$str_keni_layout_front_footer03_class = $str_keni_layout_front_footer03;
	} elseif ( ( is_single() || is_page() ) && ! is_front_page() ) {
		$str_keni_layout_front_footer03_class = $str_keni_layout_post_footer03;
	}

	return $str_keni_layout_front_footer03_class;
}

/**
 * Layout Front navigation
 * @return string   Class name.
 */
function get_keni_layout_front_navigation_class() {
	global $post;

	$str_keni_layout_front_navigation_class = '';
	$str_keni_layout_front_navigation       = get_theme_mod( 'keni_layout_front_navigation' );
	$str_keni_layout_post_navigation        = '';
	if ( is_single() || is_page() ) {
		$str_keni_layout_post_navigation = get_post_meta( $post->ID, 'keni_layout_post_navigation', true );
	}

	if ( ( is_front_page() || is_home() ) && $str_keni_layout_front_navigation === 'layout-navigation-hide' ) {
		$str_keni_layout_front_navigation_class = $str_keni_layout_front_navigation;
	} elseif ( ( is_single() || is_page() && ! is_front_page() ) && $str_keni_layout_post_navigation === 'layout-navigation-hide' ) {
		$str_keni_layout_front_navigation_class = $str_keni_layout_post_navigation;
	}

	return $str_keni_layout_front_navigation_class;
}

/**
 * Layout Front breadcrumb
 * @return string   Class name.
 */
function get_keni_layout_breadcrumb_class() {
	global $post;

	$str_keni_layout_front_breadcrumb_class = '';
	$str_keni_layout_front_breadcrumb       = get_theme_mod( 'keni_layout_front_breadcrumb' );
	$str_keni_layout_post_breadcrumb        = '';
	if ( is_single() || is_page() ) {
		$str_keni_layout_post_breadcrumb = get_post_meta( $post->ID, 'keni_layout_post_breadcrumb', true );
	}

	if ( ( is_front_page() || is_home() ) && $str_keni_layout_front_breadcrumb === 'layout-breadcrumb-hide' ) {
		$str_keni_layout_front_breadcrumb_class = $str_keni_layout_front_breadcrumb;
	} elseif ( ( is_single() || is_page() && ! is_front_page() ) && $str_keni_layout_post_breadcrumb === 'layout-breadcrumb-hide' ) {
		$str_keni_layout_front_breadcrumb_class = $str_keni_layout_post_breadcrumb;
	}

	return $str_keni_layout_front_breadcrumb_class;
}

/**
 * Layout header
 * @return string   Class name.
 */
function get_keni_layout_header_class() {

	$str_keni_layout_header_class = get_theme_mod( 'keni_layout_header' );
	if ( empty( $str_keni_layout_header_class ) ) {
		$str_keni_layout_header_class = keni_customize_layout_default( 'keni_layout_header' );
	}

	return $str_keni_layout_header_class;

}

/**
 * Layout header
 * @return string   Class name.
 */
function get_keni_layout_post_list_class() {

	$str_keni_layout_post_list_class = get_theme_mod( 'keni_layout_post_list' );
	if ( empty( $str_keni_layout_post_list_class ) ) {
		$str_keni_layout_post_list_class = keni_customize_layout_default( 'keni_layout_post_list' );
	}

	return $str_keni_layout_post_list_class;

}

/**
 * Layout header template name
 * @return string   Template name.
 */
function get_keni_layout_header_name() {

	$str_keni_layout_header_class = get_keni_layout_header_class();

	$str_layout_header_name = ltrim( $str_keni_layout_header_class, 'keni-' );

	return $str_layout_header_name;

}

/**
 * Layout Sidebar
 * @return bool
 */
function is_keni_layout_sidebar() {

	if ( get_keni_layout_sidebar_class() === 'layout-sidebar-hide' ) {
		return false;
	}

	return true;

}

/**
 * Layout Footer01
 * @return bool
 */
function is_keni_layout_footer01() {

	if ( get_keni_layout_footer01_class() === 'layout-footer-hide' ) {
		return false;
	}

	return true;

}

/**
 * Layout Footer02
 * @return bool
 */
function is_keni_layout_footer02() {

	if ( get_keni_layout_footer02_class() === 'layout-footer-hide' ) {
		return false;
	}

	return true;

}

/**
 * Layout Footer03
 * @return bool
 */
function is_keni_layout_footer03() {

	if ( get_keni_layout_footer03_class() === 'layout-footer-hide' ) {
		return false;
	}

	return true;

}

/**
 * Layout Front navigation
 * @return bool
 */
function is_keni_layout_front_navigation() {

	if ( get_keni_layout_front_navigation_class() === 'layout-navigation-hide' ) {
		return false;
	}

	return true;

}

/**
 * Layout Front breadcrumb
 * @return bool
 */
function is_keni_layout_breadcrumb() {

	if ( get_keni_layout_breadcrumb_class() === 'layout-breadcrumb-hide' ) {
		return false;
	}

	return true;

}

/**
 * Page title display
 * @return bool
 */
function is_keni_page_title() {
	global $post;

	if ( is_front_page() ) {
		if ( get_option( 'keni_disp_front_page_title' ) === 'show' ) {
			return true;
		} else {
			return false;
		}
	}

	// get setting
	$str_get_page_title_disp_page = get_post_meta( $post->ID, 'keni_page_title_disp_page', true );

	if ( $str_get_page_title_disp_page == '1' ) {
		return false;
	}

	return true;
}

/**
 * snsボタンの表示と非表示を判定する
 *
 * @param  boolean $is_for_archives 各投稿に対するSNSボタンの表示フラグ（デフォルトはfalse）
 *
 * @return boolean                  [description]
 */
function is_keni_disp_sns() {
	global $post;

	if ( is_front_page() ) {
		if ( get_option( 'keni_disabled_disp_sns_top' ) == '1' ) {
			return false;
		}
	} elseif ( is_home() ) {
		if ( get_option( 'keni_disabled_disp_sns_home' ) == '1' ) {
			return false;
		}
	} elseif ( is_category() || is_tag() ) {
		if ( get_option( 'keni_disabled_disp_sns_category_tag' ) == '1' ) {
			return false;
		}
	} elseif ( is_archive() ) {
		if ( get_option( 'keni_disabled_disp_sns_archive' ) == '1' ) {
			return false;
		}
	} elseif ( is_search() ) {
		if ( get_option( 'keni_disabled_disp_sns_search' ) == '1' ) {
			return false;
		}
	} elseif ( is_single() ) {
		if ( get_option( 'keni_disabled_disp_sns_post' ) == '1' ) {
			return false;
		}
	} elseif ( is_page() ) {
		if ( get_option( 'keni_disabled_disp_sns_page' ) == '1' ) {
			return false;
		}
	}

	return true;
}

/**
 * 個別ページの上側SNSボタンの表示処理
 * @return boolean [description]
 */
function is_keni_disp_sns_singler_up() {

	if ( is_single() ) {
		switch ( get_option( 'keni_disabled_disp_sns_post_position' ) ) {
			case 'down':
				return false;
				break;

			default:
				return true;
				break;
		}

	} elseif ( is_page() ) {
		switch ( get_option( 'keni_disabled_disp_sns_page_position' ) ) {
			case 'down':
				return false;
				break;

			default:
				return true;
				break;
		}
	}

	return true;
}

/**
 * 個別ページの下側SNSボタンの表示処理
 * @return boolean [description]
 */
function is_keni_disp_sns_singler_down() {

	if ( is_single() ) {
		switch ( get_option( 'keni_disabled_disp_sns_post_position' ) ) {
			case 'up':
				return false;
				break;

			default:
				return true;
				break;
		}

	} elseif ( is_page() ) {
		switch ( get_option( 'keni_disabled_disp_sns_page_position' ) ) {
			case 'up':
				return false;
				break;

			default:
				return true;
				break;
		}
	}

	return true;
}


/**
 * 投稿一覧における各投稿のSNSボタン表示設定を取得する
 * @return boolean [description]
 */
function is_keni_disp_sns_posts_list() {
	if ( get_option( 'keni_disabled_disp_sns_posts_list' ) == '1' ) {
		return false;
	}

	return true;
}


/**
 * Get avatar
 * @return string  Image tag
 */
function keni_get_avatar() {
	$str = '';

	$author_id  = get_the_author_meta( 'ID' );
	$obj_author = get_userdata( $author_id );

	$str_get_profile_thumb = get_user_meta( $author_id, 'keni_profile_thumb', true );
	if ( ! empty( $str_get_profile_thumb ) ) {
		$arr_image = wp_get_attachment_image_src( $str_get_profile_thumb, 'thumbnail' );
		$str       = '<img alt="' . $obj_author->display_name . '" src="' . $arr_image[0] . '" class="avatar" height="150" width="150">';
	} else {
		$str = get_avatar( $author_id, 300, 'mm', $obj_author->display_name );
	}

	return $str;
}

if ( ! function_exists( 'get_installed_year' ) ) {
	/**
	 * インストール年を取得
     * @since Ver.7.1
	 * @return $year_string
	 */
	function get_installed_year() {
		global $wpdb;
		$year_string = "";

		$result = $wpdb->get_var( "select post_date from {$wpdb->posts} ORDER BY ID ASC LIMIT 1" );
		if ( isset( $result ) ) {
			$year_string = date( 'Y', strtotime( $result ) );
		}

		return $year_string;
	}
}