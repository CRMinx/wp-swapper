<?php
defined( 'ABSPATH' ) || exit;
/**
* Class to handle head component
*
* @since 0.1
*/

class HeadComponent {
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
}
