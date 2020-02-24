<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://getbot.ninja
 * @since             1.0.0
 * @package           Twilio Voice Test
 *
 * @wordpress-plugin
 * Plugin Name:       BotNinja Twilio
 * Plugin URI:        http://getbot.ninja/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            BotNinja
 * Author URI:        http://getbot.ninja/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
 

define('PLUGIN_NAME_VERSION', '1.0.0');

global $plugin_base;

$plugin_base = plugin_basename(__FILE__);


require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use App\system\bootstrap\Boot;

Boot::init();





