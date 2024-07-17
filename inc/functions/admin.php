<?php
/**
* Link to the admin panel of the plugin, support & documentation
*
* @since 0.1
*/
function swapper_settings_action_links( $actions ) {

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'https://wpswapper.com/support', __( 'Support', 'swapper' ) ) );

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'https://wpswapper.com/documentation', __( 'Docs', 'swapper' ) ) );

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'https://wpswapper.com/faq', __( 'FAQ', 'swapper' ) ) );

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', admin_url('admin.php?page=wp_swapper'), __( 'Dashboard', 'swapper' ) ) );

	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( WP_SWAPPER_FILE ), 'swapper_settings_action_links' );

/**
* Add WP Swapper link to admin menu
*
* @since 0.1
*/
function wp_swapper_add_admin_menu() {
    add_menu_page(
        'WP Swapper Settings',
        'WP Swapper',
        'manage_options',
        'wp_swapper',
        'wp_swapper_settings_page'
    );
}
add_action('admin_menu', 'wp_swapper_add_admin_menu');

/**
* Set the wp swapper admin page
*
* @since 0.1
*/
function wp_swapper_settings_page() {
    require WP_SWAPPER_VIEWS_PATH . 'main-layout.php';
}

require WP_SWAPPER_ADMIN_UI_PATH . 'enqueue.php';
