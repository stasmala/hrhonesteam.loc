<?php global $wp_query;?>
<?php get_header(); ?>

<div id="main">
    <?php
    $publications = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1,
    ]);
    ?>

    <?php if($publications->have_posts()): ?>
        <ul class="publication-list">
            <?php
            while ($publications->have_posts()): $publications->the_post();
                get_template_part('parts/card', 'publication');
            endwhile;
            ?>
        </ul>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <div class="btn__wrapper">
        <button class="btn btn__primary" id="load-more">Load more</button>
    </div>
</div>

<?php get_footer(); ?>
