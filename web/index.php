<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();

header(
	join('', ['Location: ', getenv('WP_SITEURL')]),
	true, 302
);
exit;
