<?php
defined( 'ABSPATH' ) || exit;
/**
* Class to handle header component
*
* @since 0.1
*/

class HeaderComponent {
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
        $this->content = $this->extractHeaderContent($html);
    }

    /**
     *  Extract the content between the <header> tags
     *
     * @since 0.1
     *
     *  @param string $html
     *
     *  @returns string <header> tag of the document.
     */
    private function extractHeaderContent($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $header = $dom->getElementsByTagName('header')->item(0);
        return $header ? $dom->saveHTML($header) : '';
    }

    /**
    * Get the extracted header content
    *
    * @since 0.1
    *
    * @returns string
    */
    public function getContent() {
        return $this->content;
    }
}
