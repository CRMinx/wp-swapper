<?php

namespace WP_Swapper\Models;

use WP_Swapper\Traits\Cache_Handler;

/**
* Abstract class for interacting with models
*
* @since 0.0.1
*/
abstract class Model
{
    use Cache_Handler;

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
    * Extract the content for the specific model
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
