<?php

if (str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']) === '/')
{
	require dirname(__DIR__) . '/vendor/autoload.php';

	$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
	$dotenv->load();

	header(
		join('', ['Location: ', getenv('WP_SITEURL'), '/']),
		true, 302
	);
	exit;
}
else
{
	define('WP_USE_THEMES', true);
	require __DIR__ . '/blog/wp-blog-header.php';
}
