<?php

namespace WP_Swapper;

use WP_Swapper\BotDetector;

/**
* Class to instantiate HTMX attributes
*
* @since 0.0.1
*/
class HtmxHandler {
    /**
    * Bot detector instance
    *
    * @since 0.0.1
    *
    * @var BotDetector
    */
    private $bot_detector;

    /**
    * Constructor
    *
    * @since 0.0.1
    *
    * @param BotDetector $bot_detector
    */
    public function __construct(BotDetector $bot_detector) {
        $this->bot_detector = $bot_detector;
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
        if ($this->bot_detector->is_bot()) {
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
