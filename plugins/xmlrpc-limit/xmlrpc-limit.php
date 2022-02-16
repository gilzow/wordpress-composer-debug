<?php
/**
 * XML RPC Limiter
 *
 * Plugin Name: XML RPC Limiter
 * Plugin URI:  https://platform.sh/
 * Description: Limits the ability to access the XML RPC capabilities to specific IP addresses
 * Version:     0.0.1
 * Tested up to: 5.9
 * Requires PHP: 7.4
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


function limitXMLRPC_to_ip() {
	$ipAddress = '';
	$return = false;
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ipAddress = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ipAddress = $_SERVER['REMOTE_ADDR'];
	}

	if ('216.106.73.250' == $ipAddress) {
		$return = true;
	}

	return $return;
}

add_filter('xmlrpc_methods', static function ($methods) {
	if (!limitXMLRPC_to_ip()) {
		return [];
	}

	return $methods;
});

add_filter('xmlrpc_enabled', static function ($enabled){
	if (!limitXMLRPC_to_ip()) {
		return false;
	}

	return $enabled;
});


