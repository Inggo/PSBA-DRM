<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\Traits\UsesBootstrapModals;
use Inggo\WordPress\PSBAManila\Admin as BaseAdmin;

class Admin extends BaseAdmin
{
    use UsesBootstrapModals;

    public function __construct()
    {
        parent::__construct('psba-drm');
    }

    public function init()
    {
        parent::init();
    }

    public function addMetaBoxes()
    {
        parent::addMetaBoxes();
        $this->addFellowshipPageMetaboxes();
    }

    public function createDefaultCategories()
    {
        parent::createDefaultCategories();

        wp_insert_term('Research Fellow', 'post_tag');
        wp_insert_term('MBA-DRM', 'post_tag');
        wp_insert_term('DBA', 'post_tag');
        wp_insert_term('International', 'post_tag');
    }

    public function addFellowshipPageMetaboxes()
    {
        $cmb = new_cmb2_box([
            'id'            => 'fellowship_page_metabox',
            'title'         => __('Fellowship Page', $this->slug),
            'object_types'  => ['page'],
            'show_on'       => ['key' => 'page-template', 'value' => 'templates/fellowship-page.php'],
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true
        ]);

        $cmb->add_field([
            'name' => 'Contents',
            'type' => 'wysiwyg',
            'id' => 'fellowship_page_content',
            'description' => 'Above content will be shown before the filtered Fellows',
            'options' => array(),
            'default' => '',
        ]);

        $cmb->add_field([
            'name' => 'Tag',
            'desc' => 'This page will show Fellows that has the tag selected above',
            'id' => 'fellowship_tag_filter',
            'taxonomy' => 'post_tag',
            'type' => 'taxonomy_select',
        ]);
    }

    public function overridePageContents($post_id, $post, $update)
    {
        parent::overridePageContents($post_id, $post, $update);
        
        $page_template = get_post_meta($post_id, '_wp_page_template', true);

        if ($page_template === 'templates/fellowship-page.php') {
            return $this->overrideFellowshipPageContents($post);
        }
    }

    protected function overrideFellowshipPageContents($post)
    {
        $terms = get_the_terms($post->ID, 'post_tag');

        // Clear post content
        $post->post_content = get_post_meta($post->ID, 'fellowship_page_content', true);

        $tax_query = [
            'taxonomy' => 'post_tag',
            'field' => 'slug',
            'terms' => array_map(function ($term) {
                return $term->slug;
            }, $terms)
        ];

        // Get fellows
        $fellows = get_posts([
            'post_type' => 'fellow',
            'tax_query' => $tax_query,
            'posts_per_page' => -1,
        ]);

        if ($fellows) {
            $post->post_content .= "\n\n";

            $post->post_content .= '<table class="table table-striped table-hover">';
            $post->post_content .= '<thead><tr>';
            $post->post_content .= '<th scope="col">Name</th>';
            $post->post_content .= '<th scope="col">Trainings</th>';
            $post->post_content .= '<th scope="col">Designation</th>';
            $post->post_content .= '</tr></thead>';
            $post->post_content .= '<tbody>';

            $post->post_content .= $this->parseFellowsToRows($fellows);

            $post->post_content .= '</tbody></table>';

            $post->post_content .= $this->parseFellowsToModals($fellows);
        }

        remove_action('save_post', [$this, 'overridePageContents'], 20);

        wp_update_post($post);

        add_action('save_post', [$this, 'overridePageContents'], 20, 3);
    }

    private function parseFellowsToRows($fellows)
    {
        $content = "";

        foreach ($fellows as $fellow) {
            $content .= '<tr>';
            $content .= '<th scope="row"><a href="javascript:;" data-toggle="modal" data-target="#fellow-modal-';
            $content .= $fellow->ID . '"><b>' . $fellow->post_title . '</b>';

            $titles = get_post_meta($fellow-ID, 'fellow_titles', true);

            if ($titles) {
                $content .= ', ' . $titles;
            }

            $content .= '</a></th><td>' . get_post_meta($fellow->ID, 'trainings', true);
            $content .= '</td><td>' . get_post_meta($fellow->ID, 'designation', true);
            $content .= '</td></tr>';
        }

        return $content;
    }

    private function parseFellowsToModals($fellows)
    {
        $content = "";

        foreach ($fellows as $fellow) {
            $contents = '';

            $bio = get_post_meta($fellow->ID, 'cv_bio', true);

            if ($bio) {
                $contents .= $bio . "\n\n";
            }

            $trainings = get_post_meta($fellow->ID, 'trainings', true);

            if ($trainings) {
                $contents .= '<h4>Trainings</h4>';
                $contents .= $trainings;
            }

            $content .= $this->parseBootstrapModal('fellow-modal-' . $fellow->ID, $fellow->post_title, $contents);
        }

        return $content;
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
