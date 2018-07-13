<?php

/**
 * Template Name: Fellowship Page
 *
 * @package WordPress
 * @subpackage psba-drm
 */

global $theme;
global $post;

get_header();

if (have_posts()) :
while (have_posts()) :
    the_post();

    $theme->setCurrentPost($post);

    if ($post->post_parent):
        $post = get_post($post->post_parent);
        setup_postdata($post);

        get_template_part('partials/page', 'parent');
        wp_reset_postdata();
    else: ?>
<section class="container">
    <div class="row justify-content-md-center">
        <div class="col">
            <?php get_template_part('partials/content', 'page'); ?>
        </div>
    </div>
</section>
<?php
    endif;
endwhile;
endif;

get_footer();
