jQuery.noConflict();
(function($) {
	var view_outline = "";
	var targetArea = $('.article-body');
	var top_indent = 0;
	var before_indent = 0;
	var firstFlg = true;
	targetArea.children(':header').each(function(i){
		var indent = $(this).prop("tagName").match(/h(\d+)/i);
		if (top_indent == 0 || top_indent > indent[1]) top_indent =  indent[1];
	});

	targetArea.children(':header').each(function(i){
		var text = $(this).text();
		var target_id = $(this).attr('id');
		var target_tag = $(this).prop("tagName");	
		if (!target_id) target_id = 'keni-toc' + i
		$(this).attr('id',target_id);
		var indent = target_tag.match(/h(\d+)/i);

		if (before_indent != indent[1]) {
			if (before_indent < indent[1]) {
				if (firstFlg) {
					firstFlg = false;
				} else {
					view_outline = view_outline + '<ol>\n';	
				}
			} else if (before_indent > indent[1]) {
				for (i = indent[1]; i < before_indent; i++) {
					view_outline = view_outline + '</li>\n';
					view_outline = view_outline + '</ol>\n';
				}
			} else {
				view_outline = view_outline + '</li>\n';
			}
		} else {
			view_outline = view_outline + '</li>\n';
		}

		view_outline = view_outline + '<li><a href="#'+target_id+'">'+ text+'</a>';

		before_indent = indent[1];
	});

	if (view_outline != "") {
		if (targetArea.find('#keni_toc').length == 0) jQuery(jQuery('.article-body h2:first')).before('<div id="keni_toc"></div>');
		$("#keni_toc").addClass('toc-area');

		var input_toc_title = $('#keni_toc').attr('title');

		if (input_toc_title == null){
			input_toc_title = '目次';
		}

		var style_display = '';
		var is_close = $('#keni_toc').attr('closed');
		var class_toc_area_btn = 'toc-area_btn_close';

		if ( is_close == 'true' ) {
			class_toc_area_btn = 'toc-area_btn_open';
			style_display = 'style="display: none;"';
		}

		$("#keni_toc").html('<div class="toc-area_inner"><div class="toc_title">' + input_toc_title + '</div><span class="toc-area_btn ' + class_toc_area_btn + '"></span><ol class="toc-area_list" ' + style_display + '>' + view_outline + '</ol></div>');
	}

})(jQuery);

