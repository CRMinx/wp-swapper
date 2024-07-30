<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Footer;
use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

class Footer_Controller extends Controller {

    use Dom_Handler;

    protected $componentName = 'Footer';

    protected function createModel($content) {
        return new Footer($content);
    }

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
