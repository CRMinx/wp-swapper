<?php

namespace WP_Swapper\Components;

use WP_Swapper\Traits\CacheHandlerTrait;
use DOMDocument;

/**
* Class to handle body component
*
* @since 0.1
*/
class BodyComponent {

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
        $this->content = $this->extractBodyContent($html);
    }

    /**
     *  Extract the content between the <header> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <body> tag of the document.
     */
    private function extractBodyContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $body = $dom->getElementsByTagName('body')->item(0);

        if ($body) {
            $bodyContent = '<body';

            foreach ($body->attributes as $attribute) {
                $bodyContent .= ' ' . $attribute->name . '="' . $attribute->value . '"';
            }

            $bodyContent .= '>';
            return $bodyContent;
        }

        return '';
    }

    /**
    * Get the extracted body content
    *
    * @since 0.1
    *
    * @returns string
    */
    public function getContent() {
        return $this->content;
    }

    /**
    * Remove white space and html attributes from header
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
