<?php

namespace WP_Swapper\Components;

use WP_Swapper\Traits\CacheHandlerTrait;
use DOMDocument;

/**
* Class to handle footer component
*
* @since 0.1
*/

class FooterComponent {

    use CacheHandlerTrait;

    /**
    * Buffer content
    *
    * @since 0.1
    *
    * @var string
    */
    private $content;

    /**
    * Constructor
    *
    * @since 0.1
    *
    * @param string $html
    */
    public function __construct($html) {
        $this->content = $this->extractFooterContent($html);
    }

    /**
     *  Extract the content between the <footer> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <footer> tag of the document.
     */
    private function extractFooterContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $footer = $dom->getElementsByTagName('footer')->item(0);
        return $footer ? $dom->saveHTML($footer) : '';
    }

    /**
    * Get the extracted footer content
    *
    * @since 0.1
    *
    * @returns string
    */
    public function getContent() {
        return $this->content;
    }

    protected function normalizeContent($content) {
        // Remove extra whitespace, newlines, and tabs
        $normalizedContent = preg_replace('/\s+/', ' ', trim($content));

        // Strip all HTML attributes
        $normalizedContent = preg_replace('/<(\w+)([^>]*?)>/', '<$1>', $normalizedContent);

        return $normalizedContent;
    }
}
