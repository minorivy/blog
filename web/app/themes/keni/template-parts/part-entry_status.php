<div class="entry_status">
	<?php
	$flag_get_time_disp = get_option( 'keni_time_disp', 'show' );
	if ( $flag_get_time_disp != 'hide' ) :
	?>
	<ul class="entry_date">
		<?php if( get_the_modified_date() > get_the_date() && ( $flag_get_time_disp == 'show' || $flag_get_time_disp == 'update' ) ) {
			$str_modified_date = get_the_modified_date();
			$str_modified_date_prop = get_the_modified_date('c');
			if ( $str_modified_date == '' ) {
				$str_modified_date = get_the_date();
				$str_modified_date_prop = get_the_date('c');
			}
			echo '<li class="entry_date_item">' . __( 'Update Date', 'keni' ) . '：<time itemprop="dateModified" datetime="' . $str_modified_date_prop . '" content="' . $str_modified_date_prop . '">' . $str_modified_date . '</time></li>';
		} ?>
		<?php if ( $flag_get_time_disp == 'show' || $flag_get_time_disp == 'post' ) {
			$str_published_date = get_the_date();
			$str_published_date_prop = get_the_date('c');
			echo '<li class="entry_date_item">' . __( 'Post Date', 'keni' ) . '：<time itemprop="datePublished" datetime="' . $str_published_date_prop . '" content="' . $str_published_date_prop . '">' . $str_published_date . '</time></li>';
		} ?>
	</ul>
	<?php endif; ?>
	<ul class="entry_category">
		<?php
			$cats = get_the_category();
			foreach ($cats as $cat) {

				$style_a = '';
				$style_li = '';
				// category | tag Color
				if ( function_exists( "get_term_meta" ) ) {
					// wordpress 4.4.0以降
					$str_get_text_color_term = get_term_meta( $cat->term_id, "keni_text_color_term", true );
					$str_get_background_color_term = get_term_meta( $cat->term_id, "keni_background_color_term", true );
				}
				else {
					$str_get_text_color_term = get_option( "keni_text_color_term_" . $cat->term_id );
					$str_get_background_color_term = get_option( "keni_background_color_term_" . $cat->term_id );
				}

				if ( ! empty( $str_get_text_color_term ) ) {
					$style_a = ' style="color: ' . $str_get_text_color_term . ';"';
				}
				if ( ! empty( $str_get_background_color_term ) ) {
					$style_li = ' style="background-color: ' . $str_get_background_color_term . ';"';
				}

				echo '<li class="entry_category_item ' . $cat->slug . '"' . $style_li . '><a href="'. get_category_link( $cat->term_id ) .'"' . $style_a . '>'. $cat->name .'</a></li>';
			}
		?>
	</ul>
</div>