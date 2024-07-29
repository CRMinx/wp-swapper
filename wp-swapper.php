<?php
/**
* Plugin Name: WP Swapper
* Plugin URI: https://wpswapper.com
* Description: Increase speed by swapping content that changes instead of full page reloads.
* Version: 0.0.1
* Requires at least: 5.8
* Requires PHP: 7.3
* Author: WP Swapper
* Author URI: https://wpswapper.com
* License: GPLv2 or later
*
* Text Domain: swapper
* Domain Path: languages
*
* Copyright 2024 WP Swapper
*/

defined( 'ABSPATH' ) || exit;

session_start();

// Swapper defines.
define( 'WP_SWAPPER_VERSION',              '0.0.1' );
define( 'WP_SWAPPER_WP_VERSION',           '5.8' );
define( 'WP_SWAPPER_WP_VERSION_TESTED',    '6.5.5' );
define( 'WP_SWAPPER_PHP_VERSION',          '7.3' );
define( 'WP_SWAPPER_PRIVATE_KEY',          false );
define( 'WP_SWAPPER_SLUG',                 'wp_swapper_settings' );
define( 'WP_SWAPPER_WEB_MAIN',             'https://wpswapper.com/' );
define( 'WP_SWAPPER_WEB_API',              WP_SWAPPER_WEB_MAIN . 'api/wpswapper/' );
define( 'WP_SWAPPER_WEB_CHECK',            WP_SWAPPER_WEB_MAIN . 'check_update.php' );
define( 'WP_SWAPPER_WEB_VALID',            WP_SWAPPER_WEB_MAIN . 'valid_key.php' );
define( 'WP_SWAPPER_WEB_INFO',             WP_SWAPPER_WEB_MAIN . 'plugin_information.php' );
define( 'WP_SWAPPER_FILE',                 __FILE__ );
define( 'WP_SWAPPER_PATH',                  realpath( plugin_dir_path( WP_SWAPPER_FILE ) ) . '/' );
define( 'WP_SWAPPER_INC_PATH',              realpath( WP_SWAPPER_PATH . 'inc/' ) . '/' );
define( 'WP_SWAPPER_VIEWS_PATH',            realpath( WP_SWAPPER_PATH . 'views' ) . '/' );

require_once WP_SWAPPER_INC_PATH . 'constants.php';

define( 'WP_SWAPPER_DEPRECATED_PATH',       realpath( WP_SWAPPER_INC_PATH . 'deprecated/' ) . '/' );
define( 'WP_SWAPPER_FRONT_PATH',            realpath( WP_SWAPPER_INC_PATH . 'front/' ) . '/' );
define( 'WP_SWAPPER_ADMIN_PATH',            realpath( WP_SWAPPER_INC_PATH . 'admin' ) . '/' );
define( 'WP_SWAPPER_ADMIN_UI_PATH',         realpath( WP_SWAPPER_ADMIN_PATH . 'ui' ) . '/' );
define( 'WP_SWAPPER_ADMIN_UI_MODULES_PATH', realpath( WP_SWAPPER_ADMIN_UI_PATH . 'modules' ) . '/' );
define( 'WP_SWAPPER_COMMON_PATH',           realpath( WP_SWAPPER_INC_PATH . 'common' ) . '/' );
define( 'WP_SWAPPER_FUNCTIONS_PATH',        realpath( WP_SWAPPER_INC_PATH . 'functions' ) . '/' );
define( 'WP_SWAPPER_VENDORS_PATH',          realpath( WP_SWAPPER_INC_PATH . 'vendors' ) . '/' );
define ( 'WP_SWAPPER_CLASSES_PATH',         realpath( WP_SWAPPER_INC_PATH . 'classes' ) . '/' );
define ( 'WP_SWAPPER_COMPONENTS_PATH',      realpath( WP_SWAPPER_CLASSES_PATH . 'components' ) . '/' );
define( 'WP_SWAPPER_3RD_PARTY_PATH',        realpath( WP_SWAPPER_INC_PATH . '3rd-party' ) . '/' );
if ( ! defined( 'WP_SWAPPER_CONFIG_PATH' ) ) {
	define( 'WP_SWAPPER_CONFIG_PATH',       WP_CONTENT_DIR . '/wp-swapper-config/' );
}
define( 'WP_SWAPPER_URL',                   plugin_dir_url( WP_SWAPPER_FILE ) );
define( 'WP_SWAPPER_INC_URL',               WP_SWAPPER_URL . 'inc/' );
define( 'WP_SWAPPER_ADMIN_URL',             WP_SWAPPER_INC_URL . 'admin/' );
define( 'WP_SWAPPER_ASSETS_URL',            WP_SWAPPER_URL . 'assets/' );
define( 'WP_SWAPPER_ASSETS_PATH',            WP_SWAPPER_PATH . 'assets/' );
define( 'WP_SWAPPER_ASSETS_JS_URL',         WP_SWAPPER_ASSETS_URL . 'js/' );
define( 'WP_SWAPPER_ASSETS_JS_PATH',         WP_SWAPPER_ASSETS_PATH . 'js/' );
define( 'WP_SWAPPER_ASSETS_CSS_URL',        WP_SWAPPER_ASSETS_URL . 'css/' );
define( 'WP_SWAPPER_ASSETS_IMG_URL',        WP_SWAPPER_ASSETS_URL . 'img/' );

