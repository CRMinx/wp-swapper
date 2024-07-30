<?php

namespace WP_Swapper\Handlers;

/**
* Class to enqueue scripts and styles
*
* @since 0.0.1
*/
class Enqueue_Handler {
    /**
    * Constructor
    *
    * @since 0.0.1
    */
    public function __construct() {
        /**
        * Load Class.
        */
        $this->setup_hooks();
    }

    /**
     * Add Actions
     *
     * @since 0.0.1
     *
     * @returns void
     */
    protected function setup_hooks() {
        add_action('wp_enqueue_scripts', [$this, 'register_styles']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    }

    /**
     * Register Styles
     *
     * @since 0.0.1
     *
     * @returns void
     */
    public function register_styles() {
        wp_register_style(
            'swapper_loader_style',
            esc_url(WP_SWAPPER_ASSETS_CSS_URL . 'loader.css'),
            null,
            WP_SWAPPER_VERSION
        );

        wp_enqueue_style('swapper_loader_style');
    }

    /**
    * Register Scripts
    *
    * @since 0.0.1
    *
    * @returns void
    */
    public function register_scripts() {
        wp_register_script(
            'htmx',
            'https://unpkg.com/htmx.org@2.0.1',
            [],
            '2.0.1',
        );
        wp_register_script(
            'swapper_script',
            esc_url(WP_SWAPPER_ASSETS_JS_URL . 'swapper-script.js'),
            ['htmx'],
            WP_SWAPPER_VERSION,
        );

        wp_enqueue_script('htmx');
        wp_enqueue_script('swapper_script');
    }
}
