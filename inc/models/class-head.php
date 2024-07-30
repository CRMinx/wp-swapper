<?php

namespace WP_Swapper\Models;

use DOMDocument;

/**
* Class to handle head model
*
* @since 0.1
*/
class Head extends Model {
    /**
     *  Extract the content between the <head> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <head> tag of the document.
     */
    protected function extractContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $head = $dom->getElementsByTagName('head')->item(0);
        return $head ? $dom->saveHTML($head) : '';
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
