jQuery.noConflict();
(function($) {
	$(function() {
		$('input[name="post_category[]"]').on('change', function() {
			var radio = createPrimaryCategoryRadioArea();

			if (radio != null ) {
				there_str = $('#primary_category_area .inside');
				if ( there_str.has('p') ) {
					there_str.find('p').remove();
				}

				$('#primary_category_area .inside').html(there_str.html()+"<p>"+radio+"</p>");
			}
		})
	});
	
	function createPrimaryCategoryRadioArea() {
		var radio = '';
		var primary_category = $('input[name="keni_primary_category_post"]:checked').val();
		var cat_counts = $('input[name="post_category[]"]:checked').length;
		if (cat_counts > 0) {
			var alive = 'n';
			$('input[name="post_category[]"]:checked').map(function() {
				if ($(this).val() == primary_category) alive = 'y';
			})

			$('input[name="post_category[]"]:checked').map(function() {
				if ($(this).val() == primary_category || alive == "n") {
					radio += '<label><input type="radio" name="keni_primary_category_post" value="'+$(this).val()+'" checked="checked">'+$(this).parent('label').text()+"</label><br />\n";
					alive = "y";
				} else {
					radio += '<label><input type="radio" name="keni_primary_category_post" value="'+$(this).val()+'">'+$(this).parent('label').text()+"</label><br />\n";
				}
			})
		}
		return radio;
	}
})(jQuery);