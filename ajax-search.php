<?php
/*
Plugin Name: Ajax Search
Description: A plugin to search products with Ajax.
Version: 1.1
Author: Soroush Paknezhad
*/

defined('ABSPATH') || exit;

// Define constants
define('AJAX_SEARCH_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AJAX_SEARCH_PLUGIN_URL', plugin_dir_url(__FILE__));

// Enqueue assets
function ajax_search_enqueue_assets() {
    wp_enqueue_style('ajax-search-style', AJAX_SEARCH_PLUGIN_URL . 'assets/css/style.css');
    wp_enqueue_script('ajax-search-script', AJAX_SEARCH_PLUGIN_URL . 'assets/js/script.js', ['jquery'], null, true);

    wp_localize_script('ajax-search-script', 'ajaxSearch', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'ajax_search_enqueue_assets');

// Include necessary files
require_once AJAX_SEARCH_PLUGIN_DIR . 'includes/ajax-search-handler.php';

// Register shortcode
function ajax_search_shortcode() {
    ob_start();
    include AJAX_SEARCH_PLUGIN_DIR . 'templates/search-form.php';
    return ob_get_clean();
}
add_shortcode('ajax_search', 'ajax_search_shortcode');
