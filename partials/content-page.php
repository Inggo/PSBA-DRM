<?php
global $post;
?>
<article>
    <?php if (get_post_meta($post->ID, '_wp_page_template', true) != 'templates/multi-content.php'): ?>
    <h2><?php the_title(); ?></h2>
    <section class="text-justify page-contents">
        <?php the_content(); ?>
    </section>
    <?php else: ?>
    <section class="page-contents multi-content">
        <?php the_content(); ?>
    </section>
    <?php endif; ?>
</article>
