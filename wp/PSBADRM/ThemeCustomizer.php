<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\PSBAManila\ThemeCustomizer as BaseCustomizer;

use WP_Customize_Manager;

class ThemeCustomizer extends BaseCustomizer
{
    public function __construct($slug = 'psba-drm')
    {
        parent::__construct('psba-drm');
    }

    public function register(WP_Customize_Manager $manager)
    {
        parent::register($manager);

        $this->initializeConceptPaper();
    }

    private function initializeConceptPaper()
    {
        $this->ch->addSection($this->slug . '_concept_paper', 'Concept Paper');
        $this->ch->addControl('concept_paper_label', $this->slug . '_concept_paper', 'Label');
        $this->ch->addFileControl('concept_paper_file', $this->slug . '_concept_paper', 'File');
    }

    public function initializeSiteHeader()
    {
        parent::initializeSiteHeader();

        $this->ch->addControl('header_subtitle', $this->slug . '_site_header', 'Subtitle');
        $this->ch->addImageControl('header_secondary_logo', $this->slug . '_site_header', 'Secondary Logo');
        $this->ch->addImageControl('header_background', $this->slug . '_site_header', 'Header Background');
    }
}
