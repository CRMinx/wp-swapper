<?php

namespace WP_Swapper\Components;

use DOMDocument;

/**
* Class to handle header component
*
* @since 0.1
*/
class HeaderComponent extends Component {
    /**
     *  Extract the content between the <header> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <header> tag of the document.
     */
    protected function extractContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $header = $dom->getElementsByTagName('header')->item(0);
        return $header ? $dom->saveHTML($header) : '';
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

        // Strip all HTML attributes
        $normalizedContent = preg_replace('/<(\w+)([^>]*?)>/', '<$1>', $normalizedContent);

        return $normalizedContent;
    }
}
