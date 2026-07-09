<?php

class Wsbb_Public
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        $css_file = plugin_dir_url(__FILE__) . '../css/frontend.css';
        if (file_exists(plugin_dir_path(__FILE__) . '../css/frontend.css')) {
            wp_enqueue_style($this->plugin_name . '-frontend', $css_file, array(), $this->version);
        }
    }

    public function enqueue_scripts()
    {
        $js_file = plugin_dir_url(__FILE__) . '../js/frontend.js';
        if (file_exists(plugin_dir_path(__FILE__) . '../js/frontend.js')) {
            wp_enqueue_script($this->plugin_name . '-frontend', $js_file, array(), $this->version, true);
        }
    }
}
