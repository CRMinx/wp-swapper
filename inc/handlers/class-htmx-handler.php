<?php

namespace WP_Swapper\Handlers;

use WP_Swapper\Traits\Bot_Handler;

/**
* Class to instantiate HTMX attributes
*
* @since 0.0.1
*/
class Htmx_Handler {

    use Bot_Handler;

    /**
    * Constructor
    *
    * @since 0.0.1
    */
    public function __construct() {
        add_filter('body_class', [$this, 'add_htmx_attributes_to_body'], 20, 2);
    }

    /**
    * Adds custom HTMX attributes to the body class filter
    *
    * @since 0.0.1
    *
    * @param array $classes Array of body classes.
    *
    * @return array Modified array of body attributes.
    */
    public function add_htmx_attributes_to_body($classes) {
        if ($this->is_bot()) {
            return $classes;
        }

        $attributes = array(
            'hx-indicator="#swapper-loader"',
            'hx-target="#swapper-site-content"',
            'hx-swap="innerHTML show:window:top"'
        );

        echo ' ' . implode(' ', $attributes);
        return $classes;
    }
}
