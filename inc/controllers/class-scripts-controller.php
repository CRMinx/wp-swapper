<?php

namespace WP_Swapper\Controllers;

use WP_Swapper\Models\Scripts;

class Scripts_Controller extends Controller {

    protected $componentName = 'Scripts';

    protected function createModel($content) {
        return new Scripts($content);
    }

    protected function view() {
        return '<div id="changed-footer-scripts" style="display: none;">' . $this->model->getContent() . '</div>';
    }
}
