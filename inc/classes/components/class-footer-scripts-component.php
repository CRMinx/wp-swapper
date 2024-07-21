<?php

namespace WP_Swapper\Components;

use WP_Swapper\Traits\CacheHandlerTrait;
use DOMDocument;

/**
* Class to handle footer scripts component
*
* @since 0.1
*/

class FooterScriptsComponent {

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
        $this->content = $this->extractFooterScriptsContent($html);
    }

    /**
     *  Extract the content between the footer <script> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string footer <script> tags of the document.
     */
    private function extractFooterScriptsContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $scriptContent = '';

        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            if ($script->parentNode->tagName === 'body') {
                $scriptContent .= $dom->saveHTML($script);
            }
        }

        return $scriptContent;
    }

    /**
    * Get the extracted footer script content
    *
    * @since 0.1
    *
    * @returns string
    */
    public function getContent() {
        return $this->content;
    }

    /**
    * Remove white space and html attributes from footer
    *
    * @since 0.1
    *
    * @returns string
    */
    protected function normalizeContent($content) {
        // Remove extra whitespace, newlines, and tabs
        $normalizedContent = preg_replace('/\s+/', ' ', trim($content));

        return $normalizedContent;
    }
}
