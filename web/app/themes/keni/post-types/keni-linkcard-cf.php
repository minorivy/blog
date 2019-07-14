<?php

function keni_linkcard_init() {
	register_post_type( 'keni_linkcard', array(
		'labels'                => array(
			'name'               => __( '賢威リンクカード', 'theme-name' ),
			'singular_name'      => __( '賢威リンクカード', 'theme-name' ),
			'all_items'          => __( '賢威リンクカード一覧', 'theme-name' ),
			'new_item'           => __( '新規賢威リンクカードを追加', 'theme-name' ),
			'add_new'            => __( '新規追加', 'theme-name' ),
			'add_new_item'       => __( '新しい賢威リンクカードを追加', 'theme-name' ),
			'edit_item'          => __( '賢威リンクカードを編集', 'theme-name' ),
			'view_item'          => __( '賢威リンクカードを表示', 'theme-name' ),
			'search_items'       => __( '賢威リンクカードを検索', 'theme-name' ),
			'not_found'          => __( '賢威リンクカードが見つかりませんでした。', 'theme-name' ),
			'not_found_in_trash' => __( 'ゴミ箱内に賢威リンクカードが見つかりませんでした。', 'theme-name' ),
			'parent_item_colon'  => __( 'Parent store', 'theme-name' ),
			'menu_name'          => __( '賢威リンクカード', 'theme-name' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title' ),    // URLをタイトルとして使用
		'has_archive'           => false,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-media-code',
		'show_in_rest'          => true,
		'rest_base'             => 'keni_cc',
		'menu_position'         => 5,
		'exclude_from_search'   => true,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}

add_action( 'init', 'keni_linkcard_init' );

function keni_linkcard_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['keni_linkcard'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Keni linkcard updated.', 'keni' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'keni' ),
		3  => __( 'Custom field deleted.', 'keni' ),
		4  => __( 'Keni linkcard updated.', 'keni' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Keni linkcard restored to revision from %s', 'keni' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Keni linkcard published.', 'keni' ), esc_url( $permalink ) ),
		7  => __( 'Keni cc saved.', 'keni' ),
		8  => sprintf( __( 'Keni linkcard submitted.', 'keni' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf( __( 'Keni linkcard scheduled for: <strong>%1$s</strong>.', 'keni' ),
			// translators: Publish box date format, see https://secure.php.net/manual/en/function.date.php
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __( 'Keni linkcard draft updated.', 'keni' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'keni_linkcard_updated_messages' );

/**
 * 投稿一覧にリンクURLを表示
 *
 * @param $defaults
 *
 * @return mixed
 */
function keni_linkcard_posts_columns( $defaults ) {
	$defaults['url'] = '指定URL';

	return $defaults;
}

add_filter( 'manage_keni_linkcard_posts_columns', 'keni_linkcard_posts_columns' );

/**
 * リンクURLを表示
 *
 * @param $column_name
 * @param $post_id
 */
function keni_linkcard_add_column( $column_name, $post_id ) {
	if ( $column_name == 'url' ) {
		$surls = get_post_meta( $post_id, 'url', true );
	}
	if ( isset( $surls ) && $surls ) {
		echo esc_attr( $surls );
	} else {
		echo __( 'None' );
	}
}

add_action( 'manage_keni_linkcard_posts_custom_column', 'keni_linkcard_add_column', 10, 2 );

/**
 * 管理画面 一覧画面の調整 CSS
 */
function keni_linkcard_posts_css() {
	global $id;
	$post_type = get_post_type( $id );
	if ( $post_type === "keni_linkcard" ) {
		echo <<<EOF
		<style type="text/css">
			/** 表示する 削除 */
			.view { display: none; }
		</style>
		<script>
			jQuery(function() {
				jQuery('input[name="post_name"]').parent().parent().remove();
				jQuery('select[name="mm"]').parent().parent().parent().remove();
				jQuery('input[name="post_password"]').parent().parent().parent().remove();
				jQuery('select[name="_status"]').parent().parent().parent().remove();
			});
		</script>
EOF;
	}
}

add_action( 'admin_head', 'keni_linkcard_posts_css', 100 );

/**
 * 管理画面 投稿画面の調整
 */
function keni_linkcard_submitbox_custom() {
	global $id;
	$post_type = get_post_type( $id );
	if ( $post_type === "keni_linkcard" ) {
		echo '<style>
#edit-slug-box { display: none; }
li#wp-admin-bar-view { display: none; }
#preview-action { display: none; }
.misc-pub-section.misc-pub-post-status,
#post-status-display { display: none; }
.misc-pub-section.misc-amp-status { display: none; }
</style>';
	}
}
add_action( 'admin_print_styles', 'keni_linkcard_submitbox_custom' );
