<?php

namespace WP_Swapper\Components;

use WP_Swapper\Traits\CacheHandlerTrait;

/**
* Class for handling Components
*
* @since 0.0.1
*/
abstract class Component {

    use CacheHandlerTrait;

    /**
    * Buffer content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $content;

    /**
    * Constructor
    *
    * @since 0.0.1
    *
    * @param string $html
    */
    public function __construct($html) {
        $this->content = $this->extractContent($html);
    }

    /**
    * Extract the content for the specific component
    *
    * @since 0.0.1
    *
    * @param string $html
    * @return string extracted content
    */
    abstract protected function extractContent($html);

    /**
    * Get the extracted content
    *
    * @since 0.0.1
    *
    * @return string
    */
    public function getContent() {
        return $this->content;
    }

    /**
    * Normalize Content for comparison
    *
    * @since 0.0.1
    *
    * @param string $content
    * @return string normalized content
    */
    abstract protected function normalizeContent($content);
}
