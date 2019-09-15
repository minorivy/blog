<?php

// customize user profile items
/**
 * Add user profile
 * @param  array $wb
 * @return array
 */
function mnr_user_contactmethods( $wb )
{
	$wb['mnr_github'] = 'Github';
	return $wb;
}
add_filter('user_contactmethods', 'mnr_user_contactmethods', 11);
