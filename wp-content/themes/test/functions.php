<?php
wp_enqueue_style( 'all', get_template_directory_uri().'/css/all.css', $ver = false, $media = 'all' );
wp_enqueue_script( 'main.js', get_template_directory_uri().'/js/main.js', array( 'jquery'  ) );

wp_localize_script( 'load-more', 'load_more', array(
    'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
    'posts' => json_encode( $wp_query->query_vars ),
    'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
    'max_page' => $wp_query->max_num_pages,
    'nonce' => wp_create_nonce('load_more_nonce')
    ) );


function weichie_load_more() {
    $ajaxposts = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $_POST['paged'],
    ]);

    $response = '';

    if($ajaxposts->have_posts()) {
        while($ajaxposts->have_posts()) : $ajaxposts->the_post();
            $response .= get_template_part('parts/card', 'publication');
        endwhile;
    } else {
        $response = '';
    }

    echo $response;
    exit;
}
add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');