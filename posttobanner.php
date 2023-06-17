<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://oswaldocavalcante.com
 * @since             1.0.0
 * @package           Posttobanner
 *
 * @wordpress-plugin
 * Plugin Name:       Post to Banner
 * Plugin URI:        https://github.com/oswaldocavalcante/posttobanner
 * Description:       Create a image banners from WordPress posts to share on social media.
 * Version:           1.0.0
 * Author:            Oswaldo Cavalcante
 * Author URI:        https://oswaldocavalcante.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       posttobanner
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'POSTTOBANNER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-posttobanner-activator.php
 */
function activate_posttobanner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-posttobanner-activator.php';
	Posttobanner_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-posttobanner-deactivator.php
 */
function deactivate_posttobanner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-posttobanner-deactivator.php';
	Posttobanner_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_posttobanner' );
register_deactivation_hook( __FILE__, 'deactivate_posttobanner' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-posttobanner.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_posttobanner() {

	$plugin = new Posttobanner();
	$plugin->run();

}
run_posttobanner();
