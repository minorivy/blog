<?php if ( ! ( is_front_page() && ! is_paged() ) ) : ?>
<!--▼▼ パン屑リスト ▼▼-->
<div class="keni-breadcrumb-list_wrap">
	<div class="keni-breadcrumb-list_outer">
<?php the_keni_breadcrumbs(); ?>
	</div><!--keni-breadcrumb-list_outer-->
</div><!--keni-breadcrumb-list_wrap-->
<!--▲▲ パン屑リスト ▲▲-->
<?php endif; ?>