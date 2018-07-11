<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\PSBAManila\ThemeCustomizer as BaseCustomizer;

use WP_Customize_Manager;

class ThemeCustomizer extends BaseCustomizer
{
    public function __construct($slug = 'psba-manila')
    {
        parent::__construct('psba-drm');
    }

    public function initializeSiteHeader()
    {
        parent::initializeSiteHeader();

        $this->ch->addControl('header_subtitle', $this->slug . '_site_header', 'Subtitle');
        $this->ch->addImageControl('header_secondary_logo', $this->slug . '_site_header', 'Secondary Logo');
        $this->ch->addImageControl('header_background', $this->slug . '_site_header', 'Header Background');
    }
}
