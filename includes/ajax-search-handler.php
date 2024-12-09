<?php
defined('ABSPATH') || exit;

function ajax_search_products_handler() {
    if (!isset($_POST['term'])) {
        wp_die();
    }

    global $wpdb;

    $term = sanitize_text_field($_POST['term']);

    // Modify the WP_Query where clause
    add_filter('posts_where', function ($where) use ($term, $wpdb) {
        $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($term) . '%');
        return $where;
    });

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    $query = new WP_Query($args);

    // Reset the filter after query
    remove_filter('posts_where', '__return_empty_string');

    if ($query->have_posts()) {
        echo '<div class="res-container">';
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail = get_the_post_thumbnail(get_the_ID(), [64, 64], ['alt' => get_the_title()]);
            $product = wc_get_product(get_the_ID());

            echo '<div class="result-item">';
            echo '<a class="sa-result-container" href="' . get_the_permalink() . '">';
            echo '<div class="result-item">' . $thumbnail . '</div>';
            echo '<div class="sa-product-info">';
            echo '<span class="sa-text-title">' . get_the_title() . '</span>';
            if ($product) {
                echo '<span class="sa-text-title">' . $product->get_price() . ' تومان</span>';
            }
            echo '</div></a></div>';
        }
        echo '</div>';
    } else {
        echo 'محصولی یافت نشد.';
    }

    wp_die();
}
add_action('wp_ajax_ajax_search_products', 'ajax_search_products_handler');
add_action('wp_ajax_nopriv_ajax_search_products', 'ajax_search_products_handler');
