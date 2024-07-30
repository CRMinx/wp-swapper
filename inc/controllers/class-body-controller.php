<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Body;
use DOMDocument;

/**
* Class for interacting with the Body Model
*
* @since 0.0.1
*/
class Body_Controller extends Controller {

    /**
    * The component name
    * Used in HTTP Headers and cache.
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName = 'Body';

    /**
    * Instantiate the model
    *
    * @since 0.0.1
    *
    * @param string $content the buffer
    *
    * @return Body object
    */
    protected function createModel($content) {
        return new Body($content);
    }

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string the body component
    */
    protected function view() {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->model->getContent(), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $body = $dom->getElementsByTagName('body')->item(0);

        if ($body) {
            $attributes = '';
            foreach ($body->attributes as $attribute) {
                $attributes .= $attribute->name . '="' . $attribute->value . '" ';
            }

            return '<div style="display: none;" id="changed-body"><div ' . trim($attributes) . '></div></div>';
        }

        return '';
    }
}
