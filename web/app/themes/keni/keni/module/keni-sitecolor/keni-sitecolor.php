<?php
//-----------------------------------------------------
// Customizer
//-----------------------------------------------------

/**
 * Color set
 */
function keni_customize_color_set( $id = "" ) {
	$color_set["turquoise"] = array(
								'#00858a',
								'#05a5ab',
								'#b3e4e6',
								'#def2f3',
								'#e8f7f7',
								'#d1eff0',
								'#333333'
							);
	$color_set["bluegray"] = array(
								'#819faf',
								'#86aabe',
								'#dbe5eb',
								'#eff3f5',
								'#f3f7f9',
								'#e9f1f3',
								'#333333'
							);
	$color_set["brown"] = array(
								'#5a3f30',
								'#70503e',
								'#d4cbc5',
								'#ebe7e5',
								'#f2efed',
								'#e5dfdc',
								'#333333'
							);
	$color_set["lightblue"] = array(
								'#0d91b3',
								'#0baad6',
								'#b4e5f3',
								'#dff3f9',
								'#e8f7fa',
								'#d2eff7',
								'#333333'
							);
	$color_set["pink"] = array(
								'#be4e8c',
								'#d54f98',
								'#f3cadf',
								'#f8e8f1',
								'#fbeff6',
								'#f7deed',
								'#333333'
							);
	$color_set["red"] = array(
								'#e3504c',
								'#ff4e46',
								'#ffc9c7',
								'#fde7e7',
								'#ffeeee',
								'#ffe0de',
								'#333333'
							);

	if ( ! empty( $id ) ) {
		return $color_set[$id];
	}
	else {
		return $color_set;
	}

}

/**
 * Default
 */
function keni_customize_color_default( $id ) {
	$default = array(
			'keni_color_pattern'          => 'turquoise'
		);

	$default_color_set = keni_customize_color_set( $default['keni_color_pattern'] );

	$i = 1;
	foreach ($default_color_set as $key => $color) {
		$default['keni_color_' . $i] = $color;

		$i++;
	}

	if ( ! empty( $id ) ) {
		return $default[$id];
	}
}

/**
 * Color
 */
function keni_admin_color_script() {
if ( is_customize_preview() ):
	// 変数セット
	$arr_default_color_set = keni_customize_color_set();
	foreach ($arr_default_color_set as $color_name => $arr_color) :
		${$color_name} = "";
		if ( is_array( $arr_color ) ) {
			foreach ( $arr_color as $key => $color ) {
				${$color_name} .= "color_" . ($key+1) . " = '" . $color . "';";
			}
		}
	endforeach;

	?>
	<script type="text/javascript">
		jQuery(function($){
			var color_1;
			var color_2;
			var color_3;
			var color_4;
			var color_5;
			var color_6;
			var color_7;
			wp.customize( 'keni_color_pattern', function( value ) {
				value.bind( function( to ) {
					if ( to == "turquoise" ) {
						<?php echo $turquoise; ?>
					}
					else if ( to == "bluegray") {
						<?php echo $bluegray; ?>
					}
					else if ( to == "brown") {
						<?php echo $brown; ?>
					}
					else if ( to == "lightblue") {
						<?php echo $lightblue; ?>
					}
					else if ( to == "pink") {
						<?php echo $pink; ?>
					}
					else if ( to == "red") {
						<?php echo $red; ?>
					}
					$('#customize-control-keni_color_1 .wp-color-picker').val(color_1).change();
					$('#customize-control-keni_color_2 .wp-color-picker').val(color_2).change();
					$('#customize-control-keni_color_3 .wp-color-picker').val(color_3).change();
					$('#customize-control-keni_color_4 .wp-color-picker').val(color_4).change();
					$('#customize-control-keni_color_5 .wp-color-picker').val(color_5).change();
					$('#customize-control-keni_color_6 .wp-color-picker').val(color_6).change();
					$('#customize-control-keni_color_7 .wp-color-picker').val(color_7).change();
				} );
			} );

		});
	</script>
	<?php
endif;
}
add_action('admin_print_scripts', 'keni_admin_color_script', 999);

/**
 * Color
 */
