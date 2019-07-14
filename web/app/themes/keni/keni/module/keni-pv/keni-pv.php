<?php
//---------------------------------------------------------------------------
//	ページのPV数を表示するウィジェット
//---------------------------------------------------------------------------

$keni_pv = new Keni_PV_Widget();

/**
 *    PVランキングを集計するテーブルから、1ヶ月前以前のデータを削除する
 */
add_action( 'pv_data_delete_cron', array( $keni_pv, 'pv_one_month_delete' ) );

// cron登録処理
if ( ! wp_next_scheduled( 'pv_data_delete_cron' ) ) {
	wp_schedule_event( time(), 'daily', 'pv_data_delete_cron' );
}

add_action( 'after_switch_theme', array( $keni_pv, 'createPVData' ) );

add_action( 'widgets_init', function () {
	register_widget( 'Keni_PV_Widget' );
} );

add_action( 'get_header', 'keni_set_pv_cookie' );

add_action( 'save_post', array( &$keni_pv, "save_pv_disable" ) );


if ( ! function_exists( 'keni_set_pv_cookie' ) ) {
	/**
	 * ページの閲覧をしたかどうかを判断するcookieをセットする
	 */
	function keni_set_pv_cookie() {
		if ( is_singular() ) {
			$id = "pv" . get_the_ID();
			if ( ! isset( $_COOKIE[ $id ] ) ) {
				keniCountUpView();
				setcookie( $id, time(), 0, "/" );
			}
		}
	}
}

/**
 * ページのPV数をカウントする
 */
function keniCountUpView() {
	global $wpdb;
	$post_id = get_the_ID();
	$meta_id = $wpdb->get_var( "SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id={$post_id} AND meta_key = 'pvc_views'" );
	if ( is_numeric( $meta_id ) && $meta_id > 0 ) {
		$wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_value=meta_value+1 WHERE meta_id={$meta_id}" );
	} else {
		$wpdb->query( "INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES ( '{$post_id}', 'pvc_views', 1)" );
	}

	// 時間毎のPV数を取得する為のカウントをする
	$wpdb->query( "INSERT INTO " . $wpdb->prefix . "keni_pv (pv_dates, post_id, pv_count) VALUES ('" . date( "YmdH" ) . "','{$post_id}','1') ON DUPLICATE KEY UPDATE pv_count=pv_count+1" );

	$wpdb->flush();
}

/**
 * ページのPV数を表示する
 */
function keniViewPV() {
	echo keniGetViewPV( get_the_ID() );
}

/**
 * @param string $id
 *
 * @return mixed
 */
function keniGetViewPV( $id = "" ) {
	if ( $id == "" ) {
		$id = get_the_ID();
	}

	return get_post_meta( $id, 'pvc_views', true );
}

add_action( 'add_meta_boxes', 'add_pv_disable_area' );
/**
 *    管理画面上にPVランキングの対象にするかどうかのチェック項目を設ける
 */
function add_pv_disable_area() {
	$keni_pv = new Keni_PV_Widget();
	add_meta_box( 'pv_disable_area', 'PVランキングから除外', array( $keni_pv, 'view_pv_setting' ), array( 'post', 'page' ), 'side', 'low' );
}

/**
 * Class Keni_PV_Widget
 */
class Keni_PV_Widget extends WP_Widget {

	function get_ranking_style_list() {
		$ranking_style_list = array(
			"1" => array( "label"     => "画像＋テキスト",
			              "div_class" => "widget_recent_entries_img widget_recent_entries_ranking"
			),
			"2" => array( "label"     => "背景画像＋テロップ",
			              "div_class" => "widget_recent_entries_img02 widget_recent_entries_ranking",
			),
			"3" => array( "label"     => "背景画像＋テキスト",
			              "div_class" => "widget_recent_entries_img03 widget_recent_entries_ranking",
			)
		);

		return $ranking_style_list;
	}

	function get_ranking_target_list() {
		$ranking_target_list = array(
			"pv"  => array( "label" => "PV数" ),
			"hbm" => array( "label" => "はてブ数" )
		);

		return $ranking_target_list;
	}

	function get_ranking_period() {
		$ranking_period = array(
			"1d" => "24時間",
			"1w" => "1週間",
			"1m" => "1ヶ月",
			"no" => "全て"
		);

		return $ranking_period;
	}

	function __construct() {
		parent::__construct( 'keni_pv',
			'【賢威】人気記事（PV・はてな）',
			array( 'description' => '賢威テンプレートに付属する 記事PV数・はてなブックマーク数でランキングを表示するウィジェットです', )
		);
	}

