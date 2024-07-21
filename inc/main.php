<?php

defined( 'ABSPATH' ) || exit;

// Composer autoload.
if ( file_exists( WP_SWAPPER_PATH . 'vendor/autoload.php' ) ) {
    require WP_SWAPPER_PATH . 'vendor/autoload.php';
}

require WP_SWAPPER_FUNCTIONS_PATH . 'inject.php';
require WP_SWAPPER_FUNCTIONS_PATH . 'admin.php';

//require_once WP_SWAPPER_INC_PATH . 'Dependencies' . DIRECTORY_SEPARATOR . 'ActionScheduler' . DIRECTORY_SEPARATOR . 'action-scheduler.php';

/**
* Tell WP what to do when plugin is loaded.
*
* @since 0.1
*/
function swapper_init() {
    // Nothing to do if autosave.
    if ( defined( 'DOING_AUTOSAVE' ) ) {
        return;
    }

    /**
    * Fires when WP Swapper starts to load.
    */
    do_action( 'wp_swapper_before_load' );

    // Call defines and funcitons.
    require WP_SWAPPER_FUNCTIONS_PATH . 'options.php';

    // Last constants.
    define( 'WP_SWAPPER_PLUGIN_NAME', 'WP Swapper' );
    define( 'WP_SWAPPER_PLUGIN_SLUG', sanitize_key( WP_SWAPPER_PLUGIN_NAME ) );
}
