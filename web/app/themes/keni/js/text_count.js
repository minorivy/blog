// カウント数を表示するエリアを管理画面に追加
jQuery.noConflict();
(function($) {
	$(function() {
		if($("#title").length && $('[name="keni_meta_description_post"]').length && $('[name="keni_another_post_title"]').length ){
			if ($("#title")[0]) {
				$("#titlewrap").after('<div class="title_count_area"><strong class="title_count">タイトル文字数：</strong><span id="title_count">'+getTitleCount()+'文字</span></div>');

				$("#title").keyup(function() {
					$("#title_count").html(getTitleCount()+'文字');
				});
			}
			var jqMetaDescPost = $('[name="keni_meta_description_post"]');
			if (jqMetaDescPost) {

				jqMetaDescPost.after('<div class="meta_description_area"><b>ディスクリプション文字数：</b><span id="meta_description_count">'+getDescriptionCount(jqMetaDescPost)+'文字</span></div>');

				jqMetaDescPost.keyup(function() {
					$('#meta_description_count').html(getDescriptionCount(this)+'文字');
				});
				
			}
			var jqAnotherPostTitle = $('[name="keni_another_post_title"]');
			if (jqAnotherPostTitle) {

				jqAnotherPostTitle.after('<div class="meta_description_area"><b>個別設定タイトル文字数：</b><span id="another_title_count">'+getAnotherTitleCount(jqAnotherPostTitle)+'文字</span></div>');

	            jqAnotherPostTitle.keyup(function() {
	                $('#another_title_count').html(getDescriptionCount(this)+'文字');
	            });
			}
		}
	});
	
	// タイトルに入っている文字数を取得
	function getTitleCount() {
		if ($("#title")[0]) return $("#title").val().length;
	}
	function getDescriptionCount(jqObj) {
		if ($(jqObj)) return $(jqObj).val().length;
	}
  function getAnotherTitleCount(jqObj) {
    if ($(jqObj)) return $(jqObj).val().length;
  }
})(jQuery);