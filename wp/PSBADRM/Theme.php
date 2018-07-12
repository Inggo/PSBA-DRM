<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\PSBAManila\Theme as BaseTheme;

class Theme extends BaseTheme
{
    public function __construct()
    {
        add_filter('Inggo\WordPress\Filters\ThemeCustomizerClass', function ($class) {
            return ThemeCustomizer::class;
        }, 20);

        add_filter('theme_page_templates', [$this, 'removeUnusableTemplates']);
    }

    public function removeUnusableTemplates($templates)
    {
        unset($templates['templates/portal-page.php']);
        return $templates;
    }

    public function registerScriptStyles()
    {
        parent::registerScriptStyles();

        wp_register_style('google-webfonts-drm', 'https://fonts.googleapis.com/css?family=Merriweather:900', [], '');
    }

    public function enqueueStyles()
    {
        parent::enqueueStyles();

        wp_enqueue_style('psba-drm', get_stylesheet_directory_uri() . '/style.css', ['google-webfonts-drm', 'main_css'], $this->version);
    }
}
