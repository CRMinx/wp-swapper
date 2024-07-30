<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Head;

/**
* Class for interacting with the Head Model
*
* @since 0.0.1
*/
class Head_Controller extends Controller {

    /**
    * The component name
    * Used in HTTP Headers and cache.
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName = 'Head';

    /**
    * Instantiate the model
    *
    * @since 0.0.1
    *
    * @param string $content the buffer
    *
    * @return Head object
    */
    protected function createModel($content) {
        return new Head($content);
    }

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string the head component
    */
    protected function view() {
        $head = preg_replace('/^<head>|<\/head>$/', '', $this->model->getContent());

        if ($head) {
            return '<div style="display: none;" id="changed-head">' . $head . '</div>';
        }

        return '';
    }
}
