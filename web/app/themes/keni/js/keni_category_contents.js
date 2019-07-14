jQuery(function () {
    jQuery('#addtag').on('mousedown', '#submit', function () {
        tinyMCE.triggerSave();
        var set_class = jQuery("#wp-keni_page_contents_term-wrap").attr('class');
        if (set_class.match(/tmce-active/)) {
            var content_iframe = jQuery('#keni_page_contents_term_ifr').contents().find('body').html();
            jQuery('#keni_page_contents_term').val(content_iframe);
            jQuery('#keni_page_contents_term_ifr').contents().find('body').html('');
        }
		tinyMCE.activeEditor.setContent('');
    });
});
