<?php

namespace WP_Swapper\Tests;

use Brain\Monkey;
use Brain\Monkey\Functions;

require __DIR__ . '/../vendor/autoload.php';

Monkey\setUp();

Functions\when('plugin_dir_path')->alias(function ($file) {
    return dirname($file) . '/';
});

Functions\when('plugin_dir_url')->alias(function ($file) {
    return 'localhost' . '/';
});

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

define( 'WP_SWAPPER_URL',                   plugin_dir_url( WP_SWAPPER_FILE ) );
define( 'WP_SWAPPER_INC_URL',               WP_SWAPPER_URL . 'inc/' );
define( 'WP_SWAPPER_ADMIN_URL',             WP_SWAPPER_INC_URL . 'admin/' );
define( 'WP_SWAPPER_ASSETS_URL',            WP_SWAPPER_URL . 'assets/' );
define( 'WP_SWAPPER_ASSETS_PATH',            WP_SWAPPER_PATH . 'assets/' );
define( 'WP_SWAPPER_ASSETS_JS_URL',         WP_SWAPPER_ASSETS_URL . 'js/' );
define( 'WP_SWAPPER_ASSETS_JS_PATH',         WP_SWAPPER_ASSETS_PATH . 'js/' );
define( 'WP_SWAPPER_ASSETS_CSS_URL',        WP_SWAPPER_ASSETS_URL . 'css/' );
define( 'WP_SWAPPER_ASSETS_IMG_URL',        WP_SWAPPER_ASSETS_URL . 'img/' );
