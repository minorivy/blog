/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	var keni_color_1;
	var keni_color_2;
	var keni_color_3;
	var keni_color_4;
	var keni_color_5;
	var keni_color_6;
	var keni_color_7;
	wp.customize( 'keni_color_1', function( value ) {
		value.bind( function( to ) {
			keni_color_1 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_2', function( value ) {
		value.bind( function( to ) {
			keni_color_2 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_3', function( value ) {
		value.bind( function( to ) {
			keni_color_3 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_4', function( value ) {
		value.bind( function( to ) {
			keni_color_4 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_5', function( value ) {
		value.bind( function( to ) {
			keni_color_5 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_6', function( value ) {
		value.bind( function( to ) {
			keni_color_6 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );
	wp.customize( 'keni_color_7', function( value ) {
		value.bind( function( to ) {
			keni_color_7 = to;
			keni_color_preview();
			keni_color_pseudo_elements_preview();
		} );
	} );

	// 疑似要素
	function keni_color_pseudo_elements_preview() {

		var keniCustomizeMainColorCss = '';
		var keniCustomizeMainColorTag = '<style type="text/css" id="keni-customize-main-color">'+keniCustomizeMainColorCss+'</style>';

		keniCustomizeMainColorCss += '.list_style02 li::before{background: '+keni_color_2+';}';

		if ($('style#keni-customize-main-color').size()) {
			$("style#keni-customize-main-color").html(keniCustomizeMainColorCss);
		} else {
			$("head").append(keniCustomizeMainColorTag);
		}
	}

	function keni_color_preview() {
		$('.color01').css( {'color': keni_color_1 } );
		$('.color02').css( {'color': keni_color_2 } );
		$('.color03').css( {'color': keni_color_3 } );
		$('.color04').css( {'color': keni_color_4 } );
		$('.color05').css( {'color': keni_color_5 } );
		$('.color06').css( {'color': keni_color_6 } );
		$('q').css( { 'background': keni_color_6 } );
		$('table:not(.review-table) thead th').css( { 'border-color': keni_color_2, 'background-color': keni_color_2 } );
		$('a:hover, a:active, a:focus').css( { 'color': keni_color_1 } );
		$('.keni-header_wrap').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%,' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.keni-header_cont .header-mail .btn_header').css( { 'color': keni_color_1 } );
		$('.site-title > a span').css( { 'color': keni_color_1 } );
		$('.keni-breadcrumb-list li a:hover, .keni-breadcrumb-list li a:active, .keni-breadcrumb-list li a:focus').css( { 'color': keni_color_1 } );
		$('.keni-section h1:not(.title_no-style)').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.archive_title').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('h2').not('.title_no-style, .entry_title').css( { 'background': keni_color_2 } );
		$('.profile-box-title').css( { 'background': keni_color_2 } );
		$('.keni-related-title').css( { 'background': keni_color_2 } );
		$('.comments-area h2').css( { 'background': keni_color_2 } );
		$('h3').not('.title_no-style ,.sub-section_title').css( { 'border-top-color': keni_color_2, 'border-bottom-color': keni_color_2, 'color': keni_color_1 } );
		$('h4:not(.title_no-style)').css( { 'border-bottom-color': keni_color_2, 'color': keni_color_1 } );
		$('h5:not(.title_no-style)').css( { 'color': keni_color_1 } );
		$('.keni-section h1 a:hover, .keni-section h1 a:active, .keni-section h1 a:focus, .keni-section h3 a:hover, .keni-section h3 a:active, .keni-section h3 a:focus, .keni-section h4 a:hover, .keni-section h4 a:active, .keni-section h4 a:focus, .keni-section h5 a:hover, .keni-section h5 a:active, .keni-section h5 a:focus, .keni-section h6 a:hover, .keni-section h6 a:active, .keni-section h6 a:focus').css( { 'color': keni_color_1 } );
		$('.keni-section .sub-section_title').css( { 'background': keni_color_7 } );
		$('.btn_style01').css( { 'border-color': keni_color_1, 'color': keni_color_1 } );
		$('.btn_style02').css( { 'border-color': keni_color_1, 'color': keni_color_1 } );
		$('.btn_style03').css( { 'background': keni_color_2 } );
		$('.entry-list .entry_title a:hover, .entry-list .entry_title a:active, .entry-list .entry_title a:focus').css( { 'color': keni_color_1 } );
		$('.ently_read-more .btn').css( { 'border-color': keni_color_1, 'color': keni_color_1 } );
		$('.profile-box').css( { 'background-color': keni_color_5 } );
		$('.advance-billing-box_next-title').css( { 'color': keni_color_3 } );
		$('.step-chart li:nth-child(2)').css( { 'background-color': keni_color_4 } );
		$('.step-chart_style01 li:nth-child(2)::after, .step-chart_style02 li:nth-child(2)::after').css( { 'border-top-color': keni_color_4 } );
		$('.step-chart li:nth-child(3)').css( { 'background-color': keni_color_3 } );
		$('.step-chart_style01 li:nth-child(3)::after, .step-chart_style02 li:nth-child(3)::after').css( { 'border-top-color': keni_color_3 } );
		$('.step-chart li:nth-child(4)').css( { 'background-color': keni_color_2 } );
		$('.step-chart_style01 li:nth-child(4)::after, .step-chart_style02 li:nth-child(4)::after').css( { 'border-top-color': keni_color_2 } );
		$('.toc-area_inner .toc-area_list > li::before').css( { 'background': keni_color_2 } );
		$('.toc_title').css( { 'color': keni_color_1 } );
		$('.dl_style02 dt').css( { 'background': keni_color_2 } );
		$('.dl_style02 dd').css( { 'background': keni_color_4 } );
		$('.accordion-list dt').css( { 'background': keni_color_2 } );
		$('.ranking-list .review_desc_title').css( { 'color': keni_color_1 } );
		$('.review_desc').css( { 'background-color': keni_color_5 } );
		$('.item-box .item-box_title').css( { 'color': keni_color_1 } );
		$('.item-box02').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.item-box02 .item-box_inner').css( { 'background-color': keni_color_5 } );
		$('.item-box02 .item-box_title').css( { 'background-color': keni_color_2 } );
		$('.item-box03 .item-box_title').css( { 'background-color': keni_color_2 } );
		$('.box_style01').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.box_style01 .box_inner').css( { 'background-color': keni_color_5 } );
		$('.box_style03').css( { 'background': keni_color_5 } );
		$('.box_style06').css( { 'background-color': keni_color_5 } );
		$('.cast-box').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.cast-box .cast_name, .cast-box_sub .cast_name').css( { 'color': keni_color_1 } );
		$('.widget .cast-box_sub .cast-box_sub_title').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 + ')' } );
		$('.voice_styl02').css( { 'background-color': keni_color_5 } );
		$('.voice_styl03').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_5 + ' 25%, ' + keni_color_5 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_5 + ' 75%, ' + keni_color_5 + ')' } );
		$('.voice-box .voice_title').css( { 'color': keni_color_1 } );
		$('.chat_style02 .bubble').css( { 'background-color': keni_color_2 } );
		$('.chat_style02 .bubble .bubble_in').css( { 'border-color': keni_color_2 } );
		$('.related-entry-list .related-entry_title a:hover, .related-entry-list .related-entry_title a:active, .related-entry-list .related-entry_title a:focus').css( { 'color': keni_color_1 } );
		$('.interval01 span').css( { 'background-color': keni_color_2 } );
		$('.interval02 span').css( { 'background-color': keni_color_2 } );
		$('.page-nav .current, .page-nav li a:hover, .page-nav li a:active, .page-nav li a:focus').css( { 'background': keni_color_2 } );
		$('.page-nav-bf .page-nav_next:hover, .page-nav-bf .page-nav_next:active, .page-nav-bf .page-nav_next:focus, .page-nav-bf .page-nav_prev:hover, .page-nav-bf .page-nav_prev:active, .page-nav-bf .page-nav_prev:focus').css( { 'color': keni_color_1 } );
		$('.nav-links .nav-next a:hover, .nav-links .nav-next a:active, .nav-links .nav-next a:focus, .nav-links .nav-previous a:hover, .nav-links .nav-previous a:active, .nav-links .nav-previous a:focus'). css( { 'color': keni_color_1, 'text-decoration': 'underline' } );
		$('.commentary-box .commentary-box_title').css( { 'color': keni_color_2 } );
		$('.calendar tfoot td a:hover, .calendar tfoot td a:active, .calendar tfoot td a:focus').css( { 'color': keni_color_1 } );
		$('.form-mailmaga .form-mailmaga_title').css( { 'color': keni_color_2 } );
		$('.form-login .form-login_title').css( { 'color': keni_color_2 } );
		$('.form-login-item .form-login_title').css( { 'color': keni_color_2 } );
		$('.contact-box').css( { 'background-image': 'linear-gradient( -45deg, #fff 25%, ' + keni_color_2 + ' 25%, ' + keni_color_2 + ' 50%, #fff 50%, #fff 75%, ' + keni_color_2 + ' 75%, ' + keni_color_2 } );
		$('.contact-box_inner').css( { 'background-color': keni_color_5 } );
		$('.contact-box .contact-box-title').css( { 'background-color': keni_color_2 } );
		$('.contact-box_tel').css( { 'color': keni_color_1 } );
		$('.widget_recent_entries .keni-section ul li a:hover, .widget_recent_entries .keni-section ul li a:active, .widget_recent_entries .keni-section ul li a:focus, .widget_archive .keni-section > ul li a:hover, .widget_archive .keni-section > ul li a:active, .widget_archive .keni-section > ul li a:focus, .widget_categories .keni-section > ul li a:hover, .widget_categories .keni-section > ul li a:active, .widget_categories .keni-section > ul li a:focus').css( { 'color': keni_color_1 } );
		$('.tagcloud a::before').css( { 'color': keni_color_1 } );
		$('.widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:hover, .widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:active, .widget_recent_entries_img .list_widget_recent_entries_img .widget_recent_entries_img_entry_title a:focus').css( { 'color': keni_color_1 } );
		$('.keni-link-card_title a:hover, .keni-link-card_title a:active, .keni-link-card_title a:focus').css( { 'color': keni_color_1 } );

		if (window.innerWidth > 768) {
			$('.keni-gnav_inner li a:hover, .keni-gnav_inner li a:active, .keni-gnav_inner li a:focus').css( { 'border-bottom-color': keni_color_2 } );
			$('.step-chart_style02 li:nth-child(2)::after').css( { 'border-left-color': keni_color_4 } );
			$('.step-chart_style02 li:nth-child(3)::after').css( { 'border-left-color': keni_color_3 } );
			$('.step-chart_style02 li:nth-child(4)::after').css( { 'border-left-color': keni_color_2 } );
			$('.col1 .contact-box_tel').css( { 'color': keni_color_1 } );
		}
		if (window.innerWidth > 920) {
			$('.contact-box_tel').css( { 'color': keni_color_1 } );
		}

	}

} )( jQuery );
