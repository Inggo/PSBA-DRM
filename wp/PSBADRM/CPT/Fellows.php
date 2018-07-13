<?php

namespace Inggo\WordPress\PSBADRM\CPT;

use Inggo\WordPress\AbstractCPT;
use Inggo\WordPress\CMB2\Filters;

class Fellows extends AbstractCPT
{   
    public $slug = 'psba-drm';

    public function register()
    {
        $labels = array(
            'name'                  => _x( 'Fellows', 'Post Type General Name', $this->slug ),
            'singular_name'         => _x( 'Fellow', 'Post Type Singular Name', $this->slug ),
            'menu_name'             => __( 'Fellows', $this->slug ),
            'name_admin_bar'        => __( 'Fellow', $this->slug ),
            'archives'              => __( '', $this->slug ),
            'attributes'            => __( 'Fellow Attributes', $this->slug ),
            'parent_item_colon'     => __( '', $this->slug ),
            'all_items'             => __( 'All Fellows', $this->slug ),
            'add_new_item'          => __( 'Add New Fellow', $this->slug ),
            'add_new'               => __( 'Add New', $this->slug ),
            'new_item'              => __( 'New Fellow', $this->slug ),
            'edit_item'             => __( 'Edit Fellow', $this->slug ),
            'update_item'           => __( 'Update Fellow', $this->slug ),
            'view_item'             => __( 'View Fellow', $this->slug ),
            'view_items'            => __( 'View Fellow', $this->slug ),
            'search_items'          => __( 'Search Fellow', $this->slug ),
            'not_found'             => __( 'Not found', $this->slug ),
            'not_found_in_trash'    => __( 'Not found in Trash', $this->slug ),
            'featured_image'        => __( 'Photo', $this->slug ),
            'set_featured_image'    => __( 'Set photo', $this->slug ),
            'remove_featured_image' => __( 'Remove photo', $this->slug ),
            'use_featured_image'    => __( 'Use as photo', $this->slug ),
            'insert_into_item'      => __( 'Insert into fellow', $this->slug ),
            'uploaded_to_this_item' => __( 'Uploaded to this fellow', $this->slug ),
            'items_list'            => __( 'Fellow list', $this->slug ),
            'items_list_navigation' => __( 'Fellow list navigation', $this->slug ),
            'filter_items_list'     => __( 'Filter fellow list', $this->slug ),
        );

        $args = array(
            'label'                 => __( 'Fellows', $this->slug ),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail', 'revisions', 'page-attributes'),
            'taxonomies'            => array('post_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-nametag',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'rewrite'               => false,
            'capability_type'       => 'post',
        );

        register_post_type('fellow', $args);

        add_filter('manage_fellow_posts_columns', [$this, 'applyColumns']);
        add_filter('manage_fellow_posts_custom_column', [$this, 'applyColumnContents'], 10, 2);
        add_filter('gettext', [$this, 'replacePlaceholder']);

        add_filter('cmb2_admin_init', [$this, 'addMetaBoxes'], 15);
    }

    public function applyColumns($posts_columns)
    {
        $posts_columns = [
            'cb' => '<input type="checkbox" />',
            'title' => 'Title',
            'featured_image' => 'Photo',
            'menu_order' => 'Order',
            'tags' => 'Tags',
            'date' => 'Date',
        ];

        return $posts_columns;
    }

    public function applyColumnContents($column_name, $post_ID)
    {
        if ($column_name === 'featured_image' && $thumb = get_the_post_thumbnail_url($post_ID)) {
            echo '<img src="' . $thumb . '" alt="" width="100px" />';
        }

        if ($column_name === 'menu_order') {
            echo get_post($post_ID)->menu_order;
        }
    }

    public function replacePlaceholder($input)
    {
        global $post_type;

        if(is_admin() && 'Enter title here' == $input && 'fellow' == $post_type) {
            return 'Enter Full Name';
        }

        return $input;
    }

    public function addMetaBoxes()
    {
        $cmb = new_cmb2_box([
            'id'            => 'fellow_metabox',
            'title'         => __('Fellow Details'),
            'object_types'  => ['fellow'],
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true
        ]);

        $cmb->add_field([
            'name' => 'Surname',
            'id'   => 'surname',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => 'First Name',
            'id'   => 'first_name',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => 'Titles',
            'id'   => 'fellow_titles',
            'description' => 'Appended to name, separate with commas (e.g., BBA, MBA, DBA, CPA)',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => 'Designation',
            'id'   => 'designation',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => 'CV / Bio',
            'id'   => 'cv_bio',
            'type' => 'wysiwyg',
            'options' => array(),
            'default' => '',
        ]);

        $cmb->add_field([
            'name' => 'Trainings',
            'id'   => 'trainings',
            'type' => 'wysiwyg',
            'options' => array(),
            'default' => '',
        ]);

        $cmb->add_field([
            'name' => 'Researches',
            'id'   => 'researches',
            'type' => 'wysiwyg',
            'options' => array(),
            'default' => '',
        ]);
    }
}
