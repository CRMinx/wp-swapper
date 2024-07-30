<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Header;
use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

/**
* Class for interacting with the Header Model
*
* @since 0.0.1
*/
class Header_Controller extends Controller {

    use Dom_Handler;

    /**
    * The component name
    * Used in HTTP Headers and cache.
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName = 'Header';

    /**
    * Instantiate the model
    *
    * @since 0.0.1
    *
    * @param string $content the buffer
    *
    * @return Header object
    */
    protected function createModel($content) {
        return new Header($content);
    }

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string the header component
    */
    protected function view() {
        $dom_header = new DOMDocument();
        @$dom_header->loadHTML($this->model->getContent(), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->swap_links($dom_header);

        $header = $dom_header->saveHTML();
        if ($header) {
            return '<div id="changed-header" style="display: none;">' . $header . '</div>';
        }

        return '';
    }
}
