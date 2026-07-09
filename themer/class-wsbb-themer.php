<?php

/**
 * WSBB Themer - Bootstrap.
 *
 * @since 1.0
 */
final class Wsbb_Themer
{

  /**
   * Initialize themer functionality.
   *
   * @since 1.0
   * @return void
   */
  static public function init()
  {
    if (! class_exists('FLBuilder')) {
      return;
    }

    self::define_constants();
    self::load_files();
  }

  /**
   * Define themer constants.
   *
   * @since 1.0
   * @access private
   * @return void
   */
  static private function define_constants()
  {
    define('WSBB_THEMER_DIR', WSBB_PLUGIN_DIR . 'themer/');
    define('WSBB_THEMER_URL', WSBB_PLUGIN_DIR_URL . 'themer/');
  }

  /**
   * Load classes and includes.
   *
   * @since 1.0
   * @access private
   * @return void
   */
  static private function load_files()
  {
    require_once WSBB_THEMER_DIR . 'class-wsbb-themer-cpt.php';
    require_once WSBB_THEMER_DIR . 'class-wsbb-themer-rules.php';
    require_once WSBB_THEMER_DIR . 'class-wsbb-themer-renderer.php';

    if (is_admin()) {
      require_once WSBB_THEMER_DIR . 'class-wsbb-themer-admin.php';
    }
  }
}
