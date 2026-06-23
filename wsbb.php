<?php

/**
 * Plugin Name: WSBB
 * Plugin URI: https://websweetstudio.com/
 * Description: Easily build Themer layouts for your archives, posts, 404 pages and more!
 * Version: 0.0.1
 * Author: websweetstudio
 * Author URI: https://websweetstudio.com/
 * Copyright: (c) 2016 websweetstudio
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wsbb
 * Domain Path: /languages
 * Requires PHP: 7.0
 */

if (!defined('WPINC')) {
  die;
}

define('WSBB_VERSION', '0.0.1');
define('WSBB_PLUGIN_FILE', plugin_basename(__FILE__));
define('WSBB_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('WSBB_MODULES_DIR', plugin_dir_path(__FILE__) . 'modules/');
define('WSBB_MODULES_URL', plugins_url('/modules/', __FILE__));

/**
 * Load Beaver Builder custom modules.
 */
function wsbb_load_modules()
{
  if (class_exists('FLBuilder')) {
    require_once WSBB_MODULES_DIR . 'wsbb-button/wsbb-button.php';
    require_once WSBB_MODULES_DIR . 'wsbb-gallery/wsbb-gallery.php';
    require_once WSBB_MODULES_DIR . 'wsbb-heading/wsbb-heading.php';
    require_once WSBB_MODULES_DIR . 'wsbb-html/wsbb-html.php';
    require_once WSBB_MODULES_DIR . 'wsbb-post/wsbb-post.php';
    require_once WSBB_MODULES_DIR . 'wsbb-visual-editor/wsbb-visual-editor.php';
  }
}
add_action('init', 'wsbb_load_modules');

function activate_wsbb()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-wsbb-activator.php';
  Wsbb_Activator::activate();
}

function deactivate_wsbb()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-wsbb-deactivator.php';
  Wsbb_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wsbb');
register_deactivation_hook(__FILE__, 'deactivate_wsbb');

require_once plugin_dir_path(__FILE__) . 'includes/class-wsbb.php';

function run_wsbb()
{
  $plugin = new Wsbb();
  $plugin->run();
}

run_wsbb();
