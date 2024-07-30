<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Footer;
use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

/**
* Class for interacting with the Footer Model
*
* @since 0.0.1
*/
class Footer_Controller extends Controller {

    use Dom_Handler;

    /**
    * The component name
    * Used in HTTP Headers and cache.
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName = 'Footer';

    /**
    * Instantiate the model
    *
    * @since 0.0.1
    *
    * @param string $content the buffer
    *
    * @return Footer object
    */
    protected function createModel($content) {
        return new Footer($content);
    }

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string the footer component
    */
    protected function view() {
        $dom_footer = new DOMDocument();
        @$dom_footer->loadHTML($this->model->getContent(), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->swap_links($dom_footer);

        $footer = $dom_footer->saveHTML();
        if ($footer) {
            return '<div id="changed-footer" style="display: none;">' . $footer . '</div>';
        }

        return '';
    }
}
