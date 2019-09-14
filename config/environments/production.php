<?php

use Roots\WPConfig\Config;

Config::define( 'AS3CF_SETTINGS', serialize([
	'provider' => env('AS3CF_PROVIDER'),
	'access-key-id' => env('AS3CF_ACCESS_KEY'),
	'secret-access-key' => env('AS3CF_SECRET_KEY'),
]));
