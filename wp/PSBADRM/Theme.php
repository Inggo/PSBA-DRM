<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\Theme as BaseTheme;

class Theme extends BaseTheme
{
    public function __construct()
    {
        parent::__construct('psba-drm', new ThemeCustomizer);
    }

    public function registerScriptStyles()
    {
        parent::registerScriptStyles();

        wp_register_style('google-webfonts-drm', 'https://fonts.googleapis.com/css?family=Merriweather:900', [], '');
    }

    public function enqueueStyles()
    {
        wp_enqueue_style('psba-drm', get_stylesheet_directory_uri() . '/style.css', ['google-webfonts-drm', 'main_css'], $this->version);
    }
}
