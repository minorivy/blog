<?php
//-----------------------------------------------------
// 共通コンテンツ
//-----------------------------------------------------
function get_keni_common_contents( $atts, $comm_post_id ) {
	$id = null;
	extract( shortcode_atts( array(
		'id' => $comm_post_id,
	), $atts ) );
	$content = get_post( $id, "ARRAY_A" );

	if ( isset( $content['post_content'] ) && $content['post_status'] == "publish" ) {
		return do_shortcode( keni_richtext_formats( $content['post_content'] ) );
	} else {
		return "";
	}

}

add_shortcode( 'cc', 'get_keni_common_contents' );

/**
 * 共通コンテンツ・フッタのリッチテキストを本文扱いにならないようにする
 *
 * @param  string $content
 *
 * @return string
 */
function keni_richtext_formats( $content ) {
	$res      = '';
	$pattern  = '{(\[raw\].*?\[/raw\])}is';
	$contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces   = preg_split( $pattern, $content, - 1, PREG_SPLIT_DELIM_CAPTURE );

	foreach ( $pieces as $piece ) {
		$res .= ( preg_match( $contents, $piece, $matches ) ) ? $matches[1] : wptexturize( wpautop( $piece ) );
	}

	return $res;
}

//-----------------------------------------------------
// アイコン
//-----------------------------------------------------
function get_keni_icon_shortcode( $atts, $content = null ) {

	return '<i class="icon_' . $atts[0] . '"></i>';

}

add_shortcode( 'icon', 'get_keni_icon_shortcode' );


//-----------------------------------------------------
// 文字色
//-----------------------------------------------------
/**
 *
 * 肯定 = positive
 * 否定・禁止 = ban
 * シンプルな強調 = simple
 * 用語の解説・例示 = example
 * その他の色 = other
 * マーカー表示 = marker
 *
 */
function get_keni_text_shortcode( $atts, $content = null ) {
	$type = null;
	$color = null;
	extract( shortcode_atts( array(
		'type'  => '',
		'color' => ''
	), $atts ) );

	$str_html  = '';
	$str_class = '';

	if ( ! empty( $type ) ) {

		switch ( $type ) {

			// 肯定
			case 'positive':

				if ( $color == 2 || $color == 'aqua' ) {
					$str_class = 'aqua';
				} else {
					$str_class = 'navy';
				}

				break;

			// 否定・禁止
			case 'ban':

				$str_class = 'red';

				break;

			// シンプルな強調
			case 'simple':

				if ( $color == 2 || $color == 'pink' ) {
					$str_class = 'pink';
				} else if ( $color == 3 || $color == 'purple' ) {
					$str_class = 'purple';
				} else {
					$str_class = 'orange';
				}

				break;

			// 用語の解説・例示
			case 'example':

				$str_class = 'green';

				break;

			// その他の色
			case 'other':

				if ( $color == 2 || $color == 'yellow' ) {
					$str_class = 'yellow';
				} else if ( $color == 3 || $color == 'olive' ) {
					$str_class = 'olive';
				} else if ( $color == 4 || $color == 'lime' ) {
					$str_class = 'lime';
				} else if ( $color == 5 || $color == 'black' ) {
					$str_class = 'black';
				} else if ( $color == 6 || $color == 'gray' ) {
					$str_class = 'gray';
				} else if ( $color == 7 || $color == 'white' ) {
					$str_class = 'white';
				} else if ( $color == 8 || $color == 'brown' ) {
					$str_class = 'brown';
				} else {
					$str_class = 'blue';
				}

				break;

			// マーカー表示
			case 'marker':

				if ( $color == 3 || $color == 'orange' || $color == 'line-orange' ) {
					$str_class = 'line-orange';
				} else if ( $color == 4 || $color == 'pink' || $color == 'line-pink' ) {
					$str_class = 'line-pink';
				} else if ( $color == 5 || $color == 'blue' || $color == 'line-blue' ) {
					$str_class = 'line-blue';
				} else if ( $color == 6 || $color == 'lime' || $color == 'line-lime' ) {
					$str_class = 'line-lime';
				} else if ( $color == 7 || $color == 'gray' || $color == 'line-gray' ) {
					$str_class = 'line-gray';
				} else {
					$str_class = 'line-yellow';
				}

				break;

		}
	} else if ( ! empty( $color ) ) {
		if ( ctype_alpha( $color ) ) {
			$str_class = $color;
		}
	}

	if ( ! empty( $str_class ) ) {
		$str_html = '<span class="' . $str_class . '">' . $content . '</span>';
	}

	return $str_html;
}

