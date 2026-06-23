<?php

class Wsbb
{
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        $this->version = defined('WSBB_VERSION') ? WSBB_VERSION : '1.0.0';
        $this->plugin_name = 'wsbb';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wsbb-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wsbb-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wsbb-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wsbb-public.php';

        $this->loader = new Wsbb_Loader();
    }

    private function set_locale()
    {
        $plugin_i18n = new Wsbb_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new Wsbb_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    private function define_public_hooks()
    {
        $plugin_public = new Wsbb_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_loader()
    {
        return $this->loader;
    }

    public function get_version()
    {
        return $this->version;
    }
}
