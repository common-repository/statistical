<?php
/**
 * @package Statistics
 */
/*
Plugin Name: Statistics
Plugin URI: https://sojourner.co/blog/code/jekyll-wordpress-display-content-metadata-total-word-count.html
Description: Shows useful, statistical information about the content on your blog, in a widget. Data displayed: Combined wordcount of all your published posts, Total no of published posts, Avg no of words written per post, and Days since the first post was published. Please note that all counts shown are approximations, based on some simple calculations.
Version: 1.0a
Author: sojourner.co
Author URI:  https://sojourner.co/
License: GPLv2 or later
Text Domain: statistics
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2015 Sojourner.co
*/

/*

If you're reading this, this plugin is a small test to validate a much larger
idea.

*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}



define( 'STAT__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'STAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


register_activation_hook( __FILE__, array( 'Statistics', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Statistics', 'plugin_deactivation' ) );

require_once( STAT__PLUGIN_DIR . 'class.statistics.php' );
require_once( STAT__PLUGIN_DIR . 'class.statistics-widget.php' );

add_action( 'init', array( 'Statistics', 'init' ) );

//admin code later on.
