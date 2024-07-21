<?php
defined('ABSPATH') || exit;

/**
* Class to handle widget component
*
* @since 0.1
*/
class WidgetComponent {
    /**
    * Buffer content
    *
    * @since 0.1
    *
    * @var array
    */
    private $content = [];

    /**
    * Constructor
    *
    * @since 0.1
    *
    * @param string $html
    */
    public function __construct() {
        $this->content = $this->captureWidgetAreas();
    }

    /**
    * Capture the content of registered widget areas
    *
    * @since 0.1
    *
    * @returns array Array of widget area contents.
    */
    private function captureWidgetAreas() {
        global $wp_registered_sidebars;
        $widgetAreas = [];

        if (count($wp_registered_sidebars) > 0) {
            foreach ($wp_registered_sidebars as $sidebar) {
                ob_start();
                $result = dynamic_sidebar($sidebar['id']);
                $output = ob_get_clean();

                if ($result) {
                    $widgetAreas[$sidebar['id']] = $output;
                } else {
                    $sidgetAreas[$sidebar['id']] = '';
                }
            }
        }

        return $widgetAreas;
    }

    /**
    * Get the captured widget content
    *
    * @since 0.1
    *
    * @returns array
    */
    public function getContent() {
        return $this->content;
    }
}
