<?php

namespace WP_Swapper\Controllers;

abstract class Controller {

    protected $content;

    protected $model;

    protected $componentName;

    protected $should_render = false;

    public function __construct($content) {
        $this->content = $content;
        $this->model = $this->createModel($content);

        if ($this->componentChanged()) {
            $this->cacheComponent();
            $this->createHeader();
            $this->should_render = true;
        }
    }

    abstract protected function createModel($content);

    abstract protected function view();

    private function componentChanged() {
        return $this->model->hasComponentChanged(
            $this->componentName,
            $this->model->getContent(),
        );
    }

    private function createHeader() {
        header('X-Component-Changed-' . $this->componentName . ': true');
    }

    private function cacheComponent() {
        $this->model->cacheComponent(
            $this->componentName,
            $this->model->getContent(),
        );
    }

    public function render() {
        if ($this->should_render) {
            return $this->view();
        }

        return '';
    }
}