add_shortcode( 'text', 'get_keni_text_shortcode' );


//-----------------------------------------------------
// 注意書き
//-----------------------------------------------------
function get_keni_note_shortcode( $atts, $content = null ) {

	return '<span class="note">' . $content . '</span>';

}

add_shortcode( 'note', 'get_keni_note_shortcode' );


//-----------------------------------------------------
// 画像カラム
//-----------------------------------------------------
function get_keni_col_shortcode( $atts, $content = null ) {

	return '<div class="col' . $atts[0] . '-wrap">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'col', 'get_keni_col_shortcode' );

function get_keni_col_inner_shortcode( $atts, $content = null ) {

	return '<div class="col">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'col_inner', 'get_keni_col_inner_shortcode' );

function get_keni_col_ns_shortcode( $atts, $content = null ) {

	return '<div class="col_ns">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'col_ns', 'get_keni_col_ns_shortcode' );

//-----------------------------------------------------
// box
//-----------------------------------------------------
function get_keni_box_shortcode( $atts, $content = null ) {
	$class = null;
	$title = null;
	extract( shortcode_atts( array(
		'class' => '',
		'title' => ''
	), $atts ) );

	$html_title = '';
	if ( ! empty( $title ) ) {
		$html_title = '<div class="box_style_title"><span class="box_style_title_inner">' . $title . '</span></div>';
	}

	return '<div class="box_style ' . $class . '"><div class="box_inner">' . $html_title . '<p>' . do_shortcode( $content ) . '</p></div></div>';

}

add_shortcode( 'box', 'get_keni_box_shortcode' );

/*
 * リンクカード
 */
function keni_shortcode_articlelink( $atts ) {
	$url = null;
	$src = null;
	$title = null;
	$description = null;
	$target = null;
	extract( shortcode_atts( array(
		'url'         => '',
		'src'         => '',
		'title'       => '',
		'description' => '',
		'target'      => ''
	), $atts ) );

	require_once( 'OpenGraph.php' );

	locate_template( 'keni/module/keni-util/keni-util.php', true );

	//
	$graph = keni_linkcard_exists( $atts['url'] );
	if ( ! is_null( $graph ) ) {
		$graph_flg = false;
	} else {
		$graph_array                = array();
		$graph_array['url']         = "";
		$graph_array['title']       = "";
		$graph_array['description'] = "";
		$graph_array['image']       = "";
		$graph                      = (Object) $graph_array;
		$graph_flg                  = true;
	}
	if ( $graph_flg === true ) {
		if ( function_exists( 'punycode_encode' ) ) {
			//Punycodeへのエンコード
			$encoded_url = punycode_encode( $url );
			$graph       = OpenGraph::fetch( $encoded_url );
		} else {
			$graph = OpenGraph::fetch( $url );
		}
	} else {
		$src = @$graph->image;
	}

	$og_url = $graph->url;
	if ( ! isset( $og_url ) || empty( $og_url ) ) {
		$og_url = $url;
	}
	$og_url_disp = mb_strimwidth( $og_url, 0, 80, "..." );

	if ( empty( $title ) ) {
		$og_title = $graph->title;
	} else {
		$og_title = $title;
	}

	$og_image = "";
	if ( empty( $src ) ) {
		if ( preg_match( "/^https:/", $graph->image ) ) {
			$og_image = $graph->image;
		}
	} else {
		$og_image = $src;
	}

	if ( empty( $description ) ) {
		$og_desc = $graph->description;
	} else {
		$og_desc = $description;
	}

	$og_target = "";
	$openner = "";
	if ( ! empty( $target ) ) {
		$og_target = trim( esc_attr( $target ) );
		if ( $target == "_blank" ) {
			$openner = ' rel="noopener"';
		}
	}

	$link = '<div class="keni-link-card_wrap"><blockquote class="keni-link-card">';
	if ( ! empty( $og_image ) ) {
		$link .= '<div class="keni-link-card_thumb"><a href="' . $og_url . '"' . ( $og_target == '' ? "" : ' target="' . $og_target . '"' . $openner ) . '><img src="' . $og_image . '" width="150" alt=""></a></div>';
	}
	$link .= '<div class="keni-link-card_title"><a href="' . $og_url . '"' . ( $og_target == '' ? "" : ' target="' . $og_target . '"'.$openner ) . '>' . $og_title . '</a></div>';
	$link .= '<div class="keni-link-card_url"><cite><a href="' . $og_url . '"' . ( $og_target == '' ? "" : ' target="' . $og_target . '"'.$openner ) . '>' . $og_url_disp . '</a></cite></div>';
	$link .= '<div class="keni-link-card_desc">' . $og_desc . '</div></blockquote></div>';

	if ( $graph_flg === true ) {
		$post        = array(
			'post_title'    => $og_title, // 投稿のタイトル。
			'post_status'   => 'publish',
			'post_type'     => 'keni_linkcard', // 投稿タイプ。デフォルトは 'post'。
			'post_date'     => date( "Y-m-d H:i:s" ), // 投稿の作成日時。
			'post_date_gmt' => date( "Y-m-d H:i:s" ), // 投稿の作成日時（GMT）。
		);
		$wp_error    = false;
		$postmeta_id = wp_insert_post( $post, $wp_error );
		if ( $postmeta_id > 0 ) {
			update_post_meta( $postmeta_id, 'keni_lc_url', $og_url );
			update_post_meta( $postmeta_id, 'keni_lc_title', $og_title );
			update_post_meta( $postmeta_id, 'keni_lc_description', $og_desc );
			update_post_meta( $postmeta_id, 'keni_lc_image', $og_image );
			update_post_meta( $postmeta_id, 'url', $url );
		}
	}

	return $link;
}

add_shortcode( 'keni-linkcard', 'keni_shortcode_articlelink' );

/**
 * リンクカード存在チェック
 *
 * @param $graph_flg
 * @param $url
 *
 * @return bool
 */
function keni_linkcard_exists( $url ) {
	
	// CFからリンク検索
	$args = Array(
		'post_type'      => 'keni_linkcard',
		'posts_per_page' => 1,
		'meta_key'       => 'url',
		'meta_value'     => $url,
		'exact'          => true,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC'
	);

	$graph      = null;
	$graph_post = new WP_Query( $args );
	if ( $graph_post->have_posts() ):
		while ( $graph_post->have_posts() ): $graph_post->the_post();
			global $id;
			$url                        = get_post_meta( $id, 'keni_lc_url', true );
			$title                      = get_post_meta( $id, 'keni_lc_title', true );
			$description                = get_post_meta( $id, 'keni_lc_description', true );
			$image                      = get_post_meta( $id, 'keni_lc_image', true );
			$graph_array                = array();
			$graph_array['url']         = $url;
			$graph_array['title']       = $title;
			$graph_array['description'] = $description;
			$graph_array['image']       = $image;
			// $graph データ整備
			$graph = (Object) $graph_array;
		endwhile;
	endif;
	wp_reset_postdata();

	return $graph;
}

/**
 * リンクカードにカスタムフィールドボックス追加
 */
function add_linkcard_fields() {
	//add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
	//第4引数のpostをpageに変更すれば固定ページにオリジナルカスタムフィールドが表示されます(custom_post_typeのslugを指定することも可能)。
	//第5引数はnormalの他にsideとadvancedがあります。
	add_meta_box( 'keni_linkcard_setting', '賢威リンクカード情報', 'insert_linkcard_fields', 'keni_linkcard', 'normal' );
}

add_action( 'admin_menu', 'add_linkcard_fields' );

/**
 * リンクカードカスタムフィールド入力ボックス表示
 */
function insert_linkcard_fields() {
	global $post;

	//下記に管理画面に表示される入力エリアを作ります。「get_post_meta()」は現在入力されている値を表示するための記述です。
	$url = get_post_meta( $post->ID, 'url', true );
	$lc_url = get_post_meta( $post->ID, 'keni_lc_url', true );
	$lc_title = get_post_meta( $post->ID, 'keni_lc_title', true );
	$lc_desc = get_post_meta( $post->ID, 'keni_lc_description', true );
	$lc_image = get_post_meta( $post->ID, 'keni_lc_image', true );
	echo <<<EOF
	<p class="post-attributes-label-wrapper"><label class="post-attributes-label">対象URL ※keni-linkcard ショートコードで指定する url </label></p>
	<input type="text" name="url" value="{$url}" class="regular-text" />
	<p class="post-attributes-label-wrapper"><label class="post-attributes-label">OGP URL</label></p>
	<input type="text" name="keni_lc_url" value="{$lc_url}" class="regular-text" />
	<p class="post-attributes-label-wrapper"><label class="post-attributes-label">OGP タイトル</label></p>
	<input type="text" name="keni_lc_title" value="{$lc_title}" class="regular-text" />
	<p class="post-attributes-label-wrapper"><label class="post-attributes-label">OGP description</label></p>
	<input type="text" name="keni_lc_description" value="{$lc_desc}" class="regular-text" />
	<p class="post-attributes-label-wrapper"><label class="post-attributes-label">OGP イメージ URL</label></p>
	<input type="text" name="keni_lc_image" value="{$lc_image}" class="regular-text" />
EOF;
}


/**
 * リンクカードカスタムフィールドの値を保存
 */
function save_linkcard_fields( $post_id ) {
	if ( ! empty( $_POST['url'] ) ) {
		update_post_meta( $post_id, 'url', $_POST['url'] );
	} else {
		delete_post_meta( $post_id, 'url' );
	}
	if ( ! empty( $_POST['keni_lc_url'] ) ) {
		update_post_meta( $post_id, 'keni_lc_url', $_POST['keni_lc_url'] );
	} else {
		delete_post_meta( $post_id, 'keni_lc_url' );
	}
	if ( ! empty( $_POST['keni_lc_title'] ) ) { //題名が入力されている場合
		update_post_meta( $post_id, 'keni_lc_title', $_POST['keni_lc_title'] ); //値を保存
	} else { //題名未入力の場合
		delete_post_meta( $post_id, 'keni_lc_title' ); //値を削除
	}

	if ( ! empty( $_POST['keni_lc_description'] ) ) {
		update_post_meta( $post_id, 'keni_lc_description', $_POST['keni_lc_description'] );
	} else {
		delete_post_meta( $post_id, 'keni_lc_description' );
	}

	if ( ! empty( $_POST['keni_lc_image'] ) ) {
		update_post_meta( $post_id, 'keni_lc_image', $_POST['keni_lc_image'] );
	} else {
		delete_post_meta( $post_id, 'keni_lc_image' );
	}
}

add_action( 'save_post', 'save_linkcard_fields' );

//---------------------------------------------------------------------------
//	新着情報の表示
//---------------------------------------------------------------------------
if ( ! function_exists( 'newposts_keni_schotcode' ) ) {
	function newposts_keni_schotcode( $atts ) {

		$target    = null;
		$rows      = null;
		$excerpt   = null;
		$show_date = null;
		$catid     = null;
		$show_cat  = null;

		extract( shortcode_atts( array( 'target'    => "new",
		                                'rows'      => 5,
		                                'excerpt'   => 1,
		                                'show_date' => "default",
		                                'catid'     => 0,
		                                'show_cat'  => "true"
		), $atts ) );
		$news_data = newposts_keni( $target, $rows, $excerpt, $show_date, $catid, $show_cat );
		if ( ! empty( $news_data ) ) {
			return do_shortcode( $news_data );
		}

		return "";
	}
}
add_shortcode( 'newpost', 'newposts_keni_schotcode' );

//---------------------------------------------------------------------------
//	記事一覧の表示
//---------------------------------------------------------------------------
if ( ! function_exists( 'post_list_keni_shortcode' ) ) {
	function post_list_keni_shortcode( $atts ) {

		$target    = null;
		$rows      = null;
		$excerpt   = null;
		$show_date = null;
		$kind      = null;
		$value     = null;
		$show_tag  = null;
		$title     = null;
		$ex_cat    = null;

		extract( shortcode_atts( array( 'target'    => "new",
		                                'rows'      => 5,
		                                'excerpt'   => 1,
		                                'show_date' => "default",
		                                'kind'      => "category",
		                                'value'     => 0,
		                                'show_tag'  => "true",
		                                'title'     => "",
										'ex_cat'    => "",
		), $atts ) );
		$posts_data = posts_list_keni( $target, $rows, $excerpt, $show_date, $kind, $value, $show_tag, $title, $ex_cat );
		if ( ! empty( $posts_data ) ) {
			return do_shortcode( $posts_data );
		}

		return "";
	}
}
add_shortcode( 'postlist', 'post_list_keni_shortcode' );


//---------------------------------------------------------------------------
//	「この投稿を先頭に固定表示」になっている投稿のリストを表示
//---------------------------------------------------------------------------
if ( ! function_exists( 'sticky_keni_schotcode' ) ) {
	/**
	 * @param $atts
	 *
	 * @return string
	 */
	function sticky_keni_schotcode( $atts ) {

		$target        = null;
		$rows          = null;
		$social_counts = null;
		$excerpt       = null;
		$show_date     = null;
		$catid         = null;

		extract( shortcode_atts( array( 'target'        => "sticky",
		                                'rows'          => 3,
		                                'social_counts' => 1,
		                                'excerpt'       => 0,
		                                'show_date'     => "default",
		                                "catid"         => 0
		), $atts ) );
		$sticky_data = newposts_keni( $target, $rows, $excerpt, $show_date, $catid );    // $social_counts 削除
		if ( ! empty( $sticky_data ) ) {
			return do_shortcode( $sticky_data );
		}

		return "";
	}
}
add_shortcode( 'sticky', 'sticky_keni_schotcode' );


//---------------------------------------------------------------------------
//	ワイド表示のエリア表示
//---------------------------------------------------------------------------
if ( ! function_exists( 'wide_area' ) ) {
	function wide_area( $atts, $content = null ) {

		$content = preg_replace( "/^<\/p>\n/", "", $content );
		$content = preg_replace( "/<p>$/us", "", $content );
		$content = preg_replace( "/<br \/>\n$/us", "", $content );

		$class = ( isset( $atts['class'] ) ) ? "section-in " . $atts['class'] : "section-in";

		$other_param = "";

		if ( is_array( $atts ) && count( $atts ) > 0 ) {
			foreach ( $atts as $key => $val ) {
				if ( $key != "class" ) {
					$other_param = ' ' . $key . '="' . $val . '"';
				}
			}
		}

		return do_shortcode( "<div class=\"section-wrap wide\">\n<div class=\"" . $class . "\"" . $other_param . ">\n" . $content . "\n</div>\n</div>\n" );
	}
}
add_shortcode( 'wide', 'wide_area' );


//---------------------------------------------------------------------------
//	ノーマル表示のエリア表示
//---------------------------------------------------------------------------
if ( ! function_exists( 'normal_area' ) ) {
	function normal_area( $atts, $content = null ) {

		$content = preg_replace( "/^<\/p>\n/", "", $content );
		$content = preg_replace( "/<p>$/us", "", $content );
		$content = preg_replace( "/<br \/>\n$/us", "", $content );

		$class = ( isset( $atts['class'] ) ) ? "section-in " . $atts['class'] : "section-in";

		$other_param = "";
		if ( is_array( $atts ) && count( $atts ) > 0 ) {
			foreach ( $atts as $key => $val ) {
				if ( $key != "class" ) {
					$other_param = ' ' . $key . '="' . $val . '"';
				}
			}
		}

		return do_shortcode( "<div class=\"section-wrap\">\n<div class=\"" . $class . "\"" . $other_param . ">\n" . $content . "\n</div>\n</div>\n" );
	}
}
add_shortcode( 'normal', 'normal_area' );

//---------------------------------------------------------------------------
//	<br />が出力されないように、そこに書かれた内容をそのまま出力する
//---------------------------------------------------------------------------
if ( ! function_exists( 'script_direct' ) ) {
	function script_direct( $atts, $content = null ) {
		return do_shortcode( preg_replace( '/<br[[:space:]]*\/?[[:space:]]*>/i', "\n", $content ) );
	}
}
add_shortcode( 'script', 'script_direct' );

//-----------------------------------------------------
// 改行スクリプト
//-----------------------------------------------------
function get_keni_br_shortcode( $atts, $content = null ) {
	$num = null;
	extract( shortcode_atts( array( 'num' => '5' ), $atts ) );
	$out = "";
	for ( $i = 0; $i < $num; $i ++ ) {
		$out .= "<br>";
	}

	return do_shortcode( $out );
}

add_shortcode( 'br', 'get_keni_br_shortcode' );
