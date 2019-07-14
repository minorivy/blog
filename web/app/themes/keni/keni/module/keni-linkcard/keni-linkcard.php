<?php
//-----------------------------------------------------
// admin 賢威リンクカード パーマリンク非表示
//-----------------------------------------------------
add_filter( 'get_sample_permalink_html' , 'keni_admin_linkcard_permalink' );
function keni_admin_linkcard_permalink( $permalink_html ){
	global $post;

	if( $post->post_type == 'keni_linkcard' || preg_match( '/post_type=keni_linkcard/', $permalink_html ) ){
		$permalink_html = false;
	}
	return $permalink_html;
}

