<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\PSBAManila\Admin as BaseAdmin;

class Admin extends BaseAdmin
{
    public function __construct()
    {
        parent::__construct('psba-drm');
    }

    public function init()
    {
        parent::init();
    }

    protected function overrideMultiPageContents($post)
    {
        $contents = get_post_meta($post->ID, 'multi_page_contents', true);

        // Clear post content
        $post->post_content = "";

        // Append caption and CTA to post content as cards
        foreach ($contents as $index => $content) {
            $post->post_content .= "<h2>" . $content['title'] . "</h2>\n";
            $post->post_content .= $content['content'];
        }

        remove_action('save_post', [$this, 'overridePageContents']);

        wp_update_post($post);

        add_action('save_post', [$this, 'overridePageContents'], 10, 3);
    }
}
