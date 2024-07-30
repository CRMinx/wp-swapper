<?php

namespace WP_Swapper\Models;

use DOMDocument;

/**
* Class to handle footer model
*
* @since 0.1
*/
class Footer extends Model {
    /**
     *  Extract the content between the <footer> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <footer> tag of the document.
     */
    protected function extractContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $footer = $dom->getElementsByTagName('footer')->item(0);
        return $footer ? $dom->saveHTML($footer) : '';
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

        // Strip all HTML attributes
        $normalizedContent = preg_replace('/<(\w+)([^>]*?)>/', '<$1>', $normalizedContent);

        return $normalizedContent;
    }
}