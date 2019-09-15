<?php
/**
 * keni child theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package keni
 */

$dirs = [
	'core/posts/*.php',
	'core/queues/*.php',
	'core/user/*.php',
	'core/widgets/*.php',
];

foreach($dirs as $dir)
{
	foreach(glob(__DIR__.'/'.$dir, GLOB_BRACE) as $file)
	{
		require $file;
	}
}
