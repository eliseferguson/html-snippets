<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.saturdaynightbattleship.com
 * @since             1.0.0
 * @package           Html_Snippets
 *
 * @wordpress-plugin
 * Plugin Name:       HTML Snippets
 * Plugin URI:        https://github.com/eliseferguson/html-snippets
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Elise Ferguson
 * Author URI:        http://www.saturdaynightbattleship.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       html-snippets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-html-snippets-activator.php
 */
function activate_html_snippets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-html-snippets-activator.php';
	Html_Snippets_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-html-snippets-deactivator.php
 */
function deactivate_html_snippets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-html-snippets-deactivator.php';
	Html_Snippets_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_html_snippets' );
register_deactivation_hook( __FILE__, 'deactivate_html_snippets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-html-snippets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_html_snippets() {

	$plugin = new Html_Snippets();
	$plugin->run();

}
run_html_snippets();
