		<header id="masthead" class="keni-header keni-header_col2">
			<div class="keni-header_inner">

			<?php
			if ( is_front_page() && is_home() || is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo keni_logo(); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo keni_logo(); ?></a></p>
			<?php
			endif; ?>

			<div class="keni-header_cont">
			<?php
            $header_cont = "";
			if ( get_option( 'keni_header_content' ) ) {
				$header_cont .= get_option( 'keni_header_content' );
			} else {
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) :
					$header_cont .= '<p class="site-description">' . $description . '</p>';
				endif;
			}
			$header_cont = apply_filters( 'keni_header_cont', $header_cont );
			echo $header_cont;
			?>
			</div>

			</div><!--keni-header_inner-->
		</header><!--keni-header-->
