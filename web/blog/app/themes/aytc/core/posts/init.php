<?php

// Replace anchor link attrs in post content
add_filter( 'the_content', function( $string ) {
	return preg_replace_callback(
		'/<a\b([^>]*)href=(?:\'|")(.*?)(?:\'|")([^>]*)>(.*?)<\/a>/',
		function($matches) {
			$href_link = $matches[2];
			if (strpos($href_link, $_SERVER['HTTP_HOST']) === false)
			{
				$replaced_link = "<a href=\"{$href_link}\"{$matches[1]}{$matches[3]} target=\"_blank\">{$matches[4]}</a>";
			}
			else
			{
				$replaced_link = "<a href=\"{$href_link}\"{$matches[1]}{$matches[3]}>{$matches[4]}</a>";
			}
			return $replaced_link;
		}, $string
	);
}, 11, 1 );
