<?php

namespace WP_Swapper\Components;

use WP_Swapper\Traits\CacheHandlerTrait;
use DOMDocument;

/**
* Class to handle head component
*
* @since 0.1
*/

class HeadComponent {

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
        $this->content = $this->extractHeadContent($html);
    }

    /**
     *  Extract the content between the <head> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <head> tag of the document.
     */
    private function extractHeadContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $head = $dom->getElementsByTagName('head')->item(0);
        return $head ? $dom->saveHTML($head) : '';
    }

    /**
    * Get the extracted head content
    *
    * @since 0.1
    *
    * @returns string
    */
    public function getContent() {
        return $this->content;
    }

    /**
    * Only compare style and script tags
    *
    * @since 0.1
    *
    * @returns string
    */
    protected function normalizeContent($content) {
        // Remove all tags except <style>, <link>, and <script>
        $content = preg_replace('/<(?!\/?(style|link|script)\b)[^>]*>/', '', $content);

        // Remove extra whitespace, newlines, and tabs
        $normalizedContent = preg_replace('/\s+/', ' ', trim($content));

        return $normalizedContent;
    }
}