function keni_customize_colors($wp_customize) {

	// カラーパターン
	$wp_customize->add_setting('keni_color_pattern', array(
		'default' => keni_customize_color_default( 'keni_color_pattern' ),
		'transport'   => 'postMessage',
		'sanitize_callback' => "alphanumeric_symbol",
	));
	$wp_customize->add_control( 'keni_color_pattern', array(
		'settings' => 'keni_color_pattern',
		'label' => __( 'Color Pattern', 'keni' ),
		'section' => 'colors',
		'type' => 'radio',
		'choices' => array(
			'turquoise'    => __( 'Turquoise', 'keni' ),
			'bluegray'     => __( 'Bluegray', 'keni' ),
			'brown'        => __( 'Brown', 'keni' ),
			'lightblue'    => __( 'Lightblue', 'keni' ),
			'pink'         => __( 'Pink', 'keni' ),
			'red'          => __( 'Red', 'keni' ),
		),
		'priority' => 0,
	));

	// Color1
	$wp_customize->add_setting( 'keni_color_1', array(
		'default' => keni_customize_color_default( 'keni_color_1' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_1', array(
		'label' => __( 'Color 1', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_1',
		'priority' => 1,
	)));

	// Color2
	$wp_customize->add_setting( 'keni_color_2', array(
		'default' => keni_customize_color_default( 'keni_color_2' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_2', array(
		'label' => __( 'Color 2', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_2',
		'priority' => 1,
	)));

	// Color3
	$wp_customize->add_setting( 'keni_color_3', array(
		'default' => keni_customize_color_default( 'keni_color_3' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_3', array(
		'label' => __( 'Color 3', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_3',
		'priority' => 1,
	)));

	// Color4
	$wp_customize->add_setting( 'keni_color_4', array(
		'default' => keni_customize_color_default( 'keni_color_4' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_4', array(
		'label' => __( 'Color 4', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_4',
		'priority' => 1,
	)));

	// Color5
	$wp_customize->add_setting( 'keni_color_5', array(
		'default' => keni_customize_color_default( 'keni_color_5' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_5', array(
		'label' => __( 'Color 5', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_5',
		'priority' => 1,
	)));

	// Color6
	$wp_customize->add_setting( 'keni_color_6', array(
		'default' => keni_customize_color_default( 'keni_color_6' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_6', array(
		'label' => __( 'Color 6', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_6',
		'priority' => 1,
	)));

	// Color7 （サイドバー）
	$wp_customize->add_setting( 'keni_color_7', array(
		'default' => keni_customize_color_default( 'keni_color_7' ),
		'transport'   => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'keni_color_7', array(
		'label' => __( 'Sidebar Color', 'keni' ),
		'section' => 'colors',
		'settings' => 'keni_color_7',
		'priority' => 1,
	)));


}
add_action('customize_register', 'keni_customize_colors');



//-----------------------------------------------------
// category | tag
//-----------------------------------------------------
function keni_term_edit_form_fields_color( $term ) {
	$num_term_id = $term->term_id;

	if ( function_exists( "get_term_meta" ) ) {
		// wordpress 4.4.0以降
		$str_get_text_color_term = get_term_meta( $num_term_id, "keni_text_color_term", true );
		$str_get_background_color_term = get_term_meta( $num_term_id, "keni_background_color_term", true );
	}
	else {
		$str_get_text_color_term = get_option( "keni_text_color_term_" . $num_term_id );
		$str_get_background_color_term = get_option( "keni_background_color_term_" . $num_term_id );
	}

	// カテゴリー・タグ テキストカラー
	if ( empty( $str_get_text_color_term ) ) {
		$default_text_color = apply_filters( 'keni_category_txcolor_default', '#0329ce' );
		$str_get_text_color_term = $default_text_color;
	}
	// カテゴリー・タグ 背景カラー
	if ( empty( $str_get_background_color_term ) ) {
		$default_background_color = apply_filters( "keni_category_bgcolor_default", "#f0efe9" );
		$str_get_background_color_term = $default_background_color;
	}

	$str_html_text_color = keni_format_text( 'keni_term_meta[keni_text_color_term]', $str_get_text_color_term, 'wp-color-picker' );
	$str_html_background_color = keni_format_text( 'keni_term_meta[keni_background_color_term]', $str_get_background_color_term, 'wp-color-picker' );

?>
<tr>
	<th><?php _e( "Color", "keni" ); ?></th>
	<td>
		<table>
		<tbody>
			<tr>
				<td>
					<label for="keni_text_color_term"><?php _e( "Text Color", 'keni' ); ?></label>
					<?php echo $str_html_text_color ?>
					<label for="keni_background_color_term"><?php _e( "Background Color", 'keni' ); ?></label>
					<?php echo $str_html_background_color ?>
				</td>
				<td>
					<div id="label-color-sample" style="margin-left: 20px; padding: 10px;"><?php _e( "Category Name", 'keni' ); ?></div>
				</td>
			</tr>
		</tbody>
		</table>

	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'keni_term_edit_form_fields_color' );
add_action( 'post_tag_edit_form_fields', 'keni_term_edit_form_fields_color' );

function keni_term_add_form_fields_color( $term ) {

	$default_text_color = apply_filters( 'keni_category_txcolor_default', '#0329ce' );
	$str_html_text_color = keni_format_text( 'keni_term_meta[keni_text_color_term]', $default_text_color, 'wp-color-picker' );

	$default_background_color = apply_filters( "keni_category_bgcolor_default", "#f0efe9" );
	$str_html_background_color = keni_format_text( 'keni_term_meta[keni_background_color_term]', $default_background_color, 'wp-color-picker' );

?>
<div class="form-field">
	<table>
	<tbody>
	<tr>
	<td>
		<label for="keni_text_color_term"><?php _e( "Text Color", 'keni' ); ?></label>
		<?php echo $str_html_text_color ?>
		<label for="keni_background_color_term"><?php _e( "Background Color", 'keni' ); ?></label>
		<?php echo $str_html_background_color ?>
	</td>
	<td>
		<div id="label-color-sample" style="margin-left: 20px; padding: 10px;"><?php _e( "Category Name", 'keni' ); ?></div>
	</td>
	</tr>
	</tbody>
	</table>
</div>
<?php
}
add_action( 'category_add_form_fields', 'keni_term_add_form_fields_color' );
add_action( 'post_tag_add_form_fields', 'keni_term_add_form_fields_color' );

/**
 * Color Picker
 */
function keni_admin_term_color_script() {

	$screen = get_current_screen();
	$script = "";
	if ( $screen->taxonomy == 'category' || $screen->taxonomy == 'post_tag' ) {
		$script .= <<< EOM
		<script type="text/javascript">
		jQuery(function($){

			$('.wp-color-picker').wpColorPicker({
				change: function(event, ui){
					color = ui.color.toString();
					target_name = event.target.name;
					if( target_name == 'keni_term_meta[keni_text_color_term]' ) {
						$("#label-color-sample").css({color: color});
					}
					else if( target_name == 'keni_term_meta[keni_background_color_term]' ) {
						$("#label-color-sample").css({background: color});
					}
				},
			});

			$(window).load(function () {
				var text_color = $("[name='keni_term_meta[keni_text_color_term]']").val();
				var background_color = $("[name='keni_term_meta[keni_background_color_term]']").val();
				$("#label-color-sample").css({color: text_color});
				$("#label-color-sample").css({background: background_color});
			});

		});
		</script>
EOM;

		echo $script;

	}
}
add_action('admin_print_scripts', 'keni_admin_term_color_script', 999);


function keni_get_customize_color_css ($style_type = 'front') {

	$style_color_1 = get_theme_mod( 'keni_color_1' );
	$style_color_2 = get_theme_mod( 'keni_color_2' );
	$style_color_3 = get_theme_mod( 'keni_color_3' );
	$style_color_4 = get_theme_mod( 'keni_color_4' );
	$style_color_5 = get_theme_mod( 'keni_color_5' );
	$style_color_6 = get_theme_mod( 'keni_color_6' );
	$style_color_7 = get_theme_mod( 'keni_color_7' );

	if ($style_type == 'tinymce') {
	    $ret_css = "";
	    if (
	            ! empty( $style_color_1 ) ||
                ! empty( $style_color_2 ) ||
                ! empty( $style_color_3 ) ||
                ! empty( $style_color_4 ) ||
                ! empty( $style_color_5 ) ||
                ! empty( $style_color_6 ) ||
                ! empty( $style_color_7 )
        ) {
		    $ret_css .= "h1{background-size: 4px 4px;background-repeat: repeat-x;}.color01{color: {$style_color_1};}.color02{color: {$style_color_2};}.color03{color: {$style_color_3};}.color04{color: {$style_color_4};}.color05{color: {$style_color_5};}.color06{color: {$style_color_6};}.color07{color: {$style_color_7};}q{background: {$style_color_6};}table:not(.review-table) thead th{border-color: {$style_color_2};background-color: {$style_color_2};}a:hover,a:active,a:focus{color: {$style_color_1};}.keni-header_wrap{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.keni-header_cont .header-mail .btn_header{color: {$style_color_1};}.site-title > a span{color: {$style_color_1};}.keni-breadcrumb-list li a:hover,.keni-breadcrumb-list li a:active,.keni-breadcrumb-list li a:focus{color: {$style_color_1};}h1:not(.title_no-style){background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.archive_title{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}h2:not(.title_no-style){background: {$style_color_2};}.profile-box-title {background: {$style_color_2};}.keni-related-title {background: {$style_color_2};}.comments-area h2 {background: {$style_color_2};}h3:not(.title_no-style){border-top-color: {$style_color_2};border-bottom-color: {$style_color_2};color: {$style_color_1};}h4:not(.title_no-style){border-bottom-color: {$style_color_2};color: {$style_color_1};}h5:not(.title_no-style){color: {$style_color_1};}h1 a:hover,h1 a:active,h1 a:focus,h3 a:hover,h3 a:active,h3 a:focus,h4 a:hover,h4 a:active,h4 a:focus,h5 a:hover,h5 a:active,h5 a:focus,h6 a:hover,h6 a:active,h6 a:focus{color: {$style_color_1};}.sub-section_title {background: {$style_color_7};}.btn_style01{border-color: {$style_color_1};color: {$style_color_1};}.btn_style02{border-color: {$style_color_1};color: {$style_color_1};}.btn_style03{background: {$style_color_2};}.entry-list .entry_title a:hover,.entry-list .entry_title a:active,.entry-list .entry_title a:focus{color: {$style_color_1};}.ently_read-more .btn{border-color: {$style_color_1};color: {$style_color_1};}.profile-box{background-color: {$style_color_5};}.advance-billing-box_next-title{color: {$style_color_3};}.step-chart li:nth-child(2){background-color: {$style_color_4};}.step-chart_style01 li:nth-child(2)::after,.step-chart_style02 li:nth-child(2)::after{border-top-color: {$style_color_4};}.step-chart li:nth-child(3){background-color: {$style_color_3};}.step-chart_style01 li:nth-child(3)::after,.step-chart_style02 li:nth-child(3)::after{border-top-color: {$style_color_3};}.step-chart li:nth-child(4){background-color: {$style_color_2};}.step-chart_style01 li:nth-child(4)::after,.step-chart_style02 li:nth-child(4)::after{border-top-color: {$style_color_2};}.toc-area_inner .toc-area_list > li::before{background: {$style_color_2};}.toc_title{color: {$style_color_1};}.list_style02 li::before{background: {$style_color_2};}.dl_style02 dt{background: {$style_color_2};}.dl_style02 dd{background: {$style_color_4};}.accordion-list dt{background: {$style_color_2};}.ranking-list .review_desc_title{color: {$style_color_1};}.review_desc{background-color: {$style_color_5};}.item-box .item-box_title{color: {$style_color_1};}.item-box02{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.item-box02 .item-box_inner{background-color: {$style_color_5};}.item-box02 .item-box_title{background-color: {$style_color_2};}.item-box03 .item-box_title{background-color: {$style_color_2};}.box_style01{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.box_style01 .box_inner{background-color: {$style_color_5};}.box_style03{background: {$style_color_5};}.box_style06{background-color: {$style_color_5};}.cast-box{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.cast-box .cast_name,.cast-box_sub .cast_name{color: {$style_color_1};}.widget .cast-box_sub .cast-box_sub_title{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.voice_styl02{background-color: {$style_color_5};}.voice_styl03{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_5} 25%, {$style_color_5} 50%,#fff 50%, #fff 75%,{$style_color_5} 75%, {$style_color_5});}.voice-box .voice_title{color: {$style_color_1};}.chat_style02 .bubble{background-color: {$style_color_2};}.chat_style02 .bubble .bubble_in{border-color: {$style_color_2};}.related-entry-list .related-entry_title a:hover,.related-entry-list .related-entry_title a:active,.related-entry-list .related-entry_title a:focus{color: {$style_color_1};}.interval01 span{background-color: {$style_color_2};}.interval02 span{background-color: {$style_color_2};}.page-nav .current,.page-nav li a:hover,.page-nav li a:active,.page-nav li a:focus{background: {$style_color_2};}.page-nav-bf .page-nav_next:hover,.page-nav-bf .page-nav_next:active,.page-nav-bf .page-nav_next:focus,.page-nav-bf .page-nav_prev:hover,.page-nav-bf .page-nav_prev:active,.page-nav-bf .page-nav_prev:focus{color: {$style_color_1};}.nav-links .nav-next a:hover, .nav-links .nav-next a:active, .nav-links .nav-next a:focus, .nav-links .nav-previous a:hover, .nav-links .nav-previous a:active, .nav-links .nav-previous a:focus {color: {$style_color_1},text-decoration: 'underline' }.commentary-box .commentary-box_title{color: {$style_color_2};}.calendar tfoot td a:hover,.calendar tfoot td a:active,.calendar tfoot td a:focus{color: {$style_color_1};}.form-mailmaga .form-mailmaga_title{color: {$style_color_2};}.form-login .form-login_title{color: {$style_color_2};}.form-login-item .form-login_title{color: {$style_color_2};}.contact-box{background-image: linear-gradient(-45deg,#fff 25%, {$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.contact-box_inner{background-color: {$style_color_5};}.contact-box .contact-box-title{background-color: {$style_color_2};}.contact-box_tel{color: {$style_color_1};}.widget_recent_entries ul li a:hover,.widget_recent_entries ul li a:active,.widget_recent_entries ul li a:focus,.widget_archive > ul li a:hover,.widget_archive > ul li a:active,.widget_archive > ul li a:focus,.widget_categories > ul li a:hover,.widget_categories > ul li a:active,.widget_categories > ul li a:focus{color: {$style_color_1};}.tagcloud a::before{color: {$style_color_1};}.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:hover,.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:active,.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:focus{color: {$style_color_1};}.keni-link-card_title a:hover,.keni-link-card_title a:active,.keni-link-card_title a:focus{color: {$style_color_1};}@media (min-width : 768px){.keni-gnav_inner li a:hover,.keni-gnav_inner li a:active,.keni-gnav_inner li a:focus{border-bottom-color: {$style_color_2};}.step-chart_style02 li:nth-child(2)::after{border-left-color: {$style_color_4};}.step-chart_style02 li:nth-child(3)::after{border-left-color: {$style_color_3};}.step-chart_style02 li:nth-child(4)::after{border-left-color: {$style_color_2};}.col1 .contact-box_tel{color: {$style_color_1};}.step-chart_style02 li:nth-child(1)::after,.step-chart_style02 li:nth-child(2)::after,.step-chart_style02 li:nth-child(3)::after,.step-chart_style02 li:nth-child(4)::after{border-top-color: transparent;}}@media (min-width : 920px){.contact-box_tel{color: {$style_color_1};}}";
	    }
		return $ret_css;
	} else {
		$ret_css = "";
		if (
			! empty( $style_color_1 ) ||
			! empty( $style_color_2 ) ||
			! empty( $style_color_3 ) ||
			! empty( $style_color_4 ) ||
			! empty( $style_color_5 ) ||
			! empty( $style_color_6 ) ||
			! empty( $style_color_7 )
		) {

			$ret_css .= ".color01{color: {$style_color_1};}.color02{color: {$style_color_2};}.color03{color: {$style_color_3};}.color04{color: {$style_color_4};}.color05{color: {$style_color_5};}.color06{color: {$style_color_6};}.color07{color: {$style_color_7};}q{background: {$style_color_6};}table:not(.review-table) thead th{border-color: {$style_color_2};background-color: {$style_color_2};}a:hover,a:active,a:focus{color: {$style_color_1};}.keni-header_wrap{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.keni-header_cont .header-mail .btn_header{color: {$style_color_1};}.site-title > a span{color: {$style_color_1};}.keni-breadcrumb-list li a:hover,.keni-breadcrumb-list li a:active,.keni-breadcrumb-list li a:focus{color: {$style_color_1};}.keni-section h1:not(.title_no-style){background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.archive_title{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});} h2:not(.title_no-style){background: {$style_color_2};}.profile-box-title {background: {$style_color_2};}.keni-related-title {background: {$style_color_2};}.comments-area h2 {background: {$style_color_2};}h3:not(.title_no-style){border-top-color: {$style_color_2};border-bottom-color: {$style_color_2};color: {$style_color_1};}h4:not(.title_no-style){border-bottom-color: {$style_color_2};color: {$style_color_1};}h5:not(.title_no-style){color: {$style_color_1};}.keni-section h1 a:hover,.keni-section h1 a:active,.keni-section h1 a:focus,.keni-section h3 a:hover,.keni-section h3 a:active,.keni-section h3 a:focus,.keni-section h4 a:hover,.keni-section h4 a:active,.keni-section h4 a:focus,.keni-section h5 a:hover,.keni-section h5 a:active,.keni-section h5 a:focus,.keni-section h6 a:hover,.keni-section h6 a:active,.keni-section h6 a:focus{color: {$style_color_1};}.keni-section .sub-section_title {background: {$style_color_7};}.btn_style01{border-color: {$style_color_1};color: {$style_color_1};}.btn_style02{border-color: {$style_color_1};color: {$style_color_1};}.btn_style03{background: {$style_color_2};}.entry-list .entry_title a:hover,.entry-list .entry_title a:active,.entry-list .entry_title a:focus{color: {$style_color_1};}.ently_read-more .btn{border-color: {$style_color_1};color: {$style_color_1};}.profile-box{background-color: {$style_color_5};}.advance-billing-box_next-title{color: {$style_color_3};}.step-chart li:nth-child(2){background-color: {$style_color_4};}.step-chart_style01 li:nth-child(2)::after,.step-chart_style02 li:nth-child(2)::after{border-top-color: {$style_color_4};}.step-chart li:nth-child(3){background-color: {$style_color_3};}.step-chart_style01 li:nth-child(3)::after,.step-chart_style02 li:nth-child(3)::after{border-top-color: {$style_color_3};}.step-chart li:nth-child(4){background-color: {$style_color_2};}.step-chart_style01 li:nth-child(4)::after,.step-chart_style02 li:nth-child(4)::after{border-top-color: {$style_color_2};}.toc-area_inner .toc-area_list > li::before{background: {$style_color_2};}.toc_title{color: {$style_color_1};}.list_style02 li::before{background: {$style_color_2};}.dl_style02 dt{background: {$style_color_2};}.dl_style02 dd{background: {$style_color_4};}.accordion-list dt{background: {$style_color_2};}.ranking-list .review_desc_title{color: {$style_color_1};}.review_desc{background-color: {$style_color_5};}.item-box .item-box_title{color: {$style_color_1};}.item-box02{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.item-box02 .item-box_inner{background-color: {$style_color_5};}.item-box02 .item-box_title{background-color: {$style_color_2};}.item-box03 .item-box_title{background-color: {$style_color_2};}.box_style01{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.box_style01 .box_inner{background-color: {$style_color_5};}.box_style03{background: {$style_color_5};}.box_style06{background-color: {$style_color_5};}.cast-box{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.cast-box .cast_name,.cast-box_sub .cast_name{color: {$style_color_1};}.widget .cast-box_sub .cast-box_sub_title{background-image: linear-gradient(-45deg,{$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.voice_styl02{background-color: {$style_color_5};}.voice_styl03{background-image: linear-gradient(-45deg,#fff 25%,{$style_color_5} 25%, {$style_color_5} 50%,#fff 50%, #fff 75%,{$style_color_5} 75%, {$style_color_5});}.voice-box .voice_title{color: {$style_color_1};}.chat_style02 .bubble{background-color: {$style_color_2};}.chat_style02 .bubble .bubble_in{border-color: {$style_color_2};}.related-entry-list .related-entry_title a:hover,.related-entry-list .related-entry_title a:active,.related-entry-list .related-entry_title a:focus{color: {$style_color_1};}.interval01 span{background-color: {$style_color_2};}.interval02 span{background-color: {$style_color_2};}.page-nav .current,.page-nav li a:hover,.page-nav li a:active,.page-nav li a:focus{background: {$style_color_2};}.page-nav-bf .page-nav_next:hover,.page-nav-bf .page-nav_next:active,.page-nav-bf .page-nav_next:focus,.page-nav-bf .page-nav_prev:hover,.page-nav-bf .page-nav_prev:active,.page-nav-bf .page-nav_prev:focus{color: {$style_color_1};}.nav-links .nav-next a:hover, .nav-links .nav-next a:active, .nav-links .nav-next a:focus, .nav-links .nav-previous a:hover, .nav-links .nav-previous a:active, .nav-links .nav-previous a:focus {color: {$style_color_1}; text-decoration: 'underline'; }.commentary-box .commentary-box_title{color: {$style_color_2};}.calendar tfoot td a:hover,.calendar tfoot td a:active,.calendar tfoot td a:focus{color: {$style_color_1};}.form-mailmaga .form-mailmaga_title{color: {$style_color_2};}.form-login .form-login_title{color: {$style_color_2};}.form-login-item .form-login_title{color: {$style_color_2};}.contact-box{background-image: linear-gradient(-45deg,#fff 25%, {$style_color_2} 25%, {$style_color_2} 50%,#fff 50%, #fff 75%,{$style_color_2} 75%, {$style_color_2});}.contact-box_inner{background-color: {$style_color_5};}.contact-box .contact-box-title{background-color: {$style_color_2};}.contact-box_tel{color: {$style_color_1};}.widget_recent_entries .keni-section ul li a:hover,.widget_recent_entries .keni-section ul li a:active,.widget_recent_entries .keni-section ul li a:focus,.widget_archive .keni-section > ul li a:hover,.widget_archive .keni-section > ul li a:active,.widget_archive .keni-section > ul li a:focus,.widget_categories .keni-section > ul li a:hover,.widget_categories .keni-section > ul li a:active,.widget_categories .keni-section > ul li a:focus{color: {$style_color_1};}.tagcloud a::before{color: {$style_color_1};}.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:hover,.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:active,.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:focus{color: {$style_color_1};}.keni-link-card_title a:hover,.keni-link-card_title a:active,.keni-link-card_title a:focus{color: {$style_color_1};}@media (min-width : 768px){.keni-gnav_inner li a:hover,.keni-gnav_inner li a:active,.keni-gnav_inner li a:focus{border-bottom-color: {$style_color_2};}.step-chart_style02 li:nth-child(2)::after{border-left-color: {$style_color_4};}.step-chart_style02 li:nth-child(3)::after{border-left-color: {$style_color_3};}.step-chart_style02 li:nth-child(4)::after{border-left-color: {$style_color_2};}.col1 .contact-box_tel{color: {$style_color_1};}.step-chart_style02 li:nth-child(1)::after,.step-chart_style02 li:nth-child(2)::after,.step-chart_style02 li:nth-child(3)::after,.step-chart_style02 li:nth-child(4)::after{border-top-color: transparent;}}@media (min-width : 920px){.contact-box_tel{color: {$style_color_1};}}";
		}
		return $ret_css;
	}
}


//-----------------------------------------------------
// Head color style
//-----------------------------------------------------
function keni_customize_color_css() {
	$flag_keni_disabled_customize_color_css = (int) get_option( 'keni_disabled_customize_color_css', 0 );
	if ( $flag_keni_disabled_customize_color_css === 1 ){ return false; }
	echo '<style type="text/css">';
	echo keni_get_customize_color_css();
	echo '</style>';
}

function keni_customize_color_css_origin()
{

    ob_start();

//	 <style type="text/css">
	?>
		/*基本色1*/
		.color01{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}

		/*基本色2*/
		.color02{
			color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}

		/*基本色3*/
		.color03{
			color: <?php echo get_theme_mod( 'keni_color_3' ); ?>;
		}

		/*基本色4*/
		.color04{
			color: <?php echo get_theme_mod( 'keni_color_4' ); ?>;
		}

		/*基本色5*/
		.color05{
			color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}

		/*基本色6*/
		.color06{
			color: <?php echo get_theme_mod( 'keni_color_6' ); ?>;
		}
		/*基本色7*/
		.color07{
			color: <?php echo get_theme_mod( 'keni_color_7' ); ?>;
		}

		<?php // line:134 ?>
		q{
			background: <?php echo get_theme_mod( 'keni_color_6' ); ?>;
		}
		<?php // line:313 ?>
		table:not(.review-table) thead th{
			border-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:474 ?>
		a:hover,
		a:active,
		a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:599 ?>
		.keni-header_wrap{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:632 ?>
		.keni-header_cont .header-mail .btn_header{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:661 ?>
		.site-title > a span{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1161 ?>
		.keni-breadcrumb-list li a:hover,
		.keni-breadcrumb-list li a:active,
		.keni-breadcrumb-list li a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1207 ?>
		.keni-section h1:not(.title_no-style){
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:1229 ?>
		.archive_title{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:1246 ?>
		.article-body h2:not(.title_no-style){
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		.profile-box-title {
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		.keni-related-title {
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		.comments-area h2 {
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:1259 ?>
		.article-body h3:not(.title_no-style){
			border-top-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			border-bottom-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1273 ?>
		.article-body h4:not(.title_no-style){
			border-bottom-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1285 ?>
		.article-body h5:not(.title_no-style){
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1323 ?>
		.keni-section h1 a:hover,
		.keni-section h1 a:active,
		.keni-section h1 a:focus,
		.keni-section h3 a:hover,
		.keni-section h3 a:active,
		.keni-section h3 a:focus,
		.keni-section h4 a:hover,
		.keni-section h4 a:active,
		.keni-section h4 a:focus,
		.keni-section h5 a:hover,
		.keni-section h5 a:active,
		.keni-section h5 a:focus,
		.keni-section h6 a:hover,
		.keni-section h6 a:active,
		.keni-section h6 a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1383 ?>
		.keni-section .sub-section_title {
			background: <?php echo get_theme_mod( 'keni_color_7' ); ?>;
		}
		<?php // line:1479 ?>
		.btn_style01{
			border-color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1486 ?>
		.btn_style02{
			border-color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1493 ?>
		.btn_style03{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:1634 ?>
		.entry-list .entry_title a:hover,
		.entry-list .entry_title a:active,
		.entry-list .entry_title a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1645 ?>
		.ently_read-more .btn{
			border-color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1693 ?>
		.profile-box{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:1738 ?>
		.advance-billing-box_next-title{
			color: <?php echo get_theme_mod( 'keni_color_3' ); ?>;
		}
		<?php // line:1804 ?>
		.step-chart li:nth-child(2){
			background-color: <?php echo get_theme_mod( 'keni_color_4' ); ?>;
		}
		<?php // line:1809 ?>
		.step-chart_style01 li:nth-child(2)::after,
		.step-chart_style02 li:nth-child(2)::after{
			border-top-color: <?php echo get_theme_mod( 'keni_color_4' ); ?>;
		}
		<?php // line:1814 ?>
		.step-chart li:nth-child(3){
			background-color: <?php echo get_theme_mod( 'keni_color_3' ); ?>;
		}
		<?php // line:1819 ?>
		.step-chart_style01 li:nth-child(3)::after,
		.step-chart_style02 li:nth-child(3)::after{
			border-top-color: <?php echo get_theme_mod( 'keni_color_3' ); ?>;
		}
		<?php // line:1824 ?>
		.step-chart li:nth-child(4){
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:1830 ?>
		.step-chart_style01 li:nth-child(4)::after,
		.step-chart_style02 li:nth-child(4)::after{
			border-top-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:1879 ?>
		.toc-area_inner .toc-area_list > li::before{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}

		<?php // line:1908 ?>
		.toc_title{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:1962 ?>
		.list_style02 li::before{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:2038 ?>
		.dl_style02 dt{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:2045 ?>
		.dl_style02 dd{
			background: <?php echo get_theme_mod( 'keni_color_4' ); ?>;
		}
		<?php // line:2099 ?>
		.accordion-list dt{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:2258 ?>
		.ranking-list .review_desc_title{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:2386 ?>
		.review_desc{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2442 ?>
		.item-box .item-box_title{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:2463 ?>
		.item-box02{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:2477 ?>
		.item-box02 .item-box_inner{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2483 ?>
		.item-box02 .item-box_title{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:2514 ?>
		.item-box03 .item-box_title{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:2562 ?>
		.box_style01{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:2575 ?>
		.box_style01 .box_inner{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2602 ?>
		.box_style03{
			background: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2620 ?>
		.box_style06{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2808 ?>
		.cast-box{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:2840 ?>
		.cast-box .cast_name,
		.cast-box_sub .cast_name{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:2894 ?>
		.widget .cast-box_sub .cast-box_sub_title{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:2929 ?>
		.voice_styl02{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:2933 ?>
		.voice_styl03{
			background-image: linear-gradient(
				-45deg,
				<?php echo get_theme_mod( 'keni_color_5' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_5' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_5' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_5' ); ?>
			);
		}
		<?php // line:2958 ?>
		.voice-box .voice_title{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:3133 ?>
		.chat_style02 .bubble{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:3140 ?>
		.chat_style02 .bubble .bubble_in{
			border-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}

		<?php // line:3297 ?>
		.related-entry-list .related-entry_title a:hover,
		.related-entry-list .related-entry_title a:active,
		.related-entry-list .related-entry_title a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:3406 ?>
		.interval01 span{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:3416 ?>
		.interval02 span{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:3518 ?>
		.page-nav .current,
		.page-nav li a:hover,
		.page-nav li a:active,
		.page-nav li a:focus{
			background: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:3597 ?>
		.page-nav-bf .page-nav_next:hover,
		.page-nav-bf .page-nav_next:active,
		.page-nav-bf .page-nav_next:focus,
		.page-nav-bf .page-nav_prev:hover,
		.page-nav-bf .page-nav_prev:active,
		.page-nav-bf .page-nav_prev:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:3733 ?>
		.commentary-box .commentary-box_title{
			color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:3881 ?>
		.calendar tfoot td a:hover,
		.calendar tfoot td a:active,
		.calendar tfoot td a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:4264 ?>
		.form-mailmaga .form-mailmaga_title{
			color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:4293 ?>
		.form-login .form-login_title{
			color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:4307 ?>
		.form-login-item .form-login_title{
			color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:4426 ?>
		.contact-box{
			background-image: linear-gradient(
				-45deg,
				#fff 25%, 
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 25%, <?php echo get_theme_mod( 'keni_color_2' ); ?> 50%,
				#fff 50%, #fff 75%,
				<?php echo get_theme_mod( 'keni_color_2' ); ?> 75%, <?php echo get_theme_mod( 'keni_color_2' ); ?>
			);
		}
		<?php // line:4439 ?>
		.contact-box_inner{
			background-color: <?php echo get_theme_mod( 'keni_color_5' ); ?>;
		}
		<?php // line:4445 ?>
		.contact-box .contact-box-title{
			background-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
		}
		<?php // line:4490 ?>
		.contact-box_tel{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:4680 ?>
		.widget_recent_entries .keni-section ul li a:hover,
		.widget_recent_entries .keni-section ul li a:active,
		.widget_recent_entries .keni-section ul li a:focus,
		.widget_archive .keni-section > ul li a:hover,
		.widget_archive .keni-section > ul li a:active,
		.widget_archive .keni-section > ul li a:focus,
		.widget_categories .keni-section > ul li a:hover,
		.widget_categories .keni-section > ul li a:active,
		.widget_categories .keni-section > ul li a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:4766 ?>
		.tagcloud a::before{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:4841 ?>
		.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:hover,
		.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:active,
		.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		<?php // line:5159 ?>
		.keni-link-card_title a:hover,
		.keni-link-card_title a:active,
		.keni-link-card_title a:focus{
			color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
		}
		@media (min-width : 768px){
			<?php // line:5916 ?>
			.keni-gnav_inner li a:hover,
			.keni-gnav_inner li a:active,
			.keni-gnav_inner li a:focus{
				border-bottom-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			}
			<?php // line:6095 ?>
			.step-chart_style02 li:nth-child(2)::after{
				border-left-color: <?php echo get_theme_mod( 'keni_color_4' ); ?>;
			}
			<?php // line:6099 ?>
			.step-chart_style02 li:nth-child(3)::after{
				border-left-color: <?php echo get_theme_mod( 'keni_color_3' ); ?>;
			}
			<?php // line:6103 ?>
			.step-chart_style02 li:nth-child(4)::after{
				border-left-color: <?php echo get_theme_mod( 'keni_color_2' ); ?>;
			}
			<?php // line:6333 ?>
			.col1 .contact-box_tel{
				color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
			}
		}/*横幅768px以上*/
		@media (min-width : 920px){
			<?php // line:6690 ?>
			.contact-box_tel{
				color: <?php echo get_theme_mod( 'keni_color_1' ); ?>;
			}
		}/*横幅920px以上*/

	<?php
    //		 </style>

    $style_str = ob_get_contents();
    ob_end_clean();

	// 賢威の設定で圧縮する設定を参照し処理を切り替え
	$keni_minify_flg = (int)get_option( 'keni_minify_flg', 0 );
	$keni_minify_flg = apply_filters( 'keni_minify_flg_hook', $keni_minify_flg );
	if ( $keni_minify_flg != 1 ) {
		wp_add_inline_style( 'my-keni_base', $style_str );
	} else {
		wp_add_inline_style( 'keni_minify_css', $style_str );
	}
}
add_action( 'wp_enqueue_scripts', 'keni_customize_color_css', 11 );

