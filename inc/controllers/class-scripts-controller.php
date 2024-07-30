<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Scripts;

/**
* Class for interacting with the Scripts Model
*
* @since 0.0.1
*/
class Scripts_Controller extends Controller {

    /**
    * The component name
    * Used in HTTP Headers and cache.
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName = 'Scripts';

    /**
    * Instantiate the model
    *
    * @since 0.0.1
    *
    * @param string $content the buffer
    *
    * @return Scripts object
    */
    protected function createModel($content) {
        return new Scripts($content);
    }

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string the scripts component
    */
    protected function view() {
        return '<div id="changed-footer-scripts" style="display: none;">' . $this->model->getContent() . '</div>';
    }
}
