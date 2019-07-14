<?php
//-----------------------------------------------------
// 最新記事一覧
//-----------------------------------------------------
class Keni_Modified_Posts extends WP_Widget {
	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'keni_modified_entries', // Base ID
			__( '【賢威】記事の一覧表示', 'keni' ), // Name
			array( 'classname' => 'widget_recent_entries', 'description' => __( '更新日順・投稿日順で記事の一覧表示ができる賢威のカスタムウィジェットです', 'keni' ), ) // Args
		);
	}

	/**
	 * ウィジェットのフロントエンド表示
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     ウィジェットの引数
	 * @param array $instance データベースの保存値
	 */
	public function widget( $args, $instance ) {
		$str_title = ! empty( $instance['title'] ) ? $instance['title'] : __( '最近更新した記事', 'keni' ) ;
		$num_posts_num  = ! empty( $instance['posts_num'] ) ? $instance['posts_num'] : '5' ;
		$flg_show_date = ! empty( $instance['show_date'] ) ? true : false;
		$arr_category__in  = ! empty( $instance['category__in'] ) ? $instance['category__in'] : array() ;
		$arr_category__not_in  = ! empty( $instance['category__not_in'] ) ? $instance['category__not_in'] : array() ;
        $str_orderby = ! empty( $instance['orderby'] ) && $instance['orderby'] === "1" ? 'post_date' : 'modified' ;
		echo $args['before_widget'];
		if ( ! empty( $str_title ) ) {
			echo $args['before_title'] . apply_filters( 'keni_modified_post_widget_title', $str_title ). $args['after_title'];
		}

		// functions.php 等で変更可能
        $keni_modified_post_type = apply_filters( 'keni_modified_post_type', "post" );
		$keni_modified_post_orderby = apply_filters( 'keni_modified_post_orderby', $str_orderby );
		$keni_modified_post_order = apply_filters( 'keni_modified_post_order', 'DESC' );

		$query_args = array(
			'post_type' => $keni_modified_post_type,
			'showposts' => $num_posts_num,
			'orderby' => $keni_modified_post_orderby,
            'order' => $keni_modified_post_order
		);

		if ( ! empty( $arr_category__in ) ) {
			$query_args = array_merge($query_args,array( 'category__in' => $arr_category__in ) );
		}
		if ( ! empty( $arr_category__not_in ) ) {
			$query_args = array_merge($query_args,array( 'category__not_in' => $arr_category__not_in ) );
		}

		$the_query = new WP_Query( $query_args );
		if ( $the_query->have_posts() ) : ?>

		<ul>
		<?php
		while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<li><a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
				<?php if ($flg_show_date): ?>
					<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
				<?php endif; ?>
			</a></li>
		<?php
		endwhile; ?>
		</ul>
		<?php
		endif;
		wp_reset_postdata();

		echo $args['after_widget'];

	}

	/**
	 * バックエンドのウィジェットフォーム
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance データベースからの前回保存された値
	 */
	public function form( $instance ) {
		$str_title = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
		$num_posts_num  = ! empty( $instance['posts_num'] ) ? $instance['posts_num'] : '5' ;
		$str_check_show_date = ! empty( $instance['show_date'] ) ? 'checked="checked"' : '' ;
		$arr_category__in  = ! empty( $instance['category__in'] ) ? $instance['category__in'] : array() ;
		$arr_category__not_in  = ! empty( $instance['category__not_in'] ) ? $instance['category__not_in'] : array() ;
        $str_select_0 = ! empty( $instance['orderby'] ) && $instance['orderby'] === "0" ? ' selected="selected"' : '' ;
        $str_select_1 = ! empty( $instance['orderby'] ) && $instance['orderby'] === "1" ? ' selected="selected"' : '' ;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル:', 'keni' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $str_title ); ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_num' ); ?>">表示する投稿数:</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'posts_num' ); ?>" name="<?php echo $this->get_field_name( 'posts_num' ); ?>" type="number" step="1" min="1" size="3" value="<?php echo esc_attr( $num_posts_num ); ?>"></p>

		<p><input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>"" <?php echo $str_check_show_date; ?> /><label for="<?php echo $this->get_field_id( 'show_date' ); ?>">日付を表示する</label></p>

        <p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>">表示順:</label><select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>"><option value="0"<?php echo $str_select_0; ?>>更新日順</option><option value="1"<?php echo $str_select_1; ?>>投稿日順</option></select></p>
		<p>
		<div class="categorydiv">
		<label for="<?php echo $this->get_field_id( 'category__in' ); ?>"><?php _e( '表示カテゴリ:', 'keni' ); ?></label>
			<div class="tabs-panel">
			<ul class="categorychecklist form-no-clear">
			<?php
				keni_wp_terms_checklist_input_name( 'category', array( 'input_name' => $this->get_field_name( 'category__in' ), 'selected_cats' => $arr_category__in, 'checked_ontop' => false ) );
			?>
			</ul>
			</div>
		</div>
		</p>

		<p>
		<div class="categorydiv">
		<label for="<?php echo $this->get_field_id( 'category__not_in' ); ?>"><?php _e( '除外カテゴリ:', 'keni' ); ?></label>
			<div class="tabs-panel">
			<ul class="categorychecklist form-no-clear">
			<?php
				keni_wp_terms_checklist_input_name( 'category', array( 'input_name' => $this->get_field_name( 'category__not_in' ), 'selected_cats' => $arr_category__not_in, 'checked_ontop' => false ) );
			?>
			</ul>
			</div>
		</div>
		</p>
		<?php
	}

	/**
	 * ウィジェットフォームの値を保存用にサニタイズ
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance 保存用に送信された値
	 * @param array $old_instance データベースからの以前保存された値
	 *
	 * @return array 保存される更新された安全な値
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['posts_num'] = ( ! empty( $new_instance['posts_num'] ) ) ? strip_tags( $new_instance['posts_num'] ) : '';
		$instance['show_date'] = ( ! empty( $new_instance['show_date'] ) ) ? strip_tags( $new_instance['show_date'] ) : '';
		$instance['category__in'] = ( ! empty( $new_instance['category__in'] ) ) ? $new_instance['category__in'] : '';
		$instance['category__not_in'] = ( ! empty( $new_instance['category__not_in'] ) ) ? $new_instance['category__not_in'] : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? $new_instance['orderby'] : '';

		return $instance;
	}

} // class Keni_Modified_Posts

// ウィジェットを登録
function register_keni_Modified_posts() {
	register_widget( 'Keni_modified_Posts' );
}
add_action( 'widgets_init', 'register_keni_modified_posts' );

class Keni_Widget_Recent_Posts extends WP_Widget {

	function __construct() {
		parent::__construct('keni_recent_post',
												'【賢威】画像つきの投稿一覧',
												array( 'description' => '画像つきの投稿一覧を表示する賢威のカスタムウィジェットです', )
											);
	}


	public function widget( $args, $instance ) {

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts with Images' , 'keni');
		$title = apply_filters( 'keni_recent_post_widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$flg_show_date = ( ! empty( $instance['show_date'] ) ) ? true : false;

		$style = isset( $instance['style'] ) ? $instance['style'] : 1;

		$class = 'widget_recent_entries_img';
		if ( $style == "2" ) {
			$class = 'widget_recent_entries_img02';
		} else if ( $style == "3" ) {
			$class = 'widget_recent_entries_img03';
		}


		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) {

			echo $args['before_widget'];
			echo '<div class="' . $class . '">';
			if ( $title ) echo $args['before_title'] . $title . $args['after_title']."\n";

			$no = 0;


			while ( $r->have_posts() ) : $r->the_post();

				$str_post_title = esc_html( get_the_title() );

				if ( $flg_show_date ) {
					$str_post_title .= '<span class="post-date">' . get_the_time( get_option( 'date_format' ) ) . '</span>';
				}

				if ($no <= 0) echo '<ul class="list_widget_recent_entries_img">';

                $thumbnail_str = "keni_thumbnail";
                if ( $style == "1" ) {
	                // サムネイルサイズを賢威8特別サイズ keni_thumbnail_s にする
	                $thumbnail_str = "keni_thumbnail_s";
                }
				if ( get_the_post_thumbnail(get_the_ID()) != ""  ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumbnail_str );
					$str_image_url = $image[0];
				}
				else {
					$str_image_url = get_stylesheet_directory_uri() . '/images/no-image.jpg';
				}
				switch ($style) {
				    // 画像＋テキスト
					case "1":
						echo sprintf( keni_format_thumb_li(), get_the_permalink(), $str_image_url, esc_html( get_the_title() ), get_the_permalink(), $str_post_title );
						break;
					// 背景画像＋テロップ
					case "2":
						echo sprintf( keni_format_thumb_li(), get_the_permalink(), $str_image_url, esc_html( get_the_title() ), get_the_permalink(), $str_post_title );
						break;
					// 背景画像＋テキスト
					case "3":
						echo sprintf( keni_format_thumb_background_li(), $str_image_url, get_the_permalink(), $str_post_title );
						break;
				}
				$no++;
			endwhile;

			echo "</ul>\n</div>";
			echo $args['after_widget'];

			wp_reset_postdata();
		}

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}


  	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = mb_convert_kana($new_instance['number'], "n");
		$instance['show_date'] = trim($new_instance['show_date']);
		$instance['style'] = $new_instance['style'];
		return $instance;
	}

	function form($instance) {

		$new_post_list = $this->get_new_post_list();

		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : "";
		$number = (isset($instance['number'])) ? esc_attr($instance['number']) : 5;
		if (!preg_match("/^[0-9]+$/", $number)) $number = 5;
		$show_date = (isset($instance['show_date'])) ? esc_attr($instance['show_date']) : '';
		$str_check_show_date = ! empty( $instance['show_date'] ) ? 'checked="checked"' : '' ;
		$style = (isset($instance['style'])) ? esc_attr($instance['style']) : 1;

		echo "<p><label for=\"".$this->get_field_id('title')."\">タイトル:<input class=\"widefat\" id=\"".$this->get_field_id('title')."\" name=\"".$this->get_field_name('title')."\" type=\"text\" value=\"".$title."\" /></p>\n";
		echo "<p><label for=\"".$this->get_field_id('number')."\">表示する投稿数:<input type=\"text\"  id=\"".$this->get_field_id('number')."\" name=\"".$this->get_field_name('number')."\" type=\"text\" value=\"".$number."\" size=\"3\" /></p>\n";
		?>
		<p><input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>"" <?php echo $str_check_show_date; ?> /><label for="<?php echo $this->get_field_id( 'show_date' ); ?>">日付を表示する</label></p>
		<?php
		if (!preg_match("/^[0-9]+$/", $style)) $style = 1;

		echo "<p>表示形式:</p>\n";
		foreach ($new_post_list as $style_id => $style_val) {
			if ($style_id == $style) {
				echo "<p><input type=\"radio\" name=\"".$this->get_field_name('style')."\" value=\"".$style_id."\" id=\"".$this->get_field_id('style_'.$style_id)."\" checked=\"checked\"><label for=\"".$this->get_field_id('style_'.$style_id)."\">".$style_val['label']."</label></p>\n";
			} else {
				echo "<p><input type=\"radio\" name=\"".$this->get_field_name('style')."\" value=\"".$style_id."\" id=\"".$this->get_field_id('style_'.$style_id)."\"><label for=\"".$this->get_field_id('style_'.$style_id)."\">".$style_val['label']."</label></p>\n";
			}
		}
	}

    public function get_new_post_list() {
	    $new_post_list = array("1" => array("label" => "シンプルなリスト", "ul_class" => "link-menu-image", "li_class" => ""),
	                           "2" => array("label" => "画像＋テキストのリスト", "ul_class" => "post-list01", "li_class" => " on-image"),
	                           "3" => array("label" => "背景画像＋テキストのリスト", "ul_class" => "post-list02", "li_class" => " on-image")
	    );
	    return $new_post_list;
    }

}

function new_posts_widget_register() {
	register_widget('Keni_Widget_Recent_Posts');
}
add_action('widgets_init', 'new_posts_widget_register');
