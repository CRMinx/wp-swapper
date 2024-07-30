<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Header;
use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

class Header_Controller extends Controller {

    use Dom_Handler;

    protected $componentName = 'Header';

    protected function createModel($content) {
        return new Header($content);
    }

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
