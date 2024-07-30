<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Body;
use DOMDocument;

class Body_Controller extends Controller {

    protected $componentName = 'Body';

    protected function createModel($content) {
        return new Body($content);
    }

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
