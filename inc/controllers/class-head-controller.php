<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Head;

class Head_Controller extends Controller {

    protected $componentName = 'Head';

    protected function createModel($content) {
        return new Head($content);
    }

    protected function view() {
        $head = preg_replace('/^<head>|<\/head>$/', '', $this->model->getContent());

        if ($head) {
            return '<div style="display: none;" id="changed-head">' . $head . '</div>';
        }

        return '';
    }
}