if ( ! defined( 'WP_SWAPPER_CACHE_ROOT_PATH' ) ) {
	define( 'WP_SWAPPER_CACHE_ROOT_PATH', WP_CONTENT_DIR . '/cache/' );
}
define( 'WP_SWAPPER_CACHE_PATH',         WP_SWAPPER_CACHE_ROOT_PATH . 'wp-swapper/' );
define( 'WP_SWAPPER_MINIFY_CACHE_PATH',  WP_SWAPPER_CACHE_ROOT_PATH . 'min/' );
define( 'WP_SWAPPER_CACHE_BUSTING_PATH', WP_SWAPPER_CACHE_ROOT_PATH . 'busting/' );
define( 'WP_SWAPPER_CRITICAL_CSS_PATH',  WP_SWAPPER_CACHE_ROOT_PATH . 'critical-css/' );

define( 'WP_SWAPPER_USED_CSS_PATH',  WP_SWAPPER_CACHE_ROOT_PATH . 'used-css/' );

if ( ! defined( 'WP_SWAPPER_CACHE_ROOT_URL' ) ) {
	define( 'WP_SWAPPER_CACHE_ROOT_URL', WP_CONTENT_URL . '/cache/' );
}
define( 'WP_SWAPPER_CACHE_URL',         WP_SWAPPER_CACHE_ROOT_URL . 'wp-swapper/' );
define( 'WP_SWAPPER_MINIFY_CACHE_URL',  WP_SWAPPER_CACHE_ROOT_URL . 'min/' );
define( 'WP_SWAPPER_CACHE_BUSTING_URL', WP_SWAPPER_CACHE_ROOT_URL . 'busting/' );

define( 'WP_SWAPPER_USED_CSS_URL', WP_SWAPPER_CACHE_ROOT_URL . 'used-css/' );

if ( ! defined( 'CHMOD_WP_SWAPPER_CACHE_DIRS' ) ) {
	define( 'CHMOD_WP_SWAPPER_CACHE_DIRS', 0755 ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
}
if ( ! defined( 'WP_SWAPPER_LASTVERSION' ) ) {
	define( 'WP_SWAPPER_LASTVERSION', '3.15.10' );
}

/**
 * We use is_readable() with @ silencing as WP_Filesystem() can use different methods to access the filesystem.
 *
 * This is more performant and more compatible. It allows us to work around file permissions and missing credentials.
 */
if ( @is_readable( WP_SWAPPER_PATH . 'licence-data.php' ) ) { //phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	@include WP_SWAPPER_PATH . 'licence-data.php'; //phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
}

require WP_SWAPPER_INC_PATH . 'compat.php';
require WP_SWAPPER_INC_PATH . 'classes/class-wp-swapper-requirements-check.php';

$wp_swapper_requirement_checks = new WP_Swapper_Requirements_Check(
	[
		'plugin_name'         => 'WP Swapper',
		'plugin_file'         => WP_SWAPPER_FILE,
		'plugin_version'      => WP_SWAPPER_VERSION,
		'plugin_last_version' => WP_SWAPPER_LASTVERSION,
		'wp_version'          => WP_SWAPPER_WP_VERSION,
		'php_version'         => WP_SWAPPER_PHP_VERSION,
	]
);

if ( $wp_swapper_requirement_checks->check() ) {
    require WP_SWAPPER_INC_PATH . 'main.php';
}

unset( $wp_swapper_requirement_checks );
