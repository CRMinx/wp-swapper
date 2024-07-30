<?php

namespace WP_Swapper\Controllers;

/**
* Abstract parent controller class
* for interacting with models
*
* @since 0.0.1
*/
abstract class Controller {

    /**
    * The buffer
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $content;

    /**
    * The model
    *
    * @since 0.0.1
    *
    * @var Model object
    */
    protected $model;

    /**
    * The component name
    * User in the http header and cache
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $componentName;

    /**
    * Should the component render?
    * Component should only render if it
    * has changed.
    *
    * @since 0.0.1
    *
    * @var bool defaults false, true if current buffer
    * is different from cache
    */
    protected $should_render = false;

    /**
    * Constructor method
    *
    * @since 0.0.1
    *
    * @param string $content The buffer
    *
    * @return void
    */
    public function __construct($content) {
        $this->content = $content;
        $this->model = $this->createModel($content);

        if ($this->componentChanged()) {
            $this->cacheComponent();
            $this->createHeader();
            $this->should_render = true;
        }
    }

    /**
    * Create the model
    *
    * @since 0.0.1
    *
    * @param string $content The buffer
    *
    * @return Model object
    */
    abstract protected function createModel($content);

    /**
    * Create the view
    *
    * @since 0.0.1
    *
    * @return string The component
    */
    abstract protected function view();

    /**
    * Compare buffer to cache
    * to see if component changed
    *
    * @since 0.0.1
    *
    * @return bool true if cache is different
    * from buffer.
    */
    private function componentChanged() {
        return $this->model->hasComponentChanged(
            $this->componentName,
            $this->model->getContent(),
        );
    }

    /**
    * Create the HTTP Header.
    * Notifies front end if component
    * has been updated.
    *
    * @since 0.0.1
    *
    * @return void
    */
    private function createHeader() {
        header('X-Component-Changed-' . $this->componentName . ': true');
    }

    /**
    * Cache the component
    *
    * @since 0.0.1
    *
    * @return void
    */
    private function cacheComponent() {
        $this->model->cacheComponent(
            $this->componentName,
            $this->model->getContent(),
        );
    }

    /**
    * Render the view.
    *
    * @since 0.0.1
    *
    * @return string The component view
    */
    public function render() {
        if ($this->should_render) {
            return $this->view();
        }

        return '';
    }
}