	function widget( $args, $instance ) {
		// 期間を区切る
		$ranking_period = $this->get_ranking_period();
		if ( ! is_array( $ranking_period ) ) {
			$ranking_period = array();
		}

		$ranking_style_list = $this->get_ranking_style_list();

		$before_widget = $args['before_widget'];
		$before_title  = $args['before_title'];
		$after_title   = $args['after_title'];
		$after_widget  = $args['after_widget'];


		// ランキングの文字数
		$keni_rank_desc_length = apply_filters( 'keni_rank_desc_length', 80 );

		extract( $args );

		$instance['title'] = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Popular Posts', 'keni' );

		$_number = ( ! empty( $instance['number'] ) ? $instance['number'] : 5 );
		$_show_pv = ( ! empty( $instance['show_pv'] ) ? $instance['show_pv'] : 'n' );
		$_target = ( ! empty( $instance['target'] ) ? $instance['target'] : null );
		$title   = apply_filters( 'widget_title', $instance['title'] );
		$number  = apply_filters( 'widget_number', $_number );
		$show_pv = apply_filters( 'widget_show_pv', $_show_pv );
		$target  = apply_filters( 'widget_target', $_target );

		if ( empty( $target ) ) {
			$target = "pv";
		}

		$_style  = ( ! empty( $instance['style'] ) ? $instance['style'] : "1" );
		$_period = ( ! empty( $instance['period'] ) ? $instance['period'] : '' );

		$style  = apply_filters( 'widget_style', $_style );
		$period = apply_filters( 'widget_period', $_period );

		$before_widget = str_replace( "widget widget_keni_pv\"", "widget widget_keni_pv " . $ranking_style_list[ $style ]['div_class'] . "\"", $before_widget );

		$before_widget_title_html = $before_widget;
		if ( $title ) {
			$before_widget_title_html .= $before_title . $title . $after_title;
		}

		global $wpdb;

		if ( $target == "pv" ) {

			if ( empty( $period ) ) {
				$period = end( $ranking_period );
			}

			switch ( $period ) {
				case "1d":
					$start = date( "YmdH", mktime( ( date( "H" ) - 24 ), 0, 0, date( "m" ), date( "d" ), date( "Y" ) ) );
					break;
				case "1w":
					$start = date( "YmdH", mktime( 0, 0, 0, date( "m" ), ( date( "d" ) - 7 ), date( "Y" ) ) );
					break;
				case "1m":
					$start = date( "YmdH", mktime( 0, 0, 0, ( date( "m" ) - 1 ), date( "d" ), date( "Y" ) ) );
					break;
				default:
					$start = 0;
					break;
			}


			// 除外するpost_idを取得
			$ext_ids = $wpdb->get_col( "SELECT post_id FROM " . $wpdb->prefix . "postmeta WHERE meta_key='pv_disable'" );
			$ext_sql = ( is_array( $ext_ids ) && count( $ext_ids ) > 0 ) ? " AND meta.post_id NOT IN (" . implode( ",", $ext_ids ) . ")" : "";

			if ( $start == 0 ) {
				// PV数の多い記事の情報とPV数を取得
				$counts = $wpdb->get_results( "SELECT ID, post_title, meta_value AS pv FROM {$wpdb->postmeta} AS meta LEFT JOIN {$wpdb->posts} AS po ON meta.post_id=po.ID WHERE meta_key='pvc_views' AND post_status='publish' AND (post_type='post' OR post_type='page')" . $ext_sql . " GROUP BY meta.post_id ORDER BY (pv+0) DESC LIMIT 0," . $number, ARRAY_A );
			} else {
				$end    = date( "YmdH" );
				$counts = $wpdb->get_results( "SELECT pvs.post_id AS ID, post_title, SUM(pv_count) AS pv FROM {$wpdb->prefix}keni_pv AS pvs LEFT JOIN {$wpdb->posts} AS po ON pvs.post_id=po.ID LEFT JOIN {$wpdb->postmeta} AS meta ON meta.post_id=po.ID WHERE meta_key='pvc_views' AND post_status='publish' AND (post_type='post' OR post_type='page') AND pv_dates BETWEEN " . $start . " AND " . $end . $ext_sql . " GROUP BY pvs.post_id ORDER BY pv DESC, po.post_modified DESC LIMIT 0," . $number, ARRAY_A );
			}

			echo $before_widget_title_html;
			?>
            <ol class="list_widget_recent_entries_img">
			<?php
			foreach ( $counts as $no => $val ) {
				$post_data = get_post( $val['ID'] );

				$content = ( $post_data->post_excerpt != "" ) ? strip_tags( strip_shortcodes( $post_data->post_excerpt ) ) : strip_tags( strip_shortcodes( $post_data->post_content ) );

				if ( mb_strlen( $content ) > $keni_rank_desc_length ) {
					$content = mb_substr( $content, 0, $keni_rank_desc_length ) . "...";
				}

				$str_pv_count = ( $show_pv == 'y' ? '<span class="count">（' . number_format( $val['pv'] ) . ' view）</span>' : '' );

				// target_mark = ' target="_blank"';
				$target_mark = " " . apply_filters( "keni_pv_link_target", "" );

				$thumbnail_str = "keni_thumbnail";
				if ( $style == "1" ) {
					// サムネイルサイズを賢威8特別サイズ keni_thumbnail_s にする
					$thumbnail_str = "keni_thumbnail_s";
				}
				if ( get_the_post_thumbnail( $post_data->ID ) != ""  ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_data->ID ), $thumbnail_str );
					$thumbnail_image_url = $image[0];
				}
				else {
					$thumbnail_image_url = get_stylesheet_directory_uri() . '/images/no-image.jpg';
				}
                $str_post_title = $post_data->post_title . $str_pv_count;
				switch ( $style ) {
					case "1":
						echo sprintf( keni_format_thumb_li( $target_mark ), get_the_permalink( $post_data->ID ), $thumbnail_image_url, esc_html( $post_data->post_title ), get_the_permalink( $post_data->ID ), $str_post_title, $target_mark );
						break;
					case "2":
						echo sprintf( keni_format_thumb_li( $target_mark ), get_the_permalink( $post_data->ID ), $thumbnail_image_url, esc_html( $post_data->post_title ), get_the_permalink( $post_data->ID ), $str_post_title, $target_mark );
						break;
					case "3":
						echo sprintf( keni_format_thumb_background_li( $target_mark ), $thumbnail_image_url, get_the_permalink( $post_data->ID ), $str_post_title, $target_mark );
						break;
				}
			}
			if ( isset( $counts ) && $counts > 0 ) {
				?>
                </ol>
				<?php
			}
		} else {
			echo $before_widget_title_html;
			?>
            <ol class="list_widget_recent_entries_img">
				<?php
				$url    = "https://b.hatena.ne.jp/entrylist/json?url=" . urlencode( home_url() ) . "&sort=count&callback=json";
				$hatena = wp_remote_get( $url );
				if ( ! is_wp_error( $hatena ) && $hatena['response']['code'] === 200 ) {

					$content = $hatena['body'];

					preg_match_all( "/({.*?})/", $content, $json );

					if ( isset( $json[1] ) && count( $json[1] ) > 0 ) {
						$now_count = 0;

						foreach ( $json[1] as $no => $line ) {

							$post_id = 0;

							if ( $number > $now_count ) {
								$line_val         = json_decode( $line, true );
								$str_hatena_count = '<span class="count">（' . number_format( $line_val['count'] ) . ' users）</span>';

								$post_id = url_to_postid( $line_val['link'] );

								if ( $post_id > 0 && get_the_post_thumbnail( $post_id ) != "" ) {
									$image_url       = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id, 'large_thumb' ) );
									$thumbnail_image = $image_url[0];
								} else {
									$thumbnail_image = get_template_directory_uri() . "/images/no-image.jpg";
								}

								$title   = ( $post_id > 0 && get_the_title( $post_id ) != "" ) ? get_the_title( $post_id ) : $line_val['title'];
								$content = ( $post_id > 0 && get_post_field( 'excerpt', $post_id ) ) ? strip_tags( strip_shortcodes( get_post_field( 'excerpt', $post_id ) ) ) : "";

								$thumbnail_image_url = get_template_directory_uri() . "/images/no-image.jpg";
								if ( get_the_post_thumbnail( $post_id ) != "" ) {
									$image_url           = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
									$thumbnail_image_url = $image_url[0];
								}
								// target_mark = ' target="_blank"';
								$target_mark = " " . apply_filters( "keni_pv_link_target", "" );
								$thumbnail_image = "<img src=\"" . $thumbnail_image_url . "\" alt=\"".$title."\">";

								switch ( $style ) {
									case "1":
										?>
                                        <li>
                                            <figure class="widget_recent_entries_thumb">
                                                <a href="<?php echo $line_val['link']; ?>"<?php echo $target_mark; ?>><?php echo $thumbnail_image; ?></a>
                                            </figure>
                                            <p class="widget_recent_entries_img_entry_title"><a
                                                        href="<?php echo $line_val['link']; ?>"<?php echo $target_mark; ?>><?php echo $title; ?><?php echo $str_hatena_count; ?></a>
                                            </p>
                                        </li>
										<?php
										break;
									case "2":
										?>
                                        <li>
                                            <figure class="widget_recent_entries_thumb">
                                                <a href="<?php echo $line_val['link']; ?>"<?php echo $target_mark; ?>><?php echo $thumbnail_image; ?></a>
                                            </figure>
                                            <p class="widget_recent_entries_img_entry_title"><a
                                                        href="<?php echo $line_val['link']; ?>"<?php echo $target_mark; ?>><?php echo $title; ?><?php echo $str_hatena_count; ?></a>
                                            </p>
                                        </li>
										<?php
										break;
									case "3":
										?>
                                        <li style="background-image: url(<?php echo $thumbnail_image_url; ?>);">
                                            <p class="widget_recent_entries_img_entry_title"><a
                                                        href="<?php echo $line_val['link']; ?>"><?php echo $title; ?><?php echo $str_hatena_count; ?></a>
                                            </p>
                                        </li>
										<?php
										break;
								}

							} else {
								break;
							}
							$now_count ++;

						}
					}
				} else {
					?>
                    <li>&nbsp;</li>
					<?php
				}
				?>
            </ol>
			<?php
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = trim( $new_instance['number'] );
		$instance['number'] = mb_convert_kana( $instance['number'], "n" );
		$instance['target'] = trim( $new_instance['target'] );

		if ( ! is_numeric( $instance['number'] ) || ( $instance['number'] > 10 ) ) {
			$instance['number'] = 10;
		}
		$instance['show_pv'] = trim( $new_instance['show_pv'] );
		$instance['style']   = $new_instance['style'];
		$instance['period']  = $new_instance['period'];

		return $instance;
	}

	function form( $instance ) {
		$title  = ( isset( $instance['title'] ) ) ? esc_attr( $instance['title'] ) : "";
		$number = ( isset( $instance['number'] ) ) ? esc_attr( $instance['number'] ) : 5;
		if ( ! is_numeric( $number ) ) {
			$number = 5;
		}
		$show_pv = ( isset( $instance['show_pv'] ) ) ? esc_attr( $instance['show_pv'] ) : "n";

		$target = ( isset( $instance['target'] ) ) ? esc_attr( $instance['target'] ) : "pv";
		if ( empty( $target ) ) {
			$target = "pv";
		}
		$style = ( isset( $instance['style'] ) ) ? esc_attr( $instance['style'] ) : 3;

		$period = ( isset( $instance['period'] ) ) ? esc_attr( $instance['period'] ) : 0;
		?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">タイトル:<input class="widefat"
                                                                                  id="<?php echo $this->get_field_id( 'title' ); ?>"
                                                                                  name="<?php echo $this->get_field_name( 'title' ); ?>"
                                                                                  type="text"
                                                                                  value="<?php echo $title; ?>"></p>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>">表示する投稿数:<input type="text"
                                                                                      id="<?php echo $this->get_field_id( 'number' ); ?>"
                                                                                      name="<?php echo $this->get_field_name( 'number' ); ?>"
                                                                                      type="text"
                                                                                      value="<?php echo $number; ?>"
                                                                                      size="3">(最大 10)</p>
        <p>表示項目:
        <?php
        $chk_mark = "";
        if ( ! empty( $show_pv ) && $show_pv != "n" ) {
            $chk_mark = " checked=\"checked\"";
        }
        ?>
        <p><input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_pv' ); ?>"
                  value="y"
                  name="<?php echo $this->get_field_name( 'show_pv' ); ?>"<?php echo $chk_mark; ?>><label
                    for="<?php echo $this->get_field_id( 'show_pv' ); ?>">「PV数」または「はてブ数」を表示しますか ?</label></p>
		<?php

		$ranking_target_list = $this->get_ranking_target_list();
		foreach ( $ranking_target_list as $target_style => $target_val ) {
			$chk_mark = "";
			if ( $target_style == $target ) {
				$chk_mark = " checked=\"checked\"";
			}
			?>
            <span><input type="radio" name="<?php echo $this->get_field_name( 'target' ); ?>"
                         value="<?php echo $target_style; ?>"
                         id="<?php echo $this->get_field_id( 'target_' . $target_style ); ?>"<?php echo $chk_mark; ?>><label
                        for="<?php echo $this->get_field_id( 'target_' . $target_style ); ?>"><?php echo $target_val['label']; ?></label>　</span>
			<?php
		}
		?>
        </p>
		<?php
		// 期間を区切る
		$ranking_period = $this->get_ranking_period();
		if ( empty( $period ) ) {
			$period = end( $ranking_period );
		}

		?>
        <p>PV数を集計する期間:
            <select name="<?php echo $this->get_field_name( 'period' ); ?>">
				<?php
				foreach ( $ranking_period as $period_key => $period_val ) {
					$chk_mark = "";
					if ( $period == $period_key ) {
						$chk_mark = " selected=\"selected\"";
					}
					?>
                    <option value="<?php echo $period_key; ?>"<?php echo $chk_mark; ?>><?php echo $period_val; ?></option>
					<?php
				}
				echo "</select></p>\n";


				if ( ! is_numeric( $style ) ) {
					$style = 3;
				}

				?>
        <p>表示形式:</p>
		<?php
		$ranking_style_list = $this->get_ranking_style_list();
		foreach ( $ranking_style_list as $style_id => $style_val ) {
			$chk_mark = "";
			if ( $style_id == $style ) {
				$chk_mark = " checked=\"checked\"";
			}
			?>
            <p><input type="radio" name="<?php echo $this->get_field_name( 'style' ); ?>"
                      value="<?php echo $style_id; ?>"
                      id="<?php echo $this->get_field_id( 'style_' . $style_id ); ?>"<?php echo $chk_mark; ?>><label
                        for="<?php echo $this->get_field_id( 'style_' . $style_id ); ?>"><?php echo $style_val['label']; ?></label>
            </p>
			<?php
		}
	}

	/**
	 *
	 * @param bool $disp_flg
	 *
	 * @return string|void Archive Title if $disp_flg is false.
	 */
	public function view_pv_setting( $disp_flg = false ) {
		$pv_disable = ( isset( $_GET['post'] ) ) ? get_post_meta( intval( $_GET['post'] ), "pv_disable", true ) : "";

		$chk_mark = "";
		if ( ! empty( $pv_disable ) && $pv_disable == "y" ) {
			$chk_mark = " checked=\"checked\"";
		}
		$res = <<<EOL
<input type="checkbox" name="pv_disable" value="y" id="pv_disable"{$chk_mark}><label for="pv_disable">&nbsp;除外する</label>
EOL;
		if ( $disp_flg == false ) {
			return $res;
		}
		echo $res;
	}

	/**
	 * save_pv_disable
	 *
	 * @param string $post_id
	 */
	function save_pv_disable( $post_id = "" ) {
		if ( isset( $_POST['pv_disable'] ) ) {
			update_post_meta( $post_id, 'pv_disable', "y" );
		} else {
			delete_post_meta( $post_id, 'pv_disable' );
		}
	}


	/*************************************************/
	/**
	 * PVランキングを集計するテーブルから、1ヶ月前以前のデータを削除する
	 */
	function pv_one_month_delete() {
		global $wpdb;
		$days = $wpdb->query( "DELETE FROM " . $wpdb->prefix . "keni_pv WHERE SUBSTR(pv_dates,1,8) < " . date( "Ymd", mktime( 0, 0, 0, date( "m" ) - 1, date( "d" ), date( "Y" ) ) ) );
	}

	/**
	 * createPVData
	 */
	function createPVData() {
		global $wpdb;
		if ( $wpdb->get_var( "show tables like '" . $wpdb->prefix . "keni_pv'" ) != $wpdb->prefix . "keni_pv" ) {

			$char   = defined( "DB_CHARSET" ) ? DB_CHARSET : "utf8";
			$pv_sql = "CREATE TABLE " . $wpdb->prefix . "keni_pv (
				`pv_dates` char(10) collate utf8_bin NOT NULL,
				`post_id` int(4) unsigned NOT NULL,
				`pv_count` int(4) unsigned NOT NULL default '0',
				PRIMARY KEY  (`pv_dates`,`post_id`),
				KEY `pv_dates` (`pv_dates`),
				KEY `pv_post_id` (`post_id`)
			) ENGINE=InnoDB DEFAULT CHARSET = " . $char . ";";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $pv_sql );
		}
	}

}