<?php
//-----------------------------------------------------
// Page Title
//-----------------------------------------------------
/**
 * category | tag
 */
function keni_term_edit_form_fields_page_title( $term ) {
	$num_term_id = $term->term_id;

	if ( function_exists( "get_term_meta" ) ) {
		// wordpress 4.4.0以降
		$str_get_page_title_term = get_term_meta( $num_term_id, "keni_page_title_term", true );
	}
	else {
		$str_get_page_title_term = get_option( "keni_page_title_term_" . $num_term_id );
	}

	$str_html_page_title = keni_format_text( 'keni_term_meta[keni_page_title_term]', $str_get_page_title_term );

?>
<tr>
	<th><label for="keni_page_title_term"><?php _e( "Page Title", 'keni' ); ?></label></th>
	<td>
		<?php echo $str_html_page_title ?>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'keni_term_edit_form_fields_page_title' );
add_action( 'post_tag_edit_form_fields', 'keni_term_edit_form_fields_page_title' );

function keni_term_add_form_fields_page_title( $term ) {

	$str_html_page_title = keni_format_text( 'keni_term_meta[keni_page_title_term]' );

?>
<div class="form-field">
	<label for="keni_layout_term"><?php _e( "Page Title", 'keni' ); ?></label>
	<?php echo $str_html_page_title ?>
</div>
<?php
}
add_action( 'category_add_form_fields', 'keni_term_add_form_fields_page_title' );
add_action( 'post_tag_add_form_fields', 'keni_term_add_form_fields_page_title' );

/**
 * Get Page Title
 * @return string Archive title.
 */
function keni_get_archive_title() {

	$title = "";

	if ( is_category() || is_tag() ) {

		$num_term_id = get_queried_object_id();

		if ( function_exists( "get_term_meta" ) ) {
			// wordpress 4.4.0以降
			$str_get_page_title_term = get_term_meta( $num_term_id, "keni_page_title_term", true );
		}
		else {
			$str_get_page_title_term = get_option( "keni_page_title_term_" . $num_term_id );
		}

		if ( ! empty( $str_get_page_title_term ) ) {
			$title = $str_get_page_title_term;
		}

	} else {
	    // 日付アーカイブの場合は description を取得
        if ( is_author() ) {
	        /* translators: Author archive title. 1: Author name */
	        $title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
        } elseif ( is_year() ) {
	        /* translators: Yearly archive title. 1: Year */
	        $title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
        } elseif ( is_month() ) {
	        /* translators: Monthly archive title. 1: Month name and year */
	        $title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
        } elseif ( is_day() ) {
	        /* translators: Daily archive title. 1: Date */
	        $title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
        } elseif ( is_tax( 'post_format' ) ) {
	        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
		        $title = _x( 'Asides', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		        $title = _x( 'Galleries', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		        $title = _x( 'Images', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		        $title = _x( 'Videos', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		        $title = _x( 'Quotes', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		        $title = _x( 'Links', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		        $title = _x( 'Statuses', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		        $title = _x( 'Audio', 'post format archive title' );
	        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		        $title = _x( 'Chats', 'post format archive title' );
	        }
        } elseif ( is_post_type_archive() ) {
	        /* translators: Post type archive title. 1: Post type name */
	        $title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
        } elseif ( is_tax() ) {
	        $tax = get_taxonomy( get_queried_object()->taxonomy );
	        /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
	        $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
        } else {
	        $title = __( 'Archives' );
        }

		$title = apply_filters( "keni_get_archive_title_date", $title );
	}

	return $title;
}

/**
 * Archive title
 * @param  string $title
 * @return string Archive title.
 */
function keni_edit_archive_title( $title ) {

	$str_get_archive_title = keni_get_archive_title();
	if ( empty( $str_get_archive_title  ) ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		}
		else if ( is_tag() ) {
			$title = single_tag_title( '', false );
		}
	}
	else {
		// カテゴリが個別で設定されている場合はそのまま表示する
		$title = $str_get_archive_title;
		return $title;
	}

	return sprintf( __('Archive List for %s','keni'), $title);
}
add_filter( 'get_the_archive_title', 'keni_edit_archive_title' );



//-----------------------------------------------------
// Page Contents
//-----------------------------------------------------
/**
 * category | tag
 */
function keni_term_edit_form_fields_page_contents( $term ) {

	$num_term_id = $term->term_id;

	if ( function_exists( "get_term_meta" ) ) {
		// wordpress 4.4.0以降
		$str_get_page_contents_term = get_term_meta( $num_term_id, "keni_page_contents_term", true );
	}
	else {
		$str_get_page_contents_term = get_option( "keni_page_contents_term_" . $num_term_id );
	}

	$arr_settings = array( 'textarea_name' => 'keni_term_meta[keni_page_contents_term]');

?>
<tr>
	<th><label for="keni_page_contents_term"><?php _e( "Page Contents", 'keni' ); ?></label></th>
	<td>
		<?php wp_editor( $str_get_page_contents_term, 'keni_page_contents_term', $arr_settings ); ?>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'keni_term_edit_form_fields_page_contents' );
add_action( 'post_tag_edit_form_fields', 'keni_term_edit_form_fields_page_contents' );

function keni_term_add_form_fields_page_contents( $term ) {

	$arr_settings = array( 'textarea_name' => 'keni_term_meta[keni_page_contents_term]');

?>
<div class="form-field">
	<label for="keni_layout_term"><?php _e( "Page Contents", 'keni' ); ?></label>
	<?php wp_editor( '', 'keni_page_contents_term', $arr_settings ); ?>
</div>
<?php
}
add_action( 'category_add_form_fields', 'keni_term_add_form_fields_page_contents' );
add_action( 'post_tag_add_form_fields', 'keni_term_add_form_fields_page_contents' );

/**
 * Page Contents disp
 * @param  string $description
 * @return string Archive description.
 */
function keni_edit_archive_description( $description ) {
	if ( is_category() || is_tag() ) {

		$num_term_id = get_queried_object_id();

		if ( function_exists( "get_term_meta" ) ) {
			// wordpress 4.4.0以降
			$str_get_page_contents_term = get_term_meta( $num_term_id, "keni_page_contents_term", true );
		}
		else {
			$str_get_page_contents_term = get_option( "keni_page_contents_term_" . $num_term_id );
		}

		if ( ! empty( $str_get_page_contents_term ) ) {
			$description = sprintf( keni_format_page_contents(), $str_get_page_contents_term );
		} else {
			$description = "";
		}

	} else {
	    // keni-seo 読み込み完了が必須
		$description = keni_get_meta_description();
    }
	$flg = apply_filters( 'keni_archive_content_wpautop', true );
	$description = do_shortcode( $flg ? wpautop( $description ) : $description );
	return $description;
}
add_filter( 'get_the_archive_description', 'keni_edit_archive_description' );

/**
 * Format page contents
 * @return string
 */
function keni_format_page_contents() {
	return '<div class="keni-page-contents">%s</div>';
}
