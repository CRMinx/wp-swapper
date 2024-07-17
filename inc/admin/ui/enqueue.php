<?php

defined( 'ABSPATH' ) || exit;

/**
* Add the CSS and JS files for WP Swapper admin panel
*
* @since 0.1
*/
function swapper_add_admin_css_js() {
    wp_enqueue_style('swapper_admin_style', WP_SWAPPER_ASSETS_CSS_URL . 'style.css', null, WP_SWAPPER_VERSION);
    wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', [], null, true);
}
add_action('admin_enqueue_scripts', 'swapper_add_admin_css_js');
