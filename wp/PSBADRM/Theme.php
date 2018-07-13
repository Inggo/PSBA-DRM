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
        add_action('init', [$this, 'unregisterPostTypes']);

        $this->cpt_registrar[] = new CPTRegistrar;
    }

    public function unregisterPostTypes()
    {
        unregister_post_type('proceedings');
        unregister_post_type('personnel');
        unregister_post_type('curriculum');
    }

    public function removeUnusableTemplates($templates)
    {
        unset($templates['templates/portal-page.php']);
        unset($templates['templates/contact-page.php']);
        unset($templates['templates/personnel-page.php']);
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
