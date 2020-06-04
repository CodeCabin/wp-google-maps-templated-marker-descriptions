<?php
/*
Plugin Name: WP Google Maps - Templated Marker Descriptions
Plugin Author: WP Google Maps - Perry Rylance
Description: Implements HTML templating for marker descriptions, use the name and data-name attributes to dynamically populate marker descriptions, use parentheses in attributes to do the same
Version: 1.0
*/

namespace WPGMZA;

add_action('init', function() {
	
	require_once(plugin_dir_path(__FILE__) . 'class.custom-marker.php');
	
});