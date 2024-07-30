<?php

namespace WP_Swapper\Models;

use DOMDocument;

/**
* Class to handle body model
*
* @since 0.1
*/
class Body extends Model {
    /**
     *  Extract the attributes from the <body> tag
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <body> tag of the document.
     */
    protected function extractContent($html) {
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
