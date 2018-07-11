<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\Theme as BaseTheme;
use Inggo\WordPress\PSBAManila\ThemeCustomizer;

class Theme extends BaseTheme
{
    public function __construct()
    {
        parent::__construct('psba-drm', new ThemeCustomizer);
    }

    public function enqueueStyles()
    {
        wp_enqueue_style('psba-drm-css', get_template_directory_uri() . '/style.css', ['google-webfonts', 'google-webfonts-accent', 'bootstrap_css', 'photoswipe'], $this->version);
    }
}
